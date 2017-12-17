<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="pageBanner";
	$tbl="page_banner";
	$title = "Page Banner";
	$folder = $PARAMS["bannerPath"];

	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
			$page = 1;
 	}
	$offset = ($page-1)* $pagingSize;

	$result = mysql_query("SELECT * FROM page_banner AS `pb` LEFT JOIN cat1 AS `c1` ON cat1ID=`c1`.id");
	$totalRecord = mysql_num_rows(mysql_query("SELECT * FROM ".$tbl));

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

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="20%" > Cat Name(EN)</td>
				<td> Cat Name(TC)</td>
				<td width="10%">&nbsp;</td>
			</tr>
			<?php while($row = mysql_fetch_array($result)){ ?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td><?=$row["title_en"]?></td>
				<td><?=$row["title_tc"]?></td>
				<td align="center" >
				<input type="button" value="Edit" onClick="window.location='<?=$module?>Edit.php?id=<?=$row['id']?>'">
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