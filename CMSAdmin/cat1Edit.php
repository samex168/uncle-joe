<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php'); 
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="cat1";
	$tbl="cat1";
	$title = "<a href='cat1.php'>Cat I</a>";
	$folder = $PARAMS['bannerPath'];

	$id = intval($_GET["id"]);
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
      	<span class="bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Edit</span>
      	<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php'"  />
		<form action="catAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onSubmit="return validating()">
		<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
		<?php if ($msg==1){ ?>
		<tr>
		   		<td colspan="2"><div align="center" class="msg"><strong>Record Saved</strong></div></td>
		</tr>
		<?php } ?>
		<tr>
			<td width="20%" >Sequence :</td>
			<td width="80%" ><input type="number" name="seq" value="<?=htmlspecialchars_decode($arr["seq"])?>"  class="validate[required]" /></td>
		</tr>
		<tr>
			<td width="20%" >Title(EN):</td>
			<td width="80%" ><input type="text" name="title_en" size="60" value="<?=htmlspecialchars_decode($arr["title_en"])?>"  class="validate[required]" /></td>
		</tr>
		<tr>
			<td width="20%" >Title(TC):</td>
			<td width="80%" ><input type="text" name="title_tc" size="60" value="<?=htmlspecialchars_decode($arr["title_tc"])?>"  class="validate[required]" /></td>
		</tr>
	<!--	<tr>
			<td >Image (EN): </td>
			<td>
			<?php if($row["img_en"]!= "" && file_exists("../".$folder.$row["img_en"])){ ?>
			<a href="../<? echo $folder.$row["img_en"]; ?>" target="_blank" class="deleteLink"><img src="../<?php echo $folder.$row["img_en"]; ?>" width="300px"></a> 
			<a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete this banner?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_en','<?=$folder?>')" class="deleteLink">Delete</a><br>
			<?php } ?>
			<input type="file" name="img_en" size="45">(<?=$PARAMS['imageSize']['pageBanner']?>)
			</td>
		</tr>
		<tr>
			<td >Image (TC): </td>
			<td>
			<?php if($row["img_tc"]!= "" && file_exists("../".$folder.$row["img_tc"])){ ?>
			<a href="../<? echo $folder.$row["img_tc"]; ?>" target="_blank" class="deleteLink"><img src="../<?php echo $folder.$row["img_tc"]; ?>" width="300px"></a> 
			<a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete this banner?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_tc','<?=$folder?>')" class="deleteLink">Delete</a><br>
			<?php } ?>
			<input type="file" name="img_tc" size="45">(<?=$PARAMS['imageSize']['pageBanner']?>)
			</td>
		</tr> -->
		<tr>
			<td >Status:</td>
			<td >
			<label><input name="status" type="radio" value="1" <?php if($arr["status"] == 1) { ?> checked="checked" <?php } ?> />Active</label>
			<label><input name="status" type="radio" value="0" <?php if($arr["status"] == 0) { ?> checked="checked" <?php } ?> />Inactive</label>
			</td>
		</tr>
		<tr>
			<td >&nbsp;</td>
			<td >
			<input name="Submit" type="submit" value="Save" class="bdtxt">
			<input name="reset" type="reset" value="Reset" class="bdtxt">
			</td>
		</tr>
		</table>
		<input type="hidden" name="tbl" value="<?=$tbl?>">
		<input type="hidden" name="page" value="<?=$module?>">
		<input type="hidden" name="action" value="edit">
		<input type="hidden" name="folder" value="<?=$folder?>">
		<input type="hidden" name="id" value="<?=$id?>">
		</form>
       </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>