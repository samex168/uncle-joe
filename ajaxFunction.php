<?php require_once('_common/conn_open.php'); ?>
<?php require_once('_common/data_functions.php'); ?>
<?php require_once('_common/common.php'); ?>
<?php
$gettype = str_replace("'", "", $_REQUEST["gettype"]);

switch ($gettype) {
	case 'addToCart':
		$plu = mysql_real_escape_string($_POST['plu']);
		$qty = mysql_real_escape_string($_POST['qty']);
		$_SESSION["cart"][$plu] = $qty;
		echo $PARAMS['ADD_TO_CART'];
		break;
	case 'changeCartQty':
		$plu = mysql_real_escape_string($_POST['plu']);
		$qty = $_POST['qty'];
		if(isset($_SESSION['cart'][$plu]))
			$_SESSION['cart'][$plu] = $qty;
		echo $qty;
		break;
	case 'removeCart':
		$plu = mysql_real_escape_string($_POST['plu']);
		unset($_SESSION["cart"][$plu]);
		echo $plu;
		break;
	case 'setCoupon':
		$code = mysql_real_escape_string($_POST['code']);
		if($code=="CLEAR"){
			unset($_SESSION['coupon']);
			echo $PARAMS['COUPON_CLEAR'];
		}else{
			$check = mysql_num_rows(mysql_query("SELECT id FROM coupon WHERE code='$code' AND status=1 AND date_start<='$today' AND date_end>='$today'"));
			if($check > 0){
				$_SESSION['coupon'] = $code;
				echo $PARAMS['COUPON_ADDED'];
			}else{
				echo $PARAMS['NOT_VALID_COUPON'];
			}
		}
		break;
	case 'checkEmailExist':
		$email = mysql_real_escape_string($_POST['email']);
		$check = mysql_num_rows(mysql_query("SELECT email FROM member where email='$email'"));
		if($check > 0){
			echo $PARAMS['EMAIL_EXIST'];
		}else{
			echo "0";
		}
		break;
	case 'memberLogout':
		unset($_SESSION["member"]);
		echo $PARAMS["MEMBER_LOGOUT"];
		break;
	default:
		# code...
		break;
}

?>
<?php require_once('_common/conn_close.php'); ?>