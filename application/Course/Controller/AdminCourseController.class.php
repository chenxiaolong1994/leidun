<?php
namespace Course\Controller;
use Common\Controller\AdminbaseController;
class AdminCourseController extends AdminbaseController {
	protected $course_obj;
	protected $courseview_obj;
	protected $coursetype_obj;
	protected $usercourse_obj;
	
	function _initialize() {
		parent::_initialize();
		session("access_url",null);
		session("access_name",null);
		checkadmin();
		$this->course_obj = D("Common/Course");
		$this->courseview_obj = D("Common/CourseView");
		$this->coursetype_obj = D("Common/Coursetype");
        $this->usercourse_obj = D("Common/Usercourse");
        $this->section_obj = D("Common/Section");
	} 
	function index(){
		$type="normal";
		$this->_lists("'normal'");
		$this->_getTree();
		$this->display();
	}
	function zhibo(){
		$this->_lists("'live'");
		$this->_getTree();
		$this->display();
	}
	function doc(){
		$this->_lists("'doc'");
		$this->_getTree();
		$this->display();
	}
	function xueyuan(){
	    $cs_id = intval(I("get.cs_id"));
	    $xueyuan=$this->usercourse_obj->where(array('course_id'=>$cs_id))->select();
	    foreach($xueyuan as $n=> $val){           
             $urlArr = explode("|",$xueyuan[$n]['studied']);  
             $jnum=count( $urlArr)-1;
             $cs_id=$xueyuan[$n][course_id];
             $znum=$this->section_obj->where(array("cs_id"=>$cs_id))->count();
             $xueyuan[$n]['bili'] = round(($jnum/$znum)*100);
             $xueyuan[$n]['jnum']=$jnum;
             $xueyuan[$n]['znum']=$znum;
	      }  
		$this->assign("xueyuan",$xueyuan);
		$this->display();
	}
    function pinglun(){
		$cs_id = intval(I("get.cs_id"));
		$pinglun=$this->usercourse_obj->where(array('course_id'=>$cs_id,'pinglun'=>array('neq','')))->select();
		$this->assign("pinglun",$pinglun);
		$this->display();
	}
	function pinglundel(){
	   $data['pinglun']='';
	   if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			
			if ($this->usercourse_obj->where(array('id'=>$id))->save($data)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}

		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->usercourse_obj->where("id in ($tids)")->save($data)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	
	}
	function add(){
		$this->_getTree();
		$term_id = intval(I("get.term"));
		$term=$this->course_obj->where("ty_id=$term_id")->find();
		$domain=sp_get_domain();
		$this->assign("term",$term);
		$this->assign("domain",$domain);
		$this->display();
	}
	
	function add_post(){
		if (IS_POST) {
			$data = $this->course_obj->create();
			$count=$this->course_obj->count();
			$term_id=$data['ty_id'];
			$typedata=$this->coursetype_obj->where("term_id=$term_id")->find();
			$data['cs_teacher']=$_SESSION["ADMIN_ID"];
			$data['top_id']=$typedata['parent'];
			$data['cs_picture']=$_POST['cs_picture'];
			$data['labelid']=$_POST['labelid'];
			$deta['notice']=$_POST['code'];
			$deta['count']=$_POST['count'];
			$data['cs_brief']=htmlspecialchars_decode($data['cs_brief']);
			if($deta['notice']=='sucess'){
				if ($this->course_obj->add($data)) {
					$this->success("添加成功！");
				}else{
					$this->error("添加失败！");
				}			
			}else{
				if($count>=$deta['count']){
					$this->error($deta['notice']);
				}else{
					if ($this->course_obj->add($data)) {
					    $this->success("添加成功！");
				    }else{
					   $this->error("添加失败！");
				    }			
				}
			}
		}
	}
	
	public function edit(){
		$id=  intval(I("get.id"));
		$cs_data=$this->course_obj->where("id=$id")->find();
		$this->assign("cs_data",$cs_data);
		$this->_getTree();
		$this->display();
	}
	
