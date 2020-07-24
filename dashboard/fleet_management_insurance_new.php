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

   	func_isEmpty($vehicle_id, "vehicle"); 

   	func_isEmpty($renewal_date, "renewal date"); 

   	func_isEmpty($serial_no, "serial no"); 

   	func_isEmpty($amount, "amount"); 

   	func_isEmpty($provider, "provider"); 

   	func_isEmpty($period, "period"); 

   	func_isEmpty($note, "note"); 

   	if (func_isValid()) {

   		$sql = "INSERT INTO
  				fleet_insurance
  				(
  				vehicle_id,
  				renewal_date,
  				serial_no,
  				amount,
  				provider,
  				period,
  				note,
  				cid,
  				cdate
  				)
  				VALUES
  				(
  				'" . $vehicle_id . "',
  				'" . conv_datetodbdate($renewal_date) . "',
  				'" . conv_text_to_dbtext3($serial_no) . "',
  				" . $amount . ",
  				'" . $provider . "',
  				" . $period . ",
  				'" . conv_text_to_dbtext3($note) . "',
  				" . $_SESSION['cid'] . ",
  				CURRENT_TIMESTAMP
  				)"; 

  				db_update($sql); 

  				vali_redirect("fleet_management_insurance.php?btn_search=Search&page=" . $page . "&search_vehicle=" . $search_vehicle); } }?>

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
                  <h3>Add Insurance</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Insurance</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="renewal_date">Renewal Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="renewal_date" aria-describedby="inputSuccess2Status" name="renewal_date" value="<?php echo $renewal_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="serial_no" class="control-label col-md-3 col-sm-3 col-xs-12">Serial No</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="serial_no" value="<?php echo $serial_no; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Amount</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="amount" class="control-label col-md-3 col-sm-3 col-xs-12">Provider</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="provider" class="form-control">
  									<option value=''>Please Select</option>
  									<option value='AIA' <?php echo vali_iif('AIA' == $provider, 'Selected', ''); ?>>AIA</option>
  									<option value='AIG' <?php echo vali_iif('AIG' == $provider, 'Selected', ''); ?>>AIG</option>
  									<option value='Allianz' <?php echo vali_iif('Allianz' == $provider, 'Selected', ''); ?>>Allianz</option>
  									<option value='Etiqa Takaful' <?php echo vali_iif('Etiqa Takaful' == $provider, 'Selected', ''); ?>>Etiqa Takaful</option>
  									<option value='Kurnia' <?php echo vali_iif('Kurnia' == $provider, 'Selected', ''); ?>>Kurnia</option>
  									<option value='Takaful Ikhlas' <?php echo vali_iif('Takaful Ikhlas' == $provider, 'Selected', ''); ?>>Takaful Ikhlas</option>
  									<option value='Takaful Malaysia' <?php echo vali_iif('Takaful Malaysia' == $provider, 'Selected', ''); ?>>Takaful Malaysia</option>
  									<option value='Tokio Marine' <?php echo vali_iif('Tokio Marine' == $provider, 'Selected', ''); ?>>Tokio Marine</option>
  									<option value='MAA Takaful' <?php echo vali_iif('MAA Takaful' == $provider, 'Selected', ''); ?>>MAA Takaful</option>
  									<option value='Zurich' <?php echo vali_iif('Zurich' == $provider, 'Selected', ''); ?>>Zurich</option>
  									<option value='Other' <?php echo vali_iif('Other' == $provider, 'Selected', ''); ?>>Other</option>
  								</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="period" class="control-label col-md-3 col-sm-3 col-xs-12">Period</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="period" class="form-control m-b" style="width: 15em">
  									<option value='1' <?php echo vali_iif('1' == $period, 'Selected', ''); ?>>1 years</option>
  									<option value='2' <?php echo vali_iif('2' == $period, 'Selected', ''); ?>>2 years</option>
  									<option value='3' <?php echo vali_iif('3' == $period, 'Selected', ''); ?>>3 years</option>
  									<option value='4' <?php echo vali_iif('4' == $period, 'Selected', ''); ?>>4 years</option>
  									<option value='5' <?php echo vali_iif('5' == $period, 'Selected', ''); ?>>5 years</option>
  									<option value='6' <?php echo vali_iif('6' == $period, 'Selected', ''); ?>>6 months</option>
  								</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="note" class="control-label col-md-3 col-sm-3 col-xs-12">Note (If any)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="note" value="<?php echo $note; ?>">
                          </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                            <button type="button" class="btn btn-default" onclick="location.href='fleet_management_insurance.php?btn_search=&search_vehicle=<?php echo $search_vehicle; ?>'">Cancel</button>

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