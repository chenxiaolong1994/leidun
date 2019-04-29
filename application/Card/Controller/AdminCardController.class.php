<?php
namespace Card\Controller;

use Common\Controller\AdminbaseController;

class AdminCardController extends AdminbaseController
{
    protected $card_obj;
    protected $cardtype_obj;
    protected $cardview_obj;
    protected $course_obj;

    function _initialize()
    {
        parent::_initialize();
        $this->card_obj = D("Common/Card");
        $this->cardtype_obj = D("Common/Cardtype");
        $this->cardview_obj = D("Common/CardView");
        $this->course_obj = D("Common/Course");
    }

    function index()
    {
        $this->_lists();
        $this->_getType();
        $this->display();
    }

    function index_cs()
    {
        $cs_id = intval(I("get.cs_id"));
        $cs_name = $this->course_obj->where("id=$cs_id")->getField('cs_name');
        $count = $this->card_obj->where("cs_id=$cs_id")->count();
        $page = $this->page($count, 50);
        $cardlist = $this->card_obj->where("cs_id=$cs_id")->order("id ASC")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->assign("cardlist", $cardlist);
        $this->assign("cs_data", $cs_name);
        $this->display();
    }

    function add()
    {
        $type_id = intval(I("get.type_id"));
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->assign("type_id", $type_id);
        $this->display();
    }

    function add_jihuo()
    {
        $type_id = intval(I("get.type_id"));
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->_getCourse();
        $this->assign("type_id", $type_id);
        $this->display();
    }

    function add_jihuo_cs()
    {
        $type_id = intval(I("get.type_id"));
        $cs_id = intval(I("get.cs_id"));
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->assign("type_id", $type_id);
        $this->assign("cs_id", $cs_id);
        $this->display();
    }

    function add_tiyan()
    {
        $type_id = intval(I("get.type_id"));
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->assign("type_id", $type_id);
        $this->display();
    }

    function add_vip()
    {
        $type_id = intval(I("get.type_id"));
        $domain = sp_get_domain();
        $this->assign("domain", $domain);
        $this->assign("type_id", $type_id);
        $this->display();
    }

    function add_post()
    {
        $i = 1;
        if (IS_POST) {
            $type_id = intval(I("post.type_id"));
            $cs_id = intval(I("post.cs_id"));
            $viptime = intval(I("post.viptime"));
            $card_price = intval(I("post.card_price"));
            $numbers = intval(I("post.numbers"));
            //$notice = $_POST['code'];
            //$count = $_POST['count'];
            $data = $this->card_obj->create();
           // $j = $this->card_obj->where(array('type_id' => $type_id))->count();
            while ($i <= $numbers) {
                $carddate = $this->sp_random_string_card(15);
                $data['type_id'] = $type_id;
                $data['cs_id'] = $cs_id;
                $data['viptime'] = $viptime;
                $data['card_price'] = $card_price;
                $data['card_name'] = $carddate;
                $data['addtime'] = date('Y-m-d H:i:s');
                $i++;
                $result = $this->card_obj->add($data);
            }

            if ($result) {

                $this->success("添加成功！", U("AdminCard/index"));
            } else {
                echo 3;
                $this->error("添加失败！");
            }

        }
    }

