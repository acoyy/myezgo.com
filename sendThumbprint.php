<?php
$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
$icNumber = $input["icNumber"];

//Start Debug
if($_SERVER['REQUEST_METHOD']=='POST'){

    $sql = "SELECT firstname,lastname,status,reason_blacklist FROM customer WHERE nric_no = '$icNumber' AND status = 'B'";

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $status = $row['status'];
            $reason_blacklist = $row['reason_blacklist'];
    
        }

    } 

    else{

        $firstname = "";
        $lastname = "";
        $status = "";
        $reason_blacklist = "";

    }


    

}

$response["status"] = 0;
$response["result"] = $status;
$response["firstname"] = $firstname;
$response["lastname"] = $lastname;
$response["reason_blacklist"] = $reason_blacklist;

echo json_encode($response);
?>