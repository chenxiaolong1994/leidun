<?php
namespace Common\Model;
use Common\Model\CommonModel;
class MaterialModel extends CommonModel{
    protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('name', 'require', '名称不能为空！', 1, 'regex', 3),
			array('url', 'require', '下载地址不能为空！', 1, 'regex', 3),
	);
	 protected $_auto=array(
       array('addtime','getDate',1,'callback'),
       );
     function getDate(){
		return date('Y-m-d H:i:s');
	  }
	 protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
}