<?php
header("content-type:text/html;charset=utf-8");
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}
if(isset($_SERVER['HTTP_REFERER'])){
	if(strpos($_SERVER['HTTP_REFERER'],'http://localhost')!=0){
		reOut();
	}
}else{
	reOut();
}
if(!isset($_REQUEST['uName'])||!isset($_REQUEST['jwPsw'])||!isset($_REQUEST['password'])||!isset($_REQUEST['nPassword'])||!isset($_REQUEST['checkcode'])){
	reOut();
}
$uName=trim($_REQUEST['uName']);
$jwPsw=trim($_REQUEST['jwPsw']);
$password=trim($_REQUEST['password']);
$nPassword=trim($_REQUEST['nPassword']);
$checkcode=trim($_REQUEST['checkcode']);
if($password!=$nPassword||strlen($password)<6){
	reOut();
}
session_start();
$checkcode2='';
if(isset($_SESSION['myCheckCode'])){
	$checkcode2=trim($_SESSION['myCheckCode']);
}else{
	reOut();
}
if($checkcode!=$checkcode2){
	reOut();
}
$infoUrl="http://localhost/ahu/php/ahu2.php?name=".$uName."&password=".$jwPsw;
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$infoUrl);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
$res=curl_exec($curl);
$res=json_decode($res);
$num=$res->Num;
if($num==0){
	reOut();
}
else if($num==1){
	$arr["Num"]=1;
	reOut();
}
$password=md5($password);
$xName=$res->name;
$className=$res->className;
$conn=new mysqli('localhost','ahuname','password','ahu');
$conn->query("set names 'utf8'");
$sql="insert into ahu_uinfo (learn_num,name,password,class) values ('".$uName."','".$xName."','".$password."','".$className."');";
$res=$conn->query($sql);
if($res==0){
	$arr["Num"]=2;
	reOut();
}
$conn->close();
$_SESSION['xName']=$xName;
$_SESSION['uName']=$uName;
$arr["Num"]=3;
reOut();
?>