    private function _lists($status = 1)
    {
        $type_id = 0;
        if (!empty($_REQUEST["type"])) {
            $type_id = intval($_REQUEST["type"]);
        }
        $where_ands = empty($type_id) ? array("card_state<=$status") : array("type_id = $type_id and card_state<=$status");
        $fields = array(
            'start_time' => array("field" => "addtime", "operator" => "="),
            'end_time' => array("field" => "addtime", "operator" => "<"),
            'keyword' => array("field" => "card_name", "operator" => "like"),
        );

        if (IS_POST) {
            foreach ($fields as $param => $val) {
                if (isset($_POST[$param]) && !empty($_POST[$param])) {
                    $operator = $val['operator'];
                    $field = $val['field'];
                    $get = $_POST[$param];
                    $_GET[$param] = $get;
                    if ($operator == "like") {
                        $get = "%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        } else {
            foreach ($fields as $param => $val) {
                if (isset($_GET[$param]) && !empty($_GET[$param])) {
                    $operator = $val['operator'];
                    $field = $val['field'];
                    $get = $_GET[$param];
                    if ($operator == "like") {
                        $get = "%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }
        $where = join(" and ", $where_ands);
        //dump($where);
        $count = $this->card_obj->where($where)->count();
        $page = $this->page($count, 100);
        $cardlist = $this->card_obj->where($where)->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        $this->assign("cardlist", $cardlist);
    }

    private function _getType()
    {
        $typedata = $this->cardtype_obj->order(array("id" => "asc"))->select();
        $this->assign("typedata", $typedata);
    }

    private function _getCourse()
    {
        $typedata = $this->course_obj->order(array("id" => "asc"))->select();
        $this->assign("typedata", $typedata);
    }

    function sell()
    {
        if (isset($_POST['ids']) && $_GET["sell"]) {

            $data["sale_state"] = 1;
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->save($data) !== false) {
                $this->success("设置成功！", U("AdminCard/index"));
            } else {
                $this->error("设置失败！", U("AdminCard/index"));
            }
        }
        if (isset($_POST['ids']) && $_GET["unsell"]) {

            $data["sale_state"] = 0;
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->save($data) !== false) {
                $this->success("取消成功！", U("AdminCard/index"));
            } else {
                $this->error("取消失败！", U("AdminCard/index"));
            }
        }
    }

    function used()
    {
        if (isset($_POST['ids']) && $_GET["used"]) {

            $data["use_state"] = 1;
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->save($data) !== false) {
                $this->success("设置成功！", U("AdminCard/index"));
            } else {
                $this->error("设置失败！", U("AdminCard/index"));
            }
        }
        if (isset($_POST['ids']) && $_GET["unused"]) {

            $data["use_state"] = 0;
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->save($data) !== false) {
                $this->success("取消成功！", U("AdminCard/index"));
            } else {
                $this->error("取消失败！", U("AdminCard/index"));
            }
        }
    }

    function lock()
    {
        if (isset($_POST['ids']) && $_GET["lock"]) {

            $data["card_state"] = 1;
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->save($data) !== false) {
                $this->success("锁定成功！", U("AdminCard/index"));
            } else {
                $this->error("锁定失败！", U("AdminCard/index"));
            }
        }
        if (isset($_POST['ids']) && $_GET["unlock"]) {

            $data["card_state"] = 0;
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->save($data) !== false) {
                $this->success("解锁成功！");
            } else {
                $this->error("解锁失败！");
            }
        }
    }

    function sp_random_string_card($len)
    {
        $chars = array(
            "A", "B", "C", "D", "E", "F", "G",
            "H", "J", "K", "M", "N", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);    // 将数组打乱
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }

    function randstr($len)
    {
        $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
        $chars1 = '023456789';
        // characters to build the password from
        mt_srand((double)microtime() * 1000000 * getmypid());
        // seed the random number generater (must be done)
        $password = '';
        $cardname = '';

        while (strlen($cardname) < $len) {
            $cardname .= substr($chars, (mt_rand() % strlen($chars)), 1);
        }
        while (strlen($password) < ($len - 4)) {

            $password .= substr($chars1, (mt_rand() % strlen($chars1)), 1);
        }

        return $card = array($cardname, $password);

    }

    function delete()
    {
        if (isset($_GET['id'])) {
            $id = intval(I("get.id"));
            if ($this->card_obj->delete($id) !== false) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }

        }
        if (isset($_POST['ids'])) {
            $tids = join(",", $_POST['ids']);
            if ($this->card_obj->where("id in ($tids)")->delete()) {
                $this->success("删除成功！", U("AdminCard/index"));
            } else {
                $this->error("删除失败！", U("AdminCard/index"));
            }
        }
    }

}