<?php
	require_once('conn.php');
	$pid = $_GET['pid'];
	$deletesql = "call del_product($pid);";
	if(mysql_query($deletesql)){
		echo "<script>alert('删除成功');window.location.href='index.php';</script>";
	}else{
		echo "<script>alert('删除失败');window.location.href='index.php';</script>";
	}