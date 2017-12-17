<?php
if(!function_exists('checkName')){
	function checkName($db,$dataField,$id){
		$chkName = mysql_fetch_array(mysql_query("SELECT `".$dataField."` FROM ".$db." WHERE `id`='".$id."'"));
		return $chkName[0];
	}
}


function checkexist($db,$field,$fieldValue){
	
      $chk = mysql_num_rows(mysql_query("select * from ".$db." where ".$field."='".$fieldValue."'"));

	 return $chk;  
}
function getRecordNo ($str){
	$chk = mysql_num_rows(mysql_query($str));
	return $chk;  
}

function encode($str){
	return base64_encode($str);
}
function decode($str){
	return base64_decode($str);
}
function getStatus($str){
	if($str == "1"){
		return "Active";
	}else{
		return "Inactive";
	}
}

function checkServiceCat($contentId,$catId){
	$chk = mysql_num_rows(mysql_query("select catId from tbl_contentCat where contentId='$contentId' and catId = '$catId'"));
	if ($chk > 0 ){
	return true;
	}else{
	return false;
	}
}

?>