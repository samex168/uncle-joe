<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="coupon";
	$tbl="coupon";
	$title = "Coupon";

	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
			$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	if(isset($_GET["action"]) && $_GET["action"] == "remove"){
		mysql_query("DELETE FROM $tbl where id=$id") or die(mysql_error());
	}

	$result = mysql_query("SELECT * FROM ".$tbl." limit $offset, $pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("SELECT * FROM ".$tbl));
	$totalPage = ceil($totalRecord/$pagingSize);

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
          	<input type="button" name="add" value="Add Coupon" onClick="window.location='<?=$module?>Add.php'" >
          	<div style="margin-top:10px"><span id="paging"></span>
			<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
			<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="20%">Coupon Code</td>
				<td width="15%">Title(EN)</td>
				<td width="8%">Start Date</td>
				<td width="8%">End Date</td>
				<td width="5%" align="center" >Status</td>
				<td width="12%" align="center" >&nbsp;</td>
			</tr>
			<?php while($row = mysql_fetch_array($result)){ ?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td><?=$row["code"]?></td>
				<td><?=$row["title_en"]?></td>
				<td><?=$row["date_start"]?></td>
				<td><?=$row["date_end"]?></td>
				<td align="center" ><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
				<td align="center" >
				<input type="button" value="Edit" onClick="window.location='<?=$module?>Edit.php?id=<?=$row['id']?>'">
				<input type="button" value="Remove" onClick="javascript:if(confirm('Are you sure to remove the coupon?')){ window.location='<?=$module?>.php?id=<?=$row['id']?>&action=remove' }" >
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