<?php
/**
 * 微信有关
 */
namespace User\Controller;

use Common\Controller\HomebaseController;

class WeixinController extends HomebaseController
{
    public $haibao_scene_pre = 'haibao_openid_';
    public $default_scene_pre = 'qrscene_';

    function get_redis_cli()
    {
        $redis = new \redis();
        $redis->connect('127.0.0.1', 6379);
        return $redis;
    }

    function get_redis_value()
    {
        $key = I('get.key');
        $redis = $this->get_redis_cli();
        $v = $redis->get($key);
        var_dump($v);
    }

    public function weixin_token()
    {
        $redis = new \redis();
        $redis->connect('127.0.0.1', 6379);
        //获得参数 signature nonce token timestamp echostr
        $nonce = $_GET['nonce'];
        $token = C('wx_token');
        $timestamp = $_GET['timestamp'];
        $echostr = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1(implode($array));
        if ($str == $signature && $echostr) {
            //第一次接入weixin api接口的时候
            echo $echostr;
            exit;
        } else {

            $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
            $postObj = simplexml_load_string($postArr);
            $this->weixin_response($postObj);

        }

    }

    // 判断用户是否扫码登录,js轮询
    function scan_status_check()
    {
        $scene_str = session('scene_str');
        if (!$scene_str) {
            echo 3;
            exit;
        }
        $key = 'scene_str_' . $scene_str;
        $redis = $this->get_redis_cli();
        $res = $redis->get($key);
        $openid_key = 'openid_' . $key;
        $openid = $redis->get($openid_key);

        if (!$openid) {
            echo 1;
            exit;
        }

        $users_model = M('Users');
        $where['openid'] = $openid;
        $result = $users_model->where($where)->find();
        //$sql = $users_model->getLastSql();

        //var_dump($scene_str,$openid_key,$openid,$where,$sql,$result);exit;

        $_SESSION["user"] = $result;
        //写入此次登录信息
        $data = array(
            'last_login_time' => date("Y-m-d H:i:s"),
            'last_login_ip' => get_client_ip(0, true),
        );
        $users_model->where(array('id' => $result["id"]))->save($data);

        echo $res;
    }


