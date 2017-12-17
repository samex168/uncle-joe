<?php require_once('../_common/conn_open.php'); ?>
<?php require_once('../_common/common.php'); ?>
<?php require_once('include/checklogin.php'); ?>
<?php require_once('include/function.php'); ?>
<?php 
/*
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Product_export.xls");
echo "\xEF\xBB\xBF"; // add BOM to the file. fixed chinese display problem
*/
if(isset($_POST['action']) && $_POST['action']=="export"){
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
    require_once './Classes/PHPExcel.php';
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Add some data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Order No');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Order Date');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Member ID');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Addressee');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tel');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Product Details');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Cart Total');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Coupon');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Discount');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Delivery Charge');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Total Amount');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Payment Method');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Delivery Date');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Address');

    $order_details_sql = mysql_query("SELECT * FROM order_details WHERE orderStatus=3 AND date_order BETWEEN '$date_from' AND '$date_to' ORDER BY date_order DESC, orderNo DESC");
    $i = 1;
    while ($order_row = mysql_fetch_array($order_details_sql)){
        $i++;
        $product_details = "";
        $product_sql = mysql_query("SELECT * FROM order_product AS `op` LEFT JOIN product AS `p` ON `op`.plu=`p`.plu WHERE orderNo='".$order_row['orderNo']."'");
        while($product_row = mysql_fetch_array($product_sql)){
            $product_details .= $product_row['plu']."($".$product_row['price']."*".$product_row['qty'].") ";
        }
        $discount = $order_row['discount']==""?1:$order_row['discount'];
        $total = $order_row['cartTotal']*$discount+$order_row['deliveryCharge'];
        $address = $order_row['flat']." ".$order_row['building']." ".$order_row['street']." ".$order_row['district']." ".$order_row['area'];

        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i,htmlspecialchars_decode($order_row['orderNo'],ENT_QUOTES),PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,htmlspecialchars_decode($order_row['date_order'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,htmlspecialchars_decode($order_row['memberId'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,htmlspecialchars_decode($order_row['addressee'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,htmlspecialchars_decode($order_row['tel'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,htmlspecialchars_decode($product_details,ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,htmlspecialchars_decode($order_row['cartTotal'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$i,htmlspecialchars_decode($order_row['coupon'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i,htmlspecialchars_decode($order_row['discount'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$i,htmlspecialchars_decode($order_row['deliveryCharge'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i,htmlspecialchars_decode($total,ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$i,htmlspecialchars_decode(getPaymentMethod($order_row['paymentMethod']),ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$i,htmlspecialchars_decode($order_row['date_delivery'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$i,htmlspecialchars_decode($address,ENT_QUOTES));
    }
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="GeneralSales_report.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}

require_once('include/_header.php');
?>
<script type="text/javascript">
    $(function() {
         $(".datepicker").datepicker({
         dateFormat: 'yy-mm-dd'
         });
    });
</script>
<div class="main clearfix">
<div class="col_cat">
    <div class="cat_menus">
        <?php require_once('include/_menu.php'); ?>
    </div>
</div>
<div class="col_content clearfix">
    <div class="col_main">
      <div class="content">
        <span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;">General Sales Report Export</span>
        <form name="form1" action="reportGeneral.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="export">
         <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" class="bdtxt">
          <tr>
            <td>Order Date Period :</td>
            <td><input type="text" name="date_from" class="datepicker" required> To <input type="text" name="date_to" class="datepicker" required></td>
          </tr>
          <tr>
            <td><input type="submit" name="submit" value="Export"></td>
          </tr>
        </table>
        </form>
      </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>