<?php

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


