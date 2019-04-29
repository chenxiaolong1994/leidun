<?php
namespace Qcloud_cos;
class Auth
{

    const AUTH_URL_FORMAT_ERROR = -1;
    const AUTH_SECRET_ID_KEY_ERROR = -2;

   
    public static function appSign($expired, $bucketName) {

        $appId = cosconfig('APP_ID');
        $secretId = cosconfig('SECRET_ID');
        $secretKey = cosconfig('SECRET_KEY');
        if (empty($secretId) || empty($secretKey) || empty($appId)) {
			
            return self::AUTH_SECRET_ID_KEY_ERROR;
        }
        return self::appSignBase($appId, $secretId, $secretKey, $expired, null, $bucketName);
    }

   
    public static function appSign_once($path, $bucketName) {

        $appId = cosconfig('APP_ID');
        $secretId = cosconfig('SECRET_ID');
        $secretKey = cosconfig('SECRET_KEY');

        if (preg_match('/^\//', $path) == 0) {
            $path = '/' . $path;
        }
        $fileId = '/' . $appId . '/' . $bucketName . $path;
        
        if (empty($secretId) || empty($secretKey) || empty($appId)) {
            return self::AUTH_SECRET_ID_KEY_ERROR;
        }
                    
        return self::appSignBase($appId, $secretId, $secretKey, 0, $fileId, $bucketName);
    }

   
    public static function appSign_multiple($path, $bucketName, $expired) {

        $appId = cosconfig('APP_ID');
        $secretId = cosconfig('SECRET_ID');
        $secretKey = cosconfig('SECRET_KEY');

        if (preg_match('/^\//', $path) == 0) {
            $path = '/' . $path;
        }
        $fileId = $path;
        
        if (empty($secretId) || empty($secretKey) || empty($appId)) {
            return self::AUTH_SECRET_ID_KEY_ERROR;
        }
                    
        return self::appSignBase($appId, $secretId, $secretKey, $expired, $fileId, $bucketName);
    }
    
   
    private static function appSignBase($appId, $secretId, $secretKey, $expired, $fileId, $bucketName) {
        if (empty($secretId) || empty($secretKey)) {
            return self::AUTH_SECRET_ID_KEY_ERROR;
        }

        $now = time();
        $rdm = rand();
        $plainText = "a=$appId&k=$secretId&e=$expired&t=$now&r=$rdm&f=$fileId&b=$bucketName";
        $bin = hash_hmac('SHA1', $plainText, $secretKey, true);
        $bin = $bin.$plainText;

        $sign = base64_encode($bin);

        return $sign;
    }

}


