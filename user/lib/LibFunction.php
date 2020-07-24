<?php
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$errMsg = '';
	
  function func_isNull($value,$str=0) {
		if ($value == "" || empty($value)) {
			return $str;
		} else {
			return $value;
		}
	}
	
	function func_isCheck($value,$str='N') {
		if ($value == "" || empty($value)) {
			return $str;
		} else {
			return $value;
		}
	}
	//===================================================
 	//===================================================
  function func_isMinLength($value,$length,$str,$c=1) {
		global $errMsg, $lang;
	  if ($value != "" && !empty($value)) {
			if (strlen($value) < $length) {
				if ($c==1) {
					func_setErrMsg("- Minimum " . $length . " Characters for " . $str . ".<br>");
				} else {
					func_setErrMsg($str . ".<br>");
				}
			}
		}
	}
	
  function func_isMaxLength($value,$length,$str,$c=1) {
		global $errMsg;
	  if ($value != "" && !empty($value)) {
			if (strlen($value) > $length) {
				if ($c==1) {
					func_setErrMsg("- Maximum " . $length . " Characters for " . $str . "!<br>");
				} else {
					func_setErrMsg($str."<br>");
				}
			}
		}
	}
	
  function func_isEmpty($v,$str,$c=1) {
		global $errMsg, $lang;
		if ($v == '') {
			if ($c==1) {
				func_setErrMsg("- Please provide " . $str.".<br>");
			} else {
				func_setErrMsg($str.".<br>");
			}
		}
	}
	
  function func_isEmail($v,$str,$c=1) {
		global $errMsg, $lang; 
	  if ($v != "" && !empty($v)) {
			if (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $v)) {
				if ($c==1) {
					func_setErrMsg("- Please provide "  . $str.".<br>");
				} else {
					func_setErrMsg($str."<br>");
				}
			}
		}
		// $c1 = strpos($v,"@");
		// $c2 = strpos($v,".");
		// if($c1 === FALSE || $c2 === FALSE) 
	}
	
  function func_isURL($v,$str) {
		global $errMsg, $lang; 
	  if ($v != "" && !empty($v)) {
			if (!preg_match("#^(http:\/\/|https:\/\/|www\.)(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?(\/)*$#i", $v)) {
				func_setErrMsg("- Invalid URL! Please enter the correct " . $str.".<br>");
			}
		}
	}
	
	function func_isAlphabet($v,$str,$c=1) {
		global $errMsg, $lang; 
		if (!ereg('[^A-Za-z]', $v)) {
			if ($c==1) {
				func_setErrMsg("- Please provide " . $str." containing alpha only!<br>");
			} else {
				func_setErrMsg($str."<br>");
			}
		}
	}
	
	function func_isAlphaNumeric($v,$str,$c=1) {
		global $errMsg, $lang; 
		if (!ereg('[^A-Za-z]', $v) || !ereg('[^0-9]', $v)) {
			if ($c==1) {
				func_setErrMsg("- Please provide " . $str." containing both alpha and numeric!<br>");
			} else {
				func_setErrMsg($str."<br>");
			}
		}
	}
	
	function func_isNum($value,$str,$c=1) {
		global $errMsg, $lang; 
	  if ($value != "" && !empty($value)) {
		  if (!(is_numeric($value))) {
	 			if ($c==1) {
					func_setErrMsg("- Please provide numeric value for " . $str . ".<br>");
				} else {
					func_setErrMsg($str."<br>");
				}
  		}
		}
	}
	
	function func_isTime($value,$str,$c=1) {
		global $errMsg, $lang; 
		if (!(mem_get($value."_h") > -1 && mem_get($value."_h") < 13 && mem_get($value."_m") > -1 && mem_get($value."_m") < 60)) {
			if ($c==1) {
				func_setErrMsg("- Invalid time! Please enter the correct " . $str . ".<br>");
			} else {
				func_setErrMsg($str."<br>");
			}
		}
	}
	
	function func_isDate($value,$str,$c=1) {
		global $errMsg, $lang, ${$value._d}, ${$value._m}, ${$value._y}; 
		if (${$value._m} != '' && ${$value._d} != '' && ${$value._y} != '') {
			if (!(checkdate(${$value._m},${$value._d},${$value._y}))) {
	 			if ($c==1) {
					func_setErrMsg("- Invalid date! Please enter the correct " . $str . ".<br>");
				} else {
					func_setErrMsg($str."<br>");
				}
			}
		} else {
			if ($c==1) {
				func_setErrMsg("- Invalid date! Please enter the correct " . $str . ".<br>");
			} else {
				func_setErrMsg($str."<br>");
			}
		}
	}
	
	function func_isDate2($value,$str,$c=1) {
		global $errMsg, $lang; 
		if (mem_get($value."_m") != '' && mem_get($value."_d") != '' && mem_get($value."_y") != '') {
			if (!(checkdate(mem_get($value."_m"),mem_get($value."_d"),mem_get($value."_y")))) {
	 			if ($c==1) {
					func_setErrMsg("- Invalid date! Please enter the correct " . $str . ".<br>");
				} else {
					func_setErrMsg($str."<br>");
				}
			}
		} else {
			if ($c==1) {
				func_setErrMsg("- Invalid date! Please enter the correct " . $str . ".<br>");
			} else {
				func_setErrMsg($str."<br>");
			}
		}
	}
	
	function func_isDateEmpty($value,$t) {
	  if ($t == 0) {
	    mem_set($value . "_y", func_isNull(mem_get($value . "_y"), Date("Y")));
  	  mem_set($value . "_m", func_isNull(mem_get($value . "_m"), Date("m")));
  	  mem_set($value . "_d", func_isNull(mem_get($value . "_d"), Date("d")));
  	} elseif ($t == 1) {
  	  mem_set($value . "_y", func_isNull(mem_get($value . "_y"), "1900"));
  	  mem_set($value . "_m", func_isNull(mem_get($value . "_m"), "1"));
  	  mem_set($value . "_d", func_isNull(mem_get($value . "_d"), "1"));
  	} elseif ($t == 2) {
  	  mem_set($value . "_y", func_isNull(mem_get($value . "_y"), "1900"));
  	  mem_set($value . "_m", func_isNull(mem_get($value . "_m"), "0"));
  	  mem_set($value . "_d", func_isNull(mem_get($value . "_d"), "0"));
		}
	}
	
	function getMonthName($n) {
		$timestamp = mktime(0, 0, 0, $n, 1, 2005);
		
		return date("F", $timestamp);
	}

	function func_datebox($value,$t,$rt=false) {
		global ${$value._d}, ${$value._m}, ${$value._y}, $lang;
	  if ($t == 0) {
	   $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = 1960;
	   $ye = Date("Y");
	  } elseif ($t == 1) {
     $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = 1900;
		 $ye = Date("Y");
    } elseif ($t == 2) {
     $d = 0;
	   $ms = 0;
	   $me = 12;
	   $ys = 1900;
		 $ye = 2020;
    } elseif ($t == 3) {
     $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = 1900;
		 $ye = 2020;
    } elseif ($t == 4) {
		$d = 1;
	   $ms = Date("m")-3;
	   $me = Date("m")+1;
	   $ys = $ye = Date("Y");
	  }
	  $str1 = '<select name="' . $value . '_d">';
		$str1 .= '<option value="">DD</option>';
	   for ($i=$d;$i<=31;$i++) {
	     $str1 .= "<option ";
	     if (${$value._d} == $i) {
        $str1 .= "selected ";
       }
       $str1 .= 'value="' . $i .  '">' . vali_iif($i==0,"-",$i) . '</option>';
	   }
	  $str1 .= "</select> ";
	  
	  $str2 = '<select name="' . $value . '_m">';
		$str2 .= '<option value="">MM</option>';
		for ($i=$ms;$i<=$me;$i++) {
			$str2 .= "<option ";
			if (${$value._m} == $i) {
				$str2 .= "selected ";
			}
			$str2 .= 'value="' . $i .  '">' . vali_iif($i==0,"-",vali_iif($t==3,getMonthName($i),$i)) . '</option>';
		}
	  $str2 .= "</select> ";
	  
	  $str3 = '<select name="' . $value . '_y">';
		$str3 .= '<option value="">YY</option>';
	   for ($i=$ys;$i<=$ye;$i++) {
	     $str3 .= "<option ";
	     if (${$value._y} == $i) {
        $str3 .= "selected ";
       }
       $str3 .= 'value="' . $i .  '">' . vali_iif($i==1900 && $t==2,"-",$i) . '</option>';
	   }
	  $str3 .= "</select>";
	  if ($rt) return $str1 . $str2 . $str3;
		else echo $str1 . $str2 . $str3;
	}
	
	function func_datebox2($value,$t) {
		global ${$value._d}, ${$value._m}, ${$value._y};
	  if ($t == 0) {
	   $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = 1970;
		 $ye = Date("Y");
	  } elseif ($t == 1) {
     $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = 1900;
		 $ye = Date("Y");
    } elseif ($t == 2) {
     $d = 0;
	   $ms = 0;
	   $me = 12;
	   $ys = 1900;
		 $ye = 2020;
    } elseif ($t == 3) {
     $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = 1900;
		 $ye = Date("Y");
    } elseif ($t == 4) {
     $d = 1;
	   $ms = 1;
	   $me = 12;
	   $ys = Date("Y");
	   $ye = Date("Y") + 1;
	  }elseif ($t == 5) {
     $d = 0;
	   $ms = 0;
	   $me = 12;
	    $ys = 1900;
		 $ye = Date("Y") - 4;
    }
	
		$str1 = '<select style="" name="' . $value . '_d" >';
		if ($t == 3) $str1 .= '<option value="">Day</option>';
		for ($i=$d;$i<=31;$i++) {
			$str1 .= "<option ";
			if (${$value._d} == $i) {
				$str1 .= "selected ";
			}
			$str1 .= 'value="' . $i .  '">' . vali_iif($i==0,"-",vali_iif($i<10,"0".$i,$i)) . '</option>';
		}
		$str1 .= "</select> ";
	  
	  $str2 = '<select style="" name="' . $value . '_m" >';
		if ($t == 3) $str2 .= '<option value="">Month</option>';
		for ($i=$ms;$i<=$me;$i++) {
			$str2 .= "<option ";
			if (${$value._m} == $i) {
				$str2 .= "selected ";
			}
			$str2 .= 'value="' . $i .  '">' . vali_iif($i==0,"-",vali_iif($t==3,getMonthName($i),vali_iif($i<10,"0".$i,$i))) . '</option>';
		}
	  $str2 .= "</select> ";
	  
	  $str3 = '<select style="" name="' . $value . '_y" >';
		if ($t == 3) $str3 .= '<option value="">Year</option>';
	   for ($i=$ys;$i<=$ye;$i++) {
	     $str3 .= "<option ";
	     if (${$value._y} == $i) {
        $str3 .= "selected ";
       }
       $str3 .= 'value="' . $i .  '">' . vali_iif(($i==1900 && $t==2)||($i==1900 && $t==5),"-",$i) . '</option>';
	   }
	  $str3 .= "</select>";
	  echo $str1 . $str2 . $str3;
	}
	
	function func_getDate($value) {
	  if (mem_get($value . "_d") == "00" && mem_get($value . "_m") == "00" && mem_get($value . "_y") == "1900") {
	   return "Unknown";
	  } else {
	   return mem_get($value . "_d") . "-" . mem_get($value . "_m") . "-" . mem_get($value . "_y");
	  }
	}
	
	function func_getdbDate($value) {
		global ${$value._d}, ${$value._m}, ${$value._y};
		return func_isNull(${$value._y}) . "-" . func_isNull(${$value._m}) . "-" . func_isNull(${$value._d});
	}
	
	function func_getdbDate2($value) {
		return func_isNull(mem_get($value . "_y")) . "-" . func_isNull(mem_get($value . "_m")) . "-" . func_isNull(mem_get($value . "_d"));
	}
	
	function func_getdbTime($value) {
		if (mem_get($value . "_l") == 'AM') {
			if (mem_get($value . "_h") == 12) {
				return "00:" . func_isNull(mem_get($value . "_m")) . ':00';
			} else {
				return func_isNull(mem_get($value . "_h")) . ":" . func_isNull(mem_get($value . "_m")) . ':00';
			}
		} else {
			if (mem_get($value . "_h") == 12) {
				return func_isNull(mem_get($value . "_h")) . ":" . func_isNull(mem_get($value . "_m")) . ':00';
			} else {
				return (func_isNull(mem_get($value . "_h"))+12) . ":" . func_isNull(mem_get($value . "_m")) . ':00';
			}
		}
		return func_isNull(mem_get($value . "_h")) . ":" . func_isNull(mem_get($value . "_m")) . func_isNull(mem_get($value . "_l"),'');
		// $dateTime = new DateTime(func_isNull(mem_get($value . "_h")) . ":" . func_isNull(mem_get($value . "_m")) . func_isNull(mem_get($value . "_l"),''));
		// return date_format($dateTime,'H:i:s');
	}
	
	//========================================================================================================================================
	//========================================================================================================================================]
	
	function func_clrDate($value) {
		mem_set($value.'_y','');
		mem_set($value.'_m','');
		mem_set($value.'_d','');
	}
	
	function func_clrTime($value) {
		mem_set($value.'_h','');
		mem_set($value.'_m','');
		mem_set($value.'_l','');
	}
	
	function func_isTimeEmpty($value,$t) {
	  if ($t == 0) {
	    mem_set($value . "_h", func_isNull(mem_get($value . "_h"), Date("h")));
			// if (Date("i") >= 0 && Date("i") < 5) {
				// $i = '00';
			// } elseif(Date("i") >= 5 && Date("i") < 10) {
				// $i = '05';
			// } elseif(Date("i") >= 10 && Date("i") < 15) {
				// $i = '10';
			// } elseif(Date("i") >= 15 && Date("i") < 20) {
				// $i = '15';
			// } elseif(Date("i") >= 20 && Date("i") < 25) {
				// $i = '20';
			// } elseif(Date("i") >= 25 && Date("i") < 30) {
				// $i = '25';
			// } elseif(Date("i") >= 30 && Date("i") < 35) {
				// $i = '30';
			// } elseif(Date("i") >= 35 && Date("i") < 40) {
				// $i = '35';
			// } elseif(Date("i") >= 40 && Date("i") < 45) {
				// $i = '40';
			// } elseif(Date("i") >= 45 && Date("i") < 50) {
				// $i = '45';
			// } elseif(Date("i") >= 50 && Date("i") < 55) {
				// $i = '50';
			// } elseif(Date("i") >= 55) {
				// $i = '55';
			// }
  	  mem_set($value . "_m", func_isNull(mem_get($value . "_m"), Date("i")));
  	  mem_set($value . "_l", func_isNull(mem_get($value . "_l"), strtoupper(Date("a"))));
  	} elseif ($t == 1) {
  	  mem_set($value . "_h", func_isNull(mem_get($value . "_y"), "1"));
  	  mem_set($value . "_m", func_isNull(mem_get($value . "_m"), "0"));
  	  mem_set($value . "_l", func_isNull(mem_get($value . "_d"), "AM"));
		}                  
	}
	
	function func_addLine($v=1) {
		return '<div style="clear:both;font-size:'.(2*$v).'px;">&nbsp;</div>';
	}

	function func_timebox($value){
		$x = 1;
		$y = 0;
		$z = "AM";
		$str1 = '<select name="'. $value . '_h">';
		for ($i=$x;$i<=12;$i++) {
		    $str1 .= "<option ";
		    if (mem_get($value . "_h") == $i) {
				$str1 .= "selected ";
			}
			$str1 .= 'value="' . $i .  '">' . $i . '</option>';
		}
		$str1 .= "</select> ";
		
		$str2 = '<select name="' . $value . '_m">';
			for ($i=$y;$i<=59;$i++) {
				$str2 .= "<option ";
				if (mem_get($value . "_m") == vali_iif($i<10,"0".$i,$i)) {
					$str2 .= "selected ";
				}
				$str2 .= 'value="'. vali_iif($i<10,"0".$i,$i) .'">' . vali_iif($i<10,"0".$i,$i) . '</option>';
			}
		$str2 .= "</select> ";	

		$str3 = '<select name="' . $value . '_l">';
		
		$str3 .='<option ';
		if (mem_get($value . "_l") == "AM") {
				$str3 .= "selected ";
		}
		$str3 .= 'value="AM">AM</option>';
		$str3 .='<option ';
		if (mem_get($value . "_l") == "PM") {
				$str3 .= "selected ";
		}
		$str3 .= 'value="PM">PM</option>';
		$str3 .="<selected>";
		
		echo $str1 . $str2 . $str3;
	}
	
	function timeDiff($firstTime,$lastTime){
		// convert to unix timestamps
		$firstTime=strtotime($firstTime);
		$lastTime=strtotime($lastTime);
		
		// perform subtraction to get the difference (in seconds) between times
		$timeDiff=$lastTime-$firstTime;
		
		// return the difference
		return $timeDiff;

	}
	
	function func_timeToString($date){
		if ($date >= 2592000) {
			$date = (int)($date/60/60/24/30);
			$date = $date . ($date > 1 ? ' months' : ' month');
		} elseif ($date >= 86400) {
			$t = (int)($date/60/60/24);
			if ($t >= 7 && $t <= 21) {
				$date = (int)($date/60/60/24/7);
				$date = $date . ($date > 1 ? ' weeks' : ' week');
			} else {
				$date = (int)($date/60/60/24);
				$date = $date . ($date > 1 ? ' days' : ' day');
			}
		} elseif ($date >= 3600) {
			$date = (int)($date/60/60);
			$date = $date . ($date > 1 ? ' hours' : ' hour');
		} elseif ($date >= 60) {
			$date = (int)($date/60);
			$date = $date . ($date > 1 ? ' minutes' : ' minute');
		} else {
			$date = $date . ($date > 1 ? ' seconds' : ' second');
		}
		
		return $date;
	}
	
	function day_left($date){
		if($date<'00:00:00'){			
			return "";
		}else{
			$time_left = explode(":",$date);
			$day = ($time_left[0]/24); 
			$hour = (int)fmod($time_left[0],24); 
			$minute = (int)$time_left[1]; 
			$sec =  $time_left[2];
			
			if($day<1 && $hour>0){
				return $hour." hr ".$minute." min ";
			}else if($day>0){
				return (int)$day." days ".$hour." hr";
			}else if($day<1 && $hour==0 && $minute>0){
				return $minute." min ";
			}else if($minute==0){
				return "1 min ";
			}
		}
	}
	
	//===================================================
 	//===================================================
  function func_setErrMsg($value) {
    $_SESSION["err_msg"] .= $value;
  	func_setValid("N");
	}
	
	function func_getErrMsg() {
		$msg = $_SESSION["err_msg"];
		func_clrErrMsg();
    return $msg;
	}
	
	function func_setMsg($value) {
		$_SESSION["err_msg"] .= $value;
		func_setValid("Y");
	}
	function func_clrErrMsg() {
		unset($_SESSION["err_msg"]);
	}
	
	//===================================================
 	//===================================================
	function func_setValid($value) {
    if ($value == "Y") func_clrErrMsg();
    $_SESSION["chk_valid"] = $value;
	}
	
	function func_isValid() {
    if ($_SESSION["chk_valid"] == "Y") { 
      return true;
    } else {
      return false;
    }
	}	

	//===================================================
 	//===================================================
	function func_setReqForm($pre='') {
    foreach($_POST as $key => $value) {
     // echo $key." = ".$value."<br>";
      //mem_set($key,$value);
			$_SESSION[$pre."func_count"] .= "|" . $key;
    }
	}
	
	function func_setSelectForm($pre='') {
    for ($i=0;$i<db_colcount();$i++) {
      //echo $pre . db_getName(i) . " - " . db_get(0,i) . "<br>";
      //mem_set($pre . db_getName($i), db_get(0,$i));
		  $_SESSION["func_count"] .= "|" . $pre . db_getName($i);
    }
	}
	
	//===================================
	function func_setReqVar($pre='') {
    foreach($_GET as $key => $value) {
			$tmp = $pre . $key;
			global $$tmp;
			$$tmp = $value;
			 //echo $tmp .' => '. nohtml($value).'<br>';
    }
		
    foreach($_POST as $key => $value) {
			$tmp = $pre . $key;
			global $$tmp;
			$$tmp = $value;
			 //echo $tmp .' => '. nohtml($value).'<br>';
    }
	}
	
	function func_setSelectVar($row=0,$dic=0,$pre='') {
		for ($col=0;$col<db_colcount($dic);$col++) {
			$tmp = $pre . db_getName($col,$dic);
			global $$tmp;
			$$tmp = db_get($row,$col,$dic);
		}
	}
	//===================================

	function func_addSpace($v) {
	 for ($i=0;$i<$v;$i++) $output .= "&nbsp;";
	 return $output;
	}
	
	function func_randStr($len,$format='') {
		switch($format) {
			case 'CHAR':
				$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; break;
			case 'NUMBER':
				$chars='0123456789'; break;
			default :
				$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; break;
		}
		$password="";
		while(strlen($password)<$len){
			$max = strlen($chars)-1;
			$password.=substr($chars,(mt_rand(0,$max)),1);
		}
		return $password;
	}

	function func_runnoStr($runno,$len){
		for($i=0;$i<$len;$i++){
			if(strlen($runno) < $len){	
				$runno = "0" . $runno;
			}
		}
		return $runno;
	}
	
	function getRndFontSize() {
		$fontSize[] = "10";
		$fontSize[] = "12";
		$fontSize[] = "14";
		$fontSize[] = "16";
		$fontSize[] = "18";
		$fontSize[] = "20";
		$fontSize[] = "22";
		$rndNum = rand(0,7);
		return $fontSize[$rndNum].'px';
	}
	
	function deep_in_array($value, $array, $case_insensitive = false) {
		foreach($array as $item) {
			if(is_array($item)) $ret = deep_in_array($value, $item, $case_insensitive);
			else $ret = ($case_insensitive) ? strtolower($item)==strtolower($value) : $item==$value;
			if($ret) return $ret;
		}
		return false;
	}

	function cutstr($value,$lenght,$end='...'){
		if (strlen($value) >= $lenght){       
			$limited.= substr($value,0,$lenght);
			$limited.= $end;  
		}else{
			$limited = $value;
		}
		return $limited;
	} 

	//==============================================================================================================================================
	function lang($l, $replace='') {
		global $lang;
		return parse($lang[$l],$replace);
  }

	function parse() {
    $args = func_get_args();
		$lang = array_shift($args);
    if (is_array($args[0])) $args = $args[0];
		return vsprintf(str_replace('{?}', '%s', $lang), $args);	
	}
	
	//==============================================================================================================================================

	function authSendEmail($to, $subject, $message) {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		if (MAIL_SECURE) $mail->SMTPSecure = MAIL_SECURE;                 // sets the prefix to the servier
		if (MAIL_PORT) $mail->Port       = MAIL_PORT;                   // set the SMTP port for the GMAIL server
		$mail->Host     	= MAIL_SERVER;
		$mail->SMTPAuth 	= true;
		$mail->Username 	= MAIL_USERNAME;
		$mail->Password 	= MAIL_PASSWORD;
		$mail->IsHTML(true);
		$mail->From     	= MAIL_FROM;
		$mail->FromName 	= MAIL_FROM_NAME;
		$mail->AddAddress($to); 
		$mail->AddReplyTo(MAIL_REPLY, MAIL_REPLY_NAME);
		$mail->Subject  	= $subject;
										
		$mail->Body =  $message;
		//$mail->Send();
		if(!$mail->Send()) {
		  echo "Mailer Error: ".$to . $mail->ErrorInfo;
		}
		$mail->ClearAllRecipients();
		$mail->SmtpClose();
	}
	

	
	//===================================================================
	function deleteFromArray(&$array, $deleteIt, $useOldKeys = FALSE){
		$tmpArray = array();
		$found = FALSE;
		foreach($array as $key => $value){
			if($value !== $deleteIt){
				if(FALSE === $useOldKeys){
					$tmpArray[] = $value;
				}else{
					$tmpArray[$key] = $value;
				}
			}else{
				$found = TRUE;
			}
		}
	  
		$array = $tmpArray;
	  
		return $found;
	}
	
	//=========================	
	//BEGIN Export Excel
	//=========================
	function xlsBOF() {
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
		return;
	}

	function xlsEOF() {
		echo pack("ss", 0x0A, 0x00);
		return;
	}

	function xlsWriteNumber($Row, $Col, $Value) {
		echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
		echo pack("d", $Value);
		return;
	}

	function xlsWriteLabel($Row, $Col, $Value ) {
		$L = strlen($Value);
		echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
		echo $Value;
	return;
	} 
	
	//=========================	
	// END Export Excel
	//=========================	
	
	function random($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}
	
	function getIP(){
		$onlineip = "";
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		return $onlineip;
	}
	
	function add_forum_member($username,$password,$email){
				$onlineip = getIP();

				preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
				$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
				unset($onlineipmatches);

				$salt = substr(uniqid(rand()), -6);
				$password = md5(md5($password).$salt);
				$timestamp = time();
				db_update("INSERT INTO x_members SET username='$username', password='$password', email='$email', regip='".$onlineip."', regdate='$timestamp', salt='$salt'");
				db_select("SELECT LAST_INSERT_ID();");
				db_update("INSERT INTO x_memberfields SET uid='$uid'");
				$uid = db_get(0,0);
				
				$password = md5(random(10));

				$sql ="INSERT INTO z_members (uid, username, password, secques, adminid, groupid, regip, regdate, lastvisit, lastactivity, posts, credits, email, showemail, timeoffset, pmsound, invisible, newsletter)
					VALUES ('$uid', '$username', '$password', '', '0', '10', '$onlineip', '$timestamp', '$timestamp', '$timestamp', '0', 0, '$email', '0', '9999', '1', '0', '1')";
				db_update($sql);
				db_select("SELECT LAST_INSERT_ID();");
				$uid = db_get(0,0);
				db_update("REPLACE INTO z_memberfields (uid) VALUES ('$uid')");
	}
	
	//===================================

	
	function func_encrypt($string, $key) {
	  $result = '';
	  for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	  }

	  return base64_encode($result);
	}

	//==============================================================================================================================================
	
		//////////////////////////////////////////////////////////////////////
	//PARA: Date Should In YYYY-MM-DD Format
	//RESULT FORMAT:
	// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
	// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
	// '%m Month %d Day'                                            =>  3 Month 14 Day
	// '%d Day %h Hours'                                            =>  14 Day 11 Hours
	// '%d Day'                                                        =>  14 Days
	// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
	// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
	// '%h Hours                                                    =>  11 Hours
	// '%a Days                                                        =>  468 Days
	//////////////////////////////////////////////////////////////////////	
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);
		
		$interval = date_diff($datetime1, $datetime2);
		
		return $interval->format($differenceFormat);
    
	}
?>