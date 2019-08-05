<?php
include_once 'config.php';

$dbc = dbconnect(true);

// ��XExcel�ɮ��Y�A�i��citi_export.$file_ending�����A�n���ɦW 
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

// �]�w��Ʈw�j�M����
$sql = "SELECT `ID`, `cname`, `phone`, `email`, `ISSHARE`, `creat_date` FROM `test` WHERE `ID` in (SELECT min(`ID`) FROM `test` WHERE `cname` != '' or `phone` != '' or `email` != '' GROUP by `phone`)";
$result = mysqli_query($dbc, $sql);

//�]�w�Ĥ@�檺���Y
$sep = "\t";
$title2Write = array('�s��' , '�m�W' , '���' , '�q�l�H�c' , '�O�_����' , '�إߤ��');
for ( $i = 0 ; $i < 6 ; $i++ ) {
	echo mb_convert_encoding($title2Write[$i],"big5","big5"). "\t"; //��r��(�Ĥ@��big���Q�ন���r��)
}
print("\n"); 

//��ƶ}�l��� Excel ���Ҧ����
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