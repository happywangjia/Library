<?php
header("Content-Type=text/html;charset=utf-8");
session_start();
$arr=array("Num"=>0);
function reOut(){
	global $arr;
	echo json_encode($arr);
	die();
} 
function pan($email,$telephone){
	global $arr;
	$patternEmail = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	$patternTel="/^[1-9][0-9]{10}$/i";
	if($email!=""&&preg_match($patternEmail,$email)==false){
		$arr['Num']=2;
		reOut();

	}
	if($telephone!=""&&preg_match($patternTel,$telephone)==false){
		$arr['Num']=2;
		reOut();
	}
}
if(!isset($_SESSION)||!isset($_REQUEST['content'])){
	reOut();
}
$content=trim($_REQUEST['content']);
if($content==1){
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select learn_num,name,password,class,email,telephone from ahu_uinfo where learn_num='".$_SESSION['uName']."';";
	$res=$conn->query($sql);
	$row=$res->fetch_assoc();
	$arr['Num']=1;
	$arr['learn_num']=$row['learn_num'];
	$arr['name']=$row['name'];
	$arr['password']=$row['password'];
	$arr['class']=$row['class'];
	$arr['email']=$row['email'];
	$arr['telephone']=$row['telephone'];
	$_SESSION['psw']=$row['password'];
	reOut();

}else if($content==2){
	$email=trim($_REQUEST['email']);
	$telephone=trim($_REQUEST['telephone']);
	pan($email,$telephone);
	$password=$_SESSION['psw'];
	if(isset($_REQUEST['password'])&&trim($_REQUEST['password'])!=""){	
		$password=md5(trim($_REQUEST['password']));
	}
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="update ahu_uinfo set email='".$email."',telephone='".$telephone."',password='".$password."' where learn_num='".$_SESSION['uName']."';";
	$conn->query($sql);
	$conn->close();
	$arr['Num']=3;
	reOut();

}

?>
