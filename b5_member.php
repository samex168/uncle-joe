<?php
    require_once('_common/common.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

    if(!isset($_SESSION['member']["id"])){
        redirect('b5_login.php');
        exit();
    }

    $id = mysql_real_escape_string(trim(str_replace("'", "", $_SESSION['member']["id"])));

    $msg = isset($_GET["msg"])?$_GET["msg"]:"";

    $result = mysql_query("SELECT * FROM member WHERE id='$id'");
    $row = mysql_fetch_array($result);
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
  function checkform(){
    clearMsg();
    if($('#password_hash').val()!=$('#password_confirm').val()){
      $('#password_confirm_msg').html("<?=$PARAMS['NOT_EQUAL_PASSWORD']?>");
      return false;
    }
  }
  function clearMsg(){
    $('#password_confirm_msg').html("");
  }
</script>
<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
    <div>
        <p id="path"><a href="index.php">主頁</a> &gt; 會員資料</p>
        <div style="margin:20px"><a href="b5_member_order.php" class="ui_btn_green">購物記錄</a></div>
        <div id="continer" style="width:100%;padding:20px;">
            <div style="width:55%;float:left;padding:10px;">
            <h1 class="ui_nav2_subtitle">帳戶資料</h1>
            <form action="member_action.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
                <?= CSRF::genHiddenCSRF('member-form'); ?>
                <input type="hidden" name="action" value="updateAccount">
                <input type="hidden" name="id" value="<?=$row['id']?>">
            <table cellpadding="4" cellspacing="8">
            <?php if ($msg == 1){ ?>
            <tr>
                <td colspan="2" align="center" style="color:red;">資料已儲存</td>
            </tr>
            <?php } ?>
            <tr>
                <td>電郵地址：</td>
                <td><input name="email" type="text" id="email" class="ui_inputbox200W" value="<?=$row['email']?>" required readonly></td>
            </tr>
            <tr>
                <td>中文姓名 :</td>
                <td><input type="text" name="name_tc" value="<?=$row['name_tc']?>" required></td>
            </tr>
            <tr>
                <td>英文姓名 :</td>
                <td><input type="text" name="name_en" value="<?=$row['name_en']?>" required></td>
            </tr>
            <tr>
                <td>性别：</td>
                <td><label><input id="gender1" name="gender" mandatory="false" value="M" type="radio" <?=$row['gender']=="M"?"checked":""?> required>男 </label><label><input id="gender2" name="gender" mandatory="false" value="F" type="radio" <?=$row['gender']=="F"?"checked":""?>>女</label></td>
            </tr>
            <tr>
                <td>出生日期：</td>
                <td>
                <select name="birthYear" class="ui_inputbox200W">
                  <option value="">===== 請選擇 =====</option>
                  <?=genBirthYearSelectOption($row['birthYear'])?>
                </select> 年 &nbsp; 
                <select name="birthMonth" class="ui_inputbox200W">
                  <option value="">===== 請選擇 =====</option>
                  <?=genBirthMonthSelectOption($row['birthMonth'])?>
                </select> 月
                </td>
            </tr>
            <tr>
                <td valign="top">通訊地址：</td>
                <td style="padding:0px;"><table border="0" cellpadding="3" cellspacing="3" width="100%">
                <tbody>
                <tr>
                    <td width="80">室/樓/座</td>
                    <td><input name="flat" type="text" id="flat" class="ui_inputbox200W" value="<?=$row['flat']?>"></td>
                </tr>
                <tr>
                    <td>大廈名稱</td>
                    <td><input name="building" type="text" id="building" class="ui_inputbox200W" value="<?=$row['building']?>"></td>
                </tr>
                <tr>
                    <td>屋苑/街道</td>
                    <td><input name="street" type="text" id="street" class="ui_inputbox200W" value="<?=$row['street']?>"></td>
                </tr>
                <tr>
                    <td rowspan="2" valign="top">地區</td>
                    <td><input name="district" type="text" id="district" class="ui_inputbox200W" value="<?=$row['district']?>">
                      <br></td>
                </tr>
                <tr>
                    <td><select name="area" id="area">
                    <option value="">===== 請選擇 =====</option>
                    <?php foreach ($PARAMS['district'] as $key => $value) { ?>
                    <option value="<?=$key?>" <?=$row['area']==$key?"selected":""?>><?=getAreaName($key)?></option>
                    <?php } ?>
                    </select></td>
                </tr>
                </tbody>
              </table></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td colspan="2"><input type="checkbox" name="accept_promotion" id="accept_promotion" value=1 <?=$row['accept_promotion']==1?"checked":""?>>
                <label for="accept_promotion">我同意你按私隱政策使用我的個人資料作直接促銷。</label></td>
            </tr>
            </table>
            <p></p>
            <input type="submit" name="submit" value="儲存" class="ui_btn_green" style="border:none;cursor:pointer">
            </form>
            </div>

            <div style="padding:10px">
            <h1 class="ui_nav2_subtitle">更改密碼</h1>
            <form action="member_action.php" name="form2" id="form2" enctype="multipart/form-data" method="post" onsubmit="return checkform()">
                <?= CSRF::genHiddenCSRF('updatePassword-form'); ?>
                <input type="hidden" name="action" value="updatePassword">
                <input type="hidden" name="id" value="<?=$row['id']?>">
            <table cellpadding="4" cellspacing="8">
            <?php if($msg == 2){ ?>
            <tr>
                <td colspan="2" align="center" style="color:red;">已更改密碼</td>
            </tr>
            <?php }elseif($msg == 3){ ?>
            <tr>
                <td colspan="2" align="center" style="color:red;">密碼錯誤</td>
            </tr>
            <?php } ?>
            <tr>
                <td>現有密碼 :</td>
                <td><input type="password" name="password_old" required></td>
            </tr>
            <tr>
                <td>新密碼 :</td>
                <td><input type="password" name="password_hash" id="password_hash" required></td>
            </tr>
            <tr>
                <td>確認密碼 :</td>
                <td><input type="password" name="password_confirm" id="password_confirm" required></td>
            </tr>
            <tr>
                <td></td>
                <td><span id="password_confirm_msg" style="color:red;margin-left:5px"></span></td>
            </tr>
            </table>
            <input type="submit" name="submit" class="ui_btn_green" value="儲存" style="border:none;cursor:pointer">
            </form>
            </div>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>