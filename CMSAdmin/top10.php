<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="top10";
	$tbl="top10";
	$title = "Top 10";
	$folder = $PARAMS["productPath"];

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

	$top10_result = mysql_query("select * from ".$tbl." order by seq, date_start DESC limit $offset, $pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("select * from ".$tbl." order by seq"));
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
          	<input type="button" name="add" value="Add Product to Top 10" onClick="window.location='<?=$module?>Add.php'" >
          	<div style="margin-top:10px"><span id="paging"></span>
			<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
			<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="12%" align="center">PLU</td>
				<td width="40%" >Product Name</td>
				<td width="3%">Seq.</td>
				<td width="10%">Start Date</td>
				<td width="5%" align="center" >Status</td>
				<td width="13%" align="center" >&nbsp;</td>
			</tr>
			<?php
			while($top10_row = mysql_fetch_array($top10_result)){
				$product_result = mysql_query("select * from product WHERE plu='".$top10_row['plu']."'");
				$row = mysql_fetch_array($product_result);
			?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td align="center"><?=$row["plu"]?></td>
				<td><?=$row["name_tc"]?></td>
				<td><?=$top10_row["seq"]?></td>
				<td><?=$top10_row['date_start']?></td>
				<td align="center" ><?php if($top10_row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
				<td align="center" >
				<input type="button" value="Edit" onClick="window.location='<?=$module?>Edit.php?id=<?=$top10_row['id']?>'">
				<input type="button" value="Remove" onClick="javascript:if(confirm('Are you sure?')){ window.location='<?=$module?>.php?id=<?=$top10_row['id']?>&action=remove' }" >
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