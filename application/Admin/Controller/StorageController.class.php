<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class StorageController extends AdminbaseController{
	
	function _initialize() {
		parent::_initialize();
		$this->storage_model = D("Common/Config");
	}
	function index(){
		$data=$this->storage_model->where(array('id'=>1))->find();
		$this->assign('data', $data);
		$this->display();
	}
	
	function setting_post(){
		if(IS_POST){
			$data['type']=$_POST['type'];
			$data['SecretId']=$_POST['SecretId'];
			$data['SecretKey']=$_POST['SecretKey'];
			$result=$this->storage_model->where(array('id'=>1))->save($data);
			exit();
				if($result!==false){
					$this->success("设置成功！");
				}else{
					$this->error("设置出错！");
				}
			}else{
				$this->error("文件存储类型不存在！");
			}
		
		}

}