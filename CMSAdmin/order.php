<?php
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');
	require_once('../_common/data_functions.php');

	$module="order";
	$tbl="order_details";
	$title = "Order";
	$id = (isset($_GET['id']))?intval($_GET["id"]):'';

	$filter ="";
	$name = (isset($_GET['addressee']))?htmlspecialchars(str_replace("'", "", $_GET["addressee"]),ENT_QUOTES):'';
	$order = (isset($_GET['orderNo']))?htmlspecialchars(str_replace("'", "", $_GET["orderNo"]),ENT_QUOTES):'';
	if ($order !=""){
		$filter = $fileter." and orderNo LIKE '%".$order."%' ";
	}
	if($name !=""){
		$filter = $fileter." and addressee LIKE '%".$name."%' ";
	}

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
		$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	$sql = "SELECT * FROM `order_details` WHERE `orderNo` !='' ".$filter." ORDER BY date_order DESC, orderNo DESC LIMIT $offset, $pagingSize";
	$result = mysql_query($sql);
	$totalRecord = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM `order_details` WHERE `orderNo` !='' ".$filter));
	$totalRecord = $totalRecord[0];
	$totalPage = ceil($totalRecord/$pagingSize);

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<div class="main clearfix">
<div class="col_cat">
    <div class="cat_menus">
        <?php require_once('include/_menu.php'); ?>
    </div>
</div>
<div class="col_content clearfix">
	<div class="col_main">
      <div class="content">
      	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?></span>
      	<form name="form1" id="form1" action="order.php" method="get" onSubmit="return val()">
		  <table border="0" cellspacing="0" cellpadding="2" class="bdtxt txt12black">
            <tr>
              <td>OrderNo: <input type="text" name="orderNo" size="15" maxlength="32"></td>
              <td>Addressee: <input type="text" name="addressee" size="15" maxlength="20"></td>
              <td><input type="submit" name="Search" value="Search" class="txt12black"></td>
            </tr>
          </table>
		</form>
		<div style="margin-top:10px;"><span id="paging"></span><script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','&orderNo=<?php echo $order; ?>&customer=<?php echo $name; ?>');</script><span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>
		<?php if($totalRecord > 0 ) { ?>
		<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
		<tr>
			<td width="15%">Order No </td>
			<td width="13%">Addressee</td>
			<td width="10%" align="right">Total</td>
			<td width="8%" align="center" nowrap="nowrap">Payment status</td>
			<td width="6%" align="center" nowrap="nowrap">Order Status</td>
			<td width="12%" align="center" nowrap="nowrap">Order Date</td>
			<td width="10%" align="center">&nbsp;</td>
		</tr>
		<?php while($row = mysql_fetch_array($result)){ ?>
		<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
			<td><?=$row["orderNo"]?></td>
			<td><?=$row["addressee"]?></td>
			<td align="right">$<?=number_format($row['cartTotal']+$row['deliveryCharge']-($row['coupon']!=""?$row['cartTotal']*getCouponDiscount($row['coupon']):0),$PARAMS['decimals'])?></td>
			<td align="center"><?=getPaymentStatus($row["paymentStatus"])?></td>
			<td align="center"><?=getOrderStatus($row["orderStatus"])?></td>
			<td align="center"><?=$row["date_order"]?></td>
			<td align="center">
		      <input type="button" value="Order Detail" onClick="window.location='<?=$module?>Edit.php?orderNo=<?=$row["orderNo"]?>'">
		      </td>
		</tr>
		<?php } ?>
		</table>
		<?php }else{ ?>
 		 <div align="center" class="maincontxt"><strong class="txt13blue">No Records Found</strong><br></div>
		<?php } ?>
      </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>