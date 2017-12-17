<?php 
	require_once('../_common/conn_open.php'); 
 	require_once('include/checklogin.php'); 
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="cat1";
	$tbl="cat1";
	$title = "Cat I";

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
		$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;
	$result = mysql_query("select * from ".$tbl." order by seq limit $offset,$pagingSize");
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
      	<input type="button" name="add" value="Add Cat I" onClick="window.location='<?=$module?>Add.php'" >
      	<div style="margin-top:10px;"><span id="paging"></span>
		<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
		<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

		<?php if($totalRecord > 0 ) { ?>
		<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="5%" align="center">Cat I</td>
				<td width="25%" >Title(TC)</td>
				<td width="25%" >Title(EN)</td>
				<td width="5%" align="center" >Seq.</td>
				<td width="8%" align="center" >Status</td>
				<td width="13%" align="center" >&nbsp;</td>
			</tr>
			<?php
				while($row = mysql_fetch_array($result)){
			?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td  align="center"><?=$row["id"]?></td>
				<td  ><?=$row["title_tc"]?></td>
				<td  ><?=$row["title_en"]?></td>
				<td  align="center"><?=$row["seq"]?></td>
				<td align="center"  ><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
				<td align="center"  >
			      <input type="button" value="Edit" name="B222" onClick="window.location='<?=$module?>Edit.php?id=<?=$row["id"]?>'">
			      <input type="button" value="Cat II" name="B22" onClick="window.location='cat2.php?cat1=<?=$row["id"]?>'"></td>
			</tr>
			<?php
				}
			?>
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