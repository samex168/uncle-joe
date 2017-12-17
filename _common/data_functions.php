<?php
function getValueFromTableByCon($value, $tbl, $con, $conVal, $status=null){
  $statuscon = $status==null?"":" AND status='".$status."'";
  $sql = mysql_query("SELECT $value FROM $tbl WHERE $con='$conVal' $statuscon");
  $result = mysql_fetch_array($sql);
  return $result[0];
}

function getProductByPLU($plu){
  $result = mysql_fetch_array(mysql_query("SELECT * FROM product WHERE plu='$plu'"));
  return $result;
}

function countCartTotal(){
  $total = 0;
  foreach ($_SESSION['cart'] as $key => $value) {
    $result = mysql_fetch_array(mysql_query("SELECT price FROM product WHERE plu = '$key'"));
    $total += $result[0]*$value;
  }
  return $total;
}

function checkDeliveryCharge($total, $area){
  $noCharge = getSystemVars($area, "no_delivery_charge");
  if($total > $noCharge)
    return 0;
  else
    return getSystemVars($area, "delivery_charge");
}

function getCouponByCode($code){
  $result = mysql_fetch_array(mysql_query("SELECT * FROM coupon WHERE code='$code'"));
  return $result;
}

function getCouponDiscount($code=null){
  if($code!=null){
    $type = mysql_fetch_array(mysql_query("SELECT type FROM coupon WHERE code = '$code'"));
    if($type[0]==1){
      $result = mysql_fetch_array(mysql_query("SELECT value FROM coupon WHERE code = '$code'"));
      return 1-$result[0];
    }
    return 0;
  }

  $type = mysql_fetch_array(mysql_query("SELECT type FROM coupon WHERE code = '".$_SESSION['coupon']."'"));
  if($type[0]==1){
    $result = mysql_fetch_array(mysql_query("SELECT value FROM coupon WHERE code = '".$_SESSION['coupon']."'"));
    return countCartTotal()*(1-$result[0]);
  }
  return 0;
}

function getSystemVars($name, $type){
  $result = mysql_fetch_array(mysql_query("SELECT value FROM system_vars WHERE name='$name' AND type='$type'"));
  return $result[0];
}

function genOrderNo(){
	$result = mysql_fetch_array(mysql_query("SELECT orderNo FROM order_details ORDER BY orderNo DESC LIMIT 1"));
	$no = $result[0];
	if(substr($no, 0, 8)==date("Ymd")){
		$last = intval(substr($no, 8))+1;
		$no = date("Ymd").sprintf('%06d', $last);
	}else{
		$no = date("Ymd")."000001";
	}
	return $no;
}

function countOrderTotal($orderNo){
  $sql = mysql_query("SELECT * FROM order_details WHERE orderNo='$orderNo'");
  $result = mysql_fetch_array($sql);
  $discount = $result['discount']==""?0:$result['cartTotal']*(1-$result['discount']);
  $total = $result['cartTotal']+$result['deliveryCharge']-$discount;
  return $total;
}


?>