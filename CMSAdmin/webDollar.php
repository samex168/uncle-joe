<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$module = "member";
	$title = "<a href='member.php'>Member</a>";

	$id = intval($_REQUEST["id"]);
	if(isset($_POST['adjust'])&&$_POST["adjust"] == "yes"){
		$action = $_POST["action"];
		$amt = $_POST["amt"];
		$recordDate = $_POST["recordDate"];
		$remarks = $_POST["remarks"];

		if($action =="Add"){
			mysql_query("update tbl_member set validDollar = validDollar + $amt where id='$id'");
			$insertSQL = "insert into tbl_dollar_history (`memberId`,`action`,`amt`,`recordDate`,`remarks`) values ('$id','$action','$amt','$recordDate','$remarks')";
			mysql_query($insertSQL)or die(mysql_error());
		}
		if($action =="Deduct"){
			$currDollar = mysql_fetch_array(mysql_query("select validDollar from tbl_member where id='$id'"))or die(mysql_error());
			if ($amt > $currDollar[0]){
				echo "<script>alert('不能扣減多於$".$currDollar[0]."');</script>";
			}else{
				mysql_query("update tbl_member set validDollar = validDollar - $amt where id='$id'");
				$insertSQL = "insert into tbl_dollar_history (`memberId`,`action`,`amt`,`recordDate`,`remarks`) values ('$id','$action','$amt','$recordDate','$remarks')";
				mysql_query($insertSQL)or die(mysql_error());
			}
		}
		echo "<script>window.location='sweetDollar.php?id=$id';</script>";
	}

	$row = mysql_fetch_array(mysql_query("select name_en, webDollar, date_dollarExpire from member where id='$id'"));

	require_once('include/_header.php');
?>
<script type="text/javascript">
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
	$(function() {
		$("#recordDate").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
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
          	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;"><?=$title?> - Web Dollar</span>
          	<input type="button" name="back" value="Back" onClick="window.location='<?=$module?>.php'"  />
          	<div class="bdtxt" style="margin-top:10px">Member <?=$row["name_en"]?>, Web Dollar:  <?=$row["webDollar"]?>, Expire Date:  <?=$row["date_dollarExpire"]?></div>
          	<div class="bdtxt" style="margin-top:10px">
			<form name="form1" id="form1" action="sweetDollar.php" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="adjust" value="yes" />
				<label>日期: <input type="text" name="recordDate" id="recordDate" size="10" maxlength="10" class="validate[required] text-input datepicker"></label>
				<label>Remarks:
					<select name="remarks" >
					  	<option value="1">客戶服務員更正</option>
						<option value="2">會員推廣</option>
						<option value="3">推廣活動</option>
					</select></label>
				<label>Action:
					<select name="action" >
					  	<option value="Add">Add</option>
						<option value="Deduct">Deduct</option>
					</select></label>
				<input type="text" name="amt" id="amt" size="10" maxlength="10" class="validate[required,custom[integer]]">
			    <input type="submit" name="Submit" value="Submit" class="txt12black">
			</form>
			</div>

				 <?php

					   $orderSql = mysql_query("select a.*,b.lastOrderDate, b.validDollar from tbl_order a, tbl_member b where a.memberId = b.id and a.memberId='$id' and (b.lastOrderDate  between date_sub(CURDATE(),INTERVAL 1 YEAR) and CURDATE()) and (a.status='Completed' or a.status='Order Confirmed') order by a.orderNo desc" )or die(mysql_error()); ?>
					購物 Bonus Point 記錄
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <th width="20%" bgcolor="#6ed5f6">購物日期</th>
            	        <th width="20%" bgcolor="#6ed5f6">訂單編號</th>
            	        <th width="20%" bgcolor="#6ed5f6">上次結餘</th>
            	        <th width="20%" bgcolor="#6ed5f6">已使用</th>
            	        <th width="20%" bgcolor="#6ed5f6">賺取</th>
          	        </tr>
					  <?php
					  $idx = 0;
					  while ($orderRow = mysql_fetch_array($orderSql)){
					  		$total = mysql_fetch_array(mysql_query("select totalDollarGet as totalGet, useDollar as totalUse from tbl_order where memberId='$id' and (status = 'Completed' or status = 'Order Confirmed' ) and id <= ".$orderRow["id"]." order by orderNo desc limit 0,1"))or die(mysql_error());
							if($idx == 0){
								$sql = "SELECT SUM(IF(`action`='Deduct', `amt`,-1*`amt`)) AS `adjustment` FROM `tbl_dollar_history` WHERE `memberId`='$id'";
								$adjRS = mysql_query($sql);
								$adjustment = mysql_fetch_array($adjRS);
								$lastTime = $orderRow["validDollar"]+$adjustment['adjustment'];
								$lastTime = $lastTime + $total[1] - $total[0];
							}else{
								$lastTime = $lastTime + $total[1] - $total[0];
							}


					  ?>
            	      <tr>
            	        <td align="center" bgcolor="#FFFFFF"><?=$orderRow["orderDate"]?></td>
            	           <td align="center" bgcolor="#FFFFFF"><?=$orderRow["orderNo"]?></td>
            	           <td align="center" bgcolor="#FFFFFF">$<?=number_format($lastTime,1)?></td>
            	        <td align="center" bgcolor="#FFFFFF">$<?=number_format($total[1],1)?></td>
            	        <td align="center" bgcolor="#FFFFFF">+ $<?=number_format($orderRow["totalDollarGet"],1)?></td>
          	        </tr>
					<?php
					$idx++;
					} ?>
          	      </table>
				  <br />
				  其他 Bonus Point 記錄:
				  <?php
				  $dollarSQL2 = mysql_query("select * from tbl_dollar_history where memberId='$id' order by recordDate desc");
				  ?>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <th width="25%" bgcolor="#6ed5f6">更新日期</th>
            	        <th width="40%" bgcolor="#6ed5f6">描述</th>
            	        <th width="35%" bgcolor="#6ed5f6">更新Sweet Dollar </th>
           	        </tr>
					 <?php while ($dollarRow2= mysql_fetch_array($dollarSQL2)){ ?>
					 <tr>
            	        <td align="center" bgcolor="#FFFFFF"><?=$dollarRow2["recordDate"]?></td>
            	           <td align="center" bgcolor="#FFFFFF">
						  <?php if ($dollarRow2["remarks"] == "1"){
						  	 		echo "客戶服務員更正";
								}elseif  ($dollarRow2["remarks"] == "2"){
									echo "會員推廣";
								}elseif  ($dollarRow2["remarks"] == "3"){
									echo "推廣活動";
								}elseif ($dollarRow2["remarks"] == "4"){
									echo "過期 Sweet Dollars";
								}else{
									echo $dollarRow2["remarks"];
								}
							?>
						  </td>
            	        <td align="center" bgcolor="#FFFFFF">
							<?php

							if($dollarRow2["action"] == "Add"){
								echo "+";
							}
							if($dollarRow2["action"] == "Deduct"){
								echo "-";
							}
							?>
							$<?=$dollarRow2["amt"]?>
						</td>
           	        </tr>
					<?php } ?>
				  </table>
          </div>
        </div>
    </div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>