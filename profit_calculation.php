<?php
	if($day_agent == 0) {

		if($time < 8){

			$agent_subtotal = $time * $dbcar_rate_hour; 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_halfday;
		} 

		else if($time >= 13){ 

			$agent_subtotal = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
		} 

	} 

	elseif ($day_agent == 1) { 


		if($time < 8){
			
			$agent_subtotal = $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} 

	elseif ($day_agent == 2) { 

		if($time < 8){
			
			$agent_subtotal = $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 3) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

	else if($time >= 8 && $time <= 12) {

		$agent_subtotal = $dbcar_rate_threeday + $dbcar_rate_halfday; 

	} elseif ($time >= 13){ 

		$agent_subtotal = $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

	} 

	} elseif ($day_agent == 4) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 5) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 
			
			$agent_subtotal = $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 6) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_sixday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
		} 

	} elseif ($day_agent == 7) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 8) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 9) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 10) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 11) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 12) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

				$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 13) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 14) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 15) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 16) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 17) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + $dbcar_rate_halfday; 

		} 

		elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour);

		} 

	} elseif($day_agent == 18) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif($day_agent == 19) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 20) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 21) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 22) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 23) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 24) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 25) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 26) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} else if ($day_agent == 27) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 28) { 
		
		if($mymonth == '2')
		{
			if($time < 8){

				$agent_subtotal = $dbcar_rate_monthly + ($time * $dbcar_rate_hour); 
			}

			else if($time >= 8 && $time <= 12) { 

				$agent_subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday; 

			} elseif ($time >= 13){ 

				$agent_subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

			}  
		}

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 29) { 

		if($time < 8){

			$agent_subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) {

			$agent_subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	} elseif ($day_agent == 30) { 

		if($time < 8){

			$agent_subtotal = $dbcar_rate_monthly + ($time * $dbcar_rate_hour); 
		}

		else if($time >= 8 && $time <= 12) { 

			$agent_subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday; 

		} elseif ($time >= 13){ 

			$agent_subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

		} 

	}
?>