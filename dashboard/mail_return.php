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
    <center>
      <table width="60%">
          <thead>
              <tr>
                  <th width="50%">Booking Details </th>
                  <th width="50%">' . $fullname . '</th>
              </tr>
          </thead>
          <tbody>
          <tr>
              <td width="50%">Reservation Number : </td>
              <td width="50%"></td>
          </tr>
          <tr>
              <td width="50%">Pickup Date : </td>
              <td width="50%">' . $pickup_date . '</td>
          </tr>
          <tr>
              <td width="50%">Pickup Time : </td>
              <td width="50%">' . $pickup_time . '</td>
          </tr>
          <tr>
              <td width="50%">Pickup Location : </td>
              <td width="50%">' . $pickup_location . '</td>
          </tr>
          <tr>
              <td width="50%">Return Date : </td>
              <td width="50%">' . $return_date . '</td>
          </tr>
          <tr>
              <td width="50%">Return Time : </td>
              <td width="50%">' . $return_time . '</td>
          </tr>
          <tr>
              <td width="50%">Return Location : </td>
              <td width="50%">' . $return_location . '</td>
          </tr>
        </tbody>
      </table>
      <br>
      <table width="60%">
        <thead>
          <tr>
           <th colspan="2">Vehicle Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td width="50%">Vehicle Make : </td>
              <td width="50%">' . $make . '</td>
          </tr>
          <tr>
              <td width="50%">Vehicle Model : </td>
              <td width="50%">' . $model . '</td>
          </tr>
        </tbody>
      </table>
      <br>
      <table width="60%">
        <thead>
          <tr>
          <th colspan="2">Driver Details</th>
         </tr>
       </thead>
       <tbody>
         <tr>
         <td width="50%">NRIC / Passport No. : </td>
         <td width="50%">' . $nric_no . '</td>
         </tr>
         <tr>
         <td width="50%">License No. : </td>
         <td width="50%">' . $license_no . '</td>
         </tr>
         <tr>
         <td width="50%">Driver Age : </td>
         <td width="50%">' . $age . '</td>
         </tr>
         <tr>
         <td width="50%">Email : </td>
         <td width="50%">' . $email . '</td>
         </tr>
         <tr>
         <td width="50%">Phone No. : </td>
         <td width="50%">' . $phone_no . '</td>
         </tr>
         <tr>
         <td width="50%">Address : </td>
         <td width="50%">' . $address . '</td>
         </tr>
         <tr>
         <td width="50%">Postcode : </td>
         <td width="50%">' . $postcode . '</td>
         </tr>
         <tr>
         <td width="50%">City : </td>
         <td width="50%">' . $city . '</td>
         </tr>
         <tr>
         <td width="50%">Country : </td>
         <td width="50%">' . $country . '</td>
         </tr>
       </tbody>
     </table>
     <br>
     <table width="60%">
      <thead>
         <tr>
          <th colspan="2">Cost Details</th>
         </tr>
       </thead>
       <tbody>
         <tr>
         <td width="50%">Base Cost : </td>
         <td width="50%">' . $sub_total . '</td>
         </tr>
         <tr>
         <td width="50%">Refund Deposit : </td>
         <td width="50%">' . $refund_dep . '</td>
         </tr>
          </tbody>
      </table>
    </center>
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
