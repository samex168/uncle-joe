<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');
	require_once('../_common/common.php');

	$orderNo = (isset($_GET['orderNo']))?$_GET['orderNo']:"";
	if(isset($_GET['module']) && $_GET['module']=="order"){
		$module='order';
		$backLocation = "orderEdit.php?orderNo=$orderNo";
	}else{
		$module = "member";
		$backLocation = "member.php";
	}
	$tbl="member";
	$title = "<a href='member.php'>Member</a>";
	$thisYr = date("Y") - 10;
	$id = intval($_GET["id"]);
	if(isset($_GET['msg']) && $_GET['msg']==1)
		$msg = "Record Updated";
	else
		$msg = "";

	$result = mysql_query("select * from member where id='$id'");
	$numberfields = mysql_num_fields($result);
	$row = mysql_fetch_array($result);

	require_once('include/_header.php');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form1").validationEngine();
		$("#changepwd").change(function(){
			if($("#changepwd:checked").length>0){
				$("#newpwd_container").show();
			}else{
				$("#newpwd_container").hide();
			}
		});
	});
	function checkForm(){
		$('#form1').submit();
	}
	function resetForm(){
		document.getElementById('form1').reset();
		$('#form1').validationEngine('hide');
	}
	$(function() {
		 $("#date_join").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
		 $("#date_dollarExpire").datepicker({
		 dateFormat: 'yy-mm-dd'
		 });
		 $("#date_lastOrder").datepicker({
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
		  	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:15px;"><?=$title?> - Edit</span>
		  	<input type="button" name="back" value="Back" onClick="window.location='<?=$backLocation?>'"  />
			<form name="form1" id="form1" action="memberAction.php" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="action" id="action" value="update" />
				<input type="hidden" name="tbl" id="tbl" value="<?=$tbl?>" />
				<input type="hidden" name="module" id="module" value="<?=$module?>" />
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="oldpwd" value="<?=$row['password_hash']?>" />
				<input type="hidden" name="orderNo" value="<?=$orderNo?>" />
			<table width="100%" border="0" cellspacing="3" class="bdtxt" id="member_table01">
			<?php if ($msg != ""){ ?>
			<tr>
				<td colspan="2" valign="top" class="redtext" align="center"><?=$msg?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="2" valign="top" class="blue15">Personal Information</td>
			</tr>
			<tr>
				<td width="25%">Name(EN):</td>
				<td><input name="name_en" type="text" class="validate[required]" value="<?=$row['name_en']?>" size="40" maxlength="100" /></td>
			</tr>
			<tr>
				<td width="20%">Name(TC):</td>
				<td><input name="name_tc" type="text" class="validate[required]" value="<?=$row['name_tc']?>" size="40" maxlength="100" /></td>
			</tr>
			<tr>
				<td>Gender:</td>
				<td>
				<label><input type="radio" name="gender" value="M" class="validate[required]" <?php echo $row['gender']=='M'?'checked':''; ?> checked >Male</label>
				<label><input type="radio" name="gender"  value="F"  class="validate[required]" <?php echo $row['gender']=='F'?"checked":""; ?> />Female</label>
				</td>
			</tr>
			<tr>
				<td>Tel:</td>
				<td><input name="tel" type="text" class="validate[custom[phone]]" value="<?=$row["tel"]?>"  id="tel" size="40"/></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input name="email" type="text" class="validate[required,custom[email]]" id="email" value="<?=$row["email"]?>" size="40" maxlength="100" /></td>
			</tr>
			<tr>
				<td>Birthday:</td>
				<td>
				<select name="birthYear" class="basetext" id="birthYear">
				<option value="">---</option>
				<?php echo genBirthYearSelectOption($row['birthYear']); ?>
				</select> 年&nbsp
				<select name="birthMonth" class="basetext" id="birthMonth">
				<option value="">---</option>
				<?php echo genBirthMonthSelectOption($row['birthMonth']); ?>
				</select> 月
				</td>
			</tr>
			<tr>
				<td valign="top">Password:</td>
				<td>
				<label><input type="checkbox" name="changepwd" id="changepwd"> Change Password?</label>
				<div id="newpwd_container" style="display: none">
					<label><span style="margin-right:22px">New Password: </span><input name="password_hash" type="password"  class="validate[required] " id="password_hash" size="30" maxlength="100" value="<?=$row['password_hash']?>"></label><br>
					<label>Confirm Password: <input name="password2" type="password" class="validate[required,equals[password_hash]]" id="password2" size="30" maxlength="100" value="<?=$row['password_hash']?>" /></label>
				</div>
				</td>
			</tr>
			<tr><td></td><td></td></tr>
			<tr>
				<td colspan="2" valign="top" class="blue15">Address</td>
			</tr>
			<tr>
				<td valign="top">Registered Address:</td>
				<td>
					<table>
					<tr>
						<td>Flat/Floor/Block:</td>
						<td><input name="flat" type="text" value="<?=$row['flat']?>" id="flat" size="60" /></td>
					</tr>
					<tr>
						<td>Building:</td>
						<td><input name="building" type="text" value="<?=$row['building']?>" id="building" size="60"/></td>
					</tr>
					<tr>
						<td>Street/Estate:</td>
						<td><input name="street" type="text" value="<?=$row['street']?>" id="street" size="60"/></td>
					</tr>
					<tr>
						<td>District:</td>
						<td><input name="district" type="text" value="<?=$row['district']?>" id="district" size="60"/></td>
					</tr>
					<tr>
						<td></td>
						<td>
						<label>
						<select name="area" class="basetext" id="area">
							<option value="">---</option>
							<?php
								foreach ($PARAMS['district'] as $key => $value) {
									echo '<option '.($key==$row['area']?"selected":"").' value="'.$key.'">'.getAreaName($key)."</option>";
								}
							?>
						</select>
						</label>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top" class="blue15">Membership</td>
			</tr>
			<tr>
				<td>Member Type:</td>
				<td><input name="memberType" type="text" class="validate[required]" value="<?=$row["memberType"]?>"  id="memberType" size="40"/></td>
			</tr>
			<tr>
				<td>Date Join:</td>
				<td><input type="text" name="date_join" id="date_join" size="10" maxlength="10" class="validate[required]" value="<?=$row['date_join']?>"/></td>
			</tr>
			<tr>
				<td>Web Dollar:</td>
				<td><input name="webDollar" type="number" class="validate[required]" value="<?=$row["webDollar"]?>"  id="webDollar"/></td>
			<tr>
			<tr>
				<td>Web Dollar Expire Date:</td>
				<td><input name="date_dollarExpire" type="text" id="date_dollarExpire" value="<?=$row["date_dollarExpire"]?>" size="10" maxlength="10" /></td>
			</tr>
			<tr>
				<td>Promotion Agreement:</td>
				<td><label><input name="accept_promotion" type="checkbox" id="accept_promotion" value=1 <?=$row['accept_promotion']==1?"checked":""?>/>我同意你按私隱政策使用我的個人資料作直接促銷。</label></td>
			</tr>
			<tr>
				<td>Status:</td>
				<td>
				<label><input name="status" type="radio" value="1" <?php echo $row["status"]==1?"checked":""; ?> />Active</label>
				<label><input name="status" type="radio" value="0" <?php echo $row["status"]==0?"checked":""; ?>/>Inactive</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td valign="top"><p align="left">
				<input type="submit" name="Save" value="Save" />
				<input type="reset" name="Reset" value="Reset" />
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