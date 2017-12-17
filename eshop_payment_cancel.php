<?php
    require_once('_common/common.php');
    require_once('_common/CSRF.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

    $orderID = isset($_POST['orderNo'])?$_POST['orderNo']:"";
    $email = isset($_POST['email'])?$_POST['email']:"";
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
        <p id="path">主頁 &gt; 購物車 &gt; 付款取消</p>
        <div id="continer">
        	<h1 class="ui_nav2_subtitle">購物車 - 付款取消</h1>
            <p>&nbsp;</p>
            <p align="center">訂單 <?=$orderNo?> 已經取消。</p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>