<?php
session_start();
$checkcode="";
for($i=0;$i<4;$i++){
	$checkcode.=dechex(rand(1,15));
}
$_SESSION['myCheckCode']=$checkcode;
$img=imagecreatetruecolor(50,18);
$bgcolor=imagecolorallocate($img,151,183,229);
imagefill($img,0,0,$bgcolor);
$black=imagecolorallocate($img,0,0,0);
for($i=0;$i<20;$i++){
	imageline($img,rand(0,50),rand(0,18),rand(0,50),rand(0,18),imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255)));
}
imagestring($img,5,rand(2,5),rand(2,4),$checkcode,$black);
header("content-type:image/png");
imagepng($img);
?>
