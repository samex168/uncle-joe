<? require_once('_common/conn_open.php'); ?>
<? require_once('_common/common.php'); ?>
<? require_once('_common/CSRF.php'); ?>
<? require_once('_common/data_functions.php'); ?>
<?// require_once('_common/cart.php'); ?>
<?
ini_set("display_errors", true);
mb_internal_encoding('UTF-8');
if(!isset($_SESSION)){
	session_start();
}
$sandbox = 'true';
?>
<?php

if(sizeof($_SESSION["order_detail_form"])<=0 || sizeof($_SESSION["cart"])<=0 || !isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN']) || !CSRF::verifyToken('cart_confirm-form', $_POST['UNCLE-JOE_CSRF_TOKEN'])){
    redirect("b5_cart.php");
    exit();
}
$forceCancel = false;
/*foreach($cart->itemList as $item){
	if(getStock($item->itemID)<$item->quantity){
		$forceCancel = true;
		break;
	}
}*/
if(!$forceCancel){
	$emailItemList = '';

	$_SESSION['order_detail_form']['orderNo'] = genOrderNo();
  $_SESSION['order_detail_form']['orderStatus'] = 1;

  if($_SESSION['order_detail_form']['coupon']!=""){
    $coupon = getCouponByCode($_SESSION['order_detail_form']['coupon']);
  }
  $discount = $_SESSION['order_detail_form']['cartTotal'] * getCouponDiscount($_SESSION['order_detail_form']['coupon']);

  $deliveryCharge = $_SESSION["order_detail_form"]["deliveryCharge"];

  $query = mysql_query("SELECT * FROM order_details");
  $numberfields = mysql_num_fields($query);
  $lastfield = $numberfields-1;
  $sqlfieldname = "";
  $sqlfieldvalue = "";
  for ($i=0; $i<$numberfields ; $i++ ) {
     $fieldname = mysql_field_name($query, $i);
     if(isset($_SESSION["order_detail_form"][$fieldname])){
          $fieldvalue = htmlspecialchars($_SESSION["order_detail_form"][$fieldname], ENT_QUOTES);
          if($i == $lastfield){
             $sqlfieldname = $sqlfieldname."`".$fieldname."`";
             $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."'";
          }elseif($fieldname =="id"){
              //do noting
          }elseif(substr($fieldname,0,4) == "date"){
              if($fieldvalue==""){
                  $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                  $sqlfieldvalue= $sqlfieldvalue."null,";
              }else{
                  $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                  $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
              }
          }else{
              $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
              $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
          }
      }
  }
  $sql = "INSERT INTO order_details (".$sqlfieldname.") VALUES (".$sqlfieldvalue.")";
  mysql_query($sql) or die(mysql_error());
  $id = mysql_insert_id();

  $orderNo = $_SESSION["order_detail_form"]["orderNo"];
  $email = $_SESSION['member']['email'];
  foreach ($_SESSION["cart"] as $key => $value) {
      $sql = "INSERT INTO order_product (orderNo,plu,qty) VALUES ('".$orderNo."','".$key."','".$value."')";
      mysql_query($sql) or die(mysql_error());
      $emailItemList .='<tr>
    <td>'.$key.'</td>
    <td>'.getValueFromTableByCon("name_tc","product","plu",$key).'</td>
    <td>'.$value.'</td>
    <td>HKD $ '.getValueFromTableByCon("price","product","plu",$key).'</td>
  	</tr>';
  }

  $sql = "INSERT INTO order_change_log (orderNo,updateField,updateBy) VALUES ('$orderNo','New Order',1)";
  mysql_query($sql) or die(mysql_error());

	require_once("_common/sendmail.php");
	
	$recipient = $_SESSION["member"]["email"];
	$subject = 'Uncle Joe eShop New Order';
	$content = '<div style="border: 1px #ccc solid;padding: 10px;width:60%">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr><th align="center" colspan="3">UNCLE JOE 正品專賣</th></tr>
  <tr><th align="center" colspan="3">訂單</th></tr>
  <tr>
    <td colspan="3"><strong>聯絡資料</strong></td>
  </tr>
  <tr>
    <td width="10%">收件人 :</td>
    <td width="15%">'.$_SESSION["order_detail_form"]["addressee"].'</td>
    <td></td>
  </tr>
  <tr>
    <td>聯絡電話 :</td>
    <td>'.$_SESSION["order_detail_form"]["tel"].'</td>
    <td></td>
  </tr>
  <tr>
    <td valign="top">送貨地址 :</td>
    <td>座數 / 樓層 / 單位 :</td>
    <td>'.$_SESSION["order_detail_form"]["flat"].'</td>
  </tr>
  <tr>
    <td></td>
    <td>大廈名稱 :</td>
    <td>'.$_SESSION["order_detail_form"]["building"].'</td>
  </tr>
  <tr>
    <td></td>
    <td>屋苑 / 街道 :</td>
    <td>'.$_SESSION["order_detail_form"]["street"].'</td>
  </tr>
  <tr>
    <td></td>
    <td>地區 :</td>
    <td>'.$_SESSION["order_detail_form"]["district"].'</td>
  </tr>
  <tr>
    <td></td><td></td>
    <td>'.getAreaName($_SESSION["order_detail_form"]["area"]).'</td>
  </tr>
  <tr>
    <td>送貨日期 :</td>
    <td>'.$_SESSION["order_detail_form"]["date_delivery"].'</td>
  </tr>
  </table><br/>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="4"><strong>訂單詳情</strong></td>
  </tr>
  <tr>
    <td width="20%">商品編號</td>
    <td width="50%">商品名稱</td>
    <td width="12%">數量</td>
    <td width="18%">售價</td>
  </tr>'.$emailItemList.'
  <tr><td colspan="4"><hr/></td><td></tr>
  <tr><td colspan="2"></td>
    <td align="right">商品總額 : </td>
    <td>HKD $ '.$_SESSION["order_detail_form"]["cartTotal"].'</td>
  </tr>';
  if($discount>0){
    $content .= '<tr><td colspan="2"></td><td align="right">'.$coupon['title_tc'].' :</td><td>HKD $ ('.$discount.')</td></tr>';
  }
  $content .= '<tr><td colspan="2"></td>
    <td align="right">運費 : </td>
    <td>HKD $ '.$_SESSION["order_detail_form"]["deliveryCharge"].'</td>
  </tr>
  <tr><td colspan="2"></td>
  <td align="right">訂單總額 : </td>
  <td>HKD $ '.($_SESSION["order_detail_form"]["cartTotal"]+$_SESSION["order_detail_form"]["deliveryCharge"]-$discount).'</td>
  </tr>
  </table></div><div style="width:60%" align="center">此電郵為系統自動送出，請勿回覆。</div>';

	if($sandbox == 'true'){
		$res = sendmail($recipient,$subject,$content,$PARAMS['email_sender']);
	}else{
		$res = sendmail($recipient,$subject,$content,$PARAMS['email_sender']);
	}

}else{
	echo '<script>alert("Sorry, some products are out of stock!");</script>';
	echo '<script>window.location="b5_cart.php";</script>';
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>UNCLE JOE</title>
<link rel="shortcut icon" href="./favicon.ico" />
<script>
function submitform()
{
  document.checkout.submit();
}
</script>
</head>

<body>
<h2 align="center">In Process ...</h2> <br/>
<? if($sandbox == 'true'){ ?>
<form name="checkout" id="checkout" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="business" value="seller_1296180842_biz@gmail.com" />
  <input type="hidden" name="notify_url" value="http://demo.freecomm.com/unclejoe/php/eshop_verify.php">
  <input type="hidden" name="cancel_return" value="http://demo.freecomm.com/unclejoe/php/eshop_payment_cancel.php?orderNo=<?=$orderNo?>">
	<input type="hidden" name="return" value="http://demo.freecomm.com/unclejoe/php/eshop_payment_success.php?orderNo=<?=$orderNo?>">
<? }else{ ?>
<form id="checkout" name="checkout" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="business" value="" />
  <input type="hidden" name="notify_url" value="verify.php">
	<input type="hidden" name="cancel_return" value="eshop_payment_cancel.php?orderID=<?=$orderID?>">
	<input type="hidden" name="return" value="eshop_payment_success.php?orderID=<?=$orderID?>">
<? } ?>
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="invoice" value="<?=$orderNo?>">
	<input type="hidden" name="currency_code" value="HKD">
	<input type="hidden" name="lc" value="US">	
  <input type="hidden" name="charset" value="utf-8" />
  <?php if($discount>0){ ?>
  <input type="hidden" name="discount_amount_cart" value="<?=$discount?>" />
  <?php } ?>
  <?php if($deliveryCharge>0){ ?>
  <input type="hidden" name="handling_cart" value="<?=$deliveryCharge?>" />
  <?php } ?>
	<? 
		$i = 0;
		foreach($_SESSION["cart"] as $key => $value){ 
			$itemName = getValueFromTableByCon("name_tc","product","plu",$key);
			$unitPrice = getValueFromTableByCon("price","product","plu",$key);
	?>
  <input type="hidden" name="item_name_<?php echo ($i+1); ?>" value="<?=$itemName?>">
	<input type="hidden" name="item_number_<?php echo ($i+1); ?>" value="<?=$key?>"> 
	<input type="hidden" name="quantity_<?php echo ($i+1); ?>" value="<?=$value?>">
	<input type="hidden" name="amount_<?php echo ($i+1); ?>" value="<?=$unitPrice?>">
	<? 
			$i++;
		} 
	?>
</form>
<?php
	unset($_SESSION["order_detail_form"]);
  unset($_SESSION["cart"]);
  unset($_SESSION["coupon"]);
	echo '<script> submitform(); </script>';
?>

</body>
</html>
<? require_once('_common/conn_close.php'); ?>