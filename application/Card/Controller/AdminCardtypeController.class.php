<?php
namespace Card\Controller;
use Common\Controller\AdminbaseController;
class AdminCardtypeController extends AdminbaseController {
	
	protected $cardtype_obj;
	protected $taxonomys=array("article"=>"文章","picture"=>"图片");
    function _initialize() {
		parent::_initialize();
		$this->cardtype_obj = D("Common/Cardtype");
	}
	function index(){
		$cardtype_data = $this->cardtype_obj->order(array("id"=>"asc"))->select();
		$this->assign("cardtype_data", $cardtype_data);
		$this->display();    
	}
	
	function add(){
	 	
	 	$this->display();
	}
	
	function add_post(){
		if (IS_POST) {
			if ($this->cardtype_obj->create()) {
				if ($this->cardtype_obj->add()!==false) {
					$this->success("添加成功！",U("AdminCardtype/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->cardtype_obj->getError());
			}
		}
	}
	
	function edit(){
		$id = intval(I("get.id"));
		$data=$this->cardtype_obj->where(array("id" => $id))->find();
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->cardtype_obj->create()) {
				if ($this->cardtype_obj->save()!==false) {
					$this->success("修改成功！");
				} else {
					$this->error("修改失败！");
				}
			} else {
				$this->error($this->cardtype_obj->getError());
			}
		}
	}
	
	public function delete() {
	   if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			if ($this->cardtype_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}

		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->cardtype_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
}