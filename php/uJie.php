<?php
session_start();
header("Content-Type=text/html;charset=utf-8");
$Num=$_REQUEST['Num'];
if($Num==1){
	$str=$_REQUEST['content'];
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select book_num,book_name,is_borrow from ahu_books where book_name like '%".$str."%';";
	$res=$conn->query($sql);
	$num=$res->num_rows;
	$arr=array("Num"=>$num);
	for($i=0;$i<10&&$i<$num;$i++){
		$row=$res->fetch_assoc();
		$ss=array();
		$ss['book_num']=$row['book_num'];
		$ss['book_name']=$row['book_name'];
		$ss['is_borrow']=$row['is_borrow'];
		$arr[''+$i]=$ss;
	}
	$conn->close();
	echo json_encode($arr);
	die();
}else if($Num==2){
	$str=$_REQUEST['content'];
	$page=$_REQUEST['page'];
	$cnt=($page-1)*10;
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select book_num,book_name,is_borrow from ahu_books where book_name like '%".$str."%' limit ".$cnt.",10;";
	$res=$conn->query($sql);
	$num=$res->num_rows;
	$arr=array("Num"=>$num);
	for($i=0;$i<10&&$i<$num;$i++){
		$row=$res->fetch_assoc();
		$ss=array();
		$ss['book_num']=$row['book_num'];
		$ss['book_name']=$row['book_name'];
		$ss['is_borrow']=$row['is_borrow'];
		$arr[''+$i]=$ss;
	}  
	$conn->close();
	echo json_encode($arr);
	die();
}else if($Num==3){
	$arr=array();
	$bookNum=$_REQUEST['bookNum'];	
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set names 'utf8'");
	$sql="select book_name,is_borrow,intro,jie_person from ahu_books where book_num='".$bookNum."';";
	$res=$conn->query($sql)->fetch_assoc();
	$bookName=$res['book_name'];
	$isBorrow=$res['is_borrow'];
	$intro=$res['intro'];
	$jiePerson=$res['jie_person'];
	$arr['bookName']=$bookName;
	$arr['isBorrow']=$isBorrow;
	$arr['intro']=$intro;
	if($isBorrow==1){
		$sql="select retu_time from ahu_brr_book where book_num='".$bookNum."' order by id desc;";
		$res=$conn->query($sql);
		$res2=$res->fetch_assoc();
		$reTime=$res2['retu_time'];
		$arr['reTime']=$reTime;
		$sql="select name from ahu_uinfo where learn_num='".$jiePerson."';";
		$arr['jiePerson']=$conn->query($sql)->fetch_assoc()['name'];
		$res->free();
	}
	$conn->close();
	echo json_encode($arr);
	die();
}else if($Num==4){
	$arr=array();
	$bookNum=$_REQUEST['bookNum'];
	$conn=new mysqli('localhost','ahuname','password','ahu');
	$conn->query("set naems 'utf8'");
	$sql="select count(*) as num from ahu_brr_book where learn_num='".$_SESSION['uName']."' and has_retu=0";
	$num=$conn->query($sql)->fetch_assoc()['num'];
	if($num>=5){
		$arr['num']=0;
		echo json_encode($arr);                                                                                              
		die();
	}           
	$sql="insert into ahu_brr_book (book_num,learn_num,start_time,retu_time) values ('".$bookNum."','".$_SESSION['uName']."',curdate(),date_add(curdate(),interval 1 month));";
	$conn->query($sql);
	$sql="update ahu_books set is_borrow=1,jie_person='".$_SESSION['uName']."' where book_num='".$bookNum."';";
	$conn->query($sql);
	$arr['num']=1;
	$conn->close();
	$arr['num']=1;
	echo json_encode($arr);
	die();
}

?>