	public function edit_post(){
		if (IS_POST) {
			$id=intval(I("post.id"));
			$data = $this->course_obj->create();
			$data['cs_brief']=htmlspecialchars_decode($data['cs_brief']);
			$result=$this->course_obj->where("id=$id")->save($data);
			if ($result) {
				
					$this->success("编辑成功！");
				}else{
					$this->error("编辑失败！");
				}			
		}
	}
	
	public function listorders() {
		$status = parent::_listorders($this->course_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	private  function _lists($type){
		$status=1;
		$term_id=0;
		if(!empty($_REQUEST["term"])){
			$term_id=intval($_REQUEST["term"]);
		}
		$where_ands=empty($term_id)?array("cs_state<=$status and course_type=$type" ):array("ty_id = $term_id and cs_state=$status and course_type=$type");
		$fields=array(
				'start_time'=> array("field"=>"cs_addtime","operator"=>">"),
				'end_time'  => array("field"=>"cs_addtime","operator"=>"<"),
				'keyword'  => array("field"=>"cs_name","operator"=>"like"),
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
		$count=$this->course_obj->where($where)->count();
		$page = $this->page($count, 20);
		$courselist=$this->courseview_obj->where($where)->order(array('listorder','id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
		foreach($courselist as $n=> $val){
	    	$courselist[$n]['num']=$this->usercourse_obj->where(array('course_id'=>$courselist[$n]['id']))->count();	    	
		}
		$this->assign("Page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("courselist",$courselist);
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
	
	function delete(){
		if(isset($_GET['id'])){
			
			$id = intval(I("get.id"));
			if ($this->course_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}

		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->course_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
	function check(){
		if(isset($_POST['ids']) && $_GET["check"]){
			
			$data["cs_state"]=1;
			$tids=join(",",$_POST['ids']);
			if ( $this->course_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			
			$data["cs_state"]=0;
			$tids=join(",",$_POST['ids']);
			if ( $this->course_obj->where("id in ($tids)")->save($data)) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
	
	function recommend(){
		if(isset($_POST['ids']) && $_GET["recommend"]){
			$data["is_tuijian"]=1;
			$tids=join(",",$_POST['ids']);
			if ( $this->course_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("推荐成功！");
			} else {
				$this->error("推荐失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["unrecommend"]){
	
			$data["is_tuijian"]=0;
			$tids=join(",",$_POST['ids']);
			if ( $this->course_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("取消推荐成功！");
			} else {
				$this->error("取消推荐失败！");
			}
		}
	}
	
	function move(){
		if(IS_POST){
			if(isset($_GET['ids']) && isset($_POST['ty_id'])){
			
				$tids=$_GET['ids'];
				if ( $this->course_obj->where("id in ($tids)")->save($_POST)) {
					$this->success("移动成功！");
				} else {
					$this->error("移动失败！");
				}
			}
		}else{
			$parentid = intval(I("get.parent"));
			$tree = new \PathTree();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '---';
			$result =$this->coursetype_obj->order(array("path"=>"asc"))->select();
			$tree->init($result);
			$tree=$tree->get_tree();
			$this->assign("terms",$tree);
			
			$this->display();
		}
	}
	
	function recyclebin(){
		$this->_lists(0);
		$this->_getTree();
		$this->display();
	}
	
	function clean(){
		if(isset($_POST['ids'])){
			$ids = implode(",", $_POST['ids']);
			$tids= implode(",", array_keys($_POST['ids']));
			$data=array("cs_state"=>"0");
			$status=$this->course_obj->where("id in ($tids)")->delete();
			if($status!==false){
				$status=$this->course_obj->where("id in ($ids)")->delete();
			}
			
			if ($status!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			if(isset($_GET['id'])){
				$id = intval(I("get.id"));
				$tid = intval(I("get.tid"));
				$status=$this->course_obj->where("id = $tid")->delete();
				if($status!==false){
					$status=$this->course_obj->where("id=$id")->delete();
				}
				if ($status!==false) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}
	}
	
	function restore(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			$data=array("id"=>$id,"cs_state"=>"1");
			if ($this->course_obj->save($data)) {
				$this->success("还原成功！");
			} else {
				$this->error("还原失败！");
			}
		}
	}
	
}