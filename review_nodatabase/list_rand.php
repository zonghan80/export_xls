<?php

include 'config.php';

date_default_timezone_set('Asia/Taipei');

$name = $_POST['name'];
$pic_no = rand(1,2);
$pic_src= $pic_no . '.jpg';
$time= date("Y/m/d H:i:s");
$count = $_POST['count'];

if($name != '' || $name != NULL){
	echo outputJSON(true, array("ID"=> $count, "name" => $name ,"pic_src" => $pic_src,"time" => $time));
} else {
	echo outputJSON(false, array("title" => "名字欄位不能為空！"));
}