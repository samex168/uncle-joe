<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');

	$module="coupon";
	$tbl="coupon";
	$title = "<a href='coupon.php'>Coupon</a>";

	$cat1_list = mysql_query("SELECT id,title_tc FROM cat1");

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	var isCode = false;
	$(document).ready(function(){
		$("#form1").validationEngine();
	/*	$(".type").change(function(){
	      	$("#type_TA").hide();
			$("#type_I").hide();
			if($(".type:checked").val()=="1")
				$("#type_TA").show();
			else if($(".type:checked").val()=="2")
				$("#type_I").show();
	    }); */
	    $("#cat1_select").change(function(){
			$("#cat3_select *").remove();
			$("#cat3_select").append('<option value=-1>--Cat III-</option>');
			$("#product_select *").remove();
			$("#product_select").append('<option value=-1>--Product--</option>');
			ajaxLoadCat('2', $("#cat1_select").val());
		});
		$("#cat2_select").change(function(){
			ajaxLoadCat('3', $("#cat1_select").val(), $("#cat2_select").val());
		});
		$("#cat3_select").change(function(){
			ajaxLoadProduct($("#cat1_select").val(), $("#cat2_select").val(), $("#cat3_select").val());
		});
		$("#product_select").change(function(){
			$("#plu").val($("#product_select").val());
			$("#plu").blur();
		});
	});
	$(function() {
		 $(".datepicker").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
	});
	function checkForm(){
		if(isCode){
			return true;
		}else{
			alert("Not a valid Code");
			return false;
		}
	}
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
	function checkcode() {
		var url = 'ajaxFunction.php';
		var data = {gettype:"checkCouponCode", code: $("#code").val()};
		$.post(url, data, function(response){
	        if(response == "0"){
	        	document.getElementById('showAjaxResult').innerHTML="";
	        	isCode = true;
	        }else{
	        	document.getElementById('showAjaxResult').innerHTML="Code already exist";
	        	document.getElementById('code').value = "";
	        	document.getElementById('code').focus();
	        	isCode = false;
	        }
	    });
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
	function ajaxLoadProduct(select1, select2, select3){
		var url = 'ajaxFunction.php?gettype=getProduct&cat1='+select1+'&cat2='+select2+'&cat3='+select3;
		$.get(url, function(response){
            var product_list = jQuery.parseJSON(response);
            $("#product_select *").remove();
            var temp = "<option value=-1>--Product--</option>";
            for(var i in product_list){
	            var list = product_list[i];
	            temp += '<option value='+list.plu+'>'+list.name+'</option>';
	        }
	        $("#product_select").append(temp);
        });
	}
	function addCouponProduct(){
		if($("#cat1_select").val()==-1 || $("#cat2_select").val()==-1 || $("#cat3_select").val()==-1 || $("#product_select").val()==-1){
			return;
		}
		var plu = $("#product_select").val();
		if($("#item-"+plu).length==0){
		    var li = '<li id="item-'+plu+'" classs="bdtxt" style="border:1px solid lightgrey;padding:5px"><span>PLU : '+plu+'</span><br>';
		    li += '<span>'+$('#product_select option:selected').text()+'</span><br>';
		    li += '<label style="margin-right:5px">Discount Amount : <input type="text" name="item_amount[]"></label>';
		    li += '<input type="button" value="Remove">';
		    li += '<input type="hidden" id="hidden-'+plu+'" name="cat_add[]" value="'+plu+'" /></li>';
		    $(".item_container").append(li);
	    }else{
	      	alert('Cat already selected');
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
			<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Add</span>
			<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php'"  />

			<form action="top10Action.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onsubmit="return checkForm()">
				<input type="hidden" name="tbl" value="<?=$tbl?>">
				<input type="hidden" name="page" value="<?=$module?>">
				<input type="hidden" name="action" value="add">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<tr>
				<td>Code<span style="color:red">*</span>:</td>
				<td>
				<input type="text" name="code" id="code" maxlength="32" class="validate[required]" onblur="checkcode()" />
				<div id="showAjaxResult" style="font-size: 11px;font-weight: bold;color:#FF3300;display:inline;"> </div>
				</td>
			</tr>
			<tr>
				<td>Title(EN)<span style="color:red">*</span>:</td>
				<td><input type="text" name="title_en" class="validate[required]"></td>
			</tr>
			<tr>
				<td>Title(TC)<span style="color:red">*</span>:</td>
				<td><input type="text" name="title_tc" class="validate[required]"></td>
			</tr>
			<tr>
				<td width="20%">Start Date<span style="color:red">*</span>: </td>
				<td><input type="text" name="date_start" id="date_start" size="10" maxlength="10" class="datepicker validate[required]"/></td>
			</tr>
			<tr>
				<td>End Date<span style="color:red">*</span>: </td>
				<td><input type="text" name="date_end" size="10" maxlength="10" class="datepicker validate[required]"/></td>
			</tr>
			<tr>
				<td valign="top">Type:</td>
				<td><label style="margin-right:5px"><input type="radio" name="type" class="type" value="1" checked>Total Amount</label><!--<label><input type="radio" name="type" class="type" value="2">Item</label>-->
				<div id="type_TA" style="display: block;margin-top:5px">
					<label for="value" style="margin-right:5px">Discount Amount:</label><input type="text" name="value" id="value" size="15">
				</div>
			<!--	<div id="type_I" style="display: none">
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
						<option value=-1>--Cat III-</option>
					</select>
					<br>
					<select name="product_select" id="product_select">
						<option value=-1>--Product--</option>
					</select>
					<input type="button" value="Add" onclick="addCouponProduct()">
					<ul class="item_container" style="margin-top:5px"></ul>
				</div> -->
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td>Status:</td>
				<td>
				<label><input name="status" type="radio" value="1" checked />Active</label>
				<label><input name="status" type="radio" value="0" />Inactive</label>
				</td>
			</tr>
			<tr>
				<td >&nbsp;</td>
				<td><input name="Submit" type="submit" value="Add" class="bdtxt"></td>
			</tr>
			</table>

			</form>

		  </div>
		</div>
	</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>