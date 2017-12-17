<?php  
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('../_common/data_functions.php');

	$orderNo = mysql_real_escape_string($_GET['orderNo']);

	$sql = mysql_query("SELECT * FROM order_details WHERE orderNo='$orderNo'");
	$order_row = mysql_fetch_array($sql);
	$product_sql = mysql_query("SELECT * FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu=`p`.plu WHERE orderNo='$orderNo'");
	while ($row=mysql_fetch_array($product_sql)) {
      	$productList .='<tr>
    	<td>'.$row['plu'].'</td>
    	<td>'.$row['name_tc'].'</td>
    	<td>'.$row['qty'].'</td>
    	<td>HKD $ '.$row['price'].'</td>
  		</tr>';
  	}
  	$coupon = getCouponByCode($order_row['coupon']);
  	if($order_row['discount']!=""){
		$discount = $order_row['cartTotal']*(1-$order_row['discount']);
  	}else{
  		$discount = 0;
  	}

	$output = '<div style="border: 1px #ccc solid;padding: 10px;width:100%">
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr><th align="center" colspan="3">UNCLE JOE 正品專賣</th></tr>
	<tr><th align="center" colspan="3">訂單</th></tr>
	<tr>
		<td colspan="3"><strong>聯絡資料</strong></td>
	</tr>
	<tr>
		<td width="15%">收件人 :</td>
		<td width="20%">'.$order_row["addressee"].'</td>
		<td></td>
	</tr>
	<tr>
		<td>聯絡電話 :</td>
		<td>'.$order_row["tel"].'</td>
		<td></td>
	</tr>
	<tr>
		<td valign="top">送貨地址 :</td>
		<td>座數 / 樓層 / 單位 :</td>
		<td>'.$order_row["flat"].'</td>
	</tr>
	<tr>
		<td></td>
		<td>大廈名稱 :</td>
		<td>'.$order_row["building"].'</td>
	</tr>
	<tr>
		<td></td>
		<td>屋苑 / 街道 :</td>
		<td>'.$order_row["street"].'</td>
	</tr>
	<tr>
		<td></td>
		<td>地區 :</td>
		<td>'.$order_row["district"].'</td>
	</tr>
	<tr>
		<td></td><td></td>
		<td>'.getAreaName($order_row["area"]).'</td>
	</tr>
	<tr>
		<td>送貨日期 :</td>
		<td>'.$order_row["date_delivery"].'</td>
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
	</tr>'.$productList.'
	<tr><td colspan="4"><hr/></td><td></tr>
	<tr><td colspan="2"></td>
		<td align="right">商品總額 : </td>
		<td>HKD $ '.$order_row["cartTotal"].'</td>
	</tr>';
	if($discount>0){
	$output .= '<tr><td colspan="2"></td><td align="right">'.$coupon['title_tc'].' :</td><td>HKD $ ('.$discount.')</td></tr>';
	}
	$output .= '<tr><td colspan="2"></td>
		<td align="right">運費 : </td>
		<td>HKD $ '.$order_row["deliveryCharge"].'</td>
	</tr>
	<tr><td colspan="2"></td>
		<td align="right">訂單總額 : </td>
		<td>HKD $ '.($order_row["cartTotal"]+$order_row["deliveryCharge"]-$discount).'</td>
	</tr>
	</table></div><div style="width:60%" align="center"></div>';


	print $output;

	require_once("../_common/conn_close.php");
?>

<script>
  window.onload = function () {
    window.print();
    setTimeout(function(){window.close();}, 1);
  }
</script>