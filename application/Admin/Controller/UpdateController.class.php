<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class UpdateController extends AdminbaseController{
	 public function checkEnvironment()
    {
        $errors = array();
        if (!class_exists('ZipArchive')) {
            $errors[] = "php_zip扩展未激活";
        }
        if (!function_exists('curl_init')) {
            $errors[] = "php_curl扩展未激活";
        }
        $downloadDirectory = 'update/download';
        if (file_exists($downloadDirectory)) {
            if (!is_writeable($downloadDirectory)) {
                $errors[] = "下载目录({$downloadDirectory})无写权限";
            }
        } else {
            try {
                mkdir($downloadDirectory, 0777, true);
            } catch (\Exception $e) {
                $errors[] = "下载目录({$downloadDirectory})创建失败";
            }
        }
        $backupdDirectory = 'update/backup';
        if (file_exists($backupdDirectory)) {
            if (!is_writeable($backupdDirectory)) {
                $errors[] = "备份({$backupdDirectory})无写权限";
            }
        } else {
            try {
                mkdir($backupdDirectory, 0777, true);
            } catch (\Exception $e) {
                $errors[] = "备份({$backupdDirectory})创建失败";
            }
        }
        
        $this->createJsonErrors($errors);
    }
   
    public function backupFile()
    {
        $errors = array();
        $this->touch("filesystem", $mode = 0777);
        $this->remove('filesystem');
        $this->createJsonErrors($errors);
    }
   
    public function backupDb()
    {
        $errors = array();
        $this->createJsonErrors($errors);
    }
  
    public function downloadPackage()
    {
        $packageId = I("get.packageId");
        $errors    = array();
        try {
            $filepath = $this->downfile($packageId);
			 if (empty($filepath)) {
                throw new \RuntimeException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
            }
			 if(strpos($filepath,'域名')){
				 $errors[]="<font color='red'>未授权域名，无法进行升级！</font>";
			 }
			$unzipDir ='update/unzip';
            $this->unzipPackageFile($filepath,$unzipDir );
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
			
        }
        $this->createJsonErrors($errors);
    }
  
    public function backupUpgradeFile()
    {
        /* $errors    = array();
		$backupbootDir = 'update/backup';
		$backupDir=$backupbootDir.'/3.0.1';
		if (file_exists($backupDir)) {
            if (!is_writeable($backupDir)) {
                $errors[] = "备份目录({$backupDir})无写权限";
            }
        } else {
            try {
                mkdir($backupDir, 0777, true);
            } catch (\Exception $e) {
                $errors[] = "备份目录({$backupDir})创建失败";
            }
        }
        $handle = fopen($backupDir, 'r');
        while ($filePath = fgets($handle)) {
            $filePath= trim($filePath);
            $targetFile = BACKUP_PATH."{$package['fromVersion']}/".trim($filePath);
            if ($this->exists($originFile)) {
                $this->copy($originFile, $targetFile, $override = true);
            }
        }
        fclose($handle);
        last:  */
        $this->createJsonErrors($errors);
    }
   
    public function proccessTpl()
    {
        $errors    = array();
        try {
            $packageDir = './update';
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            goto last;
        }
        if (!$this->exists($packageDir.'/template')) {
            goto last;
        }
        $diffTpls = array();
        $handle = fopen($packageDir.'/template', 'r');
        while ($filePath = fgets($handle)) {
            $filePath = trim($filePath);
            $fullPath        = COREFRAME_ROOT.substr($filePath,9);
            $fullUpgradePath = $packageDir.'/source/'.trim($filePath);
            if (md5_file($fullPath) !== md5_file($fullUpgradePath)) {
                array_push($diffTpls, trim($filePath));
            }
        }
        fclose($handle);
        if (!empty($diffTpls)) {
            array_walk($diffTpls, function ($tpl, $key, $path) {
                $key == 0 ? file_put_contents($path, $tpl."\n") : file_put_contents($path, $tpl."\n", FILE_APPEND);
            }, $packageDir.'/template');
            return $this->createJsonResponse($diffTpls);
        } else {
            $this->remove($packageDir.'/template');
        }
        last:
        $this->createJsonErrors($errors);
    }
   
    public function beginUpgrade()
    {
        $errors            = array();
        $type              = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
        $coveringUpdateTpl = isset($GLOBALS['coveringUpdateTpl']) ? (bool) $GLOBALS['coveringUpdateTpl'] : false;
		$newversion = I("get.nextversion");
        try {
            $packageDir = 'update';
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            goto last;
        }
        try {
            $this->_deleteFilesForPackageUpdate($packageDir);
        } catch (\Exception $e) {
            $errors[] = "删除文件时发生了错误：{$e->getMessage()}";
            goto last;
        }
        try {
            $this->_proccessTplFile($package, $packageDir, $coveringUpdateTpl);
        } catch (\Exception $e) {
            $errors[] = "处理模板文件时发生了错误：{$e->getMessage()}";
            goto last;
        }
        try {
            $this->_replaceFileForPackageUpdate($packageDir);
        } catch (\Exception $e) {
            $errors[] = "复制升级文件时发生了错误：{$e->getMessage()}";
            goto last;
        }
        try {
            $this->_execScriptForPackageUpdate($packageDir);
        } catch (\Exception $e) {
            $errors[] = "执行升级/安装脚本时发生了错误：{$e->getMessage()}";
            goto last;
        }
		
		
        try {
            sp_clear_cache();
        } catch (\Exception $e) {
            $errors[] = "应用安装升级成功，但刷新缓存失败！请检查权限";
            goto last;
        }
        if (empty($errors)) {
            $this->updateAppForPackageUpdate($newversion);
        }
        last:
		
        $this->createJsonErrors($errors);
    }
    protected function _deleteFilesForPackageUpdate($packageDir)
    {
        if (!$this->exists($packageDir.'/delete')) {
            return;
        }
        $handle = fopen($packageDir.'/delete', 'r');
        while ($filePath = fgets($handle)) {
            $filePath= trim($filePath);
            if(substr($filePath,0,9)=='coreframe') {
                $fullPath = COREFRAME_ROOT.substr($filePath,9);
                if ($this->exists($fullPath)) {
                    $this->remove($fullPath);
                }
            } elseif(substr($filePath,0,3)=='www') {
                $fullPath = WWW_ROOT.substr($filePath,3);
                if ($this->exists($fullPath)) {
                    $this->remove($fullPath);
                }
            }
        }
        fclose($handle);
    }
  
    protected function _proccessTplFile($package, $packageDir, $coveringUpdateTpl)
    {
        if (!$this->exists($packageDir.'/template')) {
            return;
        }
        $handle = fopen($packageDir.'/template', 'r');
        while ($filePath = fgets($handle)) {
            $filePath = trim($filePath);
            $originFile  = COREFRAME_ROOT.substr($filePath,9);
            $upgradeFile = "{$packageDir}/source/".$filePath;
            if ($coveringUpdateTpl) {
                $targetFile = BACKUP_PATH."{$package['fromVersion']}/cover/".trim($filePath);
                if ($this->exists($originFile)) {
                    $this->copy($originFile, $targetFile, $override = true);
                }
            } else {
                $targetFile = BACKUP_PATH."{$package['fromVersion']}/".trim($filePath);
                if ($this->exists($upgradeFile)) {
                    $this->copy($upgradeFile, $targetFile, $override = true);
                    $this->remove($upgradeFile);
                }
            }
        }
        fclose($handle);
    }
    protected function _replaceFileForPackageUpdate($packageDir)
    {
        $this->systemRoot = './';
        $this->mirror("{$packageDir}/unzip/file/", $this->systemRoot, null, array(
            'override'        => true,
            'copy_on_windows' => true
        ));
    }
    protected function _execScriptForPackageUpdate($packageDir)
    {   
	    $DB_PREFIX=C('DB_PREFIX');
	    $this->_database_mod = M();
		$sql_file = $packageDir.'/unzip/sql/sql.sql';
        $sql_str = file($sql_file);
        $sql_str = preg_replace("/^--.+\n/",'', $sql_str);
        $sql_str = str_replace("\r", '', implode('', $sql_str));
		$sql_str = str_replace('tableprefix_',$DB_PREFIX,$sql_str);
        $ret = explode(";\n", $sql_str);
        $ret_count = count($ret);
        for ($i = 0; $i < $ret_count; $i++)
        {
            $ret[$i] = trim($ret[$i], " \r\n;"); 
            if (!empty($ret[$i]))
            {
               $this->_database_mod->execute($ret[$i]);
            }
        }
		
		if ($this->exists($packageDir.'/download')) {
            $this->remove($packageDir.'/download');
			mkdir($packageDir.'/download', 0777, true);
        }
		if ($this->exists($packageDir.'/unzip')) {
            $this->remove($packageDir.'/unzip');
			mkdir($packageDir.'/unzip', 0777, true);
        }
        return true;
    }
    protected function updateAppForPackageUpdate($version)
    {
		$configs["VERSION"]=$version;
	    sp_set_dynamic_config($configs);
        return true;
    }
    private function unzipPackageFile($filePath, $unzipDir)
    {   
	    if ($this->exists($unzipDir)) {
            $this->remove($unzipDir);
			mkdir($unzipDir, 0777, true);
        }
		
        $zip = new \ZipArchive;
        if ($zip->open($filePath) === true) {
            $zip->extractTo($unzipDir);
            $zip->close();
        } else {
            throw new \Exception('无法解压缩安装包！');
        }
    }
    private function createJsonErrors($errors)
    {
        if (empty($errors)) {
            echo json_encode(array('status' => 'ok'));
        } elseif (isset($errors['index'])) {
            echo json_encode($errors);
        } else {
            echo json_encode(array('status' => 'error', 'errors' => $errors));
        }
    }
    private function createJsonResponse($response)
    {
        echo json_encode(array('status' => 'ok', 'type' => 'tpl', 'response' => $response));
    }
    private function getPackageFileUnzipDir($package)
    {
        return DOWNLOAD_PATH.$package['fileName'];
    }
	 public function checkUpgradePackages($args)
    {
        return $this->callRemoteAppServer('POST', 'checkUpgradePackages', $args);
    }
	function downfile($packageId){
		$url = $this->getUpdatePackage($packageId);
		if(strstr($url,'http')){
			$save_dir = "update/download";
			$filename = basename($url);
			if ($this->exists($save_dir)) {
				$this->remove($save_dir);
				mkdir($save_dir, 0777, true);
			}
			$filePath = $this->getFile($url, $save_dir, $filename, 1);
			return   $filePath;
		}else{
			return   $url;
		}
		
	}
	function getFile($url, $save_dir = '', $filename = '', $type) {
		if (trim($url) == '') {
			return false;
		}
		if (trim($save_dir) == '') {
			$save_dir = './';
		}
		if (0 !== strrpos($save_dir, '/')) {
			$save_dir.= '/';
		}
		if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
			return false;
		}
		if ($type) {
			$ch = curl_init();
			$timeout = 50;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$content = curl_exec($ch);
			curl_close($ch);
		} else {
			ob_start();
			readfile($url);
			$content = ob_get_contents();
			ob_end_clean();
		}
		$size = strlen($content);
		$fp2 = @fopen($save_dir . $filename, 'a');
		fwrite($fp2, $content);
		fclose($fp2);
		unset($content, $url);
		$filePath=$save_dir . $filename;
		return $filePath;
	}
    public function getUpdatePackage($packageId)
    {
		$domain=sp_get_domain();
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://www.yxtcmf.com/index.php?g=api&m=Regcheck&a=getdownurl');
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		$post_data = array(
			"version" => $packageId,
			"domain"  =>$domain
        );
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		$data = curl_exec($curl);
		$arr=json_decode($data,true);
		curl_close($curl);
		if(empty($arr['downurl'])){
			$url= $arr['error'];
		}else{
			$url= 'http://www.yxtcmf.com'.$arr['downurl'];
		}
		return $url;
    }
    
    public function callRemoteAppServer($httpMethod, $action, $args)
    {
        list($url, $args) = $this->prepareHttpUrlAndParams($action, $args);
        if ($httpMethod == 'POST') {
            $result = post_curl($url, $args);
        } else {
            $url    = $url.(strpos($url, '?') ? '&' : '?').http_build_query($args);
            $result = get_curl($url);
        }
        return json_decode($result, true);
    }
    private function prepareHttpUrlAndParams($action, $args)
    {
        $url           = 'http://www.yxtcmf.com/api'.$action;
        $args['host']  = WEBURL;
        $args['debug'] = OPEN_DEBUG ? true : false;
        return array($url, $args);
    }
    
	public function copy($originFile, $targetFile, $override = false)
    {
        if (stream_is_local($originFile) && !is_file($originFile)) {
            throw new \RuntimeException(sprintf('Failed to copy %s because file not exists', $originFile));
        }
        $this->mkdir(dirname($targetFile));
        $doCopy = true;
        if (!$override && null === parse_url($originFile, PHP_URL_HOST) && is_file($targetFile)) {
            $doCopy = filemtime($originFile) > filemtime($targetFile);
        }
        if ($doCopy) {
            $source = fopen($originFile, 'r');
            $target = fopen($targetFile, 'w', null, stream_context_create(array('ftp' => array('overwrite' => true))));
            stream_copy_to_stream($source, $target);
            fclose($source);
            fclose($target);
            unset($source, $target);
            if (!is_file($targetFile)) {
                throw new \RuntimeException(sprintf('Failed to copy %s to %s', $originFile, $targetFile));
            }
        }
    }
  
    public function mkdir($dirs, $mode = 0777)
    {
        foreach ($this->toIterator($dirs) as $dir) {
            if (is_dir($dir)) {
                continue;
            }
            if (true !== @mkdir($dir, $mode, true)) {
                $error = error_get_last();
                if (!is_dir($dir)) {
                    if ($error) {
                        throw new \RuntimeException(sprintf('Failed to create "%s": %s.', $dir, $error['message']));
                    }
                    throw new \RuntimeException(sprintf('Failed to create "%s"', $dir));
                }
            }
        }
    }
  
    public function exists($files)
    {
        foreach ($this->toIterator($files) as $file) {
            if (!file_exists($file)) {
                return false;
            }
        }
        return true;
    }
 
    public function touch($files, $time = null, $atime = null)
    {
        foreach ($this->toIterator($files) as $file) {
            $touch = $time ? @touch($file, $time, $atime) : @touch($file);
            if (true !== $touch) {
                throw new \RuntimeException(sprintf('Failed to touch %s', $file));
            }
        }
    }
   
    public function remove($files)
    {
        $files = iterator_to_array($this->toIterator($files));
        $files = array_reverse($files);
        foreach ($files as $file) {
            if (!file_exists($file) && !is_link($file)) {
                continue;
            }
            if (is_dir($file) && !is_link($file)) {
                $this->remove(new \FilesystemIterator($file));
                if (true !== @rmdir($file)) {
                    throw new \RuntimeException(sprintf('Failed to remove directory %s', $file));
                }
            } else {
                if ('\\' === DIRECTORY_SEPARATOR && is_dir($file)) {
                    if (true !== @rmdir($file)) {
                        throw new \RuntimeException(sprintf('Failed to remove file %s', $file));
                    }
                } else {
                    if (true !== @unlink($file)) {
                        throw new \RuntimeException(sprintf('Failed to remove file %s', $file));
                    }
                }
            }
        }
    }
  
    public function chmod($files, $mode, $umask = 0000, $recursive = false)
    {
        foreach ($this->toIterator($files) as $file) {
            if ($recursive && is_dir($file) && !is_link($file)) {
                $this->chmod(new \FilesystemIterator($file), $mode, $umask, true);
            }
            if (true !== @chmod($file, $mode & ~$umask)) {
                throw new \RuntimeException(sprintf('Failed to chmod file %s', $file));
            }
        }
    }
  
    public function chown($files, $user, $recursive = false)
    {
        foreach ($this->toIterator($files) as $file) {
            if ($recursive && is_dir($file) && !is_link($file)) {
                $this->chown(new \FilesystemIterator($file), $user, true);
            }
            if (is_link($file) && function_exists('lchown')) {
                if (true !== @lchown($file, $user)) {
                    throw new \RuntimeException(sprintf('Failed to chown file %s', $file));
                }
            } else {
                if (true !== @chown($file, $user)) {
                    throw new \RuntimeException(sprintf('Failed to chown file %s', $file));
                }
            }
        }
    }
  
    public function chgrp($files, $group, $recursive = false)
    {
        foreach ($this->toIterator($files) as $file) {
            if ($recursive && is_dir($file) && !is_link($file)) {
                $this->chgrp(new \FilesystemIterator($file), $group, true);
            }
            if (is_link($file) && function_exists('lchgrp')) {
                if (true !== @lchgrp($file, $group) || (defined('HHVM_VERSION') && !posix_getgrnam($group))) {
                    throw new \RuntimeException(sprintf('Failed to chgrp file %s', $file));
                }
            } else {
                if (true !== @chgrp($file, $group)) {
                    throw new \RuntimeException(sprintf('Failed to chgrp file %s', $file));
                }
            }
        }
    }
  
    public function rename($origin, $target, $overwrite = false)
    {
        // we check that target does not exist
        if (!$overwrite && is_readable($target)) {
            throw new \RuntimeException(sprintf('Cannot rename because the target "%s" already exist.', $target));
        }
        if (true !== @rename($origin, $target)) {
            throw new \RuntimeException(sprintf('Cannot rename "%s" to "%s".', $origin, $target));
        }
    }
   
    public function symlink($originDir, $targetDir, $copyOnWindows = false)
    {
        if ($copyOnWindows && !function_exists('symlink')) {
            $this->mirror($originDir, $targetDir);
            return;
        }
        $this->mkdir(dirname($targetDir));
        $ok = false;
        if (is_link($targetDir)) {
            if (readlink($targetDir) != $originDir) {
                $this->remove($targetDir);
            } else {
                $ok = true;
            }
        }
        if (!$ok && true !== @symlink($originDir, $targetDir)) {
            $report = error_get_last();
            if (is_array($report)) {
                if ('\\' === DIRECTORY_SEPARATOR && false !== strpos($report['message'], 'error code(1314)')) {
                    throw new \RuntimeException('Unable to create symlink due to error code 1314: \'A required privilege is not held by the client\'. Do you have the required Administrator-rights?');
                }
            }
            throw new \RuntimeException(sprintf('Failed to create symbolic link from %s to %s', $originDir, $targetDir));
        }
    }
  
    public function makePathRelative($endPath, $startPath)
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            $endPath = strtr($endPath, '\\', '/');
            $startPath = strtr($startPath, '\\', '/');
        }
        $startPathArr = explode('/', trim($startPath, '/'));
        $endPathArr = explode('/', trim($endPath, '/'));
        $index = 0;
        while (isset($startPathArr[$index]) && isset($endPathArr[$index]) && $startPathArr[$index] === $endPathArr[$index]) {
            ++$index;
        }
        $depth = count($startPathArr) - $index;
        $traverser = str_repeat('../', $depth);
        $endPathRemainder = implode('/', array_slice($endPathArr, $index));
        $relativePath = $traverser.('' !== $endPathRemainder ? $endPathRemainder.'/' : '');
        return '' === $relativePath ? './' : $relativePath;
    }
   
    public function mirror($originDir, $targetDir, \Traversable $iterator = null, $options = array())
    {
        $targetDir = rtrim($targetDir, '/\\');
        $originDir = rtrim($originDir, '/\\');
        if ($this->exists($targetDir) && isset($options['delete']) && $options['delete']) {
            $deleteIterator = $iterator;
            if (null === $deleteIterator) {
                $flags = \FilesystemIterator::SKIP_DOTS;
                $deleteIterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($targetDir, $flags), \RecursiveIteratorIterator::CHILD_FIRST);
            }
            foreach ($deleteIterator as $file) {
                $origin = str_replace($targetDir, $originDir, $file->getPathname());
                if (!$this->exists($origin)) {
                    $this->remove($file);
                }
            }
        }
        $copyOnWindows = false;
        if (isset($options['copy_on_windows']) && !function_exists('symlink')) {
            $copyOnWindows = $options['copy_on_windows'];
        }
        if (null === $iterator) {
            $flags = $copyOnWindows ? \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS : \FilesystemIterator::SKIP_DOTS;
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($originDir, $flags), \RecursiveIteratorIterator::SELF_FIRST);
        }
        if ($this->exists($originDir)) {
            $this->mkdir($targetDir);
        }
        foreach ($iterator as $file) {
            $target = str_replace($originDir, $targetDir, $file->getPathname());
            if ($copyOnWindows) {
                if (is_link($file) || is_file($file)) {
                    $this->copy($file, $target, isset($options['override']) ? $options['override'] : false);
                } elseif (is_dir($file)) {
                    $this->mkdir($target);
                } else {
                    throw new \RuntimeException(sprintf('Unable to guess "%s" file type.', $file));
                }
            } else {
                if (is_link($file)) {
                    $this->symlink($file->getRealPath(), $target);
                } elseif (is_dir($file)) {
                    $this->mkdir($target);
                } elseif (is_file($file)) {
                    $this->copy($file, $target, isset($options['override']) ? $options['override'] : false);
                } else {
                    throw new \RuntimeException(sprintf('Unable to guess "%s" file type.', $file));
                }
            }
        }
    }
   
    public function isAbsolutePath($file)
    {
        return (strspn($file, '/\\', 0, 1)
            || (strlen($file) > 3 && ctype_alpha($file[0])
                && substr($file, 1, 1) === ':'
                && (strspn($file, '/\\', 2, 1))
            )
            || null !== parse_url($file, PHP_URL_SCHEME)
        );
    }
  
    private function toIterator($files)
    {
        if (!$files instanceof \Traversable) {
            $files = new \ArrayObject(is_array($files) ? $files : array($files));
        }
        return $files;
    }
   
    public function dumpFile($filename, $content, $mode = 0666)
    {
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            $this->mkdir($dir);
        } elseif (!is_writable($dir)) {
            throw new \RuntimeException(sprintf('Unable to write in the %s directory.', $dir));
        }
        $tmpFile = tempnam($dir, basename($filename));
        if (false === @file_put_contents($tmpFile, $content)) {
            throw new \RuntimeException(sprintf('Failed to write file "%s".', $filename));
        }
        $this->rename($tmpFile, $filename, true);
        if (null !== $mode) {
            $this->chmod($filename, $mode);
        }
    }
	
}