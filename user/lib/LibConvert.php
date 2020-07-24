<?php
	function conv_padding_left($value, $padding, $length) {
		If ($padding == "") $padding = " ";
		while (strlen($value) < $length) {
			$value = $padding . $value;
		}
		return $value;
	}

	function conv_is_null($value, $replace_value){
		if(empty($value)){
				return $replace_value;
		}else{
				return $value;
		}
	}

	function conv_nostroke($value){
		return str_replace("|","",$value);
	}

	function conv_text_to_dbtext($text){
		return str_replace("'", "''",strtoupper(trim($text)));
	}

	function conv_text_to_dbtext2($text){
		return str_replace(">","]",str_replace("<","[",str_replace("'", "''",trim($text))));
	}
	
	function conv_text_to_dbtext3($text){
		return str_replace("'", "''",trim($text));
	}

	function conv2db($text,$isHTML=false){
		if ($isHTML) {
			$text = str_replace("\r\n",'',$text);
			
			$text = str_replace("\\\\","\\",$text);
			$text = str_replace("\\'","'",$text);
			$text = str_replace('\\"','"',$text);
			
			$text = str_replace("\\","\\\\",$text);
			$text = str_replace("'","\\'",$text);
			$text = str_replace('"','\\"',$text);
			
		} else  {
			$text = str_replace("\\","\\\\",$text);
			$text = str_replace("'","\\'",$text);
			$text = str_replace('"','\\"',$text);
			$text = nohtml($text);
		}
		return $text;
	}

	function conv($text){
		// return stripslashes($text);
		return str_replace('\\"','"',str_replace("\\'","'",str_replace("\\\\","\\",$text)));
	}

	function rmv($text){
		// return stripslashes($text);
		return str_replace('"','',str_replace("'","",str_replace("\\","",$text)));
	}

	function conv2quote($text){
		return str_replace("[/quote]","</blockquote></div>",str_replace("[quote]","<div class='quote'><h5>Quote:</h5><blockquote>",$text));
	}
	
	function nohtml($text){
		
		return htmlspecialchars(conv($text));
	}
	
	function html2text($html) {
		$tags = array (
							0 => '~<h[123][^>]+>~si',
							1 => '~<h[456][^>]+>~si',
							2 => '~<table[^>]+>~si',
							3 => '~<tr[^>]+>~si',
							4 => '~<li[^>]+>~si',
							5 => '~<br[^>]+>~si',
							6 => '~<p[^>]+>~si',
							7 => '~<div[^>]+>~si',
						);
		$html = preg_replace($tags,"\n",$html);
		$html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);
		$html = preg_replace('~<[^>]+>~s','',$html);
		// reducing spaces
		$html = preg_replace('~ +~s',' ',$html);
		$html = preg_replace('~^\s+~m','',$html);
		$html = preg_replace('~\s+$~m','',$html);
		// reducing newlines
		$html = preg_replace('~\n+~s',"\n",$html);
		return $html;
	}
	
	function conv_datetodbdate($value, $str=''){
		$str=explode("/", $value);
		return $str[2]. "-" .$str[1]. "-" .$str[0];
	}
	
	function conv_datetodbdate2($value, $str=''){
		$str=explode("-", $value);
		$str=str_replace(" "," ", $str);
		return $str[0]. "/" .$str[1]. "/" .$str[2];
	}
	
	function conv_datetodbdate3($value, $str=''){
		$str=explode("-", $value);
		$str=str_replace(" "," ", $str);
		return $str[2]. "/" .$str[1]. "/" .$str[0];
	}
?>