<?php
	if($day == 0) {

		if($time < 5){

			if($min_rental_time =='1 day'){
				
				$subtotal = $dbcar_rate_oneday;
			}
			else if($min_rental_time =='5 hours'){

				$subtotal = 5 * $dbcar_rate_hour;
			}
		}

		else if($time < 8){

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
		
		if($mymonth == '2')
		{
			if($time < 8){

				$subtotal = $dbcar_rate_monthly + ($time * $dbcar_rate_hour); 
			}

			else if($time >= 8 && $time <= 12) { 

				$subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday; 

			} elseif ($time >= 13){ 

				$subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

			}  
		}

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
?>