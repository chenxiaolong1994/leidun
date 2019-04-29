<?php
namespace Common\Model;
use Common\Model\CommonModel;
class CardModel extends CommonModel{

	
    protected $_auto=array(
       //array 填充的字段，填充的内容，填充条件，附加规则
    array('addtime','getDate',1,'callback'),
       );

    function getDate(){
		return date('Y-m-d H:i:s');
	  }
       
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
}

