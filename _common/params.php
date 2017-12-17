<?php
if(!isset($_SESSION)){
	session_name('UNCLOE-JOE_PHPSESSID');
	ini_set('session.cookie_httponly', true);
	session_start();
}
date_default_timezone_set('Asia/Hong_Kong');
//error_reporting(E_ALL ^ E_DEPRECATED);

if(!isset($PARAMS)){
	$PARAMS = array();
}
$PARAMS['HOST'] = "http://demo.freecomm.com";
$PARAMS['ROOT_PATH'] = "/unclejoe/php/";
$PARAMS['ADMIN_PATH'] = $PARAMS['ROOT_PATH'].'/CMSAdmin';
$PARAMS['basePath'] = str_replace("_common", "", realpath(dirname(__FILE__))); // with tail slash
$PARAMS['paypal'] = "seller_1296180842_biz@gmail.com";
$PARAMS['smtp_host'] = "smtp.bbmail.com.hk";

$PARAMS['pluginsPath'] = 'plugins/';
$PARAMS['productPath'] = 'images/product/';
$PARAMS['bannerPath'] = 'images/banner/';

//===== Validation Message =====
$PARAMS['NOT_VALID_EMAIL'] = "請輸入一個有效的電郵地址";
$PARAMS['EMAIL_EXIST'] = "你所輸入電郵地址已經註冊";
$PARAMS['NOT_REG_EMAIL'] = "你所輸入電郵地址並未註冊";
$PARAMS['NOT_EQUAL_EMAIL'] = "你所輸入電郵地址並不一致，請重新輸入";
$PARAMS['NOT_EQUAL_PASSWORD'] = "你所輸入密碼並不一致，請重新輸入";


//===== System Message =====
$PARAMS['ADD_TO_CART'] = "成功加到購物車";
$PARAMS['COUPON_ADDED'] = "己新增優惠卷";
$PARAMS['NOT_VALID_COUPON'] = "無效的優惠卷";
$PARAMS['COUPON_CLEAR'] = "已取消優惠卷";
$PARAMS['MEMBER_LOGOUT'] = "你已成功登出";

//===== Email Content =====
$PARAMS['email_sender'] = "info@freecom.com";
$PARAMS['email_subject']['resetpwd'] = "UNCLE JOE - 會員密碼重設";
$PARAMS['email_sent_msg'] = "郵件已寄出";

//===== Display suggested image size =====
$PARAMS['imageSize']['slideBanner'] = "1200px &times 460px";
$PARAMS['imageSize']['pageBanner'] = "1200px &times 220px";
$PARAMS['imageSize']['product_s'] = "170px &times 170px";
$PARAMS['imageSize']['product_m'] = "400px &times 400px";
$PARAMS['imageSize']['product_l'] = "800px &times 800px";
//===== crop imge size =====
$PARAMS['img_s']['width'] = 170;
$PARAMS['img_m']['width'] = 400;
$PARAMS['img_l']['width'] = 800;
$PARAMS['img_s']['height'] = 170;
$PARAMS['img_m']['height'] = 400;
$PARAMS['img_l']['height'] = 800;

$PARAMS['district']['HK'] = array(1,2,3,4);
$PARAMS['district']['KL'] = array(5,6,7,8,9);
$PARAMS['district']['NT'] = array(10,11,12,13,14,15,16,17,18);
$PARAMS['paymentStatus'] = array(1,2,3,4);
$PARAMS['orderStatus'] = array(1,2,3,4);

$PARAMS['pagingSize'] = 20;
$PARAMS['decimals'] = 1;

?>