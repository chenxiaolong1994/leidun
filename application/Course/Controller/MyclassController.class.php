<?php
namespace Course\Controller;
use Common\Controller\HomeBaseController;
class MyclassController extends HomeBaseController {
	protected $course_obj;
	protected $courseview_obj;
	protected $coursetype_obj;

	function _initialize() {
		parent::_initialize();
		$this->course_obj = D("Common/Course");
		$this->courseview_obj = D("Common/CourseView");
		$this->coursetype_obj = D("Common/Coursetype");
		$typelist=$this->coursetype_obj->where('parent=0')->select();
		foreach($typelist as $n=> $val){
			$typelist[$n]['voo']=$this->coursetype_obj->order('listorder desc')->where('parent=\''.$val['term_id'].'\'')->select();
		}
		$this->assign('list',$typelist);
	}

	public function index(){

		$this->display();
	}
	public function study(){
		$this->display();
	}
	public function studying(){
		$this->display();
	}
}