<?php
namespace Course\Controller;
use Common\Controller\HomeBaseController; 
class OrderController extends HomeBaseController {
	protected $course_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->course_obj = D("Common/Course");
		$this->order_obj = D("Common/Order");
		$this->user_obj = D("Common/Users");
		$this->user_course_obj = D("Common/User_course");
		
	}	
	public function create(){
		$targetId=I("post.targetId");
		$totalPrice=I("post.totalPrice");
		$userId=get_current_userid();
		$shouldPayMoney=I("post.totalPrice");
		$coursename=I("post.coursename");
		$out_trade_no = date('Ymdhms').rand(100,999);
		$data['user_id']=get_current_userid();
		$data['course_id']=$targetId;
		$data['money']=$shouldPayMoney;
		$data['state']=0;
		$data['order']=$out_trade_no;
		$this->order_obj->add($data);
		$this->assign("courseId",$targetId);
		$this->assign("totalPrice",$totalPrice);
		$this->assign("money",$shouldPayMoney);
		$this->assign("userId",$userId);
		$this->assign("coursename",$coursename);
		$this->assign("order",$out_trade_no);
		$this->display();
		
	}
	public function pay(){
	    $data['user_id']=I("post.user_id");
		$data['course_id']=I("post.course_id");
		$data['money']=I("post.money");
		$data['order']=I("post.order");
		$map['user_id']=I("post.user_id");
		$map['course_id']=I("post.course_id");
		$userinfo=$this->user_obj->where('id='.$data['user_id'])->find();
		$result=$this->user_course_obj->where($map)->find();
		if($result){
			$this->error('您已经购买过此课程，请不要重复购买！');
		}else{
		    if($userinfo['money']<$data['money']){
	           $this->error('账户余额不足，请充值！');
		     }else{
		       $adddata['user_id']=I("post.user_id");
		       $adddata['course_id']=I("post.course_id");
		       $adddata['buy_time']=date_create();
		       $result1=$this->user_course_obj->data($adddata)->add();
		       
		       $savedata['money']=($userinfo['money']-I("post.money"));
		       $savedata['used_money']=($userinfo['used_money']+I("post.money"));
		       dump($savedata);
		       $result2=$this->user_obj->data($savedata)->save();
		       
		       $ordersave['state']=1;
		       $result3=$this->order_obj->where('order='.$data['order'])->data($ordersave)->save();
		       
		     }
	    }
	   
	}
}