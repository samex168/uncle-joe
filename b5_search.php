<?php
    require_once('_common/conn_open.php');
    require_once('_common/common.php');
    require_once('_common/data_functions.php');

    $text = mysql_real_escape_string(trim(str_replace("'", "", $_GET['search_text'])));

    $cat1= isset($_GET['cat1'])?$_GET['cat1']:"";
    $cat2= isset($_GET['cat2'])?$_GET['cat2']:"";
    $cat3= isset($_GET['cat3'])?$_GET['cat3']:"";

    $page = (isset($_GET["page"]))?$_GET["page"]:1;
    if($page == 0){
        $page = 1;
    }
    $pagingSize = $PARAMS['pagingSize'];
    $offset = ($page-1)* $pagingSize;

    $result = mysql_query("SELECT * FROM `product` WHERE (name_en LIKE '%$text%' OR name_tc LIKE '%$text%') AND status=1 limit $offset, $pagingSize");
    $totalRecord = mysql_num_rows(mysql_query("SELECT * FROM `product` WHERE (name_en LIKE '%$text%' OR name_tc LIKE '%$text%') AND status=1"));
    $totalPage = ceil($totalRecord/$pagingSize);
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
    	<h1><img src="images/banner_supermarket.jpg" width="1200" height="220" alt=""/></h1>
        <p id="path"><a href="index.php">主頁</a> &gt; 搜尋 : <span class="ui_info2"><?=$text?></span> &gt; <span>搜尋結果</span></p>
        <h1 class="ui_nav2_subtitle">您的搜尋找到 <?=$totalRecord?> 結果.</h1>
        <?php if($totalRecord>0){ ?>
        <ul id="porductlist" class="ui_nolst ui_nomp">
            <?php while($row = mysql_fetch_array($result)){ ?>
            <li>
            <a href="b5_product_detail.php?plu=<?=$row['plu']?>" class="productimg"><img src="<?=$PARAMS['productPath'].$row['img_s']?>" alt="" /></a>
            <p><a href="b5_product_detail.php?plu=<?=$row['plu']?>"><span class="ui_info1"><?=checkProductNameLen($row['name_tc'])?></span></a><br><span class="ui_price2">$<?=number_format($row['price'],$PARAMS['decimals'])?>/<?=$row['unit_tc']?></span><br><a href="javascript:void(0);" class="ui_btn_addcart" onclick="addToCart('<?=$row['plu']?>')">加入購物車</a></p>
            </li>
            <?php } ?>
        </ul>
        <ul id="paging" class="ui_nolst ui_nomp">
            <script>showPaging(<?=$totalPage?>, <?=$page?>, 'b5_search.php','&search_text=<?=$text?>');</script>
            <li class="ui_separate"><span>到第</span><input type="text" name="page_input" id="page_input"><span>頁</span></li>
            <li><a href="javascript:void(0);" onclick="goToPage('b5_search.php?search_text=<?=$text?>')">確定</a></li>
        </ul>
        <?php }else{ ?>
            <p>&nbsp;</p>
            <p align="center">抱歉，我們找不到您所查詢的貨品。請使用其他關鍵字搜尋</p>
            <p>&nbsp;</p>
        <?php } ?>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>