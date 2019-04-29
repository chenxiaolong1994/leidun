<?php
namespace Course\Controller;
use Common\Controller\AdminbaseController;
class AdminMaterialController extends AdminbaseController {
	protected $material;
	protected $course_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->material_obj = D("Common/Material");
        $this->course_obj = D("Common/Course");
	}
	function index(){
		$this->_lists();
		$this->display();
	}
    function index_cs(){
		$id=  intval(I("get.cs_id"));
		$cs_name=$this->course_obj->where("id=$id")->getField('cs_name');
		$ma_data=$this->material_obj->where("cs_id=$id")->order("id ASC")->select();
	    $this->assign("ma_data",$ma_data);
	    $this->assign("cs_data",$cs_name);
		$this->display();
    }
	
	function add(){
		$cs_id = intval(I("get.cs_id"));
		$sc_id = intval(I("get.sc_id"));
		$this->assign("cs_id",$cs_id);
		$this->assign("sc_id",$sc_id);
		$this->display();
	}
	
	function add_post(){
		if (IS_POST) {
			$data = $this->material_obj->create();
			if($data['name']==null) {
				$this->error("名称不能为空！");
			}
		    if($data['url']==null) {
				$this->error("下载地址不能为空！");
			}
			$data['downname']=$_SESSION["access_name"];
			$result=$this->material_obj->add($data);
			if ($result) {
				    session("access_url",null);
				    session("access_name",null);
					$this->success("添加成功！");
				}else{
					$this->error("添加失败！");
				}			
			 
		}
	}
	
	public function edit(){
		$id=  intval(I("get.id"));
		$data=$this->material_obj->where(array('id'=>$id))->find();
		$this->assign("data",$data);
		$this->display();
	}
	
	public function edit_post(){
		if (IS_POST) {
			$id=I('POST.id');
			$data = $this->material_obj->create();
			
			$result=$this->material_obj->where(array('id'=>$id))->save($data);
			if ($result!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		}
	}
	
	

	function delete(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			if ($this->material_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}

		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->material_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
	
	
}