<?php

	function db_connect($db, $hostname,$username,$password,$int=0){
		global $con;
		//print $conectionstr;
		$con[$int] = mysql_connect($hostname,$username,$password) or die ("Can't connect to Server = ".mysql_error());
		mysql_select_db($db,$con[$int]); 		
	}
	
	function db_select($sql,$int=0){
	  global $dicValue,$fieldnames,$rs;
		$dicValue[$int] = array();
		$rs[$int] = mysql_query($sql);
		if(!$rs[$int]) return 0;
		$fieldnames[$int] = "";
		$num_field = mysql_num_fields($rs[$int]);
		for($i=0; $i < $num_field; $i++){
		  $fieldnames[$int] = $fieldnames[$int]  . "|" . str_replace("|","",mysql_field_name($rs[$int], $i));
    }
    
		if(strlen($fieldnames[$int]) > 0){
			$fieldnames[$int] = substr($fieldnames[$int],1,strlen($fieldnames[$int]) - 1);
		}
	
		$i = 0;
		
		while($row=mysql_fetch_row($rs[$int])){
			$str = "";
			for($j=0; $j < mysql_num_fields($rs[$int]); $j++){
				$dicValue[$int][$i][$j] = $row[$j];
        // $str = $str . "|" . str_replace("|","",$row[$j]);
      }
      
			if(strlen($str) > 0){
				$str = substr($str,1,strlen($str) - 1);
		  }
		  
	    // $dicValue[$int][$i] = $str;
	    $i = $i + 1;
		}
		mysql_free_result($rs[$int]);
		return $dicValue[$int];
		// return count($dicValue[$int]);
	}
	
	function db_get($row,$col,$int=0){
	  global $dicValue;
		return $dicValue[$int][$row][$col];
		// $str = $dicValue[$int][$row];
		// $v = explode("|",$str);
		// if ($col >= count($v)){
			// return "";
		// }else{
			// return $v[$col];
		// }
	}
	
	function db_rowcount($int=0){
	  global $dicValue;
		return count($dicValue[$int]);
	}
	
	function db_colcount($int=0){		
	  global $fieldnames;
		$v = explode("|",$fieldnames[$int]);
		return count($v);
	}
	
	function db_getName($col,$int=0){		
	  global $fieldnames;
		$v = explode("|",$fieldnames[$int]);
		if($col >= count($v)){
			return "";
		}else{
			return $v[$col];
		}
	}
	
	function db_update($sql){
		mysql_unbuffered_query($sql);
	}
	
	function db_disconnect($int=0){
	  global $con;
	  mysql_close($con[$int]);
  }
	
?>
