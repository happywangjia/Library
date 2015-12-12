<?php
session_start();
header("Content-Type=text/html;charset=utf-8");
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}
if(!isset($_REQUEST['getContent'])||!isset($_SESSION["mName"])){
	reOut();	
}
$getContent=trim($_REQUEST['getContent']);
$mName=trim($_SESSION['mName']);
if($getContent==""||$mName==""){
	reOut();
}
if($getContent==2){
	session_destroy();
	die();
}

function getPic(){}

if($getContent==1){
	$arr["Num"]=1;
	$arr["mName"]=$mName;
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select priority,pic from ahu_admin where name='".$mName."';";
	$res=$conn->query($sql);
	if($res->num_rows==0)
		reOut();
	$get=$res->fetch_assoc();
	$arr["mPic"]=$get["pic"];
	$arr["priority"]=$get["priority"];
	json_encode($arr);
	reOut();
}

?>
