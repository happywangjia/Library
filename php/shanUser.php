<?php
header("Content-Type=text/html;charset=utf-8");
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}

if(!isset($_REQUEST['name'])){
	reOut();
}
$name=trim($_REQUEST['name']);
if($name==""){
	reOut();
}
$conn=new mysqli('localhost','ahuname','password','ahu');
$conn->query("set names 'utf8'");
$sql="select password from ahu_uinfo where learn_num='".$name."';";
$res=$conn->query($sql);
if($res->num_rows==0){
	$arr['Num']=1;
	reOut();
}
$res->free();
$sql="delete from ahu_uinfo where learn_num='".$name."';";
$conn->query($sql);
$conn->close();
$arr['Num']=2;
reOut();


?>
