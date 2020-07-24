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

$booking_id = $_GET['booking_id'];

func_setReqVar();

$sql = "SELECT
  vehicle.id AS vehicle_id,
    reg_no,
  make,
    model,
  DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
  DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
    CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
  DATE_FORMAT(return_date_final, '%d/%m/%Y') as return_date,
  DATE_FORMAT(return_date_final, '%H:%i:%s') as return_time,
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
  agreement_no,
  booking_trans.branch AS branch
  FROM customer
  JOIN booking_trans ON customer.id = customer_id 
  JOIN vehicle ON vehicle_id = vehicle.id
  WHERE booking_trans.id=" . $booking_id;
  //echo $sql;
db_select($sql);
if (db_rowcount() > 0) {
    func_setSelectVar();
}

$sql = "SELECT image FROM company WHERE id='1'";
  
  //echo $sql;
db_select($sql);
if (db_rowcount() > 0) {
    func_setSelectVar();
}

if($_GET['status'] == 'booking') {
    
    $mail = new PHPMailer; // create a new object
    // $mail->IsSMTP(); // enable SMTP
    // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // or 465
    $mail->Username = "myezgo01@gmail.com";
    $mail->Password = "sariba85";
    $mail->SetFrom("myezgo01@myezgo.com");
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
        
        Booking <i>(Staff)</i><br>
        Name: '.$fullname.'<br>
        Plate Number: '.$reg_no.'<br>
        Branch: '.$branch.'
        <br>
        <br>
        <a href="https://www.myezgo.com/dashboard/index.php?list='.$booking_id.'">Link to agreement</a>
    ';

    $mail2 = new PHPMailer; // create a new object
    // $mail2->IsSMTP(); // enable SMTP
    // $mail2->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail2->SMTPAuth = true; // authentication enabled
    $mail2->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail2->Host = "smtp.gmail.com";
    $mail2->Port = 587; // or 465
    $mail2->Username = "myezgo01@gmail.com";
    $mail2->Password = "sariba85";
    $mail2->SetFrom("myezgo01@myezgo.com");
    $mail2->isHTML(true);
    $mail2->Subject = "Booking Details";
    $mail2->Body = '
        <style>
        table {
        border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #576574;
            padding: 15px;
        }
        </style>
        <table width="60%">
                <tr>
                    <td colspan="2" width="15%">
                        <center><a href="www.myezgo.com"><img width="80%" src="myezgo.com/dashboard/assets/img/'.$image.'"></a></center>
                    </td>
                    <td colspan="2" width="15%">
                        <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com"><b>BOOK AGAIN</b></a></center>
                    </td>
                    <td colspan="2" width="15%">
                        <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/product_listing.php"><b>LIST OF VEHICLE</b></a></center>
                    </td>
                    <td colspan="2" width="15%">
                        <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/login.php"><b>REGISTER / SIGN IN</b></a></center>
                    </td>
                    <td colspan="2" width="15%">
                        <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/about_us.php"><b>CONTACT US</b></a></center>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="8">
                        <br><br>
                        Thank you for renting a vehicle from us! If you have any enquiry, please call +6014-4005050 or whatsapp us by clicking this link <a href="wa.me/60144005050">wa.me/60144005050</a>.
                        <br><br>
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Booking Details </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i>Reservation Number : </i></td>
                                    <td>'. $agreement_no .'</td>
                                </tr>
                                <tr>
                                    <td><i>Pickup Date : </i></td>
                                    <td>' . $pickup_date . '</td>
                                </tr>
                                <tr>
                                    <td><i>Pickup Time : </i></td>
                                    <td>' . $pickup_time . '</td>
                                </tr>
                                <tr>
                                    <td><i>Pickup Location : </i></td>
                                    <td>' . $pickup_location . '</td>
                                </tr>
                                <tr>
                                    <td><i>Return Date : </i></td>
                                    <td>' . $return_date . '</td>
                                </tr>
                                <tr>
                                    <td><i>Return Time : </i></td>
                                    <td>' . $return_time . '</td>
                                </tr>
                                <tr>
                                    <td><i>Return Location : </i></td>
                                    <td>' . $return_location . '</td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Vehicle Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i>Vehicle Make : </i></td>
                                    <td>' . $make . '</td>
                                </tr>
                                <tr>
                                    <td><i>Vehicle Model : </i></td>
                                    <td>' . $model . '</td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Driver Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i>Full Name. : </i></td>
                                    <td>' . $fullname . '</td>
                                </tr>
                                <tr>
                                    <td><i>NRIC / Passport No. : </i></td>
                                    <td>' . $nric_no . '</td>
                                </tr>
                                <tr>
                                    <td><i>License No. : </i></td>
                                    <td>' . $license_no . '</td>
                                </tr>
                                <tr>
                                    <td><i>Driver Age : </i></td>
                                    <td>' . $age . '</td>
                                </tr>
                                <tr>
                                    <td><i>Email : </i></td>
                                    <td>' . $email . '</td>
                                </tr>
                                <tr>
                                    <td><i>Phone No. : </i></td>
                                    <td>' . $phone_no . '</td>
                                </tr>
                                <tr>
                                    <td><i>Address : </i></td>
                                    <td>' . $address . '</td>
                                </tr>
                                <tr>
                                    <td><i>Postcode : </i></td>
                                    <td>' . $postcode . '</td>
                                </tr>
                                <tr>
                                    <td><i>City : </i></td>
                                    <td>' . $city . '</td>
                                </tr>
                                <tr>
                                    <td><i>Country : </i></td>
                                    <td>' . $country . '</td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Cost Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i>Base Cost : </i></td>
                                    <td>' . $sub_total . '</td>
                                </tr>
                                <tr>
                                    <td><i>Deposit : </i></td>
                                    <td>' . $refund_dep . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td colspan="3"></td>
                </tr>
            </table>
        ';

    $mail2->AddAddress($email);
    $mail2->AddAddress('myezgo01@gmail.com');
    $mail->AddAddress('himyezgo@gmail.com');
    // $mail->AddAddress('muhdaimanjamal95@gmail.com');
    // $mail->AddAddress('jabbar.ghani95@gmail.com');
    // $mail->AddAddress('fadlyafiq1994@gmail.com');
    // $mail->AddAddress('najibahjasmi13@gmail.com');
    // $mail->AddAddress('iqbalzainon@etlgr.com');
    // $mail->AddAddress('salemyezgo@etlgr.com');
    
    
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "<script>alert(Email has been sended);</script>";
    }

    if (!$mail2->Send()) {
        echo "Mailer Error: " . $mail2->ErrorInfo;
    } else {
        echo "<script>alert(Email has been sended);</script>";
    }
} 
else if($_GET['status'] == 'pickup') {
    
    $mail = new PHPMailer; // create a new object
    // $mail->IsSMTP(); // enable SMTP
    // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // or 465
    $mail->Username = "myezgo01@gmail.com";
    $mail->Password = "sariba85";
    $mail->SetFrom("myezgo01@myezgo.com");
    $mail->isHTML(true);
    $mail->Subject = "Pickup Details";
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
        
        Pickup<br>
        Name: '.$fullname.'<br>
        Plate Number: '.$reg_no.'<br>
        Branch: '.$branch.'
        <br>
        <br>
        <a href="https://www.myezgo.com/dashboard/index.php?list='.$booking_id.'">Link to agreement</a>
    ';
        
    $mail2 = new PHPMailer; // create a new object
    // $mail2->IsSMTP(); // enable SMTP
    // $mail2->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail2->SMTPAuth = true; // authentication enabled
    $mail2->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail2->Host = "smtp.gmail.com";
    $mail2->Port = 587; // or 465
    $mail2->Username = "myezgo01@gmail.com";
    $mail2->Password = "sariba85";
    $mail2->SetFrom("myezgo01@myezgo.com");
    $mail2->isHTML(true);
    $mail2->Subject = "Pickup Details";
    $mail2->Body = '
        <style>
            table {
            border-collapse: collapse;
            }
            
            table, th, td {
              border: 1px solid #576574;
              padding: 15px;
            }
        </style>
        
        <table width="60%">
            <tr>
                <td colspan="2" width="15%">
                    <center><a href="www.myezgo.com"><img width="80%" src="myezgo.com/dashboard/assets/img/'.$image.'"></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com"><b>BOOK AGAIN</b></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/product_listing.php"><b>LIST OF VEHICLE</b></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/login.php"><b>REGISTER / SIGN IN</b></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/about_us.php"><b>CONTACT US</b></a></center>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="8">
                    <br><br>
                    Thank you for renting a vehicle from us! If you have any enquiry, please call +6014-4005050 or whatsapp us by clicking this link <a href="wa.me/60144005050">wa.me/60144005050</a>.
                    <br><br>
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Booking Details </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Reservation Number : </i></td>
                                <td>'. $agreement_no .'</td>
                            </tr>
                            <tr>
                                <td><i>Pickup Date : </i></td>
                                <td>' . $pickup_date . '</td>
                            </tr>
                            <tr>
                                <td><i>Pickup Time : </i></td>
                                <td>' . $pickup_time . '</td>
                            </tr>
                            <tr>
                                <td><i>Pickup Location : </i></td>
                                <td>' . $pickup_location . '</td>
                            </tr>
                            <tr>
                                <td><i>Return Date : </i></td>
                                <td>' . $return_date . '</td>
                            </tr>
                            <tr>
                                <td><i>Return Time : </i></td>
                                <td>' . $return_time . '</td>
                            </tr>
                            <tr>
                                <td><i>Return Location : </i></td>
                                <td>' . $return_location . '</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                            </tr>
                            <tr>
                                <th colspan="2">Vehicle Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Vehicle Make : </i></td>
                                <td>' . $make . '</td>
                            </tr>
                            <tr>
                                <td><i>Vehicle Model : </i></td>
                                <td>' . $model . '</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                            </tr>
                            <tr>
                                <th colspan="2">Driver Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Full Name. : </i></td>
                                <td>' . $fullname . '</td>
                            </tr>
                            <tr>
                                <td><i>NRIC / Passport No. : </i></td>
                                <td>' . $nric_no . '</td>
                            </tr>
                            <tr>
                                <td><i>License No. : </i></td>
                                <td>' . $license_no . '</td>
                            </tr>
                            <tr>
                                <td><i>Driver Age : </i></td>
                                <td>' . $age . '</td>
                            </tr>
                            <tr>
                                <td><i>Email : </i></td>
                                <td>' . $email . '</td>
                            </tr>
                            <tr>
                                <td><i>Phone No. : </i></td>
                                <td>' . $phone_no . '</td>
                            </tr>
                            <tr>
                                <td><i>Address : </i></td>
                                <td>' . $address . '</td>
                            </tr>
                            <tr>
                                <td><i>Postcode : </i></td>
                                <td>' . $postcode . '</td>
                            </tr>
                            <tr>
                                <td><i>City : </i></td>
                                <td>' . $city . '</td>
                            </tr>
                            <tr>
                                <td><i>Country : </i></td>
                                <td>' . $country . '</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                            </tr>
                            <tr>
                                <th colspan="2">Cost Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Base Cost : </i></td>
                                <td>' . $sub_total . '</td>
                            </tr>
                            <tr>
                                <td><i>Deposit : </i></td>
                                <td>' . $refund_dep . '</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
    ';
    
    // $mail->AddAddress('nashrulamir79@gmail.com');
    // $mail->AddAttachment("assets/document/agreement.pdf");
    $mail->AddAddress('himyezgo@gmail.com');
    // $mail->AddAddress('muhdaimanjamal95@gmail.com');
    // $mail->AddAddress('jabbar.ghani95@gmail.com');
    // $mail->AddAddress('fadlyafiq1994@gmail.com');
    // $mail->AddAddress('najibahjasmi13@gmail.com');
    // $mail->AddAddress('iqbalzainon@etlgr.com');
    // $mail->AddAddress('salemyezgo@etlgr.com');
    
    
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "<script>alert(Email has been sended);</script>";
    }
    
    $mail2->AddAddress($email);
    // $mail2->AddAttachment("assets/document/agreement.pdf");
    // $mail2->AddAddress('iqbalzainon@etlgr.com');
    // $mail2->AddAddress('salemyezgo@etlgr.com');
    
    
    if (!$mail2->Send()) {
        echo "Mailer Error: " . $mail2->ErrorInfo;
    } else {
        echo "<script>alert(Email has been sended);</script>";
    }
} 
else if($_GET['status'] == 'return') {
    
    $mail = new PHPMailer; // create a new object
    // $mail->IsSMTP(); // enable SMTP
    // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // or 465
    $mail->Username = "myezgo01@gmail.com";
    $mail->Password = "sariba85";
    $mail->SetFrom("myezgo01@myezgo.com");
    $mail->isHTML(true);
    $mail->Subject = "Return Details";
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
        
        Return<br>
        Name: '.$fullname.'<br>
        Plate Number: '.$reg_no.'<br>
        Branch: '.$branch.'
        <br>
        <br>
        <a href="https://www.myezgo.com/dashboard/index.php?list='.$booking_id.'">Link to agreement</a>
    ';
    
    $mail2 = new PHPMailer; // create a new object
    // $mail2->IsSMTP(); // enable SMTP
    // $mail2->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail2->SMTPAuth = true; // authentication enabled
    $mail2->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail2->Host = "smtp.gmail.com";
    $mail2->Port = 587; // or 465
    $mail2->Username = "myezgo01@gmail.com";
    $mail2->Password = "sariba85";
    $mail2->SetFrom("myezgo01@myezgo.com");
    $mail2->isHTML(true);
    $mail2->Subject = "Return Details";
    $mail2->Body = '
        <style>
            table {
            border-collapse: collapse;
            }
            
            table, th, td {
              border: 1px solid #576574;
              padding: 15px;
            }
        </style>
        
        <table width="60%">
            <tr>
                <td colspan="2" width="15%">
                    <center><a href="www.myezgo.com"><img width="80%" src="myezgo.com/dashboard/assets/img/'.$image.'"></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com"><b>BOOK AGAIN</b></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/product_listing.php"><b>LIST OF VEHICLE</b></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/login.php"><b>REGISTER / SIGN IN</b></a></center>
                </td>
                <td colspan="2" width="15%">
                    <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/about_us.php"><b>CONTACT US</b></a></center>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="8">
                    <br><br>
                    Thank you for renting a vehicle from us! If you have any enquiry, please call +6014-4005050 or whatsapp us by clicking this link <a href="wa.me/60144005050">wa.me/60144005050</a>.
                    <br><br>
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Booking Details </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Reservation Number : </i></td>
                                <td>'. $agreement_no .'</td>
                            </tr>
                            <tr>
                                <td><i>Pickup Date : </i></td>
                                <td>' . $pickup_date . '</td>
                            </tr>
                            <tr>
                                <td><i>Pickup Time : </i></td>
                                <td>' . $pickup_time . '</td>
                            </tr>
                            <tr>
                                <td><i>Pickup Location : </i></td>
                                <td>' . $pickup_location . '</td>
                            </tr>
                            <tr>
                                <td><i>Return Date : </i></td>
                                <td>' . $return_date . '</td>
                            </tr>
                            <tr>
                                <td><i>Return Time : </i></td>
                                <td>' . $return_time . '</td>
                            </tr>
                            <tr>
                                <td><i>Return Location : </i></td>
                                <td>' . $return_location . '</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                            </tr>
                            <tr>
                                <th colspan="2">Vehicle Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Vehicle Make : </i></td>
                                <td>' . $make . '</td>
                            </tr>
                            <tr>
                                <td><i>Vehicle Model : </i></td>
                                <td>' . $model . '</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                            </tr>
                            <tr>
                                <th colspan="2">Driver Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Full Name. : </i></td>
                                <td>' . $fullname . '</td>
                            </tr>
                            <tr>
                                <td><i>NRIC / Passport No. : </i></td>
                                <td>' . $nric_no . '</td>
                            </tr>
                            <tr>
                                <td><i>License No. : </i></td>
                                <td>' . $license_no . '</td>
                            </tr>
                            <tr>
                                <td><i>Driver Age : </i></td>
                                <td>' . $age . '</td>
                            </tr>
                            <tr>
                                <td><i>Email : </i></td>
                                <td>' . $email . '</td>
                            </tr>
                            <tr>
                                <td><i>Phone No. : </i></td>
                                <td>' . $phone_no . '</td>
                            </tr>
                            <tr>
                                <td><i>Address : </i></td>
                                <td>' . $address . '</td>
                            </tr>
                            <tr>
                                <td><i>Postcode : </i></td>
                                <td>' . $postcode . '</td>
                            </tr>
                            <tr>
                                <td><i>City : </i></td>
                                <td>' . $city . '</td>
                            </tr>
                            <tr>
                                <td><i>Country : </i></td>
                                <td>' . $country . '</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
                            </tr>
                            <tr>
                                <th colspan="2">Cost Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Base Cost : </i></td>
                                <td>' . $sub_total . '</td>
                            </tr>
                            <tr>
                                <td><i>Deposit : </i></td>
                                <td>' . $refund_dep . '</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
    ';
    
    // $mail->AddAddress('acoydip3a@gmail.com');
    // $mail->AddAttachment("assets/document/agreement.pdf");
    $mail->AddAddress('himyezgo@gmail.com');
    // $mail->AddAddress('muhdaimanjamal95@gmail.com');
    // $mail->AddAddress('jabbar.ghani95@gmail.com');
    // $mail->AddAddress('fadlyafiq1994@gmail.com');
    // $mail->AddAddress('najibahjasmi13@gmail.com');
    // $mail->AddAddress('iqbalzainon@etlgr.com');
    // $mail->AddAddress('salemyezgo@etlgr.com');
    
    
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "<script>alert(Email has been sended);</script>";
    }
    
    $mail2->AddAddress($email);
    // $mail2->AddAttachment("assets/document/agreement.pdf");
    // $mail2->AddAddress('iqbalzainon@etlgr.com');
    // $mail2->AddAddress('salemyezgo@etlgr.com');
    
    
    if (!$mail2->Send()) {
        echo "Mailer Error: " . $mail2->ErrorInfo;
    } else {
        echo "<script>alert(Email has been sended);</script>";
    }
} 
// else if($_GET['status'] == 'booking') {
    
