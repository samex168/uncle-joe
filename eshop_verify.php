<? require_once('_common/conn_open.php'); ?>
<? require_once('_common/common.php'); ?>
<? require_once('_common/data_functions.php'); ?>
<?php
ini_set("display_errors", true);

$debug = 'true';
$sandbox = 'true';// Enter value as true for sandbox,  anything else will be regular
function anti_injection($sql) {
    foreach ($sql as &$value) {
        if (!is_array($value)) {
            $value = mysql_real_escape_string(stripslashes(trim($value))); //get all data into shape for db insert without sql injection attacks
        }
    }
    unset($value);
    return $sql;
}

// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
//$req = 'cmd=' . urlencode('_notify-validate');
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}
/*foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}*/

if($sandbox == 'true'){
	$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
	$url = 'https://www.paypal.com/cgi-bin/webscr';
}
//$ch = curl_init();
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HEADER , false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
/*
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER , 0);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);*/
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

/*$curl_result = @curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);*/
$cert = "./cacert.pem";
curl_setopt($ch, CURLOPT_CAINFO, $cert);
$curl_result = curl_exec($ch);
$curl_err = curl_error($ch);

$file = fopen("eshop_paypal.log","a+");
fwrite($file, $curl_result."\n\n");
fwrite($file, "abc\n\n");
fwrite($file, $curl_err."\n\n");
fclose($file);

$tokens = explode("\r\n\r\n", trim($curl_result));
$curl_result = trim(end($tokens));

// assign posted variables to local variables
$_POST = anti_injection($_POST);

$num_cart_items = $_POST['num_cart_items'];
$invoice = intval($_POST['invoice']);
$ref = $_POST['invoice'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = mysql_real_escape_string($_POST['txn_id']);
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

$post_result = '';
foreach ($_POST as $key => $value) {
	$post_result .= "$key=$value&";
}

$paymentStatus = getValueFromTableByCon('paymentStatus','order_details','orderNo',$ref);

//===== payment_status : 1=unpaid, 2=received, 3=fail, 4=void =====
if (strcmp($curl_result, "VERIFIED")==0) {
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your PayPal email
	// check that payment_amount/payment_currency are correct
	$total = countOrderTotal($ref);
	if(strcmp($payment_status, "Completed")==0 && $payment_amount==$total){
		$sql ="UPDATE `order_details` SET `paymentStatus` ='2', `paymentRemark`='$post_result' WHERE `orderNo` = '$ref'";
		mysql_query($sql) or die(mysql_error());

		$sql = "INSERT INTO order_change_log (orderNo,updateField,oldValue,newValue,updateBy) VALUES ('$ref','paymentStatus','$paymentStatus',2,1)";
  		mysql_query($sql) or die(mysql_error());
	}else{
		$sql ="UPDATE `order_details` SET paymentStatus ='3',`paymentRemark`='$post_result' WHERE `orderNo` = '$ref'";
		mysql_query($sql) or die(mysql_error());

		$sql = "INSERT INTO order_change_log (orderNo,updateField,oldValue,newValue,updateBy) VALUES ('$ref','paymentStatus','$paymentStatus',3,1)";
  		mysql_query($sql) or die(mysql_error());
	}
}else if (strcmp($curl_result, "INVALID")==0) {
	$sql ="UPDATE `order_details` SET paymentStatus ='3',`paymentRemark`='$post_result' WHERE `orderNo` = '$ref'";
	mysql_query($sql) or die(mysql_error());

	$sql = "INSERT INTO order_change_log (orderNo,updateField,oldValue,newValue,updateBy) VALUES ('$ref','paymentStatus','$paymentStatus',3,1)";
  	mysql_query($sql) or die(mysql_error());
}else{
	$sql ="UPDATE `order_details` SET paymentStatus ='1',`paymentRemark`='$post_result' WHERE `orderNo` = '$ref'";
	mysql_query($sql) or die(mysql_error());

	$sql = "INSERT INTO order_change_log (orderNo,updateField,oldValue,newValue,updateBy) VALUES ('$ref','paymentStatus','$paymentStatus',1,1)";
  	mysql_query($sql) or die(mysql_error());
}
/*$file = fopen("eshop_paypal.log","a+");
fwrite($file, $curl_result. " - ".json_encode($_POST)."\n");
fclose($file); */
?>
<? require_once('_common/conn_close.php'); ?>