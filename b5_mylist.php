<?php
    require_once('_common/conn_open.php');
    require_once('_common/common.php');
    require_once('_common/data_functions.php');

    $cookie = explode(",", $_COOKIE['unclejoe_view_cookies']);

    $view_result = mysql_query("SELECT * FROM product WHERE plu IN ('".implode("','", $cookie)."') LIMIT 10");
    $view_record = mysql_num_rows(mysql_query("SELECT * FROM product WHERE plu IN ('".implode("','", $cookie)."')"));

    if(isset($_SESSION['member']['id']) && $_SESSION['member']['id']!=""){
        $list = "";
        $mid = $_SESSION['member']['id'];
        $order_result = mysql_query("SELECT * FROM order_details WHERE memberId=$mid AND orderStatus=3");
        while ($order_row=mysql_fetch_array($order_result)) {
            $orderNo = $order_row['orderNo'];
            $product_result = mysql_query("SELECT * FROM order_product WHERE orderNo='$orderNo'");
            while ($product_row=mysql_fetch_array($product_result)) {
                if($list==""){
                    $list .= $product_row['plu'];
                }else{
                    $list .= ",".$product_row['plu'];
                }
            }
        }
        $list = explode(",", $list);
        $buy_result = mysql_query("SELECT * FROM product WHERE plu IN ('".implode("','", $list)."') LIMIT 10");
        $buy_record = mysql_num_rows(mysql_query("SELECT * FROM product WHERE plu IN ('".implode("','", $list)."')"));
    }
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
<script type="text/javascript" src="js/paging.js"></script>
<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
    <div>
        <p id="path"><a href="index.php">主頁</a> &gt; 我的清單</p>
        <div id="continer">
        <h1 class="ui_nav2_subtitle">最近查看商品</h1>
        <?php if($view_record>0){ ?>
        <ul id="porductlist" class="ui_nolst ui_nomp list">
            <?php while($row = mysql_fetch_array($view_result)){ ?>
            <li class="list__item"><div class="list-content">
            <a href="b5_product_detail.php?plu=<?=$row['plu']?>&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>" class="productimg"><img src="<?=$PARAMS['productPath'].$row['img_s']?>" alt="" /></a>
            <p><a href="b5_product_detail.php?plu=<?=$row['plu']?>&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>"><span class="ui_info1"><?=$row['name_tc']?></span></a><br><span class="ui_price2">$<?=number_format($row['price'],$PARAMS['decimals'])?>/<?=$row['unit_tc']?></span><br><a href="javascript:void(0);" class="ui_btn_addcart" onclick="addToCart('<?=$row['plu']?>')">加入購物車</a></p></div>
            </li>
            <?php } ?>
        </ul>
        <?php }else{ ?>
            <p>&nbsp;</p>
            <p align="center">沒有記錄</p>
            <p>&nbsp;</p>
        <?php } ?>
        </div>
        <?php if(isset($_SESSION['member']['id'])){ ?>
        <div id="continer" style="margin-top:20px">
        <h1 class="ui_nav2_subtitle">曾經購買商品</h1>
        <?php if($buy_record>0){ ?>
        <ul id="porductlist" class="ui_nolst ui_nomp list">
            <?php while($row = mysql_fetch_array($buy_result)){ ?>
            <li class="list__item"><div class="list-content">
            <a href="b5_product_detail.php?plu=<?=$row['plu']?>&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>" class="productimg"><img src="<?=$PARAMS['productPath'].$row['img_s']?>" alt="" /></a>
            <p><a href="b5_product_detail.php?plu=<?=$row['plu']?>&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>"><span class="ui_info1"><?=$row['name_tc']?></span></a><br><span class="ui_price2">$<?=number_format($row['price'],$PARAMS['decimals'])?>/<?=$row['unit_tc']?></span><br><a href="javascript:void(0);" class="ui_btn_addcart" onclick="addToCart('<?=$row['plu']?>')">加入購物車</a></p></div>
            </li>
            <?php } ?>
        </ul>
        <?php }else{ ?>
            <p>&nbsp;</p>
            <p align="center">沒有記錄</p>
            <p>&nbsp;</p>
        <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>