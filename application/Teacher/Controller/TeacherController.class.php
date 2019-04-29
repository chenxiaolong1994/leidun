<?php
namespace Teacher\Controller;
use Common\Controller\HomebaseController;
require('./Expand/cos/include.php');
use Qcloud_cos\Auth;
use Qcloud_cos\Cosapi;
class TeacherController extends HomebaseController {
	function index(){
		$this->user_obj = D("Common/Users");
		$count=$this->user_obj->where(array('user_type'=>3))->count();
		$page = $this->page($count, 12);
		$teacher=$this->user_obj->limit($page->firstRow . ',' . $page->listRows)->where(array('user_type'=>3))->select();
		$this->assign("name",'教师中心');
		$this->assign("Page", $page->show('Admin'));
		$this->assign("teacher",$teacher);
		$this->display();
		
	}
    function about(){
		if(isset($_GET['id'])){
			$this->user_obj = D("Common/Users");
			$id = intval(I("get.id"));
			$teacher=$this->user_obj->where(array('id'=>$id))->find();
			$this->assign('teacher',$teacher);
			$name=$teacher['user_nicename'].'老师个人中心';
			$this->assign('name',$name);
		} 
		
		$this->display();
	}
	function teach(){
		if(isset($_GET['id'])){
			$this->user_obj = D("Common/Users");
			$this->course_obj = D("Common/Course");
			$this->usercourse_obj = D("Common/Usercourse");
			$id = intval(I("get.id"));
			$teacher=$this->user_obj->where(array('id'=>$id))->find();
			$course=$this->course_obj->where(array('cs_teacher'=>$id))->select();
			
			foreach($course as $n=> $val){
				$course[$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
				$course[$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
				$this->assign('course',$course);
				$this->assign('teacher',$teacher);
		   }
		}
		 $name=$teacher['user_nicename'].'老师所教课程';
		 $this->assign('teacher',$teacher);
	     $this->assign('name',$name);
		 $this->display();
	}
	function learn(){
		if(isset($_GET['id'])){
			$this->user_obj = D("Common/Users");
			$this->course_obj = D("Common/Course");
			$id = intval(I("get.id"));
			$teacher=$this->user_obj->where(array('id'=>$id))->find();
			$course=$this->course_obj->where(array('cs_teacher'=>$id))->select();
			$this->assign('course',$course);
			$this->assign('teacher',$teacher);
		}
		$this->display();
	}
	function favorited(){
		
		$this->display();
	}
   
	
}

