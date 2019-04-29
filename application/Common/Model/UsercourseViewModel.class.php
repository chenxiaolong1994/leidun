<?php
namespace Common\Model;
use Think\Model\ViewModel;
class UsercourseViewModel extends ViewModel {
	public $viewFields=array(
	    'Usercourse'=>array('id','user_id','course_id','addtime','state','studied','course_price'),
		'Course'=>array('id'=>'courseid','cs_name','cs_picture','sec_numbers','_on'=>'Course.id=Usercourse.course_id'),
	 
	);
}
?>

