<?php
 error_reporting(0);
require_once('../_common/conn_open.php');
require_once('../_common/common.php');

$id = intval($_POST["id"]);
$tbl = $_POST["tbl"];
if(isset($_POST["folder"]))
	$folder = $_POST["folder"];
else
	$folder = null;
$page = $_POST["page"];
$action = $_POST["action"];
$map_path = ("../".$folder);

if($action == "edit"){
$query = mysql_query("select * from ".$tbl);
$numberfields = mysql_num_fields($query);
	$lastfield = $numberfields-1;
	$sqlupdateStr= "";
	for ($i=0; $i<$numberfields ; $i++ ) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_POST[$fieldname]) || isset($_FILES[$fieldname])){
		   if($fieldname =="id"){
		   	   //skip
		   }elseif(substr($fieldname,0,3) == "img"){
		   		if($_FILES[$fieldname]["name"] != ""){
					//$ran = strtotime("now");
					$tmpimgname = $_FILES[$fieldname]["name"];
					move_uploaded_file($_FILES[$fieldname]["tmp_name"], $map_path ."/" . $tmpimgname);
					 $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$tmpimgname."',";
				}
			}else{
		   		if (isset($_POST[$fieldname])){
			   		$fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
				   if($i == $lastfield){
						$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."'";
				   }else{
					   $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
				   }
				}
		   }
		}

	}

	$sql = "UPDATE `".$tbl."` SET ".$sqlupdateStr." WHERE `id` = '$id' LIMIT 1";
	mysql_query($sql) or die(mysql_error());
	echo "<script>window.location='".$page."Edit.php?id=$id&msg=1';</script>";
}

if($action == "add"){

	$query = mysql_query("select * from ".$tbl);
	$numberfields = mysql_num_fields($query);
	$lastfield = $numberfields-1;
	$sqlfieldname = "";
	$sqlfieldvalue = "";
	for ($i=0; $i<$numberfields ; $i++ ) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_POST[$fieldname]) || isset($_FILES[$fieldname])){
       		consoleLog($fieldname);
       	   if(isset($_POST[$fieldname]))
	   	   		$fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
		   if($i == $lastfield){
			   $sqlfieldname = $sqlfieldname."`".$fieldname."`";
			   $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."'";
		   }elseif($fieldname =="id"){
		   		//do noting
		   }elseif(substr($fieldname,0,3) == "img"){
		   		if($_FILES[$fieldname]["name"] != ""){
					//$ran = strtotime("now");
					$tmpimgname = $_FILES[$fieldname]["name"];
					move_uploaded_file($_FILES[$fieldname]["tmp_name"], $map_path ."/" . $tmpimgname);
					$sqlfieldname = $sqlfieldname."`".$fieldname."`,";
			   		$sqlfieldvalue= $sqlfieldvalue."'".$tmpimgname."',";
				}
			}else{
			   $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
			   $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
		   }
		}


	}

	$sql = "INSERT INTO ".$tbl." (".$sqlfieldname.") VALUES (".$sqlfieldvalue.")";

	mysql_query($sql) or die(mysql_error());
	$id = mysql_insert_id();

	echo "<script>window.location='".$page.".php';</script>";
}
?>