<?php
 error_reporting(0);
 require_once('../_common/conn_open.php');

$tbl = $_POST["tbl"];
$page = $_POST["page"];
$action = $_POST["action"];
$id = $_POST['id'];

if($action == "edit"){
	$query = mysql_query("select * from ".$tbl);
	$numberfields = mysql_num_fields($query);
	$lastfield = $numberfields-1;
	$sqlupdateStr= "";
	for ($i=0; $i<$numberfields ; $i++ ) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_POST[$fieldname])){
	   	   	$fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
		   	if($fieldname =="id"){
		   	   $id = intval($_POST[$fieldname]);
		   	}elseif(substr($fieldname,0,4) == "date"){
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
		}
	}

	$sql = "UPDATE `".$tbl."` SET ".$sqlupdateStr." WHERE `id` = '$id'";
	mysql_query($sql) or die(mysql_error());

	echo "<script>window.location='".$page."Edit.php?id=$id&msg=1';</script>";
}
?>