<?php
$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array



if($input['coupon_code']=="" || $input['coupon_code']==null){

    $coupon = "";

}else{

    $coupon =  strtoupper($input['coupon_code']);

}

if($input['agent_code']=="" || $input['agent_code']==null){

    $agent_code = "";

}else{

    $agent_code = strtoupper($input['agent_code']);

}

$coupontype="";
$exceed="";
$note="";
$extend="";
$freeday="false";
$response["status"] = 0;
$resultcoupon = '';
$resultagent = '';
$agent_profit='';
$agent_id='';
$agent_name='';

$search_pickup_date = $input["pickupDate"];
$search_return_date = $input["returnDate"];
$search_pickup_time = $input["pickupTime"];
$search_return_time = $input["returnTime"];
$est_total = $input["estTotal"];
$subtotal = $input["subTotal"];
$search_pickup_date = $input["pickupDate"];
$Discount = 0;

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

$pickup_date = date('m/d/Y', strtotime($search_pickup_date));
$pickup_time = $search_pickup_time;
$return_date = date('m/d/Y', strtotime($search_return_date));
$return_time = $search_return_time;
$search_return_dates = date('m/d/Y H:i:s', strtotime("$return_date $return_time"));
$search_return_dates_origin = date('m/d/Y H:i:s', strtotime("$return_date $return_time"));


$day = dateDifference($pickup_date." ".$pickup_time, $return_date." ".$return_time, '%a');
$time = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%h'); 

$mydate = date('m/d/Y', strtotime($search_pickup_date));
$mymonth = date("m",strtotime($mydate));
$myday = date("d",strtotime($mydate));
$myyear = date("Y",strtotime($mydate));

