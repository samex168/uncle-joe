<?php
    require_once('_common/conn_open.php');
    require_once('_common/common.php');
    require_once('_common/data_functions.php');

    $slide_result = mysql_query("SELECT * FROM slide WHERE status=1 AND date_start<='$today' AND date_end>='$today' ORDER BY seq");

    $top10_result = mysql_query("SELECT * FROM top10 AS `t` LEFT JOIN product AS `p` ON `t`.plu=`p`.plu WHERE `t`.status=1 AND date_start<='$today' AND date_end>='$today' ORDER BY seq LIMIT 10");
    $top10_index = 0;

    $hit_result = mysql_query("SELECT * FROM product WHERE status=1 AND hit_product=1 ORDER BY RAND() LIMIT 4");
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>UNCLE JOE</title>

        <link href="css/ui_base.css" type="text/css" rel="stylesheet">
        
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
    <body>
        <? include "b5_header.php" ?>
        <div id="content">
            <div class="slider-wrapper theme-default">
                <div id="slider" class="nivoSlider">
                    <?php while($slide_row=mysql_fetch_array($slide_result)){ 
                        if($slide_row['link_tc']!=""){ ?>
                            <a href="<?=$slide_row['link_tc']?>" target="<?=$slide_row['target']?>"><img src="<?=$PARAMS['bannerPath'].$slide_row['img_tc']?>" alt=""/></a>

                    <?php }else{ ?>
                            <img src="<?=$PARAMS['bannerPath'].$slide_row['img_tc']?>" alt=""/>
                    <?php } } ?>
                <!--    <img src="images/banner/banner_001.jpg" alt=""/>
                    <a href="b5_index.php"><img src="images/banner/banner_002.jpg" alt=""/></a>
                    <img src="images/banner/banner_003.jpg" alt=""/> -->
                </div>
                <div id="htmlcaption" class="nivo-html-caption">
                    <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
                </div>
            </div>
            <div>
                <p>&nbsp;</p>
                <h1><img src="images/title_top10.png" width="374" height="80" alt=""/></h1>
                <ul id="top1" class="ui_nolst ui_nomp">
                <!--   <li>
                        <span>1</span>
                        <a href="javascript:void(0);" class="productimg"><img src="images/product/temp_001.jpg" alt="" /></a>
                        <p><a href="javascript:void(0);"><span class="ui_info1">衍生至尊感冒止咳顆粒沖劑 (8包裝)</span></a><br><span class="ui_price1">$148</span><br><span class="ui_price2">$135</span><br><a href="javascript:void(0);"><img src="images/btn_addcart.png" width="130" height="35" alt="加入購物車"/></a></p>
                    </li> -->
                <?php while($top10_row = mysql_fetch_array($top10_result)){ $top10_index+=1; ?>
                    <li>
                        <span><?=$top10_index?></span>
                        <a href="b5_product_detail.php?plu=<?=$top10_row['plu']?>" class="productimg"><img src="<?=$PARAMS['productPath'].$top10_row['img_s']?>" alt="" /></a>
                        <p><a href="b5_product_detail.php?plu=<?=$top10_row['plu']?>"><span class="ui_info1"><?=$top10_row['name_tc']?></span></a><br><span class="ui_price1">$<?=$top10_row['price']?></span><br><span class="ui_price2">$<?=$top10_row['price']?></span><br><a href="javascript:void(0);" onclick="addToCart('<?=$top10_row['plu']?>')"><img src="images/btn_addcart.png" width="130" height="35" alt="加入購物車"/></a></p>
                    </li>
                <?php if($top10_index==3)break; } ?>
                </ul>
                <br>
                <ul id="top4" class="ui_nolst ui_nomp">
                <!--    <li>
                        <span>4</span>
                        <a href="javascript:void(0);"><img src="images/product/temp_001.jpg" alt="" /></a>
                        <p><a href="javascript:void(0);"><span class="ui_info1">衍生至尊感冒止咳顆粒沖劑 (8包裝)</span></a><br><span class="ui_info2">500克</span></p>
                    </li>  -->
                <?php while($top10_row = mysql_fetch_array($top10_result)){ $top10_index+=1; ?>
                    <li>
                        <span><?=$top10_index?></span>
                        <a href="b5_product_detail.php?plu=<?=$top10_row['plu']?>"><img src="<?=$PARAMS['productPath'].$top10_row['img_s']?>" alt="" /></a>
                        <p><a href="b5_product_detail.php?plu=<?=$top10_row['plu']?>"><span class="ui_info1"><?=$top10_row['name_tc']?></span></a><br><span class="ui_info2"><?=$top10_row['remark_tc']?></span></p>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <div id="hotpro">
            <div>
                <h1><img src="images/title_hit_product.png" width="258" height="93" alt=""/></h1>
                <ul class="ui_nomp ui_nolst">
                <!--    <li>
                        <a href="javascript:void(0);"><img src="images/product/temp_001.jpg" alt="" />
                            <p class="ui_info1">衍生至尊感冒止咳顆粒沖劑 (8包裝)</p></a>
                    </li> -->
                <?php while($hit_row = mysql_fetch_array($hit_result)){ ?>
                    <li>
                        <a href="b5_product_detail.php?plu=<?=$hit_row['plu']?>"><img src="<?=$PARAMS['productPath'].$hit_row['img_s']?>" alt="" />
                        <p class="ui_info1"><?=$hit_row['name_tc']?></p></a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <? include "b5_footer.php" ?>
    </body>
    <script>
    	$(window).load(function() {
			hideCategories();
		});
	</script>
</html>
<?php require_once('_common/conn_close.php'); ?>