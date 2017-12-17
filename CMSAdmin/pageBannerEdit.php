<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="pageBanner";
	$tbl="page_banner";
	$title = "<a href='pageBanner.php'>Page Banner</a>";
	$folder = $PARAMS['bannerPath'];

	$id = intval($_GET["id"]);
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;

	$result = mysql_query("SELECT *,`pb`.img_en AS `pb_imgen`,`pb`.img_tc AS `pb_imgtc` FROM page_banner AS `pb` LEFT JOIN cat1 AS `c1` ON cat1ID=`c1`.id WHERE `pb`.id='$id'");
	$row = mysql_fetch_array($result);

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	var isPLU = true;
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

		<form action="pageBannerAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onsubmit="return checkForm()">
			<input type="hidden" name="tbl" value="<?=$tbl?>">
			<input type="hidden" name="page" value="<?=$module?>">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="folder" value="<?=$folder?>">
			<input type="hidden" name="id" value="<?=$id?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<?php if ($msg==1){ ?>
			<tr>
				<td colspan="2"><div align="center" class="msg"><strong>Record Saved</strong></div></td>
			</tr>
			<?php } ?>
			<tr>
				<td width="20%">Cat Name(EN):</td>
				<td><input type="text" name="name_en" id="name_en" size="40" class="validate[required]" value="<?=$row['title_en']?>" readonly/></td>
			</tr>
			<tr>
				<td>Cat Name(TC):</td>
				<td><input type="text" name="name_tc" id="name_tc" size="40" class="validate[required]" value="<?=$row['title_tc']?>" readonly/></td>
			</tr>
			<tr>
				<td >Banner(EN): </td>
				<td>
				<?php if($row["pb_imgen"]!= "" && file_exists("../".$folder.$row["pb_imgen"])){ ?>
				<a href="../<? echo $folder.$row["pb_imgen"]; ?>" target="_blank" class="deleteLink"><img src="../<?php echo $folder.$row["pb_imgen"]; ?>" width="300px"></a> 
				<a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete this banner?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_en','<?=$folder?>')" class="deleteLink">Delete</a><br>
				<?php } ?>
				<input type="file" name="img_en" size="45">(<?=$PARAMS['imageSize']['pageBanner']?>)
				</td>
			</tr>
			<tr>
				<td >Banner(TC): </td>
				<td>
				<?php if($row["pb_imgtc"]!= "" && file_exists("../".$folder.$row["pb_imgtc"])){ ?>
				<a href="../<? echo $folder.$row["pb_imgtc"]; ?>" target="_blank" class="deleteLink"><img src="../<?php echo $folder.$row["pb_imgtc"]; ?>" width="300px"></a> 
				<a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete this banner?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_tc','<?=$folder?>')" class="deleteLink">Delete</a><br>
				<?php } ?>
				<input type="file" name="img_tc" size="45">(<?=$PARAMS['imageSize']['pageBanner']?>)
				</td>
			</tr>
			<tr>
			  	<td >Status:</td>
			  	<td>
			  	<label><input name="status" type="radio" value="1" <?php if($row["status"] == 1) { ?> checked="checked" <?php } ?> />Active</label>
			  	<label><input name="status" type="radio" value="0" <?php if($row["status"] == 0 or $row["status"] == "") { ?> checked="checked" <?php } ?> />Inactive</label>
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