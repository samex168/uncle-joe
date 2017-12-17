<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');

	$module="top10";
	$tbl="top10";
	$title = "<a href='top10.php'>Top 10</a>";
	$folder = $PARAMS['productPath'];

	$cat1_list = mysql_query("SELECT id,title_tc FROM cat1");	

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	var isPLU = false;
	$(document).ready(function(){
		$("#form1").validationEngine();
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
		 $("#date_start").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
		 $("#date_end").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
	});
	function checkForm(){
		if(isPLU){
			return true;
		}else{
			alert("Not a valid PLU");
			return false;
		}
	}
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
	function checkplu(plu) {
		http=GetXmlHttpObject();

		code = document.getElementById(plu).value;
		var id = "";
		var url = 'ajaxFunction.php?';
		var now = new Date();
		var uts = now.getTime();

		var fullurl = url + 't='+ uts + '&code=' + code + '&gettype=plu&id='+ id;
		http.open("GET", fullurl, true);
		http.onreadystatechange=function() {
			if(http.readyState == 4 && http.status == 200) {
				if (http.responseText == "") {
					document.getElementById('showAjaxResult').innerHTML="PLU Not Found";
					isPLU = false;
				}else{
					document.getElementById('showAjaxResult').innerHTML=http.responseText;
					isPLU = true;
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
				<input type="hidden" name="folder" value="<?=$folder?>">

			<table border="0" cellpadding="2" cellspacing="1" width="100%" class="bdtxt">
			<tr>
				<td>Select Product:</td>
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
						<option value=-1>--Cat III-</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
				<select name="product_select" id="product_select">
					<option value=-1>--Product--</option>
				</select>
				</td>
			</tr>
			<tr>
				<td >PLU<span style="color:red">*</span>:</td>
				<td>
				<input type="text" name="plu" id="plu" size="20" maxlength="15" class="validate[required]" onblur="checkplu('plu')" />
				<div id="showAjaxResult" style="font-size: 11px;font-weight: bold;color:#FF3300;display:inline;"> </div>
				</td>
			</tr>
			<tr>
				<td >Sequence<span style="color:red">*</span>:</td>
				<td><input type="number" name="seq" class="validate[required,custom[integer]]"></td>
			</tr>
			<tr>
				<td width="25%">Start Date<span style="color:red">*</span>: </td>
				<td><input type="text" name="date_start" id="date_start" size="10" maxlength="10" class="validate[required]"/></td>
			</tr>
			<tr>
				<td height="26" >End Date<span style="color:red">*</span>: </td>
				<td><input type="text" name="date_end" id="date_end" size="10" maxlength="10" class="validate[required]"/></td>
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