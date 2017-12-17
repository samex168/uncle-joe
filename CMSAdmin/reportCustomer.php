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

    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Member ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name(Eng)');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name(中文)');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Email');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Member Type');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Order No');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Total Amount');

    $member_details_sql = mysql_query("SELECT * FROM `member` AS `m` WHERE EXISTS (SELECT * FROM order_details AS `od` WHERE orderStatus=3 AND date_order BETWEEN '$date_from' AND '$date_to' AND `m`.id=`od`.memberId)");
    $i = 1;
    while ($member_row = mysql_fetch_array($member_details_sql)){
        $i++;
        $total = 0;
        $orderList = "";
        $mid = $member_row['id'];
        $order_sql = mysql_query("SELECT * FROM order_details WHERE memberId=$mid AND orderStatus=3 AND date_order BETWEEN '$date_from' AND '$date_to'");
        while ($order_row=mysql_fetch_array($order_sql)) {
            $orderList .= $order_row['orderNo']." ";
            if($order_row['discount']!="")
                $discount = $order_row['cartTotal']*(1-$order_row['discount']);
            else
                $discount = 0;
            $total += $order_row['cartTotal']+$order_row['deliveryCharge']-$discount;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,htmlspecialchars_decode($member_row['id'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,htmlspecialchars_decode($member_row['name_en'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,htmlspecialchars_decode($member_row['name_tc'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,htmlspecialchars_decode($member_row['email'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,htmlspecialchars_decode($member_row['memberType'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,htmlspecialchars_decode($orderList,ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,htmlspecialchars_decode($total,ENT_QUOTES));
    }
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="CustomerSummary_report.xls"');
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
        <span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;">Customer Summary Export</span>
        <form name="form1" action="reportCustomer.php" method="post" enctype="multipart/form-data">
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