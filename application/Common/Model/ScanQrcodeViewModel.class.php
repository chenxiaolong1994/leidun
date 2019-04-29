<?php
namespace Common\Model;
use Think\Model\ViewModel;
class ScanQrcodeViewModel extends ViewModel{
	public $viewFields = array(
      'ScanQrcode'=>array('id','openid','scan_openid','scan_time'),

	);

}