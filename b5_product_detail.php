<?php
    require_once('_common/conn_open.php');
    require_once('_common/common.php');
    require_once('_common/data_functions.php');

    $plu = mysql_real_escape_string($_GET["plu"]);
    $cat1 = isset($_GET["cat1"])?$_GET["cat1"]:"";
    $cat2 = isset($_GET["cat2"])?$_GET["cat2"]:"";
    $cat3 = isset($_GET["cat3"])?$_GET["cat3"]:"";

    $cat1_title = $cat1==""?"":getValueFromTableByCon('title_tc','cat1','id',$cat1);
    $cat2_title = $cat2==""?"":getValueFromTableByCon('title_tc','cat2','id',$cat2);
    $cat3_title = $cat3==""?"":getValueFromTableByCon('title_tc','cat3','id',$cat3);

    $result = mysql_query("SELECT * FROM product WHERE plu='$plu'");
    $row = mysql_fetch_array($result);

    
    if(!isset($_COOKIE["unclejoe_view_cookies"])){
        setcookie("unclejoe_view_cookies", $plu, time()+(86400), "/"); // 86400 = 1 day
    }else{
        $cookie = $_COOKIE["unclejoe_view_cookies"].",".$plu;
        setcookie("unclejoe_view_cookies", $cookie, time()+(86400), "/");
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
<link rel="stylesheet" href="plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
        $(".fancybox_helpers").fancybox({
          helpers: {
              title : {
                  type : 'float'
              }
          }
      });
    });
</script>
<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
  	<div id="proinfobox">
        <p id="path"><?php if($cat1_title!="")echo $cat1_title." &gt; ".$cat2_title." &gt; ".$cat3_title ?></p>
      	<div id="proimgbox">
        	<img src="<?=$PARAMS['productPath'].$row['img_m']?>" alt="" />
        </div>
        <div id="proinfo">
        	<h1><?=$row["name_tc"]?></h1>
        	<p>產地：<?=$row["country_tc"]?></p>
        	<p>網上優惠價：<?=number_format($row["price"],$PARAMS["decimals"])?></p>
        	<p>數量：<select name="quantity" class="quantity-select" id="quantity-select-<?=$row['plu']?>"><?=genQtySelectOption($value)?></select>／<label for="quantity-select-<?=$row['plu']?>">盒</label></p>
        	<p><a href="javascript:void(0);" onclick="addToCart('<?=$row['plu']?>')"><img src="images/btn_addcart.png" width="130" height="35" alt="加入購物車"/></a>　<a href="javascript:history.back(-1);"><img src="images/btn_back.jpg" width="93" height="35" alt="返回"/></a></p>
        	<p>&nbsp;</p>
        	<p><a href="<?=$PARAMS['productPath'].$row['img_l']?>" class="color_f90 fancybox_helpers">按此查看大圖</a></p>
        	<p><?=htmldecode($row['des_tc'])?></p>
        	<hr/>
            <ol>
            	<li>以上價格為折實價，不可與其他優惠同時使用。</li>
                <li>以上圖片只供參考，一切以實物作準。</li>
            </ol>
        </div>
  </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>