<?php

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
		
		// start debbug
        
		//successful booking

        $response["status"] = 0;
		$response["message"] = "Pickup successful";
		$response["booking_id"] = $booking_id;
?>