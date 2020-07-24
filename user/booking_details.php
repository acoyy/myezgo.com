<?php
session_cache_limiter('');
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");

// $page = $_SERVER['PHP_SELF'];
// $sec = "10";
// header("Refresh: $sec; url=$page");

// header("Cache-Control: no-cache, must-revalidate");


if(isset($_SESSION['user_id']))
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
  include ("_header.php");

  func_setReqVar(); 

  $sql = "SELECT * FROM customer WHERE id = ".$_SESSION['user_id']; 
  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

  }

  $sql = "SELECT * FROM booking_trans WHERE id = ".$_GET['booking_id'];
  db_select($sql);

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

  }

  $pickup_time = date('H.i',strtotime($pickup_date));
  $pickup_date = date('d/m/Y',strtotime($pickup_date));
  $return_time = date('H.i',strtotime($return_date));
  $return_date = date('d/m/Y',strtotime($return_date));

  if($customer_id == $_SESSION['user_id'])
  {
  
  ?>

<style>
  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: Arial;
  }

  /* The grid: Four equal columns that floats next to each other */
  .column {
    float: left;
    width: 25%;
    padding: 10px;
  }

  /* Style the images inside the grid */
  .column img {
    opacity: 0.8; 
    cursor: pointer; 
  }

  .column img:hover {
    opacity: 1;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  /* The expanding image container */
  .container {
    position: relative;
    /*display: none;*/
  }

  /* Expanding image text */
  #imgtext {
    position: absolute;
    bottom: 15px;
    left: 15px;
    color: white;
    font-size: 20px;
  }

  /* Closable button inside the expanded image */
  .closebtn {
    position: absolute;
    top: 10px;
    right: 15px;
    color: white;
    font-size: 35px;
    cursor: pointer;
  }
