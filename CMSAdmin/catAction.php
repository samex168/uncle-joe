<?php
 error_reporting(0);
 require_once('../_common/conn_open.php');

$tbl = $_POST["tbl"];
if(isset($_POST["folder"]))
	$folder = $_POST["folder"];
else
	$folder = null;
$page = $_POST["page"];
$action = $_POST["action"];
if(isset($_POST["cat1"]))
	$cat1 = intval($_POST["cat1"]);
else
	$cat1 = null;
if(isset($_POST["cat2"]))
	$cat2 = intval($_POST["cat2"]);
else
	$cat2 = null;
if(isset($_POST["cat3"]))
	$cat3 = intval($_POST["cat3"]);
else
	$cat3 = null;
$map_path = ("../".$folder);

if($action == "edit"){
	$query = mysql_query("select * from ".$tbl);
	$numberfields = mysql_num_fields($query);
	$lastfield = $numberfields-1;
	$sqlupdateStr= "";
	for ($i=0; $i<$numberfields ; $i++ ) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_POST[$fieldname]) || isset($_FILES[$fieldname])){
       		if(isset($_POST[$fieldname]))
	   	   		$fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
		   	if($fieldname =="id"){
		   	   $id = intval($_POST[$fieldname]);
		   	}elseif(substr($fieldname,0,3) == "img"){
		   		if($_FILES[$fieldname]["name"] != ""){
					//$ran = strtotime("now");
					$tmpimgname = $_FILES[$fieldname]["name"];
					move_uploaded_file($_FILES[$fieldname]["tmp_name"], $map_path ."/" . $tmpimgname);
					$sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$tmpimgname."',";
				}
			}elseif(substr($fieldname,0,3) == "doc"){
		   		if($_FILES[$fieldname]["name"] != ""){
					//$ran = strtotime("now");
					$tmpdocname = $_FILES[$fieldname]["name"];
					move_uploaded_file($_FILES[$fieldname]["tmp_name"], $map_path ."/" . $tmpdocname);
					 $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$tmpdocname."',";
				}
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

	$sql = "UPDATE `".$tbl."` SET ".$sqlupdateStr." WHERE `id` = '$id' LIMIT 1";
	mysql_query($sql) or die(mysql_error());

	echo "<script>window.location='".$page."Edit.php?id=$id&msg=1&cat1=$cat1&cat2=$cat2&cat3=$cat3';</script>";
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
			}elseif(substr($fieldname,0,3) == "doc"){
		   		if($_FILES[$fieldname]["name"] != ""){
					//$ran = strtotime("now");
					$tmpdocname = $_FILES[$fieldname]["name"];
					move_uploaded_file($_FILES[$fieldname]["tmp_name"], $map_path ."/" . $tmpdocname);
					$sqlfieldname = $sqlfieldname."`".$fieldname."`,";
			   		$sqlfieldvalue= $sqlfieldvalue."'".$tmpdocname."',";
				}
			}elseif(substr($fieldname,0,4) == "date"){
				if($fieldvalue==""){
					$sqlfieldname = $sqlfieldname."`".$fieldname."`,";
			   		$sqlfieldvalue= $sqlfieldvalue."null,";
				}
		   		else{
		   			$sqlfieldname = $sqlfieldname."`".$fieldname."`,";
			   		$sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
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

	echo "<script>window.location='".$page.".php?cat1=".$cat1."&cat2=".$cat2."&cat3=".$cat3."&id=".$id."&msg=1';</script>";
}
?>