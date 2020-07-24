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

  if (isset($btn_save)) { 

      func_setValid("Y"); 

  if (func_isValid()) { 

      $sql = "INSERT INTO vehicle
        (
        reg_no,
        class_id,
        engine_no,
        chasis_no,
        make,
        model,
        year,
        color,
        location_id,
        availability,
        rate_type,
        power_type,
        min_rental_time,
        cid,
        engine,
        cdate)
        VALUES(
        '$reg_no',
        '$class_id',
        '$engine_no',
        '$chasis_no',
        '$make',
        '$model',
        '$year',
        '$color',
        '$location_id',
        '$availability',
        '$rate_type',
        '$power_type',
        '$min_rental_time',
        " . $_SESSION['cid'] . ",
        '$engine',
        CURRENT_TIMESTAMP
      )"; 

      db_update($sql); 

      $vehicle_id = mysqli_insert_id($con);


      $sql = "INSERT INTO booking_trans
        (
        agreement_no,
        pickup_location,
        pickup_date,
        pickup_time,
        return_date,
        return_time,                    
        vehicle_id,
        created,
        available
        )
        VALUES
        (
        'New Vehicle',
        '$location_id',
        now(),
        now(),
        now(),
        now(),
        '$vehicle_id',
        CURRENT_TIMESTAMP,
        'Park'
        )
      "; 


      db_update($sql); 


      // $sql = "SELECT LAST_INSERT_ID() FROM vehicle"; 

      // db_select($sql); 

      // if (db_rowcount() > 0) {

      //     $vehicle_id = mysqli_insert_id($con);

      // } 

      if($_POST['property'] == "company") { 

          vali_redirect("manage_vehicle.php"); 

      } 

      elseif($_POST['property'] == "investor") { 

        vali_redirect("investor_details_new.php?id=$vehicle_id"); 

      } 
    } 
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

            <div class="page-title">
                <div class="title_left">
                  <h3>Add Vehicle</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Vehicle</h2>
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
                      <form id="demo-form2" onSubmit="return validateThisFrom (this);" data-parsley-validate class="form-horizontal form-label-left" method="POST">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle Class
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="class_id" class="form-control">
                              
                              <?php  
                              
                              $value = ""; 
                              $sql = "SELECT id, class_name FROM class WHERE status = 'A'"; 
                              db_select($sql); 

                          if(db_rowcount()>0){ 

                              for($j=-1;$j<db_rowcount();$j++){ 

                                      if($j== '-1')
                                      {
                                          $value = $value."<option value='' ".vali_iif(''==$class_id,'Selected','').">-- Please select --</option>";
                                      }else
                                      {
                                          $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$class_id,'Selected','').">".db_get($j,1)."</option>";
                                      }
                                  } 

                            echo $value; 
                          }
                           ?>                  

                          </select>

                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Registration Number
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="reg_no" value="<?php echo $reg_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Engine Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="engine_no" value="<?php echo $engine_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Chasis Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="chasis_no" value="<?php echo $chasis_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Make</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="make" value="<?php echo $make;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="model" value="<?php echo $model;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="year" value="<?php echo $year;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Color</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="color" value="<?php echo $color;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Minimum Rental Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="min_rental_time" class="form-control">
                              <option value="">-- Please select --</option>
                              <option value="5 hours">5 hours</option>
                              <option value="1 day">1 day</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="location_id">
                              <?php  

                              $value = ""; 
                              $sql = "SELECT id, description, `default` from location";
                              db_select($sql); 

                              if(db_rowcount()>0){  

                                  for($j=-1;$j<db_rowcount();$j++){ 

                                      if($j== '-1')
                                      {
                                          $value = $value."<option value='' ".vali_iif(''==$location_id,'Selected','').">-- Please select --</option>";
                                      }else
                                      {
                                          $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$location_id,'Selected','').">".db_get($j,1)."</option>";
                                      }
                                  }

                                  echo $value;
                              } 

                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Engine</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="engine" value="<?php echo $engine; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Power Type</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="power_type" class="form-control">
                              <option value=''>-- Please select --</option>
                              <option value='Fuel' <?php echo vali_iif('Fuel' == $power_type, 'Selected', ''); ?>>Fuel</option>
                              <option value='Diesel' <?php echo vali_iif('Diesel' == $power_type, 'Selected', ''); ?>>Diesel</option>
                              <option value='Gas' <?php echo vali_iif('Gas' == $power_type, 'Selected', ''); ?>>Gas</option>
                              <option value='Electric' <?php echo vali_iif('Electric' == $power_type, 'Selected', ''); ?>>Electric</option>
                              <option value='Hybrid' <?php echo vali_iif('Hybrid' == $power_type, 'Selected', ''); ?>>Hybrid</option>
                            </select>

                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Availability</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="availability" class="form-control">
                                      <option value="">-- Please select --</option>
                                      <option value='Available' <?php echo vali_iif('Available'==$availability,'Selected','');?>>Available</option>
                                      <option value='Maintenance' <?php echo vali_iif('Maintenance'==$availability,'Selected','');?>>Maintenance</option>
                                      <option value='Accident' <?php echo vali_iif('Accident'==$availability,'Selected','');?>>Accident</option>
                                      <option value='Accident Total Lost' <?php echo vali_iif('Accident Total Lost'==$availability,'Selected','');?>>Accident Total Lost</option>
                                      <option value='Sold' <?php echo vali_iif('Sold'==$availability,'Selected','');?>>Sold</option>
                                      <option value='Pending Sale' <?php echo vali_iif('Pending Sale'==$availability,'Selected','');?>>Pending Sale</option>
                                      <option value='List On Site For Sale' <?php echo vali_iif('List On Site For Sale'==$availability,'Selected','');?>>List On Site For Sale</option>
                                      <option value='Disposed' <?php echo vali_iif('Disposed'==$availability,'Selected','');?>>Disposed</option>
                                  </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Car Owned By</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="property" class="form-control">
                                              <option value="">-- Please select --</option>
                                              <option name="company" value="company">Company</option>
                                              <option name="investor" value="investor">Investor</option>
                                          </select>
                          </div>
                        </div>
                        

                        

                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="btn_save">Save & Next</button>
                          <button type="button" class="btn btn-primary" onclick="location.href='manage_vehicle.php?btn_search=Search&page=<?php echo $page;?>&search_name=<?php echo $search_name;?>'" name="btn_cancel">Cancel</button>
                            
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
  <script language='JavaScript' type='text/javascript'>
      function validateThisFrom(thisForm) {
          if (thisForm.class_id.value == "") {
              alert("Please make a selection for Vehicle Class");
              thisForm.class_id.focus();
              return false;
          }
          if (thisForm.location_id.value == "") {
              alert("Please make a selection for Location");
              thisForm.location_id.focus();
              return false;
          }
          if (thisForm.power_type.value == "") {
              alert("Please make a selection for Power Type");
              thisForm.power_type.focus();
              return false;
          }
          if (thisForm.availability.value == "") {
              alert("Please make a selection Availability");
              thisForm.availability.focus();
              return false;
          }
          if (thisForm.property.value == "") {
              alert("Please make a selection for Car Owned By");
              thisForm.property.focus();
              return false;
          }
      }
  </script>
<?php  
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>