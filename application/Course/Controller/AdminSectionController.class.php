<?php
namespace Course\Controller;
use Common\Controller\AdminbaseController;
require('./Expand/cos/include.php');
use Qcloud_cos\Auth;
use Qcloud_cos\Cosapi;
class AdminSectionController extends AdminbaseController {
	protected $section_obj;
	protected $course_obj;
    
	function _initialize() {
		parent::_initialize();
		$this->section_obj = D("Common/Section");
		$this->sectionview_obj = D("Common/SectionView");
		$this->course_obj = D("Common/Course");
		$this->live_obj=D("Common/Live");
	}
   public function cos_upload() {
   set_time_limit(0);
     
    $srcPath=$_FILES['upvideo']['tmp_name'];
    $bucketName = C('DOMAIN');
    $dar=Date('Y').'/'.Date('m'); 
    $path = "/$dar/";
    $ispath=Cosapi::statFolder($bucketName, $path);
    if($ispath['code']!='0'){
        Cosapi::createFolder($bucketName, $path);
    }
    $dstPath = $path.$_FILES['upvideo']['name'];
    $_SESSION["access_name"]=$_FILES['upvideo']['name'];
    if($_FILES['upvideo']['size'] < 7388608){
        $arr = Cosapi::upload($srcPath,$bucketName,$dstPath);
    }else{
        $arr = Cosapi::upload_slice($srcPath, $bucketName, $dstPath);
    }
    if($arr['code']=='0'){
    	$_SESSION["access_url"]=$arr['data']['access_url'];
        $this->success('上传成功');
   
    }else{
        $this->success('上传失败');
    }
   }
   public function upload(){
   if (!empty($_FILES) && $_POST['token'] == $verifyToken) 
    {
        $upload = new \Think\Upload();
        //  $upload->maxSize   =     3145728 ;      // 设置附件上传大小
          $upload->exts      =     C('VEDIOTYPE');  // 设置附件上传类型
            $upload->rootPath  =      './upload/vedio/'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['Filedata']);
        if(!$info) 
        {
            echo "error".$upload->getError();
        }
        else 
        {
            echo $info['savepath'].$info['savename'];
        }
        //  $name = $_SERVER['DOCUMENT_ROOT'].'/upload/vedio/'.$info['savepath'].$info['savename'];
        $data['name'] = $info['savepath'].$info['savename'];      //  上传后的文件名！
    }
    }
	
	
	function index(){
		$this->_lists();
		$this->_getCourse();
		$this->display();
	}
    function index_cs(){
		$id=  intval(I("get.cs_id"));
		$cs_name=$this->course_obj->where("id=$id")->getField('cs_name');
		$cstype=$this->course_obj->where("id=$id")->getField('course_type');
		$sc_data=$this->section_obj->where("cs_id=$id")->order("id ASC")->select();
		if($cstype=='live'){
			$HttpUrl="live.api.qcloud.com";
			$HttpMethod="GET"; 
			$isHttps =true;
			$secretKey=C('SecretKey');
			$COMMON_PARAMS = array(
				'Nonce'=> rand(),
				'Timestamp'=>time(NULL),
				'Action'=>'DescribeLVBChannel',
				'SecretId'=> C('SecretId'),
			);
			foreach($sc_data as $n=> $val){
				$sc_data[$n]['channelid']=$this->live_obj->where('sectionid=\''.$val['id'].'\'')->getField('channelid');
		   }
		    foreach($sc_data as $n=> $val){
				$PRIVATE_PARAMS = array(
			    'channelId'=>$val['channelid'],
               );
			$result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
			$res=json_decode($result,true);
			if($res.code==0){
				$sc_data[$n]['livestate']=$res['channelInfo']['0'][channel_status];
			}else{
				$sc_data[$n]['livestate']='';
			}
			
		   }
		}
	    $this->assign("sc_data",$sc_data);
	    $this->assign("cs_id",$id);
	    $this->assign("cs_data",$cs_name);
		$this->assign("cstype",$cstype);
	    
		$this->display();
    }
	function livexiangqing(){
	    $channelId=  I("get.chid");
	    $HttpUrl="live.api.qcloud.com";
		$HttpMethod="GET"; 
		$isHttps =true;
		$secretKey=C('SecretKey');
		$COMMON_PARAMS = array(
				'Nonce'=> rand(),
				'Timestamp'=>time(NULL),
				'Action'=>'DescribeLVBChannel',
				'SecretId'=> C('SecretId'),
			);
		$PRIVATE_PARAMS = array(
			    'channelId'=>$channelId,
               );
	    $result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
	    $res=json_decode($result,true);
		if($res.code==0){
			$data['channel_id']=$res['channelInfo'][0]['channel_id'];
			$data['channel_name']=$res['channelInfo'][0]['channel_name'];
			$data['channel_status']=$res['channelInfo'][0]['channel_status'];
			$data['sourceID']=$res['channelInfo'][0]['upstream_list'][0]['sourceID'];
			$data['sourceAddress']=$res['channelInfo'][0]['upstream_list'][0]['sourceAddress'];
			$this->assign('data',$data);
			$this->display();
		}else{
			$result="";
			$this->display();
		}
	   
   }
   function liveshudown(){
	    $channelId=  I("get.chid");
	    $HttpUrl="live.api.qcloud.com";
		$HttpMethod="GET"; 
		$isHttps =true;
		$secretKey=C('SecretKey');
		$COMMON_PARAMS = array(
				'Nonce'=> rand(),
				'Timestamp'=>time(NULL),
				'Action'=>'StopLVBChannel',
				'SecretId'=> C('SecretId'),
			);
		$PRIVATE_PARAMS = array(
			    'channelIds.1'=>$channelId,
					
               );
	    $result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
	    $res=json_decode($result,true);
		if($res.code==0){
			$this->assign("result",'关闭成功');
		}else{
			$this->assign("result",$res.message);
		}
		$this->display();

   }
   function livestart(){
	    $channelId=  I("get.chid");
	    $HttpUrl="live.api.qcloud.com";
		$HttpMethod="GET"; 
		$isHttps =true;
		$secretKey=C('SecretKey'); 
		$COMMON_PARAMS = array(
				'Nonce'=> rand(),
				'Timestamp'=>time(NULL),
				'Action'=>'StartLVBChannel',
				'SecretId'=> C('SecretId'),
			);
		$PRIVATE_PARAMS = array(
			    'channelIds.1'=>$channelId,
					
               );
	    $result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
	    $res=json_decode($result,true);
		if($res.code==0){
			$this->assign("result",'开启成功');
		}else{
			$this->assign("result",$res.message);
		}
		$this->display();

	   
   }
   function livedel(){
	    $channelId=  I("get.chid");
	    $HttpUrl="live.api.qcloud.com";
		$HttpMethod="GET"; 
		$isHttps =true;
		$secretKey=C('SecretKey'); 
		$COMMON_PARAMS = array(
				'Nonce'=> rand(),
				'Timestamp'=>time(NULL),
				'Action'=>'DeleteLVBChannel',
				'SecretId'=> C('SecretId'),
			);
		$PRIVATE_PARAMS = array(
			    'channelIds.1'=>$channelId,
					
               );
	    $result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
	    $res=json_decode($result,true);
		
		if($res.code==0){
			$this->live_obj->where(array('channelid'=>$channelId))->delete();
			$this->assign("result",'删除成功');
		}else{
			$this->assign("result",$res.message);
		}
		$this->display();

   }
   function liveonline(){
	   $channelId=  I("get.chid");
	    $HttpUrl="live.api.qcloud.com";
		$HttpMethod="GET"; 
		$isHttps =true;
		$secretKey=C('SecretKey');
		$COMMON_PARAMS = array(
				'Nonce'=> rand(),
				'Timestamp'=>time(NULL),
				'Action'=>'DescribeLVBOnlineUsers',
				'SecretId'=> C('SecretId'),
			);
		$PRIVATE_PARAMS = array(
			    'channelIds.n'=>$channelId,
					
               );
	    $result=$this->CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
	    $res=json_decode($result,true);
		if($res.code==0){
			$this->assign("result",$res['list']['online']);
		}else{
			$this->assign("result",$res.message);
		}
		$this->display();
   }
   function CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps){
		$FullHttpUrl = $HttpUrl."/v2/index.php";
		$ReqParaArray = array_merge($COMMON_PARAMS, $PRIVATE_PARAMS);
		ksort($ReqParaArray);
		$SigTxt = $HttpMethod.$FullHttpUrl."?";
		$isFirst = true;
		foreach ($ReqParaArray as $key => $value)
		{
			if (!$isFirst) 
			{ 
				$SigTxt = $SigTxt."&";
			}
         $isFirst= false;
			if(strpos($key, '_'))
			{
				$key = str_replace('_', '.', $key);
			}

        $SigTxt=$SigTxt.$key."=".$value;
		}

		$Signature = base64_encode(hash_hmac('sha1', $SigTxt, $secretKey, true));
		$Req = "Signature=".urlencode($Signature);
		foreach ($ReqParaArray as $key => $value)
		{
			$Req=$Req."&".$key."=".urlencode($value);
		}
		if($HttpMethod === 'GET')
		{
			if($isHttps === true)
			{
				$Req="https://".$FullHttpUrl."?".$Req;
			}
			else
			{
				$Req="http://".$FullHttpUrl."?".$Req;
			}
         // dump($Req);
			$Rsp = file_get_contents($Req);
            return ($Rsp );
		}
		else
		{
			if($isHttps === true)
			{
				$Rsp= SendPost("https://".$FullHttpUrl,$Req,$isHttps);
			}
			else
			{
				$Rsp= SendPost("http://".$FullHttpUrl,$Req,$isHttps);
			}
			 return ($Rsp );
		}
		
	}

	function SendPost($FullHttpUrl,$Req,$isHttps){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Req);

        curl_setopt($ch, CURLOPT_URL, $FullHttpUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($isHttps === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
        }

        $result = curl_exec($ch);
		if($result.code==0){
			$this->success('创建直播成功！');
		}
	}
	
	function add(){
		$cs_id=  intval(I("get.cs_id"));
		$cs_data=$this->section_obj->where("id=$cs_id")->find();
		$where['cs_id']=$cs_id;
		$where['type_id']=1;
		$zhang_list=$this->section_obj->where($where)->order("id DESC")->select();
		$this->assign("cs_data",$cs_data);
		$this->assign("cs_id",$cs_id);
		$this->assign("zhang_list",$zhang_list);
		$this->display();
	}
    function add_zhang(){
		$cs_id=  intval(I("get.cs_id"));
		$this->assign("cs_id",$cs_id);
		$this->display();   
	}
    function add_video(){
		
		$this->display();   
	}
    function add_zhang_post(){
        if (IS_POST) {
        	
		    $data['cs_id']=intval(I("post.cs_id"));
		    $data['type_id']=intval(I("post.type_id"));
		    $data['sc_name']=I("post.sc_name");
		    $data['addtime']=I("post.addtime");
		    $data['state']=1;
		    if($data['sc_name']==null){
		       $this->error("请填写章节名称！");
		    }
			$result=$this->section_obj->add($data);
			if ($result) {
				
					$this->success("添加成功！" );
				}else{
					$this->error("添加失败！");
				}			
		}
	}
	
    function addaudio(){
		
		$this->display();
	}
	function add_post(){
	   if (IS_POST) {
			if ($data=$this->section_obj->create()) {
				if($data['video_type']==1){
					$data['yun_url']=I('post.yun_url');
				}else{
				    $data['yun_url']=I('post.youku_url');
				    $data['playpass']=I('post.playpass');
				}
				if ($this->section_obj->add($data)!==false) {
					session("access_url",null);
					session("access_name",null);
					$this->success("添加成功！");
					
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->section_obj->getError());
			}
		}
	}
   function add_all(){
		
		$this->display();
	}
	public function edit(){
		$id=  intval(I("get.id"));
		$section=$this->section_obj->where("id=$id")->find();
		$course = $this->course_obj->order(array("listorder"=>"asc"))->select();
		$this->assign("course",$course);
		$this->assign("section",$section);
		$this->display();
	}
    public function edit_zhang(){
		$id=  intval(I("get.id"));
		$section=$this->section_obj->where("id=$id")->find();
		$this->assign("section",$section);
		$this->display();
	}
	public function edit_post(){
     	if (IS_POST) {
     		$id= intval(I("post.id"));
			if ($data=$this->section_obj->create()) {
			    if($data['video_type']==1){
					$data['yun_url']=I('post.yun_url');
				}else{
				    $data['yun_url']=I('post.youku_url');
				    $data['playpass']=I('post.playpass');
				}
				if ($this->section_obj->where("id=$id")->save($data)!==false) {
					$this->success("编辑成功！");
				} else {
					$this->error("编辑失败！");
				}
			} else {
				$this->error($this->section_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->section_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	private  function _lists($status=1){
		$cs_id=0;
		$type_id=0;
		if(!empty($_REQUEST["cs_id"])){
			$cs_id=intval($_REQUEST["cs_id"]);
		}
	    $where_ands=empty($cs_id)? array("state<=$status and type_id<=$type_id"):array("cs_id = $cs_id and state<=$status and type_id=$type_id");
	    $fields=array(
				'start_time'=> array("field"=>"addtime","operator"=>">"),
				'end_time'  => array("field"=>"addtime","operator"=>"<"),
				'keyword'  => array("field"=>"sc_name","operator"=>"like"),
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
		$count=$this->section_obj->where($where)->count();
		$page = $this->page($count, 20);
		$sectionlist=$this->sectionview_obj->where($where)->order(array('listorder','id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign("page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		unset($_GET[C('VAR_URL_PARAMS')]);
		$this->assign("formget",$_GET);
		$this->assign("sectionlist",$sectionlist);
	}
	
	private function _getCourse(){
		
		$course = $this->course_obj->order(array("listorder"=>"asc"))->select();
		$this->assign("course",$course);
	}
	private function _getCoursename($cs_id){
	    $where['id']=$cs_id;
		$course = $this->course_obj->where($where)->select();
		$this->assign("cs_name",$course['cs_name']);
	}
	function delete(){
		if(isset($_GET['id'])){
			$id = intval(I("get.id"));
			if ($this->section_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}

		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			if ($this->section_obj->where("id in ($tids)")->delete()) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
	function check(){
		if(isset($_POST['ids']) && $_GET["check"]){
			
			$data["state"]=1;
			$tids=join(",",$_POST['ids']);
			if ( $this->section_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			
			$data["state"]=0;
			$tids=join(",",$_POST['ids']);
			if ( $this->section_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
	
     function isfree(){
		if(isset($_POST['ids']) && $_GET["free"]){
			
			$data["is_free"]=1;
			$tids=join(",",$_POST['ids']);
			if ( $this->section_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("设置成功！");
			} else {
				$this->error("设置失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["unfree"]){
			
			$data["is_free"]=0;
			$tids=join(",",$_POST['ids']);
			if ( $this->section_obj->where("id in ($tids)")->save($data)!==false) {
				$this->success("取消免费成功！");
			} else {
				$this->error("取消免费失败！");
			}
		}
	}
	
	function move(){
		if(IS_POST){
			if(isset($_GET['ids']) && isset($_POST['cs_id'])){
				$tids=$_GET['ids'];
				if ( $this->section_obj->where("id in ($tids)")->save($_POST)) {
					$this->success("移动成功！");
				} else {
					$this->error("移动失败！");
				}
			}
		}else{
			$course = $this->course_obj->order(array("listorder"=>"asc"))->select();
		    $this->assign("course",$course);
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
			$data=array("post_status"=>"0");
			$status=$this->terms_relationship->where("tid in ($tids)")->delete();
			if($status!==false){
				$status=$this->posts_obj->where("id in ($ids)")->delete();
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
				$status=$this->terms_relationship->where("tid = $tid")->delete();
				if($status!==false){
					$status=$this->posts_obj->where("id=$id")->delete();
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
			$data=array("tid"=>$id,"status"=>"1");
			if ($this->terms_relationship->save($data)) {
				$this->success("还原成功！");
			} else {
				$this->error("还原失败！");
			}
		}
	}
	
}