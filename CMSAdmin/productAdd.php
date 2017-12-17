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
	$cat1_title = checkName("cat1", "title_tc", $cat1);
	$cat2_title = checkName("cat2", "title_tc", $cat2);
	$cat3_title = checkName("cat3", "title_tc", $cat3);
	$title = "<a href='cat1.php'>".$cat1_title."</a> - <a href='cat2.php?cat1=$cat1'>".$cat2_title."</a> - <a href='cat3.php?cat1=$cat1&cat2=$cat2'>".$cat3_title."</a> - <a href='product.php?cat1=$cat1&cat2=$cat2&cat3=$cat3'>Product</a>";
	$folder = $PARAMS['productPath'];

	$cat1_list = mysql_query("SELECT id,title_tc FROM cat1");

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="../plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		setEditor("des_en");
		setEditor("des_tc");
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
	$(document).ready(function(){
		$("#form1").validationEngine();
	});
	function checkForm(){
		$('#form1').submit();
	}
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
	function checkplu(plu) {
		http=GetXmlHttpObject()
		code = document.getElementById(plu).value;
			//id = document.getElementById('id').value;
		id = "";
		var url = 'ajaxFunction.php?';
		var now = new Date();
		var uts = now.getTime();

		var fullurl = url + 't='+ uts + '&code=' + code + '&gettype=plu&id='+ id;
		http.open("GET", fullurl, true);
		http.onreadystatechange=function() {
			if(http.readyState == 4 && http.status == 200) {
				if (http.responseText == "") {
					document.getElementById('showAjaxResult').innerHTML="";
				}else{
					document.getElementById('showAjaxResult').innerHTML="PLU already exist";
					document.getElementById(plu).value = "";
				}
			}
		}
		http.send(null);
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
		if($('#cat1_select').val()==<?=$cat1?> && $('#cat2_select').val()==<?=$cat2?> && $('#cat3_select').val()==<?=$cat3?> ){
			alert("Cannot add current cat");
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
		  	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Add</span>
		  	<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>'"  />

			<form action="productAction.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
				<input type="hidden" name="tbl" value="<?=$tbl?>">
				<input type="hidden" name="page" value="<?=$module?>">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="folder" value="<?=$folder?>">
				<input type="hidden" name="cat1" value="<?=$cat1?>">
				<input type="hidden" name="cat2" value="<?=$cat2?>">
				<input type="hidden" name="cat3" value="<?=$cat3?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<tr>
			   	<td width="22%">Current Cat:</td>
				<td><input type="text" size="60" value="<?=$cat1_title." - ".$cat2_title." - ".$cat3_title?>" readonly/></td>
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
				 <td >PLU<span style="color:red">*</span>:</td>
				 <td>
				 	<input type="text" name="plu" id="plu" size="20" maxlength="15" class="validate[required]" onblur="checkplu('plu')" />
					<span id="showAjaxResult" style="font-size: 11px;font-weight: bold;color:#FF3300"> </span>
				  </td>
			 </tr>
			 <tr>
					<td width="156" >Name(EN)<span style="color:red">*</span>:</td>
					<td><input type="text" name="name_en" size="60" class="validate[required]" /></td>
				</tr>
				 <tr>
					<td width="156" >Name(TC)<span style="color:red">*</span>:</td>
					<td><input type="text" name="name_tc" size="60" class="validate[required]" /></td>
				</tr>
				 <tr>
					<td width="156" >Country(EN):</td>
					<td><input type="text" name="country_en" size="60"  /></td>
				</tr>
				 <tr>
					<td width="156" >Country(TC):</td>
					<td><input type="text" name="country_tc" size="60" /></td>
				</tr>
				 <tr>
					<td width="156" >Brand(EN):</td>
					<td><input type="text" name="brand_en" size="60" /></td>
				</tr>
				 <tr>
					<td width="156" >Brand(TC):</td>
					<td><input type="text" name="brand_tc" size="60"  /></td>
				</tr>
				 <tr>
					<td width="156" >Vendor:</td>
					<td><input type="text" name="vendor" size="60" /></td>
				</tr>
				 <tr>
					 <td >Description(EN):</td>
					 <td><textarea name="des_en" cols="50" rows="3" ></textarea></td>
				 </tr>
				 <tr>
					 <td >Description(TC):</td>
					 <td><textarea name="des_tc" cols="50" rows="3"  ></textarea></td>
				 </tr>
				 <tr>
					 <td>Price<span style="color:red">*</span>: </td>
					 <td><input type="text" name="price" size="10" maxlength="10" value=0 class="validate[required,custom[number]]"></td>
				 </tr>
				 <tr>
					 <td>Unit(EN)<span style="color:red">*</span>:</td>
					 <td><input type="text" name="unit_en" size="10" maxlength="10" class="validate[required]"> </td>
				 </tr>
				 <tr>
					 <td >Unit(TC)<span style="color:red">*</span>:</td>
					 <td><input type="text" name="unit_tc" size="10" maxlength="10" class="validate[required]"/></td>
				 </tr>
				 <tr>
					 <td >Cost: </td>
					 <td ><input type="text" name="cost" size="10" maxlength="10" value="0"></td>
					 <td >&nbsp;</td>
					 <td >&nbsp;</td>
				 </tr>
				 <tr>
					 <td >Remark(EN):</td>
					 <td><textarea name="remark_en" cols="70" rows="4" ></textarea></td>
					 </tr>
				 <tr>
					 <td >Remark(TC):</td>
					 <td><textarea name="remark_tc" cols="70" rows="4" ></textarea></td>
				 </tr>
					<tr>
						<td > Web Dollar Base<span style="color:red">*</span>: </td>
						<td><input type="text" name="webDollarBase" size="10" maxlength="10" class="validate[custom[integer]]" value=0 /></td>
					</tr>
				 <tr>
						<td >Web Dollar Multiplier<span style="color:red">*</span>: </td>
						<td><input type="text" name="webDollarMulti" size="10" maxlength="10" class="validate[custom[integer]]" value=1 /></td>
					</tr>
				 <tr>
						<td > Web Dollar Amt<span style="color:red">*</span>: </td>
						<td><input type="text" name="webDollarAmt" size="10" maxlength="10" class="validate[custom[integer]]" value=0 /></td>
				</tr>
				<tr>
					<td >Web Dollar Valid From: </td>
					<td><input type="text" name="date_wdValidFrom" class="datepicker" size="10" maxlength="10"/></td>
				</tr>
				<tr>
					<td >Web Dollar Valid To:</td>
					<td><input type="text" name="date_wdValidTo" class="datepicker" size="10" maxlength="10"/></td>
				</tr>
				 <tr>
					 <td >Hit Product:</td>
					 <td>
				 	 <label><input name="hit_product" type="radio" value="1" />Yes</label>
					 <label><input name="hit_product" type="radio" value="0" checked="checked"/>No</label> 
					 </td>
				 </tr>
				 <tr>
					 <td >New Product </td>
					 <td>
				     <label><input name="newproduct" type="radio" value="1" />Yes</label>
					 <label><input name="newproduct" type="radio" value="0" checked="checked"/>No</label>	
					 </td>
				 </tr>
				 <tr>
					 <td >Product Image(S) : </td>
					 <td><input type="file" name="img_s" size="45">(<?=$PARAMS['imageSize']['product_s']?>)</td>
				 </tr>
					<tr>
					 <td >Product Image(M) : </td>
					 <td><input type="file" name="img_m" size="45">(<?=$PARAMS['imageSize']['product_m']?>)</td>
				 </tr>
					<tr>
					 <td >Product Image(L) : </td>
					 <td><input type="file" name="img_l" size="45">(<?=$PARAMS['imageSize']['product_l']?>)</td>
				 </tr>
				<tr>
					<td >Status:</td>
					<td>
					<label><input name="status" type="radio" value="1" checked />Active</label>
					<label><input name="status" type="radio" value="0" />Inactive</label>
					</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td><input name="submit" type="submit" value="Save" class="bdtxt"></td>
				</tr>
			</table>

			</form>

		  </div>
		</div>
	</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>