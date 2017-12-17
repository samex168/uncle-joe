<?php
 error_reporting(0);
require_once('../_common/conn_open.php');
require_once('../_common/common.php');
require_once('include/function.php');
require_once('../_common/data_functions.php');

$id = intval($_POST["id"]);
$orderNo = $_POST['orderNo'];
$tbl = $_POST["tbl"];
$module = $_POST["module"];
$action = $_POST["action"];

if($action == "update"){
	//Order change Log
	$sql = "SELECT * FROM `order_details` WHERE `id`='".$id."'";
	$odRS = mysql_query($sql);
	if(mysql_num_rows($odRS)==1){
		$odRow = mysql_fetch_assoc($odRS);
		foreach($odRow as $k=>$v){
			if(isset($_POST[$k]) && $_POST[$k]!=$v){
				$sql = "INSERT INTO `order_change_log` (`orderNo`,`updateField`,`oldValue`,`newValue`,`updateBy`) VALUES ('".$orderNo."','".$k."','".$v."','".$_POST[$k]."',2)";
				mysql_query($sql) or die(mysql_error());
			}
		}
	}

	$query = mysql_query("select * from order_details");
	$numberfields = mysql_num_fields($query);
	$lastfield = $numberfields-1;
	$sqlupdateStr= "";
	for ($i=0; $i<$numberfields; $i++) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_POST[$fieldname])){
       		$fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
		   if($fieldname =="id"){
		   	   //skip
		   }else if(substr($fieldname,0,4)=="date"){
		   		if($fieldvalue=="")
		   			$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = null,";
		   		else
		   			$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
		   }else if($fieldname=="coupon"){
		   		$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
		   		$coupon = getCouponByCode($fieldvalue);
		   		if($coupon['value']!=""){
		   			$sqlupdateStr = $sqlupdateStr."`discount` = '".$coupon['value']."',";
		   		}
		   }else{
				if($i == $lastfield){
					$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."'";
				}else{
					$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
				}
		   }
		}
	}
	$sql = "UPDATE `order_details` SET ".$sqlupdateStr." WHERE `id` = '$id'";
	mysql_query($sql) or die(mysql_error());

	$cartTotal = mysql_fetch_array(mysql_query("SELECT cartTotal FROM order_details WHERE orderNo='$orderNo'"));

	if($cartTotal[0] > getSystemVars($_POST['area'],'no_delivery_charge')){
		$sql = "UPDATE `order_details` SET deliveryCharge=0 WHERE `id` = '$id'";
	}else{
		$sql = "UPDATE `order_details` SET deliveryCharge='".getSystemVars($_POST['area'],'delivery_charge')."' WHERE `id` = '$id'";
	}
	mysql_query($sql) or die(mysql_error());

	echo "<script>window.location='orderEdit.php?orderNo=$orderNo&msg=1';</script>";
}

require_once('../_common/conn_close.php');
?>