<?php
if (ini_get('magic_quotes_gpc'))
{
	function stripslashesRecursive(array $array)
	{
		foreach ($array as $k => $v)
		{
			if (is_string($v))
			{
				$array[$k] = stripslashes($v);
			} else
			if (is_array($v))
			{
				$array[$k] = stripslashesRecursive($v);
			}
		}
		return $array;
	}
	$_GET = stripslashesRecursive($_GET);
	$_POST = stripslashesRecursive($_POST);
}
define("APP_DEBUG",false);
define('SITE_PATH', dirname(__file__) . "/");
define('APP_PATH', SITE_PATH . 'application/');
define('SPAPP_PATH', SITE_PATH . 'yxtedu/');
define('SPAPP', './application/');
define('SPSTATIC', SITE_PATH . 'statics/');
define("RUNTIME_PATH", SITE_PATH . "data/runtime/");
define("HTML_PATH", SITE_PATH . "data/runtime/Html/");
define("THINKCMF_CORE_TAGLIBS", 'cx,Common\Lib\Taglib\TagLibSpadmin,Common\Lib\Taglib\TagLibHome');

if (function_exists('saeAutoLoader') || isset($_SERVER['HTTP_BAE_ENV_APPID']))
{

} else
{
	if (!file_exists("data/install.lock"))
	{
		if (strtolower($_GET['g']) != "install")
		{
			header("Location:./index.php?g=install");
			exit();
		}
	}
}
define("UC_CLIENT_ROOT", './api/uc_client/');

if (file_exists(UC_CLIENT_ROOT . "config.inc.php"))
{
	include UC_CLIENT_ROOT . "config.inc.php";
}
require SPAPP_PATH . 'Core/ThinkPHP.php';
