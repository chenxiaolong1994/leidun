<?php
namespace Teacher\Controller;

use Common\Controller\HomebaseController;

require('./Expand/cos/include.php');
use Qcloud_cos\Auth;
use Qcloud_cos\Cosapi;

class CenterController extends HomebaseController
{
    function _initialize()
    {
        parent::_initialize();
        $this->course_obj = D("Common/Course");
        $this->coursetype_obj = D("Common/Coursetype");
        $this->courseview_obj = D("Common/CourseView");
        $this->user_obj = D("Common/Users");
        $this->label_obj = D("Common/Label");
        $this->section_obj = D("Common/Section");
        $this->usercourse_obj = D("Common/Usercourse");
        $this->material_obj = D("Common/Material");
        $this->teacher_order = D("Common/Teacher_order");
        $this->tixian_obj = D("Common/Tixian");
        $this->application_obj = D("Common/Application");
        $this->shiti_obj = D("Common/Exam_shiti");
        $this->live_obj = D("Common/Live");
        $this->userpapers_obj = D("Common/Exam_userpapers");
        $this->papers_obj = D("Common/Exam_papers");
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $avatar = $user['avatar'];
        $this->assign('avatar', $avatar);
        $this->assign('user', $user);
        $this->check_login();
        if ($user['user_type'] == 2) {
            $this->error("您无权操作！");
        }
    }

    function temp_insert()
    {

        //for i in `ls`;do name=${i:3};echo ${name%.mp4}; echo $url$i;done
        $handle = fopen('course.txt', 'r');
        $i = 1;
        while (!feof($handle)) {
            $data = array();
            $buffer = fgets($handle, 4096);
            $filename = trim($buffer);
            $a = explode(',' , $filename);
            $name = $a[0];
            $url = $a[1];
            //var_dump($a);
            $data['sc_name'] = $name;
            $data['yun_url'] = $url;
            $data['cs_id'] = 42;
            $data['video_type'] = 1;
            $data['section_type'] = 1;
            $data['state'] = 1;
            $data['addtime'] = date('Y-m-d H:i:s');
            if ($i<=5) {
                $data['is_free'] = 1;
            }
            $f = $this->section_obj->add($data);
            var_dump($f);
            $i = $i+1;

        }
        fclose($handle);
    }

