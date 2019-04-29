<?php
namespace Common\Model;
use Think\Model\ViewModel;
class Forum_praisalViewModel extends ViewModel{
	public $viewFields = array(
      'forum_praisal'=>array('id','replyid','topicid','userid','content','addtime'),
      'users'=>array('avatar', '_on'=>'forum_praisal.userid=users.id'),
	);

}