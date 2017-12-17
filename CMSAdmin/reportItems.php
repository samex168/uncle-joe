<?php require_once('../_common/conn_open.php'); ?>
<?php require_once('../_common/common.php'); ?>
<?php require_once('include/checklogin.php'); ?>
<?php require_once('../_common/data_functions.php'); ?>
<?php 
/*
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Product_export.xls");
echo "\xEF\xBB\xBF"; // add BOM to the file. fixed chinese display problem
*/
ini_set("display_errors",1);
if(isset($_POST['action']) && $_POST['action']=="export"){
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
    require_once './Classes/PHPExcel.php';
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Add some data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PLU');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Product Name(Eng)');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Product Name(中文)');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Unit Price');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Quantity');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Total Amount');

    $order_details_sql = mysql_query("SELECT plu,SUM(qty) FROM `order_product` AS `op` WHERE EXISTS (SELECT * FROM order_details AS `od` WHERE orderStatus=3 AND date_order BETWEEN '$date_from' AND '$date_to' AND `op`.orderNo=`od`.orderNo) GROUP BY plu");
    $i = 1;
    while ($order_row = mysql_fetch_array($order_details_sql)){
        $i++;
        $product_row = getProductByPLU($order_row['plu']);

        $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$i,htmlspecialchars_decode($order_row['plu'],ENT_QUOTES),PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,htmlspecialchars_decode($product_row['name_en'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,htmlspecialchars_decode($product_row['name_tc'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,htmlspecialchars_decode($product_row['price'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,htmlspecialchars_decode($order_row['SUM(qty)'],ENT_QUOTES));
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,htmlspecialchars_decode($product_row['price']*$order_row['SUM(qty)'],ENT_QUOTES));
    }
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="ItemSales_report.xls"');
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
        <span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;">Item Sales Report Export</span>
        <form name="form1" action="reportItems.php" method="post" enctype="multipart/form-data">
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