<?php
namespace Course\Controller;
use Common\Controller\AdminbaseController;
class AdminLabelController extends AdminbaseController {
	
	protected $coursetype_obj;
	protected $label_obj;
	function _initialize() {
		parent::_initialize();
		$this->coursetype_obj = D("Common/Coursetype");
		$this->label_obj = D("Common/Label");
		$this->assign("taxonomys",$this->taxonomys);
	}
	function index(){
		$label = $this->label_obj->order(array("id"=>"asc"))->select();
		
	    foreach($label as $n=> $val){
	    	$label[$n]['typename']=$this->coursetype_obj->where(array('term_id'=>$label[$n]['c_id']))->getfield(name);
		}
		$this->assign("label", $label);
		$this->display();  
	}
	
	function add(){
	 	$parentid = intval(I("get.parent"));
	 	$tree = new \PathTree();
	 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
	 	$tree->nbsp = '---';
	 	$result = $this->coursetype_obj->order(array("path"=>"asc"))->select();
	 	$tree->init($result);
	 	$tree=$tree->get_tree();
	 	$this->assign("terms",$tree);
	 	$this->assign("parent",$parentid);
	 	$this->display();
	}
    function select(){
       $c_id=I("get.id");
       $label = $this->label_obj->order(array("id"=>"asc"))->where(array('c_id'=>$c_id))->select();
       $json_string = json_encode($label);
       echo $json_string;
    }
	function add_post(){
		if (IS_POST) {
			if ($data=$this->label_obj->create()) {
			
				if ($this->label_obj->add()!==false) {
					$this->success("添加成功！",U("AdminLabel/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->label_obj->getError());
			}
		}
	}
	
	public function listorders() {
		$status = parent::_listorders($this->label_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	/**
	 *  删除
	 */
	public function delete() {
		$id = intval(I("get.id"));
		if ($this->label_obj->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
}