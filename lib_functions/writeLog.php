<?php
/**
 * 检查目标文件夹是否存在，如果不存在则自动创建该目录
 *
 * @param       string      $text     	  记录的内容
 * @param       string      $log_name     日志名.txt
 * @param       string      $log_type     日志文件名
 * @param       string      $dir     	  下级目录
 * @return      
 */
function writeLog($text, $log_name, $log_type = 'log', $dir = '') {
	$log_dir = $log_type;
	if($dir){
		$log_dir .= "/".$dir;
	}
	if(!is_dir($log_dir)){
        @mkdir ($log_dir);
    }
	$params_str = $_SERVER['QUERY_STRING'];
	$req_url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $params_str;
	
	$real_ip = '';
    include_once './getUserRealIp.php';
	if(function_exists('getUserRealIp')){
		$real_ip = getUserRealIp();
	}
	@error_log($real_ip."   ".date('Y-m-d H:i:s')."   ".$req_url." ".$text."\r\n",3,$log_dir."/".date("Y-m-d")." - ".$log_name.".txt");
}


