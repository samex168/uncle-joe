<?php
if(!isset($_SESSION)){
	session_start();
}
$_SESSION['admin']='';
$_SESSION['username']='';
unset($_SESSION['admin']);
unset($_SESSION['username']);
echo '<script>window.location="index.php";</script>';
?>