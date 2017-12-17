<?php 
	require_once('../_common/conn_open.php');
	require_once('../_common/common.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/data_functions.php');

	$orderNo = str_replace("'", "", $_GET["orderNo"]);
	$msg = (isset($_GET["msg"]))?intval($_GET["msg"]):0;
	$title = "<a href='order.php'>Order</a>";
	$tbl = "order_details";
	$module = "order";

	$result = mysql_query("SELECT * FROM order_details WHERE orderNo='$orderNo'");
	$row = mysql_fetch_array($result);
	$coupon_row=getCouponByCode($row['coupon']);
	if($row['discount']!="" && $coupon_row['title_tc']!=""){
		$discount = $row['cartTotal']*(1-$row['discount']);
	}else{
		$discount = 0;
	}

	$product_result = mysql_query("SELECT *,`op`.id AS `opid`, `p`.id AS `pid` FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu = `p`.plu WHERE orderNo='$orderNo'");

	$cat1_list = mysql_query("SELECT id,title_tc FROM cat1");

	$changeLog = mysql_query("SELECT * FROM order_change_log WHERE orderNo = '$orderNo' ORDER BY updateTime DESC");

	require_once('include/_header.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
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
		 $(".datepicker").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
	});
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
	function addOrderProduct(){
		if($("#product_select").val()==-1){
			alert('Please select a product');
			return;
		}
		if(Math.floor($("#qty_add").val())!=$("#qty_add").val() || !$.isNumeric($("#qty_add").val())){
			alert('Qty not a valid number');
			$("#qty_add").focus();
			return;
		}
		ajaxAddOrderProduct('<?=$orderNo?>',$("#product_select").val(),$("#qty_add").val());
	}
	function updateOrderProduct(id,plu){
		if(Math.floor($("#qty-"+id).val())!=$("#qty-"+id).val() || !$.isNumeric($("#qty-"+id).val())){
			alert('Qty not a valid number');
			$("#qty-"+id).focus();
			return;
		}
		ajaxUpdateOrderProduct(id,'<?=$orderNo?>',plu,$("#qty-"+id).val());
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
      	<span class="c_txt13purple bdtxt" style="float:right;"><?=$title?> - Edit</span>
      	<div>
      	<input type="button" name="back" value="Back" onclick="window.location='<?=$module?>.php'" />
      	<input type="button" name="print" value="Print Invoice" onClick="window.open('printInvoice.php?orderNo=<?=$orderNo?>','_blank')" />
      	</div>
      	<?php if ($msg==1){ ?>
      	<div align="center" class="msg"><strong>Record Saved</strong></div>
      	<?php } ?>
      	<div style="margin-top:15px">
      	<?php if($row['memberId']!=''){ $member_row = mysql_fetch_array(mysql_query("SELECT * FROM member WHERE id=".$row['memberId'])); ?>
  		<span class='blue15 bdtxt'>Member Information</span>
  		<table border="0" cellpadding="2" cellspacing="1" width="100%" align="center" bgcolor="#6ed5f6" class="bdtxt" style="margin-top:5px">
		<tr>
			<td width="5%">ID</td>
			<td width="12%">Name(EN)</td>
			<td width="12%">Name (TC) </td>
			<td width="8%">Join Date </td>
			<td width="12%">Member Type </td>
			<td width="5%" align="center" nowrap="nowrap">Status </td>
			<td width="6%" align="center" >&nbsp;</td>
		</tr>
		<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'" >
			<td><?=$member_row["id"]?></td>
			<td><?=$member_row["name_en"]?></td>
			<td><?=$member_row["name_tc"]?></td>
			<td><?=$member_row["date_join"]?></td>
			<td><?=$member_row["memberType"]?></td>
			<td align="center"><?php if($member_row["status"] == 1){ echo "Active"; }else{ echo "Inactive"; } ?></td>
			<td align="center"><input type="button" value="Edit" onclick="window.location='memberEdit.php?id=<?=$member_row["id"]?>&module=<?=$module?>&orderNo=<?=$orderNo?>'"></td>
		</tr>
		</table>
      	<?php } ?>
      	</div>

      	<form name="form1" id="form1" action="orderAction.php" method="post" enctype="application/x-www-form-urlencoded">
      		<input type="hidden" name="orderNo" value="<?=$orderNo?>">
      		<input type="hidden" name="id" value="<?=$row['id']?>">
			<input type="hidden" name="action" value="update">
			<input type="hidden" name="tbl" value="$tbl">
			<input type="hidden" name="module" value="module">

      	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="bdtxt" style="margin-top:15px">
		<tr>
			<td colspan="4" class="blue15">Order Information</td>
		</tr>
		<tr>
			<td width="20%"><strong>Order No:</strong></td>
			<td width="30%"><?=$row["orderNo"]?></td>
			<td width="20%" ><strong>Order Date: </strong></td>
			<td width="30%"><?=$row["date_order"]?></td>
		</tr>
		<tr>
			<td><strong>Addressee Name:</strong></td>
			<td><input type="text" name="addressee" value="<?=$row["addressee"]?>" size="20"></td>
			<td><strong>Addressee Tel:</strong></td>
			<td><input type="text" name="tel" value="<?=$row["tel"]?>" size="20" class="validate[required,custom[number]]"></td>
		</tr>
		<tr>
			<td><strong>Delivery Date: </strong></td>
			<td><input type="text" class="datepicker" name="date_delivery" value='<?=$row["date_delivery"]?>'></td>
			<td><strong>Delivery Charge:</strong> </td>
			<td><?=$row["deliveryCharge"]?></td>
		</tr>
		<tr>
			<td><strong>Payment Method :</strong></td>
			<td><?=getPaymentMethod($row["paymentMethod"])?></td>
			<td><strong>Coupon:</strong></td>
			<td><input type="text" name="coupon" value="<?=$row['coupon']?>"></td>
		</tr>
		<tr>
			<td><Strong>Payment Status:</Strong></td>
			<td colspan="3">
			<?php foreach ($PARAMS['paymentStatus'] as $value) { ?>
				<label><input type="radio" name="paymentStatus" value="<?=$value?>" <?=$row['paymentStatus']==$value?"checked":""?>><?=getPaymentStatus($value)?></label>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td><Strong>Order Status:</Strong></td>
			<td colspan="3">
				<?php foreach ($PARAMS['orderStatus'] as $value) { ?>
					<label><input type="radio" name="orderStatus" value="<?=$value?>" <?=$row['orderStatus']==$value?"checked":""?>><?=getOrderStatus($value)?></label>
				<?php } ?>
			</td>
		</tr>
	<!--	<tr>
			<td valign="top"><strong>Payment Remarks:</strong></td>
			<td colspan="3"><textarea name="remark" rows="4" cols="60"><?=htmlspecialchars_decode($row["paymentRemark"])?></textarea></td>
		</tr> -->
		<tr><td></td></tr>
		<tr>
			<td colspan="4" class="blue15">Address</td>
		</tr>
		<tr>
			<td><strong>Flat/Floor/Block:</strong></td>
			<td colspan="3"><input type="text" name="flat" size="60" value="<?=$row['flat']?>"></td>
		</tr>
		<tr>
			<td><strong>Building:</strong></td>
			<td colspan="3"><input type="text" name="building" size="60" value="<?=$row['building']?>"></td>
		</tr>
		<tr>
			<td><strong>Street/Estate:</strong></td>
			<td colspan="3"><input type="text" name="street" size="60" value="<?=$row['street']?>"></td>
		</tr>
		<tr>
			<td><strong>District:</strong></td>
			<td colspan="3"><input type="text" name="district" size="60" value="<?=$row['district']?>"></td>
		</tr>
		<tr>
			<td><strong>Area:</strong></td>
			<td colspan="3">
			<select name="area" class="basetext" id="area">
				<?php
					foreach ($PARAMS['district'] as $key => $value) {
						echo '<option '.($key==$row['area']?"selected":"").' value="'.$key.'">'.getAreaName($key)."</option>";
					}
				?>
			</select>
			</td>
		</tr>
		<tr><td></td></tr>
		<tr>
			<td></td><td colspan="3"><input type="submit" name="save" value="Save Order"> <input type="reset" name="reset" value="Reset"></td>
		</tr>
		</table>
		</form>

		<div class="blue15 bdtxt" style="margin-top:10px;margin-bottom:5px">Order Item</div>
		<div class="bdtxt">
			<Strong>Add Item: </Strong>
			<select name="cat1_select" id="cat1_select">
				<option value=-1>--Cat I--</option>
				<?php while($cat1_row=mysql_fetch_array($cat1_list)){ ?>
					<option value=<?=$cat1_row['id']?>><?=$cat1_row['title_tc']?></option>
				<?php } ?>
			</select>
			<select id="cat2_select">
				<option value=-1>--Cat II--</option>
			</select>
			<select id="cat3_select">
				<option value=-1>--Cat III-</option>
			</select>
			<select id="product_select">
				<option value=-1>--Product--</option>
			</select>
			Qty:<select id="qty_add"><?=genQtySelectOption()?></select>&nbsp<input type="button" value="Add" onclick="addOrderProduct()">
		</div>
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="bdtxt" style="margin-top:5px">
		<tr bgcolor="#6ed5f6">
			<td width="5%">&nbsp;</td>
			<td width="12%"><strong>PLU</strong></td>
			<td width="30%"><strong>Name </strong></td>
			<td width="8%" align="right"><strong>Unit Price </strong></td>
			<td width="8%" align="center"><strong>Qty</strong></td>
			<td width="6%" align="right"><strong>Subtotal</strong></td>
		</tr>
		<?php while($product_row = mysql_fetch_array($product_result)){ ?>
		<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'">
			<td>
			<a href="javascript:void(0)" onclick="updateOrderProduct(<?=$product_row['opid']?>,'<?=$product_row["plu"]?>')">Update</a>
			<a href="javascript:void(0)" class="bdlink" onclick="javascript:if(confirm('Are you sure to delete this item?'))ajaxDeleteOrderProduct(<?=$product_row['opid']?>)">Delete</a>
			</td>
			<td><?=$product_row["plu"]?></td>
			<td><?=$product_row['name_tc']?></td>
			<td align="right">$<?=number_format($product_row["price"],$PARAMS['decimals'])?></td>
			<td align="center"><select id="qty-<?=$product_row['opid']?>"><?=genQtySelectOption($product_row['qty'])?></select>(<?=$product_row['unit_tc']?>)</td>
			<td align="right">$<?=number_format($product_row['price']*$product_row['qty'],$PARAMS['decimals']);?></td>
		</tr>
		<?php } ?>
		<tr><td colspan="6"><hr size="1" color="#666666" width="100%"></td></tr>
		<tr>
			<td></td><td></td><td></td>
			<td colspan="2" align="right">Cart Total:</td>
			<td align="right">$<?=number_format($row['cartTotal'],$PARAMS['decimals'])?></td>
		</tr>
		<?php if($discount>0){ ?>
		<tr>
			<td></td><td></td><td></td>
			<td colspan="2" align="right"><?=$coupon_row['title_en']?>:</td>
			<td align="right">$(<?=number_format($discount,$PARAMS['decimals'])?>)</td>
		</tr>
		<?php } ?>
		<tr>
			<td></td><td></td><td></td>
			<td colspan="2" align="right">Delivery Charge:</td>
			<td align="right">$<?=$row['deliveryCharge']?></td>
		</tr>
		<tr>
			<td></td><td></td><td></td>
			<td colspan="2" align="right">Order Total:</td>
			<td align="right">$<?=number_format($row['cartTotal']+$row['deliveryCharge']-$discount,$PARAMS['decimals'])?></td>
		</tr>
		</table>
		<div class="blue15 bdtxt" style="margin-top:10px;margin-bottom:5px">Order Change Log</div>
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="bdtxt" style="margin-top:5px">
		<tr bgcolor="#6ed5f6">
			<td width="15%"><strong>Update Time</strong></td>
			<td width="10%"><strong>Update Field</strong></td>
			<td width="15%"><strong>Old Value</strong></td>
			<td width="15%"><strong>New Value</strong></td>
			<td width="8%"><strong>Update By</strong></td>
		</tr>
		<?php while($changeLog_row = mysql_fetch_array($changeLog)){ ?>
		<tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'">
		<td><?=$changeLog_row['updateTime']?></td>
		<td><?=$changeLog_row['updateField']?></td>
		<td><?=$changeLog_row['oldValue']?></td>
		<td><?=$changeLog_row['newValue']?></td>
		<td><?=getUpdateByName($changeLog_row['updateBy'])?></td>
		</tr>
		<?php } ?>
		</table>
      </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>