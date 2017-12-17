<?php require_once('../_common/conn_open.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UNCLE JOE Adminstration Panel</title>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate.min.js"></script>

<link href="css/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<script src="js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
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
</head>

<body>
	<div class="wrapper">
		<div class="header clearfix">
			<div class="logo">
				<a href="../b5_index.php" target="_blank"><img src="images/logo.png" alt="UNCLE JOE" title="UNCLE JOE" /></a>
			</div>
			<div class="links">
				<div class="top_links clearfix">
					<div class="image_upload">
					</div>
				</div>
			</div>
		</div>

			<div class="col_content clearfix">
				<div class="col_main">
				  <div class="content" align="center">
				  <p>	  <p>
				   <form action="login.php" name="form1" id="form1" method="POST" enctype="application/x-www-form-urlencoded">
					  <table width="300" align="center" cellpadding="3" cellspacing="3" >

					  <tr>
						<td width="114" class="bdtxt">Username :</td>
						<td><input type="text" name="uid" id="uid" style="width:12em;"  class="validate[required]" /></td>
						</tr>
					  <tr>
						<td class="bdtxt">Password :</td>
						<td><input type="password" name="psw" id="psw" style="width:12em;" class="validate[required]" /></td>
						</tr>
					  <tr>
						<td class="bdtxt">&nbsp;</td>
						<td><input type="submit" name="submit" id="submit" value="Login" />
							<input type="reset" name="reset" id="reset" value="Reset" />			</td>
						</tr>
					  </table>
						</form>
							  <p>	  <p>
				   </div>
				</div>
			</div>

		<div class="footer clearfix" align="center">
			<span>Copyright &copy; UNCLE JOE</span>
			<a href="http://www.freecomm.com" target="_blank"><img src="images/logo_freecomm.png" title="Freedom Communications Ltd." alt="Freedom Communications Ltd." /></a>
		</div>

	</div>
</body>
</html>
<?php require_once('../_common/conn_close.php'); ?>