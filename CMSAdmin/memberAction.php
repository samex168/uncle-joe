<?php
 error_reporting(0);
require_once('../_common/conn_open.php');
require_once('../_common/common.php');
require_once('include/function.php');

$id = intval($_POST["id"]);
$tbl = $_POST["tbl"];
$oldpwd = $_POST['oldpwd'];

$module = $_POST["module"];
$action = $_POST["action"];

if($action == "update"){
	//Member update history
	$sql = "SELECT * FROM `member` WHERE `id`='".$id."'";
	$mbRS = mysql_query($sql);
	if(mysql_num_rows($mbRS)==1){
		$mbRow = mysql_fetch_assoc($mbRS);
		foreach($mbRow as $k=>$v){
			if(isset($_POST[$k]) && $_POST[$k]!=$v){
				$sql = "INSERT INTO `member_update_history` (`member_id`,`update_field`,`old_value`,`new_value`,`updateBy`) VALUES ('".$id."','".$k."','".$v."','".$_POST[$k]."',1)";
				mysql_query($sql);
			}else if($k=="accept_promotion" && $v=1 && !isset($_POST[$k])){
				$sql = "INSERT INTO `member_update_history` (`member_id`,`update_field`,`old_value`,`new_value`,`updateBy`) VALUES ('".$id."','".$k."','".$v."',0,1)";
				mysql_query($sql);
			}
		}
	}

	$query = mysql_query("select * from member");
	$numberfields = mysql_num_fields($query);
	$lastfield = $numberfields-1;
	$sqlupdateStr= "";
	for ($i=0; $i<$numberfields; $i++) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_POST[$fieldname])){
       		$fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
		   if($fieldname =="id"){
		   	   //skip
		   }else if(substr($fieldname,0,8)=="password" && $fieldvalue!=$oldpwd){
		   		if(isset($_POST['changepwd'])){
			   		$fieldvalue = passwordEncode($fieldvalue);
			   		$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
			   	}
		   }else if($fieldname=="birthYear" || $fieldname=="birthMonth" || substr($fieldname,0,4)=="date"){
		   		if($fieldvalue=="")
		   			$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = null,";
		   		else
		   			$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
		   }else{
				if($i == $lastfield){
					$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."'";
				}else{
					$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
				}
		   }
		}else if($fieldname=="accept_promotion"){
			$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '0',";
		}

	}
	$sql = "UPDATE `member` SET ".$sqlupdateStr." WHERE `id` = '$id'";
	mysql_query($sql) or die(mysql_error());

	if($_POST['orderNo']!=""){
		$orderNo = $_POST['orderNo'];
		echo "<script>window.location='memberEdit.php?id=$id&module=$module&orderNo=$orderNo&msg=1';</script>";
	}else{
		echo "<script>window.location='memberEdit.php?id=$id&module=$module&msg=1';</script>";
	}
}

?>