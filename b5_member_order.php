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

    $new_order = mysql_query("SELECT * FROM order_details WHERE memberId='$id' AND orderStatus=1 ORDER BY date_order DESC, orderNo DESC");
    $new_order_record = mysql_num_rows(mysql_query("SELECT * FROM order_details WHERE memberId='$id' AND orderStatus=1"));
    $processed_order = mysql_query("SELECT * FROM order_details WHERE memberId='$id' AND orderStatus!=1 ORDER BY date_order DESC, orderNo DESC");
    $processed_order_record = mysql_num_rows(mysql_query("SELECT * FROM order_details WHERE memberId='$id' AND orderStatus!=1"));
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
        <p id="path"><a href="index.php">主頁</a> &gt; <a href="b5_member.php">會員資料</a> &gt; 購物記錄</p>
        <div id="continer" style="width:100%;padding:20px;">
            <div class="continer" style="width:98%;padding:10px;">
                <h1 class="ui_nav2_subtitle">處理中的訂單</h1>
                <?php if($new_order_record>0){ ?>
                <table width="100%" cellpadding="4" cellspacing="4">
                <tr bgcolor="#FFFFFF">
                    <th width="20%" align="left">訂單編號</th>
                    <th width="20%" align="left">訂單日期</th>
                    <th width="20%" align="left">訂單總額</th>
                    <th width="20%" align="left">訂單狀態</th>
                    <th width="20%" align="left">訂單詳情</th>
                </tr>
                <?php while ($row=mysql_fetch_array($new_order)){
                    $total = $row['cartTotal']+$row['deliveryCharge']-($row['coupon']==""?0:$row['cartTotal']*getCouponDiscount($row['coupon']));
                 ?>
                <tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'">
                    <td><?=$row['orderNo']?></td>
                    <td><?=$row['date_order']?></td>
                    <td>HKD $ <?=$total?></td>
                    <td><?=getOrderStatus($row['orderStatus'])?></td>
                    <td><a href="b5_member_order_details.php?orderNo=<?=$row['orderNo']?>">查看訂單</a></td>
                </tr>
                <?php } ?>
                </table>
                <?php }else{ ?>
                    <p align="center">沒有記錄</p>
                <?php } ?>
            </div>
            <p></p>
            <div class="continer" style="width:98%;padding:10px;">
                <h1 class="ui_nav2_subtitle">已處理的訂單</h1>
                <?php if($processed_order_record>0){ ?>
                <table width="100%" cellpadding="4" cellspacing="4">
                <tr bgcolor="#FFFFFF">
                    <th width="20%" align="left">訂單編號</th>
                    <th width="20%" align="left">訂單日期</th>
                    <th width="20%" align="left">訂單總額</th>
                    <th width="20%" align="left">訂單狀態</th>
                    <th width="20%" align="left">訂單詳情</th>
                </tr>
                <?php while ($row=mysql_fetch_array($processed_order)){
                    $total = $row['cartTotal']+$row['deliveryCharge']-($row['coupon']==""?0:$row['cartTotal']*getCouponDiscount($row['coupon']));
                 ?>
                <tr bgcolor="#FFFFFF" onMouseOver="bgColor='#CCFFFF'" onMouseOut="bgColor='#FFFFFF'">
                    <td><?=$row['orderNo']?></td>
                    <td><?=$row['date_order']?></td>
                    <td>HKD $ <?=$total?></td>
                    <td><?=getOrderStatus($row['orderStatus'])?></td>
                    <td><a href="b5_member_order_details.php?orderNo=<?=$row['orderNo']?>">查看訂單</a></td>
                </tr>
                <?php } ?>
                </table>
                <?php }else{ ?>
                    <p align="center">沒有記錄</p>
                <?php } ?>
            </div>
            <div style="padding:10px">
            <a href="b5_member.php"><img src="images/btn_back.jpg"></a>
            </div>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>