<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
	require_once('include/function.php');

	$title = "Change Password";
	if(isset($_GET["msg"]))
		$msg = intval($_GET["msg"]);
	else
		$msg = 0;
	if(isset($_POST["action"])){
		if($_POST["action"] == "update"){
			$password = str_replace("'", "", $_POST["password"]);
			$password = md5(filterStr($password));
			mysql_query("UPDATE `user` SET `password_hash` = '$password' WHERE `id` =".$_SESSION['admin'] );
			$msg=1;
		}
	}
	$sql = "SELECT * FROM `user` WHERE `id` = '".$_SESSION['admin']."'";
	$rs = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($rs);

	require_once('include/_header.php')
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
			<form name="form1" id="form1" action="adminpwd.php"  enctype="application/x-www-form-urlencoded" method="post" style="margin:0px">
			<input type="hidden" name="action" value="update">
			<table border="0" cellpadding="2" cellspacing="1" width="50%" align="center" class="bdtxt">
			<tr>
				<td >&nbsp;</td>
				<td >&nbsp;</td>
			</tr>
			<?php if ($msg==1){ ?>
			<tr>
				<td colspan="2" ><div align="center" class="msg"><strong>Password updated</strong></div></td>
			</tr>
			<?php } ?>
			<tr>
				<td>New Password:</td>
				<td><input name="password" type="password" id="password" size="30" maxlength="50"   class="validate[required,custom[onlyLetterNumber,minSize[6]]] " /></td>
			 </tr>
			 <tr>
				<td width="36%" >Confirm Password:</td>
				<td width="64%" ><input name="password2" type="password" id="password2" size="30" maxlength="50"  class="validate[required,equals[password]]" /></td>
			</tr>
			<tr>
				<td >&nbsp;</td>
				<td ><input name="Submit" type="submit" value="Save" class="bdtxt"></td>
			</tr>	
			</table>
			</form>
		</div>
	</div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>