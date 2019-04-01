<?php
function TransformSymbol($content,$direction){
	if (is_array($content)){
		foreach ($content as $key=>$value){
			$content[$key] = TransformSymbol($value,$direction);
		}
	}else $content = Replace($content,$direction);
	return $content;
}
function Replace($content,$direction){
	$nft = array("<"  ,">"  ,"`"     ,"'"     ,"\""   ,","      ,"*"       ,"#" ,"("    ,")"    ,"/"      ,"\n","\r");//,"-"      
	$wft = array("&lt","&gt","&acute","&acute","&quot","&sbquo;","&lowast;","＃","&#40;","&#41;","&frasl;",""  ,""  );//,"&minus;"
	return $direction?str_replace($nft,$wft,$content):str_replace($wft,$nft,$content);
}
function outputJSON($flag,$data){
	return json_encode(array("flag"=>$flag,"data"=>$data));
}
function limitDomainAndCheck( $domainAllowed ){
	if(!$GLOBALS["_ontesting"]){
		$referrer = null;
		if (isset($_SERVER['HTTP_REFERER'])) {
			$referrer = $_SERVER['HTTP_REFERER'];
		} else if (isset($_SERVER['HTTP_ORIGIN'])) {
			$referrer = $_SERVER['HTTP_ORIGIN'];
		}
		if(!empty($referrer)){
			$isAllowed = checkDomain($referrer,$domainAllowed);
			if( !$isAllowed || !checkUAG() ){
				expressionJSON(403,"not allowed");
			}else{
				header('Access-Control-Allow-Origin:'.$isAllowed); 
			}		
		}else{
			expressionJSON(403,"not allowed");
		}
	}
}
function checkDomain($client,$domainAry){
	$check = false;
	$domain = explode("/",$client);
	for($i=0;$i<count($domainAry);$i++){
		if($domain[2]==$domainAry[$i]){
			$check = $domain[0]."//".$domain[2];
			break;
		}	
	}
	return $check;
}
function checkUAG(){
	if($_SERVER['HTTP_USER_AGENT'] == ""){
		return false;
	}else{
		return true;
	}
}
function expressionJSON($c,$m){
	$result = array();
	$result["status"] = $c;
	$result["msg"] = $m;
	if(isset($_GET['callback'])){
		echo $_GET['callback']."(".json_encode($result).")";
	}else{
		echo json_encode( $result );
	}
	die;		
}

function _fnreplaceAttack($value){
	//預防XSS攻擊 替換特殊符號
	$Rcase = array("`", "'", "\"", "--", ";", ",", "(", ")", "/", "*");
	$value = str_replace($Rcase, "", $value);	
	return $value;
}
//email encode( $t = 0 ) and decode ( $t = 1 )
function _fnEncodeEmail($v,$m,$t){
	if($t == 0){
		$tmp = base64_encode(urlencode($v));
		$out = _fnEncodeByMDway($tmp,$m,$t);
	}else{
		$tmp = _fnEncodeByMDway($v,$m,$t);
		$out = urldecode(base64_decode($tmp));
	}
	return $out;
}
function _fnEncodeByMDway($v,$m,$t){
	$n1=array(9,8,7,6,5,4,3,2,1,0);
	$n2=array(1,3,5,7,9,2,4,6,8,0);
	$n3=array(2,4,6,8,0,1,3,5,7,9);
	$n4=array(1,9,2,8,3,7,4,6,5,0);
	$n5=array(3,2,1,6,5,4,9,8,7,0);
	$n=array($n1,$n2,$n3,$n4,$n5); 
	$v=_fnNumberFormat($v);
	$va=str_split($v);
	
	$out="";
	for($i=0;$i<count($va);$i++){		
		if(is_numeric($va[$i])){
			if($t==0){
				$out=$out.($n[$m][$va[$i]]);
			}else{
			
				$out=$out._fnSearchAryPos($va[$i],$n[$m]);
			}	
		}else{
			$out=$out.$va[$i];
		}	
	}	
	return $out;
}
function _fnSearchAryPos($v,$nv){
 
	$out="";
 
	for($i=0;$i<count($nv);$i++){		
		if($nv[$i]==$v){
				$out=$i;
		}
	}
	return $out;
}
function mb_str_split( $string ) { 
    # Split at all position not after the start: ^ 
    # and not before the end: $ 
    return preg_split('/(?<!^)(?!$)/u', $string ); 
}
function _fnNumberFormat($v){
	$out="";
	$sa=mb_str_split($v);
	
	for($i=0;$i<count($sa);$i++){	
		$out=$out._fnCN2n(_fnN2n($sa[$i]));
	}

	return $out;
}
function _fnCN2n($v){ 
	if($v=="一"){
		return 1;
	}else if($v=="二"){
		return 2;
	}else if($v=="三"){
		return 3;
	}else if($v=="四"){
		return 4;
	}else if($v=="五"){
		return 5;
	}else if($v=="六"){
		return 6;
	}else if($v=="七"){
		return 7;
	}else if($v=="八"){
		return 8;
	}else if($v=="九"){
		return 9;
	}else{
		return $v;
	}

}
function _fnN2n($v){
	if($v=="０"){
		return 0;
	}else if($v=="１"){
		return 1;
	}else if($v=="２"){
		return 2;
	}else if($v=="３"){
		return 3;
	}else if($v=="４"){
		return 4;
	}else if($v=="５"){
		return 5;
	}else if($v=="６"){
		return 6;
	}else if($v=="７"){
		return 7;
	}else if($v=="８"){
		return 8;
	}else if($v=="９"){
		return 9;
	}else{
		return $v;
	}

}
?>