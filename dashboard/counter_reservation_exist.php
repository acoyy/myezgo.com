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

	// echo $_GET['search_pickup_date'];
	$search_pickup_date = $_GET['search_pickup_date'] . " " . $_GET['search_pickup_time'];
	$search_return_dates = $_GET['search_return_date'] . " " . $_GET['search_return_time'];
	$date_initial = $_GET['date_initial'];

	// echo "<br>search_pickup_date: ".$search_pickup_date;
	// echo "<br>search_return_dates: ".$search_return_dates;
	// echo "<br>date_initial: ".$date_initial;

	$day = dateDifference($search_pickup_date, $date_initial, '%a'); 

	// echo "<br>day: ".$day;

	$checkAddDriver = $_GET['checkAddDriver'];
	$checkCdw = $_GET['checkCdw'];
	$checkStickerP = $_GET['checkStickerP'];
	$checkTouchnGo = $_GET['checkTouchnGo'];
	$checkDriver = $_GET['checkDriver'];
	$checkCharger = $_GET['checkCharger'];
	$checkSmartTag = $_GET['checkSmartTag'];
	$checkChildSeat = $_GET['checkChildSeat'];

	$time = dateDifference($search_pickup_date, $date_initial, '%h'); 
	// $day = $diff - $hours * (60 * 60);
	 
	$mydate = date('m/d/Y', strtotime($_GET['search_pickup_date']));
	$mymonth = date("m",strtotime($mydate));
	$myday = date("d",strtotime($mydate));
	$myyear = date("Y",strtotime($mydate));


	$sql = "SELECT * FROM car_rate WHERE class_id=" . $_GET['class_id']; 
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

	$sql = "SELECT min_rental_time FROM vehicle WHERE id=" . $_GET['vehicle_id']; 
	db_select($sql); 

	if (db_rowcount() > 0) { 

		func_setSelectVar();
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

	if($day <= '30')
	{
		include('sale_calculation.php');
	}
	else
	{
		$day = $day - 30;


		include('sale_calculation.php');
		
		$subtotal = $subtotal + $dbcar_rate_monthly;
	}

	// $six_digit_random_number = mt_rand(100000, 999999); 
	func_setReqVar();

	if($_GET['delivery_cost'] == '')
	{
		$get_delivery_cost = '0';
	}

	if($_GET['pickup_cost'] == '')
	{
		$get_pickup_cost = '0';
	}

	$est_total = $subtotal + $get_delivery_cost + $get_pickup_cost;
	// echo "<br>674) est_total: ".$est_total;
	$Discount = '0';


	if($_GET['coupon_type'] != '' || $_GET['coupon_type'] != NULL) 
	{

		$sql = "SELECT * FROM discount WHERE code='".$_GET['coupon']."' AND value_in='".$_GET['coupon_type']."'";

		db_select($sql);

		if (db_rowcount() > 0) 
		{

			func_setSelectVar();
		}
		
		if($_GET['coupon_type'] == 'A'){

			if($_GET['coupon'] == 'LOYALTY150' && $est_total < $rate)
			{

				$Discount = $est_total;
				$est_total = '0';
			}
			else{

				$est_total = $est_total - $rate;
				$Discount = number_format($rate,2);
			}
			$coupontype = 'money';
		}

		else if($_GET['coupon_type'] == 'P'){

			$percent = $est_total * ($rate/100);
			$est_total = $est_total - $percent;
			$Discount = number_format($percent,2);
			$coupontype = 'money';
		}
	}

	
	
	if($_GET['agent_id'] != '' || $_GET['agent_id'] != NULL)
	{
		// kat sini nak buat kira2 utk agent

		$sql = "SELECT name as agent_name FROM agent WHERE id='".$_GET['agent_id']."'";

		db_select($sql);

		func_setSelectVar();

		$day_agent = dateDifference($search_pickup_date, $search_return_dates, '%a');
		
		$sql = "SELECT * FROM agent_rate";

		db_select($sql);

		func_setSelectVar();

		// echo "<br>day_agent: ".$day_agent;

		if($day_agent < 1)
		{
			if($time < 5 || ($time > 5 && $time < 12))
			{
				$profit = $perhour;
			}
			else if($time == 5)
			{
				$profit = $fivehour;
			}
			else if($time >= 12)
			{
				$profit = $halfday;
			}
		}
		else if($day_agent == 1)
		{
			$profit = $oneday;
		}
		else if($day_agent == 2)
		{
			$profit = $twoday;
		}
		else if($day_agent == 3)
		{
			$profit = $threeday;
		}
		else if($day_agent == 4)
		{
			$profit = $fourday;
		}
		else if($day_agent == 5)
		{
			$profit = $fiveday;
		}
		else if($day_agent == 6)
		{
			$profit = $sixday;
		}
		else if($day_agent >= 7 && $day_agent < 30)
		{
			$profit = $weekly;
		}
		else if($day_agent == 30)
		{
			$profit = $monthly;
		}

		$agent_profit = $subtotal * ($profit/100);
		
		if($day_agent > 30)
		{

			$agent_profit = $dbcar_rate_monthly * ($monthly/100);
			
			$day_agent = $day_agent - 30;

			if($day_agent < 1)
			{
				if($time < 5 || ($time > 5 && $time < 12))
				{
					$profit = $perhour;
				}
				else if($time == 5)
				{
					$profit = $fivehour;
				}
				else if($time >= 12)
				{
					$profit = $halfday;
				}
			}
			else if($day_agent == 1)
			{
				$profit = $oneday;
			}
			else if($day_agent == 2)
			{
				$profit = $twoday;
			}
			else if($day_agent == 3)
			{
				$profit = $threeday;
			}
			else if($day_agent == 4)
			{
				$profit = $fourday;
			}
			else if($day_agent == 5)
			{
				$profit = $fiveday;
			}
			else if($day_agent == 6)
			{
				$profit = $sixday;
			}
			else if($day_agent >= 7 && $day_agent < 30)
			{
				$profit = $weekly;
			}
			else if($day_agent == 30)
			{
				$profit = $monthly;
			}

			include('profit_calculation.php');

			$agent_profit = $agent_profit + ($agent_subtotal * ($profit/100));
		}
	}

	if(isset($btn_save_booking)){

		// echo "<script> alert('masuk'); </script>";

		$subtotal = $_POST['subtotal'];
		$est_total = $_POST['est_total'];
		$Discount = $_POST['discount'];
		$search_return_dates = $_GET['search_return_date'];

    	$temp_pickup_date = date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].':00';
    	$temp_return_date = date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time'].':00';

    	// echo "<br>".$temp_return_date;

    	$sql = "SELECT id AS booking_id FROM booking_trans WHERE vehicle_id = '$vehicle_id' AND delete_status = 'Active' AND 
			(
				(
				return_date <= '" . $temp_return_date ."' 
                AND return_date >= '" . $temp_pickup_date ."' 
                AND (available = 'Out' OR available = 'Booked')
            	)
            	OR
            	(
                pickup_date >= '" . $temp_pickup_date ."' 
                AND pickup_date <= '" . $temp_return_date ."'
                AND (available = 'Out' OR available = 'Booked')
            	)
            )";

		db_select($sql);

		if (db_rowcount() > 0) { 

			$vehicle_status = 'active';
		}

		if($vehicle_status == 'active')
		{
			echo '<script> alert("Vehicle has been Booked / Out!")</script>'; 

			vali_redirect("counter_reservation.php?search_pickup_date=".date('Y-m-d', strtotime($_GET['search_pickup_date']))."&search_pickup_time=".$_GET['search_pickup_time']."&search_return_date=".date('Y-m-d', strtotime($search_return_dates))."&search_return_time=".$_GET['search_return_time']."&search_pickup_location=".$_GET['search_pickup_location']."&search_return_location=".$_GET['search_return_location']."&vehicle_status=active&search_driver=MY&btn_search=#"); 
		}
		else
		{

			func_setValid("Y"); 
	    	func_isEmpty($nric_no, "nric no"); 
	    	func_isEmpty($title, "title"); 
	    	func_isEmpty($firstname, "first name"); 
	    	func_isEmpty($lastname, "last name"); 
	    	func_isEmpty($age, "age"); 
	    	func_isNum($age, "age"); 
	    	func_isEmpty($phone_no, "phone no"); 
	    	func_isEmpty($refund_dep_status, "refund dep status"); 
	    	func_isEmpty($refund_dep_payment, "refund dep payment"); 


		    if (func_isValid()) {

		    	$sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $_GET['vehicle_id']; 
				db_update($sql); 

				// echo "<br>1151) masuk update vehicle booking, vehicle_id: ".$_GET['vehicle_id'];

				$sql = "select nric_no from customer where nric_no = '$nric_no'";

				db_select($sql);

				if(db_rowcount() > 0)
				{
					$ic = "exist";
					if($drv_license_exp != '' && $drv_license_exp != NULL)
				    {
				     	$drv_license_exp = date('Y-m-d', strtotime($drv_license_exp));
				    }

				    $sql = "UPDATE customer SET 
				     		firstname = '" . conv_text_to_dbtext3($firstname) . "',
				     		lastname = '" . conv_text_to_dbtext3($lastname) . "',
				     		age = '" . $age . "',
				     		phone_no = '" . conv_text_to_dbtext3($phone_no) . "',
				     		email = '" . conv_text_to_dbtext3($email) . "',
				     		status = 'A',
				     		mid = '" . $_SESSION['cid'] . "',
				     		mdate = '".date('Y-m-d H:i:s',time())."',
				     		drv_name = '" . conv_text_to_dbtext3($drv_name) . "',
				     		drv_nric = '" . conv_text_to_dbtext3($drv_nric) . "',
				     		drv_address = '" . conv_text_to_dbtext3($drv_address) . "',
				     		drv_phoneno = '" . conv_text_to_dbtext3($drv_phoneno) . "',
				     		drv_license_no = '" . conv_text_to_dbtext3($drv_license_no) . "',
				     		drv_license_exp = '" . $drv_license_exp . "',
				     		survey_type = '" . $survey_type . "',
				     		survey_details = '" . conv_text_to_dbtext3($survey_details) . "'
				     		where nric_no = '$nric_no'";

					db_update($sql); 

					$sql = "SELECT id FROM customer where nric_no = '$nric_no'"; 

					db_select($sql); 

					if (db_rowcount() > 0) 
					{

						$dbcustomer_id = db_get(0, 0); 
					}
				}
				else
				{
					$ic = "not exist";

				    	$sql = "INSERT INTO customer
						(
						title,
						firstname,
						lastname,
						nric_no,
						age,
						phone_no,
						email,
						status,
						cid,
						cdate,
						drv_name,
						drv_nric,
						drv_address,
						drv_phoneno,
						drv_license_no,
						drv_license_exp,
						survey_type,
						survey_details
						)
						VALUES
						(
						'" . conv_text_to_dbtext3($title) . "',
						'" . conv_text_to_dbtext3($firstname) . "',
						'" . conv_text_to_dbtext3($lastname) . "',
						'" . conv_text_to_dbtext3($nric_no) . "',
						" . $age . ",
						'" . conv_text_to_dbtext3($phone_no) . "',
						'" . conv_text_to_dbtext3($email) . "',
						'A',
						" . $_SESSION['cid'] . ",
						'".date('Y-m-d H:i:s',time())."',
						'" . conv_text_to_dbtext3($drv_name) . "',
						'" . conv_text_to_dbtext3($drv_nric) . "',
						'" . conv_text_to_dbtext3($drv_address) . "',
						'" . conv_text_to_dbtext3($drv_phoneno) . "',
						'" . conv_text_to_dbtext3($drv_license_no) . "',
						'" . $drv_license_exp . "',
						'$survey_type',
						'" . conv_text_to_dbtext3($survey_details) . "'
						)
						"; 

					db_update($sql); 

					// $sql = "SELECT LAST_INSERT_ID() FROM customer"; 

					// db_select($sql); 

					// if (db_rowcount() > 0) 
					// {

						$dbcustomer_id = mysqli_insert_id($con); 
					// }
				}

				// $sql = "SELECT LAST_INSERT_ID() FROM customer"; 

				// db_select($sql); 

				// if (db_rowcount() > 0) { 

					// $dbcustomer_id = mysqli_insert_id($con); 

				// } 
				// echo "<br>1208) masuk customer booking, latest customer id: ".$dbcustomer_id;

				if ($_GET['pickup_cost'] >= 1) { 

					$sql = "INSERT INTO booking_trans
					   (
					   pickup_date,
					   pickup_location,
					   pickup_time,
					   return_date,
					   return_location,
					   return_time,
					   option_rental_id,
					   cdw,
					   discount_coupon,
					   discount_amount,
					   vehicle_id,
					   day,
					   sub_total,
					   balance,
					   payment_details,
					   est_total,
					   customer_id,
					   created,
					   refund_dep,
					   refund_dep_payment,
					   refund_dep_status,
					   type,
					   agent_id,
					   available,
					   p_cost,
					   p_address,
					   p_address2,
					   branch,
					   staff_id
					   )
					   VALUES
					   (
					   '" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].  "',
					   '$search_pickup_location',
					   '$search_pickup_time',
					   '" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
					   '$search_return_location',
					   '".$_GET['search_return_time']."',
					   0,
					   0,
					   '$coupon',
					   '".$Discount."',
					   " . $_GET['vehicle_id'] . ",
					   '$day',
					   '$subtotal',
					   '$payment_amount',
					   '$payment_details',
					   '$est_total',
					   '$dbcustomer_id',
					   '".date('Y-m-d H:i:s',time())."',
					   '$deposit',
					   '$refund_dep_payment',
					   '$refund_dep_status',
					   0,
					   '$agent_id',
					   'Booked',
					   " . $_GET['pickup_cost'] . ",
					   '" . conv_text_to_dbtext3($_GET['p_pickup_address']) . "',
					   '" . conv_text_to_dbtext3($_GET['r_pickup_address']) . "',
					   '".$_SESSION['user_branch']."',
					   '".$_SESSION['cid']."'
					   )
					";
					// echo "<br>1293) masuk customer pickup cost booking";
				} 
				elseif ($_GET['delivery_cost'] >= 1) { 

				   	$sql = "INSERT INTO booking_trans
					   (
					   pickup_date,
					   pickup_location,
					   pickup_time,
					   return_date,
					   return_location,
					   return_time,
					   option_rental_id,
					   cdw,
					   discount_coupon,
					   discount_amount,
					   vehicle_id,
					   day,
					   sub_total,
					   balance,
					   payment_details,
					   est_total,
					   customer_id,
					   created,
					   refund_dep,
					   refund_dep_payment,
					   refund_dep_status,
					   type,
					   r_cost,
					   r_address,
					   r_address2,
					   agent_id,
					   available,
					   branch,
					   staff_id
					   )
					   VALUES
					   (
					   '" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
					   '$search_pickup_location',
					   '$search_pickup_time',
					   '" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
					   '$search_return_location',
					   '".$_GET['search_return_time']."',
					   0,
					   0,
					   '$coupon',
					   '".$Discount."',
					   " . $_GET['vehicle_id'] . ",
					   '$day',
					   '$subtotal',
					   '$payment_amount',
					   '$payment_details',
					   '$est_total',
					   '$dbcustomer_id',
					   '".date('Y-m-d H:i:s',time())."',
					   '$deposit',
					   '$refund_dep_payment',
					   '$refund_dep_status',
					   0,
					   " . $_GET['delivery_cost'] . ",
					   '" . conv_text_to_dbtext3($_GET['p_delivery_address']) . "',
					   '" . conv_text_to_dbtext3($_GET['r_delivery_address']) . "',
					   '$agent_id',
					   'Booked',
					   '".$_SESSION['user_branch']."',
					   '".$_SESSION['cid']."'
					   )
					"; 
					// echo "<br>1360) masuk customer delivery cost booking";
				} 
				else { 

					$sql = "INSERT INTO booking_trans
					   (
					   pickup_date,
					   pickup_location,
					   pickup_time,
					   return_date,
					   return_location,
					   return_time,
					   option_rental_id,
					   cdw,
					   discount_coupon,
					   discount_amount,
					   vehicle_id,
					   day,
					   sub_total,
					   balance,
					   payment_details,
					   est_total,
					   customer_id,
					   created,
					   refund_dep,
					   refund_dep_payment,
					   refund_dep_status,
					   type,
					   agent_id,
					   available,
					   branch,
					   staff_id
					   )
					   VALUES
					   (
					   '" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
					   '$search_pickup_location',
					   '$search_pickup_time',
					   '" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
					   '$search_return_location',
					   '".$_GET['search_return_time']."',
					   0,
					   0,
					   '$coupon',
					   '".$Discount."',
					   " . $_GET['vehicle_id'] . ",
					   '$day',
					   '$subtotal',
					   '$payment_amount',
					   '$payment_details',
					   '$est_total',
					   '$dbcustomer_id',
					   '".date('Y-m-d H:i:s',time())."',
					   '$deposit',
					   '$refund_dep_payment',
					   '$refund_dep_status',
					   0,
					   '$agent_id',
					   'Booked',
					   '".$_SESSION['user_branch']."',
					   '".$_SESSION['cid']."'
					   )
					";
					// echo "<br>1426) masuk customer takada cost booking";
				}

				db_update($sql);
				
				// $sql = "SELECT LAST_INSERT_ID() FROM booking_trans "; 
				// db_select($sql); 

				// if (db_rowcount() > 0) { 

					$booking_id = mysqli_insert_id($con); 

					// echo "<script>alert('counter booking id: ".$booking_id."');</script>";
				// }
				// else
				// {
				// 	echo "<script>alert('tak masuk');</script>";
				// 	// break;
				// }
				// echo "<br>1220) latest booking_id: ".$booking_id;

				$sql = "SELECT id, description, initial from location WHERE description = '" . $_SESSION['user_branch']."'";

		         db_select($sql);

		 	     if (db_rowcount() > 0) {

		 	     	// $pickup_location = db_get(0, 1);
		 	     	$pickup_initial = db_get(0, 2);
		 	      }
		 	      else
		 	      {
		 	      	echo "<script> alert('tak jumpa');</script>";
		 	      }

		 	    if($agent==''){

		 	    	$agent='000';
	 	    	}

		 	    if($booking_id<10){

		 	      	$agr_no='000'.$booking_id;

		 	    }

	 	    	elseif ($booking_id<100) {
		 	      	
		 	      	$agr_no='00'.$booking_id;
				}

		 	    elseif ($booking_id<1000) {
		      	
	      			$agr_no='0'.$booking_id;
		 	    }

		 	    elseif ($booking_id<10000) {
		 	      	
		 	      	$agr_no=$booking_id;
		 	    }

				$agreement_no=$pickup_initial.$agent.$mymonth.$myday.$agr_no;

				// echo $agreement_no;

		        $sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;

		        db_update($sql);
		        // echo "<br>1488) masuk update booking trans booking, agreement_no: ".$agreement_no." booking_id: ".$booking_id;

				$sql = "INSERT INTO checklist
				(
				booking_trans_id,
				car_out_sticker_p,
				car_out_child_seat,
				car_out_usb_charger,
				car_out_touch_n_go,
				car_out_smart_tag,
				car_add_driver,
				car_cdw,
				car_driver
				)
				VALUES
				(
				'$booking_id',
				'" . $_GET['checkStickerP'] . "',
				'" . $_GET['checkChildSeat'] . "',
				'" . $_GET['checkCharger'] . "',
				'" . $_GET['checkTouchnGo'] . "',
				'" . $_GET['checkSmartTag'] . "',
				'" . $_GET['checkAddDriver'] . "',
				'" . $_GET['checkCdw'] . "',
				'" . $_GET['checkDriver'] . "'
				)
				"; 

				db_update($sql); 
			} 

			if($agent_profit != '' && $agent_id != '')
			{
				$est_total = $subtotal - $agent_profit;

				$sql = "INSERT INTO agent_profit 
				(
					agent_id,
					booking_trans_id,
					amount,
					created,
					cid
				)
				VALUES
				(
					'$agent_id',
					'$booking_id',
					'$agent_profit',
					'".date('Y-m-d H:i:s',time())."',
					'".$_SESSION['cid']."'
				)";

				db_update($sql);
			}

			$sql = "INSERT INTO sale 
			(
				title,
				type,
				booking_trans_id,
				vehicle_id,
				total_day,
				deposit,
				payment_status,
				payment_type,
				pickup_date,
				return_date,
				staff_id,
				created
			)
			VALUES (
				'Booking Deposit in',
				'Booking',
				'$booking_id',
				'" . $_GET['vehicle_id'] . "',
				'$day',
				'$deposit',
				'$refund_dep_status',
				'$refund_dep_payment',
				'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
				'" . date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
				'".$_SESSION['cid']."',
				'".date('Y-m-d H:i:s',time())."'
			)";

			db_update($sql);

			echo '<script> alert("Successfully booking!")</script>'; 

			$_SESSION['search_pickup_date'] = NULL;
			$_SESSION['search_return_date'] = NULL;

			vali_redirect("mail.php?status=booking&booking_id=" . $booking_id); 
		}
	}
	else if (isset($btn_save_pickup)){
		
		// echo "<br>masuk dah";
		//button SAVE clicked

		$subtotal = $_POST['subtotal'];
		$est_total = $_POST['est_total'];
		$Discount = $_POST['discount'];
		$search_return_dates = $_GET['search_return_date'];

		$temp_license_exp = date('Y-m-d', strtotime($_POST['license_exp'])).' 00:00:00';

		$temp_pickup_date = date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].':00';
    	$temp_return_date = date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time'].':00';

    	$sql = "SELECT id AS booking_id FROM booking_trans WHERE vehicle_id = '$vehicle_id' AND delete_status = 'Active' AND 
    			(
    				(
					return_date <= '" . $temp_return_date ."' 
                    AND return_date >= '" . $temp_pickup_date ."' 
                    AND (available = 'Out' OR available = 'Booked')
                	)
                	OR
                	(
                    pickup_date >= '" . $temp_pickup_date ."' 
                    AND pickup_date <= '" . $temp_return_date ."'
                    AND (available = 'Out' OR available = 'Booked')
                	)
                )";

		db_select($sql);

		if (db_rowcount() > 0) { 

			$vehicle_status = 'active';
		}



		if ($temp_license_exp >= $temp_pickup_date && $temp_license_exp <= $temp_return_date) { 

			$license_validity = 'invalid';
		}

		if($vehicle_status == 'active')
		{
			echo '<script> alert("Vehicle has been Booked / Out!")</script>'; 

			vali_redirect("counter_reservation.php?search_pickup_date=".date('Y-m-d', strtotime($_GET['search_pickup_date']))."&search_pickup_time=".$_GET['search_pickup_time']."&search_return_date=".date('Y-m-d', strtotime($search_return_dates))."&search_return_time=".$_GET['search_return_time']."&search_pickup_location=".$_GET['search_pickup_location']."&search_return_location=".$_GET['search_return_location']."&vehicle_status=active&search_driver=MY&btn_search=#"); 
		}
		else if($license_validity == 'invalid')
		{
			echo '<script> alert("License expiry is in between rental period, could not proceed.")</script>'; 
		}
		else
		{

			$coupon = $_POST['coupon'];
			$subtotal = $_POST['subtotal'];
			$est_total = $_POST['est_total'];
			$Discount = $_POST['discount'];
			$agent_profit = $_POST['agent_profit'];
			$agent_id = $_POST['agent_id'];
			$search_return_dates = $_GET['search_return_date'];

			func_setValid("Y"); 
			func_isEmpty($firstname, "first name"); 
			func_isEmpty($lastname, "last name"); 
			func_isEmpty($license_no, "license no"); 
			func_isEmpty($age, "age"); 
			func_isNum($age, "age"); 
			func_isEmpty($phone_no, "phone no"); 
			func_isEmpty($postcode, "postcode"); 
			func_isEmpty($city, "city"); 
			func_isEmpty($country, "country"); 
			func_isEmpty($payment_amount, "payment amount"); 
			func_isEmpty($ref_name, "reference name"); 
			func_isEmpty($ref_relationship, "reference relationship"); 
			func_isEmpty($ref_address, "reference address"); 
			func_isEmpty($ref_phoneno, "reference phone no"); 
			func_isNum($payment_amount, "payment amount"); 
			func_isEmpty($refund_dep_status, "refund dep status"); 
			func_isEmpty($refund_dep_payment, "refund dep payment"); 

			
		    if (func_isValid()) 
		    {
		    	// echo "<script> alert('masuk valid'); </script>";

			    $sql = "SELECT nric_no FROM customer WHERE nric_no = '$nric_no'";

				db_select($sql);

				if(db_rowcount() > 0)
				{
					$ic = "exist";
					if($drv_license_exp != '' && $drv_license_exp != NULL)
				    {
				     	$drv_license_exp = date('Y-m-d', strtotime($drv_license_exp));
				    }

				    $sql = "UPDATE customer SET 
				     		firstname = '" . conv_text_to_dbtext3($firstname) . "',
				     		lastname = '" . conv_text_to_dbtext3($lastname) . "',
				     		license_no = '" . conv_text_to_dbtext3($license_no) . "',
				     		license_exp = '" . conv_text_to_dbtext3($license_exp) . "',
				     		age = '" . $age . "',
				     		phone_no = '" . conv_text_to_dbtext3($phone_no) . "',
				     		phone_no2 = '" . conv_text_to_dbtext3($phone_no2) . "',
				     		email = '" . conv_text_to_dbtext3($email) . "',
				     		address = '" . conv_text_to_dbtext3($address) . "',
				     		address = '" . conv_text_to_dbtext3($address) . "',
				     		postcode = '" . conv_text_to_dbtext3($postcode) . "',
				     		city = '" . conv_text_to_dbtext3($city) . "',
				     		country = '" . conv_text_to_dbtext3($country) . "',
				     		status = '" . conv_text_to_dbtext3($status) . "',
				     		cid = '" . $_SESSION['cid'] . "',
				     		cdate = '".date('Y-m-d H:i:s',time())."',
				     		ref_name = '" . conv_text_to_dbtext3($ref_name) . "',
				     		ref_phoneno = '" . conv_text_to_dbtext3($ref_phoneno) . "',
				     		ref_relationship = '" . conv_text_to_dbtext3($ref_relationship) . "',
				     		ref_address = '" . conv_text_to_dbtext3($ref_address) . "',
				     		drv_name = '" . conv_text_to_dbtext3($drv_name) . "',
				     		drv_nric = '" . conv_text_to_dbtext3($drv_nric) . "',
				     		drv_address = '" . conv_text_to_dbtext3($drv_address) . "',
				     		drv_phoneno = '" . conv_text_to_dbtext3($drv_phoneno) . "',
				     		drv_license_no = '" . conv_text_to_dbtext3($drv_license_no) . "',
				     		drv_license_exp = '" . $drv_license_exp . "',
				     		survey_type = '" . $survey_type . "',
				     		survey_details = '" . conv_text_to_dbtext3($survey_details) . "'
				     		where nric_no = '$nric_no'";

					db_update($sql); 

					$sql = "SELECT id FROM customer where nric_no = '$nric_no'"; 

					db_select($sql); 

					if (db_rowcount() > 0) 
					{

						$dbcustomer_id = db_get(0, 0); 
					}
				}
				else
				{
					$ic = "not exist";

				    	$sql = "INSERT INTO customer
						(
						title,
						firstname,
						lastname,
						nric_no,
						license_no,
						license_exp,
						age,
						phone_no,
						phone_no2,
						email,
						address,
						postcode,
						city,
						country,
						status,
						cid,
						cdate,
						ref_name,
						ref_phoneno,
						ref_relationship,
						ref_address,
						drv_name,
						drv_nric,
						drv_address,
						drv_phoneno,
						drv_license_no,
						drv_license_exp,
						survey_type,
						survey_details
						)
						VALUES
						(
						'" . conv_text_to_dbtext3($title) . "',
						'" . conv_text_to_dbtext3($firstname) . "',
						'" . conv_text_to_dbtext3($lastname) . "',
						'" . conv_text_to_dbtext3($nric_no) . "',
						'" . conv_text_to_dbtext3($license_no) . "',
						'" . $license_exp . "',
						" . $age . ",
						'" . conv_text_to_dbtext3($phone_no) . "',
						'" . conv_text_to_dbtext3($phone_no2) . "',
						'" . conv_text_to_dbtext3($email) . "',
						'" . conv_text_to_dbtext3($address) . "',
						'" . conv_text_to_dbtext3($postcode) . "',
						'" . conv_text_to_dbtext3($city) . "',
						'" . conv_text_to_dbtext3($country) . "',
						'A',
						" . $_SESSION['cid'] . ",
						'".date('Y-m-d H:i:s',time())."',
						'" . conv_text_to_dbtext3($ref_name) . "',
						'" . conv_text_to_dbtext3($ref_phoneno) . "',
						'" . conv_text_to_dbtext3($ref_relationship) . "',
						'" . conv_text_to_dbtext3($ref_address) . "',
						'" . conv_text_to_dbtext3($drv_name) . "',
						'" . conv_text_to_dbtext3($drv_nric) . "',
						'" . conv_text_to_dbtext3($drv_address) . "',
						'" . conv_text_to_dbtext3($drv_phoneno) . "',
						'" . conv_text_to_dbtext3($drv_license_no) . "',
						'" . $drv_license_exp . "',
						'$survey_type',
						'" . conv_text_to_dbtext3($survey_details) . "'
						)
						"; 

					db_update($sql); 

					// $sql = "SELECT LAST_INSERT_ID() FROM customer"; 

					// db_select($sql); 

					// if (db_rowcount() > 0) 
					// {

						$dbcustomer_id = mysqli_insert_id($con); 
					// }
				}

				if(isset($_FILES['identity_photo'])){ 

					foreach($_FILES['identity_photo']['tmp_name'] as $key => $tmp_name ){ 

						if($key == 0) {
							
							$file_name = $dbcustomer_id."-identity_photo_front.jpg"; 
						} 
						else if($key == 1) {

							$file_name = $dbcustomer_id."-identity_photo_back.jpg"; 
						} 
						else if($key == 2) {
							
							$file_name = $dbcustomer_id."-utility_photo.jpg"; 
						} 
						else if($key == 3) {
							
							$file_name = $dbcustomer_id."-working_photo.jpg"; 
						}

						$file_size =$_FILES['identity_photo']['size'][$key]; 

						$file_tmp =$_FILES['identity_photo']['tmp_name'][$key]; 

						$file_type=$_FILES['identity_photo']['type'][$key]; 

						$sql = "SELECT * FROM customer WHERE id = '$dbcustomer_id'";

		                db_select($sql);

		                if(db_rowcount()>0) {

		                	if($key == 0) {

			                	$sql = "UPDATE customer SET identity_photo_front = '$file_name' WHERE id = '$dbcustomer_id'";
		                	} 
		                	else if($key == 1) {

			                	$sql = "UPDATE customer SET identity_photo_back = '$file_name' WHERE id = '$dbcustomer_id'";
		                	} 
		                	else if($key == 2) {

			                	$sql = "UPDATE customer SET utility_photo = '$file_name' WHERE id = '$dbcustomer_id'";
		                	} 
		                	else if($key == 3) {

			                	$sql = "UPDATE customer SET working_photo = '$file_name' WHERE id = '$dbcustomer_id'";
		                	}
		                }

		                db_update($sql); 
						// echo "<br>file_name: ".$file_name;
						// echo "<br>$key ----- sql: ".$sql;

						$desired_dir="assets/img/customer";

						if(is_dir($desired_dir)==false){ 

							mkdir("$desired_dir", 0700); 

						} 

						if(is_dir("$desired_dir/".$file_name)==false){ 

							move_uploaded_file($file_tmp,"$desired_dir/".$file_name); 
						}

		                else{ 

		                  $new_dir="$desired_dir/".$file_name.time(); 

		                  rename($file_tmp,$new_dir) ; 
		                } 
	              	}
	            }

			    $sql ="SELECT availability FROM vehicle WHERE id =" . $_GET['vehicle_id'];
			    db_select($sql);

				if(db_get(0,0) == 'Available')
				{

					$sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $_GET['vehicle_id']; 
					db_update($sql);
				}


				if ($_GET['pickup_cost'] >= 1) 
				{

					$sql = "INSERT INTO booking_trans
				   (
				   pickup_date,
				   pickup_location,
				   pickup_time,
				   return_date,
				   return_location,
				   return_time,
				   option_rental_id,
				   cdw,
				   discount_coupon,
				   discount_amount,
				   vehicle_id,
				   day,
				   sub_total,
				   payment_details,
				   est_total,
				   customer_id,
				   created,
				   refund_dep,
				   type,
				   balance,
				   p_cost,
				   p_address,
				   p_address2,
				   agent_id,
				   available,
				   branch,
				   staff_id
				   )
				   VALUES
				   (
				   '" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']. "',
				   '$search_pickup_location',
				   '$search_pickup_time',
				   '" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
				   '$search_return_location',
				   '".$_GET['search_return_time']."',
				   0,
				   0,
				   '$coupon',
				   '$Discount',
				   " . $_GET['vehicle_id'] . ",
				   '$day',
				   '$subtotal',
				   '$payment_details',
				   '$est_total',
				   '$dbcustomer_id',
				   '".date('Y-m-d H:i:s',time())."',
				   '$deposit',
				   '$refund_dep_payment',
				   '$refund_dep_status',
				   0,
				   '$payment_amount',
				   " . $_GET['pickup_cost'] . ",
				   '" . conv_text_to_dbtext3($_GET['p_pickup_address']) . "',
				   '" . conv_text_to_dbtext3($_GET['r_pickup_address']) . "',
				   '$agent_id',
				    'Booked',
				   '".$_SESSION['user_branch']."',
				   '".$_SESSION['cid']."'
				   ),
				   ";
			   } 
			   else if ($_GET['delivery_cost'] >= 1) 
			   { 

				   	$sql = "INSERT INTO booking_trans
				   (
				   pickup_date,
				   pickup_location,
				   pickup_time,
				   return_date,
				   return_location,
				   return_time,
				   option_rental_id,
				   cdw,
				   discount_coupon,
				   discount_amount,
				   vehicle_id,
				   day,
				   sub_total,
				   payment_details,
				   est_total,
				   customer_id,
				   created,
				   refund_dep,
				   type,
				   balance,
				   r_cost,
				   r_address,
				   r_address2,
				   agent_id,
				   available,
				   branch,
				   staff_id
				   )
				   VALUES
				   (
				   '" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].':00'.  "',
				   '$search_pickup_location',
				   '$search_pickup_time',
				   '" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
				   '$search_return_location',
				   '".$_GET['search_return_time']."',
				   0,
				   0,
				   '$coupon',
				   '".$Discount."',
				   " . $_GET['vehicle_id'] . ",
				   '$day',
				   '$subtotal',
				   '$payment_details',
				   '$est_total',
				   '$dbcustomer_id',
				   '".date('Y-m-d H:i:s',time())."',
				   '$deposit',
				   '$refund_dep_payment',
				   '$refund_dep_status',
				   0,
				   '$payment_amount',
				   " . $_GET['delivery_cost'] . ",
				   '" . conv_text_to_dbtext3($_GET['p_delivery_address']) . "',
				   '" . conv_text_to_dbtext3($_GET['r_delivery_address']) . "',
				   '$agent_id',
				   'Booked',
				   '".$_SESSION['user_branch']."',
				   '".$_SESSION['cid']."'
				   )
				   "; 
			   }
			   else 
			   { 
			       
			       $sql = "INSERT INTO booking_trans
				   (
				   pickup_date,
				   pickup_location,
				   pickup_time,
				   return_date,
				   return_location,
				   return_time,
				   option_rental_id,
				   cdw,
				   discount_coupon,
				   discount_amount,
				   vehicle_id,
				   day,
				   sub_total,
				   payment_details,
				   est_total,
				   customer_id,
				   created,
				   refund_dep,
				   refund_dep_payment,
				   refund_dep_status,
				   type,
				   balance,
				   agent_id,
				   available,
				   branch,
				   staff_id
				   )
				   VALUES
				   (
				   '" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
				   '$search_pickup_location',
				   '$search_pickup_time',
				   '" .date('Y-m-d', strtotime($search_return_dates))." ".$_GET['search_return_time']."',
				   '$search_return_location',
				   '".$_GET['search_return_time']."',
				   0,
				   0,
				   '$coupon',
				   '".$Discount."',
				   " . $_GET['vehicle_id'] . ",
				   '$day',
				   '$subtotal',
				   '$payment_details',
				   '$est_total',
				   '$dbcustomer_id',
				   '".date('Y-m-d H:i:s',time())."',
				   '$deposit',
				   '$refund_dep_payment',
				   '$refund_dep_status',
				   0,
				   '$payment_amount',
				   '$agent_id',
				   'Booked',
				   '".$_SESSION['user_branch']."',
				   '".$_SESSION['cid']."'
				   )
				   ";
				}

				db_update($sql); 

				// echo "<br> sql 853: ".$sql;

				// $sql = "SELECT LAST_INSERT_ID() FROM booking_trans"; 
				// db_select($sql); 

				// if (db_rowcount() > 0) {

					$booking_id = mysqli_insert_id($con);
				// }

				// echo "<br>863) Booking id: ".$booking_id;

				$sql = "SELECT id, description, initial from location WHERE description = '" . $_SESSION['user_branch']."'";

		         db_select($sql);

		 	     if (db_rowcount() > 0) {

			 	     // $pickup_location = db_get(0, 1);

			 	     $pickup_initial = db_get(0, 2);
		    	}

		 	    if($agent==''){

		 	      	$agent='000';
		 	    }

		 	    if($booking_id<10){

		 	      	$agr_no='000'.$booking_id;
		 	    }

		 	    elseif ($booking_id<100) {
		 	      	
		 	      	$agr_no='00'.$booking_id;
		 	    }

		 	    elseif ($booking_id<1000) {
		 	      	
		 	      	$agr_no='0'.$booking_id;
		 	    }

		 	    elseif ($booking_id<10000) {
		 	      	
		 	      	$agr_no=$booking_id;
		 	    }

				$agreement_no=$pickup_initial.$agent.$mymonth.$myday.$agr_no;

				// echo $agreement_no;

				$sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;

		        db_update($sql);
		        // echo "<br>1118) masuk booking trans update pickup, agreement no: ".$agreement_no." booking id: ".$booking_id;

				$sql = "INSERT INTO checklist
					(
					booking_trans_id,
					car_out_sticker_p,
					car_out_child_seat,
					car_out_usb_charger,
					car_out_touch_n_go,
					car_out_smart_tag,
					car_add_driver,
					car_cdw,
					car_driver
					)
					VALUES
					(
					'$booking_id',
					'" . $_GET['checkStickerP'] . "',
					'" . $_GET['checkChildSeat'] . "',
					'" . $_GET['checkCharger'] . "',
					'" . $_GET['checkTouchnGo'] . "',
					'" . $_GET['checkSmartTag'] . "',
					'" . $_GET['checkAddDriver'] . "',
					'" . $_GET['checkCdw'] . "',
					'" . $_GET['checkDriver'] . "'
					)
					"; 

				db_update($sql);

				// echo "<script> alert('db deposit: ".$dbcar_rate_deposit."'); </script>";
				// echo "<script> alert('user deposit: ".$deposit."'); </script>";
			}

			if($agent_profit != '' && $agent_id != '')
			{
				$est_total = $subtotal - $agent_profit;

				$sql = "INSERT INTO agent_profit 
				(
					agent_id,
					booking_trans_id,
					amount,
					created,
					cid
				)
				VALUES
				(
					'$agent_id',
					'$booking_id',
					'$agent_profit',
					'".date('Y-m-d H:i:s',time())."',
					'".$_SESSION['cid']."'
				)";

				db_update($sql);
			}

			$sql = "INSERT INTO sale 
			(
				title,
				type,
				booking_trans_id,
				vehicle_id,
				total_day,
				deposit,
				payment_status,
				payment_type,
				pickup_date,
				return_date,
				staff_id,
				created
			)
			VALUES (
				'Booking Deposit in',
				'Booking',
				'$booking_id',
				'" . $_GET['vehicle_id'] . "',
				'$day',
				'$deposit',
				'$refund_dep_status',
				'$refund_dep_payment',
				'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
				'" . date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
				'".$_SESSION['cid']."',
				'".date('Y-m-d H:i:s',time())."'
			)";

			db_update($sql);

			echo '<script> alert("Successfully booking!")</script>'; 

			vali_redirect("mail.php?status=booking&booking_id=" . $booking_id); 
		}
	} 


	$sqlDis = "SELECT * FROM discount WHERE code='$coupon'";

	db_select($sqlDis);

	if (db_rowcount() > 0) {

		func_setSelectVar();
	}   

	$sql = "SELECT * FROM customer WHERE nric_no='$nric_no'";

	db_select($sql);

	if (db_rowcount() > 0) {

		func_setSelectVar();
	}   

	$customer_id = $id;






