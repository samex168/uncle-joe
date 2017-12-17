<?php
    require_once('_common/conn_open.php');
    require_once('_common/common.php');
    require_once('_common/data_functions.php');

    $cat1 = $_GET['cat1'];
    $cat2 = $_GET['cat2'];
    $cat3 = $_GET['cat3'];

    $cat1_title = getValueFromTableByCon('title_tc','cat1','id',$cat1);
    $cat2_title = getValueFromTableByCon('title_tc','cat2','id',$cat2);
    $cat3_title = getValueFromTableByCon('title_tc','cat3','id',$cat3);

    $page_banner = mysql_fetch_array(mysql_query("SELECT img_tc FROM page_banner WHERE cat1ID=$cat1 AND status=1"));
    $page_banner = $page_banner[0];

    $page = (isset($_GET["page"]))?$_GET["page"]:1;
    if($page == 0){
        $page = 1;
    }
    $pagingSize = 10;
    $offset = ($page-1)* $pagingSize;

    $result = mysql_query("SELECT *, `cp`.`id` AS cpid, `p`.`id` AS pid FROM `cat_product` as `cp` LEFT JOIN `product` as `p` ON `cp`.`plu`=`p`.`plu` WHERE status=1 AND cat1=$cat1 AND cat2=$cat2 AND cat3=$cat3 order by seq limit $offset, $pagingSize");
    $totalRecord = mysql_num_rows(mysql_query("SELECT * FROM `cat_product` AS `cp` LEFT JOIN `product` AS `p` ON `cp`.plu=`p`.plu WHERE `p`.status=1 AND cat1=$cat1 AND cat2=$cat2 AND cat3=$cat3"));
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
    	<h1><img src="<?=$PARAMS['bannerPath'].$page_banner?>" width="1200" height="220" alt=""/></h1>
        <p id="path"><?=$cat1_title?> &gt; <?=$cat2_title?> &gt; <?=$cat3_title?></p>
        <ul id="porductlist" class="ui_nolst ui_nomp list">
        <!--	<li>
            <a href="b5_supermarket_product_detail.php" class="productimg"><img src="images/product/temp_001.jpg" alt="" /></a>
            <p><a href="b5_supermarket_product_detail.php"><span class="ui_info1">衍生至尊感冒止咳顆粒沖劑 (8包裝)</span></a><br><span class="ui_price2">$135/盒</span><br><a href="javascript:void(0);" class="ui_btn_addcart">加入購物車</a></p>
            </li> -->
            <?php while($row = mysql_fetch_array($result)){ ?>
            <li class="list__item"><div class="list-content">
            <a href="b5_product_detail.php?plu=<?=$row['plu']?>&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>" class="productimg"><img src="<?=$PARAMS['productPath'].$row['img_s']?>" alt="" /></a>
            <p><a href="b5_product_detail.php?plu=<?=$row['plu']?>&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>"><span class="ui_info1"><?=$row['name_tc']?></span></a><br><span class="ui_price2">$<?=number_format($row['price'],$PARAMS['decimals'])?>/<?=$row['unit_tc']?></span><br><a href="javascript:void(0);" class="ui_btn_addcart" onclick="addToCart('<?=$row['plu']?>')">加入購物車</a></p></div>
            </li>
            <?php } ?>
        </ul>
        <ul id="paging" class="ui_nolst ui_nomp">
            <script>showPaging(<?=$totalPage?>, <?=$page?>, 'b5_cat_details.php','&cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>');</script>
        <!--	<li><a href="javascript:void(0);">&lt; 上一頁</a></li>
            <li><a href="javascript:void(0);" class="using">1</a></li>
            <li><a href="javascript:void(0);">下一頁 &gt;</a></li> -->
            <li class="ui_separate"><span>到第</span><input type="text" name="page_input" id="page_input"><span>頁</span></li>
            <li><a href="javascript:void(0);" onclick="goToPage('b5_cat_details.php?cat1=<?=$cat1?>&cat2=<?=$cat2?>&cat3=<?=$cat3?>')">確定</a></li>
        </ul>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>