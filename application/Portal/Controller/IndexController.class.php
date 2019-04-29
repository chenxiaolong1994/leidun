<?php
namespace Portal\Controller;
use Common\Controller\HomebaseController;

class IndexController extends HomebaseController {
	protected $course_obj;
	protected $coursetype_obj;
	protected $term_relationships_model;
	function _initialize() {
		parent::_initialize();
		$this->course_obj = D("Common/Course");
		$this->coursetype_obj = D("Common/Coursetype");
		$this->user_obj = D("Common/Users");
		$this->articletype_obj = D("Common/Terms");
		$this->post_obj = D("Common/Posts");
		$this->slide_obj = D("Common/Slide");
		$this->usercourse_obj = D("Common/Usercourse");
		$this->term_relationships_model = D("Portal/TermRelationships");
		$this->topic_obj = D("Common/Forum_topic");
	}

	function get_course_list($course_typeid) {

		$ids = [$course_typeid];
		$type_ids = $this->coursetype_obj->where("parent=".$course_typeid)->field('term_id')->select();
		foreach($type_ids as $v) {
			$ids[] = $v['term_id'];

		}
		$map['ty_id'] = array('in', $ids);
		//var_dump($map);exit;
		$course_list['zuixin']=$this->course_obj->where($map)->order("id desc")->limit(12)->select();
		//var_dump($map, $course_list);exit;
		foreach($course_list['zuixin'] as $n=> $val){
			$course_list['zuixin'][$n]['teacher']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('user_nicename');
			$course_list['zuixin'][$n]['tpic']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('avatar');
			$course_list['zuixin'][$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$course_list['zuixin'][$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}


		$map['is_tuijian'] = 1;
		$course_list['tuijian']=$this->course_obj->where($map)->order("id desc")->limit(12)->select();
		//var_dump($map, $course_list);exit;
		foreach($course_list['tuijian'] as $n=> $val){
			$course_list['tuijian'][$n]['teacher']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('user_nicename');
			$course_list['tuijian'][$n]['tpic']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('avatar');
			$course_list['tuijian'][$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$course_list['tuijian'][$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}

		unset($map['is_tuijian']);
		$map['cs_price'] = 0;
		$course_list['free']=$this->course_obj->where($map)->order("id desc")->limit(12)->select();
		//var_dump($map, $course_list);exit;
		foreach($course_list['free'] as $n=> $val){
			$course_list['free'][$n]['teacher']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('user_nicename');
			$course_list['free'][$n]['tpic']=$this->user_obj->where('id=\''.$val['cs_teacher'].'\'')->getField('avatar');
			$course_list['free'][$n]['xueyuannum']=$this->usercourse_obj->where('course_id=\''.$val['id'].'\'')->count()+$val['cs_xuni'];
			$course_list['free'][$n]['pinglununm']=$this->usercourse_obj->where(array('course_id'=>$val['id'],'pinglun'=>array('NEQ','NULL')))->count();
		}


		//var_dump($course_list);exit;
		return $course_list;
	}

	public function index() {

		$bigdata_type_id = 1;
		$suanfa_type_id = 7;
		$houduan_type_id = 9;
		$qianduan_type_id = 11;
		$yunweiceshi_type_id = 40;
		$daka_type_id = 34;

		$bigdata_course_list = $this->get_course_list($bigdata_type_id);
		$suanfa_course_list = $this->get_course_list($suanfa_type_id);
		$houduan_course_list = $this->get_course_list($houduan_type_id);
		$qianduan_course_list = $this->get_course_list($qianduan_type_id);
		$yunweiceshi_course_list = $this->get_course_list($yunweiceshi_type_id);
		$daka_course_list = $this->get_course_list($daka_type_id);


		$this->assign('bigdata_course_list', $bigdata_course_list);
		$this->assign('suanfa_course_list', $suanfa_course_list);
		$this->assign('qianduan_course_list', $qianduan_course_list);
		$this->assign('houduan_course_list', $houduan_course_list);
		$this->assign('yunweiceshi_course_list', $yunweiceshi_course_list);
		$this->assign('daka_course_list', $daka_course_list);

		$cs_typelist=$this->coursetype_obj->where('parent=0')->select();

		
		$articlelist=$this->articletype_obj->limit(3)->select();
		foreach($articlelist as $n=> $val){
			$articlelist[$n]['voo']=$this->term_relationships_model
			->alias("a")
			->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
			->where('term_id=\''.$val['term_id'].'\'')
			->limit(7)
			->order("a.listorder ASC,b.post_modified DESC")->select();
		}

		foreach($cs_typelist as $n=> $val){
			$cs_typelist[$n]['voo']=$this->course_obj->order('id desc')->where('top_id=\''.$val['term_id'].'\'')->select();
		}

		$topic=$this->topic_obj->order('hits',DESC)->limit(12)->select();
		foreach($topic as $n=> $val){
			$topic[$n]['avatar']=$this->user_obj->where('id=\''.$val['userid'].'\'')->getField('avatar');
			$topic[$n]['username']=$this->user_obj->where('id=\''.$val['userid'].'\'')->getField('user_nicename');
		}
		$teacherlist=$this->user_obj->where(array('user_type'=>3,'user_status'=>1))->limit(4)->select();
		$slide=$this->slide_obj->where(array('slide_cid'=>1,'slide_status'=>1))->order('listorder asc')->select();
		$mslide=$this->slide_obj->where(array('slide_cid'=>2,'slide_status'=>1))->select();



		$bigdata_child = $this->coursetype_obj->where("parent=$bigdata_type_id")->select();
		$bigdata_menu_course = $this->get_menu_tuijian_list($bigdata_type_id);
		$this->assign("bigdata_menu_course", $bigdata_menu_course);
		$this->assign('bigdata_child', $bigdata_child);

		$yunweiceshi_child = $this->coursetype_obj->where("parent=$yunweiceshi_type_id")->select();
		$yunweiceshi_menu_course = $this->get_menu_tuijian_list($yunweiceshi_type_id);
		$this->assign("yunweiceshi_menu_course", $yunweiceshi_menu_course);
		$this->assign('yunweiceshi_child', $yunweiceshi_child);


		$suanfa_child = $this->coursetype_obj->where("parent=$suanfa_type_id")->select();
		$suanfa_menu_course = $this->get_menu_tuijian_list($suanfa_type_id);
		$this->assign("suanfa_menu_course", $suanfa_menu_course);
		$this->assign('suanfa_child', $suanfa_child);


		$houduan_child = $this->coursetype_obj->where("parent=$houduan_type_id")->select();
		$houduan_menu_course = $this->get_menu_tuijian_list($houduan_type_id);
		$this->assign("houduan_menu_course", $houduan_menu_course);
		$this->assign('houduan_child', $houduan_child);


		$qianduan_child = $this->coursetype_obj->where("parent=$qianduan_type_id")->select();
		$qianduan_menu_course = $this->get_menu_tuijian_list($qianduan_type_id);
		$this->assign("qianduan_menu_course", $qianduan_menu_course);
		$this->assign('qianduan_child', $qianduan_child);


		$daka_child = $this->coursetype_obj->where("parent=$daka_type_id")->select();
		$daka_menu_course = $this->get_menu_tuijian_list($daka_type_id);
		$this->assign("daka_menu_course", $daka_menu_course);
		$this->assign('daka_child', $daka_child);


		$this->assign("articlelist",$articlelist);
		$this->assign("cs_typelist",$cs_typelist);
		$this->assign("slide",$slide);
		$this->assign("teacherlist",$teacherlist);
		$this->assign("mslide",$mslide);
		$this->assign("topic",$topic);
		$this->display(":index");
	}

	function get_menu_tuijian_list($type) {
		$course_list = $this->course_obj->where("top_id=$type and is_menu_tuijian=1")->limit(4)->select();
		foreach($course_list as &$v) {
			$v['xueyuannum'] = $this->usercourse_obj->where('course_id=\''.$v['id'].'\'')->count()+$v['cs_xuni'];
		}
		return $course_list;
	}

	function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){   
        if(is_array($arrays)){   
            foreach ($arrays as $array){   
                if(is_array($array)){   
                    $key_arrays[] = $array[$sort_key];   
                }else{   
                    return false;   
                }   
            }   
        }else{   
            return false;   
        }  
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);   
        return $arrays;   
    }  
	public function article($status=1){
		$term_id= intval(I("get.termid"));
		$where=empty($term_id)?array("a.status=$status"):array("a.term_id = $term_id and a.status=$status");

		$term=$this->articletype_obj->select();
		$name=$this->articletype_obj->where(array('term_id'=>$term_id))->getField('name');
		$count=$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where($where)
		->limit($page->firstRow . ',' . $page->listRows)
		->order("a.listorder ASC,b.post_modified DESC")->count();
		$page = $this->page($count, 6);
		$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where($where)
		->limit($page->firstRow . ',' . $page->listRows)
		->order("a.listorder ASC,b.post_modified DESC")->select();
		$tuijian=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where(array("recommended"=>1,'a.status'=>1))
		->limit('10')
		->order("a.listorder ASC,b.post_modified DESC")->select();
		$remen=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->order('post_hits DESC' )->where(array('a.status'=>1))
		->limit('10')
		->select();
		foreach($article as $n=> $val){
			$article[$n]['yue']=date("m",strtotime($article[$n]['post_date']));
			$article[$n]['ri']=date("d",strtotime($article[$n]['post_date']));
		}

		$this->assign("article",$article);
		$this->assign("remen",$remen);
		$this->assign("tuijian",$tuijian);
		$this->assign("term_id",$term_id);
		$this->assign("term",$term);
		$this->assign("name",$name);
		$this->assign("Page", $page->show('Admin'));
		$this->display(":article");

	}
	public function content($status=1){
		$article_id= intval(I("get.id"));
		$termid=intval(I("get.termid"));
		$posts_model=M("Posts");
		$term=M("Terms");
		$posts_model->save(array("id"=>$article_id,"post_hits"=>array("exp","post_hits+1")));
		$content=$posts_model->where(array('id'=>$article_id))->find();
		$tuijian=$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->where(array("recommended"=>1,'a.status'=>1))
		->limit('10')
		->order("a.listorder ASC,b.post_modified DESC")->select();
		$remen=$article=$this->term_relationships_model
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.id")
		->order('post_hits DESC' )->where(array("recommended"=>1,'a.status'=>1))
		->limit('10')
		->select();
		$termname=$term->where(array('term_id'=>$termid))->getField('name');
		$this->assign("termname",$termname);
		$this->assign("term_id",$termid);
		$this->assign("tuijian",$tuijian);
		$this->assign("remen",$remen);
		$this->assign("content",$content);
		$this->assign("name",$content['post_title']);
		$this->display(":content");
	}



}


