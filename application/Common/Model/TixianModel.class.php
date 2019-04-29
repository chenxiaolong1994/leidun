<?php
namespace Common\Model;
use Common\Model\CommonModel;
class TixianModel extends  CommonModel{
	
	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('money', 'require', '提现金额不能为空！', 1, 'regex', 1),
			array('turename', 'require', '真实姓名不能为空！', 1, 'regex', 1),
			array('count', 'require', '提款账户不能为空！', 1, 'regex', 1),
	);
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
}