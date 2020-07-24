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

$day = dateDifference(conv_datetodbdate($pickup_date), conv_datetodbdate($return_date), '%a');
$time = dateDifference($pickup_time, $return_time, '%h');

$subtotal = $subtotal+$priceCdw+$priceChildSeat+$priceFirstRow+$priceAddDriver;

if(isset($_POST['formSubmit']))
{

  $_SESSION['payment_timestamp']=time();
  $_SESSION['payment_sess_time']=420;

  require '../vendor/autoload.php';
  $api = '421a747c-6344-463f-aceb-2926767d6a94';
  
//   echo "<br>class_name: ".$class_name;

  $collection = 'kbqn8ujd';
//   $collection = '9khp14er';      //   test
  $billplz = Billplz\Client::make($api);
  $response = $billplz->bill()->create(
      $collection,
      $email,
      null,
      $fullname,
      $est_total.'00',
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

                      <form class="form-horizontal form-label-left input_mask" method='post' action="" onsubmit="return validateForm()" name="myForm">
                        
                        <div class="form-group">
                          <label class="control-label" style="text-align:left"><span style="color:red" id="err"><?php echo func_getErrMsg(); ?></span></label>
                        </div>
                        
                        <div class="container">
                          <div class="col-xs-12">

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

                            <i>You will have to pay deposit upon booking</i><br><br>
                            <div style="overflow-x:auto;">
                              <table class="mytable mytable-head" style="width:100%">
                                <tr>
                                  <td style="background-color: #DCDCDC;"><center>RENTAL AND PAYMENT DETAILS</center></td>
                                </tr>
                              </table>
                            </div>

                            <table class=" mytable mytable-body">
                              
                              <tr>
                                <td width="90px"><center>Vehicle:</center></td>
                                <td width="271px"><center><?php echo $class_name; ?></center></td>
                                <td width="70px"><center>Deposit:</center></td>
                                <td width="251px"><center>RM <?php echo number_format($deposit,2); ?></center></td>
                              </tr>

                            </table>
                            <table class=" mytable mytable-body" >
                              
                              <tr>
                                <td width="75px"><center>Pickup Date @ Time:</center></td>
                                <td width="271px"><center><?php echo $pickup_date.' @ '.$pickup_time; ?></center></td>
                                <td width="70px"><center>Return Date @ Time:</center></td>
                                <td width="271px"><center><?php echo $return_date.' @ '.$return_time;; ?></center></td>
                                <td width="70px"><center>Rental:</center></td>
                                <td width="251px"><center><?php echo 'RM '.number_format($subtotal,2); ?></center></td>
                              </tr>

                            </table>
                            <table class=" mytable mytable-body">
                              
                              <tr>
                                <td width="75px" rowspan="3"><center>Customer Pickup:</center></td>
                                <td width="26px">
                                  <center>
                                  <?php
                                  if($checkPickupDelivery!="Ypickup" && $checkPickupDelivery!="YDelivery"){
                                    
                                    echo "Y";
                                  }
                                  ?>
                                  </center>
                                </td>
                                <td width="77px"><center>At Branch</center></td>
                                <td width="509px" style="border-bottom: 0px;"><center></center></td>
                                <td width="70px" style="border-bottom: 0px;"><center></center></td>
                                <td width="251px" style="border-bottom: 0px;"><center></center></td>
                              </tr>

                              <tr>
                                <td width="26px">
                                  <center>
                                  <?php
                                  if($checkPickupDelivery=="Ypickup"){

                                    echo "Y";
                                  }
                                  ?>
                                  </center>
                                </td>
                                <td width="77px" ><center>Pickup</center></td>
                                <td width="509px" style="border-bottom: 0px;">
                                  <center>
                                    <?php 
                                    if($checkPickupDelivery=="YDelivery" || $checkPickupDelivery=="Ypickup"){

                                      echo $inputPickup; 
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="70px" style="border-bottom: 0px;"><center></center></td>
                                <td width="251px" style="border-bottom: 0px;"><center></center></td>
                              </tr>

                              <tr>
                                <td width="26px">
                                  <center>
                                    <?php  
                                    if($checkPickupDelivery=="YDelivery"){
                                      
                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="77px"><center>Delivery</center></td>
                                <td width="509px"><center></center></td>
                                <td width="70px" style="border-bottom: 0px;"><center>Price:</center></td>
                                <td width="251px" style="border-bottom: 0px;">
                                  <center>
                                    <?php
                                    if($checkPickupDelivery=="Ypickup" || $checkPickupDelivery=="YDelivery"){

                                      echo "According to location";
                                    }
                                    else {

                                      echo "RM 0.00";
                                    }
                                    ?>
                                  </center>
                                </td>
                              </tr>
                            </table>

                            <table class=" mytable mytable-body" style="width:100%">
                              <tr>
                                <td width="75px" rowspan="3"><center>Customer Return:</center></td>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkPickupDelivery!="Ypickup" && $checkPickupDelivery != "YDelivery"){

                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="77px"><center>At Branch</center></td>
                                <td width="509px" style="border-bottom: 0px;"><center></center></td>
                                <td width="70px" style="border-bottom: 0px;"><center></center></td>
                                <td width="251px" style="border-bottom: 0px;"><center></center></td>
                              </tr>
                              <tr>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkPickupDelivery=="Ypickup"){
                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="77px" ><center>Pickup</center></td>
                                <td width="509px" style="border-bottom: 0px;">
                                  <center>
                                    <?php 
                                    if($checkPickupDelivery=="Ypickup" || $checkPickupDelivery=="YDelivery"){

                                      echo $inputReturn;
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="70px" style="border-bottom: 0px;"><center></center></td>
                                <td width="251px" style="border-bottom: 0px;"><center></center></td>
                              </tr>

                              <tr>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkPickupDelivery=="YDelivery"){

                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="77px"><center>Delivery</center></td>
                                <td width="509px"><center></center></td>
                                <td width="70px"><center></center></td>
                                <td width="251px"><center></center></td>
                              </tr>

                            </table>

                            <table class="mytable mytable-body" style="width:100%" >
                              
                              <tr>
                                <td width="75px" rowspan="6"><center>Extra Services:</center></td>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkAddDriver =="Y"){

                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="280px"><center>Additional Driver (RM10/Person)</center></td>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkDriver  =="Y"){

                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="280px"><center>Driver (RM200/8hrs)</center></td>
                                <td width="70px"><center>Price:</center></td>
                                <td width="251px"><center>RM <?php echo number_format($priceFirstRow,2); ?></center></td>
                              </tr>

                              <tr>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkCdw =="Y"){

                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="280px"><center>CDW (13%)</center></td>
                                <td width="26px"><center></center></td>
                                <td width="280px"><center>Travel Insurance (10%)</center></td>
                                <td width="70px"><center>Price:</center></td>
                                <td width="251px""><center>RM <?php echo number_format($priceCdw,2); ?></center></td>
                              </tr>
                              <tr>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkStickerP =="Y"){

                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="280px"><center>Sticker P 2 units (Free if Missing RM5)</center></td>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkCharger =="Y"){

                                      echo "Y";
                                    }
                                    ?> 
                                  </center>
                                </td>
                                <td width="280px"><center>USB Charger (Free if Missing RM50)</center></td>
                                <td width="70px"><center>Price:</center></td>
                                <td width="251px"><center>RM 0.00</center></td>
                              </tr>
                              <tr>

                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkTouchnGo  =="Y"){
                                      
                                      echo "Y";
                                    }
                                    ?> 
                                  </center>
                                </td>
                                <td width="280px"><center>Touch n Go Card (Free if Missing RM50)</center></td>
                                <td width="26px">
                                  <center>
                                    <?php
                                    if($checkSmartTag   =="Y"){
                                      
                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="280px"><center>Smart Tag (Free if Missing RM150)</center></td>
                                <td width="70px"><center>Price:</center></td>
                                <td width="251px"><center>RM 0.00</center></td>
                              </tr>

                              <tr>
                                <td width="26px"><center></center></td>
                                <td width="280px"><center>GPS (Free if Missing RM300)</center></td>
                                <td width="26px">
                                  <center>
                                
                                    <?php
                                    if($checkChildSeat  =="Y"){
                                      
                                      echo "Y";
                                    }
                                    ?>
                                  </center>
                                </td>
                                <td width="280px"><center>Child Seat (RM30 if Missing RM300)</center></td>
                                <td width="70px"><center>Price:</center></td>
                                <td width="251px"><center>RM <?php echo number_format($priceChildSeat,2); ?></center></td>
                              </tr>

                              <tr>
                                <td width="26px"><center></center></td>
                                <td width="280px"><center></center></td>
                                <td width="26px"><center></center></td>
                                <td width="280px"><center></center></td>
                                <td width="70px"><center>Price:</center></td>
                                <td width="251px"><center></center></td>
                              </tr>
                            </table>

                            <table class=" mytable mytable-body" style="width:100%">

                              <tr>
                                  <td width="75px" rowspan="3"><center>Payment Details Deposit:</center></td>
                                  <td width="26px"><center></center></td>
                                  <td width="70px"><center>Cash</center></td>
                                  <td width="140px" style="border-bottom: 0px;"><center></center></td>
                                  <td width="140px" style="border-bottom: 0px;"><center></center></td>
                                  <td width="26px"><center></center></td>
                                  <td width="70px"><center>Cash</center></td>
                                  <td width="140px" style="border-bottom: 0px;"><center></center></td>
                                  <td width="70px" style="border-bottom: 0px;"><center></center></td>
                                  <td width="251px" style="border-bottom: 0px;"><center></center></td>
                                </tr>

                                <tr>
                                  <td width="26px"><center></center></td>
                                  <td width="70px"><center>Online</center></td>
                                  <td width="140px" style="border-bottom: 0px;"><center><?php echo 'RM '.number_format($deposit,2); ?></center></td>
                                  <td width="140px" style="border-bottom: 0px;"><center>Payment Details Rental & Others</center></td>
                                  <td width="26px"><center></center></td>
                                  <td width="70px"><center>Online</center></td>
                                  <td width="140px" style="border-bottom: 0px;"><center><?php echo 'RM '.number_format($subtotal,2); ?></center></td>
                                  <td width="70px" style="border-bottom: 0px;"><center>Total</center></td>
                                  <td width="251px" style="border-bottom: 0px;"><center><?php echo 'RM '.number_format($est_total,2); ?></center></td>
                                </tr>

                                <tr>
                                  <td width="26px"><center></center></td>
                                  <td width="70px"><center>Card</center></td>
                                  <td width="140px"><center></center></td>
                                  <td width="140px"><center></center></td>
                                  <td width="26px"><center></center></td>
                                  <td width="70px"><center>Card</center></td>
                                  <td width="140px"><center></center></td>
                                  <td width="70px"><center></center></td>
                                  <td width="251px"><center></center></td>
                                </tr>
                              </table>

                              <table class="mytable mytable-footer" style="width:100%">

                                <tr>
                                  <td width="30.7%"><center>Prepared by: MYEZGO ONLINE BOOKING</center></td>
                                  <td width="70.3%"><center>Name: <?php echo $firstname .' '. $lastname; ?></center></td>
                                </tr>
                              </table>
                              <div class="ln_solid"></div>
                              
                              <br>

                              <h2>Terms And Conditions</h2>

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
                            </div>
                          </div>
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