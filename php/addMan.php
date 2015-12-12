<?php
header("Content-Type=text/html;charset=utf-8");
$arr =array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}
if(!isset($_REQUEST['name'])||!isset($_REQUEST['password'])){
	reOut();
}
$name=trim($_REQUEST['name']);
$password=trim($_REQUEST['password']);
if($name==""||$password==""){
	reOut();
}
$password=md5($password);
$conn=new mysqli("localhost","ahuname","password","ahu");
$conn->query("set name 'utf8'");
$sql="select password from ahu_admin where name='".$name."';";
$res=$conn->query($sql);
if($res->num_rows!=0){
	$arr['Num']=1;
	reOut();
}

$sql="insert into ahu_admin (name,password) values ('".$name."','".$password."');";
$conn->query($sql);
$conn->close();
$arr["Num"]=2;
reOut();


?>
