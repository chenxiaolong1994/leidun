<?php
namespace Course\Controller;
use Common\Controller\AdminbaseController;
class AdminOrderController extends AdminbaseController {

	protected $order_obj;
	function _initialize() {
		parent::_initialize();
		$this->order_obj = D("Common/Order");

	}
	function index(){
		$type=0;
		if(!empty($_REQUEST["type"])){
			$type=intval($_REQUEST["type"]);
		}
		$where_ands=empty($type)?array("state>=$type"):array("state=$type");
		$fields=array(
				'start_time'=> array("field"=>"addtime","operator"=>">"),
				'end_time'  => array("field"=>"addtime","operator"=>"<"),
				'keyword'  => array("field"=>"order","operator"=>"like"),
		);

		if(IS_POST){
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_POST[$param];
					$_GET[$param]=$get;
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_GET[$param];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}
		$where= join(" and ", $where_ands);
		$count=$this->order_obj->where($where)->count();
		$page = $this->page($count, 30);
		$order = $this->order_obj->order(array("id"=>"asc"))->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign("page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("order", $order);
		$this->display();
	}

}