<?php

include_once 'config.php';
$award = array("go" => "1", "start_data" => "2019-03-01", "end_data" => "2019-05-31", "open_hour" => array(11,10,12,14,15,16,17,19,18,20,22), "all" => "1000");

$date_limit = 33; //每日中獎數量

//查看時間是否允許 
date_default_timezone_set('Asia/Taipei');
$now = $_POST['time'];

$name =$_POST['name'];

if($name = ''){
	die(outputJSON(TRUE, array("title" => "再接再厲唷", "take" => 'N')));
}
//允許測試時間
if ($award["go"]=='0') {
       die(outputJSON(TRUE, array("title" => "再接再厲唷~！", "take" => 'N')));
}

//$ko = $_SERVER['HTTP_HOST'];  //限制domain
/*if (!in_array($ko,array(DOMAINNAME,'zonghan.com.tw'))) {
    die(outputJSON(TRUE, array("title" => "再接再厲唷!", "take" => 'N')));
}*/


if ($now < $award["start_data"]) {
    echo outputJSON(false, array("title" => "活動時間尚未開始！！"));
    exit();
}
if ($now > $award["end_data"]) {
    echo outputJSON(false, array("title" => "活動時間已結束，感謝您的參與"));
    exit();
}


if (!in_array(date('H'), $award["open_hour"])) {
	die(outputJSON(TRUE, array("title" => "再接再厲唷！！!!！", "take" => 'N')));
}

$itemrate_str = "50,30,20";  //中獎機率(總合須為100 or 1000 or ...的數)
$itemnum_str = "2,1,0";  //  1為品脫杯  2為1+1
$get = promoteAwardRate($itemnum_str, $itemrate_str);


if ($get == '1') {
	 die(outputJSON(TRUE, array("title" => "品脫杯！", "take" => 'Y')));
} elseif ($get == '2') {
	die(outputJSON(TRUE, array("title" => "1+1！!!!!!!!!!!!!!!!!!!!!!", "take" => 'N')));
} else {
	die(outputJSON(TRUE, array("title" => "再接再厲唷！！！！！！", "take" => 'N')));
}
