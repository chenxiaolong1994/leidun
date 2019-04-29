<?php
namespace User\Controller;
use Common\Controller\MemberbaseController;
class SettingController extends MemberbaseController {
	protected $users_model;
	function _initialize(){
		parent::_initialize();
		$this->users_model=D("Common/Users");
	}
	public function index() {
		$userid=sp_get_current_userid();
		$user=$this->users_model->where(array("id"=>$userid))->find();
		
		$this->assign($user);
    	$this->display();
    }
    public function setting_post(){
        if(IS_POST){
         $userid=sp_get_current_userid();
         $data['user_nicename']=$_POST['user_nicename'];
         $data['sex']=$_POST['sex'];
         $data['mobile']=$_POST['mobile'];
         $data['prov']=$_POST['prov'];
         $data['city']=$_POST['city'];
         $data['dist']=$_POST['dist'];
         $data['birthday']=$_POST['birthday'];
         $data['signature']=$_POST['signature'];
         $data['weiixn']=$_POST['weiixn'];
         $data['qq']=$_POST['qq'];
		 $data['zhicheng']=$_POST['zhicheng'];
		 $data['tcProfile']=$_POST['tcProfile'];
         $result=$this->users_model->where(array("id"=>$userid))->save($data);
			if ($result) {
				
					$this->success("修改成功！");
				}else{
					$this->error("修改失败！");
				}			
        }
       
    }
	public function repass(){
		$this->display(':repass');
	}
	function repasspost(){
		$mobile_verify=$_POST['mobile_verify'];
		$password=$_POST['password'];
		$mobile=$_POST['mobile'];
		if(!preg_match('/^1([0-9]{9})/',$mobile)){
	        $this->error("请输入正确的手机号码！"); 
	    }  
	    if(strlen($password) < 5 || strlen($password) > 20){
	        $this->error("密码长度至少5位，最多20位！");
	    }
		if($mobile_verify !=$_SESSION['mobile_verify']){
			$this->error("手机验证码不正确!");
		}
		$users_model=M("Users");
		$data['user_pass']=sp_password($password);
	    $where['mobile']=$mobile;       
		if($users_model->where($where)->save($data)){
			$this->success("密码重置成功！",U("User/Login/index"));
		}else{
			$this->error("密码重置失败!");
		}
	}
}