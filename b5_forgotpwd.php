<?php
    require_once('_common/common.php');
    require_once('_common/conn_open.php');
    require_once('_common/CSRF.php');

    $msg = isset($_GET['msg'])?$_GET['msg']:"";
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
      $('#email_msg2').html("<?=$PARAMS['NOT_VALID_EMAIL']?>");
      return false;
    }
    if($('#checkEmailExist').val()=="0"){
      $('#email_msg2').html("<?=$PARAMS['NOT_REG_EMAIL']?>");
      return false;
    }
}
function clearMsg(){
    $('#email_msg').html("");
}
</script>
<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
    <div>
        <p id="path"><a href="index.php">主頁</a> &gt; 忘記密碼</p>
        <div id="continer">
            <h1 class="ui_nav2_subtitle">忘記密碼</h1>
            <p>&nbsp;</p>
            <div align="center">
                <?php if($msg=="1"){ ?>
                <p style="color:red">新密碼將會發送至您的電郵地址，使用新密碼重新登入後請更改密碼。</p>
                <?php } ?>
                <form action="forgotpwd_action.php" name="form1" enctype="multipart/form-data" method="post" onsubmit="return checkform()">
                    <?= CSRF::genHiddenCSRF('forgotpwd-form'); ?>
                    <input type="hidden" id="checkEmailExist" value=-1>
                <table cellspacing="5" cellpadding="5">
                <tr><th align="left"><h3>請輸入您的電郵地址 : </h3></th></tr>
                <tr><td><input type="text" name="email" id="email" size="50" required><td></tr>
                <tr><td><span id="email_msg2" style="color:red"></span></td></tr>
                <tr><td><input type="submit" name="submit" class="ui_btn_green" value="確定" style="border:none;cursor:pointer"><td></tr>
                </table>
                </form>
            </div>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>