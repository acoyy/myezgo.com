<?php

require_once('db/db_connect.php');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$search_pickup_date = $input[0]["pickupDate"];
$search_return_date = $input[0]["returnDate"];
$search_pickup_time = $input[0]["pickupTime"];
$search_return_time = $input[0]["returnTime"];
$class_id = $input[0]["classId"];

if($input[0]["deliveryCost"]=="" || $input[0]["deliveryCost"]==null){

    $delivery_cost = 0;

}else{

    $delivery_cost = $input[0]["deliveryCost"];

}

if($input[0]["pickupCost"]=="" || $input[0]["pickupCost"]==null){

    $pickupCost = 0;

}else{

    $pickupCost = $input[0]["pickupCost"];

}

// start import

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

$getPickupDateTime = date('d/m/Y', strtotime($search_pickup_date)) . " - " . $search_pickup_time; 


$sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 

$query=mysqli_query($con,$sql);

while ($row = mysqli_fetch_array($query)){

    $dbcar_rate_class_id = $row['class_id'];
	$dbcar_rate_oneday = $row['oneday'];
	$dbcar_rate_twoday = $row['twoday'];
	$dbcar_rate_threeday = $row['threeday'];
	$dbcar_rate_fourday = $row['fourday'];
	$dbcar_rate_fiveday = $row['fiveday'];
	$dbcar_rate_sixday = $row['sixday'];
	$dbcar_rate_weekly = $row['weekly'];
	$dbcar_rate_monthly = $row['monthly'];
	$dbcar_rate_hour = $row['hour'];
	$dbcar_rate_halfday = $row['halfday'];
	$dbcar_rate_deposit = $row['deposit'];

}

$sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'"; 

$query=mysqli_query($con,$sql);

while ($row = mysqli_fetch_array($query)){

    $dbpromo_how_many_day_min = $row['how_many_day_min'];
	$dbpromo_how_many_day_max = $row['how_many_day_max'];

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


$six_digit_random_number = mt_rand(100000, 999999); 

$est_total = $subtotal + $delivery_cost + $pickupCost;

$Discount = 0;


$getBaseRate = dateDifference($pickup_date . $search_pickup_time, $return_date . $search_return_time, '%a Day %h Hours');
$getDiscount = $Discount;
$getSubtotal =  number_format($subtotal,2);
$getPickupCost= $pickupCost;
$getDeliveryCost = $delivery_cost;
$getGrandTotal = number_format($est_total,2);
$getPickupDateTime = date('d/m/Y', strtotime($search_pickup_date)) . " - " . $search_pickup_time; 
$getReturnDateTime = date('d/m/Y', strtotime($search_return_dates)) . " - " . date('H:i', strtotime($search_return_dates));


///////////////////////////////////////////////////////////////////////

$baseRate="qqwwe";

    if($_SERVER['REQUEST_METHOD']=='POST'){

            $result = array();

            array_push($result,array(

            'baseRate'=>$getBaseRate,
            'discount'=>$getDiscount,
            'subtotal'=>$getSubtotal,
            'grandTotal'=>$getGrandTotal,
            'pickupDateTime'=>$getPickupDateTime,
            'returnDateTime'=>$getReturnDateTime

            ));
            
            echo json_encode($result);
            mysqli_close($con);

        }


?>