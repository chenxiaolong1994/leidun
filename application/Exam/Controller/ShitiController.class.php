<?php
namespace Exam\Controller;
use Common\Controller\HomebaseController;
class ShitiController extends HomebaseController {
	function _initialize() {
	  parent::_initialize();
	  $this->check_login();
	  $this->shiti_obj = D("Common/Exam_shiti");
	  $this->papers_obj = D("Common/Exam_papers");
	  $this->userpapers_obj = D("Common/Exam_userpapers");
	  $this->myerrors = D("Common/Exam_myerrors");
	  $this->coursetype_obj = D("Common/Coursetype");
	  $this->course_obj = D("Common/Course");
	  $this->done_obj = D("Common/Exam_shitidone");
	  $this->label_obj = D("Common/Label");
	  $this->baoming_obj = D("Common/Exam_baoming");
	}
	function index($status=1){
		
		$top_id= intval(I("get.topid"));
		$child_id= intval(I("get.childid"));
		$label_id= intval(I("get.labelid"));
		$top_map=empty($top_id)?array("cs_state=1" ):array("cs_state = 1 and top_id=$top_id");
		$child_map=empty($child_id)? $top_map:array("cs_state = 1 and top_id=$top_id and ty_id=$child_id");
		$top_search_course=$this->course_obj->where($top_map)->select();
		$child_search_course=$this->course_obj->where($child_map)->select();
		$cs_top_ids=array();
		foreach($top_search_course as $n=> $val){
			Array_push($cs_top_ids, $top_search_course[$n]['id']);
		}
		$cs_child_ids=array();
		foreach($child_search_course as $n=> $val){
			Array_push($cs_child_ids, $child_search_course[$n]['id']);
		}
		$cs_id=empty($child_id)? $cs_top_ids:$cs_child_ids;
		$cs_ids=empty($cs_id)? array("cs_id=-1" ):$cs_id;
		$where=empty($top_id)?array('parent'=>-1):array('parent'=>$top_id);
		$toptype=$this->coursetype_obj->where(array('parent'=>0))->select();
		$childtype=$this->coursetype_obj->where($where)->select();
		if(!empty($child_id)){
			$label=$this->label_obj->where(array('c_id'=>$child_id))->select();
		}
		$userid=sp_get_current_userid();
		$myerrors=json_decode($this->myerrors->where(array('uid'=>$userid))->getField('shitiid'),true);
		$mydone=json_decode($this->done_obj->where(array('userid'=>$userid))->getField('shitiid'),true);
		if(!empty($label_id)){
			$choice_map['labelid']=$label_id;
			$choice_map['typeid']=1;
		    $choice_map['cs_id']=array ('in',$cs_ids);
		}else{
			$choice_map['typeid']=1;
		    $choice_map['cs_id']=array ('in',$cs_ids);
		}
		
		$choice_count=$this->shiti_obj->where($choice_map)->count();
		$choice_page = $this->page($choice_count,30);
		$choice=$this->shiti_obj->where($choice_map)->limit($choice_page->firstRow . ',' . $choice_page->listRows)->select();
		foreach($choice as $n=> $val){
			$choice[$n]['stem']=htmlspecialchars_decode($val['stem']);
			$choice[$n]['xa']=htmlspecialchars_decode($val['xa']);
			$choice[$n]['xb']=htmlspecialchars_decode($val['xb']);
			$choice[$n]['xc']=htmlspecialchars_decode($val['xc']);
			$choice[$n]['xd']=htmlspecialchars_decode($val['xd']);
			$choice[$n]['daan']=str_replace(',','',strtoupper(htmlspecialchars_decode($val['daan'])));
			$choice[$n]['analysis']=htmlspecialchars_decode($val['analysis']);
			if((in_array($choice[$n]['id'],$myerrors)) ){
				$choice[$n]['iserror']=1;
			}else{
				$choice[$n]['iserror']=0;
			}
			if((in_array($choice[$n]['id'],$mydone)) ){
				$choice[$n]['isdone']=1;
			}else{
				$choice[$n]['isdone']=0;
			}
		}
		if(!empty($label_id)){
			$fill_map['labelid']=$label_id;
			$fill_map['typeid']=2;
	   	    $fill_map['cs_id']=array ('in',$cs_ids);
		}else{
			$fill_map['typeid']=2;
	   	    $fill_map['cs_id']=array ('in',$cs_ids);
		}
		$fill_count=$this->shiti_obj->where($fill_map)->count();
		$fill_page = $this->page($fill_count,30);
		$fill=$this->shiti_obj->where($fill_map)->limit($fill_page->firstRow . ',' . $fill_page)->select();
		foreach($fill  as $n=> $val){
			if((in_array($fill[$n]['id'],$myerrors)) ){
				$fill[$n]['iserror']=1;
			}else{
				$fill[$n]['iserror']=0;
			}
			if((in_array($fill[$n]['id'],$mydone)) ){
				$fill[$n]['isdone']=1;
			}else{
				$fill[$n]['isdone']=0;
			}
		}
		if(!empty($label_id)){
			$determine_map['labelid']=$label_id;
			$determine_map['typeid']=3;
			$determine_map['cs_id']=array ('in',$cs_ids);
		}else{
			$determine_map['typeid']=3;
			$determine_map['cs_id']=array ('in',$cs_ids);
		}
		
		$determine_count=$this->shiti_obj->where($determine_map)->count();
		$determine_page = $this->page($determine_count,30);
		$determine=$this->shiti_obj->where($determine_map)->limit($determine_page->firstRow . ',' . $determine_page)->select();
		foreach($determine  as $n=> $val){
			if((in_array($determine[$n]['id'],$myerrors)) ){
				$determine[$n]['iserror']=1;
			}else{
				$determine[$n]['iserror']=0;
			}
			if((in_array($determine[$n]['id'],$mydone)) ){
				$determine[$n]['isdone']=1;
			}else{
				$determine[$n]['isdone']=0;
			}
		}
		if(!empty($label_id)){
			$essay_map['labelid']=$label_id;
			$essay_map['typeid']=4;
			$essay_map['cs_id']=array ('in',$cs_ids);
		}else{
			$essay_map['typeid']=4;
			$essay_map['cs_id']=array ('in',$cs_ids);
		}
		
		$essay_count=$this->shiti_obj->where($essay_map)->count();
		$essay_page = $this->page($essay_count,30);
		$essay=$this->shiti_obj->where($essay_map)->limit($essay_page->firstRow . ',' . $essay_page)->select();
		foreach($essay  as $n=> $val){
			if((in_array($essay[$n]['id'],$myerrors)) ){
				$essay[$n]['iserror']=1;
			}else{
				$essay[$n]['iserror']=0;
			}
			if((in_array($essay[$n]['id'],$mydone)) ){
				$essay[$n]['isdone']=1;
			}else{
				$essay[$n]['isdone']=0;
			}
		}
		if(!empty($label_id)){
			$material_map['labelid']=$label_id;
			$material_map['typeid']=5;
			$material_map['cs_id']=array ('in',$cs_ids);
		}else{
			$material_map['typeid']=5;
			$material_map['cs_id']=array ('in',$cs_ids);
		}
		
		$material_count=$this->shiti_obj->where($material_map)->count();
		$material_page = $this->page($material_count,30);
		$material=$this->shiti_obj->where($material_map)->limit($material_page->firstRow . ',' . $material_page)->select();
		foreach($material  as $n=> $val){
			if((in_array($material[$n]['id'],$myerrors)) ){
				$material[$n]['iserror']=1;
			}else{
				$material[$n]['iserror']=0;
			}
			if((in_array($material[$n]['id'],$mydone)) ){
				$material[$n]['isdone']=1;
			}else{
				$material[$n]['isdone']=0;
			}
		}
		$this->assign('toptype',$toptype);
		$this->assign('childtype',$childtype);
		$this->assign('label',$label);
		$this->assign('top_id',$top_id);
		$this->assign('child_id',$child_id);
		$this->assign('label_id',$label_id);
		$this->assign('choice',$choice);
		$this->assign('fill',$fill);
		$this->assign('determine',$determine);
		$this->assign('essay',$essay);
		$this->assign('material',$material);
		$this->assign("choice_page", $choice_page->show('Admin'));
		$this->assign("fill_page", $fill_page->show('Admin'));
		$this->assign("essay_page", $essay_page->show('Admin'));
		$this->assign("determine_page", $determine_page->show('Admin'));
		$this->assign("material_page", $material_page->show('Admin'));
		$this->display();
	}
	
