<?php
header("Content-Type=text/html;charset=utf-8");
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}

if(!isset($_REQUEST['getContent'])){
	reOut();
}
$getContent=trim($_REQUEST['getContent']);
if($getContent==""){
	reOut();
}
if($getContent==1){
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select name from ahu_admin where priority=0";
	$res=$conn->query($sql);
	$k=$res->num_rows;
	$arr['Num']=1;
	$arr["cnt"]=$k;
	$m=1;
	while($row=$res->fetch_assoc()){
		$arr[$m]=$row["name"];
		$m++;	
	}
	json_encode($arr);
	reOut();
}

?>
