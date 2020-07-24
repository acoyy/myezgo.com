<?php //include("_header.php"); ?>

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

include("_header.php");

require("dashboard/lib/phpmailer/class.phpmailer.php");

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
	DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
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
	sub_total,
	refund_dep
	FROM customer
	JOIN booking_trans ON customer.id = customer_id 
	JOIN vehicle ON vehicle_id = vehicle.id
	WHERE booking_trans.id=" . $_GET['booking_id'];
	//echo $sql;
db_select($sql);
if (db_rowcount() > 0) {
    func_setSelectVar();
}

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "mail.myezgo.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "sales@myezgo.com";
$mail->Password = "MYEZGO2018";
$mail->SetFrom("sales@myezgo.com");
$mail->Subject = "Booking Details";
$mail->isHTML(true);
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
                <th>Booking Details of : </th>
                <th>' . $fullname . '</th>
            </tr>
        </thead>
        <tbody>
        <tr colspan="4">
         <th>Booking Details</th>
        </tr>
        <tr>
            <td>Reservation Number : </td>
            <td></td>
        </tr>
        <tr>
            <td>Pickup Date : </td>
            <td>' . $pickup_date . '</td>
        </tr>
        <tr>
            <td>Pickup Time : </td>
            <td>' . $pickup_time . '</td>
        </tr>
        <tr>
            <td>Pickup Location : </td>
            <td>' . $pickup_location . '</td>
        </tr>
        <tr>
            <td>Return Date : </td>
            <td>' . $return_date . '</td>
        </tr>
        <tr>
            <td>Return Time : </td>
            <td>' . $return_time . '</td>
        </tr>
        <tr>
            <td>Return Location : </td>
            <td>' . $return_location . '</td>
        </tr>
        <tr colspan="4">
         <th>Vehicle Details</th>
        </tr>
        <tr>
            <td>Vehicle Make : </td>
            <td>' . $make . '</td>
        </tr>
        <tr>
            <td>Vehicle Model : </td>
            <td>' . $model . '</td>
        </tr>
        <tr colspan="4">
        <th>Driver Details</th>
       </tr>
       <tr>
       <td>NRIC / Passport No. : </td>
       <td>' . $nric_no . '</td>
       </tr>
       <tr>
       <td>License No. : </td>
       <td>' . $license_no . '</td>
       </tr>
       <tr>
       <td>Driver Age : </td>
       <td>' . $age . '</td>
       </tr>
       <tr>
       <td>Email : </td>
       <td>' . $email . '</td>
       </tr>
       <tr>
       <td>Phone No. : </td>
       <td>' . $phone_no . '</td>
       </tr>
       <tr>
       <td>Address : </td>
       <td>' . $address . '</td>
       </tr>
       <tr>
       <td>Postcode : </td>
       <td>' . $postcode . '</td>
       </tr>
       <tr>
       <td>City : </td>
       <td>' . $city . '</td>
       </tr>
       <tr>
       <td>Country : </td>
       <td>' . $country . '</td>
       </tr>
       <tr colspan="4">
        <th>Cost Details</th>
       </tr>
       <tr>
       <td>Base Cost : </td>
       <td>' . $sub_total . '</td>
       </tr>
       <tr>
       <td>Refund Deposit : </td>
       <td>' . $refund_dep . '</td>
       </tr>
        </tbody>
    </table>
    ';

$mail->AddAddress($email);
$mail->AddAddress('iqbalzainon@etlgr.com');
$mail->AddAddress('adilakhalid@etlgr.com');


if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<script>alert(Email has been sended);</script>";
}

$booking_id = $_GET['booking_id'];

vali_redirect("reservation_list_view.php?booking_id=$booking_id");


include("_footer.php");

?>
