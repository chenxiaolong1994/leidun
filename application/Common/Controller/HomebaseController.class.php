<?php
namespace Common\Controller;
use Common\Controller\AppframeController;
class HomebaseController extends AppframeController {
	
	public function __construct() {
		$this->set_action_success_error_tpl();
		parent::__construct();
	}
	
	function _initialize() {
		parent::_initialize();

		vendor('Wxpay.JsApiPay');
		$site_options=get_site_options();
        $domain=sp_get_domain();
		$this->assign($site_options);
		$this->assign("domain",$domain);

        $this->user_obj = D("Common/Users");
        $this->nav_obj = D("Common/Nav");
        $this->link_obj = D("Common/Links");
        $nav=$this->nav_obj->where(array('cid'=>1,'status'=>1,'parentid'=>0))->order('listorder asc')->select();
		$dnav=$this->nav_obj->where(array('cid'=>2,'status'=>1,'parentid'=>0))->order('listorder asc')->select();
		$links=$this->link_obj->where(array('link_status'=>1))->order('listorder asc')->select();
	    foreach($dnav as $n=> $val){
	    	$dnav[$n]['voo']=$this->nav_obj->order('listorder asc')->where('parentid=\''.$val['id'].'\'')->select();
		}
		$this->assign("links",$links);
		$this->assign("nav",$nav);	
		$this->assign("dnav",$dnav);
        $ucenter_syn=C("UCENTER_ENABLED");
		if($ucenter_syn){
			if(!isset($_SESSION["user"])){
				if(!empty($_COOKIE['thinkcmf_auth'])  && $_COOKIE['thinkcmf_auth']!="logout"){
					$thinkcmf_auth=sp_authcode($_COOKIE['thinkcmf_auth'],"DECODE");
					$thinkcmf_auth=explode("\t", $thinkcmf_auth);
					$auth_username=$thinkcmf_auth[1];
					$users_model=M('Users');
					$where['user_login']=$auth_username;
					$user=$users_model->where($where)->find();
					if(!empty($user)){
						$is_login=true;
						$_SESSION["user"]=$user;
					}
				}
			}else{
			}
		}

		if(is_weixin() && !isset($_SESSION["user"])) {
			if ($_GET['code']) {
				$code = $_GET['code'];
				$res = $this->get_weinxin_auth_access_token_by_code($code);
				session('openid', $res['openid']);
				$userinfo = $this->get_userinfo_by_auth($res['access_token'], $res['openid']);
				//session('userinfo',$userinfo);
				session('weixin_userinfo', $userinfo);
				//var_dump($userinfo);exit;
				$this->weixin_login_handle($userinfo);
			} else {
				$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
				session('redirect_url', $url);
				$url = urlencode($url);
				$appid = C('wx_appid');
				$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$url}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
				header("Location: $url");
			}
		}

		
		if(sp_is_user_login()){
			$this->assign("user",sp_get_current_user());
		}
		$coursetype_obj=D("Common/Coursetype");
		$typelist=$coursetype_obj->where('parent=0')->select();
	    foreach($typelist as $n=> $val){
			$typelist[$n]['voo']=$coursetype_obj->order('listorder desc')->where('parent=\''.$val['term_id'].'\'')->select();
			if(empty($typelist[$n]['voo'])){
			   $typelist[$n]['istop']=0;	
			}else{
			   $typelist[$n]['istop']=1;
			}
			
		}	
		$this->assign('list',$typelist);
		$userid=sp_get_current_userid();
		$user=$this->user_obj->where(array("id"=>$userid))->find();
		$avatar=$user['avatar'];
		$this->assign('avatar',$avatar);
		$this->assign("top_type",$typelist);
		$this->assign($user);
	}

	function get_weinxin_auth_access_token_by_code($code) {
		$appid = C('wx_appid');
		$secret = C('wx_appsecret');
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
		$res = $this->curl_get_https($url);
		$res = json_decode($res, true);
		return $res;
	}

	function get_userinfo_by_auth($access_token,$openid) {

		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
		$userinfo = $this->curl_get_https($url);
		$userinfo = json_decode($userinfo, true);
		//var_dump($userinfo);exit;
		return $userinfo;

	}

	//微信端打开网页，检测登录
	function weixin_login_handle($userinfo) {
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

			$_SESSION['user'] = $data;


			$rst = $user->add($data);
			if ($rst) {
				$data['id'] = $rst;
				$_SESSION['user'] = $data;
				$give_coin = C('give_coin');
				$member_charge = C('member_charge');
				$content = $userinfo['nickname'] . ",您好，欢迎关注<a href='http://www.leidun.site'>雷顿学院</a>官方公众账号,已赠送您 $give_coin 金币，点击下方菜单，可用金币购买课程，另雷顿学院金牌会员价格只要 $member_charge,金牌会员可终身免费观看本站所有课程";

			} else {
				$content = '注册失败,请重试';
			}


		} else {
			$_SESSION['user'] = $find;
			$member_charge = C('member_charge');
			$content = $userinfo['nickname'] . ",您好，欢迎回来,<a href='http://www.leidun.site'>雷顿学院</a>金牌会员价格只要 $member_charge ,金牌会员可终身免费观看本站所有课程";


		}

		return $content;
	}
	
	/**
	 * 检查用户登录
	 */
	protected function check_login(){
		if(!isset($_SESSION["user"])){
			$this->redirect('User/Login/index');
		}
		
	}
	
	/**
	 * 检查用户状态
	 */
	protected function  check_user(){
	    $user_status=M('Users')->where(array("id"=>sp_get_current_userid()))->getField("user_status");
		if($user_status==2){
			$this->error('您还没有激活账号，请激活后再使用！',U("user/login/active"));
		}
		
		if($user_status==0){
			$this->error('此账号已经被禁止使用，请联系管理员！',__ROOT__."/");
		}
	}
	 protected function  check_teacher(){
	    $user_type=M('Users')->where(array("id"=>sp_get_current_userid()))->getField("user_type");
		if($user_type==2){
			$this->error('你没有此权限！');
		}
	}
	/**
	 * 发送注册激活邮件
	 */
	protected  function _send_to_active(){
		$option = M('Options')->where(array('option_name'=>'member_email_active'))->find();
		if(!$option){
			$this->error('网站未配置账号激活信息，请联系网站管理员');
		}
		$options = json_decode($option['option_value'], true);
		//邮件标题
		$title = $options['title'];
		$uid=$_SESSION['user']['id'];
		$username=$_SESSION['user']['user_login'];
	
		$activekey=md5($uid.time().uniqid());
		$users_model=M("Users");
	
		$result=$users_model->where(array("id"=>$uid))->save(array("user_activation_key"=>$activekey));
		if(!$result){
			$this->error('激活码生成失败！');
		}
		//生成激活链接
		$url = U('user/register/active',array("hash"=>$activekey), "", true);
		//邮件内容
		$template = $options['template'];
		$content = str_replace(array('http://#link#','#username#'), array($url,$username),$template);
	
		$send_result=sp_send_email($_SESSION['user']['user_email'], $title, $content);
	
		if($send_result['error']){
			$this->error('激活邮件发送失败，请尝试登录后，手动发送激活邮件！');
		}
	}
	
	/**
	 * 加载模板和页面输出 可以返回输出内容
	 * @access public
	 * @param string $templateFile 模板文件名
	 * @param string $charset 模板输出字符集
	 * @param string $contentType 输出类型
	 * @param string $content 模板输出内容
	 * @return mixed
	 */
	public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		//echo $this->parseTemplate($templateFile);
		parent::display($this->parseTemplate($templateFile), $charset, $contentType);
	}
	
	/**
	 * 获取输出页面内容
	 * 调用内置的模板引擎fetch方法，
	 * @access protected
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $content 模板输出内容
	 * @param string $prefix 模板缓存前缀*
	 * @return string
	 */
	public function fetch($templateFile='',$content='',$prefix=''){
	    $templateFile = empty($content)?$this->parseTemplate($templateFile):'';
		return parent::fetch($templateFile,$content,$prefix);
	}
	
	/**
	 * 自动定位模板文件
	 * @access protected
	 * @param string $template 模板文件规则
	 * @return string
	 */
	public function parseTemplate($template='') {
		
		$tmpl_path=C("SP_TMPL_PATH");
		define("SP_TMPL_PATH", $tmpl_path);
		// 获取当前主题名称
		$theme      =    C('SP_DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			$t = C('VAR_TEMPLATE');
			if (isset($_GET[$t])){
				$theme = $_GET[$t];
			}elseif(cookie('think_template')){
				$theme = cookie('think_template');
			}
			if(!file_exists($tmpl_path."/".$theme)){
				$theme  =   C('SP_DEFAULT_THEME');
			}
			cookie('think_template',$theme,864000);
		}
		
		$theme_suffix="";
		
		if(C('MOBILE_TPL_ENABLED') && sp_is_mobile()){//开启手机模板支持
		    
		    if (C('LANG_SWITCH_ON',null,false)){
		        if(file_exists($tmpl_path."/".$theme."_mobile_".LANG_SET)){//优先级最高
		            $theme_suffix  =  "_mobile_".LANG_SET;
		        }elseif (file_exists($tmpl_path."/".$theme."_mobile")){
		            $theme_suffix  =  "_mobile";
		        }elseif (file_exists($tmpl_path."/".$theme."_".LANG_SET)){
		            $theme_suffix  =  "_".LANG_SET;
		        }
		    }else{
    		    if(file_exists($tmpl_path."/".$theme."_mobile")){
    		        $theme_suffix  =  "_mobile";
    		    }
		    }
		}else{
		    $lang_suffix="_".LANG_SET;
		    if (C('LANG_SWITCH_ON',null,false) && file_exists($tmpl_path."/".$theme.$lang_suffix)){
		        $theme_suffix = $lang_suffix;
		    }
		}
		
		$theme=$theme.$theme_suffix;
		
		C('SP_DEFAULT_THEME',$theme);
		
		$current_tmpl_path=$tmpl_path.$theme."/";
		// 获取当前主题的模版路径
		define('THEME_PATH', $current_tmpl_path);
		
		C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".$current_tmpl_path);
		
		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);
		
		define("SP_CURRENT_THEME", $theme);
		
		if(is_file($template)) {
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模块
		$module   =  MODULE_NAME;
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}
		
		
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = "/".CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = "/".CONTROLLER_NAME . $depr . $template;
		}
		
		$file = sp_add_template_file_suffix($current_tmpl_path.$module.$template);
		$file= str_replace("//",'/',$file);
		if(!file_exists_case($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
	}
	
	/**
	 * 设置错误，成功跳转界面
	 */
	private function set_action_success_error_tpl(){
		$theme      =    C('SP_DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			if(cookie('think_template')){
				$theme = cookie('think_template');
			}
		}
		//by ayumi手机提示模板
		$tpl_path = '';
		if(C('MOBILE_TPL_ENABLED') && sp_is_mobile() && file_exists(C("SP_TMPL_PATH")."/".$theme."_mobile")){//开启手机模板支持
			$theme  =   $theme."_mobile";
			$tpl_path=C("SP_TMPL_PATH").$theme."/";
		}else{
			$tpl_path=C("SP_TMPL_PATH").$theme."/";
		}
		
		//by ayumi手机提示模板
		$defaultjump=THINK_PATH.'Tpl/dispatch_jump.tpl';
		$action_success = sp_add_template_file_suffix($tpl_path.C("SP_TMPL_ACTION_SUCCESS"));
		$action_error = sp_add_template_file_suffix($tpl_path.C("SP_TMPL_ACTION_ERROR"));
		if(file_exists_case($action_success)){
			C("TMPL_ACTION_SUCCESS",$action_success);
		}else{
			C("TMPL_ACTION_SUCCESS",$defaultjump);
		}
		if(file_exists_case($action_error)){
			C("TMPL_ACTION_ERROR",$action_error);
		}else{
			C("TMPL_ACTION_ERROR",$defaultjump);
		}
	}
    function inject_check($sql_str) {
	   return eregi('select|insert|script|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤
}


	function get_weixin_userinfo($openid)
	{
		$access_token = $this->get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$res = $this->curl_get_https($url);
		$userinfo = json_decode($res, true);
		return $userinfo;
	}


	function get_access_token()
	{
		$redis = new \redis();
		$redis->connect('127.0.0.1', 6379);
		$access_token = $redis->get('leidun_access_token');
		if (!$access_token) {
			$appid = C('wx_appid');
			$secret = C('wx_appsecret');
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
			$data = $this->curl_get_https($url);
			$data = json_decode($data, true);
			$access_token = $data['access_token'];
			$redis->set('leidun_access_token', $data['access_token'], 7000);
		}
		return $access_token;
	}


	function curl_get_https($url)
	{
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
		$tmpInfo = curl_exec($curl);     //返回api的json对象
		//关闭URL请求
		curl_close($curl);
		return $tmpInfo;    //返回json对象
	}

	/* PHP CURL HTTPS POST */
	function curl_post_https($url, $data)
	{ // 模拟提交数据函数
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec($curl); // 执行操作
		if (curl_errno($curl)) {
			echo 'Errno' . curl_error($curl);//捕抓异常
		}
		curl_close($curl); // 关闭CURL会话
		return $tmpInfo; // 返回数据，json格式
	}

	function curl_up_img($url, $filepath) {
		if (class_exists('\CURLFile')) {
			$field = array('fieldname' => new \CURLFile(realpath($filepath)));
		} else {
			$field = array('fieldname' => '@' . realpath($filepath));
		}
		$ch = curl_init();

		if (class_exists('\CURLFile')) {
			curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
		} else {    if (defined('CURLOPT_SAFE_UPLOAD')) {
			curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
		}
		}

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $field);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		return curl_exec($ch);

		//curl_close($ch);
	}
	
}