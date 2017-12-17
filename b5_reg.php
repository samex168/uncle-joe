<?php
  require_once('_common/common.php');
  require_once('_common/CSRF.php');
  require_once('_common/conn_open.php');
  require_once('_common/data_functions.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UNCLE JOE</title>

<link href="css/ui_base.css" type="text/css" rel="stylesheet">
<link href="css/ui_supermarket.css" type="text/css" rel="stylesheet">

<!-- import jQuery -->
        <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
        <!-- import Nivo Slider -->
        <script type="text/javascript" src="js/Nivo_Slider/jquery.nivo.slider.js"></script>
        <link rel="stylesheet" href="js/Nivo_Slider/themes/default/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="js/Nivo_Slider/nivo-slider.css" type="text/css" media="screen" />
        <style>
            .sticky {
                top: -10px;
                position: fixed !important;
                width: 100%;
                z-index: 9999;
            }
        </style>

</head>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#email").change(function(){
      isEmailExist($('#email').val());
    });
  });
  function checkform(){
    clearMsg();
    if(!isEmail($('#email').val())){
      $('#email_msg').html("<?=$PARAMS['NOT_VALID_EMAIL']?>");
      return false;
    }
    if(!isEmail($('#email_confirm').val())){
      $('#email_confirm_msg').html("<?=$PARAMS['NOT_VALID_EMAIL']?>");
      return false;
    }
    if($('#checkEmailExist').val()!="0"){
      $('#email_msg').html("<?=$PARAMS['EMAIL_EXIST']?>");
      return false;
    }
    if($('#email').val()!=$('#email_confirm').val()){
      $('#email_confirm_msg').html("<?=$PARAMS['NOT_EQUAL_EMAIL']?>");
      return false;
    }
    if($('#password_hash').val()!=$('#password_confirm').val()){
      $('#password_confirm_msg').html("<?=$PARAMS['NOT_EQUAL_PASSWORD']?>");
      return false;
    }
  }
  function clearMsg(){
    $('#email_msg').html("");
    $('#email_confirm_msg').html("");
    $('#password_confirm_msg').html("");
  }
</script>
<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
  <div>
	<p id="path">主頁 &gt; 註册帳戶</p>
		<div id="continer">
        	<h1 class="ui_nav2_subtitle">註册帳戶</h1>
       	  <p>請填寫以下資料，即可成為會員：</p>
<form action="reg_action.php" name="form1" id="form1" enctype="multipart/form-data" method="post" onsubmit="return checkform()">
<?= CSRF::genHiddenCSRF('reg-form'); ?>
<input type="hidden" name="lang" value="tc">
<input type="hidden" id="checkEmailExist" value=-1>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tbody>
    <tr>
      <td>中文姓名：</td>
      <td><input type="text" name="name_tc" class="ui_inputbox200W" required></td>
    </tr>
    <tr>
      <td width="100">英文姓名：</td>
      <td><input type="text" name="name_en" class="ui_inputbox200W" required></td>
    </tr>
    <tr>
      <td>性别：</td>
      <td><label>
        <input id="gender1" name="gender" mandatory="false" value="M" type="radio" required>
        男 </label>
        <label>
          <input id="gender2" name="gender" mandatory="false" value="F" type="radio">
          女</label></td>
    </tr>
    <tr>
      <td>電郵地址：</td>
      <td><input name="email" type="text" id="email" class="ui_inputbox200W" required><span id="email_msg" style="color:red;margin-left:5px"></span></td>
    </tr>
    <tr>
      <td>確認電郵地址：</td>
      <td><input name="email_confirm" type="text" id="email_confirm" class="ui_inputbox200W" required><span id="email_confirm_msg" style="color:red;margin-left:5px"></span></td>
    </tr>
    <tr>
      <td>密碼：</td>
      <td><input name="password_hash" type="password" id="password_hash" class="ui_inputbox200W" required></td>
    </tr>
    <tr>
      <td>確認密碼：</td>
      <td><input name="password_confirm" type="password" id="password_confirm" class="ui_inputbox200W" required><span id="password_confirm_msg" style="color:red;margin-left:5px"></td>
    </tr>
    <tr>
      <td valign="top">通訊地址：</td>
      <td style="padding:0px;"><table border="0" cellpadding="3" cellspacing="0" width="100%">
        <tbody>
          <tr>
            <td width="80">室/樓/座</td>
            <td><input name="flat" type="text" id="flat" class="ui_inputbox200W"></td>
          </tr>
          <tr>
            <td>大廈名稱</td>
            <td><input name="building" type="text" id="building" class="ui_inputbox200W"></td>
          </tr>
          <tr>
            <td>屋苑/街道</td>
            <td><input name="street" type="text" id="street" class="ui_inputbox200W"></td>
          </tr>
          <tr>
            <td rowspan="2" valign="top">地區</td>
            <td><input name="district" type="text" id="district" class="ui_inputbox200W">
              <br></td>
          </tr>
          <tr>
            <td><select name="area" id="area">
              <option value="">===== 請選擇 =====</option>
              <?php
                foreach ($PARAMS['district'] as $key => $value) {
                  echo '<option value="'.$key.'">'.getAreaName($key)."</option>";
                }
              ?>
            </select></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>出生日期：</td>
      <td>
        <select name="select" id="select" class="ui_inputbox200W">
          <option value="">===== 請選擇 =====</option>
          <?=genBirthYearSelectOption()?>
        </select>
        年 &nbsp; 
        <select name="select" id="select" class="ui_inputbox200W">
          <option value="">===== 請選擇 =====</option>
          <?=genBirthMonthSelectOption()?>
        </select>
        月
        </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="checkbox" name="cb_18" id="cb_18" required>
        <label for="cb_18">本人已年滿18歲，同意並接受 <a href="javascript:void(0);">一般條款及細則</a> 及 <a href="javascript:void(0);">私隱政策</a></label>。</td>
      </tr>
    <tr>
      <td colspan="2"><input type="checkbox" name="accept_promotion" id="accept_promotion" value=1>
        <label for="accept_promotion">我同意你按私隱政策使用我的個人資料作直接促銷。</label></td>
      </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </tbody>
</table>
<input type="submit" name="submit" class="ui_btn_green" value="登記" style="cursor:pointer;border:none">
</form>
			
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>