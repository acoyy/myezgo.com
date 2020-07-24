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

  if (isset($btn_save)) { 

      func_setValid("Y"); 
      func_isEmpty($vehicle_id, "vehicle_id"); 
      func_isEmpty($description, "description"); 
      func_isEmpty($status, "status"); 
      func_isNum($milleage, "milleage"); 

  if (func_isValid()) {

      if ($milleage == "") {

      $milleage = 0;

          } 

      $sql = "UPDATE fleet_maintenance SET
              vehicle_id = '".$vehicle_id."',
              description = '".conv_text_to_dbtext3($description)."',
              milleage = '".$milleage."',
              cost = '".$cost."',
              date = '".conv_datetodbdate($date)."',
              status = '".$status."',
              mid = ".$_SESSION['cid'].",
              mdate = CURRENT_TIMESTAMP
              WHERE id =".$_GET['id']; db_update($sql); vali_redirect("fleet_management_maintenance.php?btn_search=Search&page=" . $page . "&search_vehicle=" . $search_vehicle);} } else if (isset($btn_delete)) { $sql = "DELETE from fleet_maintenance WHERE id = " . $_GET['id']; db_update($sql); vali_redirect("fleet_management_maintenance.php?btn_search=Search&page=" . $page . "&search_vehicle=" . $search_vehicle); } else { $sql = "SELECT vehicle_id, description, milleage, cost, DATE_FORMAT(date, '%d/%m/%Y') as date, status
          FROM fleet_maintenance
          WHERE id=" . $_GET['id']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); 

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
                  <h3>Edit Maintenance</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Maintenance</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">

   

                          <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_id">Vehicle 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="vehicle_id" <?php echo $disabled; ?>>
                          <option value="">Please Select</option>
                          
                          <?php 

                          $value = ""; 

                          $sql = "SELECT id, reg_no, model, year from vehicle"; 

                          db_select($sql);

                          if (db_rowcount() > 0) {

                              for ($j = 0; $j < db_rowcount(); $j++) {

                              $value = $value . "<option value='" . db_get($j, 0) . "' " . vali_iif(db_get($j, 0) == $vehicle_id, 'Selected', '') . ">
                              " . db_get($j, 1) . " : " . db_get($j, 2) . " (" . db_get($j, 3) .")</option>";

                                          }

                                  } 

                              echo $value;

                              ?>
                          </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea type="text" class="form-control" name="description"><?php echo $description;?></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="cost" class="control-label col-md-3 col-sm-3 col-xs-12">Cost</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="cost" value="<?php echo $cost; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="milleage" class="control-label col-md-3 col-sm-3 col-xs-12">Mileage</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="milleage" value="<?php echo $milleage;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="renewal_date">Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="date" aria-describedby="inputSuccess2Status" name="date" value="<?php echo $date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                                      <option value='O' <?php echo vali_iif('O'==$status,'Selected','');?>>Open</option>
                                      <option value='C' <?php echo vali_iif('C'==$status,'Selected','');?>>Close</option>
                                  </select>
                          </div>
                        </div>




                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                            <button type="button" class="btn btn-default" onclick="location.href='fleet_management_mainenance.php?btn_search=&search_vehicle=<?php echo $search_vehicle;?>'">Cancel</button>

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