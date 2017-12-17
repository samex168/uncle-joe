<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="productSearch";
	$tbl="product";
	$title = "Product Search";
	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
		$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	if(isset($_GET['search']) && $_GET['search']=="nocat"){
		$module="searchNoCat";
		$sql = "SELECT * FROM product AS `p` WHERE NOT EXISTS (SELECT * FROM cat_product AS `cp` WHERE `p`.plu = `cp`.plu)";
		$result = mysql_query($sql);
		$totalRecord = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM product AS `p` WHERE NOT EXISTS (SELECT * FROM cat_product AS `cp` WHERE `p`.plu = `cp`.plu)"));
		$totalRecord = $totalRecord[0];
		$totalPage = ceil($totalRecord/$pagingSize);
	}else{
		$filter ="";
		if(isset($_REQUEST["name"]))
			$name = mysql_real_escape_string(trim(str_replace("'", "", $_REQUEST["name"])));
		else
			$name = "";
		if(isset($_REQUEST["plu"]))
			$plu = mysql_real_escape_string(trim($_REQUEST["plu"]));
		else
			$plu = "";

		if($plu !=""){
			$filter = $filter." AND (`plu`='$plu')";
		}

		if($name !=""){
			$filter = $filter." AND (`name_en` LIKE '%".$name."%' OR `name_tc` LIKE'%".$name."%')";
		}
		
		$sql = "SELECT * FROM `product` WHERE `plu` !='' ".$filter." ORDER BY `plu` LIMIT $offset, $pagingSize";
		$result = mysql_query($sql);
		$totalRecord = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM `product` WHERE `plu` !='' ".$filter));
		$totalRecord = $totalRecord[0];
		$totalPage = ceil($totalRecord/$pagingSize);
	}

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
      	<form name="form1" action="productSearch.php" method="get" >
		  <table border="0" cellspacing="0" cellpadding="2">
	        <tr>
	          <td>PLU: <input type="text" name="plu" size="20" maxlength="20"></td>
	          <td>Name: <input type="text" name="name" size="20" maxlength="20"></td>
	          <td align="right"><input type="submit" name="Search" value="Search" class="txt12black"></td>
	        </tr>
	        <tr>
	          <td colspan="3"><input type="button" value="Show No Cat Product" onclick="window.location='productSearch.php?search=nocat'"></td>
	        </tr>
	      </table>
		</form>
		<div style="margin-top:10px;"><span id="paging"></span>
		<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','&name=<?=$name?>&plu=<?=$plu?>');</script>
		<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>
		<?php if($totalRecord > 0 ) { ?>
		  	<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
				<tr>
					<td width="10%" align="center">PLU</td>
					<td width="40%" >Product Name </td>
					<td width="5%" align="center" >status</td>
					<td width="5%" align="center" >&nbsp;</td>
				</tr>
				<?php while($row = mysql_fetch_array($result)){ ?>
					<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
						<td align="center"><?=$row["plu"]?></td>
						<td ><?=$row["name_tc"]?></td>
						<td align="center" ><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
						<td align="center"><input type="button" value="Edit" name="B222"onClick="window.location='productEdit.php?id=<?=$row["id"]?>&module=<?=$module?>'"></td>
					</tr>
				<?php }	?>
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