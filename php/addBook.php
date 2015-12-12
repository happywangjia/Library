<?php
header("Content-Type=text/html;charset=utf-8");
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
}
if(!isset($_REQUEST['shuNum'])||!isset($_REQUEST['shuName'])||!isset($_REQUEST['shuJie'])){
	reOut();
}
$shuNum=trim($_REQUEST['shuNum']);
$shuName=trim($_REQUEST['shuName']);
$shuJie=trim($_REQUEST['shuJie']);
if($shuNum==""||$shuName==""){
	reOut();
}
$conn=new mysqli('localhost','ahuname','password','ahu');
$conn->query("set names 'utf8'");
$sql="select book_name from ahu_books where book_num='".$shuNum."';";
$res=$conn->query($sql);
if($res->num_rows!=0){
	$arr['Num']=1;
	reOut();
}
$res->free();
$sql="insert into ahu_books (book_num,book_name,is_borrow,intro) values ('"
	.$shuNum."','".$shuName."',0,'".$shuJie."');";
$conn->query($sql);
$arr['Num']=2;
reOut();

?>