?>

	<body class="nav-md">
		<div class="container body">
	    	<div class="main_container">

	        	<?php include('_leftpanel.php'); ?>

	        	<?php include('_toppanel.php'); ?>

	        	 <script type="text/javascript">
					 	function change() {
							var select = document.getElementById("survey");
							var divv = document.getElementById("survey_details");
							var value = select.value;
							if (value == "Others") {
							    toAppend = "<div class='col-md-6'><div class='form-group'><label class='control-label'>Survey Details</label><input class='form-control' type='textbox' name='survey_details' value='<?php echo $survey_details; ?>' ></div></div>";
							    divv.innerHTML=toAppend; 
							    return;
							}
							if (value == "non") {
								toAppend = "<div class='col-md-6'><div class='form-group'></div></div>";divv.innerHTML = toAppend;  return;
								}
						}

						window.onload = function(){

							// Show the current tab, and add an "active" class to the button that opened the tab
							document.getElementById('btn_walkin').className += " active";
							document.getElementById('walkin').style.display = "block";
						}
						
						function openCity(evt, cityName) {
					 		// Declare all variables
							var i, tabcontent, tablinks;

							// Get all elements with class="tabcontent" and hide them
							tabcontent = document.getElementsByClassName("tabcontent");
							for (i = 0; i < tabcontent.length; i++) {
								tabcontent[i].style.display = "none";
							}

							// Get all elements with class="tablinks" and remove the class "active"
							tablinks = document.getElementsByClassName("tablinks");
							for (i = 0; i < tablinks.length; i++) {
								tablinks[i].className = tablinks[i].className.replace(" active", "");
							}

							// Show the current tab, and add an "active" class to the button that opened the tab
							document.getElementById(cityName).style.display = "block";
							evt.currentTarget.className += " active";
						}

					</script>
					<style>
						/* Style the tab */
						.tab {
						  overflow: hidden;
						  border: 1px solid #ccc;
						  background-color: #f1f1f1;
						}

						/* Style the buttons that are used to open the tab content */
						.tab button {
						  background-color: inherit;
						  float: left;
						  border: none;
						  outline: none;
						  cursor: pointer;
						  padding: 14px 16px;
						  transition: 0.3s;
						}

						/* Change background color of buttons on hover */
						.tab button:hover {
						  background-color: #ddd;
						}

						/* Create an active/current tablink class */
						.tab button.active {
						  background-color: #ccc;
						}

						/* Style the tab content */
						.tabcontent {
						  animation: fadeEffect 1s;
						  display: none;
						  padding: 6px 12px;
						  border: 1px solid #ccc;
						  border-top: none;
						}

						@keyframes fadeEffect {
						  from {opacity: 0;}
						  to {opacity: 1;}
						}
					</style>
					<style>
					  @-webkit-keyframes ring {
					    0% {
					      -webkit-transform: rotate(-15deg);
					      transform: rotate(-15deg);
					    }

					    2% {
					      -webkit-transform: rotate(15deg);
					      transform: rotate(15deg);
					    }

					    4% {
					      -webkit-transform: rotate(-18deg);
					      transform: rotate(-18deg);
					    }

					    6% {
					      -webkit-transform: rotate(18deg);
					      transform: rotate(18deg);
					    }

					    8% {
					      -webkit-transform: rotate(-22deg);
					      transform: rotate(-22deg);
					    }

					    10% {
					      -webkit-transform: rotate(22deg);
					      transform: rotate(22deg);
					    }

					    12% {
					      -webkit-transform: rotate(-18deg);
					      transform: rotate(-18deg);
					    }

					    14% {
					      -webkit-transform: rotate(18deg);
					      transform: rotate(18deg);
					    }

					    16% {
					      -webkit-transform: rotate(-12deg);
					      transform: rotate(-12deg);
					    }

					    18% {
					      -webkit-transform: rotate(12deg);
					      transform: rotate(12deg);
					    }

					    20% {
					      -webkit-transform: rotate(0deg);
					      transform: rotate(0deg);
					    }
					  }

					  @keyframes ring {
					    0% {
					      -webkit-transform: rotate(-15deg);
					      -ms-transform: rotate(-15deg);
					      transform: rotate(-15deg);
					    }

					    2% {
					      -webkit-transform: rotate(15deg);
					      -ms-transform: rotate(15deg);
					      transform: rotate(15deg);
					    }

					    4% {
					      -webkit-transform: rotate(-18deg);
					      -ms-transform: rotate(-18deg);
					      transform: rotate(-18deg);
					    }

					    6% {
					      -webkit-transform: rotate(18deg);
					      -ms-transform: rotate(18deg);
					      transform: rotate(18deg);
					    }

					    8% {
					      -webkit-transform: rotate(-22deg);
					      -ms-transform: rotate(-22deg);
					      transform: rotate(-22deg);
					    }

					    10% {
					      -webkit-transform: rotate(22deg);
					      -ms-transform: rotate(22deg);
					      transform: rotate(22deg);
					    }

					    12% {
					      -webkit-transform: rotate(-18deg);
					      -ms-transform: rotate(-18deg);
					      transform: rotate(-18deg);
					    }

					    14% {
					      -webkit-transform: rotate(18deg);
					      -ms-transform: rotate(18deg);
					      transform: rotate(18deg);
					    }

					    16% {
					      -webkit-transform: rotate(-12deg);
					      -ms-transform: rotate(-12deg);
					      transform: rotate(-12deg);
					    }

					    18% {
					      -webkit-transform: rotate(12deg);
					      -ms-transform: rotate(12deg);
					      transform: rotate(12deg);
					    }

					    20% {
					      -webkit-transform: rotate(0deg);
					      -ms-transform: rotate(0deg);
					      transform: rotate(0deg);
					    }
					  }

					  @-webkit-keyframes horizontal {
					    0% {
					      -webkit-transform: translate(0,0);
					      transform: translate(0,0);
					    }

					    6% {
					      -webkit-transform: translate(-5px,0);
					      transform: translate(-5px,0);
					    }

					    12% {
					      -webkit-transform: translate(0,0);
					      transform: translate(0,0);
					    }

					    18% {
					      -webkit-transform: translate(-5px,0);
					      transform: translate(-5px,0);
					    }

					    24% {
					      -webkit-transform: translate(0,0);
					      transform: translate(0,0);
					    }

					    30% {
					      -webkit-transform: translate(-5px,0);
					      transform: translate(-5px,0);
					    }

					    36% {
					      -webkit-transform: translate(0,0);
					      transform: translate(0,0);
					    }
					  }

					  @keyframes horizontal {
					    0% {
					      -webkit-transform: translate(0,0);
					      -ms-transform: translate(0,0);
					      transform: translate(0,0);
					    }

					    6% {
					      -webkit-transform: translate(-5px,0);
					      -ms-transform: translate(-5px,0);
					      transform: translate(-5px,0);
					    }

					    12% {
					      -webkit-transform: translate(0,0);
					      -ms-transform: translate(0,0);
					      transform: translate(0,0);
					    }

					    18% {
					      -webkit-transform: translate(-5px,0);
					      -ms-transform: translate(-5px,0);
					      transform: translate(-5px,0);
					    }

					    24% {
					      -webkit-transform: translate(0,0);
					      -ms-transform: translate(0,0);
					      transform: translate(0,0);
					    }

					    30% {
					      -webkit-transform: translate(-5px,0);
					      -ms-transform: translate(-5px,0);
					      transform: translate(-5px,0);
					    }

					    36% {
					      -webkit-transform: translate(0,0);
					      -ms-transform: translate(0,0);
					      transform: translate(0,0);
					    }
					  }

					  .faa-ring.animated,
					  .faa-ring.animated-hover:hover,
					  .faa-parent.animated-hover:hover > .faa-ring {
					    -webkit-animation: ring 4s ease infinite;
					    animation: ring 4s ease infinite;
					    transform-origin-x: 50%;
					    transform-origin-y: 0px;
					    transform-origin-z: initial;

					  }

					  .faa-horizontal.animated,
					  .faa-horizontal.animated-hover:hover,
					  .faa-parent.animated-hover:hover > .faa-horizontal {
					    -webkit-animation: horizontal 2s ease infinite;
					    animation: horizontal 2s ease infinite;
					  }

					</style>

	        	<!-- page content -->
				<div class="right_col" role="main">
					<div class="">
						<div class="page-title">
							<div class="title_left">
								<h3>Counter Reservation View</h3>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>NRIC No</h2>
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
										<br>
										<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
											<form method='POST' action="">
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no_main">NRIC No</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="number" class="form-control" placeholder="NRIC No" id="nric_no_main" name="nric_no" value="<?php if($_POST['nric_no'] =='' || $_POST['nric_no'] == NULL) { echo $_GET['nric_no']; } else{ echo $_POST['nric_no']; } ?>" <?php if($ic == "exist") { echo "readonly"; }?>>
														<br>
														<center><input type="submit" class="btn btn-warning" name="filter"></center>
													</div>
													<div class="col-md-1 col-sm-1 col-xs-1">
														<abbr title='Please ensure the NRIC No is correct'><i class="fa fa-info-circle"></i></abbr>
													</div>
												</div>
											</form>
											<div class="ln_solid"></div>
										</div>
									</div>
								</div>

								<?php 

									if(isset($filter)){

										$coupon_query = '';
										if($_GET['coupon_type'] != '' || $_GET['coupon_type'] != NULL)
										{
											$coupon_query = '&coupon_type='.$_GET['coupon_type'].'&coupon='.$_GET['coupon'];
										}
										else if($_GET['agent_id'] != '' || $_GET['agent_id'] != NULL)
										{
											$coupon_query = '&agent_id='.$_GET['agent_id'];
										}

										vali_redirect("counter_reservation_exist.php?vehicle_id=" . $_GET['vehicle_id'] . $coupon_query . "&date_initial=".$_GET['date_initial']."&search_pickup_date=" . $_GET['search_pickup_date'] . "&search_pickup_time=" . $_GET['search_pickup_time'] . "&search_return_date=" . $_GET['search_return_date'] . "&search_return_time=" . $_GET['search_return_time'] . "&search_pickup_location=" . $_GET['search_pickup_location'] . "&search_return_location=" . $_GET['search_return_location'] . "&class_id=" . $_GET['class_id'] . "&delivery_cost=" . $_GET['delivery_cost'] . "&p_delivery_address=" . $_GET['p_delivery_address'] . "&r_delivery_address=" . $_GET['r_delivery_address'] . "&pickup_cost=" . $_GET['pickup_cost'] . "&p_pickup_address=" . $_GET['p_pickup_address'] . "&r_pickup_address=" . $_GET['r_pickup_address']."&nric_no=".$_POST['nric_no']. "&checkAddDriver=" .$_GET['checkAddDriver']. "&checkCdw=" .$_GET['checkCdw']. "&checkStickerP=" .$_GET['checkStickerP']. "&checkTouchnGo=" .$_GET['checkTouchnGo']. "&checkDriver=" .$_GET['checkDriver']. "&checkCharger=" .$_GET['checkCharger']. "&checkSmartTag=" .$_GET['checkSmartTag']. "&checkChildSeat=" .$_GET['checkChildSeat']);
									}

								?>
								<div class="x_panel">
									<div class="x_title">
										<h2>Details</h2>
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
                        				<div class="container">
                        					<div class="">
                        						<div class='col-sm-4'>
                        							Base Rate
                        							<div class="form-group">
                        								<div class='input-group date col-md-12 col-sm-6 col-xs-12'>
                        									
                        									<?php 

                        										if($_GET['coupon_type'] == 'D')
                        										{

                        											$day_initial = dateDifference($search_pickup_date . " " . $search_pickup_time, $date_initial, '%a');
                        											$hour_initial = dateDifference($search_pickup_date . " " . $search_pickup_time, $date_initial, '%h');
                        											$day_added = dateDifference($date_initial, $search_return_dates, '%a');

                        											?>

		                        									<input class="form-control" value="<?php echo "$day_initial + $day_added Day(s), $hour_initial Hour(s)";  ?>" disabled>
		                        									<?php
                        										}
                        										else if($_GET['coupon_type'] == 'H')
                        										{

                        											$day_initial = dateDifference($search_pickup_date, $date_initial, '%a');
                        											$hour_initial = dateDifference($search_pickup_date . " " . $search_pickup_time, $date_initial, '%h');
                        											$hour_added = dateDifference($date_initial, $search_return_dates, '%h');

                        											?>

		                        									<input class="form-control" value="<?php echo "$day_initial Day(s), $hour_initial + $hour_added Hour(s)";  ?>" disabled>
		                        									<?php
                        										}
                        										else
                        										{
                        											?>
                        											<input class="form-control" value="<?php echo dateDifference($search_pickup_date .' ' . $search_pickup_time, $search_return_dates, '%a Day(s), %h Hour(s)'); ?>" disabled>
                        											<?php
                        										}
                        									?>
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
                        						<?php
                        							if($pickup_cost != '')
                        							{
	                    								?>
	                    								<div class='col-sm-4'>
	                    									Pickup Cost (MYR)
	                    									<div class="form-group">
	                    										<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
	                    											<input class="form-control" type="number" value="<?php echo $pickup_cost; ?>" name="pickup_cost" disabled>
	                    										</div>
	                    									</div>
	                    								</div>
	                    								<?php
                									}

									                else if($delivery_cost != '')
									                {

									                	?>
										                <div class='col-sm-4'>
										                    Delivery Cost (MYR)
										                    <div class="form-group">
										                        <div class='input-group date col-md-12 col-sm-6 col-xs-12' >
										                        	<?php echo $pickup_cost; ?>
										                            <input class="form-control" type="number" value="<?php echo $delivery_cost; ?>" name="delivery_cost" disabled>
										                            
										                        </div>
										                    </div>
										                </div>
									                	<?php
									            	} 
								            	?>
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
													Pickup Location
													<div class="form-group">
														<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
															<?php
																$sql = "SELECT id, description from location WHERE id=" . $_GET['search_pickup_location'];

																db_select($sql);

																if (db_rowcount() > 0) {

																	$pickup_location = db_get(0, 1);
																}
															?>
															<input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
														</div>
													</div>
												</div>
												<div class='col-sm-4'>
													Return Location
													<div class="form-group">
														<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
															<?php
																$sql = "SELECT id, description from location WHERE id=" . $_GET['search_return_location']; db_select($sql);
																if (db_rowcount() > 0) 
																{
																	$return_location = db_get(0, 1);
																}
															?>
															<input class="form-control" value="<?php echo $return_location; ?>" disabled>
														</div>
													</div>
												</div>
												<div class='col-sm-4'>
													Pickup Date & Time
													<div class="form-group">
														<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
															<input class="form-control" value="<?php echo date('d/m/Y', strtotime($_GET['search_pickup_date'])) . " - " . $_GET['search_pickup_time']; ?>" disabled>
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
																if ($coupontype == 'duration') 
																{ 
															?>
																	<input class="form-control" value="<?php echo date('d/m/Y', strtotime($_GET['search_return_date'])) . " - " . $return_time . " -> " . date('d/m/Y', strtotime($search_return_dates)) . " - " . date('H:i', strtotime($search_return_dates)); ?>" disabled>
															<?php
																} else {
															?>
																<input class="form-control" value="<?php echo date('d/m/Y', strtotime($search_return_dates)) . " - " . date('H:i', strtotime($search_return_dates)); ?>" disabled>
															<?php 
																}
															?>
														</div>
													</div>
												</div>
												<?php
												if($_GET['coupon_type'] != '' || $_GET['coupon_type'] != NULL)
												{
													echo "
														<div class='col-sm-4'>
															Coupon
															<div class='form-group'>
																<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																	<input type='text' class='form-control' value='".$_GET['coupon']."' disabled>
																</div>
															</div>
														</div>
													";
												}
												if($_GET['agent_id'] != '' || $_GET['agent_id'] != NULL)
												{
													echo "
														<div class='col-sm-4'>
															Agent Name
															<div class='form-group'>
																<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																	<input type='text' class='form-control' value='".$agent_name."' disabled>
																</div>
															</div>
														</div>
													";
													echo "
														<div class='col-sm-4'>
															Agent Profit (RM)
															<div class='form-group'>
																<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
																	<input type='number' step='0.01' class='form-control' value='".number_format($agent_profit,2)."' disabled>
																</div>
															</div>
														</div>
													";
					            		
					            					if($agent_profit > 0)
					            					{
					            						$est_total = $est_total - $agent_profit;
					            					}
												} 
												?>
											</div>
										</div>
										<div class="ln_solid"></div>
									</div>
								</div>

								<?php 

									if(isset($license_update)) {

										$customer_id = $_POST['customer_id'];
										$license_exp = $_POST['license_exp'];

										$sql = "UPDATE customer SET license_exp = '$license_exp' WHERE id = '$customer_id'";
										
										db_update($sql);

										if(isset($_FILES['identity_photo']) || isset($_FILES['other_photo'])){ 

											foreach($_FILES['identity_photo']['tmp_name'] as $key => $tmp_name ){ 

												if($key == 0) {
													
													$file_name = $customer_id."-identity_photo_front.jpg"; 
												} 
												else if($key == 1) {
													
													$file_name = $customer_id."-identity_photo_back.jpg"; 
												}

												$file_size =$_FILES['identity_photo']['size'][$key]; 

												$file_tmp =$_FILES['identity_photo']['tmp_name'][$key]; 

												$file_type=$_FILES['identity_photo']['type'][$key]; 

												$sql = "SELECT * FROM customer WHERE id = '$customer_id'";

								                db_select($sql);

								                if(db_rowcount()>0) {

								                	if($key == 0) {

									                	$sql = "UPDATE customer SET identity_photo_front = '$file_name' WHERE id = '$customer_id'";
								                	} 
								                	else if($key == 1) {

									                	$sql = "UPDATE customer SET identity_photo_back = '$file_name' WHERE id = '$customer_id'";
								                	}
								                }

								                db_update($sql); 

												// echo "<br>file_name: ".$file_name;
												// echo "<br>$key ----- sql: ".$sql;

												$desired_dir="assets/img/customer";

												if(is_dir($desired_dir)==false){ 

													mkdir("$desired_dir", 0700); 
												} 

												if(is_dir("$desired_dir/".$file_name)==false){ 

													move_uploaded_file($file_tmp,"$desired_dir/".$file_name); 
												}

								                else{ 

								                  $new_dir="$desired_dir/".$file_name.time(); 

								                  rename($file_tmp,$new_dir) ; 
								                } 
							              	}

							              	if(isset($_FILES['other_photo'])) {


								              	foreach($_FILES['other_photo']['tmp_name'] as $key => $tmp_name ){ 

													if($key == 0) {
														
														$file_name = $customer_id."-utility_photo.jpg"; 
													} 
													else if($key == 1) {
														
														$file_name = $customer_id."-working_photo.jpg"; 
													}

													$file_size =$_FILES['other_photo']['size'][$key]; 

													$file_tmp =$_FILES['other_photo']['tmp_name'][$key]; 

													$file_type=$_FILES['other_photo']['type'][$key]; 

													$sql = "SELECT * FROM customer WHERE id = '$customer_id'";

									                db_select($sql);

									                if(db_rowcount()>0) {

									                	if($key == 0) {

										                	$sql = "UPDATE customer SET utility_photo = '$file_name' WHERE id = '$customer_id'";
									                	} 
									                	else if($key == 1) {

										                	$sql = "UPDATE customer SET working_photo = '$file_name' WHERE id = '$customer_id'";
									                	}
									                }

									                db_update($sql); 
													// echo "<br>file_name: ".$file_name;
													// echo "<br>$key ----- sql: ".$sql;

													$desired_dir="assets/img/customer";

													if(is_dir($desired_dir)==false){ 

														mkdir("$desired_dir", 0700); 
													} 

													if(is_dir("$desired_dir/".$file_name)==false){ 

														move_uploaded_file($file_tmp,"$desired_dir/".$file_name); 
													}

									                else{ 

									                  $new_dir="$desired_dir/".$file_name.time(); 

									                  rename($file_tmp,$new_dir) ; 
									                }
								              	}
							              	}
							            }
									}

									if($license_exp < $search_return_date && $license_exp != NULL && $license_no != NULL) { 
								?>

								<div class="x_panel">
									<div class="x_title">
										<h1><i class="fa fa-arrow-circle-o-right" style="color: red;"> License Expired</i></h1>
										<div class="clearfix"></div>
									</div>
                        			<form id="demo-form2" enctype="multipart/form-data" name="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">
										<div class="x_title">
											<h2>Customer Information</h2>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
											<br>
											<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

        										<input class="form-control" type="hidden" name="coupon" value="<?php echo $coupon; ?>"><br>
		                        				<input class="form-control" type="hidden" name="discount" value="<?php echo $Discount; ?>"><br>
		                        				<input class="form-control" type="hidden" value="<?php echo $est_total; ?>" name="est_total"><br>
		                        				<input class="form-control" type="hidden" value="<?php echo $subtotal;?>" name="subtotal" id="subtotal">
		                        				<input class="form-control" type="hidden" value="<?php echo $agent_profit;?>" name="agent_profit" id="agent_profit">
		                        				<input class="form-control" type="hidden" value="<?php echo $agent_id;?>" name="agent_id" id="agent_id">
		                        				<input class="form-control" type="hidden" value="<?php echo $customer_id;?>" name="customer_id" id="customer_id">
		                						
		                						<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="text" class="form-control" placeholder="NRIC No" id="nric_no" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)" disabled>
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_no">License Number</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" id="license_no" disabled>
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_exp">License Expired <font color="red">*</font></label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="date" class="form-control" placeholder="License Expired" name="license_exp" value="<?php echo $license_exp; ?>" id="license_exp" required>
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (front)</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="file" class="btn btn-control" name="identity_photo[]" required>
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (back)</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="file" class="btn btn-control" name="identity_photo[]" required>
													</div>
												</div>

												<?php
													if($utility_photo == NULL || $working_photo == NULL) {

														?>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12">Utility Photo (Optional)</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input type="file" class="btn btn-control" name="other_photo[]">
															</div>
														</div>

														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12">Working Photo (Optional)</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input type="file" class="btn btn-control" name="other_photo[]">
															</div>
														</div>
														<?php														
													}
												?>

												<div class="form-group" style="text-align: center;">
													<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
														<button type="submit" name="license_update" class="btn btn-success">Submit</button>
													</div>
												</div>
		                					</div>
		                				</div>
		                			</form>
		                		</div>

		                        <?php } else { ?>

								<div class="tab">
									<button style="" id="btn_walkin" class="tablinks" onclick="openCity(event, 'walkin')">Walk in</button>
									<button style="" id="btn_booking" class="tablinks" onclick="openCity(event, 'Booking')">Booking</button>
								</div>

									<!-- Tab content -->
								<div id="walkin" class="tabcontent">

									<div class="x_panel">
										<div class="x_title">
											<h1><i class="fa fa-arrow-circle-o-right" style="color: green;"> Walk in</i></h1>
											<div class="clearfix"></div>
										</div>
	                        			<form id="walkin_form" enctype="multipart/form-data" name="walkin_form" data-parsley-validate class="form-horizontal form-label-left" method="POST">
											<div class="x_title">
												<h2>Customer Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

													<div class="form-group">
			                							<div class="col-md-9 col-sm-9 col-xs-12">
			                								<div class="radio">
			                									<label>
			                										<input class="form-control" type="hidden" name="coupon" value="<?php echo $coupon; ?>"><br>
							                        				<input class="form-control" type="hidden" name="discount" value="<?php echo $Discount; ?>"><br>
							                        				<input class="form-control" type="hidden" value="<?php echo $est_total; ?>" name="est_total"><br>
							                        				<input class="form-control" type="hidden" value="<?php echo $subtotal;?>" name="subtotal" id="subtotal">
							                        				<input class="form-control" type="hidden" value="<?php echo $agent_profit;?>" name="agent_profit" id="agent_profit">
							                        				<input class="form-control" type="hidden" value="<?php echo $agent_id;?>" name="agent_id" id="agent_id">
			                									</label>
			                								</div>
			                							</div>
			                						</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="NRIC No" id="nric_no" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)" disabled>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="title" class="form-control" id="title">
																<option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
																<option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
																<option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>
															</select>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" value="<?php echo $firstname; ?>" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" value="<?php echo $lastname; ?>" id="lastname" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Driver's Age</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>" id="age" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_no">Phone No 1</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Phone No" name="phone_no" value="<?php echo $phone_no; ?>" id="phone_no" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_no2">Phone No 2<br><i>(Optional)</i></label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Phone No 2" name="phone_no2" value="<?php echo $phone_no2; ?>" id="phone_no2">
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" id="email">
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_no">License Number</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" id="license_no" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_exp">License Expired</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="date" class="form-control" placeholder="License Expired" name="license_exp" value="<?php echo $license_exp; ?>" id="license_exp" required>
														</div>
													</div>
													<?php
														if($firstname != NULL && $identity_photo_front != NULL) {

															?>
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (front)</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<img src="assets/img/customer/<?php echo $identity_photo_front.'?nocache='. time(); ?>" style="height:190px;">
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (back)</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<img src="assets/img/customer/<?php echo $identity_photo_back.'?nocache='. time(); ?>" style="height:190px;">
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">Utility Photo</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<img src="assets/img/customer/<?php echo $utility_photo.'?nocache='. time(); ?>" style="height:190px;">
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">Working Photo</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<img src="assets/img/customer/<?php echo $working_photo.'?nocache='. time(); ?>" style="height:190px;">
																</div>
															</div>

															<?php
														
														} else {

															?>
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (front)</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="file" class="btn btn-control" name="identity_photo[]" required>
																</div>
															</div>
															
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (back)</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="file" class="btn btn-control" name="identity_photo[]" required>
																</div>
															</div>
															
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">Utility Bills (Optional)</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="file" class="btn btn-control" name="identity_photo[]">
																</div>
															</div>
															
															<div class="form-group">
																<label class="control-label col-md-3 col-sm-3 col-xs-12">Working Card (Optional)</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="file" class="btn btn-control" name="identity_photo[]">
																</div>
															</div>
															
															<?php
														}
													?>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $address; ?>" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postcode">Postcode</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="number" class="form-control" placeholder=" Postcode" name="postcode" value="<?php echo $postcode; ?>" id="postcode" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">State</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="city" class="form-control" id="city" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Perlis' == $city, 'Selected', ''); ?> value='Perlis'>Perlis</option>
																<option <?php echo vali_iif('Kedah' == $city, 'Selected', ''); ?> value='Kedah'>Kedah</option>
																<option <?php echo vali_iif('Pulau Pinang' == $city, 'Selected', ''); ?> value='Pulau Pinang'>Pulau Pinang</option>
																<option <?php echo vali_iif('Perak' == $city, 'Selected', ''); ?> value='Perak'>Perak</option>
																<option <?php echo vali_iif('Selangor' == $city, 'Selected', ''); ?> value='Selangor'>Selangor</option>
																<option <?php echo vali_iif('Wilayah Persekutuan Kuala Lumpur' == $city, 'Selected', ''); ?> value='Wilayah Persekutuan Kuala Lumpur'>Wilayah Persekutuan Kuala Lumpur</option>
																<option <?php echo vali_iif('Wilayah Persekutuan Putrajaya' == $city, 'Selected', ''); ?> value='Wilayah Persekutuan Putrajaya'>Wilayah Persekutuan Putrajaya</option>
																<option <?php echo vali_iif('Melaka' == $city, 'Selected', ''); ?> value='Melaka'>Melaka</option>
																<option <?php echo vali_iif('Negeri Sembilan' == $city, 'Selected', ''); ?> value='Negeri Sembilan'>Negeri Sembilan</option>
																<option <?php echo vali_iif('Johor' == $city, 'Selected', ''); ?> value='Johor'>Johor</option>
																<option <?php echo vali_iif('Pahang' == $city, 'Selected', ''); ?> value='Pahang'>Pahang</option>
																<option <?php echo vali_iif('Terengganu' == $city, 'Selected', ''); ?> value='Terengganu'>Terengganu</option>
																<option <?php echo vali_iif('Kelantan' == $city, 'Selected', ''); ?> value='Kelantan'>Kelantan</option>
																<option <?php echo vali_iif('Sabah' == $city, 'Selected', ''); ?> value='Sabah'>Sabah</option>
																<option <?php echo vali_iif('Sarawak' == $city, 'Selected', ''); ?> value='Sarawak'>Sarawak</option>
															</select>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select ui-jq="chosen" name="country" class="form-control" id="country" required>
																<optgroup label="Alaskan/Hawaiian Time Zone">
																	<option value="AK">Alaska</option>
																	<option value="HI">Hawaii</option>
																	<option value="MY" selected>Malaysia</option>
																</optgroup>

																<optgroup label="Pacific Time Zone">
																	<option value="CA">California</option>
																	<option value="NV">Nevada</option>
																	<option value="OR">Oregon</option>
																	<option value="WA">Washington</option>
																</optgroup>
																	
																<optgroup label="Mountain Time Zone">
																	<option value="AZ">Arizona</option>
																	<option value="CO">Colorado</option>
																	<option value="ID">Idaho</option>
																	<option value="MT">Montana</option>
																	<option value="NE">Nebraska</option>
																	<option value="NM">New Mexico</option>
																	<option value="ND">North Dakota</option>
																	<option value="UT">Utah</option>
																	<option value="WY">Wyoming</option>
																</optgroup>
																	
																<optgroup label="Central Time Zone">
																	<option value="AL">Alabama</option>
																	<option value="AR">Arkansas</option>
																	<option value="IL">Illinois</option>
																	<option value="IA">Iowa</option>
																	<option value="KS">Kansas</option>
																	<option value="KY">Kentucky</option>
																	<option value="LA">Louisiana</option>
																	<option value="MN">Minnesota</option>
																	<option value="MS">Mississippi</option>
																	<option value="MO">Missouri</option>
																	<option value="OK">Oklahoma</option>
																	<option value="SD">South Dakota</option>
																	<option value="TX">Texas</option>
																	<option value="TN">Tennessee</option>
																	<option value="WI">Wisconsin</option>
																</optgroup>
																	
																<optgroup label="Eastern Time Zone">
																	<option value="CT">Connecticut</option>
																	<option value="DE">Delaware</option>
																	<option value="FL">Florida</option>
																	<option value="GA">Georgia</option>
																	<option value="IN">Indiana</option>
																	<option value="ME">Maine</option>
																	<option value="MD">Maryland</option>
																	<option value="MA">Massachusetts</option>
																	<option value="MI">Michigan</option>
																	<option value="NH">New Hampshire</option>
																	<option value="NJ">New Jersey</option>
																	<option value="NY">New York</option>
																	<option value="NC">North Carolina</option>
																	<option value="OH">Ohio</option>
																	<option value="PA">Pennsylvania</option>
																	<option value="RI">Rhode Island</option>
																	<option value="SC">South Carolina</option>
																	<option value="VT">Vermont</option>
																	<option value="VA">Virginia</option>
																	<option value="WV">West Virginia</option>
																</optgroup>
																	
															</select>
														</div>
													</div>
													<div class="ln_solid"></div>
												</div>
											</div>
										
										<!-- start edit -->

										<?php

										if($_GET['checkAddDriver']=="Y"){

										?>
										
										<div class="x_panel">
											<div class="x_title">
												<h2>Additional Driver Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_name">Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Name" name="drv_name" value="<?php echo $drv_name; ?>" id="drv_name">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_nric">NRIC No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="IC No. / Passport" name="drv_nric" value="<?php echo $drv_nric; ?>" id="drv_nric">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_address">Address</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input class="form-control" placeholder="Address" name="drv_address" value="<?php echo $drv_address; ?>" id="drv_address">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_phoneno">Phone No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno" value="<?php echo $drv_phoneno; ?>" id="drv_phoneno">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_no">License No.</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input class="form-control" type="text" placeholder="License No." name="drv_license_no" id="drv_license_no" value="<?php echo $drv_license_no; ?>">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_exp">License Expired</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="date" class="form-control" name="drv_license_exp" placeholder="License Expired">
															<!-- <input type="text" class="form-control" name="drv_license_exp" id="single_cal2" placeholder="License Expired"> -->
														</div>
													</div>

													<div class="ln_solid"></div>
												</div>
											</div>
										</div>
										
										<?php
										
										}
										
										?>
										
										
										
											<div class="x_title">
												<h2>Reference Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_name">Reference Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Reference Name" name="ref_name" value="<?php echo $ref_name; ?>" id="ref_name" required>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_relationship">Reference Relationship</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Reference Relationship" name="ref_relationship" value="<?php echo $ref_relationship; ?>" id="ref_relationship" required>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_address">Reference Address</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input class="form-control" placeholder="Reference Address" name="ref_address" id="ref_address" value="<?php echo $ref_address; ?>" required>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_phoneno">Reference Phone No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Reference Phone No" name="ref_phoneno" value="<?php echo $ref_phoneno; ?>" id="ref_phoneno" required>
														</div>
													</div>

													<div class="ln_solid"></div>

												</div>
											</div>

										<div class="x_panel">
											
											<div class="x_title">
												<h2>Payment Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_amount">Payment Amount (MYR)</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $payment_amount; ?>" id="payment_amount" required>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_details">Payment Status</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="payment_details" id="payment_details" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Collect' == $payment_details, 'Selected', ''); ?> value='Collect'>Collect</option>
																<option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?> value='Cash'>Cash</option>
																<option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?> value='Online'>Online</option>
																<option <?php echo vali_iif('Card' == $payment_details, 'Selected', ''); ?> value='Card'>Card</option>
																<option <?php echo vali_iif('Nil' == $payment_details, 'Selected', ''); ?> value='Nil'>Nil</option>
																<option <?php echo vali_iif('Return' == $payment_details, 'Selected', ''); ?> value='Return'>Return</option>
																<option <?php echo vali_iif('Closing' == $payment_details, 'Selected', ''); ?> value='Closing'>Closing</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="deposit">Deposit (MYR)</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="deposit" id="deposit" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('0' == $deposit, 'Selected', ''); ?> value='0'>RM0</option>
																<option <?php echo vali_iif('50' == $deposit, 'Selected', ''); ?> value='50'>RM50</option>
																<option <?php echo vali_iif('100' == $deposit, 'Selected', ''); ?> value='100'>RM100</option>
																<option <?php echo vali_iif('200' == $deposit, 'Selected', ''); ?> value='200'>RM200</option>
																<option <?php echo vali_iif('300' == $deposit, 'Selected', ''); ?> value='300'>RM300</option>
																<option <?php echo vali_iif('400' == $deposit, 'Selected', ''); ?> value='400'>RM400</option>
																<option <?php echo vali_iif('500' == $deposit, 'Selected', ''); ?> value='500'>RM500</option>
																<option <?php echo vali_iif('600' == $deposit, 'Selected', ''); ?> value='600'>RM600</option>
															</select>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="refund_dep_status">Deposit Status</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="refund_dep_status" id="refund_dep_status" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Collect' == $refund_dep_status, 'Selected', ''); ?> value='Collect'>Collect</option>
																<option <?php echo vali_iif('Paid' == $refund_dep_status, 'Selected', ''); ?> value='Paid'>Paid</option>
															</select>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="refund_dep_payment">Deposit Type</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="refund_dep_payment" id="refund_dep_payment" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
																<option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
																<option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
															</select>
														</div>
													</div>

													<div class="ln_solid"></div>

												</div>
											</div>
										</div>

										<div class="x_panel">
											<div class="x_title">
												<h2>Survey</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="survey_type">Survey</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="survey_type" id="survey_type" class="form-control" onchange="change();" required>
																<option <?php echo vali_iif('Banner' == $survey_type, 'Selected', ''); ?> value='Banner'>Banner</option>
																<option <?php echo vali_iif('Bunting' == $survey_type, 'Selected', ''); ?> value='Bunting'>Bunting</option>
																<option <?php echo vali_iif('Facebook Ads' == $survey_type, 'Selected', ''); ?> value='Freinds'>Facebook Ads</option>
																<option <?php echo vali_iif('Friends' == $survey_type, 'Selected', ''); ?> value='Friends'>Friends</option>
																<option <?php echo vali_iif('Google Ads' == $survey_type, 'Selected', ''); ?> value='Google Ads'>Google Ads</option>
																<option <?php echo vali_iif('Magazine' == $survey_type, 'Selected', ''); ?> value='Magazine'>Magazine</option>
																<option <?php echo vali_iif('Others' == $survey_type, 'Selected', ''); ?> value='Others'>Others</option>
															</select>
														</div>
													</div>
													<div class="ln_solid"></div>

													<div class="form-group" style="text-align: center;">
														<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
															<button type="submit" name="btn_save_pickup" class="btn btn-success">Submit</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
									</div>
								</div>

								<div id="Booking" class="tabcontent">

                        			<form id="booking_form" enctype="multipart/form-data" name="booking_form" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                        				<div class="x_panel">
											<div class="x_title">
												<h1><i class="fa fa-arrow-circle-o-down" style="color: blue;"> Booking</i></h1>
												<div class="clearfix"></div>
											</div>
											<div class="x_title">
												<h2>Customer Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

													<div class="form-group">
			                							<div class="col-md-9 col-sm-9 col-xs-12">
			                								<div class="radio">
			                									<label>
			                										<input class="form-control" type="hidden" name="coupon" value="<?php echo $coupon; ?>"><br>
							                        				<input class="form-control" type="hidden" name="discount" value="<?php echo $Discount; ?>"><br>
							                        				<input class="form-control" type="hidden" value="<?php echo $est_total; ?>" name="est_total"><br>
							                        				<input class="form-control" type="hidden" value="<?php echo $subtotal;?>" name="subtotal" id="subtotal">
							                        				<input class="form-control" type="hidden" value="<?php echo $agent_profit;?>" name="agent_profit" id="agent_profit">
							                        				<input class="form-control" type="hidden" value="<?php echo $agent_id;?>" name="agent_id" id="agent_id">
			                									</label>
			                								</div>
			                							</div>
			                						</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no_booking">NRIC No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="NRIC No" id="nric_no_booking" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)" disabled>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title_booking">Title</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="title" class="form-control" id="title_booking">
																<option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
																<option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
																<option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>
															</select>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname_booking">First Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname_booking" value="<?php echo $firstname; ?>" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname_booking">Last Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lastname; ?>" id="lastname_booking" required>
														</div>
													</div>
												
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_booking">Driver's Age</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>" id="age_booking" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_no_booking">Phone No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Phone No" name="phone_no" value="<?php echo $phone_no; ?>" id="phone_no_booking" required>
														</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_booking">Email</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" id="email_booking">
														</div>
													</div>
													
													<div class="ln_solid"></div>
												</div>
											</div>
										</div>
									
										<!-- start edit -->

										<?php

										if($_GET['checkAddDriver']=="Y"){

										?>
										
										<div class="x_panel">
											<div class="x_title">
												<h2>Additional Driver Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_name_booking">Name</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Name" name="drv_name" value="<?php echo $drv_name; ?>" id="drv_name_booking">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_nric_booking">NRIC No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="IC No. / Passport" name="drv_nric" value="<?php echo $drv_nric; ?>" id="drv_nric_booking">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_address_booking">Address</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input class="form-control" placeholder="Address" name="drv_address" value="<?php echo $drv_address; ?>" id="drv_address_booking">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_phoneno_booking">Phone No</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno" value="<?php echo $drv_phoneno; ?>" id="drv_phoneno_booking">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_no_booking">License No.</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input class="form-control" type="text" placeholder="License No." name="drv_license_no" id="drv_license_no_booking" value="<?php echo $drv_license_no; ?>">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_exp_booking">License Expired</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="date" class="form-control" name="drv_license_exp" placeholder="License Expired" id="drv_license_exp_booking">
															<!-- <input type="text" class="form-control" name="drv_license_exp" id="single_cal2" placeholder="License Expired"> -->
														</div>
													</div>

													<div class="ln_solid"></div>
												</div>
											</div>
										</div>
										
										<?php
										
										}
										
										?>
										

										<div class="x_panel">
											
											<div class="x_title">
												<h2>Payment Information</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
													
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_amount_booking">Payment Amount (MYR)</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $payment_amount; ?>" id="payment_amount_booking" required>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_details_booking">Payment Status</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="payment_details" id="payment_details_booking" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Collect' == $payment_details, 'Selected', ''); ?> value='Collect'>Collect</option>
																<option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?> value='Cash'>Cash</option>
																<option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?> value='Online'>Online</option>
																<option <?php echo vali_iif('Card' == $payment_details, 'Selected', ''); ?> value='Card'>Card</option>
																<option <?php echo vali_iif('Nil' == $payment_details, 'Selected', ''); ?> value='Nil'>Nil</option>
																<option <?php echo vali_iif('Return' == $payment_details, 'Selected', ''); ?> value='Return'>Return</option>
																<option <?php echo vali_iif('Closing' == $payment_details, 'Selected', ''); ?> value='Closing'>Closing</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="deposit_booking">Deposit (MYR)</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="deposit" id="deposit_booking" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('0' == $deposit, 'Selected', ''); ?> value='0'>RM0</option>
																<option <?php echo vali_iif('50' == $deposit, 'Selected', ''); ?> value='50'>RM50</option>
																<option <?php echo vali_iif('100' == $deposit, 'Selected', ''); ?> value='100'>RM100</option>
																<option <?php echo vali_iif('200' == $deposit, 'Selected', ''); ?> value='200'>RM200</option>
																<option <?php echo vali_iif('300' == $deposit, 'Selected', ''); ?> value='300'>RM300</option>
																<option <?php echo vali_iif('400' == $deposit, 'Selected', ''); ?> value='400'>RM400</option>
																<option <?php echo vali_iif('500' == $deposit, 'Selected', ''); ?> value='500'>RM500</option>
																<option <?php echo vali_iif('600' == $deposit, 'Selected', ''); ?> value='600'>RM600</option>
															</select>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="refund_dep_status_booking">Deposit Type</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="refund_dep_status" id="refund_dep_status_booking" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Collect' == $refund_dep_status, 'Selected', ''); ?> value='Collect'>Collect</option>
																<option <?php echo vali_iif('Paid' == $refund_dep_status, 'Selected', ''); ?> value='Paid'>Paid</option>
															</select>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="refund_dep_payment_booking">Deposit Status</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="refund_dep_payment" id="refund_dep_payment_booking" class="form-control" required>
																<option value="">Please Select</option>
																<option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
																<option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
																<option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
															</select>
														</div>
													</div>

													<div class="ln_solid"></div>

												</div>
											</div>
										</div>

										<div class="x_panel">
											<div class="x_title">
												<h2>Survey</h2>
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
												<br>
												<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
													<div class="form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="survey_type_booking">Survey</label>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<select name="survey_type" id="survey_type_booking" class="form-control" onchange="change();" required>
																<option <?php echo vali_iif('Banner' == $survey_type, 'Selected', ''); ?> value='Banner'>Banner</option>
																<option <?php echo vali_iif('Bunting' == $survey_type, 'Selected', ''); ?> value='Bunting'>Bunting</option>
																<option <?php echo vali_iif('Facebook Ads' == $survey_type, 'Selected', ''); ?> value='Freinds'>Facebook Ads</option>
																<option <?php echo vali_iif('Friends' == $survey_type, 'Selected', ''); ?> value='Friends'>Friends</option>
																<option <?php echo vali_iif('Google Ads' == $survey_type, 'Selected', ''); ?> value='Google Ads'>Google Ads</option>
																<option <?php echo vali_iif('Magazine' == $survey_type, 'Selected', ''); ?> value='Magazine'>Magazine</option>
																<option <?php echo vali_iif('Others' == $survey_type, 'Selected', ''); ?> value='Others'>Others</option>
															</select>
														</div>
													</div>
													<div class="ln_solid"></div>

													<div class="form-group" style="text-align: center;">
														<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
															<button type="submit" name="btn_save_booking" class="btn btn-success">Submit</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
									<?php } ?>
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
	      </div>
	    </div>
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