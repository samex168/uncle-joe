<?php
 error_reporting(0);
require_once('../_common/conn_open.php');
require_once('../_common/common.php');

$tbl = $_POST["tbl"];
$page = $_POST["page"];
$action = $_POST["action"];
$name = $_POST["name"];

$deliveryCharge = $_POST['deliveryCharge'];
$noDeliveryCharge = $_POST['noDeliveryCharge'];

if($action == "edit"){
	if($deliveryCharge != ""){
		$sql = "UPDATE `system_vars` SET `value`=$deliveryCharge WHERE `name`='$name' AND type='delivery_charge'";
		mysql_query($sql) or die(mysql_error());
	}
	if($noDeliveryCharge != ""){
		$sql = "UPDATE `system_vars` SET `value`=$noDeliveryCharge WHERE `name`='$name' AND type='no_delivery_charge'";
		mysql_query($sql) or die(mysql_error());
	}
	
	echo "<script>window.location='".$page."Edit.php?name=$name&msg=1';</script>";
}

require_once('../_common/conn_close.php');
?>