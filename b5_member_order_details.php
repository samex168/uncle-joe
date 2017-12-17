<?php
    require_once('_common/common.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

    if(!isset($_SESSION['member']["id"])){
        redirect('b5_login.php');
        exit();
    }

    $id = mysql_real_escape_string(trim(str_replace("'", "", $_SESSION['member']["id"])));
    $orderNo = mysql_real_escape_string($_GET['orderNo']);

    $msg = isset($_GET["msg"])?$_GET["msg"]:"";

    $order_details = mysql_query("SELECT * FROM order_details WHERE orderNo='$orderNo'");
    $order_row = mysql_fetch_array($order_details);
    $order_product = mysql_query("SELECT * FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu=`p`.plu WHERE orderNo='$orderNo'");
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
        <p id="path"><a href="index.php">主頁</a> &gt; <a href="b5_member.php">會員資料</a> &gt; <a href="b5_member_order.php">購物記錄</a></p>
        <div id="continer" style="width:100%;padding:20px;">
            <h1 class="ui_nav2_subtitle"><span>訂單編號 : <?=$orderNo?></span><span style="margin-right:50px;margin-left:50px">訂單日期 : <?=$order_row['date_order']?></span><span>訂單狀態 : <?=getOrderStatus($order_row['orderStatus'])?></span></h1>
            <h2><span class="color_f90" style="margin-right:50px">付款方式 : <?=getPaymentMethod($order_row['paymentMethod'])?></span><span class="color_f90">付款狀態 : <?=getPaymentStatus($order_row['paymentStatus'])?></span></h2>
            <div>
            <div style="width:20%;float:left;border:margin:5px">
            <p>收件人 : <?=$order_row['addressee']?></p>
            <p>送貨日期 : <?=$order_row['date_delivery']?></p>
            </div>
            <table cellpadding="4" cellspacing="4">
            <tr>
                <td>送貨地址 :</td>
                <td>座數 / 樓層 / 單位 :</td>
                <td><?=$order_row['flat']?></td>
            </tr>
            <tr><td></td>
                <td>大廈名稱 :</td>
                <td><?=$order_row['building']?></td>
            </tr>
            <tr><td></td>
                <td>屋苑 / 街道 :</td>
                <td><?=$order_row['street']?></td>
            </tr>
            <tr><td></td>
                <td>地區 :</td>
                <td><?=$order_row['district']?></td>
            </tr>
            <tr><td></td><td></td>
                <td><?=getAreaName($order_row['area'])?></td>
            </tr>
            </table>
            </div>
            <div style="margin-top:20px">
            <table cellpadding="4" cellspacing="4">
            <tr>
                <th align="left" width="10%">商品編號</th>
                <th align="left" width="30%">商品名稱</th>
                <th align="left" width="5%">數量</th>
                <th align="left" width="10%">售價</th>
            </tr>
            <?php while($row=mysql_fetch_array($order_product)){ ?>
            <tr>
                <td><?=$row['plu']?></td>
                <td><?=$row['name_tc']?></td>
                <td><?=$row['qty']?></td>
                <td>HKD $ <?=$row['price']?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="4"><hr/></td>
            </tr>
            <tr><td colspan="2"></td>
                <td align="right">商品總額 :</td>
                <td>HKD $ <?=$order_row['cartTotal']?></td>
            </tr>
            <?php if($order_row['coupon']!=""){ 
                $coupon_row=getCouponByCode($order_row['coupon']);
                $discount = $order_row['cartTotal']*getCouponDiscount($order_row['coupon']); ?>
            <tr><td colspan="2"></td>
                <td align="right"><?=$coupon_row['title_tc']?></td>
                <td>HKD $ (<?=$discount?>)</td>
            </tr>
            <?php } ?>
            <tr><td colspan="2"></td>
                <td align="right">運費 :</td>
                <td>HKD $ <?=$order_row['deliveryCharge']?></td>
            </tr>
            <tr><td colspan="2"></td>
                <td align="right">訂單總額 :</td>
                <td>HKD $ <?=$order_row['cartTotal']+$order_row['deliveryCharge']-$discount?></td>
            </tr>
            </table>
            </div>
            <div style="padding:10px">
            <a href="b5_member_order.php"><img src="images/btn_back.jpg"></a>
            </div>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>