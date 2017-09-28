<?php

function write_log($text, $log_name, $log_type = 'log', $dir = '') {
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
	if(function_exists('real_ip')){
		$real_ip = real_ip();
	}
	@error_log($real_ip."   ".date('Y-m-d H:i:s')."   ".$req_url." ".$text."\r\n",3,$log_dir."/".date("Y-m-d")." - ".$log_name.".txt");
}


/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
*/
 function real_ip() { 

    static $realip = NULL;
    if ($realip !== NULL) {
        return $realip;
    }

    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip) {
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = '0.0.0.0';
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    return $realip;
}