<?php

include './PHPExcel/PHPExcel.php';
/**
 * 读取excel转换成数组
 * 
 * @param string $excelFile 文件路径
 * @param string $excelType excel后缀格式
 * @param int $startRow 开始读取的行数
 * @param int $endRow 结束读取的行数
 * @retunr array
 */
function readFromExcel($excelFile, $excelType = null, $startRow = 1, $endRow = null,$xls_import_columns)  
{

    $excelReader = PHPExcel_IOFactory::createReader("Excel5");

    $excelReader->setReadDataOnly(true);

    //如果有指定行数，则设置过滤器
    if ($startRow && $endRow) 
    {
        $perf           = new PHPExcel_ReadFilter();
        $perf->startRow = $startRow;
        $perf->endRow   = $endRow;
        $excelReader->setReadFilter($perf);
    }

    $phpexcel    = $excelReader->load($excelFile);
    $activeSheet = $phpexcel->getActiveSheet();
    if (!$endRow) 
    {
        $endRow = $activeSheet->getHighestRow(); //总行数
    }

    $highestColumn      = $activeSheet->getHighestColumn(); //最后列数所对应的字母，例如第2行就是B
    $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数

    $data = array();
    for ($row = $startRow; $row <= $endRow; $row++) 
    {
        if($row == 1)
        {
            continue;
        }
        for ($col = 0; $col < $highestColumnIndex; $col++) 
        {
            $v = (string) $activeSheet->getCellByColumnAndRow($col, $row)->getValue();
            if(!$v)
            {
                continue;
            }
            $data[$row][$xls_import_columns[$col]] = $v;
        }
    }
    
    return $data;
} 



//demo,此方式可以解决大数据量导入导致内存溢出问题
//用来生成对应excel每一列key值的数组
$xls_upload_data_arr = array('user_name');
if (! empty ( $_FILES ['file'] ['name'] )){
    $tmp_file = $_FILES ['file'] ['tmp_name'];
    $file_types = explode ( ".", $_FILES ['file'] ['name'] );
    $file_type = $file_types [count ( $file_types ) - 1];


    /*判别是不是.xls文件，判别是不是excel文件*/
    if (strtolower ( $file_type ) != "xls" && strtolower ( $file_type ) != "xlsx"){
        sys_msg("不是Excel文件，重新上传", 1);
    }

    copy($tmp_file, '../users.xlsx');



    $startRow  = 1;
    $endRow    = 300;
    do {

                      
        $res = readFromExcel($file_path, null, $startRow, $endRow,$xls_upload_data_arr);

        //进行自己的操作。。。。。

        $startRow = $endRow + 1;
        $endRow = $endRow + 300;

    } while (!empty($res));


}else{
    sys_msg("请选择文件", 1);
}

@unlink('../users.xlsx');