<?php

class MailMerge {

	public $debugMode = false;
	public $content = "";
	public $result = "";
	public $search = array();
	public $replace = array();

	function debug($value=''){
		if($this->debugMode){
			$btr=debug_backtrace();
			$line=$btr[0]['line'];
			$file=basename($btr[0]['file']);
			print"<pre>$file:$line</pre>\n";
			if(is_array($value)){
				print"<pre>";
				print_r($value);
				print"</pre>\n";
			}elseif(is_object($value)){
				$value.dump();
			}else{
				print("<p>&gt;${value}&lt;</p>");
			}
			exit();
		}
	}
	function loadContent($path){
		if($path!='' && file_exists($path) && is_file($path)){
			$this->content = file_get_contents($path);
			if($this->content===false){
				$this->content = "";
				$this->debug("Cannot read the file!");
				return false;
			}else{
				return true;
			}
		}else{
			$this->debug("Cannot find the file!");
			return false;
		}
	}
	function merge(){
		if(is_array($this->search) && is_array($this->replace) && (sizeof($this->search)==sizeof($this->replace))){
			$this->result = str_replace($this->search,$this->replace,$this->content);
			return $this->result;
		}else{
			$this->debug("Invalid parameters!");
			return false;
		}
	}
	function reset(){
		$this->content="";
		$this->result = "";
		unset($this->search);
		unset($this->replace);
		$this->search = array();
		$this->replace = array();
	}
	function push($search,$replace){
		array_push($this->search, $search);
		array_push($this->replace, $replace);
	}
}
