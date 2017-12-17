<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');

	$module="cat1";
	$tbl="cat1";
	$title = "<a href='cat1.php'>Cat I</a>";
	$folder = "files/product";

	require_once('include/_header.php');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form1").validationEngine();
	});
	function checkForm(){
		$('#form1').submit();
	}
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
      <span class="bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Add</span>
      <input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php'">
      <form action="catAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onSubmit="return validating()">
		<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">		
			<tr>
				<td width="20%" >Sequence<span style="color:red">*</span>:</td>
				<td width="80%" ><input type="number" name="seq" class="validate[required]" /></td>
			</tr>
			<tr>
				<td>Title(EN)<span style="color:red">*</span>:</td>
				<td><input type="text" name="title_en" size="60"  class="validate[required]" /></td>
			</tr>
			<tr>
				<td>Title(TC)<span style="color:red">*</span>:</td>
				<td><input type="text" name="title_tc" size="60"  class="validate[required]" /></td>
			</tr>
		<!--	<tr>
				<td >Image(EN):</td>
				<td ><input type="file" name="img_en" size="50" /></td>
			</tr>
			<tr>
				<td >Image(TC):</td>
				<td ><input type="file" name="img_tc" size="50" /></td>
			</tr> -->
			<tr>
				<td >Status:</td>
				<td >
				<label><input name="status" type="radio" value="1" checked/>Active</label>
				<label><input name="status" type="radio" value="0" />Inactive</label>
				</td>
			</tr>
			 <tr>
				<td >&nbsp;</td>
				<td ><input name="Submit" type="submit" value="Save" class="bdtxt"></td>
				<td ></td>
			 </tr>
		</table>
		<input type="hidden" name="tbl" value="<?=$tbl?>">
		<input type="hidden" name="page" value="<?=$module?>">
		<input type="hidden" name="action" value="add">
		<input type="hidden" name="folder" value="<?=$folder?>">
		</form>
      </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>