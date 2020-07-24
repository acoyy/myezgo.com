<?php

$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
$icNumber = $input["icNumber"];

//Start Debug
if($_SERVER['REQUEST_METHOD']=='POST'){

    $sql = "SELECT * FROM customer WHERE nric_no = '$icNumber'";

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        $response["result"] = 0;

        while ($row = mysqli_fetch_array($query)){

            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $nric_no = $row['nric_no'];
            $license_no = $row['license_no'];
            $license_exp = $row['license_exp'];
            $phone_no = $row['phone_no'];
            $phone_no2 = $row['phone_no2'];
            $email = $row['email'];
            $address = $row['address'];
            $postcode = $row['postcode'];
            $city = $row['city'];
            $country = $row['country'];
            $status = $row['status'];
            $cid = $row['cid'];
            $cdate = $row['cdate'];
            $ref_name = $row['ref_name'];
            $ref_phoneno = $row['ref_phoneno'];
            $drv_name = $row['drv_name'];
            $drv_nric = $row['drv_nric'];
            $drv_address = $row['drv_address'];
            $drv_phoneno = $row['drv_phoneno'];
            $drv_license_no = $row['drv_license_no'];
            $drv_license_exp = $row['drv_license_exp'];
            $ref_relationship = $row['ref_relationship'];
            $ref_address = $row['ref_address'];
            $survey_type = $row['survey_type'];
            $provider_id = $row['provider_id'];
            $survey_details = $row['survey_details'];
    
        }

        $response["firstname"] = $firstname;
        $response["lastname"] = $lastname;
        $response["license_no"] = $license_no;
        $response["license_exp"] = $license_exp;
        $response["phone_no"] = $phone_no;
        $response["phone_no2"] = $phone_no2;
        $response["email"] = $email;
        $response["address"] = $address;
        $response["postcode"] = $postcode;
        $response["city"] = $city;
        $response["country"] = $country;
        $response["status"] = $status; 
        $response["cid"] = $cid;
        $response["cdate"] = $cdate;
        $response["ref_name"] = $ref_name;
        $response["ref_phoneno"] = $ref_phoneno;
        $response["drv_name"] = $drv_name;
        $response["drv_nric"] = $drv_nric;
        $response["drv_address"] = $drv_address;
        $response["drv_phoneno"] = $drv_phoneno;
        $response["drv_license_no"] = $drv_license_no;
        $response["drv_license_exp"] = $drv_license_exp;
        $response["ref_relationship"] = $ref_relationship;
        $response["ref_address"] = $ref_address;
        $response["survey_type"] = $survey_type;
        $response["provider_id"] = $provider_id;
        $response["survey_details"] = $survey_details;

    } 

    else{
        
        $response["result"] = 1;

    }
    
}



echo json_encode($response);



?>