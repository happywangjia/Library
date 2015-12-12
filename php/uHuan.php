<?php
session_start();
header("Content-Type=text/html;charset=utf-8");
$num=$_REQUEST['Num'];
if($num==1){
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select book_num,start_time,retu_time from ahu_brr_book where learn_num='".$_SESSION['uName']."' and has_retu=0;";
	$res=$conn->query($sql);
	$cnt=$res->num_rows;
	$arr=array('cnt'=>$cnt);
	for($i=0;$i<$cnt;$i++){
		$tmp=$res->fetch_assoc();
		$bookNum=$tmp['book_num'];
		$startTime=$tmp['start_time'];
		$retuTime=$tmp['retu_time'];
		$sql="select book_name from ahu_books where book_num='".$bookNum."';";
		$tmp2=$conn->query($sql);
		$bookName=$tmp2->fetch_assoc()['book_name'];
		$jian=array();
		$jian['bookNum']=$bookNum;
		$jian['startTime']=$startTime;
		$jian['retuTime']=$retuTime;
		$jian['bookName']=$bookName;
		$arr[''+$i]=$jian;
	}
	$conn->close();
	echo json_encode($arr);
	die();
}else if($num==2){
	$bookNum=$_REQUEST['bookNum'];
	$now=date("y-m-d",time());
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select id,retu_time from ahu_brr_book where book_num='".$bookNum."' order by id desc";
	$res=$conn->query($sql)->fetch_assoc();
	$id=$res['id'];
	$retuTime=$res['retu_time'];
	$time1=strtotime($now);
	$time2=strtotime($retuTime);
	$sql="update ahu_books set is_borrow=0,jie_person=null where book_num='".$bookNum."';";
	$conn->query($sql);
	$fine=0.0;
	if($time1>$time2){
		$end=round(($time1-$time2)/3600/24);
		$fine=$end*0.1;
	}
	$sql="update ahu_brr_book set has_retu=1,actual_retu=curdate(),fine='".$fine."' where id='".$id."';";
	$conn->query($sql);
	$conn->close();
	$arr=array("fine"=>$fine);
	echo json_encode($arr);
	die();
}

?>
