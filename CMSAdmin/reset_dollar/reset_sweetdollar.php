<?php require_once('../../_common/conn_open.php'); ?>
<?php require_once('../inc/function.php'); ?>
<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
$yesterday = date("Y-m-d",strtotime("-1 day",strtotime("now")));
$newExpiryDate = date("Y-m-d",strtotime("+1 year",strtotime($yesterday)));

$sql = "CREATE TEMPORARY TABLE `tmp_expired_member` ( SELECT `id`,`validDollar` FROM `tbl_member` WHERE `dollarExpireDate`<='".$yesterday."' OR `dollarExpireDate`='' OR `dollarExpireDate` IS NULL)";
//echo $sql.'<br/>';
$rs = mysql_query($sql) or die(mysql_error());
$sql = "INSERT INTO `tbl_dollar_history` (`memberId`,`action`,`amt`,`recordDate`,`remarks`) SELECT `id`,'Deduct',`validDollar`,CURDATE(),'4' FROM `tmp_expired_member` AS `tmp`";
//echo $sql.'<br/>';
mysql_query($sql) or die(mysql_error());
$sql = "UPDATE `tbl_member` SET `dollarExpireDate`= '".$newExpiryDate."',`validDollar`=0 WHERE `id` IN (SELECT `id` FROM `tmp_expired_member`)";
//echo $sql.'<br/>';
if(mysql_query($sql)){
	echo '1';
}else{
	echo '0';
}
?>
<?php require_once('../../_common/conn_close.php'); ?>