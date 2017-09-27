<?php

include './PHPExcel/PHPExcel.php';

function createObjData($xml_upload_goods,$file_name,$title='上传',$is_twoD_arr=false , $is_download=true)
{
    $xml_index = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG');
    // 生成新的excel对象
    $objPHPExcel = newObjPHPExcel();
    // 设置工作薄名称
    $objPHPExcel->getActiveSheet()->setTitle($title);

    if($is_twoD_arr){
        $line = 1;
        foreach ($xml_upload_goods as $k => $r) {
            foreach ($r as $k2 => $v2) {
                $objPHPExcel->getActiveSheet()->setCellValueExplicit($xml_index[$k2].$line, $v2,PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $line ++;
        }
    }else{
        foreach($xml_upload_goods as $k=>$r){
            $objPHPExcel->getActiveSheet()->setCellValue($xml_index[$k].'1', $r);
        }
    }
    
    objWriterOutput($objPHPExcel, $file_name ,$is_download);
}


function objWriterOutput($objPHPExcel, $file_name ,$is_download=true)
{
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_end_clean();
    // 从浏览器直接输出$filename
    if($is_download){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=".$file_name.date('YmdHis').".xls");
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output'); //文件通过浏览器下载
    }else{
        $objWriter->save('./'.$file_name.".xls") ;//脚本方式运行，保存在当前目录
    }

}


//demo
$filed_arr = array('0'=>"会员名称",'1'=>"会员昵称",'2'=>"手机",'3'=>"积分",'4'=>"注册日期");
$export_arr[] = $filed_arr;
foreach ($user_list['user_list'] as $k => $v) {
  $temp_arr = array();
  $temp_arr['0'] = $v['user_name'];
  $temp_arr['1'] = $v['real_name'];
  $temp_arr['2'] = $v['mobile_phone'];
  $temp_arr['3'] = $v['pay_points'];
  $temp_arr['4'] = $v['reg_time'];
  $export_arr[] = $temp_arr;
}
createObjData($export_arr,"user_list",'',true);