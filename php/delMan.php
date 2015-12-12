<?php
header("Content-Type=text/html;charset=utf-8");
$name=$_REQUEST['name'];
$conn=new mysqli('localhost','ahuname','password','ahu');
$conn->query("set names 'utf8'");
$sql="delete from ahu_admin where name='".$name."';";
$conn->query($sql);
$conn->close();
echo "ok";

?>
