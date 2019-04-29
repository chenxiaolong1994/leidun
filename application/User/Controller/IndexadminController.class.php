<?php

namespace User\Controller;
use Common\Controller\AdminbaseController;
class IndexadminController extends AdminbaseController {
    function index(){
    	
		$where_ands=array("user_type >= 1");
		$fields=array(
				'start_time'=> array("field"=>"cs_addtime","operator"=>">"),
				'end_time'  => array("field"=>"cs_addtime","operator"=>"<"),
				'keyword'  => array("field"=>"user_login","operator"=>"like"),
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
    	$users_model=M("Users");
		 //var_dump($where);exit;
    	$count=$users_model->where($where)->count();
    	$page = $this->page($count, 20);
    	$lists = $users_model
    	->where($where)
    	->order("create_time DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display(":index");
    }
    
    function ban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Users")->where(array("id"=>$id,"user_type"=>2))->setField('user_status','0');
    		if ($rst) {
    			$this->success("会员拉黑成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员拉黑失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    
    function cancelban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Users")->where(array("id"=>$id,"user_type"=>2))->setField('user_status','1');
    		if ($rst) {
    			$this->success("会员启用成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员启用失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
   function detailed(){
     	$id=I('get.id');
     	$users_model=M("Users");   	
    	$lists = $users_model->where(array("id"=>$id))->find();
    	$this->assign('lists', $lists);
        $this->display(":detailed");
   } 
   function buycourse(){
      $this->course_obj = D("Common/Course");
      $this->section_obj = D("Common/Section");
      $id=I('get.id');
      $model=M("Usercourse"); 
      $count=$model->where(array('user_id'=>$id))->count();
      $page = $this->page($count, 10);
      $lists= $model->where(array('user_id'=>$id))->limit($page->firstRow . ',' . $page->listRows)->select();
      foreach($lists as $n=> $val){
			 $lists[$n]['coursename']=$this->course_obj->where('id=\''.$val['course_id'].'\'')->getField('cs_name');
		     $urlArr = explode("|",$lists[$n]['studied']);  
             $jnum=count( $urlArr);
             $cs_id=$lists[$n][course_id];
             $znum=$this->section_obj->where(array("cs_id"=>$cs_id))->count();
             $lists[$n]['bili'] = intval(($jnum/$znum)*100);
      }
     
      $this->assign('lists', $lists);
      $this->display(":buycourse");
   }
   function repass(){
       $id=I('get.id');
       $this->assign('id', $id);
       $this->display(":repass");
   }
   function repass_post(){
       $id=I('post.id');
       $pass=I('post.pass');
	   if(empty($pass)){
		   $this->error('请输入密码！');
	   }
       $newpass=sp_password($pass);
       $rst = M("Users")->where(array("id"=>$id))->setField('user_pass',$newpass);
    		if ($rst) {
    			$this->success("重置成功！");
    		} else {
    			$this->error('重置失败！');
    		}
   }
   function addmoney(){
     $id=I('get.id');
     $this->assign('id', $id);
     $this->display(":addmoney");
   }
   function addmoney_post(){
       $id=I('post.id');
       $coin=I('post.coin');
	   if(empty($coin)){
		   
		   $this->error('金额不能为空！');
	   }
	   $ycoin=M("Users")->where(array("id"=>$id))->getField('coin');
       $rst = M("Users")->where(array("id"=>$id))->setField('coin',$coin+$ycoin);
    		if ($rst) {
    			$this->success("设置成功！");
    		} else {
    			$this->error('设置成功！');
    		}
   }
   function presentcourse(){
	    $this->course_obj = D("Common/Course");
		$this->coursetype_obj = D("Common/Coursetype");
		$this->courseview_obj = D("Common/CourseView");
	   $id=I('get.id');
	   $this->_getTree();
	   $term_id = intval(I("get.term"));
	   $term=$this->course_obj->where("ty_id=$term_id")->find();
	   $this->assign("term",$term);
	   $this->assign('id', $id);
	   $this->assign('course', $course);
	   $this->display(":presentcourse");
   }
   function presentcourse_post(){
	   $this->course_obj = D("Common/Course");
	   $this->usercourse = D("Common/Usercourse");
	   $userid=I('post.userid');
	   $courseid=I('post.courseid');
	   $courseinfo=$this->course_obj->where("id=$courseid")->find();
	   $data['user_id']=$userid;
	   $data['course_id']=$courseid;
	   $data['teacher_id']=$courseinfo['cs_teacher'];
	   $data['course_price']=0;
	   $data['addtime']=date('Y-m-d H:i:s');
	   
	   $check=$this->usercourse->where(array('user_id'=>$userid,'course_id'=>$courseid))->find();
	   if($check){
		   $this->error('该客户已经购买此课程，请不要重复赠送！');
	   }else{
		   if( $this->usercourse->add($data)){
		   
		      $this->success('赠送课程成功！');
	        }
		   
	   }
	   
	   
   }
   private function _getTree(){
		$term_id=empty($_REQUEST['term'])?0:intval($_REQUEST['term']);
		$result = $this->coursetype_obj->order(array("listorder"=>"asc"))->select();
		
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("AdminCoursetype/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("AdminTerm/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("AdminTerm/delete", array("id" => $r['term_id'])) . '">删除</a> ';
			$r['visit'] = "<a href='#'>访问</a>";
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['selected']=$term_id==$r['term_id']?"selected":"";
			$array[] = $r;
		}
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
	
}