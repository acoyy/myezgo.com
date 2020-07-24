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

  <?php include('_header.php'); func_setReqVar(); ?>

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
                  <h3>Counter Reservation</h3>
                </div>
              </div>

              <div class="clearfix"></div>
              
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Counter Reservation</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br>
                      <form class="form-horizontal form-label-left input_mask" action="#" onsubmit="return validateForm()" name="myForm">
                        <div class="form-group">
                          <label class="control-label" style="text-align:left"><span style="color:red" id="err"><?php if($vehicle_status != '') echo "- Vehicle chosen has been Booked / Out"; ?></span></label>
                          <label class="control-label" style="text-align:left"><span style="color:red" id="err"><?php echo func_getErrMsg(); ?></span></label>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pickup Date & time</label>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="date" autocomplete="off" class="form-control" id="search_pickup_date" name="search_pickup_date" value="<?php echo $search_pickup_date; ?>" onkeydown="return false">
                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <select name="search_pickup_time" class="form-control">
                              <option value="">Pickup Time</option>
                              <option <?php echo vali_iif('08:00' == $search_pickup_time, 'Selected', ''); ?> value="08:00">08.00</option>
                              <option <?php echo vali_iif('08:30' == $search_pickup_time, 'Selected', ''); ?> value="08:30">08.30</option>
                              <option <?php echo vali_iif('09:00' == $search_pickup_time, 'Selected', ''); ?> value="09:00">09.00</option>
                              <option <?php echo vali_iif('09:30' == $search_pickup_time, 'Selected', ''); ?> value="09:30">09.30</option>
                              <option <?php echo vali_iif('10:00' == $search_pickup_time, 'Selected', ''); ?> value="10:00">10.00</option>
                              <option <?php echo vali_iif('10:30' == $search_pickup_time, 'Selected', ''); ?> value="10:30">10.30</option>
                              <option <?php echo vali_iif('11:00' == $search_pickup_time, 'Selected', ''); ?> value="11:00">11.00</option>
                              <option <?php echo vali_iif('11:30' == $search_pickup_time, 'Selected', ''); ?> value="11:30">11.30</option>
                              <option <?php echo vali_iif('12:00' == $search_pickup_time, 'Selected', ''); ?> value="12:00">12.00</option>
                              <option <?php echo vali_iif('12:30' == $search_pickup_time, 'Selected', ''); ?> value="12:30">12.30</option>
                              <option <?php echo vali_iif('13:00' == $search_pickup_time, 'Selected', ''); ?> value="13:00">13.00</option>
                              <option <?php echo vali_iif('13:30' == $search_pickup_time, 'Selected', ''); ?> value="13:30">13.30</option>
                              <option <?php echo vali_iif('14:00' == $search_pickup_time, 'Selected', ''); ?> value="14:00">14.00</option>
                              <option <?php echo vali_iif('14:30' == $search_pickup_time, 'Selected', ''); ?> value="14:30">14.30</option>
                              <option <?php echo vali_iif('15:00' == $search_pickup_time, 'Selected', ''); ?> value="15:00">15.00</option>
                              <option <?php echo vali_iif('15:30' == $search_pickup_time, 'Selected', ''); ?> value="15:30">15.30</option>
                              <option <?php echo vali_iif('16:00' == $search_pickup_time, 'Selected', ''); ?> value="16:00">16.00</option>
                              <option <?php echo vali_iif('16:30' == $search_pickup_time, 'Selected', ''); ?> value="16:30">16.30</option>
                              <option <?php echo vali_iif('17:00' == $search_pickup_time, 'Selected', ''); ?> value="17:00">17.00</option>
                              <option <?php echo vali_iif('17:30' == $search_pickup_time, 'Selected', ''); ?> value="17:30">17.30</option>
                              <option <?php echo vali_iif('18:00' == $search_pickup_time, 'Selected', ''); ?> value="18:00">18.00</option>
                              <option <?php echo vali_iif('18:30' == $search_pickup_time, 'Selected', ''); ?> value="18:30">18.30</option>
                              <option <?php echo vali_iif('19:00' == $search_pickup_time, 'Selected', ''); ?> value="19:00">19.00</option>
                              <option <?php echo vali_iif('19:30' == $search_pickup_time, 'Selected', ''); ?> value="19:30">19.30</option>
                              <option <?php echo vali_iif('20:00' == $search_pickup_time, 'Selected', ''); ?> value="20:00">20.00</option>
                              <option <?php echo vali_iif('20:30' == $search_pickup_time, 'Selected', ''); ?> value="20:30">20.30</option>
                              <option <?php echo vali_iif('21:00' == $search_pickup_time, 'Selected', ''); ?> value="21:00">21.00</option>
                              <option <?php echo vali_iif('21:30' == $search_pickup_time, 'Selected', ''); ?> value="21:30">21.30</option>
                              <option <?php echo vali_iif('22:00' == $search_pickup_time, 'Selected', ''); ?> value="22:00">22.00</option>
                              <option <?php echo vali_iif('22:30' == $search_pickup_time, 'Selected', ''); ?> value="22:30">22.30</option>
                              <option <?php echo vali_iif('23:00' == $search_pickup_time, 'Selected', ''); ?> value="23:00">23.00</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Return Date & time</label>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="date" class="form-control" name="search_return_date" id="search_return_date" placeholder="Return Date" value="<?php echo $search_return_date; ?>">
                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <select name="search_return_time" class="form-control">
                              <option value="">Return Time</option>
                              <option <?php echo vali_iif('08:00' == $search_return_time, 'Selected', ''); ?> value="08:00">08.00</option>
                              <option <?php echo vali_iif('08:30' == $search_return_time, 'Selected', ''); ?> value="08:30">08.30</option>
                              <option <?php echo vali_iif('09:00' == $search_return_time, 'Selected', ''); ?> value="09:00">09.00</option>
                              <option <?php echo vali_iif('09:30' == $search_return_time, 'Selected', ''); ?> value="09:30">09.30</option>
                              <option <?php echo vali_iif('10:00' == $search_return_time, 'Selected', ''); ?> value="10:00">10.00</option>
                              <option <?php echo vali_iif('10:30' == $search_return_time, 'Selected', ''); ?> value="10:30">10.30</option>
                              <option <?php echo vali_iif('11:00' == $search_return_time, 'Selected', ''); ?> value="11:00">11.00</option>
                              <option <?php echo vali_iif('11:30' == $search_return_time, 'Selected', ''); ?> value="11:30">11.30</option>
                              <option <?php echo vali_iif('12:00' == $search_return_time, 'Selected', ''); ?> value="12:00">12.00</option>
                              <option <?php echo vali_iif('12:30' == $search_return_time, 'Selected', ''); ?> value="12:30">12.30</option>
                              <option <?php echo vali_iif('13:00' == $search_return_time, 'Selected', ''); ?> value="13:00">13.00</option>
                              <option <?php echo vali_iif('13:30' == $search_return_time, 'Selected', ''); ?> value="13:30">13.30</option>
                              <option <?php echo vali_iif('14:00' == $search_return_time, 'Selected', ''); ?> value="14:00">14.00</option>
                              <option <?php echo vali_iif('14:30' == $search_return_time, 'Selected', ''); ?> value="14:30">14.30</option>
                              <option <?php echo vali_iif('15:00' == $search_return_time, 'Selected', ''); ?> value="15:00">15.00</option>
                              <option <?php echo vali_iif('15:30' == $search_return_time, 'Selected', ''); ?> value="15:30">15.30</option>
                              <option <?php echo vali_iif('16:00' == $search_return_time, 'Selected', ''); ?> value="16:00">16.00</option>
                              <option <?php echo vali_iif('16:30' == $search_return_time, 'Selected', ''); ?> value="16:30">16.30</option>
                              <option <?php echo vali_iif('17:00' == $search_return_time, 'Selected', ''); ?> value="17:00">17.00</option>
                              <option <?php echo vali_iif('17:30' == $search_return_time, 'Selected', ''); ?> value="17:30">17.30</option>
                              <option <?php echo vali_iif('18:00' == $search_return_time, 'Selected', ''); ?> value="18:00">18.00</option>
                              <option <?php echo vali_iif('18:30' == $search_return_time, 'Selected', ''); ?> value="18:30">18.30</option>
                              <option <?php echo vali_iif('19:00' == $search_return_time, 'Selected', ''); ?> value="19:00">19.00</option>
                              <option <?php echo vali_iif('19:30' == $search_return_time, 'Selected', ''); ?> value="19:30">19.30</option>
                              <option <?php echo vali_iif('20:00' == $search_return_time, 'Selected', ''); ?> value="20:00">20.00</option>
                              <option <?php echo vali_iif('20:30' == $search_return_time, 'Selected', ''); ?> value="20:30">20.30</option>
                              <option <?php echo vali_iif('21:00' == $search_return_time, 'Selected', ''); ?> value="21:00">21.00</option>
                              <option <?php echo vali_iif('21:30' == $search_return_time, 'Selected', ''); ?> value="21:30">21.30</option>
                              <option <?php echo vali_iif('22:00' == $search_return_time, 'Selected', ''); ?> value="22:00">22.00</option>
                              <option <?php echo vali_iif('22:30' == $search_return_time, 'Selected', ''); ?> value="22:30">22.30</option>
                              <option <?php echo vali_iif('23:00' == $search_return_time, 'Selected', ''); ?> value="23:00">23.00</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location</label>
                          
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <select class="form-control" name="search_pickup_location" <?php echo $disabled; ?>>
                          
                            <?php
   
                              $value = ""; $sql = "SELECT id, description FROM location WHERE status = 'A'"; 
                          
                              db_select($sql); 
                          
                              if (db_rowcount() > 0) { 

                                for ($j = 0; $j < db_rowcount(); $j++){ 

                                  $value = $value . "<option value=" . db_get($j, 0) . " " . vali_iif(db_get($j, 0) == $search_pickup_location, 'Selected', '') . ">" . db_get($j, 1) . "</option>"; 
                                }
                              } 

                              echo "<option value='' selected disabled>Pickup</option>";
                              echo $value; 
                            ?>
                              
                            </select>
                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <select class="form-control" name="search_return_location" <?php echo $disabled; ?>>

                            <?php

                              $value = ""; 
                              $sql = "SELECT id, description from location WHERE status = 'A'"; 
                              db_select($sql); 

                              if (db_rowcount() > 0) { 

                                for ($j = 0; $j < db_rowcount(); $j++) { 

                                  $value = $value . "<option value=" . db_get($j, 0) . " " . vali_iif(db_get($j, 0) == $search_return_location, 'Selected', '') . ">" . db_get($j, 1) . "</option>"; 
                                }
                              } 

                              echo "<option value='' selected disabled>Return</option>";
                              echo $value; 
                            ?>
                              
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Search Vehicle</label>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="search_vehicle">

                            <?php

                              $value = ""; 
                              $sql = "SELECT id, class_name from class"; 
                              db_select($sql); 

                              if (db_rowcount() > 0) { 

                                for ($j = 0; $j < db_rowcount(); $j++) { 

                                  $value = $value . "<option value=" . db_get($j, 0) . " " . vali_iif(db_get($j, 0) == $search_vehicle, 'Selected', '') . ">" . db_get($j, 1) . "</option>"; 
                                }
                              } 

                              echo "<option value='' selected>----</option>";
                              echo $value; 
                            ?>
                              
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Driver</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="search_driver">
                              <optgroup label="Alaskan/Hawaiian Time Zone">
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                              </optgroup>
                              <optgroup label="Pacific Time Zone">
                                <option value="CA">California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                              </optgroup>
                              <optgroup label="Mountain Time Zone">
                                <option value="AZ">Arizona</option>
                                <option value="CO">Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NM">New Mexico</option>
                                <option value="ND">North Dakota</option>
                                <option value="UT">Utah</option>
                                <option value="WY">Wyoming</option>
                              </optgroup>
                              <optgroup label="Central Time Zone">
                                <option value="AL">Alabama</option>
                                <option value="AR">Arkansas</option>
                                <option value="IL">Illinois</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="OK">Oklahoma</option>
                                <option value="SD">South Dakota</option>
                                <option value="TX">Texas</option>
                                <option value="TN">Tennessee</option>
                                <option value="WI">Wisconsin</option>
                              </optgroup>
                              <optgroup label="Asian Time Zone">
                                <option value="MY" selected>Malaysia</option>
                                <option value="JPN">Japan</option>
                                <option value="SGP">Singapore</option>
                              </optgroup>
                              <optgroup label="Eastern Time Zone">
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="IN">Indiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="OH">Ohio</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WV">West Virginia</option>
                              </optgroup>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Delivery Term</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="opt" onchange="change();">
                              <option selected value = ''>At Branch</option>
                              <option value="delivery">Delivery</option>
                              <option value="pickup">Pickup</option>
                            </select>
                          </div>
                        </div>
                        
                        <div id="opt-cont"></div>

                        <div class="form-group">
                          <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" name="btn_search" class="btn btn-success">Search</button>
                            <a href='counter_reservation.php'><button class="btn btn-primary" type="button">Reset</button></a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="x_panel">

                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Reg No</th>
                          <th>Make</th>
                          <th>Model</th>
                          <th>Color</th>
                          <th>Year</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                        <?php
                          func_setPage(); 
                          func_setOffset(); 
                          func_setLimit(10); 

                          if (isset($btn_search)) { 

                            // Filter unavailable car by array id 1

                            $sqla = "SELECT * FROM booking_trans WHERE 
                            (
                              return_date <= '" . $search_return_date.' '.$search_return_time.':00'."' 
                              AND return_date >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                              AND (available = 'Extend' OR available = 'Out' OR available = 'Booked')
                            ) 
                            OR
                            (
                              pickup_date >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                              AND pickup_date <= '" . $search_return_date.' '.$search_return_time.':00'."'
                              AND (available = 'Extend' OR available = 'Out' OR available = 'Booked')
                            )
                            OR
                            (
                              return_date >= '" . $search_return_date.' '.$search_return_time.':00'."' 
                              AND pickup_date <= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                              AND (available = 'Extend' OR available = 'Out' OR available = 'Booked')
                            ) 
                            OR
                            (
                              pickup_date <= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                              AND return_date >= '" . $search_return_date.' '.$search_return_time.':00'."' 
                              AND (available = 'Extend' OR available = 'Out' OR available = 'Booked')
                            ) 
                            group by vehicle_id";
                            
                            $result = [];
                            
                            $query=mysqli_query($con,$sqla);

                            // $i = 0;

                            while ($row = mysqli_fetch_array($query)){

                              $result[] = $row['vehicle_id'];
                            }
                            
                            if($search_vehicle != '')
                            {
                              $and = " AND vehicle_id ='$search_vehicle'";
                            }
                            else{
    
                              $and = '';
                            }
                            
                            $sql = "SELECT id FROM booking_trans WHERE available = 'Extend'".$and;
                            
                            $query = mysqli_query($con,$sql);
                            
                            while ($row = mysqli_fetch_array($query)){
                                
                                $extend_booking_id = $row['id'];
                                
                                $sqlc = "SELECT vehicle_id FROM extend WHERE 
                                booking_trans_id = '".$extend_booking_id."'
                                (
                                    (
                                      extend_to_date   <= '" . $search_return_date.' '.$search_return_time.':00'."' 
                                      AND extend_to_date  >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."'
                                    )
                                    OR
                                    (
                                      extend_from_date   >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                                      AND extend_from_date  <= '" . $search_return_date.' '.$search_return_time.':00'."'
                                    )
                                    OR 
                                    (
                                      extend_to_date  >= '" . $search_return_date.' '.$search_return_time.':00'."' 
                                      AND extend_from_date  <= '" . $search_pickup_date.' '.$search_pickup_time.':00'."'
                                    )
                                    OR 
                                    (
                                      extend_from_date  <= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                                      AND extend_to_date  >= '" . $search_return_date.' '.$search_return_time.':00'."'
                                    )
                                ) GROUP BY vehicle_id";
                                
                                $query2 = mysqli_query($con,$sqlc);
                                
                                // echo "<br><br>sqlc: ".$sqlc;
                                
                                $numrows = mysqli_num_rows($query2);
                                
                                // echo "<br>numrows: ".$numrows;
                                
                                while ($row2 = mysqli_fetch_array($query2)){
                                        
                                    $result2[] = $row2['vehicle_id'];
                                }
                            }
                            
                            if($result != null && $result2 != null)
                            {
                                $merge = array_merge($result,$result2);
                                // echo "masuk sini 1";
                            }
                            else if($result != null && $result2 == null)
                            {
                                
                                $merge = $result;
                                // echo "masuk sini 2";
                            }
                            else if($result == null && $result2 != null)
                            {
                                $merge = $result2;
                                // echo "masuk sini 3";
                            }
                            else if($result == null && $result2 == null)
                            {
                                $merge = null;
                                // echo "masuk sini 4";
                            }
                            
                            $list_id=implode(", ", $result);
                            $list_id2=implode(", ", $result2);
                            
                            // echo "<br>list_id: ".$list_id;
                            // echo "<br>list_id2: ".$list_id2;
                            
                            $list_id4 = implode(", ", $merge);
                            
                            // echo "<br>list_id4: ".$list_id4;
 
                            if($list_id4 != '0' && $list_id4 != '' && $list_id4 != null)
                            {

                              $where = ""; 

                              if($search_vehicle != '')
                              {
                                $where = 'AND class_id = '.$search_vehicle.' AND';
                                
                                // echo "masuk haha";
                              }
                              else{

                                $where = 'AND';
                              }

                              $sql = "SELECT vehicle.id, 
                              vehicle.class_id, 
                              vehicle.reg_no, 
                              vehicle.make, 
                              vehicle.model, 
                              vehicle.color, 
                              vehicle.year, 
                              booking_trans.pickup_date, 
                              booking_trans.pickup_time,
                              booking_trans.return_date,
                              booking_trans.return_time 
                              FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                              WHERE booking_trans.vehicle_id not in ($list_id4) ".$where." (availability = 'Available' OR availability = 'Out' OR availability = 'Booked')
                              GROUP BY vehicle.id ";

                            //   echo "<br>masuk 1";
                              //   echo "<br>sql: ".$sql;
                            }
                            else
                            {

                              if($search_vehicle != '')
                              {
                                $where = 'WHERE class_id = '.$search_vehicle . " AND";
                              }
                              else{
    
                                $where = 'WHERE';
                              }
    
                              $sql = "SELECT vehicle.id, 
                              vehicle.class_id, 
                              vehicle.reg_no, 
                              vehicle.make, 
                              vehicle.model, 
                              vehicle.color, 
                              vehicle.year, 
                              booking_trans.pickup_date, 
                              booking_trans.pickup_time,
                              booking_trans.return_date,
                              booking_trans.return_time 
                              FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                              ".$where." (availability = 'Available' OR availability = 'Out' OR availability = 'Booked')
                              GROUP BY vehicle.id ";
    
                            //   echo "<br>masuk 2";
                            }

                            db_select($sql);

                            func_setTotalPage(db_rowcount()); 

                            db_select($sql . " LIMIT " . func_getLimit() . " OFFSET " . func_getOffset()); 

                            if (db_rowcount() > 0) {

                              for ($i = 0; $i < db_rowcount(); $i++) {

                                if (func_getOffset() >= 10) {

                                  $no = func_getOffset() + 1 + $i;

                                } else {

                                  $no = $i + 1;

                                } 
                                echo "<tr>
                                  <th scope='row'>" . $no . "</th>";
                                //   echo "<td>" . db_get($i, 0) ." - ". db_get($i, 2) . "</td>
                                
                                echo "<td>" . db_get($i, 2) . "</td>
                                  <td>" . db_get($i, 3) . "</td>
                                  <td>" . db_get($i, 4) . "</td>
                                  <td>" . db_get($i, 5) . "</td>
                                  <td>" . db_get($i, 6) . "</td>
                                  <td>
                                  <a href='counter_reservation_filter.php?vehicle_id=" . db_get($i, 0) . "&search_pickup_date=" . $search_pickup_date . "&search_pickup_time=" . $search_pickup_time . "&search_return_date=" . $search_return_date . "&search_return_time=" . $search_return_time . "&search_pickup_location=" . $search_pickup_location . "&search_return_location=" . $search_return_location . "&class_id=" . db_get($i, 1) . "&delivery_cost=" . $delivery_cost . '&p_delivery_address=' . $p_delivery_address . '&r_delivery_address=' . $r_delivery_address . '&pickup_cost=' . $pickup_cost . '&p_pickup_address=' . $p_pickup_address . '&r_pickup_address=' . $r_pickup_address . "'>
                                  <i class='fa fa-pencil'></i>
                                  <span>Book Now</span>
                                  </a>
                                  </td>
                                  <td style='display:none'>
                                  <div id='" . db_get($i, 0) . "' style='display:none;width:800px' class='card__body'>
                                  <img src='img/" . db_get($i, 1) . "'>
                                  </div>
                                  </td>
                                  </tr>
                                ";
                              }
                            }else {

                              echo "<tr><td colspan='9'>Vehicle is not available</td></tr>";
                            }  
                            
                            echo "
                              <tr>
                              <td colspan='10' style='text-align:center'>"; 
                              func_getPaging('counter_reservation.php?x&btn_search=&search_pickup_date=' . $search_pickup_date . '&search_pickup_time=' . $search_pickup_time . '&search_return_date=' . $search_return_date . '&search_return_time=' . $search_return_time . '&search_pickup_location=' . $search_pickup_location . '&search_return_location=' . $search_return_location . '&search_vehicle=' . $search_vehicle);

                            echo "</td> </tr>"; 
                          }
                          else{

                            echo "<tr><td colspan='9'>No record found</td></tr>";
                          }    
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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

