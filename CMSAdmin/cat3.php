<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');

	$module="cat3";
	$tbl="cat3";
	$cat1 = intval($_GET["cat1"]);
	$cat2 = intval($_GET["cat2"]);
	$title = "<a href='cat1.php'>".checkName("cat1", "title_tc", $cat1)."</a> - <a href='cat2.php?cat1=$cat1'>".checkName("cat2", "title_tc", $cat2)."</a>";
	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
		$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;
	$result = mysql_query("select * from ".$tbl." where cat1= $cat1 and cat2=$cat2 order by seq limit $offset,$pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("select * from ".$tbl." where cat1= $cat1 and cat2= $cat2 order by seq"));
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
      	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Cat III</span>
      	<input type="button" name="back" value="Back" onClick="window.location='cat2.php?cat1=<?=$cat1?>'" />
		<input type="button" name="add" value="Add Cat III" onClick="window.location='<?=$module?>Add.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>'" >
		<div style="margin-top:10px;"><span id="paging"></span>
		<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','&cat1=<?=$cat1?>&cat2=<?=$cat2?>');</script>
		<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

		<?php if($totalRecord > 0 ) { ?>
		<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
		<tr>
			<td width="7%" align="center">Cat I</td>
			<td width="7%" align="center">Cat II</td>
			<td width="7%" align="center">Cat III</td>
			<td width="25%" >Title(TC)</td>
			<td width="25%" >Title(EN)</td>
			<td width="5%" align="center" >Seq.</td>
			<td width="8%" align="center" >status</td>
			<td width="15%" align="center" >&nbsp;</td>
		</tr>
		<?php
		while($row = mysql_fetch_array($result)){
		?>
		<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
			<td align="center"><?=$row["cat1"]?></td>
			<td align="center"><?=$row["cat2"]?></td>
			<td align="center"><?=$row["id"]?></td>
			<td ><?=$row["title_tc"]?></td>
			<td ><?=$row["title_en"]?></td>
			<td  align="center"><?=$row["seq"]?></td>
			<td align="center" ><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
			<td align="center" >
			<input type="button" value="Edit" name="B222"onClick="window.location='<?=$module?>Edit.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>&id=<?=$row["id"]?>'">
			<input type="button" value="Product" name="B22"onClick="window.location='product.php?cat1=<?=$cat1?>&cat2=<?=$row["cat2"]?>&cat3=<?=$row["id"]?>'">
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