//     $mail = new PHPMailer; // create a new object
//     // $mail->IsSMTP(); // enable SMTP
//     // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
//     $mail->SMTPAuth = true; // authentication enabled
//     $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
//     $mail->Host = "smtp.gmail.com";
//     $mail->Port = 587; // or 465
//     $mail->Username = "myezgo01@gmail.com";
//     $mail->Password = "sariba85";
//     $mail->SetFrom("myezgo01@myezgo.com");
//     $mail->isHTML(true);
//     $mail->Subject = "Booking Details";
//     $mail->Body = '
//         <style>
//         table {
//         border-collapse: collapse;
//         }
    
//         table, th, td {
//             border: 1px solid #576574;
//             padding: 15px;
//         }
//         </style>
//         <table width="60%">
//                 <tr>
//                     <td colspan="2" width="15%">
//                         <center><a href="www.myezgo.com"><img width="80%" src="myezgo.com/dashboard/assets/img/'.$image.'"></a></center>
//                     </td>
//                     <td colspan="2" width="15%">
//                         <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com"><b>BOOK AGAIN</b></a></center>
//                     </td>
//                     <td colspan="2" width="15%">
//                         <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/product_listing.php"><b>LIST OF VEHICLE</b></a></center>
//                     </td>
//                     <td colspan="2" width="15%">
//                         <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/login.php"><b>REGISTER / SIGN IN</b></a></center>
//                     </td>
//                     <td colspan="2" width="15%">
//                         <center><a style="text-decoration: none; font-family: arial narrow, sans-serif;" href="www.myezgo.com/about_us.php"><b>CONTACT US</b></a></center>
//                     </td>
//                 </tr>
//                 <tr>
//                     <td></td>
//                     <td colspan="8">
//                         <br><br>
//                         Thank you for renting a vehicle from us! If you have any enquiry, please call +6014-4005050 or whatsapp us by clicking this link <a href="wa.me/60144005050">wa.me/60144005050</a>.
//                         <br><br>
//                         <table>
//                             <thead>
//                                 <tr>
//                                     <th colspan="2">Booking Details </th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 <tr>
//                                     <td><i>Reservation Number : </i></td>
//                                     <td>'. $agreement_no .'</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Pickup Date : </i></td>
//                                     <td>' . $pickup_date . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Pickup Time : </i></td>
//                                     <td>' . $pickup_time . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Pickup Location : </i></td>
//                                     <td>' . $pickup_location . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Return Date : </i></td>
//                                     <td>' . $return_date . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Return Time : </i></td>
//                                     <td>' . $return_time . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Return Location : </i></td>
//                                     <td>' . $return_location . '</td>
//                                 </tr>
//                             </tbody>
//                             <thead>
//                                 <tr>
//                                     <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
//                                 </tr>
//                                 <tr>
//                                     <th colspan="2">Vehicle Details</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 <tr>
//                                     <td><i>Vehicle Make : </i></td>
//                                     <td>' . $make . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Vehicle Model : </i></td>
//                                     <td>' . $model . '</td>
//                                 </tr>
//                             </tbody>
//                             <thead>
//                                 <tr>
//                                     <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
//                                 </tr>
//                                 <tr>
//                                     <th colspan="2">Driver Details</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 <tr>
//                                     <td><i>Full Name. : </i></td>
//                                     <td>' . $fullname . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>NRIC / Passport No. : </i></td>
//                                     <td>' . $nric_no . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>License No. : </i></td>
//                                     <td>' . $license_no . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Driver Age : </i></td>
//                                     <td>' . $age . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Email : </i></td>
//                                     <td>' . $email . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Phone No. : </i></td>
//                                     <td>' . $phone_no . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Address : </i></td>
//                                     <td>' . $address . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Postcode : </i></td>
//                                     <td>' . $postcode . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>City : </i></td>
//                                     <td>' . $city . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Country : </i></td>
//                                     <td>' . $country . '</td>
//                                 </tr>
//                             </tbody>
//                             <thead>
//                                 <tr>
//                                     <td bgcolor="#FFFFFF" style="line-height:15px;" colspan=3>&nbsp;</td>
//                                 </tr>
//                                 <tr>
//                                     <th colspan="2">Cost Details</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 <tr>
//                                     <td><i>Base Cost : </i></td>
//                                     <td>' . $sub_total . '</td>
//                                 </tr>
//                                 <tr>
//                                     <td><i>Deposit : </i></td>
//                                     <td>' . $refund_dep . '</td>
//                                 </tr>
//                             </tbody>
//                         </table>
//                     </td>
//                     <td colspan="3"></td>
//                 </tr>
//             </table>
//         ';
    
//     $mail->AddAddress($email);
//     $mail->AddAddress('himyezgo@gmail.com');
//     $mail->AddAddress('iqbalzainon@etlgr.com');
//     $mail->AddAddress('salemyezgo@etlgr.com');
    
    
//     if (!$mail->Send()) {
//         echo "Mailer Error: " . $mail->ErrorInfo;
//     } else {
//         echo "<script>alert(Email has been sended);</script>";
//     }
// }

vali_redirect("reservation_list_view.php?booking_id=$booking_id");

include("_footer.php");

?>
