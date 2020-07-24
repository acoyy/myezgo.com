<?php include("_header.php"); ?>

<body class="full-screen">

<!-- BEGIN: SITE-WRAPPER -->
<div class="coming-soon-wrapper full-screen">
  <div class="coming-soon full-screen">
    <div class="centered-box text-center">
      <div class="loading-animation">
        <span><i class="fa fa-plane"></i></span>
        <span><i class="fa fa-bed"></i></span>
        <span><i class="fa fa-ship"></i></span>
        <span><i class="fa fa-suitcase"></i></span>
      </div>
      <div class="search-title">
        <p>Saving Your Booking Information</p>
        <small>This Will Take Few Seconds</small>
      </div>
      <p class="copyright"><?php echo $website_name; ?> &copy;</p>
    </div>
  </div>
</div>
<!-- END: SITE-WRAPPER -->

</body>

<?php

require("lib/phpmailer/class.phpmailer.php");

func_setReqVar();

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
  WHERE booking_trans.id=" . $_GET['booking_id'];
  //echo $sql;
db_select($sql);
if (db_rowcount() > 0) {
    func_setSelectVar();
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

$mail->AddAddress($email);
$mail->AddAddress('iqbalzainon@etlgr.com');
$mail->AddAddress('adilakhalid@etlgr.com');
$mail->AddAddress('myezgosale@etlgr.com');
$mail->AddAddress('acoyy@etlgr.com');


if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<script>alert(Email has been sended);</script>";
}

$booking_id = $_GET['booking_id'];


vali_redirect("reservation_list_view.php?booking_id=$booking_id");

include("_footer.php");

?>