    function weixin_response($postObj)
    {
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $userinfo = $this->get_weixin_userinfo($toUser);
        $msgType = 'text';
        $EventKey = $postObj->EventKey;
        $redis = $this->get_redis_cli();
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注 subscribe 事件
            if (strtolower($postObj->Event == 'subscribe')) {

                //扫描拉新客户的二维码
                if (strpos($EventKey, $this->haibao_scene_pre)) {
                    $qrcode_openid = substr($EventKey, strlen($this->haibao_scene_pre) + strlen($this->default_scene_pre));
                    $content = "你扫描的海报 openid 是 " . $qrcode_openid;
                    $content = $this->handle_user($userinfo);
                    $this->send_kefu_msg($toUser, $content);
                    $this->haibao_activity_response($toUser, $fromUser, $qrcode_openid);

                } else {
                    //回复用户消息(纯文本格式)
                    $redis_key = "scene_str_" . ltrim($EventKey, 'qrscene_');
                    $redis->set($redis_key, 2, 3600);
                    $openid_key = 'openid_' . $redis_key;
                    $redis->set($openid_key, (string)$toUser, 3600);

                    $content = $this->handle_user($userinfo);
                    $this->weixin_response_template($toUser, $fromUser, $msgType, $content);
                }



            } else {

                // 扫描拉新客户的二维码
                if (strpos($EventKey, $this->haibao_scene_pre) === 0) {
                    $qrcode_openid = substr($EventKey, strlen($this->haibao_scene_pre));
                    $this->haibao_activity_response($toUser, $fromUser, $qrcode_openid);

                   // $this->weixin_response_template($toUser, $fromUser, $msgType, $content);
                }

                $redis_key = "scene_str_" . $EventKey;

                $redis->set($redis_key, 2, 3600);
                $openid_key = 'openid_' . $redis_key;
                $redis->set($openid_key, (string)$toUser, 3600);
                $member_charge = C('member_charge');
                $content = $userinfo['nickname'] . " ，您好，欢迎回来，<a href='http://www.leidun.site'>雷顿学院</a>  金牌会员价格只要 $member_charge ，金牌会员可终身免费观看本站所有课程,会员升级  <a href='http://www.leidun.site/user/center/up_user2.html'>http://www.leidun.site/user/center/up_user2.html</a>";
                //$content = $EventKey;
                $this->weixin_response_template($toUser, $fromUser, $msgType, $content);
            }
        } else if (strtolower($postObj->MsgType) == 'text') {
            if (strtolower($postObj->Content) == 1) {
                $content = "雷顿学院百度网盘免费资料，链接: https://pan.baidu.com/s/1ePhJ_ZdM7k20Eh4e0_1ojw 提取码: bnf7 ";
                $this->weixin_response_template($toUser, $fromUser, $msgType, $content);
            } elseif (strtolower($postObj->Content) == 2) {
                $this->personal_haibao_response($toUser, $fromUser);
            }
        }

    }

    function add_scan_record($openid, $scan_openid) {
        $scan_qrcode_obj = M('scan_qrcode');
        $f = $scan_qrcode_obj->where("openid='$openid' and scan_openid='$scan_openid'")->find();
        if(!$f && ($openid!=$scan_openid)) {
            $scan_time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `yxt_scan_qrcode` (`openid`,`scan_time`,`scan_openid`) VALUES ( '$openid', '$scan_time', '$scan_openid')";
            $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
            $Model->execute($sql);
            $this->user_obj->where("openid='$scan_openid'")->setInc('coin', 10);
            $userinfo = $this->get_weixin_userinfo($openid);
            $nickname = $userinfo['nickname'];
            $kf_msg = "恭喜你，用户 $nickname 扫描了你的专属海报二维码，本次你获得10金币, 点击下方菜单使用金币购买课程或升级会员";
            $this->send_kefu_msg($scan_openid, $kf_msg);
        }
    }

    function haibao_activity_response($toUser, $fromUser, $qrcode_openid) {
        $content = "你扫描的海报 openid 是 " . $qrcode_openid;
        $kf_msg = "hi~  终于等到你 \n \n雷顿学院大免单，冲榜即可赢0元获得金牌会员和免费观看任意课程的机会  \n \n【冲榜方式】 \n \n转发下方个人专属海报给好友或朋友圈，邀请好友扫码参与活动，每邀请一位好友获取 10 金币，可用金币充值会员或购买任意课程";
        $this->add_scan_record($toUser, $qrcode_openid);
        $this->send_kefu_msg($toUser, $kf_msg);
        $this->personal_haibao_response($toUser, $fromUser);
    }

    function personal_haibao_response($toUser, $fromUser)
    {
        $media_id = $this->get_img_media($toUser);
        $this->weixin_response_img($toUser, $fromUser, $media_id);
    }

    function send_kefu_msg($openid, $kf_msg)
    {
        $token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$token";
        $data = '{"touser":"'.$openid.'","msgtype":"text","text":{ "content":"'.$kf_msg.'" }}';
        $this->curl_post_https($url, $data);
    }

    function handle_user($userinfo)
    {
        $user = M('users');
        $map['openid'] = $userinfo['openid'];
        $find = $user->where($map)->find();
        if (!$find) {
            $data = array(
                'user_login' => $userinfo['nickname'],
                'avatar' => $userinfo['headimgurl'],
                'sex' => $userinfo['sex'],
                'openid' => $userinfo['openid'],
                'user_nicename' => $userinfo['nickname'],
                'last_login_ip' => get_client_ip(0, true),
                'create_time' => date("Y-m-d H:i:s"),
                'last_login_time' => date("Y-m-d H:i:s"),
                'user_status' => 1,
                "user_type" => 2,
                "member_type" => 1,
                'coin' => C('give_coin') //初始赠送金币
            );

            $rst = $user->add($data);
            if ($rst) {
                $data['id'] = $rst;
                $_SESSION['user'] = $data;
                $give_coin = C('give_coin');
                $member_charge = C('member_charge');
                $content = $userinfo['nickname'] . ",您好，欢迎关注<a href='http://www.leidun.site'>雷顿学院</a>官方公众账号,已赠送您 $give_coin 金币，点击下方菜单，可用金币购买课程，另雷顿学院金牌会员价格只要 $member_charge,金牌会员可终身免费观看本站所有课程。回复 1 可免费领取 100G 学习资料";

            } else {
                $content = '注册失败,请重试';
            }


        } else {
            $member_charge = C('member_charge');
            $content = $userinfo['nickname'] . ",您好，欢迎回来,<a href='http://www.leidun.site'>雷顿学院</a>金牌会员价格只要 $member_charge ,金牌会员可终身免费观看本站所有课程";


        }

        return $content;

    }

    function weixin_response_template($toUser, $fromUser, $msgType, $content)
    {
        $time = time();
        $template = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                     </xml>";
        $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
        echo $info;
    }

    function weixin_response_img($toUser, $fromUser, $media_id)
    {
        $time = time();
        $tpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                    </Image>
                </xml>";
        $info = sprintf($tpl, $toUser, $fromUser, $time, $media_id);
        echo $info;
    }

    function create_personal_qrcode()
    {
        $openid = I('openid');
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $expire_seconds = 60 * 60 * 24 * 7;
        $scene_str = $this->haibao_scene_pre . $openid;
        $data = '{"expire_seconds":' . $expire_seconds . ', "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "' . $scene_str . '"}}}';
        $res = $this->curl_post_https($url, $data);
        $res = json_decode($res, true);
        $qrcode_ticket = $res['ticket'];
        $qrcode_ticket = urlencode($qrcode_ticket);
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$qrcode_ticket";
        $img = $this->curl_get_https($url);
        //echo $img;
        header("Content-type: image/jpeg");
        echo $img;

    }

    function deal_img()
    {
        header('Content-Type: image/png');
        $pic = "public/images/wechat_share.png";
        $f = file_exists($pic);
        $im = imagecreatefrompng($pic);


        // 二维码
        $openid = I('openid');
        $userinfo = $this->get_weixin_userinfo($openid);
        // 微信昵称
        $tc = imagecolorallocate($im, 0, 0, 0);
        $font = "public/simplebootx/public/fonts/ADOBEFANGSONGSTD-REGULAR.OTF";
        imagettftext($im, 15, 0, 280, 690, $tc, $font, $userinfo['nickname']);
        $qrcode_url = U('user/weixin/create_personal_qrcode?openid=' . $openid);

        // 头像
        $headimg_url = $userinfo['headimgurl'];
        $imgname = substr(md5(time() . rand(1, 1000)), 10) . '.jpeg';
        $headimg = downloadimg($headimg_url, 'public/images/activity/headimgs/' . $imgname);
        //$headimg = "public/images/wechat_share/headimg.jpeg";
        list($width_orig, $height_orig) = getimagesize($headimg);
        //$headim = imagecreatefromjpeg ($headimg);
        $headim = $this->createRoundImg($headimg);
        imagecopyresized($im, $headim, 210, 653, 0, 0, 58, 58, $width_orig, $height_orig);


        $url = 'http://' . $_SERVER['HTTP_HOST'];
        $qrcode_url = $url . $qrcode_url;
        $imgname = substr(md5(time() . rand(1, 1000)), 10) . '.jpeg';
        $qrcode_path = downloadimg($qrcode_url, 'public/images/activity/qrcode/' . $imgname);
        $qrcode = imagecreatefromjpeg($qrcode_path);
        list($width_orig, $height_orig) = getimagesize($qrcode_path);
        imagecopyresized($im, $qrcode, 400, 850, 0, 0, 130, 130, $width_orig, $height_orig);
        imagepng($im);
        //var_dump($f);
        exit;
    }

    function get_img_media($openid)
    {
        $deal_url = U('user/weixin/deal_img?openid=' . $openid);
        $url = 'http://' . $_SERVER['HTTP_HOST'];
        $haibao_url = $url . $deal_url;
        $imgname = substr(md5(time() . rand(1, 1000)), 10) . '.jpeg';
        $haibao_path = downloadimg($haibao_url, 'public/images/activity/haibao/' . $imgname);
        $media_id = $this->up_img_to_weixin($haibao_path);
        return $media_id;
    }

    function weixin_login()
    {
        $this->assign('scene_str', session('scene_str'));
        $this->display(':weixin_login');
    }

    function show_qrcode_img()
    {
        $qrcode_ticket = $this->create_temp_qrcode();
        $qrcode_ticket = urlencode($qrcode_ticket);
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$qrcode_ticket";
        $img = $this->curl_get_https($url);
        //echo $img;
        header("Content-type: image/jpeg");
        echo $img;
    }


    function create_temp_qrcode()
    {
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $expire_seconds = 60 * 60 * 24;
        $scene_str = str_shuffle(rand_string(6, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') . time());
        session('scene_str', $scene_str);
        $redis = new \redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->set('scene_str_' . $scene_str, 1, $expire_seconds);

        $data = '{"expire_seconds":' . $expire_seconds . ', "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "' . $scene_str . '"}}}';
        $res = $this->curl_post_https($url, $data);
        $res = json_decode($res, true);
        return $res['ticket'];
    }


    // 2019年将会发生的五件事情
    function starttest()
    {
        $userinfo = $_SESSION["weixin_userinfo"];
        //var_dump($userinfo);exit;


        $this->display(':starttest');
    }

    function resultshare()
    {
        $this->display(':resultshare');
    }

    function test()
    {
        $u = $_SESSION['weixin_userinfo'];
        var_dump($u);
        exit;
    }

    function deal_img_for_share()
    {
        header('Content-Type: image/png');
        $userinfo = $_SESSION['weixin_userinfo'];
        $name = $userinfo['nickname'];
        //$name = '晨曦哦';
        $headimg = $userinfo['headimgurl'];
        //$headimg = "http://thirdwx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo3PiaHwXBTa4gVWUfHENNPBh8xmO7LeslPvUndrIiaq2uGNfPkmFZiaNB4xeIf6xQmVLslygKf3TuxQ/132";

        $pic = "public/images/activity/back2019.jpg";
        //$headimg = "public/images/wechat_share/headimg.jpeg";
        //$picinfo = $this->myGetImageSize($headimg);

        $imgname = substr(md5(time() . rand(1, 1000)), 10) . '.jpeg';
        $headimg = downloadimg($headimg, 'public/images/activity/headimgs/' . $imgname);


        list($width_orig, $height_orig) = getimagesize($headimg);
        $im = imagecreatefromjpeg($pic);
        //$headim = imagecreatefromjpeg ($headimg);
        $headim = $this->createRoundImg($headimg);

        //imagecopy ( $im, $headim, 290, 50, 0, 0, 500, 500);
        imagecopyresized($im, $headim, 278, 33, 0, 0, 124, 124, $width_orig, $height_orig);


        $tc = imagecolorallocate($im, 0, 0, 0);
        $font = "public/simplebootx/public/fonts/ADOBEFANGSONGSTD-REGULAR.OTF";

        //$name='你好';
        imagettftext($im, 15, 0, 310, 185, $tc, $font, $name);

        $things = array('脱单', '分手', '升职', '复合', '奉子成婚', '变瘦', '暴富', '被父母催婚', '生孩子', '养一只猫', '养一条狗', '胖30斤', '进军模特界', '成为健身达人', '成为歌神', '坐拥千万粉丝', '网络爆红', '被王思聪关注', '被范冰冰关注', '拍一部电影', '被表白', '被求婚', '去大理', '去普吉岛', '去美国', '去英国', '跳一次广场舞', '身价过亿', '一夜暴富', '登录月球', '长高5厘米', '被喜欢的人告白', '一个人吃火锅', '一个人搬家', '买房子', '买汽车', '拿到驾照', '自驾游', '去西藏');
        $rand = array_rand($things, 5);

        imagettftext($im, 25, 0, 125, 350, $tc, $font, $things[$rand[0]]);
        imagettftext($im, 25, 0, 125, 440, $tc, $font, $things[$rand[1]]);
        imagettftext($im, 25, 0, 125, 530, $tc, $font, $things[$rand[2]]);
        imagettftext($im, 25, 0, 125, 620, $tc, $font, $things[$rand[3]]);
        imagettftext($im, 25, 0, 125, 710, $tc, $font, $things[$rand[4]]);

        imagejpeg($im);
        //echo $im;
        //var_dump($f);
        // exit;
    }

    function createRoundImg($imgpath)
    {
        //$imgpath = "public/images/wechat_share/headimg.jpeg";
        $ext = pathinfo($imgpath);
        //var_dump($ext);exit;
        $src_img = null;

        switch ($ext['extension']) {
            case 'jpg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'jpeg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'png':
                $src_img = imagecreatefrompng($imgpath);
                break;
            default:
                $src_img = imagecreatefromjpeg($imgpath);
                break;
        }
        // $wh = $this->myGetImageSize($imgpath);
        list($w, $h) = getimagesize($imgpath);
//        $w  = $wh[0];
//        $h  = $wh[1];
        $w = $h = min($w, $h);

        $image = imagecreatetruecolor($w, $h);
        $bg = imagecolorallocatealpha($image, 255, 255, 255, 127);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, $bg);
        $r = $w / 2;
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($image, $x, $y, $rgbColor);
                }
            }
        }

        //header("content-type:image/png");
        //imagepng($image);
        return $image;
        //imagedestroy($image);
    }


    public function up_img_to_weixin($img_path)

    {

        $token = $this->get_access_token();

        //$data = array("img" => "@" . $this->imgUrl);

        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $token . "&type=image";

        $res = json_decode($this->curl_up_img($url, $img_path), true);

        return $res['media_id'];

    }


}