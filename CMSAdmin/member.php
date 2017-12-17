<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');
 	require_once('../_common/common.php');

	$module="member";
	$tbl="member";
	$title = "Member";

	if(isset($_GET['id']))
		$id = intval($_GET["id"]);
	$filter ="";
	if(isset($_POST['member_name']))
		$name = str_replace("'", "", $_POST["member_name"]);
	else
		$name = "";
	if(isset($_POST['tel']))
		$tel = str_replace("'", "", $_POST["tel"]);
	else
		$tel = "";
	if(isset($_POST['email']))
		$email = str_replace("'", "", $_POST["email"]);
	else
		$email = "";

	if($name !=""){
		$filter = $filter." and name_en LIKE '%".$name."%'";
	}
	if($email !=""){
		$filter = $filter." and email = '".$email."'";
	}
	if($tel !=""){
		$filter = $filter." and tel = '".$tel."'";
	}
	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
		$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;


	$result = mysql_query("select * from member where id <> '' ".$filter." order by id limit $offset, ".$pagingSize);
	$totalRecord = mysql_num_rows(mysql_query("select * from member where id <> '' ".$filter));

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
          	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?></span><br>
          	<form name="form1" id="form1" action="member.php" method="post" enctype="application/x-www-form-urlencoded">
			  <table border="0" cellspacing="0" cellpadding="2" class="bdtxt c_txt12black">
                <tr>
                  <td>Member Name:<input type="text" name="member_name" maxlength="50"></td>
                  <td>Email:<input type="text" name="email" maxlength="50">
				  <td>Tel:  <input type="text" name="tel" maxlength="20"></td>
				  <td><input type="submit" name="Search" value="Search" class="txt12black"></td>
                </tr>
           	   </table>
		  	</form>

		  	<div style="margin-top:10px"><span id="paging"></span>
		  	<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
		  	<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="5%">ID</td>
				<td width="12%">Name(EN)</td>
				<td width="12%">Name (TC) </td>
				<td width="8%">Join Date </td>
				<td width="12%">Member Type </td>
				<td width="5%" align="center" nowrap="nowrap">Status </td>
				<td width="6%" align="center" >&nbsp;</td>
			</tr>

			<?php while($row = mysql_fetch_array($result)){	?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td><?=$row["id"]?></td>
				<td><?=$row["name_en"]?></td>
				<td><?=$row["name_tc"]?></td>
				<td><?=$row["date_join"]?></td>
				<td><?=$row["memberType"]?></td>
				<td align="center"><?php if($row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
				<td align="center" >
			      <input type="button" value="Edit" name="B222"  onClick="window.location='<?=$module?>Edit.php?id=<?=$row["id"]?>'">
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