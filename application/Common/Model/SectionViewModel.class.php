<?php
namespace Common\Model;
use Think\Model\ViewModel;
class SectionViewModel extends ViewModel{
	public $viewFields = array(
      'Section'=>array('id','cs_id','sc_name','sc_time','is_free','playtimes','state','addtime','listorder'),
      'Course'=>array('cs_name', '_on'=>'Section.cs_id=Course.id'),
	);

}