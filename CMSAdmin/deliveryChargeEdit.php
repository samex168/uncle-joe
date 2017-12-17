<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="deliveryCharge";
	$tbl="system_vars";
	$title = "<a href='deliveryCharge.php'>Delivery Charge</a>";

	$name = $_GET["name"];
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;

	$charge_result = mysql_query("SELECT * FROM ".$tbl." WHERE name='$name' AND type='delivery_charge'");
	$noCharge_result = mysql_query("SELECT * FROM ".$tbl." WHERE name='$name' AND type='no_delivery_charge'");
	$charge_row = mysql_fetch_array($charge_result);
	$noCharge_row = mysql_fetch_array($noCharge_result);

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
	  	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Edit</span>
	  	<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php'"  />

		<form action="deliveryChargeAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="page" value="<?=$module?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="name" value="<?=$name?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<?php if ($msg==1){ ?>
			<tr>
				<td colspan="2"><div align="center" class="msg"><strong>Record Saved</strong></div></td>
			</tr>
			<?php } ?>
			<tr>
				<td width="20%">Area:</td>
				<td width="80%">
				<input type="text" name="area" size="20" maxlength="15" value="<?=getAreaName($name)?>" readonly />
				</td>
			</tr>
			<tr>
				<td>Delivery Charge :</td>
				<td><input type="text" name="deliveryCharge" value="<?=$charge_row['value']?>"  class="validate[required]" /></td>
			</tr>
			<tr>
				<td>No Delivery Charge :</td>
				<td><input type="text" name="noDeliveryCharge" value="<?=$noCharge_row['value']?>"  class="validate[required]" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<input name="Submit" type="submit" value="Save" class="bdtxt">
				<input name="reset" type="reset" value="Reset" class="bdtxt">
				</td>
			</tr>
			</table>
		</form>
	   </div>
	</div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>