<?php
	require_once('../_common/CSRF.php');
	require_once('../_common/common.php');
	require_once('../_common/conn_open.php');
	require_once('include/function.php');

	$uid = filterStr($_POST['uid']);
	$psw = md5(filterStr($_POST['psw']));


	$sql = "SELECT * FROM `user` WHERE `username`='".$uid."' AND `password_hash`='".$psw."' AND `status`='1'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=1){
		// login fail
		require_once('../_common/conn_close.php');
		echo '<script>alert("Incorrect ID or Password!");</script>';
		echo '<script>window.location="index.php";</script>';
		exit();
	}else{
		$row = mysql_fetch_array($result);
		$_SESSION['admin'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		require_once('../_common/conn_close.php');
		echo '<script>window.location="main.php";</script>';
	}
?>