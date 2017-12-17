<?php 
  require_once('_common/common.php');
  require_once('_common/CSRF.php');
  require_once('_common/conn_open.php');
  require_once('_common/data_functions.php');

  if(sizeof($_SESSION["cart"])<=0 || !isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN'])){
    redirect("b5_cart.php");
    exit();
  }

  $cartTotal = countCartTotal();
  $deliveryCharge = checkDeliveryCharge(countCartTotal(),$_POST['area']);
  $couponDiscount = 0;

  unset($_SESSION["order_detail_form"]);
  $_SESSION["order_detail_form"] = $_POST;
  $_SESSION["order_detail_form"]["memberId"] = $_SESSION["member"]["id"];
  $_SESSION["order_detail_form"]["date_order"] = $today;
  $_SESSION["order_detail_form"]["cartTotal"] = $cartTotal;
  $_SESSION["order_detail_form"]["deliveryCharge"] = $deliveryCharge;
  $_SESSION["order_detail_form"]["paymentMethod"] = 1;
  $_SESSION["order_detail_form"]["paymentStatus"] = 1;
  $_SESSION["order_detail_form"]["paymentRemark"] = "";
  if(isset($_SESSION["coupon"])){
    $coupon = getCouponByCode($_SESSION["coupon"]);
    $_SESSION["order_detail_form"]["coupon"] = $coupon['code'];
    $_SESSION["order_detail_form"]["discount"] = $coupon['value'];
    $couponDiscount = $cartTotal*(1-$coupon['value']);
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

<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
  	<div>
        <p id="path">主頁 &gt; 購物車 &gt; 資料確定</p>
        <div id="continer">
        	<h1 class="ui_nav2_subtitle">購物車 - 資料確定</h1>
        	<div id="cartleft">
           		<h2>購物車內共 <span class="color_f90"><?=sizeof($_SESSION['cart'])?></span> 件商品</h2>
            	<ul class="ui_nolst ui_nomp">
             <!--   	<li><table width="100%" border="0" cellspacing="0" cellpadding="3">
            	  <tbody>
            	    <tr>
            	      <td width="90" align="center"><img src="images/product/temp_001.jpg" width="170" height="160" alt=""/></td>
            	      <td valign="top">衍生<br>
           	          <strong>衍生至尊感冒止咳顆粒沖劑 (8包裝)</strong><br>
           	          <span class="color_aaa">盒</span></td>
            	      <td width="14%" align="center">$ 179.90</td>
            	      <td width="14%" align="center">數量 1</td>
            	      <td width="14%" align="center">$ 179.90</td>
           	        </tr>
           	      </tbody>
          	  </table></li>  -->
                <?php foreach ($_SESSION["cart"] as $key => $value) { $row=getProductByPLU($key); ?>
                  <li><table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tbody>
                    <tr>
                      <td width="90" align="center"><img src="<?=$PARAMS['productPath'].$row['img_s']?>" alt=""/></td>
                      <td valign="top"><?=$row['brand_tc']?><br>
                        <strong><?=$row['name_tc']?></strong><br>
                        <span class="color_aaa"><?=$row['unit_tc']?></span></td>
                      <td width="14%" align="center">$ <?=number_format($row['price'],$PARAMS['decimals'])?></td>
                      <td width="14%" align="center">數量 <?=$value?></td>
                      <td width="14%" align="center">$ <?=number_format($row['price']*$value,$PARAMS['decimals'])?></td>
                      </tr>
                    </tbody>
                  </table></li>
                <?php } ?>
                </ul>
          	</div>
            <div id="payright">
            	<h2 class="ui_title">結帳小計</h2>
            	<table width="100%" border="0" cellspacing="0" cellpadding="3">
           		  <tbody>
            	    <tr>
            	      <td>商品總額</td>
            	      <td align="right">$ <?=number_format($cartTotal,$PARAMS['decimals'])?></td>
          	      </tr>
                  <?php if(isset($_SESSION['member']) && isset($_SESSION['coupon'])){ ?>
                  <tr>
                    <td><?=$coupon['title_tc']?></td>
                    <td align="right">$ (<?=number_format($couponDiscount,$PARAMS['decimals'])?>)</td>
                  </tr>
                  <?php } ?>
            	    <tr>
            	      <td>運費</td>
            	      <td align="right">$ <?=number_format($deliveryCharge,$PARAMS['decimals'])?></td>
          	      </tr>
            	    <tr class="color_f90">
            	      <td style="border-top: 1px #ccc solid;"><strong>訂單總額:</strong></td>
            	      <td align="right" style="border-top: 1px #ccc solid;">$ <?=number_format($cartTotal+$deliveryCharge-$couponDiscount,$PARAMS['decimals'])?></td>
          	      </tr>
       	    	  </tbody>
   	  	  	  </table>
            	<div id="logined">
                <div>
                <h2>送貨地址</h2>
                <p>收件人姓名 :<br> <?=$_POST['addressee']?></p>
                <p>聯絡電話 :<br> <?=$_POST['tel']?></p>
                <hr />
                <p>
                  <?=getAreaName($_POST['area'])?><br>
                  <?=$_POST['district']?><br>
                  <?=$_POST['street']?><br>
                  <?=$_POST['flat']?></p>
                <hr />
                <p>
                送貨日期 :<br>
                <?=$_POST['date_delivery']?>
                </p>
                <hr />
                <form action="eshop_process.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
                  <?= CSRF::genHiddenCSRF('cart_confirm-form'); ?>
                <p align="center"><a href="b5_cart.php" class="ui_btn_green">修改購物車</a>&nbsp;<input name="submit" type="submit" value="確定付款" class="ui_btn_green" style="border:none;cursor:pointer"></p>
                </form>
                </div>
              </div>
          </div>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>