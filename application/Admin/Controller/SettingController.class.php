<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SettingController extends AdminbaseController{
	
	protected $options_model;
	
	function _initialize() {
		parent::_initialize();
		$this->options_model = D("Common/Options");
	}
	
	function site(){
	    C(S('sp_dynamic_config'));
		$option=$this->options_model->where("option_name='site_options'")->find();
		$cmf_settings=$this->options_model->where("option_name='cmf_settings'")->getField("option_value");
		$tpls=sp_scan_dir(C("SP_TMPL_PATH")."*",GLOB_ONLYDIR);
		$noneed=array(".","..",".svn");
		$tpls=array_diff($tpls, $noneed);
		$this->assign("templates",$tpls);
	    $alipayconfig=array(
	      seller_email=>C('seller_email'),
	      notify_url=>C('notify_url'),
	      return_url=>C('return_url'),
	      successpage=>C('successpage'),
	      errorpage=>C('errorpage'),
	      partner=>C('partner'),
	      key=>C('key'),
	    );
	    $tencent=array(
	     APP_ID=>C(APP_ID),
	     SECRET_ID=>C(SECRET_ID),
	     SECRET_KEY=>C(SECRET_KEY),
	     DOMAIN=>C(DOMAIN),
		 SecretKey=>C(SecretKey),
		 SecretId=>C(SecretId),
		 AppId=>C(AppId),
	    );
		$wsview=array(
		 name=>C('wsviewname'),
		 pass=>C('wsviewpass'),
		 name2=>C('wsviewname2'),
		 pass2=>C('wsviewpass2'),
		);
		$radio=array(
		  livetype=>C('livetype'),
		  yuntype=>C('yuntype'),
		  mobileverify=>C('mobileverify'),
		);
		$alidayu=array(
		  alidayu_app_key=>C('alidayu_app_key'),
		  alidayu_app_secret=>C('alidayu_app_secret'),
		  smsFreeSignName=>C('smsFreeSignName'),
		  smsTemplateCode=>C('smsTemplateCode'),
			
		);
		$adminstyles=sp_scan_dir("public/simpleboot/themes/*",GLOB_ONLYDIR);
		$adminstyles=array_diff($adminstyles, $noneed);
		$this->assign("adminstyles",$adminstyles);
		if($option){
			$this->assign((array)json_decode($option['option_value']));
			$this->assign("option_id",$option['option_id']);
		}
		$this->assign("alipayconfig",$alipayconfig);
		$this->assign("tencent",$tencent);
		$this->assign("wsview",$wsview);
		$this->assign("alidayu",$alidayu);
		$this->assign("radio",$radio);
		$this->assign("cmf_settings",json_decode($cmf_settings,true));
		
		
		$this->display();
	}
	
	function site_post(){
		if (IS_POST) {
			if(isset($_POST['option_id'])){
				$data['option_id']=intval($_POST['option_id']);
			}
			
			$configs["SP_SITE_ADMIN_URL_PASSWORD"]=empty($_POST['options']['site_admin_url_password'])?"":md5(md5(C("AUTHCODE").$_POST['options']['site_admin_url_password']));
			$configs["SP_DEFAULT_THEME"]=$_POST['options']['site_tpl'];
			$configs["DEFAULT_THEME"]=$_POST['options']['site_tpl'];
			$configs["SP_ADMIN_STYLE"]=$_POST['options']['site_adminstyle'];
			$configs["URL_MODEL"]=$_POST['options']['urlmode'];
			$configs["URL_HTML_SUFFIX"]=$_POST['options']['html_suffix'];
			$configs["UCENTER_ENABLED"]=empty($_POST['options']['ucenter_enabled'])?0:1;
			$configs["COMMENT_NEED_CHECK"]=empty($_POST['options']['comment_need_check'])?0:1;
			$comment_time_interval=intval($_POST['options']['comment_time_interval']);
			$configs["COMMENT_TIME_INTERVAL"]=$comment_time_interval;
			$_POST['options']['comment_time_interval']=$comment_time_interval;
			$configs["MOBILE_TPL_ENABLED"]=empty($_POST['options']['mobile_tpl_enabled'])?0:1;
			$configs["HTML_CACHE_ON"]=empty($_POST['options']['html_cache_on'])?false:true;
			$configs["kefu_tel"]=$_POST['options']['kefu_tel'];	
			$configs["seller_email"]=$_POST['options']['seller_email'];	
			$configs["notify_url"]=$_POST['options']['notify_url'];	
			$configs["return_url"]=$_POST['options']['return_url'];	
			$configs["successpage"]=$_POST['options']['successpage'];	
			$configs["errorpage"]=$_POST['options']['errorpage'];	
			$configs["partner"]=$_POST['options']['partner'];	
			$configs["key"]=$_POST['options']['key'];
				
			$configs["APP_ID"]=$_POST['options']['APP_ID'];
			$configs["SECRET_ID"]=$_POST['options']['SECRET_ID'];
			$configs["SECRET_KEY"]=$_POST['options']['SECRET_KEY'];
			$configs["DOMAIN"]=$_POST['options']['DOMAIN'];
			
			$configs["yuntype"]=$_POST['radio1'];
			$configs["wsviewname"]=$_POST['options']['wsviewname'];
			$configs["wsviewpass"]=$_POST['options']['wsviewpass'];
			
			$configs["wsviewname2"]=$_POST['options']['wsviewname2'];
			$configs["wsviewpass2"]=$_POST['options']['wsviewpass2'];
			
			$configs["livetype"]=$_POST['radio'];
			$configs["SecretKey"]=$_POST['options']['SecretKey'];
			$configs["SecretId"]=$_POST['options']['SecretId'];
			$configs["AppId"]=$_POST['options']['AppId'];
			
			$configs["mobileverify"]=$_POST['radio3'];
			$configs["alidayu_app_key"]=$_POST['options']['alidayu_app_key'];
			$configs["alidayu_app_secret"]=$_POST['options']['alidayu_app_secret'];
			$configs["smsFreeSignName"]=$_POST['options']['smsFreeSignName'];
			$configs["smsTemplateCode"]=$_POST['options']['smsTemplateCode'];
			
			sp_set_dynamic_config($configs);
				
			$data['option_name']="site_options";
			$data['option_value']=json_encode($_POST['options']);
			if($this->options_model->where("option_name='site_options'")->find()){
				$r=$this->options_model->where("option_name='site_options'")->save($data);
			}else{
				$r=$this->options_model->add($data);
			}
			
			$banned_usernames=preg_replace("/[^0-9A-Za-z_\x{4e00}-\x{9fa5}-]/u", ",", $_POST['cmf_settings']['banned_usernames']);
			$_POST['cmf_settings']['banned_usernames']=$banned_usernames;

			sp_set_cmf_setting($_POST['cmf_settings']);
			if ($r!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
			
		}
	}
	function alipay(){
	
	$this->display();
	
	}
	function password(){
		$this->display();
	}
	
	function password_post(){
		if (IS_POST) {
			if(empty($_POST['old_password'])){
				$this->error("原始密码不能为空！");
			}
			if(empty($_POST['password'])){
				$this->error("新密码不能为空！");
			}
			$user_obj = D("Common/Users");
			$uid=get_current_admin_id();
			$admin=$user_obj->where(array("id"=>$uid))->find();
			$old_password=$_POST['old_password'];
			$password=$_POST['password'];
			if(sp_compare_password($old_password,$admin['user_pass'])){
				if($_POST['password']==$_POST['repassword']){
					if(sp_compare_password($password,$admin['user_pass'])){
						$this->error("新密码不能和原始密码相同！");
					}else{
						$data['user_pass']=sp_password($password);
						$data['id']=$uid;
						$r=$user_obj->save($data);
						if ($r!==false) {
							$this->success("修改成功！");
						} else {
							$this->error("修改失败！");
						}
					}
				}else{
					$this->error("密码输入不一致！");
				}
	
			}else{
				$this->error("原始密码不正确！");
			}
		}
	}
	
	//清除缓存
	function clearcache(){
			
		sp_clear_cache();
		$this->display();
	}
	function updata(){
		$this->display();
		
	}
	function updata_post(){
		$url = "http://www.yxtcmf.com/yxtcmf2.1.2016.7.18.zip";
		$save_dir = "update/";
		$filename = basename($url);
		//return "正在下在更新文件...";
		$res = $this->getFile($url, $save_dir, $filename, 1);
		//return "正在解压...";
		$this->success("修改成功！");

		
	}
	function getFile($url, $save_dir = '', $filename = '', $type = 0) {
    if (trim($url) == '') {
        return false;
    }
    if (trim($save_dir) == '') {
        $save_dir = './';
    }
    if (0 !== strrpos($save_dir, '/')) {
        $save_dir.= '/';
    }
    if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
        return false;
    }
    if ($type) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);
        curl_close($ch);
    } else {
        ob_start();
        readfile($url);
        $content = ob_get_contents();
        ob_end_clean();
    }
    $size = strlen($content);
    $fp2 = @fopen($save_dir . $filename, 'a');
    fwrite($fp2, $content);
    fclose($fp2);
    unset($content, $url);
    return array(
        'file_name' => $filename,
        'save_path' => $save_dir . $filename
    );
}

	
}