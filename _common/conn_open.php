<?php
require_once("CSRF.php");
require_once("common.php");

$username = "root";
$password = "admin";
$database = "db_unclejoe";

mysql_connect("localhost",$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_query("SET NAMES 'utf8'");