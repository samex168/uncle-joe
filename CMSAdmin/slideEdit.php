<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="slide";
	$tbl="slide";
	$title = "<a href='slide.php'>Slide</a>";
	$folder = $PARAMS['bannerPath'];

	$id = intval($_GET["id"]);
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;

	$result = mysql_query("select * from ".$tbl." where id='$id'");
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

		<form action="slideAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onsubmit="return checkForm()">
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
				<td width="20%">Title(EN):</td>
				<td><input type="text" name="title_en" id="title_en" size="40" class="validate[required]" value="<?=$row['title_en']?>"/></td>
			</tr>
			<tr>
				<td >Title(TC):</td>
				<td><input type="text" name="title_tc" id="title_tc" size="40" class="validate[required]" value="<?=$row['title_tc']?>" /></td>
			</tr>
			<tr>
				<td width="20%" >Sequence :</td>
				<td width="80%" ><input type="number" name="seq" value="<?=htmlspecialchars_decode($row["seq"])?>"  class="validate[required]" /></td>
			</tr>
			<tr>
				<td width="25%">Start Date: </td>
				<td><input type="text" name="date_start" id="date_start" size="10" maxlength="10" class="validate[required]" value="<?=$row['date_start']?>"/></td>
			</tr>
			<tr>
				<td height="26" >End Date: </td>
				<td><input type="text" name="date_end" id="date_end" size="10" maxlength="10" class="validate[required]" value="<?=$row['date_end']?>"/></td>
			</tr>
			<tr>
				<td >Banner(EN): </td>
				<td>
				<?php if($row["img_en"]!= "" && file_exists("../".$folder.$row["img_en"])){ ?>
				<a href="../<? echo $folder.$row["img_en"]; ?>" target="_blank" class="deleteLink"><img src="../<?php echo $folder.$row["img_en"]; ?>" width="200px"></a> 
				<a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete this banner?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_en','<?=$folder?>')" class="deleteLink">Delete</a><br>
				<?php } ?>
				<input type="file" name="img_en" size="45">(<?=$PARAMS['imageSize']['slideBanner']?>)
				</td>
			</tr>
			<tr>
				<td >Banner(TC): </td>
				<td>
				<?php if($row["img_tc"]!= "" && file_exists("../".$folder.$row["img_tc"])){ ?>
				<a href="../<? echo $folder.$row["img_tc"]; ?>" target="_blank" class="deleteLink"><img src="../<?php echo $folder.$row["img_tc"]; ?>" width="200px"></a> 
				<a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete this banner?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_tc','<?=$folder?>')" class="deleteLink">Delete</a><br>
				<?php } ?>
				<input type="file" name="img_tc" size="45">(<?=$PARAMS['imageSize']['slideBanner']?>)
				</td>
			</tr>
			<tr>
				<td>Link(EN): </td>
				<td>
				<input type="text" name="link_en" size="50" value="<?=$row['link_en']?>">
				<select name="target" id="target">
					<option value="_blank" <?php echo $row['target']=='_blank'?"selected":"" ?>>New Window</option>
					<option value="_self" <?php echo $row['target']=='_self'?"selected":"" ?>>Current Window</option>
				</select>
				</td>
			</tr>
			<tr>
				<td>Link(TC): </td>
				<td>
				<input type="text" name="link_tc" size="50" value="<?=$row['link_tc']?>">
				<select name="target" id="target">
					<option value="_blank" <?php echo $row['target']=='_blank'?"selected":"" ?>>New Window</option>
					<option value="_self" <?php echo $row['target']=='_self'?"selected":"" ?>>Current Window</option>
				</select></td>
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