//Start Debug
if($_SERVER['REQUEST_METHOD']=='POST'){
    
    
    $sqlDis = "SELECT * FROM discount WHERE code='$coupon'";

    $query=mysqli_query($con,$sqlDis);

    while ($row = mysqli_fetch_array($query)){

        $dbdis_id = $row['id'];
        $dbdis_code = $row['code'];
        $dbdis_start_date = $row['start_date'];
        $dbdis_end_date = $row['end_date'];
        $dbdis_value_in = $row['value_in'];
        $dbdis_rate = $row['rate'];

    }

    $rowdiscount=mysqli_num_rows($query);

    $sql = "SELECT id as agent_id, name as agent_name FROM agent WHERE code='$agent_code'";

    $query=mysqli_query($con,$sql);
       

        while ($row = mysqli_fetch_assoc($query)){

            $agent_id = $row['agent_id'];
            $agent_name = $row['agent'];

        }

    $rowagent=mysqli_num_rows($query);

    $sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'"; 

    $query=mysqli_query($con,$sql);

    while ($row = mysqli_fetch_array($query)){

        $dbpromo_how_many_day_min = $row['how_many_day_min'];
        $dbpromo_how_many_day_max = $row['how_many_day_max'];

    }

    // start debug 2

    if ($rowdiscount > 0) 
	{

        $resultcoupon = 'valid';

        if($coupon == '3DAYSALE' && $day < $dbpromo_how_many_day_min)
		{
			$resultcoupon = 'invalid';
        }

        if(date('m/d/Y', strtotime($search_pickup_date))>=date('m/d/Y', strtotime($dbdis_start_date)) && date('m/d/Y', strtotime($search_return_dates)) <= date('m/d/Y', strtotime($dbdis_end_date)) && $resultcoupon == 'valid') 
			{

				$resultcoupon = 'true';

				if($dbdis_value_in=='A'){

					if($coupon == 'LOYALTY150' && $est_total < $dbdis_rate)
					{

						$Discount = $est_total;
						$est_total = '0';
					}
					else{

						$est_total = $est_total - $dbdis_rate;
						$Discount = number_format($dbdis_rate,2);
					}
					$coupontype = 'money';
				}

				else if($dbdis_value_in=='P'){

					$percent = $est_total * ($dbdis_rate/100);
					$est_total = $est_total - $percent;
					$Discount = number_format($percent,2);
					$coupontype = 'money';
				}
				
				else if($dbdis_value_in=='H'){

					$date = date('m/d/Y H:i:s', strtotime($search_return_dates)); 
        			$newdate = strtotime('+ '.$dbdis_rate.' hours', strtotime($date));
        			$newdate = date('m/d/Y H:i', $newdate); 
        			$counthour = date('Hi', strtotime($newdate));
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
        				$newdate = date('m/d/Y', strtotime($search_return_dates)). " 22:30";
        				$note = "The actual ".$dbdis_rate."-hour extended time exceeded working hours, converting to maximum return time (10:30 pm)";
        				$exceed = "true";
        			}
        			else
        			{
        				$extend = "true";
        				$note = $dbdis_rate." hours period has been added";
					}
					
					//thisedit

        			$newdate = date('m/d/Y H:i', strtotime($newdate)); 
        			$search_return_dates = $newdate; 

                    
					$response["message"] = "Free ".$dbdis_rate." hour(s)";
                
					$freeday = "true";
					$response["freeday"] = $freeday;

					$coupontype = 'duration';
					$response["status"] = 1;
					
        			
				}

				else if($dbdis_value_in == 'D'){

					$date = date('m/d/Y H:i:s', strtotime($search_return_dates)); 
        			$newdate = strtotime('+ '.$dbdis_rate.' days', strtotime($date));
        			$newdate = date('m/d/Y H:i', $newdate); 

        			$newdate = date('m/d/Y H:i', strtotime($newdate)); 
                    $search_return_dates = $newdate; 
                    
        			if($dbdis_rate > 1){
                    
                        $response["status"] = 1;
                        $response["message1"] = "Free '.$dbdis_rate.' hour(s)";

                    }
	        		else{

                        $response["status"] = 1;
                        $response["message1"] = "Free '.$dbdis_rate.' hour(s)";

                    }

        			$freeday = 'true';
        			$note = "The return date has been extended";
        			$extend = "true";
					$coupontype = 'duration';
					
				}

				$getSubtotal = $subtotal;
				$getCoupon = $coupon;
				$getEstTotal = $est_total;
				$getDiscount = $Discount;
				$getSearchReturnDates = $search_return_dates;
            }
            else if($resultcoupon == 'invalid')
			{
				$resultcoupon = 'rental is less than 3 days';
            }
            else {

				$resultcoupon = 'inactive';
			}
    }
    else if(isset($getSearchReturnDates))
		{
			
			$getSearchReturnDates = $search_return_dates_origin;
		}
		else if($coupon != '' && $rowdiscount == '0')
		{

			$resultcoupon = 'not found';
        }


        if($rowagent > 0)
		{
			// kat sini nak buat kira2 utk agent
			$resultagent = 'true';

			$day_agent = dateDifference($pickup_date." ".$pickup_time, $return_date." ".$return_time, '%a');
			
			$sql = "SELECT * FROM agent_rate";

            $query=mysqli_query($con,$sql);
    
            while ($row = mysqli_fetch_array($query)){

                $id = $row['id'];
                $perhour = $row['perhour'];
                $fivehour = $row['fivehour'];
                $halfday = $row['halfday'];
                $oneday = $row['oneday'];
                $twoday = $row['twoday'];
                $threeday = $row['threeday'];
                $fourday = $row['fourday'];
                $fiveday = $row['fiveday'];
                $sixday = $row['sixday'];
                $weekly = $row['weekly'];
                $monthly = $row['monthly'];

            }

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

			$getAgentProfit = $agent_profit;
        }
        else if($agent_code != '' && $rowagent == '0')
		{
			$resultagent = 'not found';
        }

        // start debug 4
       
        if($resultcoupon == 'not found' && $resultagent =='')
		{
            $response["message2"] = "The coupon ".$coupon." does not exist";
		}
		else if($resultcoupon == 'inactive' && $resultagent =='true')
		{
            $response["message2"] = "Customer has been linked to ".$agent_name." (".$agent_code .") ". "but the coupon ".$coupon." is not active";

        }
		else if($resultcoupon == 'inactive' && $resultagent =='')
		{
            $response["message2"] = "The coupon ".$coupon." is not active";
		}
		else if($resultagent == 'not found' && $resultcoupon =='true')
		{
            $response["message2"] = "Coupon is valid but the agent ".$agent_code." does not exist";
		}
		else if($resultagent == 'not found' && $resultcoupon =='')
		{
            $response["message2"] = "Agent does not exist";
		}
		else if($resultcoupon =='inactive' && $resultagent =='not found')
		{
            $response["message2"] = "Coupon is not active and the agent " .$agent_code." does not exist";
		}
		else if($resultcoupon =='not found' && $resultagent =='not found')
		{

            $response["message2"] = "Coupon and Agent does not exist";

		}
		else if ($resultcoupon =='' && $resultagent ==''){

            $response["message2"] = "No Agent and Coupon Code";

		}
		else if($resultcoupon !='' && $resultagent ==''){

            $response["message2"] = "Discount Coupon Activate";

		}


}

if(isset($getSearchReturnDates)){

	$changeDateFormat = date('d/m/Y - H:i', strtotime($getSearchReturnDates));
	$response["searchReturnDates"] = $changeDateFormat; //discount pickup date n time

}

else{

	$changeDateFormat2 = date('d/m/Y - H:i', strtotime($search_return_dates));
	$response["searchReturnDates"] = $changeDateFormat2;

}

$response["est_total"] = $est_total;
$response["discount"] = $Discount;
$response["resultcoupon"] = $resultcoupon;
$response["resultagent"] = $resultagent;

$response["freeday"] = $freeday;
$response["note"] = $note;
$response["exceed"] = $exceed;
$response["coupontype"] = $coupontype;
$response["extend"] = $extend;
$response["agent_profit"] = $agent_profit;
$response["agent_id"] = $agent_id;
$response["agent_name"] = $agent_name;

echo json_encode($response);
?>