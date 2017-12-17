<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');

	$module="product";
	$tbl="product";
	$cat1 = intval($_GET["cat1"]);
	$cat2 = intval($_GET["cat2"]);
	$cat3 = intval($_GET["cat3"]);
	$title = "<a href='cat1.php'>".checkName("cat1", "title_tc", $cat1)."</a> - <a href='cat2.php?cat1=$cat1'>".checkName("cat2", "title_tc", $cat2)."</a> - <a href='cat3.php?cat1=$cat1&cat2=$cat2'>".checkName("cat3", "title_tc", $cat3)."</a>";
	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
			$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	$result = mysql_query("SELECT *, `cp`.`id` AS cpid, `p`.`id` AS pid FROM `cat_product` as `cp` LEFT JOIN `product` as `p` ON `cp`.`plu`=`p`.`plu` where cat1=$cat1 and cat2=$cat2 and cat3=$cat3 order by seq limit $offset, $pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("SELECT * from cat_product where cat1=$cat1 and cat2=$cat2 and cat3=$cat3"));
	$totalPage = ceil($totalRecord/$pagingSize);

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	function ajaxRemoveCat(id){
		var url = 'ajaxFunction.php?gettype=removeCat&id='+id;
		$.get(url, function(response){
            if(response != ""){
            	location.reload();
            }
        });
	}
	function ajaxSaveCatSeq(id){
		if($('#seq').val() != ""){
			var url = 'ajaxFunction.php?gettype=saveCatSeq&id='+id+'&seq='+$('#seq-'+id).val();
			$.get(url, function(response){
	            if(response != ""){
	            	location.reload();
	            }
	        });
		}
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
          	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Product</span>
          	<input type="button" name="back" value="Back" onClick="window.location='cat3.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>'" />
			<input type="button" name="add" value="Add Product" onClick="window.location='<?=$module?>Add.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>'" >
			<div style="margin-top:10px;"><span id="paging"></span>
			<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>');</script>
			<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="10%" align="center">PLU</td>
				<td width="40%" >Product Name</td>
				<td width="5%" align="center" >Status</td>
				<td width="12%" align="center">Sequence</td>
				<td width="14%" align="center" >&nbsp;</td>
			</tr>
			<?php while($row = mysql_fetch_array($result)){ ?>
				<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
					<td align="center"><?=$row["plu"]?></td>
					<td ><?=$row["name_tc"]?></td>
					<td align="center" ><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
					<td align="center"><span style="margin-right:5px"><input type="text" id="seq-<?=$row['cpid']?>" name="seq" size="5" value="<?=$row["seq"]?>"></span><input type="button" value="Save" onClick="ajaxSaveCatSeq(<?=$row['cpid']?>)"></td>
					<td align="center" >
					<input type="button" value="Edit" onClick="window.location='<?=$module?>Edit.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>&id=<?=$row["pid"]?>&module=<?=$module?>'">
					<input type="button" value="Remove" onClick="javascript:if(confirm('Are you sure to remove the product from the cat?'))ajaxRemoveCat(<?=$row['cpid']?>)">
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