<script>
function validateForm() {
    var search_pickup_time = document.forms["myForm"]["search_pickup_time"].value;
    var search_pickup_date = document.forms["myForm"]["search_pickup_date"].value;
    var search_pickup_location = document.forms["myForm"]["search_pickup_location"].value;
    var search_return_location = document.forms["myForm"]["search_return_location"].value;
    var search_return_date = document.forms["myForm"]["search_return_date"].value;
    var search_return_time = document.forms["myForm"]["search_return_time"].value;
    var search_driver = document.forms["myForm"]["search_driver"].value;
    var err = "";

    if (search_pickup_time == "") {
      err = err + "- Please provide pickup time<br/>";
    }

    if(search_pickup_date == ""){
      err = err + "- Please provide pickup date<br/>";
    }

    if(search_pickup_location == ""){
      err = err + "- Please provide pickup location<br/>";
    }

    if(search_return_location == ""){
      err = err + "- Please provide return location<br/>";
    }

    if(search_return_date == ""){
      err = err + "- Please provide return date<br/>";
    }

    if(search_return_time == ""){
      err = err + "- Please provide return time<br/>";
    }

    if(search_driver == ""){
      err = err + "- Please provide driver<br/>";
    }

    if(err != ""){
      document.getElementById("err").innerHTML = err;
      return false;
    }
  }
