<?php
namespace Common\Model;
use Think\Model\ViewModel;
class CardViewModel extends ViewModel{
	public $viewFields = array(
      'Card'=>array('id','type_id','card_name','card_pass','card_price','cs_id','user_id','use_state','sale_state','card_state','viptime','addtime'),
      'Cardtype'=>array('typename', '_on'=>'Card.type_id=Cardtype.id'),
	// 'Users'=>array('user_login', '_on'=>'Card.user_id=Users.id'),
	);

}