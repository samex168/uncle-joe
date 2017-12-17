<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="cat3";
	$tbl="cat3";
	$cat1 = intval($_GET["cat1"]);
	$cat2 = intval($_GET["cat2"]);
	$title = "<a href='cat1.php'>".checkName("cat1", "title_tc", $cat1)."</a> - <a href='cat2.php?cat1=$cat1'>". checkName("cat2", "title_tc", $cat2)."</a> - <a href='cat3.php?cat1=$cat1&cat2=$cat2'>Cat III</a>";

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
      	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Add</span>
      	<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>'"  />
		<form action="catAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onSubmit="return validating()">
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="page" value="<?=$module?>">
			<input type="hidden" name="action" value="add">
			<input type="hidden" name="cat1" value="<?=$cat1?>">
			<input type="hidden" name="cat2" value="<?=$cat2?>">
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
			<td><input type="text" name="title_tc" size="60"  class="validate[required]"/></td>
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
			<label><input name="status" type="radio" value="1" checked />Active</label>
			<label><input name="status" type="radio" value="0" />Inactive </label>
			</td>
		</tr>
		<tr>
			<td >&nbsp;</td>
			<td ><input name="Submit" type="submit" value="Save" class="bdtxt"></td>
		</tr>
		</table>
		</form>
      </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>