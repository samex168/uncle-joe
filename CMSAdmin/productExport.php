<?php require_once('../_common/conn_open.php'); ?>
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

require_once './Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Add some data
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Plu');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Product Name(Eng)');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Product Name(中文)');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Country of Origin(Eng)');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Country of Origin(中文)');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Brand(Eng)');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Brand(中文)');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Vendor');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Description(Eng)');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Description(中文)');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Price');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Unit(Eng)');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Unit(中文)');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Remarks(Eng)');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Remarks(中文)');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Web Dollar Claim');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Web Dollar (By Multiplier) >= 1');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Web Dollar (By Specific Amount)');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Web Dollar Valid From(yyyy-mm-dd)');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Web Dollar Valid To(yyyy-mm-dd)');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Hit Product');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'new Product');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'Small Image Upload (File Name only)');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'Medium Image Upload (File Name only)');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Large Image Upload (File Name only)');
$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'Weight Product');
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'Cost');
$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'Active/Inactive');

$memberSQL = mysql_query("select * from product order by id");
$i = 1;
while ($row = mysql_fetch_array($memberSQL)){
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,htmlspecialchars_decode($row['id'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$i,htmlspecialchars_decode($row['plu'],ENT_QUOTES), PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,htmlspecialchars_decode($row['name_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,htmlspecialchars_decode($row['name_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,htmlspecialchars_decode($row['country_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,htmlspecialchars_decode($row['country_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,htmlspecialchars_decode($row['brand_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i,htmlspecialchars_decode($row['brand_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i,htmlspecialchars_decode($row['vendor'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i,htmlspecialchars_decode($row['des_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$i,htmlspecialchars_decode($row['des_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i,htmlspecialchars_decode($row['price'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('M'.$i,htmlspecialchars_decode($row['unit_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i,htmlspecialchars_decode($row['unit_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i,htmlspecialchars_decode($row['remark_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('P'.$i,htmlspecialchars_decode($row['remark_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i,htmlspecialchars_decode($row['webDollarBase'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i,htmlspecialchars_decode($row['webDollarMulti'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i,htmlspecialchars_decode($row['webDollarAmt'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i,htmlspecialchars_decode($row['date_wdValidFrom'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('U'.$i,htmlspecialchars_decode($row['date_wdValidTo'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('V'.$i,htmlspecialchars_decode($row['hit_product'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('W'.$i,htmlspecialchars_decode($row['new_product'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('X'.$i,htmlspecialchars_decode($row['img_s'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i,htmlspecialchars_decode($row['img_m'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i,htmlspecialchars_decode($row['img_l'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i,htmlspecialchars_decode($row['weightproduct'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i,htmlspecialchars_decode($row['cost'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i,htmlspecialchars_decode($row['status'],ENT_QUOTES));
}
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Product_export.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
<?php require_once('../_common/conn_close.php'); ?>