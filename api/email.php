<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// require 'C:\xampp\composer\vendor\autoload.php';
require("../dashboard/lib/phpmailer/class.phpmailer.php");
$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
$name = $input["Name"];

// if($_SERVER['REQUEST_METHOD']=='POST'){

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
  WHERE booking_trans.id='4440'";

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

    // $mail->AddAddress($email);
    // $mail->AddAddress('iqbalzainon@etlgr.com');
    // $mail->AddAddress('adilakhalid@etlgr.com');
    // $mail->AddAddress('myezgosale@etlgr.com');
    // $mail->AddAddress('acoyy@etlgr.com');
    $mail->AddAddress('degressix@gmail.com');




    if (!$mail->send()) {
        $response["status"] = 1;
        $response["message"] = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $response["status"] = 0;
    }

   

// }

echo json_encode($response);

?>