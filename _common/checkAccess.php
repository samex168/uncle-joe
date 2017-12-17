<?php
	require_once("CSRF.php");
	if(!isset($_SESSION['member']) || empty($_SESSION['member'])){
		redirect("login.php");
		exit();
	}