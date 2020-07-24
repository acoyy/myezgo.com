<?php

require("../dashboard/lib/phpmailer/class.phpmailer.php");
$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array


function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

$agent=''; 



if($_SERVER['REQUEST_METHOD']=='POST'){

	$btn_save = $input["type"];

	//send Customer
	$vehicle_id = $input["id"];
	$nric_no = $input["icNumber"];
	$firstname = $input["fName"];
	$lastname = $input["lName"];
	$age = $input["age"];
	$phone_no = $input["phone_no"];
	$email = $input["email"];
	$userId =  $input["user_id"];
	$date_now =  $input["date_now"];
	$drv_name =  $input["addName"];
	$drv_nric =  $input["addNric"];
	$drv_address =  $input["addAddress"];
	$drv_phoneno =  $input["addPhoneNo"];
	$drv_license_no =  $input["addLicenseNo"];
	$date_license2 = str_replace('/', '-', $input["addLicenseExpired"]);
	$drv_license_exp = date('Y-m-d', strtotime($date_license2));
	$survey_type =  $input["surveyType"];
	$title =  $input["title"];
	$user_branch =  $input["branch"];
	$status = $input["user_status"];
	$deposit = $input["sendDeposit"];

	//send pickup details
	$pickup_cost = $input["pickup_cost"];
	$search_pickup_date = $input["pickup_date"];
	$search_pickup_location = $input["pickup_location"];
	$search_pickup_time = $input["pickup_time"];

	$date = str_replace('/', '-', $input["return_date"]);

	$search_return_date = date('Y-m-d', strtotime($date));

	$return_date = date('Y-m-d', strtotime($date));

	$search_return_location = $input["return_location"];
	$return_time = $input["return_time"];
	$p_pickup_address = $input["p_pickup_address"];
	$r_pickup_address = $input["r_pickup_address"];

	$delivery_cost = $input["delivery_cost"];
	$p_delivery_address = $input["p_delivery_address"];
	$r_delivery_address = $input["r_delivery_address"];

	$refund_dep_payment = $input["depositStatus"];
	$payment_amount = $input["payment_amount"];


	$checkAddDriver = $input["checkbox0"];
	$checkCdw = $input["checkbox1"];
	$checkStickerP = $input["checkbox2"];
	$checkTouchnGo = $input["checkbox3"];
	$checkDriver = $input["checkbox4"];
	$checkCharger = $input["checkbox5"];
	$checkSmartTag = $input["checkbox6"];
	$checkChildSeat = $input["checkbox7"];

	$coupon = $input["coupon_code"];
	$subtotal = $input["subTotal"];
	$est_total = $input["estTotal"];
	$Discount = $input["discount"];

	if($coupon != ""){

		$agent_profit = "";
		$agent_id = "";

	}

	else{

		$agent_profit = $input["agent_profit"];
		$agent_id = $input["agent_id"];

	}

	$return_date2 = date('m/d/Y', strtotime($return_date));

	$search_return_dates = date('m/d/Y H:i:s', strtotime("$return_date $return_time"));

	$payment_details = $input['payment_status'];

	$pickup_date = date('m/d/Y', strtotime($search_pickup_date));

	$day = dateDifference($pickup_date." ".$search_pickup_time, $return_date2." ".$return_time, '%a');

	$survey_details='';

	$mydate = date('m/d/Y', strtotime($search_pickup_date));
	$mymonth = date("m",strtotime($mydate));
	$myday = date("d",strtotime($mydate));
	$myyear = date("Y",strtotime($mydate));
	
//////////////////////////////////////////////////////

	// start filter reservation

	$sql = "SELECT * FROM booking_trans WHERE pickup_date='" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."' AND return_date='" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."' AND vehicle_id='$vehicle_id'";

		$query=mysqli_query($con,$sql);

		while ($row = mysqli_fetch_array($query)){

			$booking_id = $row['id'];

		}

        $rowCustomer=mysqli_num_rows($query);

        if($rowCustomer > 0){

		$response["status"] = 0;
		$response["message"] = "Already Reserved";
		$response["booking_id"] = $booking_id;

                
		}

		else{

	
			// start save booking

			if($btn_save == "btn_save_booking"){

				$sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $vehicle_id; 
				mysqli_query($con,$sql);

				$sql = "select nric_no from customer where nric_no = '$nric_no'";
				$query=mysqli_query($con,$sql);

				if(mysqli_num_rows($query) > 0){
					while ($row = mysqli_fetch_array($query)){

						$ic = "exist";
						if($drv_license_exp != '' && $drv_license_exp != NULL)
						{
							$drv_license_exp = date('Y-m-d', strtotime($drv_license_exp));
						}
						
						$sql = "UPDATE customer SET 
								firstname = '" . $firstname . "',
								lastname = '" . $lastname . "',
								age = '" . $age . "',
								phone_no = '" . $phone_no . "',
								email = '" . $email . "',
								status = 'A',
								mid = '" . $userId . "',
								mdate = '".date('Y-m-d H:i:s',time())."',
								drv_name = '" . $drv_name . "',
								drv_nric = '" . $drv_nric . "',
								drv_address = '" . $drv_address . "',
								drv_phoneno = '" . $drv_phoneno . "',
								drv_license_no = '" . $drv_license_no . "',
								drv_license_exp = '" . $drv_license_exp . "',
								survey_type = '" . $survey_type . "',
								survey_details = '" . $survey_details . "'
								where nric_no = '$nric_no'";
								
						mysqli_query($con,$sql);

						$sql = "SELECT id FROM customer where nric_no = '$nric_no'"; 

						$query=mysqli_query($con,$sql);

						while ($row = mysqli_fetch_array($query)){

							$dbcustomer_id = $row['id'];

							}

						}
					}

					else{

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
							'" . $title . "',
							'" . $firstname . "',
							'" . $lastname . "',
							'" . $nric_no . "',
							" . $age . ",
							'" . $phone_no . "',
							'" . $email . "',
							'A',
							" . $userId . ",
							'".date('Y-m-d H:i:s',time())."',
							'" . $drv_name . "',
							'" . $drv_nric . "',
							'" . $drv_address . "',
							'" . $drv_phoneno . "',
							'" . $drv_license_no . "',
							'" . $drv_license_exp . "',
							'$survey_type',
							'" . $survey_details . "'
							)
							"; 

							mysqli_query($con,$sql);

							$dbcustomer_id = mysqli_insert_id($con);

					}

					if ($pickup_cost >= 1) { 

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
							'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
						'$search_pickup_location',
						'$search_pickup_time',
						'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
						'$search_return_location',
						'".date('H:i', strtotime($search_return_dates))."',
						0,
						0,
						'$coupon',
						'".$Discount."',
						" . $vehicle_id . ",
						'$day',
						'$subtotal',
						'$payment_details',
						'$est_total',
						'$dbcustomer_id',
						'".date('Y-m-d H:i:s',time())."',
						'$deposit',
						'$refund_dep_payment',
						0,
						'$agent_id',
						'Booked',
						'$pickup_cost',
						'$p_pickup_address',
							'$r_pickup_address',
							'".$user_branch."',
							'".$userId."'
						)
						"; 

						mysqli_query($con,$sql);

					}

					elseif ($delivery_cost >= 1) { 

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
						'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
						'$search_pickup_location',
						'$search_pickup_time',
						'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
						'$search_return_location',
						'".date('H:i', strtotime($search_return_dates))."',
						0,
						0,
						'$coupon',
						'$Discount',
						" . $vehicle_id . ",
						'$day',
						'$subtotal',
						'$payment_details',
						'$est_total',
						'$dbcustomer_id',
						'".date('Y-m-d H:i:s',time())."',
						'$deposit',
						'$refund_dep_payment',
						0,
						'$delivery_cost',
						'$p_delivery_address',
						'$r_delivery_address',
						'$agent_id',
						'Booked',
						'".$user_branch."',
						'".$userId."'
						)
						"; 

					mysqli_query($con,$sql);
					// echo "<br>1360) masuk customer delivery cost booking";

				}

				else{

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
						type,
						agent_id,
						available,
						branch,
						staff_id
						)
						VALUES
						(
							'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
						'$search_pickup_location',
						'$search_pickup_time',
						'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
						'$search_return_location',
						'".date('H:i', strtotime($search_return_dates))."',
						0,
						0,
						'$coupon',
						'".$Discount."',
						" . $vehicle_id . ",
						'$day',
						'$subtotal',
						'$payment_details',
						'$est_total',
						'$dbcustomer_id',
						'".date('Y-m-d H:i:s',time())."',
						'$deposit',
						'$refund_dep_payment',
						0,
						'$agent_id',
						'Booked',
						'".$user_branch."',
							'".$userId."'
						)
						";

						mysqli_query($con,$sql);

				}


				$booking_id = mysqli_insert_id($con); 

				$sql = "SELECT id, description, initial from location WHERE description = '" . $user_branch."'";

				$query=mysqli_query($con,$sql);

				while ($row = mysqli_fetch_assoc($query)){

					$pickup_initial = $row['initial'];

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

				$sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;

				mysqli_query($con,$sql);

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
					'" . $checkStickerP . "',
					'" . $checkChildSeat . "',
					'" . $checkCharger . "',
					'" . $checkTouchnGo . "',
					'" . $checkSmartTag . "',
					'" . $checkAddDriver . "',
					'" . $checkCdw . "',
					'" . $checkDriver . "'
					)
					"; 

				mysqli_query($con,$sql);

			}

			// end save booking

			// start save pickup

			else if($btn_save == "btn_save_pickup"){

				$ref_name=$input["refName"];
				$ref_relationship=$input["refRelationship"];
				$ref_address=$input["refAddress"];
				$ref_phoneno=$input["refPhoneNo"];

				
				$date_license = str_replace('/', '-', $input["license_expired"]);
				$license_exp = date('Y-m-d', strtotime($date_license));

				
				$license_no = $input["license_no"];
				
				$phone_no2 = $input["phone_no2"];
				
				$address = $input["address"];
				$postcode = $input["post_code"];
				$city = $input["state"];
				$country = $input["country"];

				$sql ="SELECT availability FROM vehicle WHERE id =" . $vehicle_id;        
				$query=mysqli_query($con,$sql);

				while ($row = mysqli_fetch_array($query)){

					$available = $row['availability'];

				}

				if($available == 'Available'){

					$sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $vehicle_id; 
					mysqli_query($con,$sql);

				}

				$sql = "select nric_no from customer where nric_no = '$nric_no'";
				$query=mysqli_query($con,$sql);

				while ($row = mysqli_fetch_array($query)){

					$nric_no = $row['nric_no'];

				}

				$rowCustomer=mysqli_num_rows($query);

				if($rowCustomer > 0){

					$ic = "exist";

					if($drv_license_exp != '' && $drv_license_exp != NULL)
					{
							$drv_license_exp = date('Y-m-d', strtotime($drv_license_exp));
					}
					
					$sql = "UPDATE customer SET 
								firstname = '" . $firstname . "',
								lastname = '" . $lastname . "',
								license_no = '" . $license_no . "',
								license_exp = '" . $license_exp . "',
								age = '" . $age . "',
								phone_no = '" . $phone_no . "',
								phone_no2 = '" . $phone_no2 . "',
								email = '" . $email . "',
								address = '" . $address . "',
								postcode = '" . $postcode . "',
								city = '" . $city . "',
								country = '" . $country . "',
								status = '" . $status . "',
								cid = '" . $userId . "',
								cdate = '".date('Y-m-d H:i:s',time())."',
								ref_name = '" . $ref_name . "',
								ref_phoneno = '" . $ref_phoneno . "',
								ref_relationship = '" . $ref_relationship . "',
								ref_address = '" . $ref_address . "',
								drv_name = '" . $drv_name . "',
								drv_nric = '" . $drv_nric . "',
								drv_address = '" . $drv_address . "',
								drv_phoneno = '" . $drv_phoneno . "',
								drv_license_no = '" . $drv_license_no . "',
								drv_license_exp = '" . $drv_license_exp . "',
								survey_type = '" . $survey_type . "',
								survey_details = '" . $survey_details . "'
								where nric_no = '$nric_no'";
								
					mysqli_query($con,$sql);

					$sql = "SELECT id FROM customer where nric_no = '$nric_no'"; 
					$query=mysqli_query($con,$sql);

					$rowCustomer=mysqli_num_rows($query);

						if ($rowCustomer > 0) 
						{

							while ($rowCustomer = mysqli_fetch_assoc($query)){

								$dbcustomer_id = $rowCustomer['id'];
				
							}
							
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
						'" . $title . "',
						'" . $firstname . "',
						'" . $lastname . "',
						'" . $nric_no . "',
						'" . $license_no . "',
						'" . $license_exp . "',
						" . $age . ",
						'" . $phone_no . "',
						'" . $phone_no2 . "',
						'" . $email . "',
						'" . $address . "',
						'" . $postcode . "',
						'" . $city . "',
						'" . $country . "',
						'A',
						" . $userId . ",
						'".date('Y-m-d H:i:s',time())."',
						'" . $ref_name . "',
						'" . $ref_phoneno . "',
						'" . $ref_relationship . "',
						'" . $ref_address . "',
						'" . $drv_name . "',
						'" . $drv_nric . "',
						'" . $drv_address . "',
						'" . $drv_phoneno . "',
						'" . $drv_license_no . "',
						'" . $drv_license_exp . "',
						'$survey_type',
						'" . $survey_details . "'
						)
						"; 

					mysqli_query($con,$sql);

					$dbcustomer_id = mysqli_insert_id($con); 
						
				}

				//bebe

					if ($pickup_cost >= 1) 
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
					est_total,
					customer_id,
					created,
					refund_dep,
					refund_dep_payment,
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
						'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
					'$search_pickup_location',
					'$search_pickup_time',
					'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
					'$search_return_location',
					'".date('H:i', strtotime($search_return_dates))."',
					0,
					0,
					'$coupon',
					'$Discount',
					" . $vehicle_id . ",
					'$day',
					'$subtotal',
					'$est_total',
					'$dbcustomer_id',
					'".date('Y-m-d H:i:s',time())."',
					'$deposit',
					'$refund_dep_payment',
					0,
					'$payment_amount',
					'$pickup_cost',
					'$p_pickup_address',
					'$r_pickup_address',
					'$agent_id',
						'Booked',
					'".$user_branch."',
					'".$userId."'
					)
					";

					mysqli_query($con,$sql);
				}
				
				//bebe2

				else if ($delivery_cost >= 1) 
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
					'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
					'$search_pickup_location',
					'$search_pickup_time',
					'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
					'$search_return_location',
					'".date('H:i', strtotime($search_return_dates))."',
					0,
					0,
					'$coupon',
					'$Discount',
					" . $vehicle_id . ",
					'$day',
					'$subtotal',
					'$payment_details',
					'$est_total',
					'$dbcustomer_id',
					'".date('Y-m-d H:i:s',time())."',
					'$deposit',
					'$refund_dep_payment',
					0,
					'$payment_amount',
					'$delivery_cost',
					'$p_delivery_address',
					'$r_delivery_address',
					'$agent_id',
					'Booked',
					'".$user_branch."',
					'".$userId."'
					)
					"; 

					mysqli_query($con,$sql);

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
					type,
					balance,
					agent_id,
					available,
					branch,
					staff_id
					)
					VALUES
					(
					'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
					'$search_pickup_location',
					'$search_pickup_time',
					'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
					'$search_return_location',
					'".date('H:i', strtotime($search_return_dates))."',
					0,
					0,
					'$coupon',
					'".$Discount."',
					" . $vehicle_id . ",
					'$day',
					'$subtotal',
					'$payment_details',
					'$est_total',
					'$dbcustomer_id',
					'".date('Y-m-d H:i:s',time())."',
					'$deposit',
					'$refund_dep_payment',
					0,
					'$payment_amount',
					'$agent_id',
					'Booked',
					'".$user_branch."',
					'".$userId."'
					)
					"; 

					mysqli_query($con,$sql);
					}
					
					$booking_id = mysqli_insert_id($con);

					$sql = "SELECT id, description, initial from location WHERE description = '" . $user_branch."'";

					$query=mysqli_query($con,$sql);
			

					while ($row = mysqli_fetch_assoc($query)){

						$pickup_initial = $row['initial'];

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

					$sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;

					mysqli_query($con,$sql);

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
						'" . $checkStickerP . "',
						'" . $checkChildSeat . "',
						'" . $checkCharger . "',
						'" . $checkTouchnGo . "',
						'" . $checkSmartTag . "',
						'" . $checkAddDriver . "',
						'" . $checkCdw . "',
						'" . $checkDriver . "'
						)
						"; 
						
					mysqli_query($con,$sql);

			}
			
			// end save pickup

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
						'".$userId."'
					)";

				mysqli_query($con,$sql);
						
				}

				$sql = "INSERT INTO sale 
				(
					title,
					type,
					booking_trans_id,
					vehicle_id,
					total_day,
					deposit,
					pickup_date,
					return_date,
					staff_id,
					created
				)
				VALUES (
					'Booking Deposit in',
					'Booking',
					'$booking_id',
					'" . $vehicle_id . "',
					'$day',
					'$deposit',
					'" . date('Y-m-d', strtotime($search_pickup_date)).' '.$search_pickup_time."',
					'" . date('Y-m-d', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00"."',
					'".$userId."',
					'".date('Y-m-d H:i:s',time())."'
				)";


				mysqli_query($con,$sql);
						
				//successful booking
				
				// start email
				
				$sql = "SELECT
				vehicle.id AS vehicle_id,
					reg_no,
				make,
					model,
				DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
				DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
					CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
				DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
				DATE_FORMAT(return_date, '%H:%i:%s') as return_time,
					CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
				concat(firstname,' ' ,lastname) AS fullname,
				age,
					email,
					license_no,
				nric_no,
				phone_no,
				address,
					postcode,
					city,
					country,
				discount_coupon,
				discount_amount,
				sub_total,
				est_total,
				refund_dep,
				agreement_no
				FROM customer
				JOIN booking_trans ON customer.id = customer_id 
				JOIN vehicle ON vehicle_id = vehicle.id
				WHERE booking_trans.id=". $booking_id;
				
				$query=mysqli_query($con,$sql);
				
				while ($row = mysqli_fetch_assoc($query)){
				
				$vehicle_id = $row['vehicle_id'];
				$reg_no = $row['reg_no'];
				$make = $row['make'];
				$model = $row['model'];
				$pickup_date = $row['pickup_date'];
				$pickup_time = $row['pickup_time'];
				$pickup_location = $row['pickup_location'];
				$return_date = $row['return_date'];
				$return_time = $row['return_time'];
				$return_location = $row['return_location'];
				$fullname = $row['fullname'];
				$age = $row['age'];
				$email = $row['email'];
				$license_no = $row['license_no'];
				$nric_no = $row['nric_no'];
				$phone_no = $row['phone_no'];
				$address = $row['address'];
				$postcode = $row['postcode'];
				$city = $row['city'];
				$country = $row['country'];
				$discount_coupon = $row['discount_coupon'];
				$discount_amount = $row['discount_amount'];
				$sub_total = $row['sub_total'];
				$est_total = $row['est_total'];
				$refund_dep = $row['refund_dep'];
				$agreement_no = $row['agreement_no'];
				
				}
				
				$mail = new PHPMailer; // create a new object
				// $mail->IsSMTP(); // enable SMTP
				// $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
				$mail->SMTPAuth = true; // authentication enabled
				$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
				$mail->Host = "smtp.gmail.com";
				$mail->Port = 587; // or 465
				$mail->Username = "myezgo01@gmail.com";
				$mail->Password = "sariba85";
				$mail->SetFrom("myezgo01@iqbalzainon.revolusihosting.top");
				$mail->isHTML(true);
				$mail->Subject = "Booking Details";
				$mail->Body = '
					<style>
					table {
					border-collapse: collapse;
					}
				
					table, th, td {
						border: 1px solid #576574;
						padding: 15px;
					}
					</style>
					<table>
						<thead>
							<tr>
								<th><br>Booking Details of : </th>
								<th>' . $fullname . '</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td>Reservation Number : ' . $agreement_no . '</td>
						</tr>
						<tr>
							<td>Pickup Date: ' . $pickup_date . '</td>
						</tr>
						<tr>
							<td>Pickup Time: ' . $pickup_time . '</td>
						</tr>
						<tr>
							<td>Pickup Location: ' . $pickup_location . '</td>
						</tr>
						<tr>
							<td>Return Date: ' . $return_date . '</td>
						</tr>
						<tr>
							<td>Return Time: ' . $return_time . '</td>
						</tr>
						<tr>
							<td>Return Location: ' . $return_location . '</td>
						</tr>
						<tr colspan="4">
						<th><br>Vehicle Details</th>
						</tr>
						<tr>
							<td>Vehicle Make: ' . $make . '</td>
						</tr>
						<tr>
							<td>Vehicle Model: ' . $model . '</td>
						</tr>
						<tr>
							<td>Vehicle Plate No.: ' . $reg_no . '</td>
						</tr>
						<tr colspan="4">
						<th><br>Driver Details</th>
					</tr>
					<tr>
					<td>NRIC / Passport No.: ' . $nric_no . '</td>
					</tr>
					<tr>
					<td>License No.: ' . $license_no . '</td>
					</tr>
					<tr>
					<td>Driver Age: ' . $age . '</td>
					</tr>
					<tr>
					<td>Email: ' . $email . '</td>
					</tr>
					<tr>
					<td>Phone No.: ' . $phone_no . '</td>
					</tr>
					<tr>
					<td>Address: ' . $address . '</td>
					</tr>
					<tr>
					<td>Postcode: ' . $postcode . '</td>
					</tr>
					<tr>
					<td>City: ' . $city . '</td>
					</tr>
					<tr>
					<td>Country: ' . $country . '</td>
					</tr>
					<tr colspan="4">
						<th><br>Cost Details</th>
					</tr>
					<tr>
					<td>Base Cost: ' . $sub_total . '</td>
					</tr>
					<tr>
					<td>Discount Coupon: ' . $discount_coupon . '</td>
					</tr>
					<tr>
					<td>Total Rental: ' . $est_total . '</td>
					</tr>
					<tr>
					<td>Refund Deposit: ' . $refund_dep . '</td>
					</tr>
						</tbody>
					</table>
					';
					
					$mail->AddAddress($email);
					$mail->AddAddress('iqbalzainon@etlgr.com');
					$mail->AddAddress('adilakhalid@etlgr.com');
					$mail->AddAddress('myezgosale@etlgr.com');
					$mail->AddAddress('acoyy@etlgr.com');
					
			if (!$mail->send()) {
				$response["status"] = 1;
				$response["message"] = "Mailer Error: " . $mail->ErrorInfo;
			} else {
				$response["status"] = 0;
				$response["message"] = "Reservation successful";
				$response["booking_id"] = $booking_id;
			}


		}

	
	// end filter reservation
 

	}

	else{

        $response["status"] = 2;
		$response["message"] = "Reservation not successful";
		

    }

        echo json_encode($response);

?>