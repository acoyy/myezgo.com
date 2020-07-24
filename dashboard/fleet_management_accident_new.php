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

  include('_header.php'); 

  func_setReqVar(); 

      if (isset($_FILES['vehicle_image1'])) { 

      $errors = array(); 

      $vehicle_image1 = $_FILES['vehicle_image1']['name']; 

      $file_size = $_FILES['vehicle_image1']['size']; 

      $file_tmp = $_FILES['vehicle_image1']['tmp_name']; 

      $file_type = $_FILES['vehicle_image1']['type']; 

      $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image1']['name']))); 

      $expensions = array("jpeg", "jpg", "png"); 

      $file_name = date("Ymd") . "_" . basename($_FILES["vehicle_image1"]["name"]); 


      if (in_array($file_ext, $expensions) === false) { 

      $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

      } 

      if ($file_size > 2097152) { 

      $errors[] = 'File size must be excately 2 MB'; 

      } 

      if (empty($errors) == true) { 



      move_uploaded_file($file_tmp, "assets/img/" . $file_name); 

      echo "Success"; 

      } 

      else { 

      print_r($errors); 

      } 

      }

  if (isset($btn_save)) { 

      func_setValid("Y"); 

      func_isEmpty($vehicle_id, "vehicle"); 

      func_isEmpty($car_status, "car_status"); 

      func_isEmpty($accident_date, "accident date"); 

      func_isEmpty($closed_date, "closed date"); 

      func_isEmpty($action_taken, "action taken"); 

      func_isEmpty($pic, "pic"); 

      func_isEmpty($pic_phone, "pic_phone"); 

      func_isEmpty($car_location, "car location"); 

      func_isEmpty($cost, "cost"); 

      func_isEmpty($period_close_case, "period close case"); 

      func_isEmpty($follow_up_date, "follow up date"); 

      func_isEmpty($remark, "remark"); 

      func_isEmpty($oe_report, "oe that reported"); 

      // $file_name = date("Ymd") . "_" . basename($_FILES["image"]["name"]); 

      // $target_path = "../../dashboard/assets/img/" . $file_name; 

      // if (($_FILES["image"]["type"] == "") || ($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/jpg") || ($_FILES["image"]["type"] == "image/pjpeg") || ($_FILES["image"]["type"] == "image/x-png") || ($_FILES["image"]["type"] == "image/png")) { 

      //     move_uploaded_file($_FILES["image"]["tmp_name"], $target_path); 

      //     } 

      // else { 

      //     func_setErrMsg("- File is not a valid image file"); 

      //     } 

      if (func_isValid()) { 

          $sql = "INSERT INTO fleet_accident
                  (
                  vehicle_id,
                  car_status,
                  accident_date,
                  closed_date,
                  action_taken,
                  pic,
                  pic_phone,
                  car_location,
                  cost,
                  period_close_case,
                  follow_up_date,
                  remark,
                  oe_report,
                  status,
                  accident_image,
                  cid,
                  cdate
                  )
                  VALUES
                  (
                  '" . $vehicle_id . "',
                  '" . conv_text_to_dbtext3($car_status) . "',
                  '" . conv_datetodbdate($accident_date) . "',
                  '" . conv_datetodbdate($closed_date) . "',
                  '" . conv_text_to_dbtext3($action_taken) . "',
                  '" . conv_text_to_dbtext3($pic) . "',
                  '" . conv_text_to_dbtext3($pic_phone) . "',
                  '" . conv_text_to_dbtext3($car_location) . "',
                  " . $cost . ",
                  '" . conv_text_to_dbtext3($period_close_case) . "',
                  '" . conv_datetodbdate($follow_up_date) . "',
                  '" . conv_text_to_dbtext3($remark) . "',
                  '" . conv_text_to_dbtext3($oe_report) . "',
                  '" . $status . "',
                  '" . $file_name . "',
                  " . $_SESSION['cid'] . ",
                  CURRENT_TIMESTAMP
                  )"; 

                  db_update($sql); 

                  vali_redirect("fleet_management_accident.php?btn_search=Search&page=" . $page . "&search_vehicle=" . $search_vehicle); 

                          } 

                      } ?>

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
                  <h3>Add Accident</h3>
                </div>

                
              </div>

              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Accident</h2>
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
                      <form method="post" enctype = "multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_id">Vehicle 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="vehicle_id" <?php echo $disabled; ?>>
                           
                            <?php
                              
                            $value = ""; 

                            $sql = "SELECT id, reg_no, model, year from vehicle"; 

                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              for ($j = 0; $j < db_rowcount(); $j++) { 

                              $value = $value . "<option value='" . db_get($j, 0) . "' " . vali_iif(db_get($j, 0) == $vehicle_id, 'Selected', '') . ">" . db_get($j, 1) . " : " . db_get($j, 2) . " (" . db_get($j, 3) . ")</option>"; 

                                  } 

                              } 

                              echo $value; 

                              ?>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_status">Car Status
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="car_status" value="<?php echo $car_status; ?>" placeholder="Car Status">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="accident_date" class="control-label col-md-3 col-sm-3 col-xs-12">Accident Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="start_date" aria-describedby="inputSuccess2Status" name="accident_date" value="<?php echo $start_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="closed_date" class="control-label col-md-3 col-sm-3 col-xs-12">Closed Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal2" placeholder="Pickup Date" aria-describedby="inputSuccess2Status" name="closed_date" value="<?php echo $end_date;?>" autocomplete="off">
                                  
                                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                        </div>
                                 </div>
                        <div class="form-group">
                          <label for="action_taken" class="control-label col-md-3 col-sm-3 col-xs-12">Action Taken</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="action_taken" placeholder="Action Taken" value="<?php echo $action_taken; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="pic" class="control-label col-md-3 col-sm-3 col-xs-12">Person In Charge (PIC)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="pic" placeholder="Person In Charge (PIC)" value="<?php echo $pic; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="pic_phone" class="control-label col-md-3 col-sm-3 col-xs-12">PIC Phone</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="pic_phone" placeholder="PIC Phone" value="<?php echo $pic_phone; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="follow_up_date" class="control-label col-md-3 col-sm-3 col-xs-12">Follow Up Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal3" placeholder="Pickup Date" aria-describedby="inputSuccess2Status" name="follow_up_date" value="<?php echo $follow_up_date;?>" autocomplete="off">
                                  
                                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="remark" class="control-label col-md-3 col-sm-3 col-xs-12">Remark</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" placeholder="Remark" type="text" name="remark" value="<?php echo $remark; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="oe_report" class="control-label col-md-3 col-sm-3 col-xs-12">OE That Reported</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="OE That Reported" name="oe_report" value="<?php echo $oe_report; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="car_location" class="control-label col-md-3 col-sm-3 col-xs-12">Car Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Car Location" name="car_location" value="<?php echo $car_location; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="cost" class="control-label col-md-3 col-sm-3 col-xs-12">Cost</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Cost" name="cost" value="<?php echo $cost; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="period_close_case" class="control-label col-md-3 col-sm-3 col-xs-12">Period To Close Case</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Period To Close Case" name="period_close_case" value="<?php echo $period_close_case; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="transmission" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="transmission" class="form-control">
                              <option value='O' <?php echo vali_iif('O'==$status, 'Selected', ''); ?>>Open</option>
                              <option value='C' <?php echo vali_iif('C'==$status, 'Selected', ''); ?>>Close</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image1">Vehicle Image 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="btn btn-small btn-default" type="file" name="vehicle_image1">
                          </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='fleet_management_accident.php?btn_search=&search_vehicle=<?php echo $search_vehicle; ?>'">Cancel</button>
                          </div>
                        </div>

                      </form>
                    </div>
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