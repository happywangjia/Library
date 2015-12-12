<?php
session_start();
header("Content-Type=text/html;charset=utf-8");
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}
if(!isset($_REQUEST['getContent'])||!isset($_SESSION["uName"])){
	reOut();	
}
$getContent=trim($_REQUEST['getContent']);
$uName=trim($_SESSION['uName']);
if($getContent==""||$uName==""){
	reOut();
}
if($getContent==2){
	session_destroy();
	die();
}

function getPic(){}

if($getContent==1){
	$arr["Num"]=1;
	$arr["uName"]=$uName;
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select name,pic from ahu_uinfo where learn_num='".$uName."';";
	$res=$conn->query($sql);
	if($res->num_rows==0)
		reOut();
	$get=$res->fetch_assoc();
	$arr["uPic"]=$get["pic"];
	$arr["uXName"]=$get['name'];
	json_encode($arr);
	reOut();
}

?>
