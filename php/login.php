<?php
session_start();
header("Content-Type=text/html;charset=utf-8");

$arr=array("errNum"=>1);
function errOut(){
	global $arr;
	echo json_encode($arr);
	die();
}

if(!isset($_REQUEST["role"])||!isset($_REQUEST['name'])||
	!isset($_REQUEST['pass'])||!isset($_REQUEST['checkcode'])){
	errOut();
}
$checkcode=trim($_REQUEST['checkcode']);
$checkcode2="";
if(isset($_SESSION['myCheckCode'])&&$checkcode!=""){
	$checkcode2=trim($_SESSION['myCheckCode']);
}else{
	errOut();
}
if($checkcode!=$checkcode2){
	errOut();
}
$name=trim($_REQUEST['name']);
$pass=md5(trim($_REQUEST['pass']));
$role=trim($_REQUEST["role"]);
if($name==''||$pass==""||$role==""){
	errOut();
}


$conn=new mysqli('localhost','ahuname','password','ahu');
$conn->query("set names 'utf8'");
if($role=='stu'){
	$sql="select password from ahu_uinfo where learn_num='".$name."';";

}else{
	$sql="select password from ahu_admin where name='".$name."';";
}  
$res=$conn->query($sql);
$pwd=$res->fetch_assoc();
$pwd=$pwd['password'];
$res->free();
if($pwd==$pass){
	if($role=='stu'){
		$sql="select name from ahu_uinfo where learn_num='".$name."';";   
		$res=$conn->query($sql);
		$xName=$res->fetch_assoc()['name'];
		$_SESSION['xName']=$xName;
		$_SESSION['uName']=$name;
		unset($_SESSION['mName']);
		unset($_SESSION['myCheckCode']);
		$res->free();
		$conn->close();
		setCookie('uName',$xName,time()+604800);
		$arr["errNum"]=4;
		errOut();
	}else{  
		$_SESSION['mName']=$name;
		unset($_SESSION['xName']);
		unset($_SESSION['uName']);
		setCookie('mName',$name,time()+604800);
		$arr["errNum"]=5;
		errOut();
	}       
}else{ 
	errOut();
} 

?>
