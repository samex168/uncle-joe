<?php 
    require_once('../_common/conn_open.php');
    require_once('include/checklogin.php');
    require_once('include/function.php');
    require_once './Classes/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0);
    //set field name
  //  $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Member ID');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Name(EN)');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name(TC)');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Gender');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tel');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Email');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Password');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Birthday(Year)');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Birthday(Month)');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Accept Promotion');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Member Type');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Join Date');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Web Dollar');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Expire Date');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Status(1:Active,0:Inactive)');
    $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Area');
    $objPHPExcel->getActiveSheet()->setCellValue('P1', 'District');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Street/Estate');
    $objPHPExcel->getActiveSheet()->setCellValue('R1', 'Building');
    $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Flat');

    //set data
 /*   $memberSQL = mysql_query("SELECT `m`.*, `t`.`total` FROM `tbl_member` AS `m` LEFT JOIN (SELECT `memberId`, SUM(`totalAmt`+`deliveryCharge`-`useDollar`) AS `total` FROM `tbl_order` WHERE `status`='Order Confirmed' OR `status`='Completed' GROUP BY `memberId` ) AS `t` ON `m`.`id`=`t`.`memberId` ORDER BY `m`.`id`"); */
    $sql = "SELECT * FROM member ORDER BY id";
    $memberSQL = mysql_query($sql);

    $i = 1;
    while ($row = mysql_fetch_array($memberSQL)){
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,htmlspecialchars_decode($row['name_en'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,htmlspecialchars_decode($row['name_tc'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,htmlspecialchars_decode($row['gender'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,htmlspecialchars_decode($row['tel'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,htmlspecialchars_decode($row['email'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,htmlspecialchars_decode("",ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,htmlspecialchars_decode($row['birthYear'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i,htmlspecialchars_decode($row['birthMonth'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i,htmlspecialchars_decode($row['accept_promotion'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i,htmlspecialchars_decode($row['memberType'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$i,htmlspecialchars_decode($row['date_join'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i,htmlspecialchars_decode($row['webDollar'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('M'.$i,htmlspecialchars_decode($row['date_dollarExpire'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i,htmlspecialchars_decode($row['status'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i,htmlspecialchars_decode($row['area'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('P'.$i,htmlspecialchars_decode($row['district'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i,htmlspecialchars_decode($row['street'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i,htmlspecialchars_decode($row['building'],ENT_QUOTES));
    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i,htmlspecialchars_decode($row['flat'],ENT_QUOTES));
    }



    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Member_export.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

?>
<?php require_once('../_common/conn_close.php'); ?>