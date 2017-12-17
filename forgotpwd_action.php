<?php
  require_once('_common/conn_open.php');
  require_once('_common/common.php');
  require_once('_common/CSRF.php');
  require_once('_common/data_functions.php');
  ini_set("display_errors", true);
  mb_internal_encoding('UTF-8');

  if(!isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN']) || !CSRF::verifyToken('forgotpwd-form', $_POST['UNCLE-JOE_CSRF_TOKEN'])){
      redirect("b5_forgotpwd.php");
      exit();
  }

  $email = mysql_real_escape_string($_POST['email']);
  $str = genRandomString(8);
  $resetpwd = passwordEncode($str);
  mysql_query("UPDATE member SET password_hash='$resetpwd' WHERE email='$email'") or die(mysql_error());

	require_once("_common/sendmail.php");
	
	$recipient = $email;
	$subject = $PARAMS['email_subject']['resetpwd'];
	$content = '<div style="border: 1px #ccc solid;padding: 10px;width:50%">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr><th align="center">UNCLE JOE 正品專賣</th></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>親愛的客戶,</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
      <td><strong>你的密碼已經重設。</strong></td>
    </tr>
    <tr>
      <td>新密碼：'.$str.'</td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>請即使用新密碼登入UNCLE JOE 會員，並於登入後更改密碼。</td></tr>
  </table>
  </div><div style="width:50%" align="center">此電郵為系統自動送出，請勿回覆。</div>';

	$res = sendmail($recipient,$subject,$content,$PARAMS['email_sender']);
  if($res>0){
    alert($PARAMS['emial_sent_msg']);
  }

  redirect("b5_forgotpwd.php?msg=1");

?>
<? require_once('_common/conn_close.php'); ?>