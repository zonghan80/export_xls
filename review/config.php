<?php

include 'fn_api.php';
/*define("SQLACCOUNT", "root");
define("SQLPASSWORD", "1234");
define("SQLNAME", "test");
define("DOMAINNAME", "www.test.com.tw");

function dbconnect($e) {
    if ($e == true) {
        $con = mysqli_connect("localhost", SQLACCOUNT, SQLPASSWORD, SQLNAME);
        if (!$con) {
            die('Could not connect: ' . mysqli_error());
        } else {
			mysqli_query($con, "SET NAMES 'UTF8'");
            return $con;
        }
    } else {
        echo "connect is false!!";
    }
}


function safe_world($val) {  //檔SQL Injcettion(SQL資料隱碼攻擊)和XSS(跨網頁紙令碼)攻擊(簡易防止)
    $val = htmlspecialchars($val);
    return $val;
}*/

function promoteAwardRate($itemnum, $itemrate) {  //

    $itemnumarr = explode(",", $itemnum);
    $itemratearr = explode(",", $itemrate);
    $totalrate = array_sum($itemratearr);
    $ratearr = array();
    foreach ($itemratearr as $k => $val) {
        $ratecount = count($ratearr);
        $padnum = $ratecount + $val;
        $ratearr = array_pad($ratearr, $padnum, $k);
    }
    shuffle($ratearr);

    list($usec, $sec) = explode(' ', microtime());
    $p = (float) $sec + ((float) $usec * 100000);
    mt_srand($p);
    $randvalmax = ($totalrate - 1);
    $randval = mt_rand(0, $randvalmax);
    $key = $ratearr[$randval];
    $get = $itemnumarr[$key];

    return $get;
}

function deldir($path){	  //刪目錄下所有文件
    if(is_dir($path)){//是否為目錄	 
	$p = scandir($path);//掃描文件夾内所有文件夾和文件
	foreach($p as $val){		
			if($val !="." && $val !=".."){//排除目錄中的.和..			
				if(is_dir($path.$val)){//如果是目錄則到子目錄，繼續			
					deldir($path.$val.'/');//子目錄中刪文件夾和文件				
					@rmdir($path.$val.'/');//目錄清空後刪空文件夹
				}else{				
					unlink($path.$val);//刪文件
				}
			}
		}
	}
}

?>