	function adddone(){
		$id=I("post.id");
		$uid=sp_get_current_userid();
		$data['userid']=$uid;
		if($this->done_obj->where(array('userid'=>$uid))->find()){
			$data=$this->done_obj->where(array('userid'=>$uid))->find();
			$data['shitiid']=json_decode($data['shitiid'],true);
			if((!in_array($id,$data['shitiid'])) ){
				array_push($data['shitiid'],$id) ;
				$data['shitiid']= json_encode($data['shitiid']); 
				if($this->done_obj->where(array('userid'=>$uid))->save($data)){
					return json_encode($id);
				}
			}
			
		}else{
			$errors = array($id);
			$data['shitiid']= json_encode($errors);
			if($this->done_obj->add($data)){
				return json_encode($id);
			}
		}
	}
	function shitilist(){
		$cs_id=  intval(I("get.cs_id"));
		$labelid=$this->course_obj->where(array('id'=>$cs_id))->getField('labelid');
		$where_ands=array("cs_id=$cs_id");
		if(IS_POST){
			$typeid=  intval(I("post.typeid"));
			$cs_id=  intval(I("post.cs_id"));
			$where_ands=empty($typeid)?array("cs_id=$cs_id" ):array("typeid = $typeid and cs_id=$cs_id");
			$fields=array(
				'keyword'  => array("field"=>"stem","operator"=>"like"),
		   );
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
		}
		$where= join(" and ", $where_ands);
		$count=$this->shiti_obj->where($where)->count();
		$page = $this->page($count, 10);
		$shiti=$this->shiti_obj->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id"=>"desc"))->select();
		foreach($shiti as $n=> $val){
			$shiti[$n]['stem']=htmlspecialchars_decode($val['stem']);
			$shiti[$n]['xa']=htmlspecialchars_decode($val['xa']);
			$shiti[$n]['xb']=htmlspecialchars_decode($val['xb']);
			$shiti[$n]['xc']=htmlspecialchars_decode($val['xc']);
			$shiti[$n]['xd']=htmlspecialchars_decode($val['xd']);
			$shiti[$n]['analysis']=htmlspecialchars_decode($val['analysis']);
		}   
		$this->assign('cs_id',$cs_id);
		$this->assign('labelid',$labelid);
		$this->assign("Page", $page->show('Admin'));
		$this->assign('shiti',$shiti);
		$this->assign('count',$count);
		$this->display();
	}
	function  delshiti(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			$res=$this->shiti_obj->where(array('id'=>$id))->delete();
			if($res){
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！');
			}
		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->shiti_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	function  delshijuan(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			$res=$this->papers_obj->where(array('id'=>$id))->delete();
			if($res){
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！');
			}
		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->papers_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	function addshiti(){
		$cs_id=  intval(I("get.cs_id"));
		$type=  intval(I("get.type"));
		$labelid=  intval(I("get.labelid"));
		$teacherid=sp_get_current_userid();
		$this->assign('cs_id',$cs_id);
		$this->assign('teacherid',$teacherid);
		$this->assign('type',$type);
		$this->assign('labelid',$labelid);
		switch ($type)
			{
			case 1:
				$this->display(addxuanze);
			  break;  
			case 2:
				$this->display(addtiankong);
			  break;
		    case 3:
				$this->display(addpan);
				break;
			case 4:
				$this->display(addjieda);
				break;
			case 5:
				$this->display(addchailiao);
			  break;
			default:
			  $this->display(addxuanze);
		   }
		
		
	}
	function addshiti_post(){
		if (IS_POST) {
	  	  if ($data=$this->shiti_obj->create()) {
			  
			 if($data['typeid']==1){
				 
				if($data['xa']==null) {
					$this->error("选项A不能为空！");
				}else{
					$data['xa']=htmlspecialchars_decode($data['xa']);
				}
				if($data['xb']==null) {
					$this->error("选项B不能为空！");
				}else{
					$data['xb']=htmlspecialchars_decode($data['xb']);
				}
				if($data['xc']==null) {
					$this->error("选项C不能为空！");
				}else{
					$data['xc']=htmlspecialchars_decode($data['xc']);
				}
				$daan = $_POST['daan'];  
				for($i=0;$i< count($daan);$i++)   {
					$dare=$dare.$daan[$i].',';  
				}
				$data['daan']=$dare;
				$data['xd']=htmlspecialchars_decode($data['xd']);
			 }  
			if($data['stem']==null) {
					$this->error("题干不能为空！");
				}else{
					$data['stem']=htmlspecialchars_decode($data['stem']);
				}	 
			
			if($data['daan']==null) {
				$this->error("答案不能为空！");
			    } else{
					$data['daan']=htmlspecialchars_decode($data['daan']);
				}	 
			
			$data['analysis']=htmlspecialchars_decode($data['analysis']);
			
		    if ($this->shiti_obj->add($data)!==false) {
				$this->success("添加成功！",U("Exam/Shiti/shitilist",array('cs_id'=>$data['cs_id'])));
			} else {
				$this->error("添加失败！");
			}
		} else {
			$this->error($this->shiti_obj->getError());
			}
		} 
		}
	function editshiti(){
		$id=  intval(I("get.id"));
		$data=$this->shiti_obj->where(array('id'=>$id))->find();
		$type= $data['typeid'];
		$data['stem']=htmlspecialchars_decode($data['stem']);
		$data['xa']=htmlspecialchars_decode($data['xa']);
		$data['xb']=htmlspecialchars_decode($data['xb']);
		$data['xc']=htmlspecialchars_decode($data['xc']);
		$data['xd']=htmlspecialchars_decode($data['xd']);
		$data['analysis']=htmlspecialchars_decode($data['analysis']);
		$data['daan']=htmlspecialchars_decode($data['daan']);
		$daan=explode(',',$data['daan']);
		$this->assign('data',$data);
		$this->assign('daan',$daan);
		$this->assign('cs_id',$data['cs_id']);
		switch ($type)
			{
			case 1:
				$this->display(editxuanze);
			  break;  
			case 2:
				$this->display(edittiankong);
			  break;
		    case 3:
				$this->display(editpan);
				break;
			case 4:
				$this->display(editjieda);
				break;
			case 5:
				$this->display(editchailiao);
			  break;
			default:
			  $this->display(editxuanze);
		   }
	}	
	function editshiti_post(){
		if (IS_POST) {
			$data=$this->shiti_obj->create();
			$data['stem']=htmlspecialchars_decode($data['stem']);
			if($data['typeid']==1){
				$data['xa']=htmlspecialchars_decode($data['xa']);
				$data['xb']=htmlspecialchars_decode($data['xb']);
				$data['xc']=htmlspecialchars_decode($data['xc']);
				$data['xd']=htmlspecialchars_decode($data['xd']);
				$daan = $_POST['daan'];  
				for($i=0;$i< count($daan);$i++)   {
					$dare=$dare.$daan[$i].',';  
				}
				$data['daan']=$dare;
			}
				
			$data['analysis']=htmlspecialchars_decode($data['analysis']);
			if($this->shiti_obj->where(array('id'=>$data['id']))->save($data)){
				$this->success('编辑成功',U('Exam/Shiti/editshiti',array('id'=>$data['id'])));
			}else{
				$this->error('编辑失败');
			}
		} 
	}
	function preview(){
		$id=  intval(I("get.id"));
		$type=  intval(I("get.type"));
		$data=$this->shiti_obj->where(array('id'=>$id))->find();
		$data['stem']=htmlspecialchars_decode($data['stem']);
		$data['xa']=htmlspecialchars_decode($data['xa']);
		$data['xb']=htmlspecialchars_decode($data['xb']);
		$data['xc']=htmlspecialchars_decode($data['xc']);
		$data['xd']=htmlspecialchars_decode($data['xd']);
		$data['analysis']=htmlspecialchars_decode($data['analysis']);
		$data['daan']=strtoupper(htmlspecialchars_decode($data['daan']));
		
		$daan=explode(',',$data['daan']);
		$this->assign('data',$data);
		$this->assign('daan',$daan);
		switch ($type)
			{
			case 1:
				$this->display(previewxuanze);
			  break;  
			case 2:
				$this->display(previewtiankong);
			  break;
		    case 3:
				$this->display(previewpan);
				break;
			case 4:
				$this->display(previewjieda);
				break;
			case 5:
				$this->display(previewchailiao);
			  break;
			default:
			  $this->display(previewxuanze);
		   }
	}	
    function shijuan(){
		$id=  intval(I("get.cs_id"));
		$count=$this->papers_obj->where(array('cs_id'=>$id))->count();
		$page = $this->page($count,20);
		$data=$this->papers_obj->where(array('cs_id'=>$id))->order(array('id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign('data',$data);
		$this->assign('cs_id',$id);
		$this->display();
	}
	function createshijuan(){
		$cs_id=  intval(I("get.cs_id"));
		$xuanzhe=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>1))->select();
		$xuanzhenum=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>1))->count();
		$tiankong=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>2))->select();
		$tiankongnum=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>2))->count();
		$panduan=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>3))->select();
		$panduannum=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>3))->count();
		$jieda=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>4))->select();
		$jiedanum=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>4))->count();
		$cailiao=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>5))->select();
		$cailiaonum=$this->shiti_obj->where(array('cs_id'=>$cs_id,'typeid'=>5))->count();
		$this->assign('cs_id',$cs_id);
		$this->assign('xuanzhe',$xuanzhe);
		$this->assign('xuanzhenum',$xuanzhenum);
		$this->assign('tiankong',$tiankong);
		$this->assign('tiankongnum',$tiankongnum);
		$this->assign('panduan',$panduan);
		$this->assign('panduannum',$panduannum);
		$this->assign('jieda',$jieda);
		$this->assign('jiedanum',$jiedanum);
		$this->assign('cailiao',$cailiao);
		$this->assign('cailiaonum',$cailiaonum);
		$this->display();
	}
	function shijuanaddshiti(){
		$ids=$_POST['ids'];
		$temp=array(
			"num"=>count($ids),
			"ids"=>join(",",$ids),
			"arrayids"=>$ids
		);
		if($_POST['type']==1){
			session('tempxuanze',null);
			session('tempxuanze',$temp);
			$this->success('添加成功');
			
		}
		if($_POST['type']==2){
			session('temptiankong',null);
			session('temptiankong',$temp);
			$this->success('添加成功');
		}
		if($_POST['type']==3){
			session('temppanduan',null);
			session('temppanduan',$temp);
			$this->success('添加成功');
		}
		if($_POST['type']==4){
			session('tempjieda',null);
			session('tempjieda',$temp);
			$this->success('添加成功');
		}
		if($_POST['type']==5){
			session('tempcailiao',null);
			session('tempcailiao',$temp);
			$this->success('添加成功');
		}
		
		
	}
	function shijuanaddshitipost(){
		if (IS_POST){
			$title=I("post.title");
			$cs_id=I("post.cs_id");
			$limitedTime=I("post.limitedTime");
			$scores=I("post.scores");
			if($title==''){
				$this->error('请填写试卷名称');
			}
			$data['cs_id']=$cs_id;
			$data['title']=$title;
			$data['limitedTime']=$limitedTime;
			
			$data['single_choice_id']=session('tempxuanze.ids');
			$data['single_choice_score']=$scores['single_choice'];
			
			$data['fill_id']=session('temptiankong.ids');
			$data['fill_score']=$scores['fill'];
			
			$data['determine_id']=session('temppanduan.ids');
			$data['determine_score']=$scores['determine'];
			
			$data['essay_id']=session('tempjieda.ids');
			$data['essay_score']=$scores['essay'];
			
			$data['material_id']=session('tempcailiao.ids');
			$data['material_score']=$scores['material'];
			$data['state']=1;
			$data['addtime']=date('Y-m-d H:i:s');
			$data['teacherid']=sp_get_current_userid();
			if($this->papers_obj->add($data)){
				session('tempxuanze',null);
				session('temptiankong',null);
				session('temppanduan',null);
				session('tempjieda',null);
				session('tempcailiao',null);
				setcookie("title");
				setcookie("limitedtime");
				setcookie("single_choice_score");
				setcookie("fill_score");
				setcookie("determine_score");
				setcookie("essay_score");
				setcookie("material_score");
				$this->success('试卷生成成功',U('Exam/Shiti/shijuan',array('cs_id'=>$cs_id)));
			}else{
				$this->error('试卷生成失败');
			}
		}
	}
	function paperspriew(){
		$id=I("get.id");
		$data=$this->papers_obj->where(array('id'=>$id))->find();
		$map1['id']=empty($data['single_choice_id'])?array("id"=>0 ):array('in',$data['single_choice_id']);
		$map2['id']=empty($data['fill_id'])?array("id"=>0):array('in',$data['fill_id']);
		$map3['id']=empty($data['determine_id'])?array("id"=>0 ):array('in',$data['determine_id']);
		$map4['id']=empty($data['essay_id'])?array("id"=>0):array('in',$data['essay_id']);
		$map5['id']=empty($data['material_id'])?array("id"=>0):array('in',$data['material_id']);
		$single_choice=$this->shiti_obj->where($map1)->select();
		$single_choice_num=$this->shiti_obj->where($map1)->count();
		foreach($single_choice as $key=>$value){
			$single_choice[$key]['stem']=htmlspecialchars_decode($single_choice[$key]['stem']);
			$single_choice[$key]['xa']=htmlspecialchars_decode($single_choice[$key]['xa']);
			$single_choice[$key]['xb']=htmlspecialchars_decode($single_choice[$key]['xb']);
			$single_choice[$key]['xc']=htmlspecialchars_decode($single_choice[$key]['xc']);
			$single_choice[$key]['xd']=htmlspecialchars_decode($single_choice[$key]['xd']);
		}
		
		$fill=$this->shiti_obj->where($map2)->select();
		foreach($fill as $key=>$value){
			$fill[$key]['stem']=htmlspecialchars_decode($fill[$key]['stem']);
		}
		$fill_num=$this->shiti_obj->where($map2)->count();
		
		$determine=$this->shiti_obj->where($map3)->select();
		foreach($determine as $key=>$value){
			$determine[$key]['stem']=htmlspecialchars_decode($determine[$key]['stem']);
		}
		$determine_num=$this->shiti_obj->where($map3)->count();
		
		$essay=$this->shiti_obj->where($map4)->select();
		foreach($essay as $key=>$value){
			$essay[$key]['stem']=htmlspecialchars_decode($essay[$key]['stem']);
		}
		$essay_num=$this->shiti_obj->where($map4)->count();
		
		$material=$this->shiti_obj->where($map5)->select();
		foreach($material as $key=>$value){
			$material[$key]['stem']=htmlspecialchars_decode($material[$key]['stem']);
		}
		$material_num=$this->shiti_obj->where($map5)->count();
		$totalscore=$single_choice_num*$data['single_choice_score']+$fill_num*$data['fill_score']+$determine_num*$data['determine_score']+$essay_num*$data['essay_score']+$material_num*$data['material_score'];
		$this->assign('id',$id);
		$this->assign('data',$data);
		$this->assign('single_choice',$single_choice);
		$this->assign('fill',$fill);
		$this->assign('determine',$determine);
		$this->assign('essay',$essay);
		$this->assign('material',$material);
		$this->assign('single_choice_num',$single_choice_num);
		$this->assign('fill_num',$fill_num);
		$this->assign('determine_num',$determine_num);
		$this->assign('essay_num',$essay_num);
		$this->assign('material_num',$material_num);
		$this->assign('totalscore',$totalscore);
		$this->display();
	}
	function closetestpaper(){
		$id=I("post.id");
		$data['state']=0;
		if($this->papers_obj->where(array('id'=>$id))->save($data)){
			return json_encode($id);
		}
	}
	function opentestpaper(){
		$id=I("post.id");
		$data['state']=1;
		if($this->papers_obj->where(array('id'=>$id))->save($data)){
			return json_encode($id);
		}
	}
	function dopapers(){
		$id=I("get.id");
		$data=$this->papers_obj->where(array('id'=>$id))->find();
		$map1['id']=empty($data['single_choice_id'])?array("id"=>0 ):array('in',$data['single_choice_id']);
		$map2['id']=empty($data['fill_id'])?array("id"=>0):array('in',$data['fill_id']);
		$map3['id']=empty($data['determine_id'])?array("id"=>0 ):array('in',$data['determine_id']);
		$map4['id']=empty($data['essay_id'])?array("id"=>0):array('in',$data['essay_id']);
		$map5['id']=empty($data['material_id'])?array("id"=>0):array('in',$data['material_id']);
		$single_choice=$this->shiti_obj->where($map1)->select();
		foreach($single_choice as $key=>$value){
			$single_choice[$key]['stem']=htmlspecialchars_decode($single_choice[$key]['stem']);
			$single_choice[$key]['xa']=htmlspecialchars_decode($single_choice[$key]['xa']);
			$single_choice[$key]['xb']=htmlspecialchars_decode($single_choice[$key]['xb']);
			$single_choice[$key]['xc']=htmlspecialchars_decode($single_choice[$key]['xc']);
			$single_choice[$key]['xd']=htmlspecialchars_decode($single_choice[$key]['xd']);
		}
		$single_choice_num=$this->shiti_obj->where($map1)->count();
		$fill=$this->shiti_obj->where($map2)->select();
		foreach($fill as $key=>$value){
			$fill[$key]['stem']=htmlspecialchars_decode($fill[$key]['stem']);
		}
		$fill_num=$this->shiti_obj->where($map2)->count();
		
		$determine=$this->shiti_obj->where($map3)->select();
		foreach($determine as $key=>$value){
			$determine[$key]['stem']=htmlspecialchars_decode($determine[$key]['stem']);
		}
		$determine_num=$this->shiti_obj->where($map3)->count();
		
		$essay=$this->shiti_obj->where($map4)->select();
		foreach($essay as $key=>$value){
			$essay[$key]['stem']=htmlspecialchars_decode($essay[$key]['stem']);
		}
		$essay_num=$this->shiti_obj->where($map4)->count();
		
		$material=$this->shiti_obj->where($map5)->select();
		foreach($material as $key=>$value){
			$material[$key]['stem']=htmlspecialchars_decode($material[$key]['stem']);
		}
		$material_num=$this->shiti_obj->where($map5)->count();
		$totalscore=$single_choice_num*$data['single_choice_score']+$fill_num*$data['fill_score']+$determine_num*$data['determine_score']+$essay_num*$data['essay_score']+$material_num*$data['material_score'];
		$this->assign('id',$id);
		$this->assign('data',$data);
		$this->assign('single_choice',$single_choice);
		$this->assign('fill',$fill);
		$this->assign('determine',$determine);
		$this->assign('essay',$essay);
		$this->assign('material',$material);
		$this->assign('single_choice_num',$single_choice_num);
		$this->assign('fill_num',$fill_num);
		$this->assign('determine_num',$determine_num);
		$this->assign('essay_num',$essay_num);
		$this->assign('material_num',$material_num);
		$this->assign('totalscore',$totalscore);
		$this->display();
	}
	function dopaperspost(){
		if(IS_POST){
			$choice=I("post.choices");
			foreach ($choice as $k => $v) {
				foreach ($v as $m => $n) {
				  $choice[$k] = $choice[$k][$v].','.$n;
				}
			}
			$fill=I("post.fill");
			$essay=I("post.essay");
			foreach($fill as $key=>$value){
				$fill[$key]=htmlspecialchars_decode($fill[$key]);
			}
			$determine=I("post.determine");
			$essay=I("post.essay");
			foreach($essay as $key=>$value){
				$essay[$key]=htmlspecialchars_decode($essay[$key]);
			}
			$material=I("post.material");
			foreach($material as $key=>$value){
				$material[$key]=htmlspecialchars_decode($material[$key]);
			}
			$papersid=I("post.papersid");
			$data['userid']=sp_get_current_userid();
			$data['papersid']=$papersid;
			$data['choice']=json_encode($choice);
			$data['fill']=json_encode($fill);
			$data['determine']=json_encode($determine);
			$data['essay']=json_encode($essay);
			$data['material']=json_encode($material);
			$data['addtime']=date('Y-m-d H:i:s');
			$papers=$this->papers_obj->where(array('id'=>$papersid))->find();
			$data['teacherid']=$papers[teacherid];
			foreach($choice as $key=>$value){
				$daan=$this->shiti_obj->where(array('id'=>$key))->getField('daan');
				if(strtolower(str_replace(',','',$daan))==strtolower($value)){
					$data['choicescore']=$data['choicescore']+$papers['single_choice_score'];
				}
			} 
			foreach($determine as $key=>$value){
				$daan=$this->shiti_obj->where(array('id'=>$key))->getField('daan');
				if($daan==$value){
					$data['determinescore']=$data['determinescore']+$papers['determine_score'];
				}
			} 
			$where['userid']=sp_get_current_userid();
			$where['papersid']=$papersid;
			if($this->userpapers_obj->where($where)->find()){
				$this->error('您已经做过此试卷了，请不要重复交卷！');
			}
			if($this->userpapers_obj->add($data)){
				$this->success('交卷成功',U('Exam/Shiti/result',array('id'=>$papersid)));
			}
		}
	}	
	function result(){
		$id=I("get.id");
		$userid=sp_get_current_userid();
		$result=$this->userpapers_obj->where(array('userid'=>$userid,'papersid'=>$id))->find();
		$title=$this->papers_obj->where(array('id'=>$result['papersid']))->getField('title');
		$data=$this->papers_obj->where(array('id'=>$id))->find();
		$map1['id']=empty($data['single_choice_id'])?array("id"=>0 ):array('in',$data['single_choice_id']);
		$map2['id']=empty($data['fill_id'])?array("id"=>0):array('in',$data['fill_id']);
		$map3['id']=empty($data['determine_id'])?array("id"=>0 ):array('in',$data['determine_id']);
		$map4['id']=empty($data['essay_id'])?array("id"=>0):array('in',$data['essay_id']);
		$map5['id']=empty($data['material_id'])?array("id"=>0):array('in',$data['material_id']);
		$myerrors=json_decode($this->myerrors->where(array('uid'=>$userid))->getField('shitiid'),true);
		$single_choice=$this->shiti_obj->where($map1)->select();
		$single_choice_num=$this->shiti_obj->where($map1)->count();
		$user_choice= json_decode($result['choice'],true );
		foreach($single_choice  as $n=> $val){
			$single_choice[$n]['stem']=htmlspecialchars_decode($single_choice[$n]['stem']);
			$single_choice[$n]['xa']=htmlspecialchars_decode($single_choice[$n]['xa']);
			$single_choice[$n]['xb']=htmlspecialchars_decode($single_choice[$n]['xb']);
			$single_choice[$n]['xc']=htmlspecialchars_decode($single_choice[$n]['xc']);
			$single_choice[$n]['xd']=htmlspecialchars_decode($single_choice[$n]['xd']);
			$single_choice[$n]['userdaan']=strtoupper($user_choice[$single_choice[$n][id]]);
			$single_choice[$n]['daan']=strtoupper($single_choice[$n]['daan']);
			if(strtolower(str_replace(',','',$single_choice[$n]['daan']))==strtolower(str_replace(',','',$single_choice[$n]['userdaan']))){
				$single_choice[$n]['result']=1;
			}else{
				$single_choice[$n]['result']=0;
			}
			if((in_array($single_choice[$n]['id'],$myerrors)) ){
				$single_choice[$n]['iserror']=1;
			}else{
				$single_choice[$n]['iserror']=0;
			}
			
		}
		$fill=$this->shiti_obj->where($map2)->select();
		
		$fill_num=$this->shiti_obj->where($map2)->count();
		$user_fill=json_decode($result['fill'],true );
		$fillscore=json_decode($result['fillscore'],true );
		
		foreach($fill  as $n=> $val){
			$fill[$n]['stem']=htmlspecialchars_decode($fill[$n]['stem']);
			$fill[$n]['daan']=htmlspecialchars_decode($fill[$n]['daan']);
			$fill[$n]['userdaan']=$user_fill[$fill[$n][id]];
			$fill[$n]['score']=$fillscore[$fill[$n][id]];
			$totalfilescore=$totalfilescore+$fill[$n]['score'];
			if((in_array($fill[$n]['id'],$myerrors)) ){
				$fill[$n]['iserror']=1;
			}else{
				$fill[$n]['iserror']=0;
			}
		}
		$determine=$this->shiti_obj->where($map3)->select();
		$determine_num=$this->shiti_obj->where($map3)->count();
		$user_determine=json_decode($result['determine'],true );
		foreach($determine  as $n=> $val){
			$determine[$n]['userdaan']=$user_determine[$determine[$n][id]];
			if($determine[$n]['daan']==$determine[$n]['userdaan']){
				$determine[$n]['result']=1;
			}else{
				$determine[$n]['result']=0;
			}
			if((in_array($determine[$n]['id'],$myerrors)) ){
				$determine[$n]['iserror']=1;
			}else{
				$determine[$n]['iserror']=0;
			}
			
		}
		
		$essay=$this->shiti_obj->where($map4)->select();
		$essay_num=$this->shiti_obj->where($map4)->count();
		$user_essay=json_decode($result['essay'],true );
		$essayscore=json_decode($result['essayscore'],true );
		foreach($essay  as $n=> $val){
			$essay[$n]['userdaan']=$user_essay[$essay[$n][id]];
			$essay[$n]['score']=$essayscore[$essay[$n][id]];
			$totalessayscore=$totalessayscore+$essay[$n]['score'];
			if((in_array($essay[$n]['id'],$myerrors)) ){
				$essay[$n]['iserror']=1;
			}else{
				$essay[$n]['iserror']=0;
			}
		}
		
		$material=$this->shiti_obj->where($map5)->select();
		$material_num=$this->shiti_obj->where($map5)->count();
		$user_material=json_decode($result['material'],true );
		$materialscore=json_decode($result['materialscore'],true );
		foreach($material  as $n=> $val){
			$material[$n]['userdaan']=$user_material[$material[$n][id]];
			$material[$n]['score']=$materialscore[$material[$n][id]];
			$totalmaterialscore=$totalmaterialscore+$material[$n]['score'];
			if((in_array($material[$n]['id'],$myerrors)) ){
				$material[$n]['iserror']=1;
			}else{
				$material[$n]['iserror']=0;
			}
		}
		$totlescore=$single_choice_num*$data['single_choice_score']+$fill_num*$data['fill_score']+$determine_num*$data['determine_score']+$essay_num*$data['essay_score']+$material_num*$data['material_score'];
		$usertotlescore=$result['choicescore']+$result['determinescore']+$totalfilescore+$totalessayscore+$totalmaterialscore;
		$this->assign('id',$id);
		$this->assign('title',$title);
		$this->assign('data',$data);
		$this->assign('totlescore',$totlescore);
		$this->assign('usertotlescore',$usertotlescore);
		$this->assign('totalfilescore',$totalfilescore);
		$this->assign('totalessayscore',$totalessayscore);
		$this->assign('totalmaterialscore',$totalmaterialscore);
		$this->assign('result',$result);
		$this->assign('single_choice',$single_choice);
		$this->assign('fill',$fill);
		$this->assign('determine',$determine);
		$this->assign('essay',$essay);
		$this->assign('material',$material);
		$this->assign('single_choice_num',$single_choice_num);
		$this->assign('fill_num',$fill_num);
		$this->assign('determine_num',$determine_num);
		$this->assign('essay_num',$essay_num);
		$this->assign('material_num',$material_num);
		$this->display();
	}
	function examstart(){
		$id=I("get.id");
		$userid=sp_get_current_userid();
		$data=$this->papers_obj->where(array('id'=>$id))->find();
		if(!empty($data['single_choice_id'])){
			$choicecount=count(explode(',',$data['single_choice_id']));
		}else{
			$choicecount=0;
		}
		if(!empty($data['fill_id'])){
			$fillcount=count(explode(',',$data['fill_id']));
		}else{
			$fillcount=0;
		}
		if(!empty($data['determine_id'])){
			$determinecount=count(explode(',',$data['determine_id']));
		}else{
			$determinecount=0;
		}
		if(!empty($data['essay_id'])){
			$essaycount=count(explode(',',$data['essay_id']));
		}else{
			$essaycount=0;
		}
		if(!empty($data['material_id'])){
			$materialcount=count(explode(',',$data['material_id']));
		}else{
			$materialcount=0;
		}
		$choicescore=$choicecount*$data['single_choice_score'];
		$fillscore=$fillcount*$data['fill_score'];
		$determinescore=$determinecount*$data['determine_score'];
		$essayscore=$essaycount*$data['essay_score'];
		$materialscore=$materialcount*$data['material_score'];
		$result=$this->userpapers_obj->where(array('userid'=>$userid,'papersid'=>$id))->find();
		if($result){
			$isdo=true;
		}else{
			$isdo=false;
		}
		$this->assign('data',$data);
		$this->assign('choicecount',$choicecount);
		$this->assign('fillcount',$fillcount);
		$this->assign('determinecount',$determinecount);
		$this->assign('essaycount',$essaycount);
		$this->assign('materialcount',$materialcount);
		
		$this->assign('choicescore',$choicescore);
		$this->assign('fillscore',$fillscore);
		$this->assign('determinescore',$determinescore);
		$this->assign('essayscore',$essayscore);
		$this->assign('materialscore',$materialscore);
		$this->assign('titlescore',$choicescore+$fillscore+$determinescore+$essayscore+$materialscore);
		$this->assign('isdo',$isdo);
		$this->assign('result',$result);
		$this->display();
	}
	function checkpaper(){
		$id=I("get.cs_id");
		$teacherid=sp_get_current_userid();
		$count=$this->userpapers_obj->where(array('teacherid'=>$teacherid,'readover'=>0))->count();
		$page = $this->page($count, 10);
		$papers=$this->userpapers_obj->limit($page->firstRow . ',' . $page->listRows)->order(array("id"=>"desc"))->where(array('teacherid'=>$teacherid,'readover'=>0))->select();
		foreach($papers  as $n=> $val){
			$papers[$n]['title']= $this->papers_obj->where(array('id'=>$papers[$n]['papersid']))->getField('title');
		}
		$this->assign('papers',$papers);
		$this->assign("Page", $page->show('Admin'));
		$this->assign('cs_id',$id);
		$this->display();
	}
	
	function checkpaperfinished(){
		$id=I("get.cs_id");
		$teacherid=sp_get_current_userid();
		$count=$this->userpapers_obj->where(array('teacherid'=>$teacherid,'readover'=>1))->count();
		$page = $this->page($count, 10);
		$papers=$this->userpapers_obj->limit($page->firstRow . ',' . $page->listRows)->order(array("id"=>"desc"))->where(array('teacherid'=>$teacherid,'readover'=>1))->select();
		foreach($papers  as $n=> $val){
			$papers[$n]['title']= $this->papers_obj->where(array('id'=>$papers[$n]['papersid']))->getField('title');
		}
		$this->assign('papers',$papers);
		$this->assign("Page", $page->show('Admin'));
		$this->assign('cs_id',$id);
		$this->display();
	}
	function docheckpaper(){
		$id=I("get.id");
		$result=$this->userpapers_obj->where(array('id'=>$id))->find();
		$data=$this->papers_obj->where(array('id'=>$result['papersid']))->find();
		$map1['id']=empty($data['single_choice_id'])?array("id"=>0 ):array('in',$data['single_choice_id']);
		$map2['id']=empty($data['fill_id'])?array("id"=>0):array('in',$data['fill_id']);
		$map3['id']=empty($data['determine_id'])?array("id"=>0 ):array('in',$data['determine_id']);
		$map4['id']=empty($data['essay_id'])?array("id"=>0):array('in',$data['essay_id']);
		$map5['id']=empty($data['material_id'])?array("id"=>0):array('in',$data['material_id']);
		
		$single_choice=$this->shiti_obj->where($map1)->select();
		$single_choice_num=$this->shiti_obj->where($map1)->count();
		$user_choice= json_decode($result['choice'],true );
		foreach($single_choice  as $n=> $val){
			$single_choice[$n]['userdaan']=strtoupper($user_choice[$single_choice[$n][id]]);
			$single_choice[$n]['daan']=strtoupper($single_choice[$n]['daan']);
			if(strtolower(str_replace(',','',$single_choice[$n]['daan']))==strtolower(str_replace(',','',$single_choice[$n]['userdaan']))){
				$single_choice[$n]['result']=1;
			}else{
				$single_choice[$n]['result']=0;
			}
			
		}
		
		$fill=$this->shiti_obj->where($map2)->select();
		$fill_num=$this->shiti_obj->where($map2)->count();
		$user_fill=json_decode($result['fill'],true );
		$fillscore=json_decode($result['fillscore'],true );
		foreach($fill  as $n=> $val){
			$fill[$n]['stem']=htmlspecialchars_decode($fill[$n]['stem']);
			$fill[$n]['daan']=htmlspecialchars_decode($fill[$n]['daan']);
			$fill[$n]['userdaan']=$user_fill[$fill[$n][id]];
			$fill[$n]['score']=$fillscore[$fill[$n][id]];
			$totalfilescore=$totalfilescore+$fill[$n]['score'];
		}
		$determine=$this->shiti_obj->where($map3)->select();
		$determine_num=$this->shiti_obj->where($map3)->count();
		$user_determine=json_decode($result['determine'],true );
		foreach($determine  as $n=> $val){
			
			$determine[$n]['userdaan']=$user_determine[$determine[$n][id]];
			if($determine[$n]['daan']==$determine[$n]['userdaan']){
				$determine[$n]['result']=1;
			}else{
				$determine[$n]['result']=0;
			}
			
		}
		
		$essay=$this->shiti_obj->where($map4)->select();
		$essay_num=$this->shiti_obj->where($map4)->count();
		$user_essay=json_decode($result['essay'],true );
		$essayscore=json_decode($result['essayscore'],true );
		foreach($essay  as $n=> $val){
			$essay[$n]['stem']=htmlspecialchars_decode($essay[$n]['stem']);
			$essay[$n]['daan']=htmlspecialchars_decode($essay[$n]['daan']);
			$essay[$n]['userdaan']=$user_essay[$essay[$n][id]];
			$essay[$n]['score']=$essayscore[$essay[$n][id]];
			$totalessayscore=$totalessayscore+$essay[$n]['score'];
		}
		
		$material=$this->shiti_obj->where($map5)->select();
		$material_num=$this->shiti_obj->where($map5)->count();
		$user_material=json_decode($result['material'],true );
		$materialscore=json_decode($result['materialscore'],true );
		foreach($material  as $n=> $val){
			$material[$n]['stem']=htmlspecialchars_decode($material[$n]['stem']);
			$material[$n]['daan']=htmlspecialchars_decode($material[$n]['daan']);
			$material[$n]['userdaan']=$user_material[$material[$n][id]];
			$material[$n]['score']=$materialscore[$material[$n][id]];
			$totalmaterialscore=$totalmaterialscore+$material[$n]['score'];
		}
		$totlescore=$single_choice_num*$data['single_choice_score']+$fill_num*$data['fill_score']+$determine_num*$data['determine_score']+$essay_num*$data['essay_score']+$material_num*$data['material_score'];
		$usertotlescore=$result['choicescore']+$result['determinescore']+$totalfilescore+$totalessayscore+$totalmaterialscore;
		$this->assign('userpaperid',$id);
		$this->assign('paperid',$result['papersid']);
		$this->assign('title',$$data['title']);
		$this->assign('data',$data);
		$this->assign('totlescore',$totlescore);
		$this->assign('usertotlescore',$usertotlescore);
		$this->assign('totalfilescore',$totalfilescore);
		$this->assign('totalessayscore',$totalessayscore);
		$this->assign('totalmaterialscore',$totalmaterialscore);
		$this->assign('result',$result);
		$this->assign('single_choice',$single_choice);
		$this->assign('fill',$fill);
		$this->assign('determine',$determine);
		$this->assign('essay',$essay);
		$this->assign('material',$material);
		$this->assign('single_choice_num',$single_choice_num);
		$this->assign('fill_num',$fill_num);
		$this->assign('determine_num',$determine_num);
		$this->assign('essay_num',$essay_num);
		$this->assign('material_num',$material_num);
		$this->display();
		
	}
	function docheckpaperpost(){
		$fill=I("post.fill");
		$essay=I("post.essay");
		$material=I("post.material");
		$papersid=I("post.papersid");
		$userpaperid=I("post.userpaperid");
		$result=$this->userpapers_obj->where(array('id'=>$userpaperid))->find();
		if($result['readover']==1){
			 $this->error('此试卷已经批阅完成，请不要重复批阅！');
		}
		$cs_id= $this->papers_obj->where(array('array'=>$result['papersid']))->getField('cs_id');
		$label= $this->label_obj->where(array('cs_id'=>$cs_id))->getField('labelname');
		$data['fillscore']=json_encode($fill);
		$data['essayscore']=json_encode($essay);
		$data['materialscore']=json_encode($material);
		$data['chacktime']=date('Y-m-d H:i:s');
		$data['readover']=1;
		foreach($fill  as $n=> $val){
			$totalfilescore=$totalfilescore+$fill[$n];
		}
		foreach($essay  as $n=> $val){
			$totaessayscore=$totaessayscore+$essay[$n];
		}
		foreach($material  as $n=> $val){
			$totalmaterialscore=$totalmaterialscore+$material[$n];
		}
		$data['score']=$result['choicescore']+$totalfilescore+$result['determinescore']+$totaessayscore+$totalmaterialscore;
		if($label=='语文'){
			$score['chinese']=$data['score'];
			}
		if($label=='数学'){
			$score['maths']=$data['score'];
			}
		if($label=='外语'){
			$score['english']=$data['score'];
			}	
		$this->baoming_obj->where(array('userid'=>$userpaperid))->save($score);
		if($this->userpapers_obj->where(array('id'=>$userpaperid))->save($data)){
			$this->success('批阅成功',U('Exam/shiti/checkpaper',array('cs_id'=>$cs_id)));
		}
	}
	function adderrors(){
		$id=I("post.id");
		$uid=sp_get_current_userid();
		$data['uid']=$uid;
		if($this->myerrors->where(array('uid'=>$uid))->find()){
			$data=$this->myerrors->where(array('uid'=>$uid))->find();
			$data['shitiid']=json_decode($data['shitiid'],true);
			 array_push($data['shitiid'],$id) ;
			$data['shitiid']= json_encode($data['shitiid']); 
			if($this->myerrors->where(array('uid'=>$uid))->save($data)){
				return json_encode($id);
			}
			
		}else{
			$errors = array($id);
			$data['shitiid']= json_encode($errors);
			if($this->myerrors->add($data)){
				return json_encode($id);
			}
		}
	}
	function dellerrors(){
		$id=I("post.id");
		$uid=sp_get_current_userid();
		$errors=json_decode($this->myerrors->where(array('uid'=>$uid))->getField('shitiid'),true);
		$key = array_search($id, $errors);
		if ($key !== false){
			array_splice($errors, $key, 1);
		}
		$data['shitiid']= json_encode($errors);
		if($this->myerrors->where(array('uid'=>$uid))->save($data)){
				return json_encode($id);
			} 
		
	}
	function checkerrors(){
		$id=I("post.id");
		$uid=sp_get_current_userid();
		$errors=json_decode($this->myerrors->where(array('uid'=>$uid))->getField('shitiid'),true);
		if(in_array($id,$errors)){
			return json_encode($id);
		} 
	}
	function renyuan(){
		$id=I("get.id");
		$users=$this->userpapers_obj->where(array('papersid'=>$id))->order(array("score"=>"desc"))->select();
		$this->assign('users',$users);
		$this->display();
	}
	function chengji(){
		
		$this->display();
	}	
	function import(){
		$cs_id=I("get.cs_id");
		$uid=sp_get_current_userid();
		$this->assign('cs_id',$cs_id);
		$this->assign('uid',$uid);
		$this->display();
	}
	function importpost(){
		 if (!empty($_FILES)) {
			vendor('Classes.PHPExcel');
			$upload = new \Think\UploadFile();
            $upload->maxSize = 3292200;
            $upload->allowExts = explode(',', 'xls,doc');
            $upload->savePath = './Uploads/';
			$upload->saveRule = time();
            if (!$upload->upload()) {
                $this->error($upload->getErrorMsg());
			} else {
				$info = $upload->getUploadFileInfo();
			}
			$file_name=$info[0]['savepath'].$info[0]['savename'];
			$objReader = \ PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load($file_name,$encode='utf-8');
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn(); 
			for($i=3;$i<=$highestRow;$i++)
			{   
		        $data['typeid'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();  
			    $data['teacherid'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();  
				$data['cs_id']   = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
				$data['uncertain'] = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
				$data['stem'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
				$data['xa'] = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
				$data['xb'] = $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
				$data['xc'] = $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
				$data['xd'] = $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
				$data['daan'] = $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
				$data['analysis'] = $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
				if($baoming=$this->shiti_obj->add($data)){
					$res=1;
				}else{
					$res=0;
				}
			} 
			 if($res==1){
				  $this->success('导入成功！');
			 }else{
				  $this->error('导入失败！');
			 }
			
        }else
            {
                $this->error("请选择上传的文件");
            }    
		
	}
	function export(){
		$cs_id=I("get.cs_id");
		$this->assign('cs_id',$cs_id);
		$this->display();
		
	}
	function exportpost(){
		$cs_id=I("post.cs_id");
		$type=I("post.type");
		$xlsName=$this->course_obj->where(array('id'=>$cs_id))->getField('cs_name');
        $xlsCell  = array(
			array('typeid','题型ID'),
			array('teacherid','教师ID'),
			array('cs_id','所属课程ID'),
			array('uncertain','是否多项选择'),
			array('stem','题干'),
			array('xa','选项A'),
			array('xb','选项B'),
			array('xc','选择C'),
			array('xd','选择D'),
			array('daan','答案'),
			array('analysis','试题分析')
        );
		$map=$type==0? array("cs_id = $cs_id"):array("cs_id = $cs_id and typeid=$type");
        $shiti=$this->shiti_obj->where($map)->select();
		foreach($shiti  as $n=> $val){
			$shiti[$n]['stem']=htmlspecialchars_decode($shiti[$n]['stem']);
			$shiti[$n]['xa']=htmlspecialchars_decode($shiti[$n]['xa']);
			$shiti[$n]['xb']=htmlspecialchars_decode($shiti[$n]['xb']);
			$shiti[$n]['xc']=htmlspecialchars_decode($shiti[$n]['xc']);
			$shiti[$n]['xd']=htmlspecialchars_decode($shiti[$n]['xd']);
			$shiti[$n]['daan']=htmlspecialchars_decode($shiti[$n]['daan']);
			$shiti[$n]['analysis']=htmlspecialchars_decode($shiti[$n]['analysis']);
		}
        $this->exportExcel($xlsName,$xlsCell,$shiti);
	}
	
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);
        $fileName = $xlsTitle;
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor('Classes.PHPExcel');
        
        $objPHPExcel = new \ PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet()->setTitle('试题');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1'); 
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
        
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3),' ' . $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");
        $objWriter = \ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output');
 
        exit;   
    }
   
}