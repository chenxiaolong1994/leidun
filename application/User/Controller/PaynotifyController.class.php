<?php
namespace User\Controller;
use Common\Controller\MemberbaseController;
class PaynotifyController extends MemberbaseController {

    protected $users_model;
    function _initialize(){
        parent::_initialize();
        vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');
        vendor('Wxpay.NativePay');
        vendor('Wxpay.phpqrcode');
    }

    function notifyurl()
    {
        $alipay_config = array(
            'partner' => C('partner'),
            'key' => C('key'),
            'sign_type' => C('sign_type'),
            'input_charset' => C('input_charset'),
            'cacert' => C('cacert'),
            'transport' => 'http',
        );
        //echo 'sucess';exit;
        $alipayNotify = new  \  AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if ($verify_result) {

            $body = $_POST['body'];
            if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                if (get_user_type() != 2) {
                    up_user_mem($body);
                }
            }
            echo "success";
        } else {

            echo "fail";
        }
    }

    function wx_notifyurl()
    {
        $postStr = file_get_contents('php://input');
        libxml_disable_entity_loader(true);
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

        $userid = $postObj->attach;
        $total_fee = $postObj->total_fee;
        $total_fee = $total_fee / 100;
        if ($total_fee != C('member_charge')){
            return 'fail';
        }


        if (get_user_type() != 2) {
            up_user_mem($userid);
        }

        header("Content-type: application/xml");

        $xmlstring = '<xml><return_code>SUCCESS</return_code><return_msg>OK</return_msg></xml>';
        return simplexml_load_string($xmlstring);


    }


}