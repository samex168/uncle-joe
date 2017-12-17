<?php 
	require_once('../_common/conn_open.php');
	require_once('include/checklogin.php');
 	require_once('include/function.php');

	$msg =  "";
	if (isset($_POST['action']) && $_POST["action"] == "import"){
		if ($_FILES["batchFile"]["error"] > 0){
	    		$msg =  "Return Code: " . $_FILES["batchFile"]["error"] . "<br />";
		}else{

			$batchFileName = $_FILES["batchFile"]["name"];
			//move_uploaded_file($_FILES["batchFile"]["tmp_name"], "batchImport/" . $_FILES["batchFile"]["name"]);
			$batchFileName = $_FILES["batchFile"]["tmp_name"];
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
					if($isFirst){
						$isFirst = false;
						continue;
					}
					foreach($value as $k=>$v){
						$var = "col".$i;
						$$var = mysql_real_escape_string(htmlspecialchars(trim($v), ENT_QUOTES));
						$i++;
					}
					//$mid = $col1;
					$name_en = $col1;
					$name_tc = $col2;
					$gender = $col3;
					$tel = $col4;
					$email = $col5;
					$password_hash = ($col6!=""?passwordEncode($col6):$col6);
					$birthYear = $col7;
					$birthMonth = $col8;
					$accept_promotion = $col9;
					$memberType = $col10;
					$date_join  = $col11;
					$webDollar = $col12;
					$date_dollarExpire = $col13;
					$status = $col14;
					$area = $col15;
					$district = $col16;
					$street = $col17;
					$building = $col18;
					$flat = $col19;
				//	$joinDate = PHPExcel_Style_NumberFormat::toFormattedString($col14, "YYYY-M-D");
				//	$dollarExpireDate = date('Y-m-d',strtotime("+1 year",strtotime($joinDate)));

					if($email !=''){
						$checkEmail = mysql_fetch_array(mysql_query("select count(*) from member where email='$email'")) or die(mysql_error());
						if ($checkEmail[0] == 0 ){

								$sql = "INSERT INTO member (`name_en`,`name_tc`,`gender`,`tel`,`email`,`password_hash`,`birthYear`,`birthMonth`,`accept_promotion`,`memberType`,`date_join`,`webDollar`,`date_dollarExpire`,`status`,`area`,`district`,`street`,`building`,`flat`)
								VALUES ('$name_en','$name_tc','$gender','$tel','$email','$password_hash','$birthYear','$birthMonth','$accept_promotion','$memberType','$date_join','$webDollar','$date_dollarExpire','$status','$area','$district','$street','$building','$flat')";
								//echo $sql;
								//echo '<br/><br/>';
								$rt =  mysql_query($sql) or die(mysql_error());
								if ($rt == false){
									$failStr = $failStr.$name_tc.", ".$name_en.", ".$email." (Fail to import)<br>";
									$fail++;
								}else{
									$succ++;
								}
						}else{
								$failStr = $failStr.$name_tc.", ".$name_en.", ".$email." (Email exist)<br>";
								$fail++;
						}
					}
				}
				$msg =  "Import Completed";
			}
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
          	<span class="c_txt13purple bdtxt" style="float:right;margin-bottom:20px;">Member Batch Import</span>
            <form name="form1" action="memberImport.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="import">
			<?php if ($msg !=""){ ?><div align="center" class="txt14_red"><?=$msg?></div><?php } ?>
			 <table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" class="bdtxt">
			  <tr>
				<td width="24%" bgcolor="#F3F2F4" >Member List (xls):</td>
				<td width="47%" align="center" bgcolor="#F3F2F4" ><input type="file" name="batchFile" size="40"></td>
				<td width="7%" align="left" bgcolor="#F3F2F4" ><input type="submit" name="submit" value="Import" class="bdtxt" ></td>
				<td width="22%" align="right" bgcolor="#F3F2F4" ><a href="./member_import_template.xls" target="_blank">Download Template</a></td>
			  </tr>
			 <?php if ($msg !="") { ?>
			  <tr>
				<td colspan="4" bgcolor="#F3F2F4" >
				 Result:<br>
				Success:
				<?=$succ?> <br>
				Fail: <?=$fail?> <br>
				<span class="msg"><?=$failStr?></span><br></td>
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