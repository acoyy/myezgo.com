<?php

require_once('db/db_connect.php');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$vehicle_id = $input[0]["vehicle_id"];



$sql = "SELECT min_rental_time FROM vehicle WHERE id=" . $vehicle_id; 

$query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $min_rental_time = $row['min_rental_time'];
    
        }
    }

    $search_pickup_date = $input[0]["pickup_date"];
    $search_pickup_time = $input[0]["pickup_time"];
    $search_return_date = $input[0]["return_date"];
    $search_return_time = $input[0]["return_time"];
    // $class_id = $input[0]["classId"];
    
    $pickup_date = date('Y-m-d', strtotime($search_pickup_date));
    $pickup_time = $search_pickup_time;
    $return_date = date('Y-m-d', strtotime($search_return_date));
    $return_time = $search_return_time;

    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

    $return_date_ori = $return_date;
	$return_time_ori = $return_time;

    $days = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%d');
	$hours = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%h');

    $condition = "true";
    $vehicle_status = "inactive";
    
    if($days < 1)
	{
		if($min_rental_time == '1 day')
		{
			$condition = "false day";
			// echo $return_date;
			$return_date = strtotime('+1 day', strtotime($return_date));
			$return_date = date('Y-m-d',$return_date);
			$return_time = $pickup_time;

			// sampai sini 5/8/2019

			$sql = "SELECT id AS booking_id FROM booking_trans WHERE vehicle_id = '$vehicle_id' AND ((
                            return_date <= '" . $return_date.' '.$return_time.':00'."' 
                            AND return_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND (available = 'Out' OR available = 'Booked')
                          ) 
                          OR 
                          (
                            pickup_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND pickup_date <= '" . $return_date.' '.$return_time.':00'."'
                            AND (available = 'Out' OR available = 'Booked')
                          ))";

            $query=mysqli_query($con,$sql);

            if(mysqli_num_rows($query)>0){

                $vehicle_status = 'active';

            }

		
		}

		else if($min_rental_time == '5 hours')
		{

			$return_date = $return_date . " " . $return_time .":00";
			
			if($hours < 5){

				$condition = "false hour";
				$hours = 5 - $hours;
				$return_date = strtotime('+'.$hours.' hours', strtotime($return_date));
				$return_date = date('Y-m-d H:i:s', $return_date);
				// echo $return_date;

				
			}

			$temp_return_date = date('Y-m-d', strtotime($return_date));
			$temp_return_time = date('Hi', strtotime($return_date));

			// echo $temp_return_time;

			if($temp_return_time > "2230" || $temp_return_time < "800")
			{
				$return_time = "22:30";


				if($temp_return_time >= "0" && $temp_return_date > $return_date_ori)
				{

					$return_date = $return_date_ori . " " . $return_time . ":00";
				}
			}
			else
			{

				$return_time = date('H:i', strtotime($return_date));
			}
			
			$sql = "SELECT id AS booking_id FROM booking_trans WHERE vehicle_id = '$vehicle_id' AND 
					(
						(
                            return_date <= '" . $temp_return_date.' '.$return_time.':00'."' 
                            AND return_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND (available = 'Out' OR available = 'Booked')
                        )
                        OR
                        (
                            pickup_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND pickup_date <= '" . $temp_return_date.' '.$return_time.':00'."'
                            AND (available = 'Out' OR available = 'Booked')
                        )
                    )";

            $query=mysqli_query($con,$sql);

            if(mysqli_num_rows($query)>0){

                $vehicle_status = 'active';

            }
			// echo $return_date;

		}

    }
    




    if($_SERVER['REQUEST_METHOD']=='POST'){

            $result = array();

            array_push($result,array(

            'minimum'=>$min_rental_time,
            'pickupDate'=>date('d/m/Y', strtotime($pickup_date)),
            'pickupTime'=>$pickup_time,
            'returnDate'=>date('d/m/Y', strtotime($return_date)),
            'returnDateFinal'=>$return_date,
            'returnDateOri'=>date('d/m/Y', strtotime($return_date_ori)),
            'returnTime'=>$return_time,
            'condition'=>$condition,
            'vehicleStatus'=>$vehicle_status

            ));
            
            echo json_encode($result);
            mysqli_close($con);

        }


?>