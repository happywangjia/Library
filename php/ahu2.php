<?php
header("Content-type:text/html;charset=utf-8");
$domain="http://jw3.ahu.cn/";
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}

if(!isset($_REQUEST['name'])||$_REQUEST['name']==null){
	reOut();
}
if(!isset($_REQUEST['password'])||$_REQUEST['password']==null){
	reOut();
}
$name=$_REQUEST['name'];
$password=$_REQUEST['password'];
$cookiefile=dirname(__FILE__)."/cookies/".md5($name);
$headers=array(
    "User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:41.0) Gecko/20100101 Firefox/41.0",
    "Referer:http://jw3.ahu.cn/",
    "Host:jw3.ahu.cn"
);
function login($name,$password){
	global $cookiefile;
	global $headers;
	$loginUrl="http://jw3.ahu.cn/default2.aspx";
	$data=array(
		'txtUserName'=> $name,
		'TextBox2'=> $password,
		'RadioButtonList1'=>'学生',
		'hidPdrs'=>'',
		'hidsc'=>'',
		'Button1'=>'',
		'lbLanguage'=>'',
		'__VIEWSTATE'=>'dDwyODE2NTM0OTg7Oz43V12xeO03cDNjW0o9HdZA42Lo6Q=='
	);
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_URL,$loginUrl);
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_COOKIEJAR,$cookiefile);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($curl,CURLOPT_POST,true);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
	$res=curl_exec($curl);
	curl_close($curl);
	return $res;
}
function parseLogin($res){
	preg_match("/<span\sid=\"xhxm\">(.*)<\/span>/",$res,$matches);
	if(count($matches)==0){
		return null;		
	}
	$name=$matches[1];
	$name=substr($name,0,strlen($name)-4);
	return $name;
}
function getKbUrl($res){
	$tmp="学生个人课表";
	$tmp=iconv("utf-8","gb2312",$tmp);
	preg_match("/<li><a\shref=\"(\S*?)\"\starget=\'zhuti'\sonclick=\"GetMc\(\'$tmp\'\);/",$res,$matches);	
	$url=$matches[1];
	return $url;
}
function getKb($kbUrl){
	global $cookiefile;
	global $headers;
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_AUTOREFERER,true);
	curl_setopt($curl,CURLOPT_URL,$kbUrl);
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_COOKIEFILE,$cookiefile);		
	curl_setopt($curl,CURLOPT_COOKIEJAR,$cookiefile);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($curl,CURLOPT_HTTPGET,true);
	$res=curl_exec($curl);
	curl_close($curl);
	return $res;
}
function getinfo($res){
	global $className;
	$cName="行政班：";
	$cName=iconv("utf-8","gb2312",$cName);
	preg_match("/<span\sid=\"Label9\">$cName(.*?)<\/span>/",$res,$matches);
	$className=$matches[1];
}
$res=login($name,$password,$cookiefile);
$name=parseLogin($res);
if($name==null){
	$arr["Num"]=1;
	reOut();
}
$kbUrl=$domain.getKbUrl($res);
$res=getKb($kbUrl);
getinfo($res);
$name=iconv('gb2312','utf-8',$name);
$className=iconv('gb2312','utf-8',$className);
$arr["Num"]=2;
$arr["name"]=$name;
$arr["className"]=$className;
reOut();
?>
