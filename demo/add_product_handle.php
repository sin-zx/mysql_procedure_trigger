<?php 
  	require_once('conn.php');
	$pname = $_POST['pname'];
	$qoh = $_POST['qoh'];
	$qoh_threshold = $_POST['qoh_threshold']? $_POST['qoh_threshold'] : 20;
	$discnt_rate = $_POST['discnt_rate']? $_POST['discnt_rate'] : 1;
	$original_price = $_POST['original_price'];
	$imgname = $_POST['imgname'];
	$sid = $_POST['sid'];

	if(empty($pname) ){
		echo "<script>alert('商品名不能为空！');window.history.back(-1);</script>";
	}elseif(empty($qoh)){
		echo "<script>alert('库存不能为空！');window.history.go(-1);</script>";
	}elseif(empty($original_price)){
		echo "<script>alert('价格不能为空！');window.history.go(-1);</script>";
	}else{
		$sql = "call new_product('$pname', $qoh, $qoh_threshold, $original_price,$discnt_rate,$sid,'$imgname');";

		$res = mysql_query($sql) or die(mysql_error());
		if($res){
			echo "<script>alert('操作成功！');window.location.href='index.php';</script>";
		}else{
			echo "<script>alert('操作失败！error:".mysql_error()."');window.history.go(-1);</script>";
		}
	}
 