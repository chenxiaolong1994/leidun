<?php
	namespace Lib\Alidayu;
	include('TopSdk.php');
	use TopClient; 
	use AlibabaAliqinFcSmsNumSendRequest;
	class SendMSM {
		
		public function send($recNum='', $smsParam='', $smsTemplateCode='SMS_8525079', $smsFreeSignName='短信测试'){
			$c = new TopClient;
			$c->format = "json";
			$c->appkey = C('AlidayuAppKey');
			$c->secretKey = C('AlidayuAppSecret');
			$req = new AlibabaAliqinFcSmsNumSendRequest;
			//$req->setExtend("123456");
			$req->setSmsType("normal");
			$req->setSmsFreeSignName($smsFreeSignName);
			$req->setSmsParam($smsParam);
			$req->setRecNum($recNum);
			$req->setSmsTemplateCode($smsTemplateCode);
			$resp = $c->execute($req);
			return $resp;
		}
		
}