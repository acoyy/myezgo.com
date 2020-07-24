<?php
	function vali_iif($testvalue,$truevalue,$falsevalue){
    if($testvalue == true){
      return $truevalue;
    }else{
      return $falsevalue;
    }
  }

	function vali_mustNoCache(){
	  header("Cache-Control: no-store, no-cache, must-revalidate");
	  header("Pragma: no-cache");
  }
	
	function vali_isLogin(){	
    global $myPrefix;
		if($_SESSION[$myPrefix."uid"] == ""){
      return false;      
    }else{
      return true;
    }
  }
  	
	function vali_getLoginID(){
    global $myPrefix;
	  return $_SESSION[$myPrefix."uid"];
  }
	
	function vali_addLogin($login_id){
    global $myPrefix;
	  $_SESSION[$myPrefix."uid"] = $login_id;
  }	
	
	function vali_removeLogin(){
    global $myPrefix;
	  $_SESSION[$myPrefix."uid"] = "";	  
  }	
	
	function vali_redirectcode($code, $codevalue){
	  vali_redirecturl("index.php?code=" . $code . "&codevalue=" . $codevalue . "");
  }
	
	function vali_redirectIndex(){
		if(!mem_get('pid')) {
			db_disconnect();
			echo '<script>location.href=\'home.php\';</script>';
			exit();
		}
  }	
	
	function vali_redirect($url){
	  //db_disconnect();
		echo '<script>';
		echo '	location.href=\''.$url.'\';';
		echo '</script>';
	  exit();
  }	
	
	function vali_redirecturl($url,$div='content'){
	  db_disconnect();
		$url = getURL($url);
	  //header("Location: " . $url);
		echo '<script>';
		echo 'if(window.name == \'bgWorker\' || window.name == \'bgSearchWorker\') {';
		echo '	parent.location.href= \''.$url.'\';';
		echo '} else {';
		echo '	location.href=\''.$url.'\';';
		echo '}';
		echo '</script>';
	  exit();
  }	
	
	function vali_redirectjscode($code,$codevalue){
	  echo '<script>location.href="index.php?code=' . $code . '&codevalue=' . $codevalue . '";</script>';
	  exit();
  }
	
	function vali_redirectnewwinurl($url){
	  echo '<script>window.open("' . $url . '","_blank");</script>';
  }	
	
	function vali_refresh(){
	  db_disconnect();
	  //header("Location: index.php");
	  echo '<script>location.href="index.php";</script>';
	  exit();
  }
  
  	function vali_chkthread(){
		global $id,$rows;
		$sql = "SELECT q_id, date_format(q_cdate, '%d-%m-%Y %l:%i %p') as q_date, date_format(q_cdate, '%d-%m-%Y') as q_date2 , m_uname, q_title, q_desc, q_status, q_attach1, q_attach2, q_attach3 FROM question q LEFT JOIN member m ON q.m_id=m.m_id WHERE q_id=$id ";
		db_select($sql);
		$rows = db_rowcount();
		if($rows==0){ vali_redirect("experts.php?file=poe"); }	
		
	}
	
	function vali_curl($url,$data){
		$cookie = tempnam ("/tmp", "CURLCOOKIE");
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_ENCODING, "" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$content = curl_exec( $ch );
		$response = curl_getinfo( $ch );
		curl_close ( $ch );
		return $content;
	}
?>
