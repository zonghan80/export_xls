<?php
include_once 'config.php';

$dbc = dbconnect(true);

// 輸出Excel檔案頭，可把citi_export.$file_ending換成你要的檔名 
$file_type = "vnd.ms-excel"; 
$file_ending = "xls"; 
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=citi_export.$file_ending");
header("Content-Transfer-Encoding: binary ");
header("Pragma: no-cache");
header("Expires: 0");

// 設定資料庫搜尋條件
$sql = "SELECT `ID`, `cname`, `phone`, `email`, `ISSHARE`, `creat_date` FROM `test` WHERE `ID` in (SELECT min(`ID`) FROM `test` WHERE `cname` != '' or `phone` != '' or `email` != '' GROUP by `phone`)";
$result = mysqli_query($dbc, $sql);

//設定第一行的表頭
$sep = "\t";
$title2Write = array('編號' , '姓名' , '手機' , '電子信箱' , '是否分享' , '建立日期');
for ( $i = 0 ; $i < 6 ; $i++ ) {
	echo mb_convert_encoding($title2Write[$i],"big5","big5"). "\t"; //轉字體(第一個big為想轉成的字體)
}
print("\n"); 

//資料開始塞到 Excel 的所有欄位
$i = 0;

while($record = mysqli_fetch_array($result,MYSQLI_ASSOC)) {	
	$ex[]=$record;
} 	
$schema_insert = "";
foreach ($ex as $value):
	if($value["ISSHARE"] != '' && $value["ISSHARE"] != NULL){
		$schema_insert .= $value["ID"].$sep.$value["cname"].$sep.$value["phone"].$sep.$value["email"].$sep.$value["ISSHARE"].$sep.$value["creat_date"].$sep."\n";
	}
	else{
		$schema_insert .= $value["ID"].$sep.$value["cname"].$sep.$value["phone"].$sep.$value["email"].$sep."0".$sep.$value["creat_date"].$sep."\n";
	}
endforeach;

$schema_insert = str_replace($sep."$", "", $schema_insert);
$schema_insert .= "\t";

print(trim($schema_insert));
print "\n";
$i++;

?>