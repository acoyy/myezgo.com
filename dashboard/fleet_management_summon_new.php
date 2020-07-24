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
   	func_isEmpty($nric_no, "NRIC No"); 
   	func_isEmpty($name, "name"); 
   	func_isEmpty($address, "address"); 
   	func_isEmpty($date, "date"); 
   	func_isEmpty($vehicle_id, "vehicle_id"); 
   	func_isEmpty($booking_no, "booking no"); 
   	func_isEmpty($amount, "amount"); 
   	func_isEmpty($location_id, "location"); 
   	func_isEmpty($issuer, "issuer"); 
   	func_isEmpty($ctos, "ctos"); 
   	func_isEmpty($phone_no, "phone_no"); 

   if(func_isValid()){ 

   	$sql = "INSERT INTO fleet_summon
  			(
  			nric_no,
  			name,
  			address,
  			date,
  			vehicle_id,
  			booking_no,
  			amount,
  			location,
  			issuer,
  			status,
  			ctos,
  			phone_no,
  			fault,
  			cid,
  			cdate
  			)
  			VALUES(
  			'".$nric_no."',
  			'".conv_text_to_dbtext3($name)."',
  			'".conv_text_to_dbtext3($address)."',
  			'".conv_datetodbdate($date)."',
  			'".$vehicle_id."', 
  			'".conv_text_to_dbtext3($booking_no)."',
  			".$amount.",
  			'".conv_text_to_dbtext3($location_id)."',
  			'".$issuer."',
  			'New',
  			'".$ctos."',
  			'".$phone_no."',
  			'".$fault."',
  			".$_SESSION['cid'].",
  			CURRENT_TIMESTAMP 		
  			)"; 

  			db_update($sql); 

  			vali_redirect("fleet_management_summon.php?btn_search=Search&page=".$page."&search_vehicle=".$search_vehicle); 

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
                  <h3>Add Summon</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Summon</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"  method="POST">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No.</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="nric_no" <?php echo $disabled;?> onchange="getCustomerInfo(this.value)">

  						<?php  
  						
  						$value = ""; 
  						$sql = "SELECT nric_no, CONCAT(firstname, ' ' , lastname) as name  from customer WHERE status = 'A'"; 

  						db_select($sql); 

  						if(db_rowcount()>0){ 

  						for($j=0;$j<db_rowcount();$j++){ 

  						$value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$nric_no,'Selected','').">
  								".db_get($j,0)." : " .db_get($j,1)."</option>"; 

  									} 

  								} 

  							echo $value; 

  							?>

  								</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" value="<?php echo $name;?>" id="name" disabled>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="address" id="address"><?php echo $address;?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="phone_no" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="phone_no" id="phone_no"><?php echo $phone_no;?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="date" class="control-label col-md-3 col-sm-3 col-xs-12">Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="date" aria-describedby="inputSuccess2Status" name="date" value="<?php echo $date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                          
                        </div>

                        <div class="form-group">
                          <label for="date" class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="location_id" value="<?php echo $location_id;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="date" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle</label>
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
                          <label for="booking_no" class="control-label col-md-3 col-sm-3 col-xs-12">Booking No</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="booking_no" value="<?php echo $booking_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Amount</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="amount" value="<?php echo $amount;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="issuer" class="control-label col-md-3 col-sm-3 col-xs-12">Issuer</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="issuer" class="form-control">
  									<option value='JPJ' <?php echo vali_iif('JPJ'==$issuer,'Selected','');?>>JPJ</option>
  									<option value='PDRM' <?php echo vali_iif('PDRM'==$issuer,'Selected','');?>>PDRM</option>
  								</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Fault</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="fault" value="<?php echo $fault ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control" disabled>
                                          <option selected="selected" value='New' <?php echo vali_iif('New'==$status,'Selected','');?>>New</option>
                                      </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="ctos" class="control-label col-md-3 col-sm-3 col-xs-12">CTOS Action</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="ctos" class="form-control">
  									<option value='1' <?php echo vali_iif('1'==$ctos,'Selected','');?>>1</option>
  									<option value='2' <?php echo vali_iif('2'==$ctos,'Selected','');?>>2</option>
  									<option value='3' <?php echo vali_iif('3'==$ctos,'Selected','');?>>3</option>
  									<option value='B' <?php echo vali_iif('B'==$ctos,'Selected','');?>>B</option>
  								</select>
                          </div>
                        </div>
      
                        

                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="button">Cancel</button>
                <button class="btn btn-primary" type="reset">Reset</button>
                            <button name="btn_save" type="submit" class="btn btn-success">Submit</button>
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