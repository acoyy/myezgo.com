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
   include("_header.php"); 
   func_setReqVar();  
  ?>

  <style>
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  </style>


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
                  <h3>Special Case</h3>
                </div>  
              </div>

              <div class="clearfix"></div>

              <div class="row">
                <?php
                $type = $_GET['type'];
                $extend_id = $_GET['extend_id'];
                $booking_id = $_GET['booking_id'];

                if($type == 'sale')
                { 

                  $sql = "SELECT 
                      agreement_no,
                      concat(firstname,' ' ,lastname) AS fullname,
                      nric_no,
                      phone_no,
                      age,
                      address,
                      postcode,
                      city,
                      country,
                      total_sale,
                      sale.id AS sale_id,
                      sale.pickup_date AS sale_pickup_date,
                      sale.return_date AS sale_return_date,
                      booking_trans.vehicle_id,
                      concat(make, ' ', model) AS car,
                      reg_no,
                      class_id
                      FROM sale
                      LEFT JOIN booking_trans ON booking_trans.id = sale.booking_trans_id
                      LEFT JOIN customer ON customer.id = booking_trans.customer_id
                      LEFT JOIN vehicle ON vehicle.id = booking_trans.vehicle_id
                      WHERE sale.booking_trans_id = '$booking_id' AND sale.type = 'Sale'
                  ";

                  db_select($sql);

                  if(db_rowcount() > 0)
                  {
                    func_setSelectVar();
                  }

                ?>
                  <div class="col-md-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Normal Sale</h2>
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
                        <form id="demo-form2" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Agreement No.</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control" value="<?php echo $agreement_no; ?>" disabled>
                            </div>
                          </div>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control" value="<?php echo $reg_no .' - '.$car; ?>" disabled>
                            </div>
                          </div>

                          <br><br>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Date?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='date_edit' id='date_edit' value='true' disabled>
                              <label class='switch'>
                                <input id='date_toggle' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" class="form-control" name='sale_pickup_date' id='sale_pickup_date' value="<?php echo date('Y-m-d', strtotime($sale_pickup_date)); ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="sale_pickup_time" id='sale_pickup_time' class="form-control" disabled>
                                <option <?php echo vali_iif('08:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                                <option <?php echo vali_iif('08:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                                <option <?php echo vali_iif('09:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                                <option <?php echo vali_iif('09:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                                <option <?php echo vali_iif('10:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                                <option <?php echo vali_iif('10:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                                <option <?php echo vali_iif('11:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                                <option <?php echo vali_iif('11:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                                <option <?php echo vali_iif('12:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                                <option <?php echo vali_iif('12:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                                <option <?php echo vali_iif('13:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                                <option <?php echo vali_iif('13:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                                <option <?php echo vali_iif('14:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                                <option <?php echo vali_iif('14:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                                <option <?php echo vali_iif('15:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                                <option <?php echo vali_iif('15:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                                <option <?php echo vali_iif('16:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                                <option <?php echo vali_iif('16:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                                <option <?php echo vali_iif('17:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                                <option <?php echo vali_iif('17:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                                <option <?php echo vali_iif('18:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                                <option <?php echo vali_iif('18:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                                <option <?php echo vali_iif('19:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                                <option <?php echo vali_iif('19:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                                <option <?php echo vali_iif('20:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                                <option <?php echo vali_iif('20:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                                <option <?php echo vali_iif('21:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                                <option <?php echo vali_iif('21:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                                <option <?php echo vali_iif('22:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                                <option <?php echo vali_iif('22:30' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                                <option <?php echo vali_iif('23:00' == date('H:i', strtotime($sale_pickup_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" class="form-control" name='sale_return_date' id='sale_return_date' value="<?php echo date('Y-m-d', strtotime($sale_return_date)); ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="sale_return_time" id='sale_return_time' class="form-control" disabled>
                                <option <?php echo vali_iif('08:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                                <option <?php echo vali_iif('08:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                                <option <?php echo vali_iif('09:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                                <option <?php echo vali_iif('09:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                                <option <?php echo vali_iif('10:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                                <option <?php echo vali_iif('10:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                                <option <?php echo vali_iif('11:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                                <option <?php echo vali_iif('11:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                                <option <?php echo vali_iif('12:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                                <option <?php echo vali_iif('12:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                                <option <?php echo vali_iif('13:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                                <option <?php echo vali_iif('13:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                                <option <?php echo vali_iif('14:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                                <option <?php echo vali_iif('14:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                                <option <?php echo vali_iif('15:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                                <option <?php echo vali_iif('15:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                                <option <?php echo vali_iif('16:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                                <option <?php echo vali_iif('16:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                                <option <?php echo vali_iif('17:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                                <option <?php echo vali_iif('17:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                                <option <?php echo vali_iif('18:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                                <option <?php echo vali_iif('18:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                                <option <?php echo vali_iif('19:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                                <option <?php echo vali_iif('19:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                                <option <?php echo vali_iif('20:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                                <option <?php echo vali_iif('20:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                                <option <?php echo vali_iif('21:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                                <option <?php echo vali_iif('21:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                                <option <?php echo vali_iif('22:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                                <option <?php echo vali_iif('22:30' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                                <option <?php echo vali_iif('23:00' == date('H:i', strtotime($sale_return_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                              </select>
                            </div>
                          </div>

                          <br><br>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Sale?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='sale_edit' id='sale_edit' value='true' disabled>
                              <input type='hidden' name='sale_id' id='sale_id' value='<?php echo $sale_id; ?>' disabled>
                              <label class='switch'>
                                <input id='sale_toggle' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" min='0.01' step='0.01' class="form-control" name="sale" value="<?php echo $total_sale; ?>" id="sale" disabled>
                            </div>
                          </div>
                          <br>
                          <center>
                            <input class="btn btn-success" style="width: 200px;" type='submit' name='btn_submit' value="Submit">
                          </center>

                          <script>
                            document.getElementById('date_toggle').onchange = function() {
                                document.getElementById('sale_pickup_date').disabled = !this.checked;
                                document.getElementById('sale_pickup_time').disabled = !this.checked;
                                document.getElementById('sale_return_date').disabled = !this.checked;
                                document.getElementById('sale_return_time').disabled = !this.checked;
                                document.getElementById('date_edit').disabled = !this.checked;
                            };
                            document.getElementById('sale_toggle').onchange = function() {
                                document.getElementById('sale').disabled = !this.checked;
                                document.getElementById('sale_edit').disabled = !this.checked;
                                document.getElementById('sale_id').disabled = !this.checked;
                            };
                          </script>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="ln_solid"></div>
                          </div>
                        </form>
                        <?php
                          if(isset($btn_submit))
                          {
                            $sale_sql = "";
                            $booking_sql = "";

                            if($sale_edit == 'true')
                            {
                              $sale = $sale;
                            }
                            else
                            {
                              $sale = $total_sale;
                            }

                            if($date_edit == 'true')
                            {
                              $sale_pickup_time = $_POST['sale_pickup_time'];
                              $sale_pickup_date = $_POST['sale_pickup_date']. " ".$sale_pickup_time;
                              $sale_return_time = $_POST['sale_return_time'];
                              $sale_return_date = $_POST['sale_return_date']. " ".$sale_return_time;

                              $booking_sql = " pickup_date = '".$sale_pickup_date." ".$sale_pickup_time."', return_date = '".$sale_return_date." ".$sale_return_time."', pickup_time = '".$sale_pickup_time.":00', return_time = '".$sale_return_time.":00', ";

                              $sale_sql = " pickup_date = '".$sale_pickup_date." ".$sale_pickup_time."', return_date = '".$sale_return_date." ".$sale_return_time."',";

                            }

                            $day = dateDifference($sale_pickup_date, $sale_return_date, '%a');


                            $sql = "UPDATE booking_trans SET
                                ".$booking_sql."
                                est_total = '$sale'
                                WHERE id = '$booking_id'
                            ";

                            db_update($sql);

                            $sql = "UPDATE sale SET
                                total_sale = '$sale',
                                ".$sale_sql."
                                total_day = '$day',
                                mid = '".$_SESSION['cid']."',
                                modified = '".date('Y-m-d H:i:s', time())."'
                                WHERE id = '$sale_id'
                            ";

                            db_update($sql);

                            $sql = "DELETE FROM sale_log WHERE sale_id ='$sale_id'";

                            db_update($sql);

                            $sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();

                              $dbcar_rate_class_id = $class_id;
                              $dbcar_rate_oneday = $oneday;
                              $dbcar_rate_twoday = $twoday;
                              $dbcar_rate_threeday = $threeday;
                              $dbcar_rate_fourday = $fourday;
                              $dbcar_rate_fiveday = $fiveday;
                              $dbcar_rate_sixday = $sixday;
                              $dbcar_rate_weekly = $weekly;
                              $dbcar_rate_monthly = $monthly;
                              $dbcar_rate_hour = $hour;
                              $dbcar_rate_halfday = $halfday;
                              $dbcar_rate_deposit = $deposit;
                              
                            }
                                    
                            $sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'";

                            $pickup_date = date('m/d/Y', strtotime($sale_pickup_date));
                            $pickup_time = date('H:i', strtotime($sale_pickup_date));
                            $return_date = date('m/d/Y', strtotime($sale_return_date));
                            $return_time = date('H:i', strtotime($sale_return_date));
                            $day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a');

                            $daylog = '0';
                            $datelog = date('Y/m/d', strtotime($pickup_date)).' '.$pickup_time;

                            // echo "<br><br>1631) datelog: ".$datelog;

                            $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
                            $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
                            $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h'); 


                            $a = 0;

                            // echo "<br><br>1638) day: ".$day;

                            $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

                            // echo "<br><br>1640) datenew: ".$datenew;

                            while($datelog <= $datenew)
                            {

                              // echo "<br><br><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<LOOP>>>>>>>>>>>>>>>>>>>>>>>>>>";
                              // echo "<br><br>1641) datelog: ".$datelog;
                              
                              $currdate = date('Y-m-d',strtotime($datelog)).' '.$return_time;
                              
                              // echo "<br> return date: ".date('m/d/Y', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00";

                              $daydiff = dateDifference($datelog, date('m/d/Y', strtotime($return_date)).' '.$pickup_time, '%a'); 

                              $mymonth = date("m",strtotime($datelog));
                              $myyear = date("Y",strtotime($datelog));

                              // echo "<br><br>1656)year: ".$myyear;

                              // echo "<br><br>1656)normal date:".date("d/m/Y",strtotime($datelog));

                              $week1date1 = date('Y/m/d', strtotime($mymonth.'/01/'.$myyear))." 00:00:00";
                                $week1date2 = date('Y/m/d', strtotime($mymonth.'/07/'.$myyear))." 23:59:59";
                                $week2date1 = date('Y/m/d', strtotime($mymonth.'/08/'.$myyear))." 00:00:00";
                                $week2date2 = date('Y/m/d', strtotime($mymonth.'/14/'.$myyear))." 23:59:59";
                                $week3date1 = date('Y/m/d', strtotime($mymonth.'/15/'.$myyear))." 00:00:00";
                                $week3date2 = date('Y/m/d', strtotime($mymonth.'/21/'.$myyear))." 23:59:59";
                                $week4date1 = date('Y/m/d', strtotime($mymonth.'/22/'.$myyear))." 00:00:00";
                                $week4date2 = date('Y/m/d', strtotime($mymonth.'/28/'.$myyear))." 23:59:59";
                                $week5date1 = date('Y/m/d', strtotime($mymonth.'/29/'.$myyear))." 00:00:00";
                                $week5date2 = date('Y/m/d', strtotime($mymonth.'/31/'.$myyear))." 23:59:59";

                              if($mymonth == '1')
                              {

                                $monthname = 'jan';
                              }
                              else if($mymonth == '2')
                              {

                                $monthname = 'feb';
                              }
                              else if($mymonth == '3')
                              {

                                $monthname = 'march';
                              }
                              else if($mymonth == '4')
                              {

                                $monthname = 'apr';
                              }
                              else if($mymonth == '5')
                              {

                                $monthname = 'may';
                              }
                              else if($mymonth == '6')
                              {

                                $monthname = 'june';
                              }
                              else if($mymonth == '7')
                              {

                                $monthname = 'july';
                              }
                              else if($mymonth == '8')
                              {

                                $monthname = 'aug';
                              }
                              else if($mymonth == '9')
                              {

                                $monthname = 'sept';
                              }
                              else if($mymonth == '10')
                              {

                                $monthname = 'oct';
                              }
                              else if($mymonth == '11')
                              {

                                $monthname = 'nov';
                              }
                              else if($mymonth == '12')
                              {

                                $monthname = 'dis';
                              }

                              if($datelog >= $week1date1 && $datelog <= $week1date2)
                                {

                                    $week = 'week1';
                                }

                                else if($datelog >= $week2date1 && $datelog <= $week2date2)
                                {

                                    $week = 'week2';
                                }

                                else if($datelog >= $week3date1 && $datelog <= $week3date2)
                                {
                                    
                                    $week = "week3";
                                }

                                else if($datelog >= $week4date1 && $datelog <= $week4date2)
                                {

                                    $week = 'week4';
                                }

                                else if($datelog >= $week5date1 && $datelog <= $week5date2)
                                {

                                    $week = 'week5';
                                }

                              if($hourlog != '0' )
                              {

                                if($time < 8){

                                  $daily_sale = $time * $dbcar_rate_hour; 
                                }

                                else if($time >= 8 && $time <= 12) {

                                  $daily_sale = $dbcar_rate_halfday;
                                } 

                                else if($time >= 13){ 

                                  $difference_hour = $time - 12;
                                  $daily_sale = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
                                            80 + 80;
                                }

                                if($sale < $daily_sale)
                                {
                                  $daily_sale = $sale;
                                }

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  hour,
                                  type,
                                  ".$week.",
                                  ".$monthname.",
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id',
                                  '$daily_sale',
                                  '0',
                                  '$hourlog',
                                  'hour',
                                  '$daily_sale',
                                  '$daily_sale',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                db_update($sql);

                                $est_total = $sale - $daily_sale;

                                $hourlog = '0';
                              }
                              
                              else if($hourlog == '0' && $a == '0')
                              {

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  hour,
                                  ".$week.",
                                  type,
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id',
                                  '0',
                                  '0',
                                  '0',
                                  '0',
                                  'firstday',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                db_update($sql);

                                $est_total = $sale;

                              }
                              
                              else if($hourlog == '0' && $a > 0)
                              {

                                $daily_sale = $est_total / $day;

                                $daylog = $daylog + 1;

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  type,
                                  hour,
                                  ".$week.",
                                  ".$monthname.",
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id',
                                  '$daily_sale',
                                  '$daylog',
                                  'day',
                                  '0',
                                  '$daily_sale',
                                  '$daily_sale',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                db_update($sql);

                              }

                              $datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$pickup_time;

                              $a = $a +1;

                              echo "<script>
                                  window.alert('Normal sale has been successfully modified');
                                    window.location.href='reservation_list_view.php?booking_id=$booking_id';
                                  </script>";
                            }
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php
                }
                else if($type == 'extend')
                {

                  $sql = "SELECT 
                      agreement_no,
                      concat(firstname,' ' ,lastname) AS fullname,
                      nric_no,
                      phone_no,
                      age,
                      address,
                      postcode,
                      city,
                      country,
                      total_sale,
                      sale.id AS sale_id,
                      extend_from_date,
                      extend_to_date,
                      total,
                      booking_trans.vehicle_id,
                      concat(make, ' ', model) AS car,
                      reg_no,
                      class_id,
                      booking_trans.id AS booking_id
                      FROM extend
                      LEFT JOIN booking_trans ON booking_trans.id = extend.booking_trans_id
                      LEFT JOIN customer ON customer.id = booking_trans.customer_id
                      LEFT JOIN sale ON sale.booking_trans_id = booking_trans.id
                      LEFT JOIN vehicle ON vehicle.id = booking_trans.vehicle_id
                      WHERE extend.id = '$extend_id' AND sale.type = 'Extend' AND extend_from_date = sale.pickup_date AND extend_to_date = sale.return_date
                  ";

                  db_select($sql);

                  if(db_rowcount() > 0)
                  {
                    func_setSelectVar();
                  }

                ?>
                  <div class="col-md-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Extend Sale</h2>
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
                        <form id="demo-form2" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Agreement No.</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control" value="<?php echo $agreement_no; ?>" disabled>
                            </div>
                          </div>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control" value="<?php echo $reg_no .' - '.$car; ?>" disabled>
                            </div>
                          </div>

                          <br><br>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Date?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='date_edit' id='date_edit' value='true' disabled>
                              <label class='switch'>
                                <input id='date_toggle' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" class="form-control" name='extend_from_date' id='extend_from_date' value="<?php echo date('Y-m-d', strtotime($extend_from_date)); ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="extend_from_time" id='extend_from_time' class="form-control" disabled>
                                <option <?php echo vali_iif('08:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                                <option <?php echo vali_iif('08:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                                <option <?php echo vali_iif('09:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                                <option <?php echo vali_iif('09:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                                <option <?php echo vali_iif('10:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                                <option <?php echo vali_iif('10:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                                <option <?php echo vali_iif('11:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                                <option <?php echo vali_iif('11:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                                <option <?php echo vali_iif('12:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                                <option <?php echo vali_iif('12:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                                <option <?php echo vali_iif('13:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                                <option <?php echo vali_iif('13:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                                <option <?php echo vali_iif('14:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                                <option <?php echo vali_iif('14:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                                <option <?php echo vali_iif('15:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                                <option <?php echo vali_iif('15:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                                <option <?php echo vali_iif('16:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                                <option <?php echo vali_iif('16:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                                <option <?php echo vali_iif('17:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                                <option <?php echo vali_iif('17:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                                <option <?php echo vali_iif('18:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                                <option <?php echo vali_iif('18:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                                <option <?php echo vali_iif('19:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                                <option <?php echo vali_iif('19:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                                <option <?php echo vali_iif('20:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                                <option <?php echo vali_iif('20:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                                <option <?php echo vali_iif('21:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                                <option <?php echo vali_iif('21:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                                <option <?php echo vali_iif('22:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                                <option <?php echo vali_iif('22:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                                <option <?php echo vali_iif('23:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" class="form-control" name='extend_to_date' id='extend_to_date' value="<?php echo date('Y-m-d', strtotime($extend_to_date)); ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="extend_to_time" id='extend_to_time' class="form-control" disabled>
                                <option <?php echo vali_iif('08:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                                <option <?php echo vali_iif('08:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                                <option <?php echo vali_iif('09:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                                <option <?php echo vali_iif('09:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                                <option <?php echo vali_iif('10:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                                <option <?php echo vali_iif('10:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                                <option <?php echo vali_iif('11:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                                <option <?php echo vali_iif('11:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                                <option <?php echo vali_iif('12:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                                <option <?php echo vali_iif('12:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                                <option <?php echo vali_iif('13:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                                <option <?php echo vali_iif('13:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                                <option <?php echo vali_iif('14:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                                <option <?php echo vali_iif('14:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                                <option <?php echo vali_iif('15:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                                <option <?php echo vali_iif('15:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                                <option <?php echo vali_iif('16:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                                <option <?php echo vali_iif('16:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                                <option <?php echo vali_iif('17:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                                <option <?php echo vali_iif('17:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                                <option <?php echo vali_iif('18:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                                <option <?php echo vali_iif('18:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                                <option <?php echo vali_iif('19:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                                <option <?php echo vali_iif('19:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                                <option <?php echo vali_iif('20:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                                <option <?php echo vali_iif('20:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                                <option <?php echo vali_iif('21:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                                <option <?php echo vali_iif('21:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                                <option <?php echo vali_iif('22:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                                <option <?php echo vali_iif('22:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                                <option <?php echo vali_iif('23:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                              </select>
                            </div>
                          </div>

                          <br><br>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Sale?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='sale_edit' id='sale_edit' value='true' disabled>
                              <input type='hidden' name='sale_id' id='sale_id' value='<?php echo $sale_id; ?>' disabled>
                              <label class='switch'>
                                <input id='sale_toggle' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" min='0.01' step='0.01' class="form-control" name="sale" value="<?php echo $total_sale; ?>" id="sale" disabled>
                            </div>
                          </div>
                          <br>
                          <center>
                            <input class="btn btn-success" style="width: 200px;" type='submit' name='btn_submit' value="Submit">
                          </center>

                          <script>
                            document.getElementById('date_toggle').onchange = function() {
                                document.getElementById('extend_from_date').disabled = !this.checked;
                                document.getElementById('extend_from_time').disabled = !this.checked;
                                document.getElementById('extend_to_date').disabled = !this.checked;
                                document.getElementById('extend_to_time').disabled = !this.checked;
                                document.getElementById('date_edit').disabled = !this.checked;
                            };
                            document.getElementById('sale_toggle').onchange = function() {
                                document.getElementById('sale').disabled = !this.checked;
                                document.getElementById('sale_edit').disabled = !this.checked;
                                document.getElementById('sale_id').disabled = !this.checked;
                            };
                          </script>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="ln_solid"></div>
                          </div>
                        </form>
                        <?php
                          if(isset($btn_submit))
                          {
                            $sale_sql = "";
                            $date_sql = "";

                            if($sale_edit == 'true')
                            {
                              $sale_sql = ", total = '$sale'"; 
                            }
                            else
                            {
                              $sale = $total;
                            }

                            if($date_edit == 'true')
                            {
                              $extend_from_time = $_POST['extend_from_time'];
                              $extend_from_date = $_POST['extend_from_date']. " ".$extend_from_time;
                              $extend_to_time = $_POST['extend_to_time'];
                              $extend_to_date = $_POST['extend_to_date']. " ".$extend_to_time;

                              $date_sql = " pickup_date = '".$extend_from_date."', return_date = '".$extend_to_date."',";

                            }
                            
                            $day = dateDifference($extend_from_date, $extend_to_date, '%a');

                            $sql = "UPDATE sale SET
                                total_sale = '$sale',
                                ".$date_sql."
                                total_day = '$day',
                                mid = '".$_SESSION['cid']."',
                                modified = '".date('Y-m-d H:i:s', time())."'
                                WHERE id = '$sale_id'
                            ";

                            db_update($sql);

                            $sql = "UPDATE extend SET extend_from_date = '$extend_from_date', extend_from_time = '$extend_from_time', extend_to_date = '$extend_to_date', extend_to_time = '$extend_to_time'".$sale_sql.", m_date = '".date('Y-m-d', time())."' WHERE id = '$extend_id'";

                            db_update($sql);

                            $sql = "DELETE FROM sale_log WHERE sale_id ='$sale_id'";

                            db_update($sql);

                            $sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();

                              $dbcar_rate_class_id = $class_id;
                              $dbcar_rate_oneday = $oneday;
                              $dbcar_rate_twoday = $twoday;
                              $dbcar_rate_threeday = $threeday;
                              $dbcar_rate_fourday = $fourday;
                              $dbcar_rate_fiveday = $fiveday;
                              $dbcar_rate_sixday = $sixday;
                              $dbcar_rate_weekly = $weekly;
                              $dbcar_rate_monthly = $monthly;
                              $dbcar_rate_hour = $hour;
                              $dbcar_rate_halfday = $halfday;
                              $dbcar_rate_deposit = $deposit;
                              
                            }
                                    
                            $sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'";

                            $pickup_date = date('m/d/Y', strtotime($extend_from_date));
                            $pickup_time = $extend_from_time;
                            $return_date = date('m/d/Y', strtotime($extend_to_date));
                            $return_time = $extend_to_time;
                            $day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a');

                            $daylog = '0';
                            $datelog = date('Y/m/d', strtotime($pickup_date)).' '.$pickup_time;

                            // echo "<br><br>1631) datelog: ".$datelog;

                            $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
                            $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
                            $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h'); 


                            $a = 0;

                            // echo "<br><br>1638) day: ".$day;

                            $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

                            // echo "<br><br>1640) datenew: ".$datenew;

                            while($datelog <= $datenew)
                            {

                              // echo "<br><br><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<LOOP>>>>>>>>>>>>>>>>>>>>>>>>>>";
                              // echo "<br><br>1641) datelog: ".$datelog;
                              
                              $currdate = date('Y-m-d',strtotime($datelog)).' '.$return_time;
                              
                              // echo "<br> return date: ".date('m/d/Y', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00";

                              $daydiff = dateDifference($datelog, date('m/d/Y', strtotime($return_date)).' '.$pickup_time, '%a'); 

                              $mymonth = date("m",strtotime($datelog));
                              $myyear = date("Y",strtotime($datelog));

                              // echo "<br><br>1656)year: ".$myyear;

                              // echo "<br><br>1656)normal date:".date("d/m/Y",strtotime($datelog));

                              $week1date1 = date('Y/m/d', strtotime($mymonth.'/01/'.$myyear))." 00:00:00";
                                $week1date2 = date('Y/m/d', strtotime($mymonth.'/07/'.$myyear))." 23:59:59";
                                $week2date1 = date('Y/m/d', strtotime($mymonth.'/08/'.$myyear))." 00:00:00";
                                $week2date2 = date('Y/m/d', strtotime($mymonth.'/14/'.$myyear))." 23:59:59";
                                $week3date1 = date('Y/m/d', strtotime($mymonth.'/15/'.$myyear))." 00:00:00";
                                $week3date2 = date('Y/m/d', strtotime($mymonth.'/21/'.$myyear))." 23:59:59";
                                $week4date1 = date('Y/m/d', strtotime($mymonth.'/22/'.$myyear))." 00:00:00";
                                $week4date2 = date('Y/m/d', strtotime($mymonth.'/28/'.$myyear))." 23:59:59";
                                $week5date1 = date('Y/m/d', strtotime($mymonth.'/29/'.$myyear))." 00:00:00";
                                $week5date2 = date('Y/m/d', strtotime($mymonth.'/31/'.$myyear))." 23:59:59";

                              if($mymonth == '1')
                              {

                                $monthname = 'jan';
                              }
                              else if($mymonth == '2')
                              {

                                $monthname = 'feb';
                              }
                              else if($mymonth == '3')
                              {

                                $monthname = 'march';
                              }
                              else if($mymonth == '4')
                              {

                                $monthname = 'apr';
                              }
                              else if($mymonth == '5')
                              {

                                $monthname = 'may';
                              }
                              else if($mymonth == '6')
                              {

                                $monthname = 'june';
                              }
                              else if($mymonth == '7')
                              {

                                $monthname = 'july';
                              }
                              else if($mymonth == '8')
                              {

                                $monthname = 'aug';
                              }
                              else if($mymonth == '9')
                              {

                                $monthname = 'sept';
                              }
                              else if($mymonth == '10')
                              {

                                $monthname = 'oct';
                              }
                              else if($mymonth == '11')
                              {

                                $monthname = 'nov';
                              }
                              else if($mymonth == '12')
                              {

                                $monthname = 'dis';
                              }

                              if($datelog >= $week1date1 && $datelog <= $week1date2)
                              {

                                  $week = 'week1';
                              }

                              else if($datelog >= $week2date1 && $datelog <= $week2date2)
                              {

                                  $week = 'week2';
                              }

                              else if($datelog >= $week3date1 && $datelog <= $week3date2)
                              {
                                  
                                  $week = "week3";
                              }

                              else if($datelog >= $week4date1 && $datelog <= $week4date2)
                              {

                                  $week = 'week4';
                              }

                              else if($datelog >= $week5date1 && $datelog <= $week5date2)
                              {

                                  $week = 'week5';
                              }

                              if($hourlog != '0' )
                              {

                                if($time < 8){

                                  $daily_sale = $time * $dbcar_rate_hour; 
                                }

                                else if($time >= 8 && $time <= 12) {

                                  $daily_sale = $dbcar_rate_halfday;
                                } 

                                else if($time >= 13){ 

                                  $difference_hour = $time - 12;
                                  $daily_sale = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
                                            80 + 80;
                                }

                                if($sale < $daily_sale)
                                {
                                  $daily_sale = $sale;
                                }

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  hour,
                                  type,
                                  ".$week.",
                                  ".$monthname.",
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id',
                                  '$daily_sale',
                                  '0',
                                  '$hourlog',
                                  'hour (extend)',
                                  '$daily_sale',
                                  '$daily_sale',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                db_update($sql);

                                $est_total = $sale - $daily_sale;

                                $hourlog = '0';
                              }
                              
                              else if($hourlog == '0' && $a == '0')
                              {

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  hour,
                                  ".$week.",
                                  type,
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id',
                                  '0',
                                  '0',
                                  '0',
                                  '0',
                                  'firstday (extend)',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                db_update($sql);

                                $est_total = $sale;
                              }
                              
                              else if($hourlog == '0' && $a > 0)
                              {

                                $daily_sale = $est_total / $day;

                                $daylog = $daylog + 1;

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  type,
                                  hour,
                                  ".$week.",
                                  ".$monthname.",
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id',
                                  '$daily_sale',
                                  '$daylog',
                                  'day (extend)',
                                  '0',
                                  '$daily_sale',
                                  '$daily_sale',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                db_update($sql);
                              }

                              $datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$pickup_time;

                              $a = $a +1;

                              echo "<script>
                                  window.alert('Extend has been successfully modified');
                                    window.location.href='reservation_list_view.php?booking_id=$booking_id';
                                  </script>";
                            }
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>


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