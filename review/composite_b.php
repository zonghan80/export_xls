<?php

include 'config.php';

//ini_set('display_errors', 1);
//$dbc = dbconnect(true);

$typ = ($_POST['taste'] >= 1 && $_POST['taste'] <= 2) ? (int) $_POST['taste'] : 1;
$typ2 = ($_POST['pack'] >= 1 && $_POST['pack'] <= 2) ? (int) $_POST['pack'] : 1;
$typ3 = $_POST['card'];
$fbidn = $_POST['fbidn'];
$ffbidn = $_POST['ffbidn'];

/*
  input: $base64_source,$dst_1,$dst_2,$angle,$photo_x,$photo_y
  ouput: json
 *  */
/*$fbid = $_POST['fbid'];
$ffbid = $_POST['ffbid'];*/


$path = "./pic/";    
deldir($path);

$typ_arr = array(
    "1" => array("src" => "src/box_r.png"),
    "2" => array("src" => "src/box_r.png"),
);
if ($_POST['taste'] == '1') {
    $typ2_arr = array(
        "1" => array("src" => "src/r0.png"),
        "2" => array("src" => "src/r1.png"),
    );
} else {
    $typ2_arr = array(
        "1" => array("src" => "src/left0.png"),
        "2" => array("src" => "src/left1.png"),
    );
}

$imgs_img = Imagecreatefrompng($typ_arr[$typ]['src']);
$imgs_img1 = Imagecreatefrompng($typ2_arr[$typ2]['src']);
$picture_url = 'src/a.png'; //FB個人頭像
$picture_url2 = 'src/b.png';

$im = imagecreatetruecolor(1200, 628); // 新建真彩色圖像
$big = '175';
$a1 = Imagecreatefrompng($picture_url); 
$a2 = Imagecreatefrompng($picture_url2);
$src_im = imagecreatetruecolor($big, $big);
$src_im2 = imagecreatetruecolor($big, $big);
$coler = imagecolorallocate($im, 0, 0, 0); //為圖像分配颜色

imagecopyresampled($src_im, $a1, 0, 0, 0, 0, $big, $big, imagesx($a1), imagesy($a1)); //拷貝部分圖像並調整大小 $a1 到 $src_im
imagecopyresampled($src_im2, $a2, 0, 0, 0, 0, $big, $big, imagesx($a2), imagesy($a2));

//typ3
$m=mb_strlen($typ3,'utf-8');
$s=strlen($typ3);
if($s==$m){
   $font = 'MSJH.ttf';
}else{
   $font = 'MSJH.ttf'; 
}

$width3         = 620;
$font_size_3      = 5;
$font_width_3     = imagefontwidth( $font_size_3 ) * strlen( $typ3 ) /2;
$x3              = $width3 / 2 - $font_width_3;
imagettftext($imgs_img, 22, 0, $x3, 480, $coler, $font, $typ3);

//fbid
$m1=mb_strlen($fbidn,'utf-8');
$s1=strlen($fbidn);
if($s1==$m1){
   $font1 = 'MSJH.ttf';
}else{
   $font1 = 'MSJH.ttf'; 
}

$width         = 400;
$font_size      = 5;
$font_width     = imagefontwidth( $font_size ) * strlen( $fbidn ) /2;
$x              = $width / 2 - $font_width;
imagettftext($imgs_img, 22, 0, $x, 350, $coler, $font1, $fbidn); //字寫入圖

//ffbid
$m2=mb_strlen($ffbidn,'utf-8');
$s2=strlen($ffbidn);
if($s2==$m2){
   $font2 = 'MSJH.ttf';
}else{
   $font2 = 'MSJH.ttf'; 
}

$width2         = 840;
$font_size_2   = 5;
$font_width_2     = imagefontwidth( $font_size_2 ) * strlen( $ffbidn ) /2;
$x2              = $width2 / 2 - $font_width_2;
imagettftext($imgs_img, 22, 0, $x2, 350, $coler, $font2, $ffbidn);

imagecopy($imgs_img, $imgs_img1, 0, 0, 0, 0, 1200, 628);
imagecopy($im, $src_im, 132, 135, 0, 0, imagesx($src_im), imagesy($src_im));
imagecopy($im, $src_im2, 346, 135, 0, 0, imagesx($src_im2), imagesy($src_im2));
imagecopy($im, $imgs_img, 0, 0, 0, 0, 1200, 628);

$FileName1 = substr(uniqid(true, true), 0, 20); //取一段亂數名稱
imagejpeg($im, 'pic/' . $FileName1 . '.jpg');

$ok = outputJSON(true, array("filename" => $FileName1.'.jpg', "imagepath" => 'http://localhost:81/test/pic/'. $FileName1 . '.jpg'));

echo $ok;

?>