<?php
	session_cache_limiter('');
	session_start();

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0");

	// $page = $_SERVER['PHP_SELF'];
	// $sec = "10";
	// header("Refresh: $sec; url=$page");

	// header("Cache-Control: no-cache, must-revalidate");


	if(isset($_SESSION['cid']))
	{
		$idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

		if (time()-$_SESSION['timestamp']>$idletime){

			session_unset();
			session_destroy();

			echo "<script> alert('You have been logged out due to inactivity'); </script>";
			echo "<script>
	                window.location.href='index.php';
	            </script>";
        }else{
	    	
	    	$_SESSION['timestamp']=time();
	    }
		include ("_header.php"); ?>
		<html>
		<div class="row">
			<div class="col-md-2">
				<!-- <button class="btn btn-primary" style="height: 20%; width: 100%;" type="button" onclick="goBack()"><img style="height: 100%; width: 12%;" src="assets/img/cms/return_button.png"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> -->
				<button class="btn btn-primary" style="height: 100%; width: 100%;" type="button" onclick="goBack()"><img style="width: 100%;" src="assets/img/cms/return_button.png"></button>
			</div>
			<div class="col-md-10">
			    <?php if($_GET['type'] == 'vehicle'){ ?>
			    
				    <img src="assets/img/car_state/<?php echo $_GET['image_name']; ?>">
				
				<?php } else if($_GET['type'] == 'customer'){ ?>
				
				    <img src="assets/img/customer/<?php echo $_GET['image_name']; ?>">
				
				<?php } ?>
			</div>
		</div>
		<script>
		    function goBack() {
		        window.history.back();
		    }
		</script>
		</html>

		<?php

	} ?>