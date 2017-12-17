<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="slide";
	$tbl="slide";
	$title = "Slide";
	$folder = $PARAMS["bannerPath"];

	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
			$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	$result = mysql_query("select * from ".$tbl." order by seq limit $offset, $pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("select * from ".$tbl." order by seq"));
	$totalPage = ceil($totalRecord/$pagingSize);

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	function ajaxRemoveSlide(id, tbl, folder){
		var url = 'ajaxFunction.php';
		var data = {gettype:"removeSlide", id: id, tbl: tbl, folder: folder}
		$.post(url, data, function(response){
	        if(response != ""){
	        	location.reload();
	        }
	    });
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
          	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?></span>
          	<input type="button" name="add" value="Add Slide" onClick="window.location='<?=$module?>Add.php'" >
          	<div style="margin-top:10px"><span id="paging"></span>
			<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
			<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="15%" >Title</td>
				<td width="40%" >Link</td>
				<td width="3%">Seq.</td>
				<td width="5%" align="center" >Status</td>
				<td width="15%" align="center" >&nbsp;</td>
			</tr>
			<?php while($row = mysql_fetch_array($result)){ ?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td><?=$row["title_tc"]?></td>
				<td><?=$row["link_tc"]?></td>
				<td><?=$row["seq"]?></td>
				<td align="center" ><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
				<td align="center" >
				<input type="button" value="Edit" onclick="window.location='<?=$module?>Edit.php?id=<?=$row['id']?>'">
				<input type="button" value="Remove" onclick="javascript:if(confirm('Are you sure to delete the silde?'))ajaxRemoveSlide('<?=$row['id']?>','<?=$tbl?>','<?=$folder?>')" >
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