<?php
namespace Exam\Controller;
use Common\Controller\HomebaseController;
class BaomingController extends HomebaseController {

	function _initialize() {
	  parent::_initialize();
	  $this->check_login();
	  $this->baoming_obj = D("Common/Exam_baoming");
	  $this->coursetype_obj = D("Common/Coursetype");

	}
	
    function add(){
		$userid=sp_get_current_userid();
		if($result=$this->baoming_obj->where(array('userid'=>$userid))->find()){
			$result['toptype']=$this->coursetype_obj->where(array('term_id'=>$result['top_id']))->getField('name');
			$result['childtype']=$this->coursetype_obj->where(array('term_id'=>$result['type_id']))->getField('name');
			$this->assign("result", $result);
			$this->display('result');
		}else{
			$type = $this->coursetype_obj->where(array('parent'=>0))->order(array("listorder"=>"asc"))->select();
			$this->assign("type", $type);
			$this->display();
		}
		
	}
	function add_post(){
		if (IS_POST) {
			$data = $this->baoming_obj->create();
			if($data['top_id']==''){
				$this->error("请选择报名类别！");
			};
			if($data['type_id']==''){
				$this->error("请选择报名年级！");
			};
			if($data['username']==''){
				$this->error("请填写真实姓名！");
			};
			if($data['sex']==''){
				$this->error("请选择性别！");
			};
			if($data['mobilephone']==''){
				$this->error("请填写手机号码！");
			};
			if($data['fixedphone']==''){
				$this->error("请填写固定电话！");
			};
			if($data['idnumber']==''){
				$this->error("请填写身份证号！");
			};
			if($data['qq']==''){
				$this->error("请填写QQ号！");
			};
			if($data['patriarchal']==''){
				$this->error("请填写家长姓名！");
			};
			if($data['patriarchalphone']==''){
				$this->error("请填写家长电话！");
			};
			$data['userid']=sp_get_current_userid();
			$data['addtime']=date('Y-m-d H:i:s');
            if($this->baoming_obj->add($data)){
				 $this->success("报名成功！",U("Exam/Baoming/add"));
			}else{
				$this->error("报名失败！");
			}		  
		}
		
	}
	function getsontype(){
		$parentid=I("get.id");
		$sontype=$this->coursetype_obj->where(array('parent'=>$parentid))->order(array("listorder"=>"asc"))->select();
		$json_string = json_encode($sontype);
        echo $json_string;
	}
}