<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');

	$tbl="product";
	$cat1 = (isset($_GET['cat1']))?intval($_GET["cat1"]):"";
	$cat2 = (isset($_GET['cat2']))?intval($_GET["cat2"]):"";
	$cat3 = (isset($_GET['cat3']))?intval($_GET["cat3"]):"";
	$module = (isset($_GET['module']))?$_GET['module']:"";
	$backLocation = "";
	if($module=="product")
		$backLocation = "product.php?cat1=$cat1&cat2=$cat2&cat3=$cat3";
	else if($module=="productSearch")
		$backLocation = "productSearch.php";
	else if($module=="searchNoCat")
		$backLocation = "productSearch.php?search=nocat";
	$title = "Product";

	$folder = $PARAMS['productPath'];

	$id = intval($_GET["id"]);
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;

	$result = mysql_query("select * from ".$tbl." where id='$id'");
	$numberfields = mysql_num_fields($result);
	$row = mysql_fetch_array($result);

	$current_cat_list = mysql_query("SELECT `cp`.`id` AS `cpid`, `c1`.`title_tc` AS `c1_title`, `c2`.`title_tc` AS `c2_title`, `c3`.`title_tc` AS `c3_title` FROM `cat_product` AS `cp` LEFT JOIN `cat1` AS `c1` ON `cp`.`cat1`=`c1`.`id` LEFT JOIN `cat2` AS `c2` ON `cp`.`cat2`=`c2`.`id` LEFT JOIN `cat3` AS `c3` ON `cp`.`cat3`=`c3`.`id` WHERE `cp`.`plu`='".$row['plu']."'");
	$cat1_list = mysql_query("SELECT id,title_tc FROM cat1");

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="../plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		setEditor("des_en");
		setEditor("des_tc");
		$("#form1").validationEngine();
		$("#cat1_select").change(function(){
			$("#cat3_select *").remove();
			$("#cat3_select").append('<option value=-1>--Cat III--</option>');
			ajaxLoadCat('2', $("#cat1_select").val());
		});
		$("#cat2_select").change(function(){
			ajaxLoadCat('3', $("#cat1_select").val(), $("#cat2_select").val());
		});
	});
	$(function() {
		 $(".datepicker").datepicker({
			 dateFormat: 'yy-mm-dd'
		 });
	});
	function checkForm(){
		$('#form1').submit();
	}
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
	function ajaxLoadCat(cat, select1, select2=null){
		var url = 'ajaxFunction.php?gettype=getCat'+cat+'&cat1='+select1;
		if(cat=='3' && select2!=null){
			url += '&cat2='+select2;
		}
		$.get(url, function(response){
            var cat_list = jQuery.parseJSON(response);
            $("#cat"+cat+"_select *").remove();
            var temp = '<option value=-1>'
            if(cat=='2') temp+='--Cat II--</option>';
            else if(cat=='3') temp+='--Cat III--</option>';
            for(var i in cat_list){
	            var list = cat_list[i];
	            temp += '<option value='+list.id+'>'+list.title+'</option>';
	        }
	        $("#cat"+cat+"_select").append(temp);
        });
	}
	function addSelected(){
		if($('#cat1_select').val()==-1 || $('#cat2_select').val()==-1 || $('#cat3_select').val()==-1){
			alert("Please choose a Cat");
	      	return;
		}
	    var id = $('#cat1_select').val()+"-"+$('#cat2_select').val()+"-"+$('#cat3_select').val();
	    var text = $('#cat1_select option:selected').text()+"-"+$('#cat2_select option:selected').text()+"-"+$('#cat3_select option:selected').text();

	    if($("#cat-"+id).length==0){
		    var li = '<li id="cat-'+id+'" classs="bdtxt"> <input type="button" id="'+id+'" name="'+id+'" onclick="remove_cat(this.id)" value="X" /><span style="margin-left:5px">'+text+'</span>';
		    li+='<input type="hidden" id="hidden-'+id+'" name="cat_add[]" value="'+id+'" /></li>';
		    $(".cat-container").append(li);
	    }else{
	      	alert('Cat already selected');
	    }
	}
	function remove_cat(clicked_id){
	    $("#cat-"+clicked_id).remove();
	    $("#hidden-"+clicked_id).remove();
	}
	function removeSelected(){
		if($('#remove_select').val()==-1){
			alert("Please choose a Cat");
	      	return;
		}
		if($('#remove_select').children('option').length==2){
			alert("Product must be belong to at least one cat");
	      	return;
		}
	    var id = $('#remove_select').val();
	    ajaxRemoveCat(id);
	}
	function ajaxRemoveCat(id){
		var url = 'ajaxFunction.php?gettype=removeCat&id='+id;
		$.get(url, function(response){
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
		  	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Edit</span>
		  	<input type="button" name="back" value="Back" onClick="window.location='<?=$backLocation?>'" />

			<form action="productAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onSubmit="return validating()">
				<input type="hidden" name="tbl" value="<?=$tbl?>">
				<input type="hidden" name="page" value="<?=$module?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="id" value="<?=$id?>">
				<input type="hidden" name="cat1" value="<?=$cat1?>" />
				<input type="hidden" name="cat2" value="<?=$cat2?>" />
				<input type="hidden" name="cat3" value="<?=$cat3?>" />
				<input type="hidden" name="folder" value="<?=$folder?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<?php if ($msg==1){ ?>
			<tr>
				<td colspan="4"><div align="center" class="msg"><strong>Record Saved</strong></div></td>
			</tr>
			<?php } ?>
			<tr>
			   <td width="22%">Current Cat:</td>
				<td>
					<select name="remove_select" id="remove_select">
						<option value=-1>---</option>
						<?php while($cat_row=mysql_fetch_array($current_cat_list)){ ?>
							<option value=<?=$cat_row['cpid']?>><?php echo $cat_row['c1_title']."-".$cat_row['c2_title']."-".$cat_row['c3_title'] ?></option>
						<?php } ?>
					</select>
					<input id="cat_remove" name="cat_remove" type="button" value="Remove" onclick="javascript:if(confirm('You sure to remove the product from cat?'))removeSelected();">
				</td>
			 </tr>
			 <tr>
			   <td>Add to Cat:</td>
				<td>
					<select name="cat1_select" id="cat1_select">
						<option value=-1>--Cat I--</option>
						<?php while($cat1_row=mysql_fetch_array($cat1_list)){ ?>
							<option value=<?=$cat1_row['id']?>><?=$cat1_row['title_tc']?></option>
						<?php } ?>
					</select>
					<select name="cat2_select" id="cat2_select">
						<option value=-1>--Cat II--</option>
					</select>
					<select name="cat3_select" id="cat3_select">
						<option value=-1>--Cat III--</option>
					</select>
					<input id="add_cat" name="add_cat" type="button" value="Add Cat" onclick="addSelected();">
				</td>
			 </tr>
			 <tr>
				<td></td>
				<td><ul class="cat-container"></ul></td>
			</tr>
			 <tr>
			   <td >PLU:</td>
			   <td ><span>
				 <input type="text" name="plu" id="plu" size="20" maxlength="15" value="<?=$row["plu"]?>" readonly style="background:dddddd"/>
			   </span></td>
			   </tr>
			 <tr>
				<td>Name(EN):</td>
				<td><input type="text" name="name_en" id="name_en" size="60" value="<?=$row["name_en"]?>" /></td>
			  </tr>
			   <tr>
				<td>Name(TC):</td>
				<td><input type="text" name="name_tc" id="name_tc" size="60" value="<?=$row["name_tc"]?>" /></td>
			  </tr>
			   <tr>
				<td>Country(EN):</td>
				<td><input type="text" name="country_en" id="country_en" size="60"  value="<?=$row["country_en"]?>" /></td>
			  </tr>
			   <tr>
				<td>Country(TC):</td>
				<td><input type="text" name="country_tc" id="country_tc" size="60" value="<?=$row["country_tc"]?>" /></td>
			  </tr>
			   <tr>
				<td>Brand(EN):</td>
				<td><input type="text" name="brand_en" id="brand_en" size="60" value="<?=$row["brand_en"]?>" /></td>
			  </tr>
			   <tr>
				<td>Brand(TC):</td>
				<td><input type="text" name="brand_tc" id="brand_tc" size="60" value="<?=$row["brand_tc"]?>" /></td>
			  </tr>
			   <tr>
				<td>Vendor:</td>
				<td><input type="text" name="vendor" id="vendor" size="60" value="<?=$row["vendor"]?>" /></td>
			  </tr>
			   <tr>
				 <td>Description(EN):</td>
				 <td>
				   <textarea name="des_en" id="des_en" cols="50" rows="3"><?= htmlspecialchars_decode($row["des_en"]); ?></textarea>
				 </td>
			   </tr>
			   <tr>
				 <td>Description(TC):</td>
				 <td>
				   <textarea name="des_tc" id="des_tc" cols="50" rows="3"><?= htmlspecialchars_decode($row["des_tc"]); ?></textarea>
				 </td>
			   </tr>
			   <tr>
				 <td>Price : </td>
				 <td><input type="text" name="price" id="price" size="10" maxlength="10" value="<?=$row["price"]?>" class="validate[required,custom[number]]"/></td>
			   </tr>
			   <tr>
				 <td>Unit(EN):</td>
				 <td><input type="text" name="unit_en" id="unit_en" size="10" maxlength="10"  value="<?=$row["unit_en"]?>"/></td>
			   </tr>
			   <tr>
				 <td>Unit(TC):</td>
				 <td><input type="text" name="unit_tc" id="unit_tc" size="10" maxlength="10"  value="<?=$row["unit_tc"]?>"/></td>
			   </tr>
				 <tr>
				 <td >Cost: </td>
				 <td><input type="text" name="cost" id="cost" size="10" maxlength="10"  value="<?=$row["cost"]?>"/ class="validate[required,custom[number]]" /></td>
			   </tr>
			   <tr>
				 <td >Remark(EN):</td>
				 <td><textarea name="remark_en" id="remark_en" cols="60" rows="4"><?=htmlspecialchars_decode($row["remark_en"])?></textarea></td>
				 </tr>
			   <tr>
				 <td>Remark(TC):</td>
				 <td> <textarea name="remark_tc" id="remark_tc" cols="60" rows="4"><?=htmlspecialchars_decode($row["remark_tc"])?></textarea></td>
			   </tr>
				<tr>
				  <td> Web Dollar Base : </td>
				  <td><input type="text" name="webDollarBase" id="webDollarBase" size="10" maxlength="10" value="<?=$row["webDollarBase"]?>" class="validate[custom[integer]]"  /></td>
				</tr>
				 <tr>
				  <td >Web Dollar Multiplier : </td>
				  <td><input type="text" name="webDollarMulti" id="webDollarMulti" size="10" maxlength="10" value="<?=$row["webDollarMulti"]?>" class="validate[custom[integer]]"  /></td>
				</tr>
				 <tr>
				  <td > Web Dollar Amt : </td>
				  <td><input type="text" name="webDollarAmt" id="webDollarAmt" size="10" maxlength="10" value="<?=$row["webDollarAmt"]?>" class="validate[custom[integer]]"  /></td>
				</tr>
				 <tr>
				   <td>Web Dollar Valid From: </td>
				   <td><input type="text" name="date_wdValidFrom" id="date_wdValidFrom" class="datepicker" value="<?=$row["date_wdValidFrom"]?>" size="10" maxlength="10"/></td>
				 </tr>
				 <tr>
				   <td>Web Dollar Valid To:</td>
				   <td><input type="text" name="date_wdValidTo" id="date_wdValidTo" class="datepicker" value="<?=$row["date_wdValidTo"]?>" size="10" maxlength="10"/></td>
				 </tr>
			   <tr>
				 <td>Hit Product:</td>
				 <td>
				 <label><input name="hit_product" type="radio" value="1" <?php if($row["hit_product"] == 1) { ?> checked="checked" <?php } ?> />Yes</label>
				 <label><input name="hit_product" type="radio" value="0" <?php if($row["hit_product"] == 0 or $row["hit_product"] == "") { ?> checked="checked" <?php } ?>/>No</label>
				  </td>
			   </tr>
			   <tr>
				 <td>New Product</td>
				 <td>
				  <label><input name="newproduct" type="radio" value="1" <?php if($row["newproduct"] == 1) { ?> checked="checked" <?php } ?> />Yes</label>
				  <label><input name="newproduct" type="radio" value="0" <?php if($row["newproduct"] == 0 or $row["newproduct"] == "") { ?> checked="checked" <?php } ?>/>No</label>
				  </td>
			   </tr>
				<tr>
				 <td >Product Image (S) : </td>
				 <td>
				 <?php if($row["img_s"]!= "" && file_exists("../".$folder.$row["img_s"])){ ?>
				 	<a href="../<? echo $folder.$row["img_s"]; ?>" target="_blank" class="deleteLink"><img src="../<?=$folder?><?=$row["img_s"]?>" width="80" height="80"></a>
					 <a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_s','<?=$folder?>')" class="deleteLink">Delete</a>
					 <br> <?php } ?>
					 <input type="file" name="img_s" size="45">(<?=$PARAMS['imageSize']['product_s']?>)
				 </td>
			   </tr>
				 <tr>
				 <td >Product Image (M) : </td>
				 <td>
				 <?php if($row["img_m"]!= "" && file_exists("../".$folder.$row["img_m"])){ ?>
				 	<a href="../<? echo $folder.$row["img_m"]; ?>" target="_blank" class="deleteLink"><img src="../<?=$folder?><?=$row["img_m"]?>" width="80" height="80"></a>
					 <a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_m','<?=$folder?>')" class="deleteLink">Delete</a>
					 <br> <?php } ?>
					  <input type="file" name="img_m" size="45">(<?=$PARAMS['imageSize']['product_m']?>)
				</td>
			   </tr>
			   <tr>
				 <td >Product Image (L) : </td>
				 <td>
				 <?php if($row["img_l"]!= "" && file_exists("../".$folder.$row["img_l"])){ ?>
				 	<a href="../<? echo $folder.$row["img_l"]; ?>" target="_blank" class="deleteLink"><img src="../<?=$folder?><?=$row["img_l"]?>" width="80" height="80"></a>
					 <a href="javascript:void(0)" onclick="javascript:if(confirm('Are you sure to delete?'))ajaxRemoveImg('<?=$id?>','<?=$tbl?>','img_l','<?=$folder?>')" class="deleteLink">Delete</a>
					 <br> <?php } ?>
					  <input type="file" name="img_l" size="45">(<?=$PARAMS['imageSize']['product_l']?>)
				</td>
			   </tr>
				<tr>
				  <td >Status:</td>
				  <td>
				  <label><input name="status" type="radio" value="1" <?php if($row["status"] == 1) { ?> checked="checked" <?php } ?> />Active</label>
				  <label><input name="status" type="radio" value="0" <?php if($row["status"] == 0 or $row["status"] == "") { ?> checked="checked" <?php } ?> />Inactive</label>
				  </td>
				</tr>
			  <tr>
				<td >&nbsp;</td>
				<td>
				<input name="Submit" type="submit" value="Save" class="bdtxt">
				<input name="reset" type="reset" value="Reset" class="bdtxt">
				</td>
			  </tr>
			</table>
			</form>
		  </div>
		</div>
	</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>