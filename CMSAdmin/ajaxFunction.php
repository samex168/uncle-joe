<?php require_once('../_common/conn_open.php'); ?>
<?php require_once('include/checklogin.php'); ?>
<?php require_once('../_common/data_functions.php'); ?>
<?php
$gettype = str_replace("'", "", $_REQUEST["gettype"]);

switch ($gettype) {
	case 'plu':
		$id = intval($_REQUEST["id"]);
		$plu = mysql_real_escape_string(str_replace("'", "", $_GET["code"]));

		if ($id == "") {
			$check = mysql_num_rows(mysql_query("select id from product where plu='$plu'"));
			if($check > 0){
				$result = mysql_fetch_array(mysql_query("select name_tc from product where plu='$plu'"));
				echo $result[0];
			}
		}else{
			$check = mysql_num_rows(mysql_query("select id from product where plu='$plu' and id <> $id"));
			if ($check > 0){
				echo "PLU already exist";
			}
		}
		break;
	case 'checkCouponCode':
		$code = mysql_real_escape_string($_POST["code"]);
		$check = mysql_num_rows(mysql_query("SELECT id FROM coupon where code='$code'"));
		if($check > 0){
			echo "1";
		}else{
			echo "0";
		}
		break;
	case 'removeImg':
		$id = intval($_POST['id']);
		$tbl = $_POST["tbl"];
		$deltype = $_POST["type"];
		$folder = $_POST['folder'];
		$checkfile = mysql_fetch_row(mysql_query("select ".$deltype." from ".$tbl." where id=$id"));
		$delname = $checkfile[0];
		if (file_exists("../".$folder.$delname)&&$delname!=""&&$delname!="n/a") {
			unlink ("../".$folder.$delname);
		}
		mysql_query("update ".$tbl." set ".$deltype." = null where id=$id") or die(mysql_error());
		echo "success";
		break;
	case 'getCat2':
		$cat2List = array();
		$cat1 = intval($_GET['cat1']);
		$result = mysql_query("SELECT id,title_tc FROM cat2 WHERE cat1=$cat1");
		if($result!=null){
			while($row = mysql_fetch_array($result)){
				$cat2List[] = array("id"=>$row['id'], "title"=>$row['title_tc']);
			}
		}
		echo json_encode($cat2List);
		break;
	case 'getCat3':
		$cat2List = array();
		$cat1 = intval($_GET['cat1']);
		$cat2 = intval($_GET['cat2']);
		$result = mysql_query("SELECT id,title_tc FROM cat3 WHERE cat1=$cat1 AND cat2=$cat2");
		if($result!=null){
			while($row = mysql_fetch_array($result)){
				$cat2List[] = array("id"=>$row['id'], "title"=>$row['title_tc']);
			}
		}
		echo json_encode($cat2List);
		break;
	case 'removeCat':
		$id = intval($_GET['id']);
		mysql_query("DELETE FROM cat_product where id=$id") or die(mysql_error());
		echo $id;
		break;
	case 'saveCatSeq':
		$id = intval($_GET['id']);
		$seq = intval($_GET['seq']);
		mysql_query("UPDATE cat_product SET seq=$seq where id=$id") or die(mysql_error());
		echo $seq;
		break;
	case 'getProduct':
		$productList = array();
		$cat1 = intval($_GET['cat1']);
		$cat2 = intval($_GET['cat2']);
		$cat3 = intval($_GET['cat3']);
		$result = mysql_query("SELECT * FROM cat_product AS `cp` LEFT JOIN product AS `p` ON `cp`.plu=`p`.plu WHERE cat1=$cat1 AND cat2=$cat2 AND cat3=$cat3");
		if($result!=null){
			while($row = mysql_fetch_array($result)){
				$productList[] = array("plu"=>$row['plu'], "name"=>$row['name_tc']);
			}
		}
		echo json_encode($productList);
		break;
	case 'removeSlide':
		$id = intval($_POST['id']);
		$tbl = $_POST['tbl'];
		$folder = $_POST['folder'];
		$checkfile = mysql_fetch_row(mysql_query("select img_en from ".$tbl." where id=$id"));
		$delname = $checkfile[0];
		if (file_exists("../".$folder.$delname)&&$delname!=""&&$delname!="n/a") {
			unlink ("../".$folder.$delname);
		}
		$checkfile = mysql_fetch_row(mysql_query("select img_tc from ".$tbl." where id=$id"));
		$delname = $checkfile[0];
		if (file_exists("../".$folder.$delname)&&$delname!=""&&$delname!="n/a") {
			unlink ("../".$folder.$delname);
		}
		mysql_query("DELETE FROM $tbl where id=$id") or die(mysql_error());
		echo "success";
		break;
	case 'getSystemVars':
		$name = $_POST['name'];
		$type = $_POST['type'];
		$result = mysql_fetch_row(mysql_query("SELECT value FROM system_vars WHERE type=$type AND name=$name"));
		echo $result[0];
		break;
	case 'addOrderProduct':
		$orderNo = $_POST['orderNo'];
		$plu = $_POST['plu'];
		$qty = intval($_POST['qty']);
		$success = mysql_query("INSERT INTO order_product (orderNo,plu,qty) VALUES ($orderNo,$plu,$qty)");
		$result = mysql_fetch_row(mysql_query("SELECT SUM(price*qty) FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu=`p`.plu WHERE `op`.orderNo='$orderNo'"));
		$cartTotal = $result[0];
		$success = mysql_query("UPDATE order_details SET cartTotal=$cartTotal where orderNo='$orderNo'");
		$area = mysql_fetch_row(mysql_query("SELECT area FROM order_details WHERE orderNo='$orderNo'"));
		if($cartTotal > getSystemVars($area[0],'no_delivery_charge')){
			$success = mysql_query("UPDATE order_details SET deliveryCharge=0 where orderNo='$orderNo'");
		}
		echo $success;
		break;
	case 'updateOrderProduct':
		$id = intval($_POST['id']);
		$orderNo = $_POST['orderNo'];
		$plu = $_POST['plu'];
		$qty = intval($_POST['qty']);
		$success = mysql_query("UPDATE order_product SET qty=$qty where id=$id");
		$result = mysql_fetch_row(mysql_query("SELECT SUM(price*qty) FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu=`p`.plu WHERE `op`.orderNo='$orderNo'"));
		$cartTotal = $result[0];
		$success = mysql_query("UPDATE order_details SET cartTotal=$cartTotal where orderNo='$orderNo'");
		$area = mysql_fetch_row(mysql_query("SELECT area FROM order_details WHERE orderNo='$orderNo'"));
		if($cartTotal > getSystemVars($area[0],'no_delivery_charge')){
			$success = mysql_query("UPDATE order_details SET deliveryCharge=0 where orderNo='$orderNo'");
		}
		echo $success;
		break;
	case 'deleteOrderProduct':
		$id = intval($_POST['id']);
		$result = mysql_fetch_array(mysql_query("SELECT orderNo, plu FROM order_product WHERE id='$id'"));
		$orderNo = $result['orderNo'];
		$plu = $result['plu'];
		$success = mysql_query("DELETE FROM order_product where id=$id");
		$result = mysql_fetch_row(mysql_query("SELECT SUM(price*qty) FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu=`p`.plu WHERE `op`.orderNo='$orderNo'"));
		$cartTotal = $result[0];
		$success = mysql_query("UPDATE order_details SET cartTotal=$cartTotal where orderNo='$orderNo'");
		$area = mysql_fetch_row(mysql_query("SELECT area FROM order_details WHERE orderNo='$orderNo'"));
		if($cartTotal < getSystemVars($area[0],'no_delivery_charge')){
			$success = mysql_query("UPDATE order_details SET deliveryCharge=".getSystemVars($area[0],'delivery_charge')." where orderNo='$orderNo'");
		}
		echo $success;
		break;
	default:
		# code...
		break;
}

?>
<?php require_once('../_common/conn_close.php'); ?>