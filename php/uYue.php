<?php
header("Content-Type=text/html;charset=utf-8");
session_start();
$num=$_REQUEST['Num'];
if($num==1){
	$learNum=$_SESSION['uName'];
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select book_num,start_time,retu_time,has_retu,actual_retu,fine from ahu_brr_book where learn_num='".$_SESSION['uName']."' order by id desc;";
	$res=$conn->query($sql);
	$arr=array();
	$cnt=$res->num_rows;
	$arr['cnt']=$cnt;
	for($i=0;$i<$cnt;$i++){
		$jian=array();
		$tmp=$res->fetch_assoc();
		$jian['bookNum']=$tmp['book_num'];
		$jian['startTime']=$tmp['start_time'];
		$jian['retuTime']=$tmp['retu_time'];
		$jian['haRetr']=$tmp['has_retu'];
		$jian['actualRetu']=$tmp['actual_retu'];
		$jian['fine']=$tmp['fine'];
		$sql="select book_name from ahu_books where book_num='".$jian['bookNum']."';";
		$bookName=$conn->query($sql)->fetch_assoc()['book_name'];
		$jian['bookName']=$bookName;
		$arr["".$i]=$jian;
	}
	echo json_encode($arr);
	die();
}
?>
