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

  if (func_isValid()) { 

      $vehicle_id = $_GET['id']; 

      $sql = "INSERT INTO investor
              (
                  vehicle_id,
                  investor_name,
                  phone_no,
                  address,
                  nric,
                  bank_name,
                  monthly_loan,
                  loan_account_no,
                  owner_account_no,
                  value_in,
                  rate
              )
              VALUES
              (
                  '$vehicle_id',
                  '$name',
                  '$phone_no',
                  '$address',
                  '$nric',
                  '$commercial_bank_name',
                  '$monthly_loan',
                  '$loan_account_no',
                  '$owner_account_no',
                  '$value_in',
                  '$rate'
              )"; 

          db_update($sql); 

          vali_redirect("manage_vehicle.php"); 

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
                  <h3>Add Investor Details</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Investor Details</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="name" value="<?php echo $name; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="address" value="<?php echo $address; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">NRIC</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="nric" value="<?php echo $nric; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="phone_no" value="<?php echo $phone_no; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Commercial Bank Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="commercial_bank_name" value="<?php echo $commercial_bank_name; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Owner Account Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" class="form-control" name="owner_account_no" value="<?php echo $owner_account_no; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Loan Account Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="loan_account_no" value="<?php echo $loan_account_no; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Monthly Loan</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="monthly_loan" value="<?php echo $monthly_loan; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Value In</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="value_in" class="form-control">
                                                  <option value='P' <?php echo vali_iif('P'==$value_in,'Selected','');?>>Percentage</option>
                                                  <option value='A' <?php echo vali_iif('A'==$value_in,'Selected','');?>>Amount</option>
                                              </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Rate</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Rate" name="rate" value="<?php echo $rate;?>">
                          </div>
                        </div>
                
                 

                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                            <button class="btn btn-primary" type="button">Cancel</button>
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