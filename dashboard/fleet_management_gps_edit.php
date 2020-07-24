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

   	func_isEmpty($vehicle_id, "vehicle_id"); 

   	func_isEmpty($owner_name, "owner name"); 

   	func_isEmpty($nric_no, "nric no"); 

   	func_isEmpty($serial_no, "serial no"); 

   	func_isEmpty($phone_no, "phone no"); 

   	func_isEmpty($credit_balance, "credit balance"); 

   	func_isEmpty($expiry_date, "expiry date"); 

   	func_isEmpty($sim_expiry_date, "sim expiry date"); 

   	func_isNum($credit_balance, "credit balance"); 

   if(func_isValid()){ 

   	$sql = "UPDATE gps SET 
  			vehicle_id = '".$vehicle_id."',
  			owner_name = '".conv_text_to_dbtext3($owner_name)."',
  			nric_no = '".conv_text_to_dbtext3($nric_no)."',
  			serial_no = '".conv_text_to_dbtext3($serial_no)."',
  			phone_no = '".$phone_no."', 
  			credit_balance = ".$credit_balance.",
  			expiry_date = '".conv_datetodbdate($expiry_date)."',
  			sim_expiry_date = '".conv_datetodbdate($sim_expiry_date)."',
  			mid = ".$_SESSION['cid'].",
  			mdate = CURRENT_TIMESTAMP
  			WHERE id = ".$_GET['id']; 

  			db_update($sql); 

  			vali_redirect("fleet_management_gps.php?btn_search=Search&page=".$page."&search_vehicle=".$search_vehicle); 

  					} 

  				}

  			else if(isset($btn_delete)){ 

  		$sql = "DELETE from gps WHERE id = ".$_GET['id']; 

  		db_update($sql); 

  		vali_redirect("fleet_management_gps.php?btn_search=Search&page=".$page."&search_vehicle=".$search_vehicle); 

  		}else{ 

  		$sql = "SELECT vehicle_id, 
  		owner_name, 
  		nric_no, 
  		serial_no, 
  		phone_no, 
  		credit_balance, 
  		DATE_FORMAT(expiry_date, '%d/%m/%Y') as expiry_date, 
  		DATE_FORMAT(sim_expiry_date, '%d/%m/%Y') as sim_expiry_date 
  		FROM gps 
  		WHERE id=".$_GET['id']; 

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
                  <h3>Edit Gps</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Gps</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle
                          </label>
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

  							echo $value; ?>
  								</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="owner_name">Owner Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="owner_name" value="<?php echo $owner_name;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="nric_no" class="control-label col-md-3 col-sm-3 col-xs-12">NRIC No</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="nric_no" value="<?php echo $nric_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="serial_no" class="control-label col-md-3 col-sm-3 col-xs-12">Serial No</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="serial_no" value="<?php echo $serial_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="phone_no" class="control-label col-md-3 col-sm-3 col-xs-12">Phone No</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="phone_no" value="<?php echo $phone_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="credit_balance" class="control-label col-md-3 col-sm-3 col-xs-12">Credit Balance</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="credit_balance" value="<?php echo $credit_balance;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Expiry Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="expiry_date" aria-describedby="inputSuccess2Status" name="expiry_date" value="<?php echo $expiry_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Sim Expiry Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                            <input type="text" class="form-control" id="single_cal2" placeholder="sim_expiry_date" aria-describedby="inputSuccess2Status" name="sim_expiry_date" value="<?php echo $sim_expiry_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='fleet_management_gps.php?btn_search=&search_vehicle=<?php echo $search_vehicle;?>'">Cancel</button>

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