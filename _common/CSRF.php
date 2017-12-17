<?php
require_once("common.php");

class CSRF {
	public static function genToken($formName){
		$token = "";
		if(function_exists("hash_algos") && in_array("sha512",hash_algos())){
			$token = hash("sha512",mt_rand(0,mt_getrandmax()));
		}else{
			$token = ' ';
			for($i=0; $i<128; ++$i){
				$r = mt_rand(0,35);
				if($r<26){
					$c = chr(ord('a')+$r);
				}else{
					$c = chr(ord('0')+$r-26);
				}
				$token .= $c;
			}
		}
		$_SESSION['CSRF_'.$formName] = $token;
		return $token;
	}
	public static function verifyToken($formName, $token){
		$result = false;
		if(isset($_SESSION['CSRF_'.$formName])){
			if($_SESSION['CSRF_'.$formName] == $token && trim($_SESSION['CSRF_'.$formName])!=''){
				$result = true;
			}else{
				$result = false;
			}
		}else{
			return false;
		}
		unset($_SESSION['CSRF_'.$formName]);
		return $result;
	}
	public static function genHiddenCSRF($formName, $fieldName="UNCLE-JOE_CSRF_TOKEN"){
		echo '<input type="hidden" name="'.$fieldName.'" value="'.self::genToken($formName).'" />';
	}
}