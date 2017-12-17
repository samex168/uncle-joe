<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="deliveryCharge";
	$tbl="system_vars";
	$title = "Delivery Charge";

	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$charge_result = mysql_query("SELECT * FROM ".$tbl." WHERE type='delivery_charge'");
	$noCharge_result = mysql_query("SELECT * FROM ".$tbl." WHERE type='no_delivery_charge'");
	$totalRecord = mysql_num_rows(mysql_query("SELECT * FROM ".$tbl." WHERE type='delivery_charge'"));

	require_once('include/_header.php');
?>

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

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="10%" align="center">Area</td>
				<td width="20%">Delivery Charge</td>
				<td width="20%">No Delivery Charge</td>
				<td width="5%" align="center" >&nbsp;</td>
			</tr>
			<?php while($charge_row = mysql_fetch_array($charge_result)){ $noCharge_row = mysql_fetch_array($noCharge_result) ?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td align="center"><?=getAreaName($charge_row["name"])?></td>
				<td>$ <?=$charge_row["value"]?></td>
				<td>$ <?=$noCharge_row["value"]?></td>
				<td align="center" >
				<input type="button" value="Edit" onClick="window.location='<?=$module?>Edit.php?name=<?=$charge_row['name']?>'">
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