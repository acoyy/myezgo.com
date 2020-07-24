<?php
session_start();

if(isset($_SESSION['cid']) || isset($_SESSION['user_id'])){

  $idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

  if (time()-$_SESSION['timestamp']>$idletime){
    session_unset();
    session_destroy();
    echo "<script> alert('You have been logged out due to inactivity'); </script>";
    echo "<script>
    window.location.href='../';
    </script>";
  }else{
    $_SESSION['timestamp']=time();
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">


    <?php include('_header.php');

  $sql = "SELECT * FROM customer WHERE id='".$_SESSION['user_id']."'";

  db_select($sql);

  if (db_rowcount() > 0) {
    func_setSelectVar();
  }

  $fullname = $firstname." ".$lastname;
  
  $class_id = $_SESSION['cust_class_id'];

  $sql = "SELECT * FROM class WHERE id = '$class_id'";

  db_select($sql);

  if(db_rowcount() > 0)
  {
    func_setSelectVar();
  }

  $sql = "SELECT deposit FROM car_rate WHERE class_id = '$class_id'";

  db_select($sql);

  if(db_rowcount() > 0)
  {
    func_setSelectVar();
  }
  
  $_SESSION['cust_deposit'] = $deposit;
  
  $return_date = $_SESSION['cust_search_return_date'];
  $return_time = $_SESSION['cust_search_return_time'];
  $pickup_date = $_SESSION['cust_search_pickup_date'];
  $pickup_time = $_SESSION['cust_search_pickup_time'];
  
  $subtotal = $_SESSION['cust_subtotal'];
  $est_total = $subtotal+$deposit;
  $_SESSION['cust_est_total'] = $est_total;
  $day = $_SESSION['cust_day'];
  $status = $_SESSION['cust_status'];
  $checkAddDriver = $_SESSION['checkAddDriver'];
  $checkCdw = $_SESSION['checkCdw'];
  $checkStickerP = $_SESSION['checkStickerP'];
  $checkTouchnGo = $_SESSION['checkTouchnGo'];
  $checkDriver = $_SESSION['checkDriver'];
  $checkCharger = $_SESSION['checkCharger'];
  $checkSmartTag = $_SESSION['checkSmartTag'];
  $checkChildSeat = $_SESSION['checkChildSeat'];
  $checkPickupDelivery=$_SESSION['checkPickupDelivery'];
  $inputPickup=$_SESSION['inputPickup'];
  $inputReturn=$_SESSION['inputReturn'];
  $cust_search_pickup_location=$_SESSION['cust_search_pickup_location'];
  $cust_search_return_location=$_SESSION['cust_search_return_location'];
  
  if(isset($_SESSION['booking'])){ 

  $sql = "SELECT * from location where id='".$_SESSION['cust_search_pickup_location']."'";

  db_select($sql);

  $pickup = db_get(0,1);

  $sql = "SELECT * from location where id='".$_SESSION['cust_search_return_location']."'";

  db_select($sql);

  $return = db_get(0,1);

  $sql = "SELECT 
  description, 
  calculation,
  amount_type, 
  amount, 
  taxable, 
  calculation,
  pic,
  case missing_cond 
  WHEN '0' Then '-' 
  WHEN '5' Then 'If missing, RM5' 
  WHEN '50' Then 'If missing, RM50' 
  WHEN '150' Then 'If missing RM150' 
  WHEN '300' Then 'If missing, RM300' 
  End as missing_cond 
  FROM option_rental";

  db_select($sql);

  if (db_rowcount() > 0) {
    func_setSelectVar();
  }



  if($checkAddDriver=="Y"){

    $priceAddDriver = db_get(0, 3);
  }
  else{

    $priceAddDriver = 0;  
  }

  if($checkCdw=="Y"){

    $priceCdw = $subtotal*((db_get(1, 3))/100);
  }
  else{

    $priceCdw = 0;
  }

  if($checkDriver=="Y"){

    $priceDriver = (db_get(4, 3))/8;
    $priceDayDriver = ($day*24)*$priceDriver;
    $priceHourDriver = $time*$priceDriver;
    $priceDriverTotal= $priceDayDriver + $priceHourDriver;
  }
  else{

    $priceDriver = 0;
  }

  if($checkChildSeat=="Y"){

    $priceChildSeat = $day * 5;
  }
  else{

    $priceChildSeat = 0;
  }

  $priceFirstRow = $priceAddDriver + $priceDriverTotal;
}

$totalrow2 = number_format($priceChildSeat,2) + number_format($priceCdw,2);

$totalprice = $priceChildSeat + $priceCdw + $priceFirstRow;

$totalall = $totalprice + $est_total;

$day = dateDifference(conv_datetodbdate($pickup_date), conv_datetodbdate($return_date), '%a');
$time = dateDifference($pickup_time, $return_time, '%h');

if(isset($_POST['formSubmit']))
{

  $_SESSION['payment_timestamp']=time();
  $_SESSION['payment_sess_time']=420;

  require '../vendor/autoload.php';
  $api = '421a747c-6344-463f-aceb-2926767d6a94';
  $totalall = $totalall*100;
  
//   echo "<br>class_name: ".$class_name;

  $collection = 'kbqn8ujd';
  $billplz = Billplz\Client::make($api);
  $response = $billplz->bill()->create(
      $collection,
      $email,
      null,
      $fullname,
      $totalall,
      ['callback_url' => 'myezgo.com/dashboard/index.php','redirect_url' => 'https://www.myezgo.com/user/payment_verification_page.php'],
      $class_name." ~ ".$pickup_date." - ".$return_date." ~ Deposit: RM ".$deposit
  );

      // '100',

  $response->getStatusCode(); $response->toArray();

  $huhu = $response->getContent();

  $url = $huhu['url'];

//   $_SESSION['bill_id'] = $huhu['id'];
  // $_SESSION['bill_id'] = 'qtwdws3u';
//   $_SESSION['sess'] = '0';

  vali_redirect($huhu['url']);
}
  
  ?>




    <body class="nav-md">
      <div class="container body">
        <div class="main_container">

          <?php include('_leftpanel.php'); ?>

          <?php include('_toppanel.php'); ?>



          <!-- page content -->
          <div class="right_col" role="main">

            <div class="">
              <meta name="viewport" content="width=device-width, initial-scale=1">

              <div class="row">
                <div class="col-md-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Booking Confirmation <!-- <small>Activity shares</small> --></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a></li>
                            <li><a href="#">Settings 2</a></li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <h2>RENTAL AND PAYMENT DETAILS</h2>
                      <br>

                      <style type="text/css">
                        .mytable {
                          border-collapse: collapse;
                          width: 100%;
                          background-color: white;
                        }
                        .mytable-head {
                          border: 1px solid black;
                          margin-bottom: 0;
                          padding-bottom: 0;
                        }
                        .mytable-head td {
                          border: 1px solid black;
                        }
                        .mytable-body {
                          border: 1px solid black;
                          border-top: 0;
                          margin-top: 0;
                          padding-top: 0;
                          margin-bottom: 0;
                          padding-bottom: 0;
                          border-bottom: 0;
                        }
                        .mytable-body td {
                          border: 1px solid black;
                          border-top: 0;

                        }
                        .mytable-footer {
                          border: 1px solid black;
                          border-top: 0;
                          margin-top: 0;
                          padding-top: 0;
                        }
                        .mytable-footer td {
                          border: 1px solid black;
                          border-top: 0;
                        }
                      </style>

                      <i>You will have to pay deposit upon booking</i><br>  

                      <form class="form-horizontal form-label-left input_mask" method='post' action="" onsubmit="return validateForm()" name="myForm">
                        
                        <div class="form-group">
                          <label class="control-label" style="text-align:left"><span style="color:red" id="err"><?php echo func_getErrMsg(); ?></span></label>
                        </div>
                        <center>

                          <table class="table table-bordered" style="width: 70%;">
                            <tr>
                              <th colspan="12" style="background-color: #2A3F54; color: white;">
                                <center>Rental & Payment Details</center>
                              </th>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #ededed;">
                                <center><b>Customer</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="background-color: #fafaff;">
                                <b>Renter</b>
                              </td>
                              <td colspan="6">
                                <i><?php echo $fullname; ?></i>
                              </td>
                              <td colspan="2" style="background-color: #f7f7ff;">
                                <b>NRIC No.</b>
                              </td>
                              <td colspan="4">
                                <i><?php echo $nric_no; ?></i>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="background-color: #fafaff;">
                                <b>Address</b>
                              </td>
                              <td colspan="10">
                                <i><?php echo $address; ?></i>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #ededed;">
                                <center><b>Vehicle</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="6" style="background-color: #fafaff;">
                                <center><b>Vehicle Type</b></center>
                              </td>
                              <td colspan="6" style=" background-color: #fafaff;">
                                <center><b>Transmission</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="6">
                                <center><i><?php echo $class_name; ?></i></center>
                              </td>
                              <td colspan="6">
                                <center><i>Auto</i></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #ededed;">
                                <center><b>Duration</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="6" style="background-color: #fafaff;">
                                <center><b>Pickup Date & Time</b></center>
                              </td>
                              <td colspan="6" style="background-color: #fafaff;">
                                <center><b>Return Date & Time</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="6">
                                <center><?php echo $pickup_date." ".$pickup_time; ?></center>
                              </td>
                              <td colspan="6">
                                <center><?php echo $return_date." ".$return_time; ?></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #ededed;">
                                <center><b>Payment Details</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #fafaff;">
                                <table class="table table-bordered">
                                  <tr>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkAddDriver =="Y"){

                                          echo "Y";
                                        }
                                        ?>
                                      </center>
                                    </td>
                                    <td><center><b>Additional Driver</b> <i>(RM 10/Person)</i></center></td>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkDriver  =="Y"){

                                          echo "Y";
                                        }
                                        ?>
                                      </center>
                                    </td>
                                    <td><center><b>Driver</b> <i>(RM 200/8hrs)</i></center></td>
                                    <td><center><b>Price</b> <i>(RM)</i>:</center></td>
                                    <td><center><i><?php echo number_format($priceFirstRow,2); ?></i></center></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkCdw =="Y"){

                                          echo "Y";
                                        }
                                        ?>
                                      </center>
                                    </td>
                                    <td><center><b>CDW</b> <i>(13% of Rental)</i></center></td>
                                    <td>
                                      <center>
                                    
                                        <?php
                                        if($checkChildSeat  =="Y"){
                                          
                                          echo "Y";
                                        }
                                        ?>
                                      </center>
                                    </td>
                                    <td><center><b>Child Seat</b> <i>(RM 5/day if Missing RM 300)</i></center></td>
                                    <td><center><b>Price</b> <i>(RM)</i>:</center></td>
                                    <td><center><i><?php echo number_format($totalrow2,2); ?></i></center></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkStickerP =="Y"){

                                          echo "Y";
                                        }
                                        ?>
                                      </center>
                                    </td>
                                    <td><center><b>Sticker P 2 units</b> <i>(Free if Missing RM 5)</i></center></td>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkCharger =="Y"){

                                          echo "Y";
                                        }
                                        ?> 
                                      </center>
                                    </td>
                                    <td><center><b>USB Charger</b> <i>(Free if Missing RM 50)</i></center></td>
                                    <td><center><b>Price</b> <i>(RM)</i>:</center></td>
                                    <td><center><i>0.00</i></center></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkTouchnGo  =="Y"){
                                          
                                          echo "Y";
                                        }
                                        ?> 
                                      </center>
                                    </td>
                                    <td><center><b>Touch n Go Card</b> <i>(Free if Missing RM 50)</i></center></td>
                                    <td>
                                      <center>
                                        <?php
                                        if($checkSmartTag   =="Y"){
                                          
                                          echo "Y";
                                        }
                                        ?>
                                      </center>
                                    </td>
                                    <td><center><b>Smart Tag</b> <i>(Free if Missing RM 150)</i></center></td>
                                    <td><center><b>Price</b> <i>(RM)</i>:</center></td>
                                    <td><center><i>0.00</i></center></td>
                                  </tr>

                                  <tr>
                                    <td><center>Y</center></td>
                                    <td><center><b>Rental</b> <i>(RM <?php echo number_format($subtotal,2); ?>)</i></center></td>
                                    <td><center>Y</center></td>
                                    <td><center><b>Deposit</b> <i>(RM <?php echo number_format($deposit,2); ?>)</i></center></td>
                                    <td><center><b>Price</b> <i>(RM)</i>:</center></td>
                                    <td><center><i><?php echo number_format($est_total,2); ?></i></center></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4" style="vertical-align: middle; text-align: center;">
                                      <b>Prepared by:</b> <i>MYEZGO ONLINE BOOKING</i>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                      <b>Total Price</b> <i>(RM)</i>:
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                      <i><?php echo number_format($totalall,2); ?></i>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #ededed;">
                                <center><b>Pickup & Return Details</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="text-align: center; background-color: #fafaff;">
                                <b>Pickup Method</b>
                              </td>
                              <td colspan="2" style="text-align: center; background-color: #fafaff;">
                                <b>Return Method</b>
                              </td>
                              <td colspan="2" style="text-align: center; background-color: #fafaff;">
                                <b>Pickup Location</b>
                              </td>
                              <td colspan="2" style="text-align: center; background-color: #fafaff;">
                                <b>Return Location</b>
                              </td>
                              <td colspan="3" style="text-align: center; background-color: #fafaff;">
                                <b>Price</b>
                              </td>
                            </tr>
                            <tr>
                              <?php

                                if($checkPickupDelivery != "Ypickup" && $checkPickupDelivery != "YDelivery") {
                                  
                                  echo "<td colspan='2'><center>At Branch</center></td>";
                                  echo "<td colspan='2'><center>At Branch</center></td>";
                                  echo "<td colspan='2'><center>".$pickup."</center></td>";
                                  echo "<td colspan='2'><center>".$return."</center></td>";
                                  echo "<td colspan='3'><center> None </center></td>";
                                }
                                
                                else if($checkPickupDelivery== "Ypickup") {

                                  echo "<td colspan='2'><center>Need pickup</center></td>";
                                  echo "<td colspan='2'><center>Need pickup</center></td>";
                                  echo "<td colspan='2'><center>".$inputPickup."</center></td>";
                                  echo "<td colspan='2'><center>".$inputReturn."</center></td>";
                                  echo "<td colspan='3'><center>According to location</center></td>";
                                }
                                
                                else if($checkPickupDelivery=="YDelivery") {

                                  echo "<td colspan='2'><center>Delivery</center></td>";
                                  echo "<td colspan='2'><center>Delivery</center></td>";
                                  echo "<td colspan='2'><center>".$inputPickup."</center></td>";
                                  echo "<td colspan='2'><center>".$inputReturn."</center></td>";
                                  echo "<td colspan='3'><center>According to location</center></td>";
                                }
                              ?>
                            </tr>
                            <tr>
                              <td colspan="12" style="background-color: #ededed;">
                                <center><b>Terms And Conditions</b></center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="12">
                                <center>
                                  <table style="width: 80%">
                                    <tr>
                                      <td>
                                        <br>
                                        <p>• Renter must be ensure that they have fill in Car Pickup Form when taking the car and Car Return Form when returning the car thoroughly.</p>
                                        <p>• Fuel level pickup and return must be at the same level. No refund or claim for extra fuel.</p>
                                        <p>• Can't cross the country's border without company's permission. </p>
                                        <p>• Only renter and additional driver can drive this car.</p>
                                        <p>• Renter must obey traffic regulation in Malaysia and any criminal activity or wrong doing is not allowed.</p>
                                        <p>• Rental for third parties is not allowed.</p>
                                        <p>• For extend, renter must notify company and pay first before extend time.</p><p>• Payment is not refundable for early return and renter need to providecollateral item if fail to make payment.</p><p>• Drinking alcohol, drugs usage or carrying pet are not allowed inside car rental during rental period.</p>
                                        <p>• First thing to do when accident is to report immediately to company. Can't use a tow truck not from company.</p>
                                        <p>• Can't use a tow truck not from company</p>
                                        <p>• If accident the charge depends on company loss and the maximum charge is RM3000.</p>
                                        <p>• Company has the right to inform Police when renter suspected do the criminal activity.</p>
                                        <p>• If breaches terms and condition, renter will be blacklist (CTOS) with 10% service charge from outstanding payment and take law action including publishing renter details to website or social media.</p>

                                        <br>

                                        <div class="checkbox">
                                          <label>
                                            <input type="checkbox" onchange="document.getElementById('formSubmit').disabled = !this.checked;" class="flat" value="checked"> I Agree with above conditions and conditions enclosed together with this
                                            agreement
                                          </label>
                                        </div>

                                        <br>

                                        <input type="submit" id="formSubmit" name="formSubmit" value="Continue Payment" title="Please tick the box to proceed" disabled>
                                      </td>
                                    </tr>
                                  </table>
                                </center>
                              </td>
                            </tr>
                          </table>
                        </center>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php include('_footer.php') ?>
        </div>
      </div>
    </body>
  </html>
  <style>

    @-webkit-keyframes ring {
    0% {
    -webkit-transform: rotate(-15deg);
    transform: rotate(-15deg);
    }

    2% {
    -webkit-transform: rotate(15deg);
    transform: rotate(15deg);
    }

    4% {
    -webkit-transform: rotate(-18deg);
    transform: rotate(-18deg);
    }

    6% {
    -webkit-transform: rotate(18deg);
    transform: rotate(18deg);
    }

    8% {
    -webkit-transform: rotate(-22deg);
    transform: rotate(-22deg);
    }

    10% {
    -webkit-transform: rotate(22deg);
    transform: rotate(22deg);
    }

    12% {
    -webkit-transform: rotate(-18deg);
    transform: rotate(-18deg);
    }

    14% {
    -webkit-transform: rotate(18deg);
    transform: rotate(18deg);
    }

    16% {
    -webkit-transform: rotate(-12deg);
    transform: rotate(-12deg);
    }

    18% {
    -webkit-transform: rotate(12deg);
    transform: rotate(12deg);
    }

    20% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
    }
    }

    @keyframes ring {
    0% {
    -webkit-transform: rotate(-15deg);
    -ms-transform: rotate(-15deg);
    transform: rotate(-15deg);
    }

    2% {
    -webkit-transform: rotate(15deg);
    -ms-transform: rotate(15deg);
    transform: rotate(15deg);
    }

    4% {
    -webkit-transform: rotate(-18deg);
    -ms-transform: rotate(-18deg);
    transform: rotate(-18deg);
    }

    6% {
    -webkit-transform: rotate(18deg);
    -ms-transform: rotate(18deg);
    transform: rotate(18deg);
    }

    8% {
    -webkit-transform: rotate(-22deg);
    -ms-transform: rotate(-22deg);
    transform: rotate(-22deg);
    }

    10% {
    -webkit-transform: rotate(22deg);
    -ms-transform: rotate(22deg);
    transform: rotate(22deg);
    }

    12% {
    -webkit-transform: rotate(-18deg);
    -ms-transform: rotate(-18deg);
    transform: rotate(-18deg);
    }

    14% {
    -webkit-transform: rotate(18deg);
    -ms-transform: rotate(18deg);
    transform: rotate(18deg);
    }

    16% {
    -webkit-transform: rotate(-12deg);
    -ms-transform: rotate(-12deg);
    transform: rotate(-12deg);
    }

    18% {
    -webkit-transform: rotate(12deg);
    -ms-transform: rotate(12deg);
    transform: rotate(12deg);
    }

    20% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
    }
    }

    @-webkit-keyframes horizontal {
    0% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
    }

    6% {
    -webkit-transform: translate(-5px,0);
    transform: translate(-5px,0);
    }

    12% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
    }

    18% {
    -webkit-transform: translate(-5px,0);
    transform: translate(-5px,0);
    }

    24% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
    }

    30% {
    -webkit-transform: translate(-5px,0);
    transform: translate(-5px,0);
    }

    36% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
    }
    }

    @keyframes horizontal {
    0% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
    }

    6% {
    -webkit-transform: translate(-5px,0);
    -ms-transform: translate(-5px,0);
    transform: translate(-5px,0);
    }

    12% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
    }

    18% {
    -webkit-transform: translate(-5px,0);
    -ms-transform: translate(-5px,0);
    transform: translate(-5px,0);
    }

    24% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
    }

    30% {
    -webkit-transform: translate(-5px,0);
    -ms-transform: translate(-5px,0);
    transform: translate(-5px,0);
    }

    36% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
    }
    }

    .faa-ring.animated,
    .faa-ring.animated-hover:hover,
    .faa-parent.animated-hover:hover > .faa-ring {
    -webkit-animation: ring 4s ease infinite;
    animation: ring 4s ease infinite;
    transform-origin-x: 50%;
    transform-origin-y: 0px;
    transform-origin-z: initial;

    }

    .faa-horizontal.animated,
    .faa-horizontal.animated-hover:hover,
    .faa-parent.animated-hover:hover > .faa-horizontal {
    -webkit-animation: horizontal 2s ease infinite;
    animation: horizontal 2s ease infinite;
    }

  </style>
  <?php
} 
else{

  echo "<script>
  window.alert('You need to login to continue');
  window.location.href='../login.php';
  </script>";
}
?>