<?php
namespace Common\Model;
use Think\Model\ViewModel;
class CourseViewModel extends ViewModel{
	public $viewFields = array(
      'Course'=>array('id','ty_id','course_type','cs_name','cs_xuni','cs_price','cs_brief','sec_numbers','cs_picture','cs_teacher','isover','cs_addtime','cs_state','is_tuijian','listorder','labelid', 'is_menu_tuijian'),
      'Coursetype'=>array('name'=>'coursetype_name', '_on'=>'Course.ty_id=Coursetype.term_id'),
	);

}