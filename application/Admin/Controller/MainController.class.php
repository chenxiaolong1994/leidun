<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MainController extends AdminbaseController
{
    public function index()
    {
        $mysql = M()->query("select VERSION() as version");
        $mysql = $mysql[0]['version'];
        $mysql = empty($mysql) ? L('UNKNOWN') : $mysql;
        //server infomaions
        $info = array(
            L('OPERATING_SYSTEM') => PHP_OS,
            L('OPERATING_ENVIRONMENT') => $_SERVER["SERVER_SOFTWARE"],
            L('PHP_RUN_MODE') => php_sapi_name(),
            L('MYSQL_VERSION') => $mysql,
            L('UPLOAD_MAX_FILESIZE') => ini_get('upload_max_filesize'),
            L('MAX_EXECUTION_TIME') => ini_get('max_execution_time') . "s",
            L('DISK_FREE_SPACE') => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            );
        $t_course = M(Course)->count();
        $t_user = M(users)->where(array('user_type'=>2))->count();
        $t_order = M(order)->count();
        $order_1 = M(order)->where(array('state' => 1))->count();
        $order_2 = M(order)->where(array('state' => 2))->count();
        $t_article = M(posts)->count();
        $where1['cs_addtime'] = $this->find_createtime(1);
        $where2['create_time'] = $this->find_createtime(1);
		$where2['user_type']=2;
        $where3['addtime'] = $this->find_createtime(1);
        $where4['post_modified'] = $this->find_createtime(1);
        $d_course = M(Course)->where($where1)->count();
        $d_user = M(users)->where($where2)->count();
        $d_order = M(order)->where($where3)->count();
        $d_article = M(posts)->where($where4)->count();
        $where5['cs_addtime'] = $this->find_createtime(2);
        $where6['create_time'] = $this->find_createtime(2);
		$where6['user_type']=2;
        $where7['addtime'] = $this->find_createtime(2);
        $where8['post_modified'] = $this->find_createtime(2);
        $z_course = M(Course)->where($where5)->count();
        $z_user = M(Users)->where($where6)->count();
        $z_order = M(order)->where($where7)->count();
        $z_article = M(posts)->where($where8)->count();
        $where9['cs_addtime'] = $this->find_createtime(3);
        $where10['create_time'] = $this->find_createtime(3);
		$where10['user_type']=2;
        $where11['addtime'] = $this->find_createtime(3);
        $where12['post_modified'] = $this->find_createtime(3);
        $y_course = M(Course)->where($where9)->count();
        $y_user = M(users)->where($where10)->count();
        $y_order = M(order)->where($where11)->count();
        $y_article = M(posts)->where($where12)->count();
		$domain=sp_get_domain();
		$version=C('VERSION');
		$nextversionid=$this->getnextversionid($version);
		$nextversion=$this->getnextversion($version);
        $this->assign('t_course', $t_course);
        $this->assign('t_user', $t_user);
        $this->assign('t_order', $t_order);
        $this->assign('t_article', $t_article);
        $this->assign('d_course', $d_course);
        $this->assign('d_user', $d_user);
        $this->assign('d_order', $d_order);
        $this->assign('d_article', $d_article);
        $this->assign('z_course', $z_course);
        $this->assign('z_user', $z_user);
        $this->assign('z_order', $z_order);
        $this->assign('z_article', $z_article);
        $this->assign('y_course', $y_course);
        $this->assign('y_user', $y_user);
        $this->assign('y_order', $y_order);
        $this->assign('y_article', $y_article);
        $this->assign('order_1', $order_1);
        $this->assign('order_2', $order_2);
        $this->assign('server_info', $info);
		 $this->assign('version', $version);
		 $this->assign('nextversionid', $nextversionid);
		 $this->assign('nextversion', $nextversion);
		  $this->assign('domain', $domain);
        $this->display();
    }
	public function getnextversionid($version){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://www.yxtcmf.com/index.php?g=api&m=Regcheck&a=getnextversioninfo');
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		$post_data = array(
			"version" => $version
        );
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		$data = curl_exec($curl);
		$arr=json_decode($data,true);
		curl_close($curl);
		$id=$arr['id'];
		return  $id;
	}
	public function getnextversion($version){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://www.yxtcmf.com/index.php?g=api&m=Regcheck&a=getnextversioninfo');
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		$post_data = array(
			"version" => $version
        );
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		$data = curl_exec($curl);
		$arr=json_decode($data,true);
		curl_close($curl);
		$nextversion=$arr['version'];
		return  $nextversion;
	}
    public function find_createtime($day)
    {
        //查询当天数据
        if ($day == 1)
        {
            $today = date('Y-m-d 00:00:00');
            return array('egt', $today);
            //查询本周数据
        } else
            if ($day == 2)
            {
                $arr = array();
                $arr = getdate();
                $num = $arr['wday'];
                $start = date('Y-m-d H:i:s', time() - ($num - 1) * 24 * 60 * 60);
                $end = date('Y-m-d H:i:s', time() + (7 - $num) * 24 * 60 * 60);
                return array('between', array($start, $end));
                //查询本月数据
            } else
                if ($day == 3)
                {
                    $start = (date('Y-m-01 00:00:00'));
                    $end = (date('Y-m-d H:i:s'));
                    return array('between', array($start, $end));
                    ;
                    //查询本季度数据
                } else
                    if ($day == 4)
                    {
                        $month = date('m');
                        if ($month == 1 || $month == 2 || $month == 3)
                        {
                            $start = strtotime(date('Y-01-01 00:00:00'));
                            $end = strtotime(date("Y-03-31 23:59:59"));
                        } elseif ($month == 4 || $month == 5 || $month == 6)
                        {
                            $start = strtotime(date('Y-04-01 00:00:00'));
                            $end = strtotime(date("Y-06-30 23:59:59"));
                        } elseif ($month == 7 || $month == 8 || $month == 9)
                        {
                            $start = strtotime(date('Y-07-01 00:00:00'));
                            $end = strtotime(date("Y-09-30 23:59:59"));
                        } else
                        {
                            $start = strtotime(date('Y-10-01 00:00:00'));
                            $end = strtotime(date("Y-12-31 23:59:59"));
                        }
                        return array('between', array($start, $end));
                        ;
                        //查询本年度数据
                    } else
                        if ($day == 5)
                        {
                            $year = strtotime(date('Y-01-01 00:00:00'));
                            $data['createtime'] = array('egt', $year);
                            return $data;
                            //全部数据
                        } else
                        {
                            return $data;
                        }
    }
}