<?php

function curlPost($url, $curlPost, $headerArr = array()){
	$ch = curl_init();//初始化curl
	curl_setopt($ch,CURLOPT_URL,$url);//抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr );//修改header信息 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$out_put = curl_exec($ch);//运行curl
	curl_close($ch);
	return $out_put;
}

function curlGet($url, $headerArr = array()){
	$ch = curl_init($url) ;  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr );//修改header信息 
	$out_put = curl_exec($ch) ;  
	curl_close($ch);
	return $out_put;
}