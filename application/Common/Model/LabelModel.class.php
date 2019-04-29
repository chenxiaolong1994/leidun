<?php
namespace Common\Model;
use Common\Model\CommonModel;
class LabelModel extends CommonModel {
	
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('labelname', 'require', '标签名称不能为空！', 1, 'regex', 3),
			array('c_id', 'require', '请选择分类！', 1, 'regex', 3),
	);
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	

}