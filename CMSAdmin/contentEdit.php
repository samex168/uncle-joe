<?php 
	require_once('../_common/conn_open.php'); 
 	require_once('include/checklogin.php'); 
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="content";
	$tbl="content";
	$id = intval($_GET["id"]);
	$title =checkName("content", "title_en", $id);
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;

	$result = mysql_query("select * from ".$tbl." where id='$id'");
	$numberfields = mysql_num_fields($result);
	$row = mysql_fetch_array($result);

	for ($i=0; $i<$numberfields ; $i++ ) {
	    $fieldname = mysql_field_name($result, $i);
		$arr[$fieldname] = $row[$fieldname];
	}

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="../plugins/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
	  setEditor("detail_en");
	  setEditor("detail_tc");
	});
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
        	<span align="right" class="bdtxt" style="float: right;margin-bottom:20px;"><?=$title?></span>
			<form action="contentAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onSubmit="return validating()">
			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
				<?php if ($msg==1){ ?>
			 	<tr>
			   		<td colspan="2"><div align="center" class="msg"><strong>Record Saved</strong></div></td>
			   	</tr>
				<?php } ?>
					<tr>
					<td width="15%" >Title(EN):</td>
					<td width="80%" ><input type="text" name="title_en" size="60" value="<?=htmlspecialchars_decode($arr["title_en"])?>"  class="validate[required]" /></td>
				</tr>
			   <tr>
					<td>Title(TC):</td>
					<td><input type="text" name="title_tc" size="60" value="<?=htmlspecialchars_decode($arr["title_tc"])?>"  class="validate[required]" /></td>
			   </tr>
			  <tr>
			   <td >Detail(EN):</td>
			   <td><textarea name="detail_en" cols="65" rows="3"><?= htmlspecialchars_decode($arr["detail_en"]); ?></textarea></td>
			 </tr>
			 <tr>
			   <td >Detail(TC):</td>
			   <td><textarea name="detail_tc" cols="65" rows="3"><?= htmlspecialchars_decode($arr["detail_tc"]); ?></textarea></td>
			 </tr>
			  <tr>
				<td >&nbsp;</td>
				<td ><input name="Submit" type="submit" value="Save" class="bdtxt"></td>
			  </tr>
			</table>
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="page" value="<?=$module?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="id" value="<?=$id?>">
			</form>
		</div>
	</div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>