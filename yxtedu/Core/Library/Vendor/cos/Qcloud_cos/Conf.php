<?php
namespace Qcloud_cos;

class Conf
{

	const PKG_VERSION = '1.0.0';
	const API_IMAGE_END_POINT = 'http://web.image.myqcloud.com/photos/v1/';
	const API_VIDEO_END_POINT = 'http://web.video.myqcloud.com/videos/v1/';
	const API_COSAPI_END_POINT = 'http://web.file.myqcloud.com/files/v1/';
	const APPID = '10045993';
	const SECRET_ID = 'AKID4yYcaTUsQbIEXwFjUgpYjc6R9Kn6LpHZ';
	const SECRET_KEY = 'vlIiOvSrRNcRMo4m0LooVIVctoGAxZBe';

	 
	public static function getUA() {

		return 'QcloudPHP/'.self::PKG_VERSION.' ('.php_uname().')';
	}
}


//end of script
