<?php 
  require_once('_common/common.php');
  require_once('_common/CSRF.php');
  require_once('_common/conn_open.php');
  require_once('_common/data_functions.php');
 // unset($_SESSION["cart"]);
 // $_SESSION["member"]["id"] = 1;
//  $_SESSION["cart"]["HKC-16759"] = 5;
//  $_SESSION["cart"]["HKC-16700"] = 6;
//  $_SESSION["coupon"] = "UNCLE-JOE_MEMBER";  //code

  if(isset($_SESSION["member"]["id"])){
    $result = mysql_query("SELECT * FROM member WHERE id='".$_SESSION["member"]["id"]."'");
    $member_row = mysql_fetch_array($result);
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
        <script type="text/javascript" src="CMSAdmin/js/jquery.min.js"></script>
        <script type="text/javascript" src="CMSAdmin/js/jquery-migrate.min.js"></script>
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
       <link type="text/css" href="plugins/datepicker2/themes/ui-lightness/ui.all.css" rel="stylesheet" />
       <script type="text/javascript" src="plugins/datepicker2/ui/ui.core.js"></script>
       <script type="text/javascript" src="plugins/datepicker2/ui/ui.datepicker.js"></script> 
</head>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
  $(function() {
      var date = new Date();
      date.setDate(date.getDate() + 3);
      $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: date
      });
  });
