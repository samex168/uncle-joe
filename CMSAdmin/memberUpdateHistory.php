<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
 	require_once('include/function.php');

	$title = "Member Update History";
	$module = "memberUpdateHistory";

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
		$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	$result = mysql_query("select * from member_update_history ORDER BY update_time DESC LIMIT $offset, $pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("select * from member_update_history"));
	$totalPage = ceil($totalRecord/$pagingSize);

	require_once('include/_header.php');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form1").validationEngine();
	});
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
	$(function() {
		 $(".datepicker").datepicker({
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
			<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?></span>

		 	<form name="form1" id="form1" action="memberUpdateHistoryExport.php" method="post" enctype="application/x-www-form-urlencoded">
			 	<span class="c_txt12black bdtxt" style="margin:5px">Date:</span>
			 	<input type="text" name="dateFrom" id="dateFrom" class="text-input datepicker validate[required]" size="10" maxlength="10">
			 	<span class="c_txt12black bdtxt" style="margin:5px">To</span>
			 	<input type="text" name="dateTo" id="dateTo" size="10" class="text-input datepicker validate[required]" maxlength="10">
			 	<input type="submit" name="export" value="Export" class="txt12black" />
			</form>

			<div style="margin-top:10px;"><span id="paging"></span>
			<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
			<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="20%" nowrap>Member ID</td>
				<td width="10%">Update field</td>
				<td width="30%">Old Value</td>
				<td width="30%">New Value</td>
				<td width="10%" align="center" nowrap>Update Time</td>
				<td width="10%" align="center" nowrap>Update By</td>
			</tr>

			<?php while($row = mysql_fetch_array($result)){	?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td><?=$row["member_id"]?></td>
				<td><?=$row["update_field"]?></td>
				<td><?=$row["old_value"]?></td>
				<td><?=$row["new_value"]?></td>
				<td align="center"><?=$row["update_time"]?></td>
				<td align="center"><?php if($row["updateBy"] == 1){ echo "Admin"; }else{ echo "Member"; } ?></td>
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