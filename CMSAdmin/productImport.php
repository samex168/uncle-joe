<?php 
	require_once('../_common/conn_open.php');
 	require_once('include/checklogin.php');
 	require_once('include/function.php');

$msg =  "";
if (isset($_POST["action"]) && $_POST["action"] == "import"){
	if ($_FILES["batchFile"]["error"] > 0){
    		$msg =  "Return Code: " . $_FILES["batchFile"]["error"] . "<br />";
	}else{

		$batchFileName = $_FILES["batchFile"]["name"];
		$batchFileName = $_FILES["batchFile"]["tmp_name"];
     	//move_uploaded_file($_FILES["batchFile"]["tmp_name"], "batchImport/" . $_FILES["batchFile"]["name"]);
		/*
		require_once 'Excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('utf-8');
		$data->setUTFEncoder('mb');

		$data->read('batchImport/'.$batchFileName);
		*/
		function getPrice($price){
			if(substr(trim($price),0,1)=='$'){
				if(is_numeric($price)){
					return $price;
				}else{
					return substr($price,1);
				}
			}else{
				if(is_numeric($price)){
					return $price;
				}else{
					return $price;
				}
			}
		}
		require_once './Classes/PHPExcel/IOFactory.php';

		$inputFileType = PHPExcel_IOFactory::identify($batchFileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($batchFileName);
		$objPHPExcel->setActiveSheetIndex(0);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		error_reporting(E_ALL ^ E_NOTICE);
		$fail = 0;
		$failStr = "";
		$succ = 0;
		$idx = 0;

		if(sizeof($sheetData)>0){
			$isFirst = true;
			foreach($sheetData as $value){
				$i = 1;
				if ($isFirst) {
					$isFirst = false;
					continue;
				}
				foreach($value as $k=>$v){
					$var = "col".$i;
					$$var = htmlspecialchars(trim($v), ENT_QUOTES);
					$i++;
				}

				$plu = $col2;
				$name_en = $col3;
				$name_tc = $col4;
				$country_en  = $col5;
				$country_tc  = $col6;
				$brand_en = $col7;
				$brand_tc = $col8;
				$vendor = $col9;
				$des_en = $col10;
				$des_tc = $col11;
				$price = getPrice($col12);
				$unit_en = $col13;
				$unit_tc = $col14;
				$remark_en = $col15;
				$remark_tc = $col16;
				$webDollarBase = $col17;
				$webDollarMulti = $col18;
				$webDollarAmt = $col19;
				$date_wdValidFrom = $col20;
				$date_wdValidTo = $col21;
				$hit_product = $col22;
				$new_product = $col23;
				$img_s = $col24;
				$img_m = $col25;
				$img_l = $col26;
				$weightproduct = $col27;
				$cost = getPrice($col28);
				$status = $col29;

				if($plu!=''){
					$checkPlu = mysql_fetch_array(mysql_query("select count(*) from product where plu='$plu'")) or die(mysql_error());
					if ($checkPlu[0] == 0 ){
						$sql = "INSERT INTO product (`plu`,`name_en`,`name_tc`,`country_en`,`country_tc`,`brand_en`,`brand_tc`,`vendor`,`des_en`,`des_tc`,`price`,`unit_en`,`unit_tc`,`remark_en`,`remark_tc`,`webDollarBase`,`webDollarMulti`,`webDollarAmt`,`date_wdValidFrom`,`date_wdValidTo`,`hit_product`,`new_product`,`img_s`,`img_m`,`img_l`,`weightproduct`,`cost`,`status`)
						VALUES ('$plu','$name_en','$name_tc','$country_en','$country_tc','$brand_en','$brand_tc','$vendor','$des_en','$des_tc',".($price==''?'NULL':"'".$price."'").",'$unit_en','$unit_tc','$remark_en','$remark_tc','$webDollarBase','$webDollarMulti','$webDollarAmt',".($date_wdValidFrom==''?'NULL':"'".$date_wdValidFrom."'").",".($date_wdValidTo==''?'NULL':"'".$date_wdValidTo."'").",'$hit_product','$new_product','$img_s','$img_m','$img_l','$weightproduct','".doubleval($cost)."','$status')";
						//echo $sql;
						//echo '<br/><br/>';
						$rt =  mysql_query($sql) or die($sql. mysql_error().'<br />');
						if ($rt == false){
							$failStr = $failStr.$plu." ".$name_tc."<br>";
							$fail++;
						}else{
							$succ++;
						}
					}else{
						$failStr = $failStr.$plu." ".$name_tc."<br>";
						$fail++;
					}
				}
				$idx++;
			}
		}
		$msg =  "Import Completed";
	}
}

	require_once('include/_header.php');
?>
<div class="main clearfix">
<div class="col_cat">
    <div class="cat_menus">
        <?php require_once('include/_menu.php'); ?>
    </div>
</div>
<div class="col_content clearfix">
	<div class="col_main">
      <div class="content">
        <span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;">Product Batch Import</span>
        <form name="form1" action="productImport.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="import">
		<?php if ($msg !=""){ ?><div align="center" class="txt14_red"><?=$msg?></div><?php } ?>
		 <table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" class="bdtxt">
		  <tr>
			<td width="24%" bgcolor="#F3F2F4" >Product List (xls):</td>
			<td width="47%" align="center" bgcolor="#F3F2F4" ><input type="file" name="batchFile" size="40"></td>
			<td width="7%" align="left" bgcolor="#F3F2F4" ><input type="submit" name="submit" value="Import" class="bdtxt" ></td>
			<td width="22%" align="right" bgcolor="#F3F2F4" ><a href="./product_import_template.xls" target="_blank">Download Template</a></td>
		  </tr>
		 <?php if ($msg !="") { ?>
		  <tr>
			<td colspan="4" bgcolor="#F3F2F4" >
			 Result:<br>
			Success:
			<?=$succ?> <br>
			Fail: <?=$fail?> <br>
			<span class="msg"><?=$failStr?></span><br>		</td>
		   </tr>
		<?php } ?>
		</table>
		</form>
      </div>
    </div>
</div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>