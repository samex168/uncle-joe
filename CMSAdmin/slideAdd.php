<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="slide";
	$tbl="slide";
	$title = "<a href='slide.php'>Slide</a>";
	$folder = $PARAMS['bannerPath'];	

	require_once('include/_header.php');
?>
<script type="text/javascript">
	var isPLU = false;
	$(document).ready(function(){
		$("#form1").validationEngine();
	});
	$(function() {
		 $("#date_start").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
		 $("#date_end").datepicker({
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
			<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Add</span>
			<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php'"  />

			<form action="slideAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
				<input type="hidden" name="tbl" value="<?=$tbl?>">
				<input type="hidden" name="page" value="<?=$module?>">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="folder" value="<?=$folder?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<tr>
				<td width="20%">Title(EN)<span style="color:red">*</span>:</td>
				<td><input type="text" name="title_en" id="title_en" size="40" class="validate[required]" /></td>
			</tr>
			<tr>
				<td >Title(TC)<span style="color:red">*</span>:</td>
				<td><input type="text" name="title_tc" id="title_tc" size="40" class="validate[required]" /></td>
			</tr>
			<tr>
				<td >Sequence<span style="color:red">*</span>:</td>
				<td><input type="number" name="seq" class="validate[required,custom[integer]]"></td>
			</tr>
			<tr>
				<td>Start Date<span style="color:red">*</span>: </td>
				<td><input type="text" name="date_start" id="date_start" size="10" maxlength="10" class="validate[required]"/></td>
			</tr>
			<tr>
				<td>End Date<span style="color:red">*</span>: </td>
				<td><input type="text" name="date_end" id="date_end" size="10" maxlength="10" class="validate[required]"/></td>
			</tr>
			<tr>
				<td >Banner(EN)<span style="color:red">*</span>: </td>
				<td><input type="file" name="img_en" size="45" class="validate[required]">(<?=$PARAMS['imageSize']['slideBanner']?>)</td>
			</tr>
			<tr>
				<td >Banner(TC)<span style="color:red">*</span>: </td>
				<td><input type="file" name="img_tc" size="45" class="validate[required]">(<?=$PARAMS['imageSize']['slideBanner']?>)</td>
			</tr>
			<tr>
				<td>Link(EN): </td>
				<td>
				<input type="text" name="link_en" size="50">
				<select name="target" id="target">
					<option value="_blank">New Window</option>
					<option value="_self">Current Window</option>
				</select>
				</td>
			</tr>
			<tr>
				<td>Link(TC): </td>
				<td>
				<input type="text" name="link_tc" size="50">
				<select name="target" id="target">
					<option value="_blank">New Window</option>
					<option value="_self">Current Window</option>
				</select></td>
			</tr>
			<tr>
				<td >Status:</td>
				<td>
				<label><input name="status" type="radio" value="1" checked />Active</label>
				<label><input name="status" type="radio" value="0" />Inactive</label>
				</td>
			</tr>
			<tr>
				<td >&nbsp;</td>
				<td><input name="Submit" type="submit" value="Add" class="bdtxt"></td>
			</tr>
			</table>

			</form>

		  </div>
		</div>
	</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>