<?php
session_start();
if(isset($_SESSION['cid']))
{ 
  
  $idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

  if (time()-$_SESSION['timestamp']>$idletime){
    session_unset();
    session_destroy();
    echo "<script> alert('You have been logged out due to inactivity'); </script>";
        echo "<script>
                window.location.href='index.php';
            </script>";
  }else{
    $_SESSION['timestamp']=time();
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">


  <?php
  include ("_header.php"); 

  func_setReqVar(); 

  $sql = "SELECT agreement_no FROM booking_trans WHERE id=".$_GET['booking_id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 

  $sql = "SELECT * FROM upload_data WHERE BOOKING_TRANS_ID=".$_GET['booking_id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 


  $sql = "SELECT * FROM user WHERE id=".$_SESSION['cid']; 
  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 



    $id = $_GET['booking_id']; 
    $class_id = $_GET['class_id'];

    $sql="SELECT vehicle_id FROM booking_trans WHERE id=".$id;
    db_select($sql); 
    
    for ($i = 0; $i < db_rowcount(); $i++) { 

      $vehicle_id = db_get($i,0);     

    }

    $sql = "SELECT * FROM booking_trans WHERE id = '$id'"; 

      db_select($sql); 

      if (db_rowcount() > 0) { 

        func_setSelectVar(); 

      }

    ?>



  <style>
  .small .btn, .navbar .navbar-nav > li > a.btn {
    padding: 10px 10px;
  }

  .color-background {
    background-color: #eeeeee;
    border-radius: 5px 5px;
    padding: 10px;
  }

  .modal-backdrop, .modal-backdrop.fade.in {
    opacity: 0;
  }

  #canvas
  {
  width: 100%;
  height: 100%;
  background: url('assets/img/car.png');
  background-repeat:no-repeat;
  background-size:contain;
  background-position:center;
  }

  #board
  {
  width: 100%;
  height: 100%;
  background: url('assets/img/car.png');
  background-repeat:no-repeat;
  background-size:contain;
  background-position:center;
  }

  #return_sign 
  {
  width: 100%;
  height: 100%;
  /*rder: 1px solid #000;*/*/*/
  }
  </style>

  <script src="assets/js/fabric.min.js"></script>
  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="assets/js/html5-canvas-drawing-app.js"></script>

    <body class="nav-md">
      <div class="container body">
        <div class="main_container">

          <?php include('_leftpanel.php'); ?>

          <?php include('_toppanel.php'); ?>

          <!-- page content -->
          <div class="right_col" role="main">
            <div class="">

            <div class="page-title">
                <div class="title_left">
                  <h3>Delete Approval</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <div class="row">

                        <div class="btn-group" style="float: right;">
                          <a href="delete_reservation_list.php?agreement_no=<?php echo $agreement_no; ?>&booking_id=<?php echo $id; ?>&delete=true">
                            <button class="btn btn-default" type="button"><i class="fa fa-check">&nbsp;</i>Confirm Delete</button>
                          </a>
                          <a href="delete_reservation_list.php?agreement_no=<?php echo $agreement_no; ?>&booking_id=<?php echo $id; ?>&delete=false">
                            <button class="btn btn-default" type="button"><i class="fa fa-close">&nbsp;</i>Decline</button>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4" style="text-align: center;">
                        <img width="240px" src='assets/img/logo.png'>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="row">
                            <h4><?php echo $company_name; ?></h4>
                            <p><?php echo $website_name; ?></p>
                            <p><?php echo $company_address; ?></p>
                            <p><?php echo $company_phone_no; ?></p>
                            <p><?php echo $registration_no; ?></p>
                            
                            <div>
                              Reference No.
                              <div class="form-group">
                                <div class='input-group date' id='myDatepicker'>
                                  <input class="form-control" type="text" name="refno" value="<?php echo $agreement_no;?>" disabled>
                                </div>
                                <br><b>Reason delete:</b> <i><font color='red'><?php echo $reason; ?></font></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                  </div>
                </div>
                <?php
   $sql = "SELECT
    vehicle.id AS vehicle_id,
    DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
    DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
    CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
    DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
    DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
    CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
    concat(firstname,' ' ,lastname) AS fullname,
    concat(make, ' ', model) AS car,
    reg_no,
    nric_no,
    address,
    phone_no,
    email,
    license_no,
    sub_total,
    refund_dep,
    car_in_image,
    car_in_start_engine,
    car_in_no_alarm,
    car_in_air_conditioner,
    car_in_radio,
    car_in_power_window,
    car_in_window_condition,
    car_in_perfume,
    car_in_carpet,
    car_in_sticker_p,
    car_in_lamp,
    car_in_engine_condition,
    car_in_tyres_condition,
    car_in_jack,
    car_in_tools,
    car_in_signage,
    car_in_child_seat,
    car_in_wiper,
    car_in_gps,
    car_in_tyre_spare,
    car_in_usb_charger,
    car_in_touch_n_go,
    car_in_smart_tag,
    car_in_seat_condition,
    car_in_cleanliness,
    car_in_fuel_level,
    car_in_remark,
    car_out_image,
    car_out_sign_image,
    car_out_start_engine,
    car_out_no_alarm,
    car_out_air_conditioner,
    car_out_radio,
    car_out_power_window,
    car_out_window_condition,
    car_out_perfume,
    car_out_carpet,
    car_out_sticker_p,
    car_out_lamp,
    car_out_engine_condition,
    car_out_tyres_condition,
    car_out_jack,
    car_out_tools,
    car_out_signage,
    car_out_child_seat,
    car_out_wiper,
    car_out_gps,
    car_out_tyre_spare,
    car_out_usb_charger,
    car_out_touch_n_go,
    car_out_smart_tag,
    car_out_seat_condition,
    car_out_cleanliness,
    car_out_fuel_level,
    car_out_remark,
    agreement_no,
    car_in_checkby
    FROM customer
    JOIN booking_trans ON customer.id = customer_id 
    JOIN vehicle ON vehicle_id = vehicle.id
    JOIN checklist ON booking_trans_id = booking_trans.id
    WHERE booking_trans.id=".$_GET['booking_id']; 

    db_select($sql); 

    if (db_rowcount() > 0) { 

      func_setSelectVar(); 

    } 

    ?>


                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Customer Information</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $fullname; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $nric_no; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Driving License</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $license_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Address
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $address; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone No
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $phone_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Email
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $email; ?>" disabled>
                          </div>
                        </div>
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>

                  <!-- End Customer Information -->


                  <!-- Start Payment Information -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Payment Information</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $sub_total; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $refund_dep; ?>" disabled>
                          </div>
                        </div>
                      


                   
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>
                  <!-- End Payment Information -->


                  <!-- Start Vehicle Information -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Vehicle Information</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $car; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Register Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $reg_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_date; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_time; ?>" disabled>
                          </div>
                        </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_date; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_time; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_location; ?>" disabled>
                          </div>
                        </div>


                   
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>
                  <!-- End Vehicle Information -->

                  <!-- Start Vehicle Checklist -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Vehicle Checklist</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Checklist</th>
                            <th>Pickup</th>
                            <th>Return</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">Start Engine</th>
                            <td><?php echo $car_out_start_engine; ?></td>
                            <td><?php echo $car_in_start_engine; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">No Alarm</th>
                            <td><?php echo $car_out_no_alarm; ?></td>
                            <td><?php echo $car_in_no_alarm; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Wiper</th>
                            <td><?php echo $car_out_wiper; ?></td>
                            <td><?php echo $car_in_wiper; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Air Conditioner</th>
                            <td><?php echo $car_out_air_conditioner; ?></td>
                            <td><?php echo $car_in_air_conditioner; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Radio</th>
                            <td><?php echo $car_out_radio; ?></td>
                            <td><?php echo $car_in_radio; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Power Window</th>
                            <td><?php echo $car_out_power_window; ?></td>
                            <td><?php echo $car_in_power_window; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Perfumed</th>
                            <td><?php echo $car_out_perfume; ?></td>
                            <td><?php echo $car_in_perfume; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Carpet</th>
                            <td><?php echo $car_out_carpet; ?></td>
                            <td><?php echo $car_in_carpet; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Lamp</th>
                            <td><?php echo $car_out_lamp; ?></td>
                            <td><?php echo $car_in_lamp; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Engine Condition</th>
                            <td><?php echo $car_out_engine_condition; ?></td>
                            <td><?php echo $car_in_engine_condition; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Tyres Condition</th>
                            <td><?php echo $car_out_tyres_condition; ?></td>
                            <td><?php echo $car_in_tyres_condition; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Jack</th>
                            <td><?php echo $car_out_jack; ?></td>
                            <td><?php echo $car_in_jack; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Tools</th>
                            <td><?php echo $car_out_tools; ?></td>
                            <td><?php echo $car_in_tools; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Signage</th>
                            <td><?php echo $car_out_signage; ?></td>
                            <td><?php echo $car_in_signage; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Tyre Spare</th>
                            <td><?php echo $car_out_tyre_spare; ?></td>
                            <td><?php echo $car_in_tyre_spare; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Sticker P  </th>
                            <td><?php echo $car_out_sticker_p; ?></td>
                            <td><?php echo $car_in_sticker_p; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">USB Charger  </th>
                            <td><?php echo $car_out_usb_charger; ?></td>
                            <td><?php echo $car_in_usb_charger; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Touch N Go  </th>
                            <td><?php echo $car_out_touch_n_go; ?></td>
                            <td><?php echo $car_in_touch_n_go; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">SmartTag  </th>
                            <td><?php echo $car_out_smart_tag; ?></td>
                            <td><?php echo $car_in_smart_tag; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Child Seat  </th>
                            <td><?php echo $car_out_child_seat; ?></td>
                            <td><?php echo $car_in_child_seat; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">GPS  </th>
                            <td><?php echo $car_out_gps; ?></td>
                            <td><?php echo $car_in_gps; ?></td>
                          </tr>

                        </tbody>
                      </table>

                      </form>
                    </div>
                  </div>
                  <!-- End Vehicle Checklist -->

                  <!-- Start Car Image State -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Car Image State</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


  <!-- imagestart -->

  <?php

  $sql = "SELECT * FROM upload_data WHERE BOOKING_TRANS_ID='".$_GET['booking_id']."' ORDER BY ID desc LIMIT 6";

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 




  ?>


          <div class="table-responsive">
          <table class="table">
          <tbody>

          <tr>

              <?php

          for($i=0;$i<6;$i++){
        
          $no=$i+1; 

          if(db_get($i,4)!=''|db_get($i,4)!=null ){
        
          echo '<td><img src="assets/img/car_state/'.db_get($i,2).'" style="height:190px; width:280px;"></td>';

                  } 

              } 
              
        ?>
      </tr>
    </tbody>
  </table>
  </div>


  <!-- imageend -->

                   
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>
                  <!-- End Car Image State -->

                                  <!-- Start Car Condition -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Car Condition</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Remark P</th>
                            <th>Remark R</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">Car Seat Condition</th>
                            <td><?php echo $car_out_seat_condition; ?></td>
                            <td><?php echo $car_in_seat_condition; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Cleanliness</th>
                            <td><?php echo $car_out_cleanliness; ?></td>
                            <td><?php echo $car_in_cleanliness; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Fuel Level</th>
                            <td><?php echo $car_out_fuel_level; ?></td>
                            <td><?php echo $car_in_fuel_level; ?></td>
                          </tr>

                        </tbody>
                      </table>

                      </form>
                    </div>
                  </div>
                  <!-- End Car Condition -->

                                 <!-- Start Car Condition Pic-->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Remark: | = Scratch | O Broden | △ Dent | □ Missing</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />

                      <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Pickup</th>
                <th>Return</th>
              </tr>
            </thead>
            
            <tbody>

            <tr>
      
  <td>
            <?php if($car_out_image==''||$car_out_image==null){  ?>

            
              
            
            <img src="pickup.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php } else{ 

            //for pickup
              
            $png = imagecreatefrompng($car_out_image);
            $jpeg = imagecreatefromjpeg('pickup.jpg');

            list($width, $height) = getimagesize('pickup.jpg');
            list($newwidth, $newheight) = getimagesize($car_out_image);
            $out = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
            imagejpeg($out, 'give.jpg', 100); ?>

            <img src="give.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php } ?>

          </td>

          <td>

            <?php if($car_in_image==''||$car_in_image==null){   ?>
            
            <img src="return2.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php } else{

            //for return
            $png2 = imagecreatefrompng($car_in_image);
            $jpeg2 = imagecreatefromjpeg('return2.jpg');

            list($width2, $height2) = getimagesize('return2.jpg');
            list($newwidth2, $newheight2) = getimagesize($car_in_image);
            $out2 = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($out2, $jpeg2, 0, 0, 0, 0, $newwidth2, $newheight2, $width2, $height2);
            imagecopyresampled($out2, $png2, 0, 0, 0, 0, $newwidth2, $newheight2, $newwidth2, $newheight2);
            imagejpeg($out2, 'take.jpg', 100);

            ?> 

              <img src="take.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php }
             ?>

          </td>

          </tr>
          </tbody>
          </table>

          
        </div>



                    </div>
                  </div>
                  <!-- End Car Condition Pic-->

                  <!-- Start Extend Information -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Extend Information</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Extend Date</th>
                            <th>Payment Status</th>
                            <th>Payment Type</th>
                            <th>Payment Date</th>
                            <th>Payment Price</th>
                            </tr>
                         </thead>
                         <tbody>
                      
                      <?php
                      
            $sql= "SELECT 
            DATE_FORMAT(extend_from_date, '%d/%m/%Y'),
            DATE_FORMAT(extend_from_time, '%H:%i'), 
            DATE_FORMAT(extend_to_date, '%d/%m/%Y') AS extend_to_date,
            DATE_FORMAT(extend_to_time, '%H:%i'),
            payment_status,
            payment_type,
            DATE_FORMAT(c_date, '%d/%m/%Y'),
            price
            extend_from_time
            FROM extend
            WHERE booking_trans_id=".$_GET['booking_id']; 

                              db_select($sql); 

                              func_setTotalPage(db_rowcount()); 

                              db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                              if(db_rowcount()>0){

                                  for($i=0;$i<db_rowcount();$i++){

                                      if(func_getOffset()>=10){ 

                                      $no=func_getOffset()+1+$i; 

                                      } 

                                   else{ 

                                      $no=$i+1; 

                                      } 

                          echo "<tr>
                          <th scope='row'>" . $no . "</th>
                          <td>".db_get($i,0)." @ ".db_get($i,1)." - ".db_get($i,2)." @ ".db_get($i,3)."</td>
                <td>".db_get($i,4)."</td>
                <td>".db_get($i,5)."</td>
                <td>".db_get($i,6)."</td>
                <td>RM ".db_get($i,7)."</td>
                          </tr>";
             
              $extendrow = db_rowcount();


                                  }

                              } else{ echo "<tr><td colspan='8'>No records found</td></tr>"; }
                         

                          ?>

                      </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- End Extend Information -->

  <!-- Start Receipt -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Receipt</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Pay to (Name)</th>
                            <th>Return Date @ Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?php echo $fullname; ?></td>
                            <td><?php echo $return_date; ?></td>
                          </tr>
                        </tbody>

                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Payment To Customer</th>
                            <th>Details</th>
                            <th>Payment Status</th>
                            <th>Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Deposit</td>
                            <td>Pay Deposit To Customer</td>
                            <td><?php echo $refund_dep_payment; ?></td>
                            <td><?php echo 'RM'.$refund_dep; ?></td>
                          </tr>

                          <tr>
                            <td>2</td>
                            <td><?php

                            if($other_details=='' | $other_details==null ){


                                       }else{

                                     echo 'Others';


                                       }

                             ?></td>
                            <td><?php echo $other_details; ?></td>
                            <td><?php echo $other_details_payment_type; ?></td>
                            <td><?php echo 'RM '.$other_details_price; ?></td>
                          </tr>

                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td><?php 

                            $total_receipt = ($refund_dep + $other_details_price); 

                            if($other_details_price=='' || $other_details_price==null){

                            echo 'RM '.$refund_dep;               

                            }
                            else{

                            echo 'RM '.$total_receipt;                


                            }

                             ?></td>
                          </tr>



                        </tbody>

                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Payment From Customer</th>
                            <th>Details</th>
                            <th>Payment Type</th>
                            <th>Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Outstanding Extend</td>
                            <td><?php echo $outstanding_extend; ?></td>
                            <td><?php echo $outstanding_extend_type_of_payment ?></td>
                            <td><?php echo 'RM '.$outstanding_extend_cost; ?></td>
                          </tr>

                          <tr>
                            <td>2</td>
                            <td>Charges for Damages</td>
                            <td><?php echo $damage_charges_details; ?></td>
                            <td><?php echo $damage_charges_payment_type; ?></td>
                            <td><?php echo 'RM '.$damage_charges; ?></td>
                          </tr>

                          <tr>
                            <td>3</td>
                            <td>Charges items missing items</td>
                            <td><?php echo $missing_items_charges_details; ?></td>
                            <td><?php echo $missing_items_charges_payment_type; ?></td>
                            <td><?php echo 'RM '.$missing_items_charges; ?></td>
                          </tr>

                          <tr>
                            <td>4</td>
                            <td>Additional Cost</td>
                            <td><?php echo $additional_cost_details; ?></td>
                            <td><?php echo $additional_cost_payment_type; ?></td>
                            <td><?php echo 'RM '.$additional_cost; ?></td>
                          </tr>

                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td><?php 
                            $total_customer_payment = ($outstanding_extend_cost + $damage_charges + $missing_items_charges + $additional_cost);  

                            echo 'RM '.$total_customer_payment; ?></td>
                          </tr>

                        </tbody>

                        <thead>
                          <tr>
                            <th>Prepared By</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?php echo $car_in_checkby; ?></td>
                          </tr>
                        </tbody>

                      </table>


                      
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>
                  <!-- End Receipt -->

                </div>
              </div>



            </div>
          </div>
          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>

      <script>
        var time = new Date().getTime();
        $(document.body).bind("mousemove keypress", function(e) {
          time = new Date().getTime();
        });

        function refresh() {
          if(new Date().getTime() - time >= 1200000) 
            window.location.reload(true);
          else 
            setTimeout(refresh, 1200000);
        }

        setTimeout(refresh, 1200000);
      </script>
    </body>
  </html>
<?php  
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>