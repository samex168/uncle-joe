<?php
    require_once('_common/CSRF.php');
    require_once('_common/conn_open.php');
    require_once('_common/common.php');
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

<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
  	<div>
        <p id="path">主頁 &gt; 登入/註冊</p>
        <div id="continer">
        	<h1 class="ui_nav2_subtitle">登入/註冊</h1>
        	<div id="loginleft">
           	  <h2>已註冊用戶</h2>
              <form action="login_action.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
              <?= CSRF::genHiddenCSRF('member_login-form'); ?>
                <input type="hidden" name="module" value="b5_index">
            	<p><input name="email" type="text" placeholder="電郵" class="ui_inputbox200W" required></p>
            	<p><input name="password_hash" type="password" placeholder="密碼" class="ui_inputbox200W" required></p>
            	<p>&nbsp;</p>
                <p><a href="b5_forgotpwd.php" class="ui_btn_redborder">忘記密碼?</a><input type="submit" name="submit" class="ui_rightbtn ui_btn_green" style="cursor:pointer;border:none" value="登入"></p>
              </form>
          	</div>
            <div id="regright">
            	<h2>還未成為註冊用戶？</h2>
                <p>立即註冊帳戶</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p align="right"><a href="b5_reg.php" class="ui_rightbtn ui_btn_green">註冊</a></p>
          </div>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>