<?php
namespace Forum\Controller;
use Common\Controller\HomebaseController;

class PlateController extends HomebaseController {
	function _initialize() {
		parent::_initialize();
		$this->forum_plate_obj = D("Common/Forum_plate");
		$this->forum_topic_obj = D("Common/Forum_topic");
		$this->forum_reply_obj = D("Common/Forum_reply");
		$this->forum_praisal_obj = D("Common/Forum_praisal");
		$this->user_obj = D("Common/Users");
		$usertype=$this->user_obj->where(array('id'=>sp_get_current_userid()))->getField('user_type');
		$adminplate=$this->user_obj->where(array('id'=>sp_get_current_userid()))->getField('adminplate');
		$this->assign("usertype",$usertype);				
		$this->assign("adminplate",$adminplate);
	}
	function index(){
		
		$plate=$this->forum_plate_obj->select();
		$count=$this->forum_topic_obj->count();
		$page = $this->page($count, 15);
		$topic=$this->forum_topic_obj->order(array('istop'=>'desc','iscream'=>'desc','replytime'=>'desc','id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
		foreach ($plate as  $n=> $val) {
			$plate[$n]['count']=$this->forum_topic_obj->where(array('plateid'=>$val['id']))->count();
		}
		foreach ($topic as  $n=> $val) {
			$topic[$n]['username']=$this->user_obj->where(array('id'=>$val['userid']))->getField('user_nicename');
			$topic[$n]['userpic']=$this->user_obj->where(array('id'=>$val['userid']))->getField('avatar');
			$topic[$n]['thread']=$this->forum_plate_obj->where(array('id'=>$val['plateid']))->getField('name');
			$topic[$n]['reply']=$this->forum_reply_obj->where(array('topicid'=>$val['id']))->count();
			$topic[$n]['time']=lasttime(strtotime(date('Y-m-d H:i:s'))-strtotime($val['addtime']));
			
		}	
		$this->assign('topic',$topic);
		$this->assign("name",'交流论坛');
		$this->assign("plate",$plate);
		$this->assign("Page", $page->show('Admin'));
		$this->display(); 
		
	}
	function add(){
		
		$this->display(); 
	}
	function addpost(){
		if (IS_POST) {
			$data = $this->forum_plate_obj->create();
			$data['brief']=htmlspecialchars_decode($data['brief']);
			if($data['name']==''){
				$this->error("板块名称不能为空！");
			}
			
			if($data['brief']==''){
				$this->error("板块描述不能为空！");
			}
			if($this->forum_plate_obj->add($data)){
				$this->success("添加成功！",U("Forum/Plate/index"));
			}else{
				$this->error("添加失败！");
			}
			
		}
		
	}
	function del(){
		$id=  I("get.id");
		if($data = $this->forum_plate_obj->where(array('id'=>$id))->delete()){
			$this->success("删除成功！",U("Forum/Plate/index"));
		}
	}
	function thread(){
		 $id=  I("get.id");
		 $data = $this->forum_plate_obj->where(array('id'=>$id))->find();
		 $topic=$this->forum_topic_obj->order(array('istop'=>'desc','iscream'=>'desc','replytime'=>'desc','id'=>'desc'))->where(array('plateid'=>$id))->select();
		 foreach ($topic as  $n=> $val) {
			$topic[$n]['username']=$this->user_obj->where(array('id'=>$val['userid']))->getField('user_nicename');
			$topic[$n]['userpic']=$this->user_obj->where(array('id'=>$val['userid']))->getField('avatar');
			$topic[$n]['reply']=$this->forum_reply_obj->where(array('topicid'=>$val['id']))->count();
			$topic[$n]['time']=lasttime(strtotime(date('Y-m-d H:i:s'))-strtotime($val['addtime']));
		 }

		 $this->assign('plate',$data);
		 $this->assign('name',$data['name']);
		 $this->assign('topic',$topic);
		 $this->display(); 
	}
	function threadcreate(){
		$plateid=intval(I("get.plateid"));
		$this->assign('plateid',$plateid);
		$this->display(); 
	}
	function threadcreatepost(){
		if (IS_POST) {
			$data = $this->forum_topic_obj->create();
			$data['topiccontent']=htmlspecialchars_decode($data['topiccontent']);
			$data['userid']=sp_get_current_userid();
			$data['addtime']=date('Y-m-d H:i:s');
			if($data['userid']==''){
				$this->error("请登陆！",U("User/Login/index"));
			}
			if($data['topictltle']==''){
				$this->error("标题不能为空！");
			}
			
			if($data['topiccontent']==''){
				$this->error("内容不能为空！");
			}
			if($this->forum_topic_obj->add($data)){
				$this->success("发布成功！",U("Forum/Plate/index"));
			}else{
				$this->error("发布失败！");
			}
			
		}
	}
	function topic(){
		$id=  I("get.id");
		$topic=$this->forum_topic_obj->where(array('id'=>$id))->find();
		$count=$this->forum_reply_obj->where(array('topicid'=>$id))->count();
		$page = $this->page($count,20);
		$reply=$this->forum_reply_obj->where(array('topicid'=>$id))->order(array('id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
		foreach ($reply as  $n=> $val) {
			$reply[$n]['username']=$this->user_obj->where(array('id'=>$val['userid']))->getField('user_nicename');
			$reply[$n]['userpic']=$this->user_obj->where(array('id'=>$val['userid']))->getField('avatar');
			$reply[$n]['time']=lasttime(strtotime(date('Y-m-d H:i:s'))-strtotime($val['addtime']));
			$reply[$n]['voo']=$this->forum_praisal_obj->where(array('replyid'=>$val['id']))->select();
		 }
		$topic['user']=$this->user_obj->where(array('id'=>$topic['userid']))->getField('user_nicename');
		$topic['plate']=$this->forum_plate_obj->where(array('id'=>$topic['plateid']))->getField('name');
		$this->forum_topic_obj->where(array('id'=>$id))->setInc('hits', 1);
		$this->assign('topic',$topic);
		$this->assign('userid',sp_get_current_userid());
		$this->assign('reply',$reply);
		$this->assign("name",$topic['topictltle']);
		$this->assign("count",$count);
		$this->assign("Page", $page->show('Admin'));
		$this->display();
	}
	function reply(){
		if (IS_POST) {
			
			$data = $this->forum_reply_obj->create();
			$data['content']=htmlspecialchars_decode($data['content']);
			$data['userid']=sp_get_current_userid();
			$data['addtime']=date('Y-m-d H:i:s');
			$replytime['replytime']=date('Y-m-d H:i:s');
			$this->forum_topic_obj->where(array('id'=>$data['topicid']))->save($replytime);
			if($data['userid']==''){
				$this->error("请登陆！",U("User/Login/index"));
			}
			if($data['content']==''){
				$this->error("回复内容不能为空！");
			}
			if($this->forum_reply_obj->add($data)){
				$this->success("回复成功！",U("Forum/Plate/topic",array('id'=>$data['topicid'])));
			}else{
				$this->error("回复失败！");
			}
			
		}
		
	}
	function iscream(){
		if(IS_POST){ 
			$id = (int)$_POST['id']; 
			$data=$this->forum_topic_obj->where(array('id'=>$id))->find();
			if($data['iscream']==0){
				$data['iscream']=1;
			}else{
				$data['iscream']=0;
			}
			if($this->forum_topic_obj->save($data)){
				return json_encode($data['iscream']);
			}
		 
		}
	}
	function istop(){
		if(IS_POST){ 
			$id = (int)$_POST['id']; 
			$data=$this->forum_topic_obj->where(array('id'=>$id))->find();
			if($data['istop']==0){
				$data['istop']=1;
			}else{
				$data['istop']=0;
			}
			if($this->forum_topic_obj->save($data)){
				return json_encode($data['istop']);
			}
		 
		}
	}
	function edit(){
		$id=  I("get.id");
		$data = $this->forum_plate_obj->where(array('id'=>$id))->find();
		$this->assign('data',$data);
		$this->display(); 
		
	}
   function editpost(){
		if (IS_POST) {
			$data = $this->forum_plate_obj->create();
			$data['brief']=htmlspecialchars_decode($data['brief']);
			if($data['name']==''){
				$this->error("板块名称不能为空！");
			}
			
			if($data['brief']==''){
				$this->error("板块描述不能为空！");
			}
			if($this->forum_plate_obj->where(array('id'=>$data['id']))->save($data)){
				$this->success("修改成功！",U("Forum/Plate/index"));
			}else{
				$this->error("修改失败！");
			}
			
		}
		
	}
	function delreply(){
		$id=  I("get.id");
		if ($this->forum_reply_obj->where(array('id'=>$id))->delete()) {
				$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	function deltopic(){
		$id=  I("get.id");
		$threadid=$this->forum_topic_obj->where(array('id'=>$id))->getField('plateid');
		if ($this->forum_topic_obj->where(array('id'=>$id))->delete()) {
				$this->success("删除成功！",U("Forum/Plate/thread",array('id'=>$threadid)));
		}else {
			$this->error("删除失败！");
		}
	}
	function edittopic(){
		$id=  I("get.id");
		$data = $this->forum_topic_obj->where(array('id'=>$id))->find();
		$this->assign('data',$data);
		$this->display(); 
	}
	function edittopicpost(){
		if (IS_POST) {
			$data = $this->forum_topic_obj->create();
			$id=I('post.id');
			$data['topiccontent']=htmlspecialchars_decode($data['topiccontent']);
			if($data['topictltle']==''){
				$this->error("标题不能为空！");
			}
			
			if($data['topiccontent']==''){
				$this->error("内容不能为空！");
			}
			if($this->forum_topic_obj->where(array('id'=>$id))->save($data)){
				$this->success("编辑成功！",U("Forum/Plate/topic",array('id'=>$id)));
			}else{
				$this->error("编辑失败！");
			}
			
		}
	}
	function praisal(){
		if (IS_POST) {
			$data = $this->forum_praisal_obj->create();
			$data['content']=htmlspecialchars_decode($data['content']);
			$data['userid']=sp_get_current_userid();
			$data['addtime']=date('Y-m-d H:i:s');
			if($data['userid']==''){
				$this->error("请登陆！",U("User/Login/index"));
			}
			if($data['content']==''){
				$this->error("回复内容不能为空！");
			}
			if($this->forum_praisal_obj->add($data)){
				$this->success("回复成功！",U("Forum/Plate/topic",array('id'=>$data['topicid'])));
			}else{
				$this->error("回复失败！");
			}
			
		}
	}
	function delpraisal(){
		$id=  I("get.id");
		if ($this->forum_praisal_obj->where(array('id'=>$id))->delete()) {
				$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
}

