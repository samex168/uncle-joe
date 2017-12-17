<?php
require_once('params.php');
ini_set("display_errors", false);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$today = date('Y-m-d');

function consoleLog($str){
	echo '<script>console.log("'.$str.'");</script>';
}
function alert($str){
	echo '<script>alert("'.$str.'");</script>';
}
function redirect($str){
	echo '<script>window.location="'.$str.'";</script>';
}
function historyBack($go='-1'){
	echo '<script>window.history.go('.$go.');</script>';
}
// function alias
function htmlencode($str){
	return htmlspecialchars($str, ENT_QUOTES);
}
function htmldecode($str){
	if(!function_exists('htmlspecialchars_decode')){
		return strtr($str, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
	}else{
		return htmlspecialchars_decode($str, ENT_QUOTES);
	}
}
function htmlEncodeArray(&$arrayList){
	foreach ($arrayList as $key => $value) {
		if(is_array($value)){
			$arrayList[$key] = htmlEncodeArray($value);
		}else{
			$arrayList[$key] = htmlencode($value);
		}
	}
	return $arrayList;
}
function filterStr($str){
	$str = str_replace("'", "", $str);
	return $str;
}
function passwordEncode($pwd){
	return md5(filterStr($pwd));
}
if(!function_exists('checkName')){
	function checkName($table, $dataField, $id){
		$chkName = mysql_fetch_array(mysql_query("SELECT `".$dataField."` FROM ".$table." WHERE `id`='".$id."'"));
		return $chkName[0];
	}
}
/*function genPaging($totalPage, $page, $htmlPath, $other='', $lang='_tc'){
	$message = [
		'prev' => [
			'_tc' => '上一頁',
			'_en' => 'Prev'
		],
		'next' => [
			'_tc' => '下一頁',
			'_en' => 'Next'
		],
		'totalPage' => [
			'_tc' => '共 %d 頁',
			'_en' => 'Total %d pages'
		],
		'jump' => [
			'_tc' => '到第',
			'_en' => 'Jump to'
		],
		'page' => [
			'_tc' => '頁',
			'_en' => 'Page'
		],
		'go' => [
			'_tc' => '確定',
			'_en' => 'Go'
		],
	];

	$str = '';
	$str .= '<script type="text/javascript">
			    function jumpPage(){
			        var page = parseInt($("#product_paging #page").val());
			        window.location = "'.$htmlPath.'?page="+page+"'.$other.'";
			    }
			</script>';
	$str .='<div id="product_paging">
		<ul>';
	if($page > 1){
		$str .='<li><input class="button2" type="button" value="< '.$message['prev'][$lang].'" onclick="window.location=\''.$htmlPath.'?page='.($page-1).$other.'\'" /></li>';
	}else{
		$str .='<li><input type="button" class="button2" value="< '.$message['prev'][$lang].'" /></li>';
	}
	if($page<6 || $totalPage<=10){
		for($i=1; $i<=10 && $i<=$totalPage; $i++){
			if($i!=$page){
				$str .='<li><div class="paging_none"><a href="'.$htmlPath.'?page='.$i.$other.'">'.$i.'</a></div></li>';
			}else{
				$str .='<li><div class="paging_orange">'.$i.'</div></li>';
			}
		}
	}else{
		if($page >= $totalPage-5){
			for($i=$totalPage-9; $i<=$totalPage; $i++){
				if($i!=$page){
					$str .='<li><div class="paging_none"><a href="'.$htmlPath.'?page='.$i.$other.'">'.$i.'</a></div></li>';
				}else{
					$str .='<li><div class="paging_orange">'.$i.'</div></li>';
				}
			}
		}else{
			for($i=$page-4; $i<=$page+5 && $i<=$totalPage; $i++){
				if($i!=$page){
					$str .='<li><div class="paging_none"><a href="'.$htmlPath.'?page='.$i.$other.'">'.$i.'</a></div></li>';
				}else{
					$str .='<li><div class="paging_orange">'.$i.'</div></li>';
				}
			}
		}
	}
	if($page < $totalPage){
		$str .='<li><input class="button2" type="button" value="'.$message['next'][$lang].' >" onclick="window.location=\''.$htmlPath.'?page='.($page+1).$other.'\'" /></li>';
	}else{
		$str .='<li><input class="button2" type="button" value="'.$message['next'][$lang].' >" /></li>';
	}
	$str .='<li><div id="paging_none" class="margin15"> '.sprintf($message['totalPage'][$lang],$totalPage).'</div></li>';
	$str .='<li><div id="paging_none" class="margin15">'.$message['jump'][$lang].'</div></li>';
	$str .='<li><input class="text_field01 jump-page-text" type="text" name="page" id="page" value="1"/></li>';
	$str .='<li><div id="paging_none">'.$message['page'][$lang].'</div></li>';
	$str .='<li><div class="margin15"><input class="button3" type="button" value="'.$message['go'][$lang].'" onclick="jumpPage()" / ></div></li>';
	$str .='</ul>
	</div>';
	echo $str;
}*/
function checkMemberLogin($lang='_tc'){
	if(!isset($_SESSION['member']) || empty($_SESSION['member'])){
		if($lang == '_tc'){
			redirect("b5_login.php");
		}else{
			redirect("en_login.php");
		}
		exit();
	}
}
function applicationLog($log){
	$fp = fopen('application.log', 'a+');
	fwrite($fp, $log."\r\n");
	fclose($fp);
}
function showProductImage($path){
	if(trim($path) != '' && file_exists($path) && !is_dir($path)){
		return $path;
	}else{
		return 'images/product_default.jpg';
	}
}

function genBirthYearSelectOption($str=null){
	$result = "";
	for($i=1980; $i<2001; $i++){
		echo '<option '.($i==$str?"selected":"").' value="'.$i.'">'.$i.'</option>';
	}
	return $result;
}
function genBirthMonthSelectOption($str=null){
	$result = "";
	for($i=1; $i<13; $i++){
		$result .= '<option '.($i==$str?"selected":"").' value="'.$i.'">'.$i.'</option>';
	}
	return $result;
}
function genQtySelectOption($str=null){
	$result = "";
	for($i=1; $i<100; $i++){
		$result .= '<option '.($i==$str?"selected":"").' value="'.$i.'">'.$i.'</option>';
	}
	return $result;
}
function checkProductNameLen($str){
	$result = "";
	if(mb_strlen($str, "utf-8")>16){
		$result = mb_substr($str, 0, 16, "utf-8")."...";
	}else{
		$result = $str;
	}
	return $result;
}
function genRandomString($length){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getContentStatus($status){
	switch ($status) {
		case 0:
			return 'Hidden';
			break;
		case 1:
			return 'Show';
			break;
		default:
			return 'NA';
			break;
	}
}

function getAreaName($str){
	switch($str){
		case "HK":
			return "香港島";
		case "KL":
			return "九龍";
		case "NT":
			return "新界";
	}
}					
							
function getDistrictName($str){
	switch($str){
		case 1:
			return "中西區";
		case 2:
			return "灣仔區";
		case 3:
			return "東區";
		case 4:
			return "南區";
		case 5:
			return "油尖旺區";
		case 6:
			return "深水埗區";
		case 7:
			return "九龍城區";
		case 8:
			return "黃大仙區";
		case 9:
			return "觀塘區";
		case 10:
			return "葵青區";
		case 11:
			return "荃灣區";
		case 12:
			return "屯門區";
		case 13:
			return "元朗區";
		case 14:
			return "北區";
		case 15:
			return "大埔區";
		case 16:
			return "沙田區";
		case 17:
			return "西貢區";
		case 18:
			return "離島區";
	}
}

function getPaymentMethod($status){
	switch ($status) {
		case '1':
			return "Paypal";
		case '2':
			return "Credit Card";
		case '3':
			return "Bank Transfer";
		case '4':
			return "Cash";
		default:
			return "Unknown";
	}
}
function getPaymentStatus($status){
	switch ($status) {
		case '1':
			return "等待中";
		case '2':
			return "已收到";
		case '3':
			return "失敗";
		case '4':
			return "取消";
		default:
			return "Unknown";
	}
}

function getOrderStatus($status){
	switch ($status) {
		case '1':
			return "新訂單";
		case '2':
			return "確認";
		case '3':
			return "完成";
		case '4':
			return "取消";
		default:
			return "Unknown";
	}
}

function getUpdateByName($val){
	switch ($val) {
		case '1':
			return "Customer";
		case '2':
			return "Admin";
		default:
			return "Unknown";
	}
}

?>