</style>

  <style>
  </style>

  <script src="assets/js/fabric.min.js"></script>
  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="assets/js/html5-canvas-drawing-app.js"></script>

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
                  <h3>My Booking</h3>
                </div>
              </div>

              <div class="clearfix"></div>
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <div class="row">
                        <div class="row">
                          <div class="col-md-4" style="text-align: center;">
                            <img width="240px" src='img/<?php echo $company_image; ?>?nocache=<?php echo time(); ?>'>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <div class="row">
                                <br><br>
                                <h4><?php echo $company_name; ?></h4>
                                <p><?php echo $website_name; ?></p>
                                <p><?php echo $company_address; ?></p>
                                <p><?php echo $company_phone_no; ?></p>
                                <p><?php echo $registration_no; ?></p>
                                <p>Details about rental will be displayed below.</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <br><br>
                            <center>
                              <h3>
                                <font size="4">Agreement No: <i><b><?php echo $agreement_no;?></b></i></font>
                                <br><br>
                                <a href="bookingreceipt.php?id=<?php echo $_GET['booking_id']; ?>">
                                <button class="btn btn-primary"><i class="fa fa-file-o"></i>&nbsp;&nbsp;&nbsp;Booking Receipt&nbsp;&nbsp;&nbsp;<i class="fa fa-file-o"></i></button></a>
                                 <a target="_blank" href="https://wa.me/60144005050">
                                  <button class="btn btn-success">
                                    <i class="fa fa-whatsapp" style="font-size:20px;color:white"></i>
                                    &nbsp; 
                                    <font color='white'>Contact us for more info </font>
                                    &nbsp;
                                    <i class="fa fa-whatsapp" style="font-size:20px;color:white"></i>
                                  </button>
                                 </a> 
                              </h3>
                            <br><br>
                              <div class="btn-group">
                              </div>
                            </center>
                        </div>
                    </div>
                  </div>

                  <br>


                    <div class="x_title">
                      <h2>Customer Information</h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $firstname.' '.$lastname; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $nric_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone No
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $phone_no; ?>" disabled>
                          </div>
                        </div>

                        <?php
                          if($license_no != NULL)
                          {
                        ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone No 2<br><i>Optional</i>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control" value="<?php if($phone_no2 == NULL){ echo '-'; } else{ echo $phone_no2;} ?>" disabled>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Driving License</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control" value="<?php echo $license_no; ?>" disabled>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Address
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control" value="<?php echo $address; ?>" disabled>
                              </div>
                            </div>
                        <?php
                          }
                        ?>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Email
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $email; ?>" disabled>
                          </div>
                        </div>
                      </form>
                    </div>

                  <!-- End Customer Information -->


                  <!-- Start Payment Information -->
                    <div class="x_title">
                      <h2>Payment Information</h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name='sale_pickup_date' id='sale_pickup_date' value="<?php echo $pickup_date; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $pickup_time; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name='sale_return_date' id='sale_return_date' value="<?php echo $return_date; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $return_time; ?>" disabled>
                          </div>
                        </div>

                        <div class="ln_solid"></div>

                        <?php if($agent_id != '0') { ?>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Total (RM)</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" min='0.01' step='0.01' class="form-control" name="sale2" value="<?php echo $sub_total; ?>" id="sale2" required disabled>
                            </div>
                          </div>
                        
                        <?php } else { ?>
                        
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Total (RM)</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" min='0.01' step='0.01' class="form-control" name="sale2" value="<?php echo $est_total; ?>" id="sale2" required disabled>
                            </div>
                          </div>

                        <?php } ?>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment (RM)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $balance; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit (RM)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $refund_dep; ?>" disabled>
                          </div>
                        </div>

                        <?php
                        if ($payment_details == 'Collect')
                        {
                          $payment_details = 'Incomplete';
                        }
                        ?>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $payment_details; ?>" disabled>
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="ln_solid"></div>
                        </div>
                      </form>
                    </div>
                  <!-- End Payment Information -->


                  <!-- Start Vehicle Information -->
                    <div class="x_title">
                      <h2>Vehicle Information</h2>
                      
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                          
                        <?php
                        $sql = "SELECT 
                            id AS vehicle_id1,
                            reg_no AS reg_no1,
                            CONCAT(make, ' ', model) AS car1
                            FROM vehicle
                            WHERE availability = 'Available' OR availability = 'Out' OR availability = 'Booked' OR id = '$vehicle_id'
                            ORDER BY reg_no ASC
                            ";

                        db_select($sql);

                        if (db_rowcount() > 0) {

                          func_setSelectVar(); 
                        } 
                        ?>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="car2" id="car2" class="form-control" disabled>
                              <?php
                                for($i=0;$i<db_rowcount();$i++){
                                  ?>
                                  <option value="<?php echo db_get($i,0); ?>" <?php echo vali_iif(db_get($i,0) == $vehicle_id,'Selected','') ?>><?php echo db_get($i,2); ?></option>
                                  <?php
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <?php
                        if($available == "Booked") 
                        {
                          ?>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Coupon</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control" name="coupon2" id="coupon2" disabled>
                            </div>
                          </div>
                          <?php
                        }

                        if ($pickup_location == "4")
                        {
                          
                          $pickup_location = "Port Dickson";
                        }
                        else if ($pickup_location == "5")
                        {
                          
                          $pickup_location = "Seremban";
                        }
                        
                        if ($return_location == "4")
                        {
                          
                          $return_location = "Port Dickson";
                        }
                        else if ($return_location == "5")
                        {
                          
                          $return_location = "Seremban";
                        }
                        ?>
                      
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_location; ?>" disabled>
                          </div>
                        </div>

                        <div class="ln_solid"></div>


                      </form>
                    </div>
                  <!-- End Vehicle Information -->



            </div>
          </div>

          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>

      <script>
        var time = new Date().getTime();
        $(document.body).bind("mousemove keypress", function(e) {
          time = new Date().getTime();
        });

        function refresh() {
          if(new Date().getTime() - time >= 1200000) 
            window.location.reload(true);
          else 
            setTimeout(refresh, 1200000);
        }

        setTimeout(refresh, 1200000);

      </script>
    </body>
  </html>
          <?php } ?>
<?php
} else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='../login.php';
          </script>";
}
?>