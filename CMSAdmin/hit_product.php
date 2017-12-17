<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module="hit_product";
	$tbl="product";
	$title = "Hit Product";
	$folder = $PARAMS["productPath"];

	if(isset($_GET["id"]))
		$id = intval($_GET["id"]);

	$page = (isset($_GET["page"]))?$_GET["page"]:1;
	if ($page == 0){
			$page = 1;
 	}
 	$pagingSize = $PARAMS['pagingSize'];
	$offset = ($page-1)* $pagingSize;

	if(isset($_GET["action"]) && $_GET["action"] == "add_hit_product"){
		$plu = $_GET['plu'];
		mysql_query("UPDATE $tbl SET hit_product=1 WHERE `plu`='$plu'") or die(mysql_error());
	}
	if(isset($_GET["action"]) && $_GET["action"] == "remove"){
		$plu = $_GET['plu'];
		mysql_query("UPDATE $tbl SET hit_product=0 WHERE `plu`='$plu'") or die(mysql_error());
	}

	$result = mysql_query("select * from ".$tbl." WHERE hit_product=1 order by plu limit $offset, $pagingSize");
	$totalRecord = mysql_num_rows(mysql_query("select * from ".$tbl." WHERE hit_product=1 order by plu"));
	$totalPage = ceil($totalRecord/$pagingSize);
	$cat1_list = mysql_query("SELECT id,title_tc FROM cat1");

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	var isPLU = false;
	$(document).ready(function(){
		$("#cat1_select").change(function(){
			$("#cat3_select *").remove();
			$("#cat3_select").append('<option value=-1>--Cat III--</option>');
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
	function checkForm(){
		if(isPLU){
			return true;
		}else{
			alert("Not a valid PLU");
			return false;
		}
	}
	function checkplu(plu) {
		http=GetXmlHttpObject();

		code = document.getElementById(plu).value;
		id = "";
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
					document.getElementById('showAjaxResult').innerHTML="";
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
          	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?></span>
          	<form name="form1" action="<?=$module?>.php" method="get" onsubmit="return checkForm()">
          		<div><select name="cat1_select" id="cat1_select">
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
				</select><br>
				<select name="product_select" id="product_select">
					<option value=-1>--Product--</option>
				</select></div>
		        <div style="margin-top:5px">PLU: <input type="text" name="plu" id="plu" onblur="checkplu('plu')">
		        <div id="showAjaxResult" style="font-size: 11px;font-weight: bold;color:#FF3300;display:inline;"> </div>
		      	<input type="submit" name="add" value="Add to Hit Product" class="txt12black"></div>
		      <input type="hidden" name="action" value="add_hit_product">
			</form>
          	<div style="margin-top:10px"><span id="paging"></span>
			<script>showPaging(<?=$totalPage?>, <?=$page?>, '<?=$module?>.php','');</script>
			<span class="c_txt13brown">Total Record: <?=$totalRecord?></span></div>

			<?php if($totalRecord > 0 ) { ?>
			<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt">
			<tr>
				<td width="8%%" align="center">PLU</td>
				<td width="40%" >Product Name</td>
				<td width="11%" >Price</td>
				<td width="8%" align="center" >&nbsp;</td>
			</tr>
			<?php while($row = mysql_fetch_array($result)){ ?>
			<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
				<td align="center"><?=$row["plu"]?></td>
				<td><?=$row["name_tc"]?></td>
				<td style="color:darkred;">HKD $<?=number_format($row["price"],$PARAMS['decimals'])?></td>
				<td align="center" >
				<input type="button" value="Remove" onClick="javascript:if(confirm('Are you sure to remove from Hit Product?')){ window.location='<?=$module?>.php?plu=<?=$row['plu']?>&action=remove' }" >
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