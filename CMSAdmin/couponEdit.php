<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="coupon";
	$tbl="coupon";
	$title = "<a href='coupon.php'>Coupon</a>";

	$id = intval($_GET["id"]);
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;

	$result = mysql_query("SELECT * FROM ".$tbl." where id='$id'");
	$row = mysql_fetch_array($result);

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form1").validationEngine();
	});
	$(function() {
		 $(".datepicker").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
	});
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
</script>

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

		<form action="couponAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="page" value="<?=$module?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="id" value="<?=$id?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<?php if ($msg==1){ ?>
			<tr>
				<td colspan="2"><div align="center" class="msg"><strong>Record Saved</strong></div></td>
			</tr>
			<?php } ?>
			<tr>
				<td >Code:</td>
				<td>
				<input type="text" name="code" id="code" size="20" maxlength="32" value="<?=$row['code']?>" readonly/>
				<div id="showAjaxResult" style="font-size: 11px;font-weight: bold;color:#FF3300;display:inline;"> </div>
				</td>
			</tr>
			<tr>
				<td>Title(EN):</td>
				<td><input type="text" name="title_en" class="validate[required]" value="<?=$row['title_en']?>"></td>
			</tr>
			<tr>
				<td>Title(TC):</td>
				<td><input type="text" name="title_tc" class="validate[required]" value="<?=$row['title_tc']?>"></td>
			</tr>
			<tr>
				<td width="25%">Start Date: </td>
				<td><input type="text" name="date_start" size="10" maxlength="10" class="datepicker validate[required]" value="<?=$row['date_start']?>"/></td>
			</tr>
			<tr>
				<td height="26" >End Date: </td>
				<td><input type="text" name="date_end" size="10" maxlength="10" class="datepicker validate[required]" value="<?=$row['date_end']?>"/></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><label style="margin-right:5px"><input type="radio" name="type" value="1" <?=$row['type']==1?"checked":""?>>Total Amount</label><label><!--<input type="radio" name="type" value="2" <?=$row['type']==2?"checked":""?>>Item</label>--></td>
			</tr>
			<tr>
				<td></td>
				<td><label for="value" style="margin-right:5px">Discount Amount:</label><input type="text" name="value" id="value" size="15" value="<?=$row['value']?>"></td>
			</tr>
			<tr>
				<td>Status:</td>
				<td>
				<label><input name="status" type="radio" value="1" <?php echo $row["status"]==1?"checked":""; ?> />Active</label>
				<label><input name="status" type="radio" value="0" <?php echo $row["status"]==0?"checked":""; ?>/>Inactive</label>
				</td>
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