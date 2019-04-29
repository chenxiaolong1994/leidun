<?php
namespace Exam\Controller;
use Common\Controller\AdminbaseController;
class AdminShitiController extends AdminbaseController {

	function _initialize() {
	  parent::_initialize();
	  $this->shiti_obj = D("Common/Exam_shiti");
	  $this->papers_obj = D("Common/Exam_papers");
	  $this->userpapers_obj = D("Common/Exam_userpapers");
	  $this->myerrors = D("Common/Exam_myerrors");

	}
	
	function shitilist(){
		
		if(IS_POST){
			$typeid=  intval(I("post.typeid"));
			$where_ands=empty($typeid)?array("cs_id>0" ):array("cs_id>0 and typeid=$typeid");
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
		if(IS_POST){
			$where_ands=array("cs_id>0");
			$fields=array(
				'keyword'  => array("field"=>"title","operator"=>"like"),
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
		$count=$this->papers_obj->where($where)->count();
		$page = $this->page($count,10);
		$data=$this->papers_obj->where($where)->order(array('id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign('data',$data);
		$this->assign("Page", $page->show('Admin'));
		$this->display();
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
		
		$fill=$this->shiti_obj->where($map2)->select();
		$fill_num=$this->shiti_obj->where($map2)->count();
		
		$determine=$this->shiti_obj->where($map3)->select();
		$determine_num=$this->shiti_obj->where($map3)->count();
		
		$essay=$this->shiti_obj->where($map4)->select();
		$essay_num=$this->shiti_obj->where($map4)->count();
		
		$material=$this->shiti_obj->where($map5)->select();
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
	
	function opentestpaper(){
		$id=I("post.id");
		$data['state']=1;
		if($this->papers_obj->where(array('id'=>$id))->save($data)){
			return json_encode($id);
		}
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
	
	function renyuan(){
		$id=I("get.id");
		$count=$this->userpapers_obj->where(array('papersid'=>$id))->count();
		$page = $this->page($count, 8);
		$users=$this->userpapers_obj->where(array('papersid'=>$id))->limit($page->firstRow . ',' . $page->listRows)->order(array("score"=>"desc"))->select();
		$this->assign('users',$users);
		$this->assign("Page", $page->show('Admin'));
		$this->display();
	}
	
	
	
}