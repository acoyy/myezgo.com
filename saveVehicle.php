<?php

$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

$booking_id = $input["booking_id"];
$car2 = $input["vehicle_id"];



if($_SERVER['REQUEST_METHOD']=='POST'){

    $sql = "UPDATE booking_trans SET vehicle_id = '$car2' WHERE id = '$booking_id'";

    mysqli_query($con,$sql);

    $sql = "UPDATE sale SET vehicle_id = '$car2' WHERE booking_trans_id = '$booking_id'";

    mysqli_query($con,$sql);

    $sql = "SELECT * FROM extend WHERE booking_trans_id = '$booking_id'";

    $query=mysqli_query($con,$sql);

      if(mysqli_num_rows($query)>0){

            $sql = "UPDATE extend SET vehicle_id = '$car2' WHERE booking_trans_id = '$booking_id'";
        
            mysqli_query($con,$sql);
     
      }
    
      $response["message"] = "Change Vehicle Successful";

      $response["status"] = 0;

}

else{

    $response["message"] = "Change Vehicle Not Successful";

      $response["status"] = 1;


}

    

    echo json_encode($response);

?>