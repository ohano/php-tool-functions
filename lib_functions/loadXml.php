<?php

/**
 * @access      public
 * @param       string      xml     xml字符串
 * @return      array
 */
function loadXml($xml){
	$xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

	$xmlArr = array();
	if($xmlObj){
		foreach($xmlObj as $k=>$r){
			$xmlArr[$k] = (string)$r;
		}
	}
	return $xmlArr;
}