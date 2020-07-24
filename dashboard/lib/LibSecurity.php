<?php
	$f = explode('/',$_SERVER['PHP_SELF']);
	$file = end($f);
	if($file != 'index.php'){
		if($_SESSION["cid"] == ""){
			echo "<script>";
			echo "alert('Your session may have expired or you are not log in yet.Please login to continue!');";
			echo "top.location.href = 'index.php'";
			echo "</script>";
			exit();
		}
	}
?>
