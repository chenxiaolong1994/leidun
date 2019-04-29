<?php
namespace Common\Model;
use Common\Model\CommonModel;
class SectionModel extends CommonModel{
  protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('sc_name', 'require', '课件名称不能为空！', 1, 'regex', 1),
	);
	
  protected $_auto=array(
       //array 填充的字段，填充的内容，填充条件，附加规则
    array('addtime','getDate',1,'callback'),
    array('state',1),
  //  array('is_free',0),

       );

    function getDate(){
		return date('Y-m-d H:i:s');
	  }
       
  protected function _before_write(&$data) {
		parent::_before_write($data);
	}
}