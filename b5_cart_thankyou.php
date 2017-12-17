<?php
    require_once('_common/common.php');
    require_once('_common/CSRF.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

  /*  if(sizeof($_SESSION["order_detail_form"])<=0 || sizeof($_SESSION["cart"])<=0 || !isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN']) || !CSRF::verifyToken('cart_confirm-form', $_POST['UNCLE-JOE_CSRF_TOKEN'])){
        redirect("b5_cart.php");
        exit();
    }
    $_SESSION['order_detail_form']['orderNo'] = genOrderNo();
    $_SESSION['order_detail_form']['orderStatus'] = 1;

    $query = mysql_query("SELECT * FROM order_details");
    $numberfields = mysql_num_fields($query);
    $lastfield = $numberfields-1;
    $sqlfieldname = "";
    $sqlfieldvalue = "";
    for ($i=0; $i<$numberfields ; $i++ ) {
       $fieldname = mysql_field_name($query, $i);
       if(isset($_SESSION["order_detail_form"][$fieldname])){
            $fieldvalue = htmlspecialchars($_SESSION["order_detail_form"][$fieldname], ENT_QUOTES);
            if($i == $lastfield){
               $sqlfieldname = $sqlfieldname."`".$fieldname."`";
               $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."'";
            }elseif($fieldname =="id"){
                //do noting
            }elseif(substr($fieldname,0,4) == "date"){
                if($fieldvalue==""){
                    $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                    $sqlfieldvalue= $sqlfieldvalue."null,";
                }else{
                    $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                    $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
                }
            }else{
                $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
            }
        }
    }
    $sql = "INSERT INTO order_details (".$sqlfieldname.") VALUES (".$sqlfieldvalue.")";
    mysql_query($sql) or die(mysql_error());
    $id = mysql_insert_id();

    $orderNo = $_SESSION["order_detail_form"]["orderNo"];
    foreach ($_SESSION["cart"] as $key => $value) {
        $sql = "INSERT INTO order_product (orderNo,plu,qty) VALUES ('".$orderNo."','".$key."','".$value."')";
        mysql_query($sql) or die(mysql_error());
    }

    unset($_SESSION["order_detail_form"]);
    unset($_SESSION["cart"]);
    unset($_SESSION["coupon"]); */
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
        <p id="path">主頁 &gt; 購物車 &gt; 付款完成</p>
        <div id="continer">
        	<h1 class="ui_nav2_subtitle">購物車 - 付款完成</h1>
            <p>&nbsp;</p>
            <p align="center">付款完成, 感謝閣下的惠顧。</p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>