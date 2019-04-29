<?php
namespace Teacher\Controller;
use Common\Controller\AdminbaseController;
class AdminCenterController extends AdminbaseController {

	function _initialize() {
		parent::_initialize();
		$this->users_obj = D("Common/users");
		$this->usercourse_obj = D("Common/usercourse");
		$this->course_obj = D("Common/course");
		$this->tixian_obj = D("Common/tixian");
		$this->application_obj = D("Common/application");
	} 
	function index(){
	   $count=$this->application_obj->count();
	   $page = $this->page($count, 10);
	   $teacher=$this->application_obj->limit($page->firstRow . ',' . $page->listRows)->order(array('id'=>'desc'))->select();
	   foreach($teacher as $n=> $val){
			$teacher[$n]['csnum']=$this->course_obj->order('id desc')->where('cs_teacher=\''.$val['user_id'].'\'')->count();
			$teacher[$n]['xynum']=$this->usercourse_obj->order('id desc')->where('teacher_id=\''.$val['user_id'].'\'')->count();
			$teacher[$n]['adminplate']=$this->users_obj->where('id=\''.$val['user_id'].'\'')->getField('adminplate');
			$teacher[$n]['folderid']=$this->users_obj->where('id=\''.$val['user_id'].'\'')->getField('folderid');
			
		}
		$this->assign("Page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("teacher",$teacher);
//		var_dump($teacher);exit;
		$this->display();
	}
	function tcourse(){
	   $t_id = intval(I("get.t_id"));
	   $count=$this->course_obj->where('cs_teacher=\''.$t_id.'\'')->count();
	   $page = $this->page($count, 10);
	   $data=$this->course_obj->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->where('cs_teacher=\''.$t_id.'\'')->select();
       foreach($data as $n=> $val){
			$data[$n]['xynum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count();
		}
		$this->assign("Page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
	    $this->assign("data",$data);
	    $this->display();
	}
	function tixian(){
		$tixian=$this->tixian_obj->select();
	    foreach($tixian as $n=> $val){
			$tixian[$n]['name']=$this->users_obj->where('id=\''.$val['u_id'].'\'')->getField('user_nicename');
		}
		 $this->assign("tixian",$tixian);
	     $this->display();
	}
	function trequery(){
	   $id = intval(I("post.id"));
	   $tixian=$this->tixian_obj->select();
	   $data['state']=1;
	   if($this->tixian_obj->where(array('id'=>$id))->save($data)) {
	    return json_encode($data);
	   }
	}
    function requery(){
	   $id = intval(I("get.t_id"));
	   $data= $this->application_obj->where(array('user_id'=>$id))->find();
	   $this->assign("data",$data);
	   $this->display();
	  }
    function requery_post(){
    if (IS_POST){
	   $id = intval(I("post.id"));
	   $tid = intval(I("post.tid"));
	   $radio=intval(I("post.radio"));
	   $state1['state']=$radio;
	   $state2['user_type']=3;
	   $state3['user_type']=2;
	   $folderName=$this->users_obj->where(array('id'=>$tid))->getField('mobile');
	    $token=$this->gettoken();
		$bizCode='IPVFAA';
		$url='http://open.wsview.com:8090/iWSViewPortalData?';
		$username=C('wsviewname');
		$postdata = "bizCode=".$bizCode."&userName=".$username."&token=".$token.'&pReqVFAA.folderName='.$folderName;
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
		$data = curl_exec($curl); 
		$xml = simplexml_load_string($data);
	    $res = json_decode(json_encode($xml),TRUE);
		$map['folderid']=$res['folderID'];
		$this->users_obj->where(array('id'=>$tid))->save($map);
	   if($radio==1){
	   	 $this->users_obj->where(array('id'=>$tid))->save($state2);
	   	 $this->application_obj->where(array('id'=>$id))->save($state1);
	   	 $this->success("设置成功！");
	   }else{
	   	 $this->users_obj->where(array('id'=>$tid))->save($state3);
	     $this->application_obj->where(array('id'=>$id))->save($state1);
	     $this->success("设置成功！");
	   }
	  
	  }	
    }
	function creatfolder(){
		$tid = intval(I("get.t_id"));
		$folderName=$this->users_obj->where(array('id'=>$tid))->getField('mobile');
		$token=$this->gettoken();
		$bizCode='IPVFAA';
		$url='http://open.wsview.com:8090/iWSViewPortalData?';
		$username=C('wsviewname');
		$postdata = "bizCode=".$bizCode."&userName=".$username."&token=".$token.'&pReqVFAA.folderName='.$folderName;
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
		$data = curl_exec($curl); 
		$xml = simplexml_load_string($data);
	    $res = json_decode(json_encode($xml),TRUE);
		
		if($res['resultCode']==0){
			$map['folderid']=$res['folderID'];
		    $this->users_obj->where(array('id'=>$tid))->save($map);
			$this->success("创建成功！");
		}else{
			$this->error("创建失败！");
		}
	}
	function folder(){
		$t_id = intval(I("get.t_id"));
		$folderName=$this->users_obj->where(array('id'=>$t_id))->getField('mobile');
		$folderID=$this->users_obj->where(array('id'=>$t_id))->getField('folderid');
		$this->assign("folderName",$folderName);
		$this->assign("folderID",$folderID);
		$this->display();
	}
	function setbili(){
		$alipaybili=C('alipaybili');
		$cardbili=C('cardbili');
		$this->assign("alipaybili",$alipaybili);
		$this->assign("cardbili",$cardbili);
		$this->display();
	}
	function setbili_post(){
	 if (IS_POST){
		$config['alipaybili']=I('post.alipaybili');
		$config['cardbili']=I('post.cardbili');
	    sp_set_dynamic_config($config);
	 }
	   $this->success("设置成功！");
	 }
	 function adminforum(){
		 $id=I('get.t_id');
		 $state=$this->users_obj->where(array('id'=>$id))->getField('adminplate');
		 if($state==0){
			 $data['adminplate']=1;
			 if($this->users_obj->where(array('id'=>$id))->save($data)){
				 $this->success("设置成功！");
			 }else{
				 $this->error("设置失败！");
			 }
			 
		 }else{
			  $data['adminplate']=0;
			 if($this->users_obj->where(array('id'=>$id))->save($data)){
				 $this->success("设置成功！");
			 }else{
				 $this->error("设置失败！");
			 }
		 }
		 
	 }
    function gettoken(){
		$bizCode='IPUQXC';
		$username=C('wsviewname');
		$password=MD5(C('wsviewpass'));
		$url='http://open.wsview.com:8090/iWSViewPortalData?';
		$postdata = "bizCode=".$bizCode."&pReqQXC.userName=".$username."&pReqQXC.password=".$password; 
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
		$data = curl_exec($curl); 
		$xml = simplexml_load_string($data);
		$data = json_decode(json_encode($xml),TRUE);
		return($data['token']);
		curl_close($curl);
	}
	
}