</script>
<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
  	<div>
        <p id="path"><a href="index.php">主頁</a> &gt; 購物車</p>
        <div id="continer">
        	<h1 class="ui_nav2_subtitle">購物車</h1>
        	<div id="cartleft">
           		<h2>購物車內共 <span class="color_f90"><?=sizeof($_SESSION['cart'])?></span> 件商品</h2>
            	<ul class="ui_nolst ui_nomp">
           <!--     	<li><table width="100%" border="0" cellspacing="0" cellpadding="3">
            	  <tbody>
            	    <tr>
            	      <td width="90" align="center"><img src="images/product/temp_001.jpg" width="170" height="160" alt=""/></td>
            	      <td valign="top">衍生<br>
           	          <strong><a href="b5_supermarket_product_detail.php" class="color_f90">衍生至尊感冒止咳顆粒沖劑 (8包裝)</a></strong><br>
           	          <span class="color_aaa">盒</span></td>
            	      <td width="14%" align="center">$ 179.90</td>
            	      <td width="14%" align="center">數量 <select name="quantity" class="quantity-select" id="quantity-select-0">
                      <?=genQtySelectOption()?>
                      </select></td>
            	      <td width="14%" align="center">$ 179.90 <a href="javascript:void(0);"><strong>X</strong></a></td>
           	        </tr>
           	      </tbody>
          	  </table></li>  -->
                <?php if(isset($_SESSION["cart"])){ foreach ($_SESSION["cart"] as $key => $value) { $row=getProductByPLU($key); ?>
                    <li><table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tbody>
                      <tr>
                        <td width="90" align="center"><img src="<?=$PARAMS['productPath'].$row['img_s']?>" alt=""/></td>
                        <td valign="top"><?=$row['brand_tc']?><br>
                          <strong><a href="b5_product_detail.php?plu=<?=$row['plu']?>" class="color_f90"><?=$row['name_tc']?></a></strong><br>
                          <span class="color_aaa"><?=$row['unit_tc']?></span></td>
                        <td width="14%" align="center">$ <?=number_format($row['price'],$PARAMS['decimals'])?></td>
                        <td width="14%" align="center">數量 <select name="quantity" class="quantity-select" id="quantity-select-<?=$row['plu']?>" onchange="changeCartQty('<?=$row['plu']?>')">
                          <?=genQtySelectOption($value)?>
                          </select></td>
                        <td width="14%" align="center">$ <?=number_format($row['price']*$value,$PARAMS['decimals'])?> <a href="javascript:void(0);" onclick="removeCart('<?=$row['plu']?>')"><strong>X</strong></a></td>
                        </tr>
                      </tbody>
                    </table></li>
                 <?php } } ?>
                </ul>
          	</div>

            <div id="payright">
            	<h2 class="ui_title">結帳小計</h2>
              <?php if(isset($_SESSION['cart']) && sizeof($_SESSION['cart'])>0){ ?>
            	<table width="100%" border="0" cellspacing="0" cellpadding="3">
           		  <tbody>
            	    <tr>
            	      <td>商品總額</td>
            	      <td align="right">$ <?=isset($_SESSION["cart"])?number_format(countCartTotal(),$PARAMS['decimals']):""?></td>
          	      </tr>
                  <?php if(isset($_SESSION['member']) && isset($_SESSION["cart"]) && isset($_SESSION['coupon'])){ $coupon_row=getCouponByCode($_SESSION['coupon']); ?>
                  <tr>
                    <td><?=$coupon_row['title_tc']?></td>
                    <td align="right">$ (<?=number_format(getCouponDiscount(),$PARAMS['decimals'])?>)</td>
                  </tr>
                  <?php } ?>
            	    <tr>
            	      <td><strong>訂單淨總額:(未計入運費)</strong></td>
            	      <td align="right">$ <?=isset($_SESSION["cart"])?number_format(countCartTotal()-getCouponDiscount(),$PARAMS['decimals']):""?></td>
          	      </tr>
       	    	  </tbody>
   	  	  	  </table>
              <?php }else{ ?>
                <p align="center">你的購物車中沒有商品</p>
              <?php } ?>
               <?php if(!isset($_SESSION['member'])){ ?>
            	<div id="unlogin">
                  <h2 class="color_f90">會員</h2>
                  <p>如果你已註册成為會員，請先登入然後結帳，以享用會員優惠！</p>
                  <form action="login_action.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
                  <?= CSRF::genHiddenCSRF('member_login-form'); ?>
                  <input type="hidden" name="module" value="b5_cart">
                  <p>電郵 : <input name="email" type="text" class="ui_inputbox200W" required></p>
                  <p>密碼 : <input name="password_hash" type="password" class="ui_inputbox200W" required> <a href="b5_forgotpwd.php">忘記密碼?</a></p>
                  <p align="center"><input type="submit" name="submit" value="會員登入付款" class="ui_btn_green" style="cursor:pointer;border:none"></p>
                  </form>
                  <hr />
                  <h2 class="color_f90">還未成為註冊用戶？</h2>
                  <p><a href="b5_reg.php" class="ui_btn_green">立即註冊帳戶</a></p>
                  <p>&nbsp;</p>
              </div>
              <?php }else{ ?>
              <form action="b5_cart_confirm.php" name="form1" id="form1" enctype="multipart/form-data" method="post">
                <?= CSRF::genHiddenCSRF('cart-form'); ?>
                <div id="logined">
                <div><h2 class="color_f90">使用優惠券（如有）</h2>
                <p><input name="coupon" type="text" class="ui_inputbox200W" id="coupon_code" placeholder="優惠卷編號"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="button" value="確定" class="ui_btn_green" style="border:none;cursor:pointer" onclick="setCoupon()"></p>
                <?php if(isset($_SESSION['coupon'])){ $coupon_row=getCouponByCode($_SESSION['coupon']); ?>
                  <table width="100%" cellpadding="2" cellspacing="2">
                  <tr><td colspan="2">使用中的優惠券 :</td></tr>
                  <tr>
                    <td><?=$coupon_row['code']?></td>
                    <td><?=$coupon_row['title_tc']?></td>
                    <td width="10%" align="center"><a href="javascript:void(0)" class="color_f90" onclick="removeCoupon()">移除</a></td>
                  </tr>
                  </table>
                <?php } ?>
                </div>
                <div>
                <h2 class="color_f90">送貨地址</h2>
                <p>
                  收件人姓名
                  :<br>
                  <input name="addressee" type="text" id="addressee" class="ui_inputbox200W" value="<?=$member_row['name_tc']?>" required></p>
                  <p>聯絡電話 :<br>
                  <input name="tel" type="text" id="tel" class="ui_inputbox200W" value="<?=$member_row['tel']?>" required></p>
                <hr />
                <p>
                  <label><input type="radio" name="area" value="HK" <?=$member_row['area']=="HK"?"checked":""?> required>香港島</label>
                  <label><input type="radio" name="area" value="KL" <?=$member_row['area']=="KL"?"checked":""?>>九龍</label>
                  <label><input type="radio" name="area" value="NT" <?=$member_row['area']=="NT"?"checked":""?>>新界</label>
                </p>
                <p>地區 :
                  <br>
                  <input name="district" type="text" id="district" class="ui_inputbox200W" value="<?=$member_row['district']?>" required>
                </p>
                <p>屋苑 / 街道 : <br>
                  <input name="street" type="text" id="street" class="ui_inputbox200W" value="<?=$member_row['street']?>" required>
                </p>
                <p>大廈名稱 : <br>
                  <input name="building" type="text" id="street" class="ui_inputbox200W" value="<?=$member_row['building']?>" required>
                </p>
                <p>
                  座數 / 樓層 / 單位 :
                  <br>
                  <input name="flat" type="text" id="flat" class="ui_inputbox200W" value="<?=$member_row['flat']?>" required>
                </p>
                <hr />
                <p>
                送貨日期 :<br>
                <input type="text" name="date_delivery" id="date_delivery" class="datepicker" required />
                </p>
                <hr />
                <?php if(isset($_SESSION['cart']) && sizeof($_SESSION['cart'])>0){ ?>
                <p align="center"><input name="submit" type="submit" value="確定付款" class="ui_btn_green" style="border:none;cursor:pointer"></p>
                <?php }else{ ?>
                <p align="center">請先選擇商品，然後付款</p>
                <?php } ?>
                </div>
              </div>
            </form>
            <?php } ?>
          </div>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>