</script>

<script type="text/javascript">
 function change() {
        var select = document.getElementById("opt");
        var divv = document.getElementById("opt-cont");
        var value = select.value;
        if (value == "delivery") {
            toAppend = "<div class='col-md-4'><div class='form-group'><label class='label-control'>Delivery Address for Pickup</label><input class='form-control' type='textbox' name='p_delivery_address' value='<?php echo $p_delivery_address; ?>' ></div></div><div class='col-md-4'><div class='form-group'><label class='label-control'>Delivery Address for Return</label><input class='form-control' type='textbox' name='r_delivery_address' value='<?php echo $r_delivery_address; ?>' ></div></div><div class='col-md-4'><div class='form-group'><label class='label-control'>Delivery Cost</label><input class='form-control' type='number' step='0.01' name='delivery_cost' value='<?php echo $delivery_cost; ?>'></div></div><div class='ln_solid'></div>"; divv.innerHTML=toAppend; return;
            }
            if (value == "pickup") {
                toAppend = "<div class='col-md-4'><div class='form-group'><label class='label-control' name='pickup-address'>Pickup Address for Pickup</label> <input class='form-control' type='textbox' name='p_pickup_address' value='<?php echo $p_pickup_address; ?>' ></div></div> <div class='col-md-4'><div class='form-group'><label class='label-control' name='pickup-address'>Pickup Address for Return</label> <input class='form-control' type='textbox' name='r_pickup_address' value='<?php echo $r_pickup_address; ?>' ></div></div><div class='col-md-4'><div class='form-group'><label class='label-control' name='pickup-cost'>Pickup Cost</label> <input class='form-control' type='number' name='pickup_cost' step='0.01' value='<?php echo $pickup_cost; ?>'></div></div><div class='ln_solid'></div>";divv.innerHTML = toAppend;  return;
            }
        if (value == "") {
          toAppend = "<div class='col-md-4'><div class='form-group'></div></div> <div class='col-md-4'><div class='form-group'></div></div>";divv.innerHTML = toAppend;  return;
        }
     }
</script>


<script>
    $(document).ready(function () {
        var date_input = $('input[name="search_pickup_date"]');
        var container = $('.bootstrap form').length > 0 ? $('.bootstrap form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>

<script>
    $(document).ready(function () {
        var date_input = $('input[name="search_return_date"]');
        var container = $('.bootstrap form').length > 0 ? $('.bootstrap form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
<script>
  var time = new Date().getTime();
  $(document.body).bind("mousemove keypress", function(e) {
    time = new Date().getTime();
  });

  function refresh() {
    if(new Date().getTime() - time >= 1800000) 
      window.location.reload(true);
    else 
      setTimeout(refresh, 1800000);
  }

  setTimeout(refresh, 1800000);
</script>