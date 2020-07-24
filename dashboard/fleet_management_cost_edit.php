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

   if(isset($btn_save)){ 

      func_setValid("Y"); 
      func_isEmpty($location_id, "location"); 
      func_isEmpty($vehicle_id, "vehicle"); 
      func_isEmpty($fleet_date, "fleet date"); 
      func_isEmpty($cost_type, "cost type"); 
      func_isEmpty($pic, "pic"); 
      func_isEmpty($amount, "amount"); 

  if(func_isValid()){ 

      $sql = "UPDATE fleet_cost SET 
              location_id='".$location_id."', 
              fleet_date = '".conv_datetodbdate($fleet_date)."',
              vehicle_id = '".$vehicle_id."', 
              cost_type = '".$cost_type."',
              amount = ".$amount.", 
              pic = '".conv_text_to_dbtext3($pic)."', 
              cid = ".$_SESSION['cid'].", 
              mdate = CURRENT_TIMESTAMP 
              WHERE id=".$_GET['id']; 

      db_update($sql); 

      vali_redirect("fleet_management_cost.php?btn_search=Search&page=".$page."&search_vehicle=".$search_vehicle); 
          } 

      }else{ 


              $sql = "SELECT 
                        fleet_cost.id, 
                        reg_no,
                        model, 
                        year, 
                        DATE_FORMAT(fleet_date,'%d/%m/%Y') as fleet_date,
                        pic, 
                        amount, 
                        location.description ,
                        cost_type,
                        fleet_cost.location_id,
                        fleet_cost.vehicle_id
                        FROM fleet_cost 
                        LEFT JOIN vehicle ON vehicle.id = vehicle_id 
                        LEFT JOIN location ON location.id = fleet_cost.location_id 
                        WHERE fleet_cost.id=".$_GET['id']; 


              db_select($sql); 

      if(db_rowcount()>0){ 

          func_setSelectVar(); 
          
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
                  <h3>Fleet Management Cost Edit</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Fleet Management Cost Edit</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location_id">Location
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="location_id" <?php echo $disabled;?>>
                              <?php  

                              $value = ""; 

                              $sql = "SELECT id, description from location WHERE status = 'A'"; 

                              db_select($sql); 

                          if(db_rowcount()>0){ 

                              for($j=0;$j<db_rowcount();$j++){ 

                              $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$location_id,'Selected','').">
                                      ".db_get($j,1)."</option>"; 

                                  } 

                              } 

                              echo $value; 

                              ?>

                            </select>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fleet_date">Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                            <input type="text" class="form-control" id="single_cal1" placeholder="fleet_date" aria-describedby="inputSuccess2Status" name="fleet_date" value="<?php echo $fleet_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="vehicle_id" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="vehicle_id" <?php echo $disabled;?>>
                              
                              <?php  

                              $value = ""; 

                              $sql = "SELECT id, reg_no, model, year from vehicle"; 

                              db_select($sql); 

                              if(db_rowcount()>0){ 

                              for($j=0;$j<db_rowcount();$j++){ 

                              $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$vehicle_id,'Selected','').">
                                              ".db_get($j,1)." : ".db_get($j,2). " (" .db_get($j,3). ")</option>"; 

                                          } 

                              } 

                              echo $value; 

                              ?>
                                  </select>       
                          </div>
                        </div>

    
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Cost Type
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="cost_type" class="form-control">
                                          <option value='Fuel' <?php echo vali_iif('Fuel'==$cost_type,'Selected','');?>>Fuel</option>
                                          <option value='Service' <?php echo vali_iif('Service'==$cost_type,'Selected','');?>>Service</option>
                                          <option value='Wash' <?php echo vali_iif('Wash'==$cost_type,'Selected','');?>>Wash</option>
                                          <option value='Etc' <?php echo vali_iif('Etc'==$cost_type,'Selected','');?>>Etc</option>
                                      </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Person In Charge (PIC)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="pic" value="<?php echo $pic;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Amount 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="amount" value="<?php echo $amount;?>">
                          </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                          <button type="button" class="btn btn-warning" onclick="location.href='fleet_management_cost.php?btn_search=&search_vehicle=<?php echo $search_vehicle;?>'">Cancel</button>
                     
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