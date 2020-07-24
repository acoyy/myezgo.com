<?php
session_start();
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
?>

	<!DOCTYPE html>
	<html lang="en">

	<?php include('_header.php'); 
	require("lib/phpmailer/class.phpmailer.php"); 

	$vehicle_id = $_GET['vehicle_id'];
	$booking_id = $_GET['booking_id'];

	$pickup_date = date('m/d/Y', strtotime($_GET['extend_from_date']));
	$pickup_time = $_GET['extend_from_time'];
	$return_date_ori = date('m/d/Y', strtotime($_GET['extend_to_date']));
	$return_time = $_GET['extend_to_time'];
	$pickup_date = date('m/d/Y H:i', strtotime("$pickup_date $pickup_time"));
	$return_date = date('m/d/Y H:i', strtotime("$return_date_ori $return_time"));
	$return_date_ori = date('m/d/Y H:i', strtotime("$return_date_ori $return_time"));
	
	$day = dateDifference($pickup_date, $return_date_ori, '%a');

	$time = dateDifference($pickup_date, $return_date_ori, '%h');

	$mydate = date('m/d/Y', strtotime($_GET['extend_to_date']));


	$sql = "SELECT class_id FROM vehicle WHERE id='$vehicle_id'";
	db_select($sql);

	if (db_rowcount() > 0) { 

		func_setSelectVar();
	}


	$sql = "SELECT * FROM car_rate WHERE class_id='$class_id'"; 
	db_select($sql); 

	if (db_rowcount() > 0) { 

		func_setSelectVar();

		$dbcar_rate_class_id = $class_id;
		$dbcar_rate_oneday = $oneday;
		$dbcar_rate_twoday = $twoday;
		$dbcar_rate_threeday = $threeday;
		$dbcar_rate_fourday = $fourday;
		$dbcar_rate_fiveday = $fiveday;
		$dbcar_rate_sixday = $sixday;
		$dbcar_rate_weekly = $weekly;
		$dbcar_rate_monthly = $monthly;
		$dbcar_rate_hour = $hour;
		$dbcar_rate_halfday = $halfday;
		$dbcar_rate_deposit = $deposit;
		
	}

	        

	$sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'"; 

	db_select($sql); 
	if (db_rowcount() > 0) { 
		func_setSelectVar(); 

		$dbpromo_how_many_day_min = $how_many_day_min;
		$dbpromo_how_many_day_max = $how_many_day_max;
	} 
	
    $freeday = 'false';

	$difference_hour = $time - 12; 


	if($day == 0) {

		if($time < 8){

			$subtotal = $time * $dbcar_rate_hour; 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_halfday;
		} 

		else if($time >= 13){ 

			$subtotal = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
		} 

	} 

	elseif ($day == 1) { 


		if($time < 8){
			
			$subtotal = $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} 

	elseif ($day == 2) { 

		if($time < 8){
			
			$subtotal = $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 3) { 

		if($time < 8){

			$subtotal = $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

	else if($time >= 8 && $time <= 12) {

		$subtotal = $dbcar_rate_threeday + $dbcar_rate_halfday; 

	} elseif ($time >= 13){ 

		$subtotal = $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

	} 

	} elseif ($day == 4) { 

		if($time < 8){

			$subtotal = $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 5) { 

		if($time < 8){

			$subtotal = $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 
			
			$subtotal = $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 6) { 

		if($time < 8){

			$subtotal = $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_sixday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
		} 

	} elseif ($day == 7) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 8) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 9) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 10) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 11) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 12) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

				$subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 13) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 14) { 

		if($time < 8){

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 15) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 16) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 17) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + $dbcar_rate_halfday; 

		} 

		elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour);

		} 

	} elseif($day == 18) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day == 19) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 20) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 21) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 22) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 23) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 24) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 25) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 26) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} else if ($day == 27) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 28) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 29) { 

		if($time < 8){

			$subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day == 30) { 

		if($time < 8){

			$subtotal = $dbcar_rate_monthly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) { 

			$subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	}

	$six_digit_random_number = mt_rand(100000, 999999); 
	func_setReqVar();

	$est_total = $subtotal + $_GET['delivery_cost'] + $_GET['pickup_cost'];
	$Discount = '0';
	$_SESSION['subtotal'] = $subtotal;
	$_SESSION['est_total'] = $est_total;
	$_SESSION['Discount'] = $Discount;

	if(isset($btn_redeem))
	{

		$coupon = strtoupper($coupon);
		$agent = strtoupper($agent);

		$sqlDis = "SELECT * FROM discount WHERE code='$coupon'";

		db_select($sqlDis);

		if (db_rowcount() > 0) 
		{

			func_setSelectVar();

			$dbdis_code = $code;
			$dbdis_start_date = $start_date;
			$dbdis_end_date = $end_date;
			$dbdis_value_in = $value_in;
			$dbdis_rate = $rate;
			

			if(date('m/d/Y', strtotime($pickup_date))>=date('m/d/Y', strtotime($dbdis_start_date)) && date('m/d/Y', strtotime($return_date)) <= date('m/d/Y', strtotime($dbdis_end_date)) ) 
			{

				if($dbdis_value_in=='A'){

					if($coupon == 'LOYALTY150' && $est_total < $dbdis_rate)
					{

						$return_date_ori = $return_date;
						$Discount = $est_total;
						$est_total = '0';
					}
					else{

						$return_date_ori = $return_date;
						$est_total = $est_total - $dbdis_rate;
						$Discount = number_format($dbdis_rate,2);
					}
				}

				else if($dbdis_value_in=='P'){

					$percent = $est_total * ($dbdis_rate/100);
					$est_total = $est_total - $percent;
					$Discount = number_format($percent,2);
				}
				
				else if($dbdis_value_in=='H'){

					$return_date_ori = $return_date;
					$date = date('m/d/Y H:i:s', strtotime($return_date_ori));
					echo "<br>date: ".$date; 
        			$newdate = strtotime('+ '.$dbdis_rate.' hours', strtotime($date));
        			$newdate = date('m/d/Y H:i', $newdate); 
        			$counthour = date('Hi', strtotime($newdate));
					echo "<br>counthour: ".$counthour; 
					echo "<br>newdate: ".$newdate; 
        			$note = "";
        			$exceed = "";
        			$extend = "";
        			if($counthour > "2230")
        			{
        				$newdate = date('m/d/Y', strtotime($newdate)). " 22:30";
        				$note = "The actual ".$dbdis_rate."-hour extended time exceeded working hours, converting to maximum return time (10:30 pm)";
        				$exceed = "true";
        			}
        			else if($counthour < "800")
        			{
        				$newdate = date('m/d/Y', strtotime($return_date_ori)). " 22:30";
        				$note = "The actual ".$dbdis_rate."-hour extended time exceeded working hours, converting to maximum return time (10:30 pm)";
        				$exceed = "true";
        			}
        			else
        			{
        				$extend = "true";
        				$note = $dbdis_rate." hours period has been added";
        			}

        			$newdate = date('m/d/Y H:i', strtotime($newdate)); 
        			$return_date = $newdate; 
        			echo '<script language="javascript">'; 
        			echo 'alert("Free '.$dbdis_rate.' hour(s)");'; 
        			echo '</script>';
        			$freeday = 'true';
        			
				}

				else if($dbdis_value_in == 'D'){

					$return_date_ori = $return_date;
					$date = date('m/d/Y H:i:s', strtotime($return_date)); 
        			$newdate = strtotime('+ '.$dbdis_rate.' days', strtotime($date));
        			$newdate = date('m/d/Y H:i', $newdate); 

        			$newdate = date('m/d/Y H:i', strtotime($newdate)); 
        			$return_date = $newdate; 
        			echo '<script language="javascript">'; 
        			if($dbdis_rate > 1)
	        			echo 'alert("Free '.$dbdis_rate.' Days");'; 
	        		else
	        			echo 'alert("Free '.$dbdis_rate.' Day");'; 
        			echo '</script>';
        			$freeday = 'true';

        			$note = "The return date has been extended";
        			$extend = "true";
				}

				$_SESSION['subtotal'] = $subtotal;
				$_SESSION['est_total'] = $est_total;
				$_SESSION['Discount'] = $Discount;
			}

			else {

				echo "<script>alert('Coupon is not active');</script>";
			}
		}
		else
		{
			echo "<script>alert('Coupon does not exist');</script>";
		}
	}

	if(isset($_POST['btn_extend'])) { 

		$extend_from_date = $_POST['extend_from_date'];
		$extend_from_time = date('H:i',strtotime($extend_from_date));
		$extend_to_date = $_POST['extend_to_date'];
		$extend_to_time = date('H:i',strtotime($extend_to_date));


		$extend_from_date = date('m/d/Y', strtotime($extend_from_date));
		$extend_from_date = date('m/d/Y', strtotime($extend_from_date));
		$extend_to_date = date('m/d/Y', strtotime($extend_to_date));
		$day = dateDifference($extend_from_date.$extend_from_time, $extend_to_date.$extend_to_time, '%a'); 
		$time = dateDifference($extend_from_date.$extend_from_time, $extend_to_date.$extend_to_time, '%h'); 


		$sql = "SELECT * FROM extend WHERE booking_trans_id=".$_GET['booking_id']; 

		db_select($sql); 

		if(db_rowcount() < 9){ 

			$sql = "INSERT INTO extend 
			  (
			    booking_trans_id, 
			    extend_from_date,
			    extend_from_time,
			    extend_to_date,
			    extend_to_time,
			    payment_status,
			    payment_type,
			    discount_coupon,
			    discount_amount,
			    price,
			    total,
			    payment,
			    vehicle_id,
			    m_date,
			    c_date
			  ) 
			  VALUES 
			  (
			    '".$_GET['booking_id']."', 
			    '".date('Y-m-d', strtotime($extend_from_date)).' '.$extend_from_time.':00'."',
			    '$extend_from_time',
			    '".date('Y-m-d', strtotime($extend_to_date)).' '.$extend_to_time.':00'."',
			    '$extend_to_time',
			    '$payment_status',
			    '$payment_type',
			    '$discount_coupon',
			    '$discount_amount',
			    '$price',
			    '$total',
			    '$payment',
			    '".$vehicle_id."',
			    '".date('Y-m-d H:i:s', time())."',
			    '".date('Y-m-d H:i:s', time())."'
			  )"; 

			db_update($sql); 

			//start booking

			$sql = "SELECT day as db_day, sub_total as db_subtotal, balance as db_balance, vehicle_id FROM booking_trans WHERE id=".$_GET['booking_id']; 

			db_select($sql); 

			if(db_rowcount()>0){ 

			  func_setSelectVar();
			}

			$total_day = $day + $db_day;

			$total_subtotal = $subtotal + $db_subtotal;

			$total_balance = $price + $balance;


			$sql = "UPDATE booking_trans SET available = 'Extend' WHERE id = '$booking_id'";

			// $sql = "UPDATE booking_trans SET
			//      return_date ='". date('Y-m-d', strtotime($extend_to_date)).' '.$extend_to_time.':00'."',
			//      return_time ='$extend_to_time',
			//      day = '$total_day',
			//      sub_total = '$total_subtotal',
			//      est_total = '$total_subtotal',
			//      balance = '$total_balance',
			//      available = 'Extend',
			//      payment_details = '$payment_type'

			//      WHERE id = '$booking_id'
			//      ";
			 
			// end booking

			db_update($sql);

			//place extend

		} else { 

			echo "<script>alert('Extend has reach their limit.')</script>"; 
		}

		$sql = "INSERT INTO sale 
		(
		title,
		type,
		booking_trans_id,
		vehicle_id,
		total_day,
		total_sale,
		pickup_date,
		return_date,
		staff_id,
		created
		)
		VALUES (
		'Extend',
		'Extend',
		'$booking_id',
		'$vehicle_id',
		'$day',
		'$total',
		'" . date('Y-m-d', strtotime($extend_from_date)).' '.$extend_from_time.":00',
		'" . date('Y-m-d', strtotime($extend_to_date)).' '.$extend_to_time.":00',
		'".$_SESSION['cid']."',
		'".date('Y-m-d H:i:s',time())."'
		)";

		db_update($sql);

		// $sql = "SELECT LAST_INSERT_ID() FROM sale"; 
		// db_select($sql); 

		// if (db_rowcount() > 0) { 

			$sale_id = mysqli_insert_id($con); 
		// }
		// else
		// {
		// 	echo "<script>alert('tak masuk');</script>";
		// }


		$daylog = '0';
		$datelog = date('Y/m/d', strtotime($extend_from_date)).' '.$extend_from_time.":00";

		$hourlog = dateDifference($extend_from_date.$extend_from_time, date('m/d/Y', strtotime($extend_to_date)).$extend_to_time, '%h');
		$day = dateDifference($extend_from_date.$extend_from_time, date('m/d/Y', strtotime($extend_to_date)).$extend_to_time, '%a');

		$a = 0;

		$datenew = date('Y/m/d', strtotime($extend_to_date)).' '.$extend_to_time.":00";

		while($datelog <= $datenew)
		{

			// echo "<br><br><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<LOOP>>>>>>>>>>>>>>>>>>>>>>>>>>";
            
            
            $currdate = date('Y-m-d',strtotime($datelog)).' '.$extend_to_time.":00";

			$daydiff = dateDifference($datelog, date('m/d/Y', strtotime($extend_to_date)).' '.$extend_from_time, '%a'); 

			$mymonth = date("m",strtotime($datelog));
			$myyear = date("Y",strtotime($datelog));

			$week1date1 = date('Y/m/d', strtotime($mymonth.'/01/'.$myyear))." 00:00:00";
			$week1date2 = date('Y/m/d', strtotime($mymonth.'/07/'.$myyear))." 23:59:59";
			$week2date1 = date('Y/m/d', strtotime($mymonth.'/08/'.$myyear))." 00:00:00";
			$week2date2 = date('Y/m/d', strtotime($mymonth.'/14/'.$myyear))." 23:59:59";
			$week3date1 = date('Y/m/d', strtotime($mymonth.'/15/'.$myyear))." 00:00:00";
			$week3date2 = date('Y/m/d', strtotime($mymonth.'/21/'.$myyear))." 23:59:59";
			$week4date1 = date('Y/m/d', strtotime($mymonth.'/22/'.$myyear))." 00:00:00";
			$week4date2 = date('Y/m/d', strtotime($mymonth.'/28/'.$myyear))." 23:59:59";
			$week5date1 = date('Y/m/d', strtotime($mymonth.'/29/'.$myyear))." 00:00:00";
			$week5date2 = date('Y/m/d', strtotime($mymonth.'/31/'.$myyear))." 23:59:59";

			if($mymonth == '1')
			{

			  $monthname = 'jan';
			}
			else if($mymonth == '2')
			{

			  $monthname = 'feb';
			}
			else if($mymonth == '3')
			{

			  $monthname = 'march';
			}
			else if($mymonth == '4')
			{

			  $monthname = 'apr';
			}
			else if($mymonth == '5')
			{

			  $monthname = 'may';
			}
			else if($mymonth == '6')
			{

			  $monthname = 'june';
			}
			else if($mymonth == '7')
			{

			  $monthname = 'july';
			}
			else if($mymonth == '8')
			{

			  $monthname = 'aug';
			}
			else if($mymonth == '9')
			{

			  $monthname = 'sept';
			}
			else if($mymonth == '10')
			{

			  $monthname = 'oct';
			}
			else if($mymonth == '11')
			{

			  $monthname = 'nov';
			}
			else if($mymonth == '12')
			{

			  $monthname = 'dec';
			}

			if($datelog >= $week1date1 && $datelog <= $week1date2)
			{

			    $week = 'week1';
			}

			else if($datelog >= $week2date1 && $datelog <= $week2date2)
			{

			    $week = 'week2';
			}

			else if($datelog >= $week3date1 && $datelog <= $week3date2)
			{
			    
			    $week = "week3";
			}

			else if($datelog >= $week4date1 && $datelog <= $week4date2)
			{

			    $week = 'week4';
			}

			else if($datelog >= $week5date1 && $datelog <= $week5date2)
			{

			    $week = 'week5';
			}

			if($hourlog != '0')
			{

				if($time < 8){

					$daily_sale = $time * $hour; 
				}

				else if($time >= 8 && $time <= 12) {

					$daily_sale = $halfday;
				} 

				else if($time >= 13){
				    
					$daily_sale = $halfday + ($hour * $difference_hour); 
				          80 + 80;
				}

				if($daily_sale > $total)
				{
					$daily_sale = $total;
				}

				$sql = "INSERT INTO sale_log 
				(
					sale_id,
					daily_sale,
					day,
					hour,
					type,
					".$week.",
					".$monthname.",
					year,
					date,
					created
				)
				VALUES (
					'$sale_id',
					'$daily_sale',
					'0',
					'$hourlog',
					'hour (extend)',
					'$daily_sale',
					'$daily_sale',
					'$myyear',
					'$currdate',
					'".date('Y-m-d H:i:s',time())."'
				)";

				db_update($sql);

				$total = $total - $daily_sale;

				$hourlog = '0';
			}

			else if($hourlog == '0' && $a == '0')
			{

			  $sql = "INSERT INTO sale_log 
			  (
			    sale_id,
			    daily_sale,
			    day,
			    hour,
			    ".$week.",
			    type,
			    year,
			    date,
			    created
			  )
			  VALUES (
			    '$sale_id',
			    '0',
			    '0',
			    '0',
			    '0',
			    'firstday (extend)',
			    '$myyear',
			    '$currdate',
			    '".date('Y-m-d H:i:s',time())."'
			  )";

			  db_update($sql);
			}

			else if($hourlog == '0' && $a > 0)
			{

			  $daily_sale = $total / $day;

			  $daylog = $daylog + 1;

			  $sql = "INSERT INTO sale_log 
			  (
			    sale_id,
			    daily_sale,
			    day,
			    type,
			    hour,
			    ".$week.",
			    ".$monthname.",
			    year,
			    date,
			    created
			  )
			  VALUES (
			    '$sale_id',
			    '$daily_sale',
			    '$daylog',
			    'day (extend)',
			    '0',
			    '$daily_sale',
			    '$daily_sale',
			    '$myyear',
			    '$currdate',
			    '".date('Y-m-d H:i:s',time())."'
			  )";

			  db_update($sql);
			}

			$datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$extend_from_time.":00";

			$a = $a +1;
			} 

		vali_redirect("reservation_list_view.php?booking_id=".$booking_id); 
		} 







?>

	<body class="nav-md">
		<div class="container body">
	    	<div class="main_container">

	        	<?php include('_leftpanel.php'); ?>

	        	<?php include('_toppanel.php'); ?>

	        	<!-- page content -->
				<div class="right_col" role="main">
					<div class="">
						<div class="page-title">
							<div class="title_left">
								<h3>Extend Payment</h3>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Discount Coupon</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
	                        					<ul class="dropdown-menu" role="menu">
	                        						<li><a href="#">Settings 1</a></li>
	                        						<li><a href="#">Settings 2</a></li>
	                        					</ul>
	                        				</li>
	                        				<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                        			</ul>
	                        			<div class="clearfix"></div>
	                        		</div>
	                        		<div class="x_content">
	                        			<form id="demo-form1" name="demo-form1" data-parsley-validate class="form-horizontal form-label-left" method="POST">
	                        				<div class="container">
	                        					<div class="">
	                        						<div class='col-sm-4'>
	                        							Base Rate
	                        							<div class="form-group">
	                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12'>
	                        									<input class="form-control" value="<?php echo dateDifference($pickup_date, $return_date_ori, '%a Day %h Hours'); ?>" disabled>
	                        								</div>
	                        							</div>
	                        						</div>
	                        						<div class='col-sm-4'>
	                        							Discount (MYR)
	                        							<div class="form-group">
	                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
	                        									<input class="form-control" type="text" value="<?php echo $Discount; ?>" name="discount" id="discount" disabled>
	                        								</div>
	                        							</div>
	                        						</div>
	                        						<div class='col-sm-4'>
	                        							Sub Total (MYR)
	                        							<div class="form-group">
	                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
	                        									<input class="form-control" type="text" value="<?php echo number_format($subtotal,2);?>" id="subtotal" disabled>
	                        								</div>
	                        							</div>
	                        						</div>
									            	<div class='col-sm-4'>
									            		Grand Total (MYR)
									            		<div class="form-group">
									            			<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
									            				<input class="form-control" type="text" value="<?php echo number_format($est_total,2); ?>" name="est_total" disabled>
									            			</div>
									            		</div>
									            	</div>
									            </div>
												<div class="">
													<div class='col-sm-4'>
														Pickup Date & Time
														<div class="form-group">
															<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																<input class="form-control" value="<?php echo date('d/m/Y', strtotime($pickup_date)) . " - " . date('H:i', strtotime($pickup_date)); ?>" disabled>
															</div>
														</div>
													</div>
													<div class='col-sm-4'>
														Return Date & Time
														<?php
															if($exceed == "true")
															{
																echo '<abbr title="'.$note.'"><i class="fa fa-info-circle" style="color:red"></i></abbr>';
															}
															
															if($extend == "true")
															{
																echo '<abbr title="'.$note.'"><i class="fa fa-info-circle" style="color:green"></i></abbr>';
															}
														?>
														<div class="form-group">
															<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																<?php
																	if (isset($btn_redeem) && (date('m/d/Y', strtotime($pickup_date))>=date('m/d/Y', strtotime($dbdis_start_date)) && date('m/d/Y', strtotime($return_date)) <= date('m/d/Y', strtotime($dbdis_end_date)))) 
																	{ 
																?>
																		<input class="form-control" value="<?php echo date('d/m/Y', strtotime($return_date_ori)) . " - " . date('H:i', strtotime($return_date_ori)) . " -> " . date('d/m/Y', strtotime($return_date)) . " - " . date('H:i', strtotime($return_date)); ?>" disabled>
																<?php
																	} else {
																?>
																	<input class="form-control" value="<?php echo date('d/m/Y', strtotime($return_date_ori)) . " - " . date('H:i', strtotime($return_time)); ?>" disabled>
																<?php 
																	}
																?>
															</div>
														</div>
													</div>
													<div class='col-sm-4'>
														Coupon Code
														<div class="form-group">
															<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																<input type="text" class="form-control" name="coupon" value="<?php echo $coupon; ?>">
															</div>
														</div>
													</div>
													<div class='col-sm-4'>
														Agent Code
														<div class="form-group">
															<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																<input type="text" class="form-control" name="agent" value="<?php echo $agent; ?>">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="ln_solid"></div>
											<div class="form-group" style="text-align: center;">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<input type="hidden" name="pickup_date" value="<?php echo $pickup_date; ?>">
													<input type="hidden" name="pickup_time" value="<?php echo $pickup_time; ?>">
													<input type="hidden" name="return_date" value="<?php echo $return_date_ori; ?>">
													<input type="hidden" name="return_time" value="<?php echo $return_time; ?>">
													<input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
													<input type="hidden" name="est_total" value="<?php echo $est_total; ?>">
													<input type="hidden" name="Discount" value="<?php echo $Discount; ?>">
													<button type="submit" class="btn btn-primary"  name="btn_redeem" formnovalidate>Validate Discount</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Payment Details</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
	                        					<ul class="dropdown-menu" role="menu">
	                        						<li><a href="#">Settings 1</a></li>
	                        						<li><a href="#">Settings 2</a></li>
	                        					</ul>
	                        				</li>
	                        				<li><a class="close-link"><i class="fa fa-close"></i></a></li>
	                        			</ul>
	                        			<div class="clearfix"></div>
	                        		</div>
	                        		<div class="x_content">
	                        			<form id="demo-form1" name="demo-form1" data-parsley-validate class="form-horizontal form-label-left" method="POST">
	                        				<div class="container">
	                        					<div class="">
	                        						<div class='col-md-4'>
	                        							Payment Amount
	                        							<div class="form-group">
	                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12'>
	                        									<input type="text" class="form-control" placeholder="Payment Amount" name="payment" id="payment" required>
	                        								</div>
	                        							</div>
	                        						</div>
	                        						<div class='col-md-4'>
	                        							Payment Status
	                        							<div class="form-group">
	                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12'>
	                        									<select name="payment_status" class="form-control">
								                                    <option value='Paid'>Paid</option>
								                                    <option value='Collect'>Need to Collect</option>
								                                </select>
	                        								</div>
	                        							</div>
	                        						</div>
	                        						<div class='col-md-4'>
	                        							Payment Type
	                        							<div class="form-group">
	                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12'>

	                        									<select name="payment_type" class="form-control">
	                        										<option value='Cash'>Cash</option>
																	<option value='Online'>Online</option>
																	<option value='Cheque'>Cheque</option>
																	<option value='Credit / Debit'>Credit / Debit</option>
																</select>
	                        								
	                        								</div>
	                        							</div>
	                        						</div>
												</div>
											</div>
											<div class="ln_solid"></div>
											<div class="form-group" style="text-align: center;">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<input type="hidden" name="pickup_date" value="<?php echo $pickup_date; ?>">
													<input type="hidden" name="pickup_time" value="<?php echo $pickup_time; ?>">
													<input type="hidden" name="return_date" value="<?php echo $return_date_ori; ?>">
													<input type="hidden" name="return_time" value="<?php echo $return_time; ?>">
													<input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
													<input type="hidden" name="est_total" value="<?php echo $est_total; ?>">
													<input type="hidden" name="extend_from_date" value="<?php echo $pickup_date; ?>">
													<input type="hidden" name="extend_to_date" value="<?php echo $return_date; ?>">
													<input type="hidden" name="price" value="<?php echo $subtotal; ?>">
													<input type="hidden" name="total" value="<?php echo $est_total; ?>">
													<input type="hidden" name="discount_coupon" value="<?php echo $coupon; ?>">
													<input type="hidden" name="discount_amount" value="<?php echo $Discount; ?>">
													<button type="submit" class="btn btn-success"  name="btn_extend">Submit Extend</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	        <!-- /page content -->

        <?php include('_footer.php') ?>

	    <script>
			var time = new Date().getTime();
			$(document.body).bind("mousemove keypress", function(e) {
				time = new Date().getTime();
			});

			function refresh() {
				if(new Date().getTime() - time >= 1800000) 
					window.location.reload(true);
				else 
					setTimeout(refresh, 1800000);
			}

			setTimeout(refresh, 1800000);
	    </script>
	</body>
</html>

<?php
} 
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}		
?>