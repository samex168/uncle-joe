<?php 
  require_once('../_common/conn_open.php');
  require_once('include/checklogin.php');
  require_once('include/function.php');
  require_once './Classes/PHPExcel.php';

  $objPHPExcel = new PHPExcel();

  $objPHPExcel->setActiveSheetIndex(0);
  //set field name
  $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Update Time');
  $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Member ID');
  $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Member Name(EN)');
  $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Member Name(TC)');
  $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Field Name');
  $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Old Value');
  $objPHPExcel->getActiveSheet()->setCellValue('G1', 'New Value');
  $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Update By');

  //set data
  $dateFrom = mysql_real_escape_string(substr($_POST['dateFrom'],0,10).' 00:00:00');
  $dateTo = mysql_real_escape_string(substr($_POST['dateTo'],0,10).' 23:59:59');
  $sql = "SELECT `h`.*, `m`.`name_en`,`m`.`name_tc` FROM `member_update_history` AS `h` LEFT JOIN `member` AS `m` ON `h`.`member_id`=`m`.`id` WHERE `h`.`update_time` BETWEEN '".$dateFrom."' AND '".$dateTo."' ORDER BY `h`.`update_time` DESC, `h`.`id` DESC";
  $memberSQL = mysql_query($sql);
 /* $fieldName = array('password_hash'=>'登入密碼','memberType'=>'會員類別','company'=>'公司名稱','title'=>'稱呼','tel'=>'聯絡電話','webDollar'=>'webDollar','status'=>'啟用','flat_add'=>'室/樓/座','building_add'=>'屋苑/大廈名稱','street_add'=>'街道名稱及街號','district_add'=>'區域'); */

  $i = 1;
  while ($row = mysql_fetch_array($memberSQL)){
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,htmlspecialchars_decode($row['update_time'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,htmlspecialchars_decode($row['member_id'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,htmlspecialchars_decode($row['name_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,htmlspecialchars_decode($row['name_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,htmlspecialchars_decode($row['update_field'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,htmlspecialchars_decode($row['old_value'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,htmlspecialchars_decode($row['new_value'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i,htmlspecialchars_decode($row['updateBy'],ENT_QUOTES)==1?"Admin":"Member");
  }

  // Redirect output to a client’s web browser (Excel5)
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Member_Update_History_export.xls"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');

?>

<?php require_once('../_common/conn_close.php'); ?>