    public function index()
    {
        $where['cs_state'] = 1;
        $where['cs_teacher'] = sp_get_current_userid();
        $where['course_type'] = 'normal';
        $count = $this->course_obj->where($where)->count();
        $page = $this->page($count, 10);
        $courselist = $this->courseview_obj->where($where)->order(array('listorder', 'id' => 'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($courselist as $n => $val) {
            $courselist[$n]['xueyuaunshu'] = $this->usercourse_obj->where('course_id=\'' . $val['id'] . '\'')->count();
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->assign("courselist", $courselist);
        $this->display();
    }

    public function live()
    {
        $where['cs_state'] = 1;
        $where['cs_teacher'] = sp_get_current_userid();
        $where['course_type'] = 'live';
        $count = $this->course_obj->where($where)->count();
        $page = $this->page($count, 10);
        $courselist = $this->courseview_obj->where($where)->order(array('listorder', 'id' => 'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($courselist as $n => $val) {
            $courselist[$n]['xueyuaunshu'] = $this->usercourse_obj->where('course_id=\'' . $val['id'] . '\'')->count();
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->assign("courselist", $courselist);
        $this->display();
    }

    public function doc()
    {
        $where['cs_state'] = 1;
        $where['cs_teacher'] = sp_get_current_userid();
        $where['course_type'] = 'doc';
        $count = $this->course_obj->where($where)->count();
        $page = $this->page($count, 10);
        $courselist = $this->courseview_obj->where($where)->order(array('listorder', 'id' => 'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($courselist as $n => $val) {
            $courselist[$n]['xueyuaunshu'] = $this->usercourse_obj->where('course_id=\'' . $val['id'] . '\'')->count();
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->assign("courselist", $courselist);
        $this->display();
    }

    function createcourse()
    {
        $this->display();
    }

    function coursetype()
    {
        if (POST) {
            $type = I('post.type');
            $title = I('post.title');
            if ($type == 'normal') {
                $this->_getTree();
                $term_id = intval(I("get.term"));
                $term = $this->course_obj->where("ty_id=$term_id")->find();
                $domain = sp_get_domain();
                $this->assign("term", $term);
                $this->assign("domain", $domain);
                $this->assign('title', $title);
                $this->assign('type', $type);
                $this->display('add');
            }
            if ($type == 'live') {
                $this->_getTree();
                $term_id = intval(I("get.term"));
                $term = $this->course_obj->where("ty_id=$term_id")->find();
                $domain = sp_get_domain();
                $this->assign("term", $term);
                $this->assign("domain", $domain);
                $this->assign('title', $title);
                $this->assign('type', $type);
                $this->display('addzhibocourse');
            }
            if ($type == 'doc') {
                $this->_getTree();
                $term_id = intval(I("get.term"));
                $term = $this->course_obj->where("ty_id=$term_id")->find();
                $domain = sp_get_domain();
                $this->assign("term", $term);
                $this->assign("domain", $domain);
                $this->assign('title', $title);
                $this->assign('type', $type);
                $this->display('adddoccourse');
            }
        }
    }

    /* function add(){
	    $this->_getTree();
		$term_id = intval(I("get.term"));
		$term=$this->course_obj->where("ty_id=$term_id")->find();
		$domain=sp_get_domain();
		$this->assign("term",$term);
		$this->assign("domain",$domain);
		$this->display();

	} */
    function add_post()
    {
        if (IS_POST) {
            $data = $this->course_obj->create();
            $count = $this->course_obj->count();
            $term_id = $_POST['ty_id'];
            $typedata = $this->coursetype_obj->where("term_id=$term_id")->find();
            $teacherdata = M('application')->where(array('user_id' => sp_get_current_userid()))->find();
            $data['cs_teacher'] = sp_get_current_userid();
            $data['top_id'] = $typedata['parent'] ?: $term_id;
            $data['cs_picture'] = $_POST['cs_picture'];
            $data['labelid'] = $_POST['labelid'];
            $deta['notice'] = $_POST['code'];
            $deta['count'] = $_POST['count'];
            $data['cs_addtime'] = date('Y-m-d H:i:s');
            $data['cs_state'] = 1;
            $data['cs_brief'] = htmlspecialchars_decode($data['cs_brief']);
            $data['course_type'] = $_POST['type'];
            $data['stu_numbers'] = $_POST['stu_numbers'];
            if ($teacherdata['state'] < 1) {
                $this->error("您还未通过审核，暂时不能添加课程！");
            }


            if ($this->course_obj->add($data)) {
                $this->success("添加成功！", U("Teacher/Center/index"));
            } else {
                $this->error("添加失败！");
            }

//       if($deta['notice']=='sucess'){
//               echo 11;
//				if ($this->course_obj->add($data)) {
//					$this->success("添加成功！",U("Teacher/Center/index"));
//				}else{
//					$this->error("添加失败！");
//				}
//			}else{
//               echo 22;
//				if($count>=$deta['count']){
//                echo 33;
//                var_dump($count,$deta);
//					$this->error($deta['notice']);
//				}else{
//					if ($this->course_obj->add($data)) {
//					    $this->success("添加成功！",U("Teacher/Center/index"));
//				    }else{
//					   $this->error("添加失败！");
//				    }
//				}
//			}

        }

    }

    private function _getTree()
    {
        $term_id = empty($_REQUEST['term']) ? 0 : intval($_REQUEST['term']);
        $result = $this->coursetype_obj->order(array("listorder" => "asc"))->select();

        $tree = new \Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        foreach ($result as $r) {
            $r['str_manage'] = '<a href="' . U("AdminCoursetype/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("AdminTerm/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("AdminTerm/delete", array("id" => $r['term_id'])) . '">删除</a> ';
            $r['visit'] = "<a href='#'>访问</a>";
            $r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
            $r['id'] = $r['term_id'];
            $r['parentid'] = $r['parent'];
            $r['selected'] = $term_id == $r['term_id'] ? "selected" : "";
            $array[] = $r;
        }
        $tree->init($array);
        $str = "<option value='\$id' \$selected>\$spacer\$name</option>";
        $taxonomys = $tree->get_tree(0, $str);
        //var_dump($taxonomys);exit;
        $this->assign("taxonomys", $taxonomys);
    }

    function Labelselect()
    {
        $c_id = I("get.id");
        $label = $this->label_obj->order(array("id" => "asc"))->where(array('c_id' => $c_id))->select();
        $json_string = json_encode($label);
        echo $json_string;
    }

    function addsection()
    {
        $cs_id = intval(I("get.cs_id"));
        $cs_data = $this->course_obj->where("id=$cs_id")->find();
        $cs_name = $this->course_obj->where("id=$cs_id")->getField('cs_name');
        $cs_pic = $this->course_obj->where("id=$cs_id")->getField('cs_picture');
        $where['cs_id'] = $cs_id;
        $where['type_id'] = 1;
        $zhang_list = $this->section_obj->where($where)->order("id DESC")->select();
        $this->assign("cs_data", $cs_data);
        $this->assign("cs_type", $cs_data['course_type']);
        $this->assign("cs_id", $cs_id);
        $this->assign("zhang_list", $zhang_list);
        $this->assign("cs_data", $cs_name);
        $this->assign("cs_pic", $cs_pic);
        $this->display();
    }

    function addsection_post()
    {
        if (IS_POST) {
            if ($data = $this->section_obj->create()) {
                if ($data['video_type'] == 1) {
                    $data['yun_url'] = I('post.yun_url');
                } else {
                    $data['yun_url'] = I('post.youku_url');
                    $data['playpass'] = I('post.playpass');
                }
                //var_dump($data);exit;
                if ($this->section_obj->add($data) !== false) {

                    $this->success("添加成功！", U("Teacher/Center/sectionlist", array('cs_id' => $data['cs_id'])));

                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->section_obj->getError());
            }
        }
    }

    function coursedelete()
    {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            if ($this->course_obj->delete($id) !== false) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }

        }
    }

    function addlivesection()
    {
        $cs_id = intval(I("get.cs_id"));
        $cs_data = $this->course_obj->where("id=$cs_id")->find();
        $where['cs_id'] = $cs_id;
        $where['type_id'] = 1;
        $zhang_list = $this->section_obj->where($where)->order("id DESC")->select();
        $this->assign("cs_data", $cs_data);
        $this->assign("cs_id", $cs_id);
        $this->assign("zhang_list", $zhang_list);
        $this->display();
    }

    function addlivesection_post()
    {
        if (IS_POST) {
            if ($data = $this->section_obj->create()) {
                if ($data['video_type'] == 1) {
                    $data['yun_url'] = I('post.yun_url');
                } else {
                    $data['yun_url'] = I('post.youku_url');
                    $data['playpass'] = I('post.playpass');
                }
                if ($this->section_obj->add($data) !== false) {

                    $this->success("添加成功！", U("Teacher/Center/sectionlist", array('cs_id' => $data['cs_id'])));

                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->section_obj->getError());
            }
        }
    }

    function adddocsection()
    {
        $cs_id = intval(I("get.cs_id"));
        $cs_data = $this->course_obj->where("id=$cs_id")->find();
        $where['cs_id'] = $cs_id;
        $where['type_id'] = 1;
        $zhang_list = $this->section_obj->where($where)->order("id DESC")->select();
        $this->assign("cs_data", $cs_data);
        $this->assign("cs_id", $cs_id);
        $this->assign("zhang_list", $zhang_list);
        $this->display();
    }

    function adddocsection_post()
    {
        if (IS_POST) {
            if ($data = $this->section_obj->create()) {
                $data['doccontent'] = htmlspecialchars_decode($data['doccontent']);
                if ($this->section_obj->add($data) !== false) {

                    $this->success("添加成功！", U("Teacher/Center/sectionlist", array('cs_id' => $data['cs_id'])));

                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->section_obj->getError());
            }
        }
    }

    function addzhang()
    {
        $cs_id = intval(I("get.cs_id"));
        $this->assign("cs_id", $cs_id);
        $this->display();
    }

    function addzhang_post()
    {
        if (IS_POST) {

            $data['cs_id'] = intval(I("post.cs_id"));
            $data['type_id'] = intval(I("post.type_id"));
            $data['sc_name'] = I("post.sc_name");
            $data['addtime'] = I("post.addtime");
            $data['state'] = 1;
            if ($data['sc_name'] == null) {
                $this->error("请填写章节名称！");
            }
            $result = $this->section_obj->add($data);
            if ($result) {

                $this->success("添加成功！");
            } else {
                $this->error("添加失败！");
            }
        }
    }

    function addvideo()
    {
        $this->display();
    }

    public function cos_upload()
    {
        set_time_limit(0);
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $type = $_GET[type];
        $srcPath = $_FILES['upvideo']['tmp_name'];
        $bucketName = C('DOMAIN');
        $dar = $user['mobile'] . '/' . $type;
        $path = "/$dar/";
        $ispath = Cosapi::statFolder($bucketName, $path);
        if ($ispath['code'] != '0') {
            Cosapi::createFolder($bucketName, $path);
        }
        $dstPath = $path . $_FILES['upvideo']['name'];
        if ($_FILES['upvideo']['size'] < 7388608) {
            $arr = Cosapi::upload($srcPath, $bucketName, $dstPath, $insertOnly = 0);
        } else {
            $arr = Cosapi::upload_slice($srcPath, $bucketName, $dstPath, $insertOnly = 0);
        }
    }

    function sectionlist()
    {
        $id = intval(I("get.cs_id"));
        $cs_name = $this->course_obj->where("id=$id")->getField('cs_name');
        $cs_pic = $this->course_obj->where("id=$id")->getField('cs_picture');
        $cs_type = $this->course_obj->where("id=$id")->getField('course_type');
        $count = $this->section_obj->where(array('cs_id' => $id, 'type_id' => 0))->count();
        $page = $this->page($count, 10);
        $sc_data = $this->section_obj->where(array('cs_id' => $id, 'type_id' => 0))->limit($page->firstRow . ',' . $page->listRows)->order("id ASC")->select();
        foreach ($sc_data as $n => $val) {
            $sc_data[$n]['channelid'] = $this->live_obj->where('sectionid=\'' . $val['id'] . '\'')->getField('channelid');
        }
        if ($cs_type == 'live') {

            foreach ($sc_data as $n => $val) {

                $live_timestamp = strtotime($val['live_starttime']);
                //$cha
                $md5_str = $val['channelid'] . '-' . ($live_timestamp + C('ali_live_time_long')) . '-0-0-' . C('ali_live_push_stream_url_key');

                $auth_key = md5($md5_str);
                $stream_push_url = C('ali_push_stream_url') . $val['channelid'] . '?auth_key=' . $auth_key;
                $sc_data[$n]['push_url'] = $stream_push_url;

                //$sc_data[$n]['livestate'] = '';


            }
        }
        $this->assign("sc_data", $sc_data);
        $this->assign("cs_id", $id);
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_name", $cs_name);
        $this->assign("cs_pic", $cs_pic);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->display();
    }

    function update_live_state()
    {
        $section_id = intval(I("post.sc_id"));
        $live_state = intval(I("post.live_state"));
        $this->section_obj->where(array("id" => $section_id))->setField('live_state', $live_state);
    }

    function write_playback_url()
    {
        $id = intval(I("get.id"));
        $name = $this->section_obj->where(array('id' => $id))->getField('sc_name');
        $this->assign('name', $name);
        $this->assign('id', $id);
        $this->display();
    }

    function addzhibo_playbackurl_post()
    {
        $id = intval(I("post.sc_id"));
        $url = I("post.yun_url");
        $this->section_obj->where(array('id' => $id))->setField('yun_url', $url);
        $this->section_obj->where(array('id' => $id))->setField('live_state', 5);
        $this->success('回放地址填写成功');
    }

    function livexiangqing()
    {
        $livetype = C('livetype');
        if ($livetype == 'qcloudlive') {
            $channelId = I("get.chid");
            $HttpUrl = "live.api.qcloud.com";
            $HttpMethod = "GET";
            $isHttps = true;
            $secretKey = C('SecretKey');
            $COMMON_PARAMS = array(
                'Nonce' => rand(),
                'Timestamp' => time(NULL),
                'Action' => 'DescribeLVBChannel',
                'SecretId' => C('SecretId'),
            );
            $PRIVATE_PARAMS = array(
                'channelId' => $channelId,
            );
            $result = $this->CreateRequest($HttpUrl, $HttpMethod, $COMMON_PARAMS, $secretKey, $PRIVATE_PARAMS, $isHttps);
            $res = json_decode($result, true);
            if ($res . code == 0) {
                $data['channel_id'] = $res['channelInfo'][0]['channel_id'];
                $data['channel_name'] = $res['channelInfo'][0]['channel_name'];
                $data['channel_status'] = $res['channelInfo'][0]['channel_status'];
                $data['sourceID'] = $res['channelInfo'][0]['upstream_list'][0]['sourceID'];
                $data['sourceAddress'] = $res['channelInfo'][0]['upstream_list'][0]['sourceAddress'];
                $this->assign('data', $data);
                $this->display();
            } else {
                $result = "";
                $this->display();
            }
        } else {
            $liveID = I("get.chid");
            $token = $this->gettoken();
            $bizCode = 'IPVULL';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&token=" . $token . '&pReqVULL.liveID=' . $liveID;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data1 = curl_exec($curl);
            $xml = simplexml_load_string($data1);
            $data1 = json_decode(json_encode($xml), TRUE);
            $state = $data1['contUL'];
            $data['channel_id'] = $state['liveID'];
            $data['channel_name'] = $state['liveName'];;
            $data['channel_status'] = $state['liveStatus'];;
            $data['sourceID'] = $state['liveID'];;
            $data['sourceAddress'] = $state['pushAddr'];
            $data['sourceAddress'] = $state['pushAddr'];
            $this->assign('data', $data);
            $this->display();

        }
    }

    function liveshudown()
    {
        $livetype = C('livetype');
        if ($livetype == 'qcloudlive') {
            $channelId = I("get.chid");
            $HttpUrl = "live.api.qcloud.com";
            $HttpMethod = "GET";
            $isHttps = true;
            $secretKey = C('SecretKey');
            $COMMON_PARAMS = array(
                'Nonce' => rand(),
                'Timestamp' => time(NULL),
                'Action' => 'StopLVBChannel',
                'SecretId' => C('SecretId'),
            );
            $PRIVATE_PARAMS = array(
                'channelIds.1' => $channelId,

            );
            $result = $this->CreateRequest($HttpUrl, $HttpMethod, $COMMON_PARAMS, $secretKey, $PRIVATE_PARAMS, $isHttps);
            $res = json_decode($result, true);
            if ($res . code == 0) {
                $this->assign("result", '关闭成功');
            } else {
                $this->assign("result", $res . message);
            }
            $this->display();
        } else {
            $liveID = I("get.chid");
            $token = $this->gettoken();
            $bizCode = 'IPVUSU';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&token=" . $token . '&pReqVUSU.liveID=' . $liveID . "&pReqVUSU.limitStatus=1";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data = curl_exec($curl);
            $xml = simplexml_load_string($data);
            $data = json_decode(json_encode($xml), TRUE);
            $state = $data1['contUL'];
            if ($state['resultCode'] == 0) {
                $this->assign("result", '关闭成功');
            } else {
                $this->assign("result", $state['resultMsg']);
            }
            $this->display();

        }
    }

    function livestart()
    {
        $channelId = I("get.chid");
        $HttpUrl = "live.api.qcloud.com";
        $HttpMethod = "GET";
        $isHttps = true;
        $secretKey = C('SecretKey');
        $COMMON_PARAMS = array(
            'Nonce' => rand(),
            'Timestamp' => time(NULL),
            'Action' => 'StartLVBChannel',
            'SecretId' => C('SecretId'),
        );
        $PRIVATE_PARAMS = array(
            'channelIds.1' => $channelId,

        );
        $result = $this->CreateRequest($HttpUrl, $HttpMethod, $COMMON_PARAMS, $secretKey, $PRIVATE_PARAMS, $isHttps);
        $res = json_decode($result, true);
        if ($res . code == 0) {
            $this->assign("result", '开启成功');
        } else {
            $this->assign("result", $res . message);
        }
        $this->display();


    }

    function livedel()
    {
        $this->chat_msg = D("Common/Chatmsg");
        $livetype = C('livetype');
        if ($livetype == 'qcloudlive') {
            $channelId = I("get.chid");
            $HttpUrl = "live.api.qcloud.com";
            $HttpMethod = "GET";
            $isHttps = true;
            $secretKey = C('SecretKey');
            $COMMON_PARAMS = array(
                'Nonce' => rand(),
                'Timestamp' => time(NULL),
                'Action' => 'DeleteLVBChannel',
                'SecretId' => C('SecretId'),
            );
            $PRIVATE_PARAMS = array(
                'channelIds.1' => $channelId,

            );
            $result = $this->CreateRequest($HttpUrl, $HttpMethod, $COMMON_PARAMS, $secretKey, $PRIVATE_PARAMS, $isHttps);
            $res = json_decode($result, true);

            if ($res . code == 0) {
                $this->chat_msg->where(array('channel_id' => $liveID))->delete();
                $this->assign("result", '删除成功');
            } else {
                $this->assign("result", $res . message);
            }
            $this->display();
        } else {
            $liveID = I("get.chid");
            $token = $this->gettoken();
            $bizCode = 'IPVULD';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&pReqVULC.liveName=" . $name . "&token=" . $token . '&pReqVULD.liveID=' . $liveID;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data = curl_exec($curl);
            $xml = simplexml_load_string($data);
            $data = json_decode(json_encode($xml), TRUE);
            if ($data['resultCode'] == 0) {
                $this->chat_msg->where(array('channel_id' => $liveID))->delete();
                $this->assign("result", '删除成功');
                $this->display();
            } else {
                $this->assign("result", $data['resultMsg']);
                $this->display();
            }

        }
    }

    function liveonline()
    {
        $livetype = C('livetype');
        if ($livetype == 'qcloudlive') {
            $channelId = I("get.chid");
            $HttpUrl = "live.api.qcloud.com";
            $HttpMethod = "GET";
            $isHttps = true;
            $secretKey = C('SecretKey');
            $COMMON_PARAMS = array(
                'Nonce' => rand(),
                'Timestamp' => time(NULL),
                'Action' => 'DescribeLVBOnlineUsers',
                'SecretId' => C('SecretId'),
            );
            $PRIVATE_PARAMS = array(
                'channelIds.n' => $channelId,

            );
            $result = $this->CreateRequest($HttpUrl, $HttpMethod, $COMMON_PARAMS, $secretKey, $PRIVATE_PARAMS, $isHttps);
            $res = json_decode($result, true);
            if ($res . code == 0) {
                $this->assign("result", $res['list']['online']);
            } else {
                $this->assign("result", $res . message);
            }
            $this->display();
        } else {
            $liveID = I("get.chid");
            $token = $this->gettoken();
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $bizCode1 = 'IPVULL';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $postdata = "bizCode=" . $bizCode1 . "&userName=" . $username . "&token=" . $token . '&pReqVULL.liveID=' . $liveID;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data1 = curl_exec($curl);
            $xml = simplexml_load_string($data1);
            $data1 = json_decode(json_encode($xml), TRUE);
            $state = $data1['contUL'];
            $bizCode = 'IPVUBL';
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&token=" . $token . '&pReqVUBL.liveID=' . $liveID . '&pReqVUBL.liveStream=' . $state['liveStream'];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data = curl_exec($curl);
            $xml = simplexml_load_string($data);
            $data = json_decode(json_encode($xml), TRUE);
            if ($data['resultCode'] == 0) {
                $this->assign("result", $data['conCount']);
                $this->display();
            } else {
                $this->assign("result", $data['resultMsg']);
                $this->display();
            }

        }
    }

    function courseedit()
    {
        $id = intval(I("get.id"));
        $this->_getTree();
        $cs_date = $this->course_obj->where("id=$id")->find();
        $this->assign("cs_date", $cs_date);
        $this->display();
    }

    function courseedit_post()
    {
        if (IS_POST) {
            $id = intval(I("post.id"));
            $data = $this->course_obj->create();
            //var_dump($data);exit;
            $typedata = $this->coursetype_obj->where("term_id=" . $data['ty_id'])->find();
            $data['top_id'] = $typedata['parent'] ?: $data['ty_id'];

            $data['cs_brief'] = htmlspecialchars_decode($data['cs_brief']);
            $result = $this->course_obj->where("id=$id")->save($data);
            if ($result) {

                $this->success("编辑成功！", U("Teacher/Center/index"));
            } else {
                $this->error("编辑失败！");
            }
        }
    }

    function coursedel()
    {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            if ($this->course_obj->delete($id) !== false) {
                $this->success("删除成功！", U("Teacher/Center/index"));
            } else {
                $this->error("删除失败！");
            }

        }
        if (isset($_POST['ids'])) {
            $tids = join(",", $_POST['ids']);
            if ($this->course_obj->where("id in ($tids)")->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }

    function secedit()
    {
        $id = intval(I("get.id"));
        $section = $this->section_obj->where("id=$id")->find();
        $cs_name = $this->course_obj->where(array('id' => $section['cs_id']))->getField('cs_name');
        $cs_type = $this->course_obj->where(array('id' => $section['cs_id']))->getField('course_type');
        $cs_id = $this->course_obj->where(array('id' => $section['cs_id']))->getField('id');
        $course = $this->course_obj->order(array("listorder" => "asc"))->select();
        $this->assign("course", $course);
        $this->assign("cs_id", $cs_id);
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_name", $cs_name);
        $this->assign("section", $section);
        $this->display();
    }

    function livsecedit()
    {
        $id = intval(I("get.id"));
        $section = $this->section_obj->where("id=$id")->find();
        $cs_name = $this->course_obj->where(array('id' => $section['cs_id']))->getField('cs_name');
        $cs_type = $this->course_obj->where(array('id' => $section['cs_id']))->getField('course_type');
        $cs_id = $this->course_obj->where(array('id' => $section['cs_id']))->getField('id');
        $course = $this->course_obj->order(array("listorder" => "asc"))->select();
        $this->assign("course", $course);
        $this->assign("cs_id", $cs_id);
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_name", $cs_name);
        $this->assign("section", $section);
        $this->display();
    }

    function docedit()
    {
        $id = intval(I("get.id"));
        $section = $this->section_obj->where("id=$id")->find();
        $section['doccontent'] = htmlspecialchars_decode($section['doccontent']);
        $cs_name = $this->course_obj->where(array('id' => $section['cs_id']))->getField('cs_name');
        $cs_type = $this->course_obj->where(array('id' => $section['cs_id']))->getField('course_type');
        $cs_id = $this->course_obj->where(array('id' => $section['cs_id']))->getField('id');
        $course = $this->course_obj->order(array("listorder" => "asc"))->select();
        $this->assign("course", $course);
        $this->assign("cs_id", $cs_id);
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_name", $cs_name);
        $this->assign("section", $section);
        $this->display();
    }

    function secdelete()
    {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            if ($this->section_obj->delete($id) !== false) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }

        }
        if (isset($_POST['ids'])) {
            $tids = join(",", $_POST['ids']);
            if ($this->section_obj->where("id in ($tids)")->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }

    }

    function secedit_post()
    {
        if (IS_POST) {
            $id = intval(I("post.id"));
            if ($data = $this->section_obj->create()) {
                if ($data['video_type'] == 1) {
                    //$data['yun_url'] = I('post.yun_url');
                    $data['yun_url'] = $_POST['yun_url'];
                } else {
                    $data['yun_url'] = I('post.youku_url');
                    $data['playpass'] = I('post.playpass');
                }
                //var_dump($data,$_POST['yun_url']);exit;
                if ($this->section_obj->where("id=$id")->save($data) !== false) {
                    $this->success("编辑成功！");
                } else {
                    $this->error("编辑失败！");
                }
            } else {
                $this->error($this->section_obj->getError());
            }
        }
    }

    function livsecedit_post()
    {
        if (IS_POST) {
            $id = intval(I("post.id"));
            $data['sc_name'] = I("post.sc_name");
            $data['live_starttime'] = I("post.live_starttime");
            $data['sc_time'] = I("post.sc_time");
            if ($this->section_obj->where("id=$id")->save($data) !== false) {
                $this->success("编辑成功！");
            } else {
                $this->error("编辑失败！");
            }

        }
    }

    function docedit_post()
    {
        if (IS_POST) {
            $id = intval(I("post.id"));
            if ($data = $this->section_obj->create()) {
                $data['doccontent'] = htmlspecialchars_decode($data['doccontent']);
                if ($this->section_obj->where("id=$id")->save($data) !== false) {
                    $this->success("编辑成功！");
                } else {
                    $this->error("编辑失败！");
                }
            } else {
                $this->error($this->section_obj->getError());
            }
        }
    }

    function xueyuanlist()
    {
        $id = intval(I("get.cs_id"));
        $cs_name = $this->course_obj->where("id=$id")->getField('cs_name');
        $cs_type = $this->course_obj->where("id=$id")->getField('course_type');
        $cs_pic = $this->course_obj->where("id=$id")->getField('cs_picture');
        $count = $this->usercourse_obj->where(array('course_id' => $id))->count();
        $page = $this->page($count, 10);
        $xueyuan = $this->usercourse_obj->where(array('course_id' => $id))->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($xueyuan as $n => $val) {
            $urlArr = explode("|", $xueyuan[$n]['studied']);
            $jnum = count($urlArr) - 1;
            $cs_id = $xueyuan[$n][course_id];
            $znum = $this->section_obj->where(array("cs_id" => $cs_id))->count();
            $xueyuan[$n]['bili'] = round(($jnum / $znum) * 100);
            $xueyuan[$n]['jnum'] = $jnum;
            $xueyuan[$n]['znum'] = $znum;
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("cs_type", $cs_type);
        $this->assign("current_page", $page->GetCurrentPage());
        $this->assign("xueyuan", $xueyuan);
        $this->assign("cs_name", $cs_name);
        $this->assign("cs_pic", $cs_pic);
        $this->assign("cs_id", $id);
        $this->display();
    }

    function material()
    {
        $id = intval(I("get.cs_id"));
        $cs_name = $this->course_obj->where("id=$id")->getField('cs_name');
        $cs_type = $this->course_obj->where("id=$id")->getField('course_type');
        $cs_pic = $this->course_obj->where("id=$id")->getField('cs_picture');
        $cs_id = $this->course_obj->where(array('id' => $section['cs_id']))->getField('id');
        $count = $this->material_obj->where("cs_id=$id")->count();
        $page = $this->page($count, 10);
        $ma_data = $this->material_obj->where("cs_id=$id")->order("id ASC")->limit($page->firstRow . ',' . $page->listRows)->order("id ASC")->select();
        foreach ($ma_data as $n => $val) {
            $ma_data[$n]['scname'] = $this->section_obj->where('id=\'' . $val['sc_id'] . '\'')->getField('sc_name');
        }
        $this->assign("ma_data", $ma_data);
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_id", $id);
        $this->assign("cs_name", $cs_name);
        $this->assign("cs_pic", $cs_pic);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->display();
    }

    function materialadd()
    {
        $id = intval(I("get.cs_id"));
        $sc_id = intval(I("get.sc_id"));
        $cs_name = $this->course_obj->where("id=$id")->getField('cs_name');
        $cs_id = $this->course_obj->where(array('id' => $section['cs_id']))->getField('id');
        $this->assign("cs_id", $id);
        $this->assign("sc_id", $sc_id);
        $this->assign("cs_name", $cs_name);
        $this->display();
    }

    function materialadd_post()
    {
        if (IS_POST) {
            $data = $this->material_obj->create();
            if ($data['name'] == null) {
                $this->error("资料标题不能为空！");
            }
            if ($data['url'] == null) {
                $this->error("下载地址不能为空！");
            }
            $result = $this->material_obj->add($data);
            if ($result) {
                $this->success("添加成功！", U("Teacher/Center/material", array('cs_id' => $data['cs_id'])));
            } else {
                $this->error("添加失败！");
            }

        }

    }

    function materialedit()
    {
        $id = intval(I("get.id"));
        $data = $this->material_obj->where(array('id' => $id))->find();
        $cs_type = $this->course_obj->where(array('id' => $data['cs_id']))->getField('course_type');
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_id", $data['cs_id']);
        $this->assign("data", $data);
        $this->display();
    }

    function materialedit_post()
    {
        if (IS_POST) {
            $id = intval(I("POST.id"));
            $material = $this->material_obj->where(array('id' => $id))->find();
            $data['downname'] = $_SESSION["access_name"];
            $data['name'] = I("POST.name");
            $data['url'] = I("POST.url");
            $result = $this->material_obj->where(array('id' => $id))->save($data);
            if ($result) {
                session("access_url", null);
                session("access_name", null);
                $this->success("添加成功！", U("Teacher/Center/material", array('cs_id' => $material['cs_id'])));
            } else {
                $this->error("添加失败！");
            }

        }


    }

    function materialdel()
    {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            if ($this->material_obj->delete($id) !== false) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }

        }
        if (isset($_POST['ids'])) {
            $tids = join(",", $_POST['ids']);
            if ($this->material_obj->where("id in ($tids)")->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }

    }

    function pinglun()
    {
        $cs_id = intval(I("get.cs_id"));
        $cs_name = $this->course_obj->where("id=$cs_id")->getField('cs_name');
        $cs_pic = $this->course_obj->where("id=$cs_id")->getField('cs_picture');
        $cs_type = $this->course_obj->where("id=$cs_id")->getField('course_type');
        $count = $this->usercourse_obj->where(array('course_id' => $cs_id, 'pinglun' => array('neq', '')))->count();
        $page = $this->page($count, 10);
        $pinglun = $this->usercourse_obj->where(array('course_id' => $cs_id, 'pinglun' => array('neq', '')))->select();
        $this->assign("pinglun", $pinglun);
        $this->assign("cs_name", $cs_name);
        $this->assign("cs_pic", $cs_pic);
        $this->assign("cs_type", $cs_type);
        $this->assign("cs_id", $cs_id);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->display();
    }

    function isfree()
    {
        if (IS_POST) {
            $id = (int)$_POST['id'];
            $data = $this->section_obj->where(array('id' => $id))->find();
            if ($data['is_free'] == 0) {
                $data['is_free'] = 1;
            } else {
                $data['is_free'] = 0;
            }
            $this->section_obj->save($data);

            return json_encode($data);

        }
    }

    function isover()
    {
        if (IS_POST) {
            $id = (int)$_POST['id'];
            $data = $this->course_obj->where(array('id' => $id))->find();
            if ($data['isover'] == 0) {
                $data['isover'] = 1;
            } else {
                $data['isover'] = 0;
            }
            if ($this->course_obj->save($data)) {
                return json_encode($data['isover']);
            }

        }
    }

    function sales()
    {
        $userid = sp_get_current_userid();
        $count1 = $this->teacher_order->where(array('u_id' => $userid))->count();
        $count2 = $this->tixian_obj->where(array('u_id' => $userid))->count();
        $page1 = $this->page($count1, 10);
        $page2 = $this->page($count2, 10);
        $sales = $this->teacher_order->where(array('u_id' => $userid))->limit($page1->firstRow . ',' . $page->listRows)->order("id ASC")->select();
        $tixian = $this->tixian_obj->where(array('u_id' => $userid))->limit($page2->firstRow . ',' . $page->listRows)->order("id ASC")->select();
        foreach ($sales as $n => $val) {
            $inflownum = $inflownum + $val['money'];
            $sales[$n]['scname'] = $this->course_obj->where('id=\'' . $val['c_id'] . '\'')->getField('cs_name');
        }
        foreach ($tixian as $n => $val) {
            $tixiannum = $tixiannum + $val['money'];
        }
        $keti = $inflownum - $tixiannum;
        $this->assign('inflownum', $inflownum);
        $this->assign('keti', $keti);
        $this->assign('tixian', $tixian);
        $this->assign('tixiannum', $tixiannum);
        $this->assign('sales', $sales);
        $this->assign("Page1", $page1->show('Admin'));
        $this->assign("current_page", $page1->GetCurrentPage());
        $this->assign("Page2", $page2->show('Admin'));
        $this->assign("current_page", $page2->GetCurrentPage());
        $this->display();
    }

    function tixian()
    {

        $this->display();
    }

    function tixian_post()
    {
        if (IS_POST) {
            $userid = sp_get_current_userid();
            $sales = $this->teacher_order->where(array('u_id' => $userid))->select();
            $tixian = $this->tixian_obj->where(array('u_id' => $userid))->select();
            foreach ($sales as $n => $val) {
                $inflownum = $inflownum + $val['money'];
            }
            foreach ($tixian as $n => $val) {
                $tixiannum = $tixiannum + $val['money'];
            }
            $keti = $inflownum - $tixiannum;
            $data = $this->tixian_obj->create();
            if (empty($data['money'])) {
                $this->error('提现金额不能为空');
            }
            if ($data['money'] < 100) {
                $this->error('提现金额必须大于100元');
            }
            if ($data['money'] > $keti) {
                $this->error('账户余额小于你的提款额');
            }
            if (empty($data['turename'])) {
                $this->error('真实姓名不能为空');
            }
            if (empty($data['count'])) {
                $this->error('提款账户不能为空');
            }
            $data['u_id'] = sp_get_current_userid();
            $data['addtime'] = date('Y-m-d H:i:s');
            $data['state'] = 0;
            if ($this->tixian_obj->add($data)) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }

    function upvideo()
    {
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $yuntype = C('yuntype');
        if ($yuntype == 'qcloud') {
            $this->display();
        } else {
            $userid = sp_get_current_userid();
            $folderid = $this->user_obj->where(array('id' => $userid))->getField('folderid');
            $username = C('wsviewname');
            $password = MD5(MD5(C('wsviewpass')) . 'abc');
            $this->assign("folderid", $folderid);
            $this->assign("username", $username);
            $this->assign("password", $password);
            $this->display(upwsviewvideo);
        }

    }

    function updoc()
    {
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->display();
    }

    function upppt()
    {
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->display();
    }

    function ziyuanku()
    {
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $yuntype = C('yuntype');
        if ($yuntype == 'qcloud') {
            $bucketName = C('DOMAIN');
            $type = $_GET[type];

            if (empty($type)) {
                $type = video;
            }
            $dar = $user['mobile'] . '/' . $type;
            $path = "/$dar/";
            $result = Cosapi::listFolder($bucketName, $path, 100, 'eListBoth', 0);
            $this->assign('result', $result['data']['infos']);
        } else {
            $token = $this->gettoken();
            $bizCode = 'IPUJML';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $password = MD5(C('wsviewpass'));
            $folderID = $user['folderid'];
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&token=" . $token . "&pReqJML.videoID=AllList" . "&pReqJML.folderID=" . $folderID;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data = curl_exec($curl);
            $xml = simplexml_load_string($data);
            $data = json_decode(json_encode($xml), TRUE);

            $video = $data['contJM'];
            foreach ($video as $n => $val) {
                $video[$n]['name'] = $video[$n]['title'];
            }
            $this->assign('result', $video);
            curl_close($curl);
        }

        $this->assign('yuntype', $yuntype);
        $this->display();

    }

    function ziyuanku2()
    {
        $domain = sp_get_domain();
        $yuntype = C('yuntype');
        $this->assign("domain", $domain);
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();

        if ($yuntype == 'qcloud') {
            $bucketName = C('DOMAIN');
            $type = $_GET[type];
            if (empty($type)) {
                $type = video;
            }
            $dar = $user['mobile'] . '/' . $type;
            $path = "/$dar/";
            $result = Cosapi::listFolder($bucketName, $path, 100, 'eListBoth', 1);
            $res = $result['data']['infos'];
            foreach ($res as $n => $val) {
                $res[$n]['ctime'] = date('Y-m-d H:i:s', $res[$n]['ctime']);
                $res[$n]['filesize'] = round($res[$n]['filesize'] / 1024 / 1024, 2);
            }
            $this->assign('result', $res);
        } else {
            $token = $this->gettoken();
            $bizCode = 'IPUJML';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $password = MD5(C('wsviewpass'));
            $folderID = $user['folderid'];
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&token=" . $token . "&pReqJML.videoID=AllList" . "&pReqJML.folderID=" . $folderID . "&pReqJML.videoStatus=2";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data = curl_exec($curl);
            $xml = simplexml_load_string($data);
            $data = json_decode(json_encode($xml), TRUE);
            $video = $data['contJM'];

            foreach ($video as $n => $val) {
                $video[$n]['name'] = $video[$n]['title'];
                $video[$n]['videoid'] = $video[$n]['videoID'];
                $video[$n]['filesize'] = round($video[$n]['videoSize'] / 1024 / 1024, 1);
                $video[$n]['ctime'] = $video[$n]['duration'];
                access_url;
                $video[$n]['access_url'] = $video[$n]['httpStr']['2'];
            }
            $this->assign('result', $video);
            curl_close($curl);

        }
        $this->display();
    }

    function document()
    {
        $bucketName = C('DOMAIN');
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $type = document;
        $dar = $user['mobile'] . '/' . $type;
        $path = "/$dar/";
        $result = Cosapi::listFolder($bucketName, $path, 100, 'eListBoth', 0);
        $this->assign('result', $result['data']['infos']);
        $this->display();

    }

    function document2()
    {
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $bucketName = C('DOMAIN');
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $type = document;
        $dar = $user['mobile'] . '/' . $type;
        $path = "/$dar/";
        $result = Cosapi::listFolder($bucketName, $path, 100, 'eListBoth', 0);
        $res = $result['data']['infos'];

        foreach ($res as $n => $val) {
            $res[$n]['ctime'] = date('Y-m-d H:i:s', $res[$n]['ctime']);
            $res[$n]['filesize'] = round($res[$n]['filesize'] / 1024 / 1024, 2);
        }

        $this->assign('result', $res);
        $this->display();

    }

    function ppt()
    {
        $bucketName = C('DOMAIN');
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $type = ppt;
        $dar = $user['mobile'] . '/' . $type;
        $path = "/$dar/";
        $result = Cosapi::listFolder($bucketName, $path, 100, 'eListBoth', 0);
        $this->assign('result', $result['data']['infos']);
        $this->display();

    }

    function zydel()
    {
        $bucketName = C('DOMAIN');
        $userid = sp_get_current_userid();
        $user = $this->user_obj->where(array('id' => $userid))->find();
        $type = $_GET['type'];
        $dar = $user['mobile'] . '/' . $type;
        $path = "/$dar";
        if (isset($_POST['ids'])) {
            $tids = join(",", $_POST['ids']);
            $urlArr = explode(",", $tids);
            $num = count($urlArr);
            for ($i = 0; $i < $num; ++$i) {
                $path2 = $path . '/' . $urlArr[$i];

                $result = Cosapi::del($bucketName, $path2);
            }
            if ($result['code'] == '0') {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');

            }
        }
    }

    function wsviewdel()
    {
        if (isset($_POST['ids'])) {
            $tids = join(",", $_POST['ids']);
            $token = $this->gettoken();
            $bizCode = 'IPUJMD';
            $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
            $username = C('wsviewname');
            $password = MD5(C('wsviewpass'));
            $postdata = "bizCode=" . $bizCode . "&userName=" . $username . "&token=" . $token . '&pReqJMD.videoID=' . $tids;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $data = curl_exec($curl);
            $xml = simplexml_load_string($data);
            $data = json_decode(json_encode($xml), TRUE);
            $video = $data['PRespJMD'];
            curl_close($curl);
            $this->success('删除成功');
        }
    }

    function addzhibo()
    {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            $name = $this->section_obj->where(array('id' => $id))->getField('sc_name');
            $this->assign('name', $name);
            $this->assign('id', $id);
            $this->display();
        }
    }

    function seepushurl()
    {
        if (isset($_GET['id'])) {
            $sc_id = intval(I("get.id"));
            $liveobj = D('Common/live');
            $channelid = $liveobj->where(array('sectionid' => $sc_id))->getField('channelid');
            $channename = $liveobj->where(array('sectionid' => $sc_id))->getField('channelname');
            $live_starttime = $this->section_obj->where(array('id' => $sc_id))->getField('live_starttime');

            $live_timestamp = strtotime($live_starttime);
            $timestamp = $live_timestamp + C('ali_live_time_long');
            //$cha
            $md5_str = $channelid . '-' . $timestamp . '-0-0-' . C('ali_live_push_stream_url_key');

            $md5 = md5($md5_str);
            $auth_key = $timestamp . '-0-0-' . $md5;
            $stream_push_url = C('ali_push_stream_url') . $channelid . '?auth_key=' . $auth_key;
            $this->assign('push_url', $stream_push_url);
            $this->assign('channelname', $channename);
            $this->display();
        }
    }

    function addzhibo_post()
    {
        $livetype = C('livetype');
        $name = I('POST.cs_name');
        $cs_id = I('POST.cs_id');
        $isRecord = I('POST.isRecord');

        $appname = md5($name);
        $appstreanm = md5($cs_id . time() . $name);

        $this->live_obj = D("Common/live");
        $data['channelname'] = $name;
        $data['outputsourcetype'] = 3;
        $data['playerpassword'] = '';
        //$data['upstream_address'] = ;
        $data['channelid'] = "/$appname/$appstreanm";
        $data['appid'] = '';
        $data['sectionid'] = $cs_id;

        $check = $this->live_obj->where(array('sectionid' => $cs_id))->find();
        if ($check) {
            if ($this->live_obj->where(array('sectionid' => $cs_id))->save($data)) {
                $this->section_obj->where(array("id" => $cs_id))->setField('live_state', 2);
                $this->success('创建直播间成功！');
            }
        } else {
            if ($this->live_obj->add($data)) {
                $this->section_obj->where(array("id" => $cs_id))->setField('live_state', 2);
                $this->success('创建直播间成功！');
            }
        }

    }

    function CreateRequest($HttpUrl, $HttpMethod, $COMMON_PARAMS, $secretKey, $PRIVATE_PARAMS, $isHttps)
    {
        $FullHttpUrl = $HttpUrl . "/v2/index.php";
        $ReqParaArray = array_merge($COMMON_PARAMS, $PRIVATE_PARAMS);
        ksort($ReqParaArray);
        $SigTxt = $HttpMethod . $FullHttpUrl . "?";
        $isFirst = true;
        foreach ($ReqParaArray as $key => $value) {
            if (!$isFirst) {
                $SigTxt = $SigTxt . "&";
            }
            $isFirst = false;
            if (strpos($key, '_')) {
                $key = str_replace('_', '.', $key);
            }

            $SigTxt = $SigTxt . $key . "=" . $value;
        }

        $Signature = base64_encode(hash_hmac('sha1', $SigTxt, $secretKey, true));
        $Req = "Signature=" . urlencode($Signature);
        foreach ($ReqParaArray as $key => $value) {
            $Req = $Req . "&" . $key . "=" . urlencode($value);
        }
        if ($HttpMethod === 'GET') {
            if ($isHttps === true) {
                $Req = "https://" . $FullHttpUrl . "?" . $Req;
            } else {
                $Req = "http://" . $FullHttpUrl . "?" . $Req;
            }
            // dump($Req);
            $Rsp = file_get_contents($Req);
            return ($Rsp);
        } else {
            if ($isHttps === true) {
                $Rsp = SendPost("https://" . $FullHttpUrl, $Req, $isHttps);
            } else {
                $Rsp = SendPost("http://" . $FullHttpUrl, $Req, $isHttps);
            }
            return ($Rsp);
        }

    }

    function SendPost($FullHttpUrl, $Req, $isHttps)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Req);

        curl_setopt($ch, CURLOPT_URL, $FullHttpUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($isHttps === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $result = curl_exec($ch);
        if ($result . code == 0) {
            $this->success('创建直播成功！');
        }
    }

    function checkpaper()
    {
        $teacherid = sp_get_current_userid();
        $count = $this->userpapers_obj->where(array('teacherid' => $teacherid, 'readover' => 0))->count();
        $page = $this->page($count, 10);
        $papers = $this->userpapers_obj->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->where(array('teacherid' => $teacherid, 'readover' => 0))->select();
        foreach ($papers as $n => $val) {
            $papers[$n]['title'] = $this->papers_obj->where(array('id' => $papers[$n]['papersid']))->getField('title');
        }
        $this->assign('papers', $papers);
        $this->assign("Page", $page->show('Admin'));
        $this->display();
    }

    function checkpaperfinished()
    {
        $teacherid = sp_get_current_userid();
        $count = $this->userpapers_obj->where(array('teacherid' => $teacherid, 'readover' => 0))->count();
        $page = $this->page($count, 10);
        $papers = $this->userpapers_obj->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->where(array('teacherid' => $teacherid, 'readover' => 1))->select();
        foreach ($papers as $n => $val) {
            $papers[$n]['title'] = $this->papers_obj->where(array('id' => $papers[$n]['papersid']))->getField('title');
        }
        $this->assign('papers', $papers);
        $this->assign("Page", $page->show('Admin'));
        $this->display();
    }

    function gettoken()
    {
        $bizCode = 'IPUQXC';
        $username = C('wsviewname');
        $password = MD5(C('wsviewpass'));
        $url = 'http://open.wsview.com:8090/iWSViewPortalData?';
        $postdata = "bizCode=" . $bizCode . "&pReqQXC.userName=" . $username . "&pReqQXC.password=" . $password;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        $data = curl_exec($curl);
        $xml = simplexml_load_string($data);
        $data = json_decode(json_encode($xml), TRUE);
        return ($data['token']);
        curl_close($curl);
    }

}
	

