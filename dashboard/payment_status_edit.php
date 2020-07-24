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

   if(isset($btn_save)){ 


    $sql = "UPDATE booking_trans SET refund_dep_payment='$refund_dep_payment',payment_details='$payment_details' WHERE id =".$_GET['id']; 

    db_update($sql); 

    // echo 'id dia iaaalah '.$_GET['id'];
    vali_redirect("payment_list.php?btn_search=&page=".$page); 

    }

      else{ 

     $sql = "SELECT
         vehicle.id AS vehicle_id,
         DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
         DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
         CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
         DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
         DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
         CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
         concat(firstname,' ' ,lastname) AS fullname,
         concat(make, ' ', model) AS car,
         reg_no,
         nric_no,
         address,
         phone_no,
         email,
         license_no,
         sub_total,
         refund_dep,
         agreement_no,
         refund_dep_payment,
         payment_details,
         balance
         FROM customer
         JOIN booking_trans ON customer.id = customer_id 
         JOIN vehicle ON vehicle_id = vehicle.id
         WHERE booking_trans.id=".$_GET['id']; 

    db_select($sql); 

    if (db_rowcount() > 0) { 

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
                  <h3>Edit Payment Status</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Payment Status</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $fullname; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Price <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo 'RM'.$sub_total; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deposit Price <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo 'RM'.$refund_dep; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Balance <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php
            $left=$sub_total-$balance;

             echo 'RM'.$left; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deposit Status <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="refund_dep_payment" class="form-control">

                              <?php echo 'RM'.$refund_dep; ?>

                              <option value=""  >Please Select</option>

                              <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Return'>Return</option>

                              <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>

                                
                              <option value="">Please Select</option>
                          <option <?php echo vali_iif('Collect' == $refund_dep_payment, 'Selected', ''); ?> value='Collect'>Collect</option>
                          <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
                          <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
                          <option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
                          <option <?php echo vali_iif('Nil' == $refund_dep_payment, 'Selected', ''); ?> value='Nil'>Nil</option>
                          <option <?php echo vali_iif('Return' == $refund_dep_payment, 'Selected', ''); ?> value='Return'>Return</option>
                          <option <?php echo vali_iif('Closing' == $refund_dep_payment, 'Selected', ''); ?> value='Closing'>Closing</option>
                          </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Payment Status <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="payment_details" class="form-control">

            <option value=""  >Please Select</option>

            <option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?> value='Return'>Return</option>

            <option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?> value='Online'>Online</option>
              

            <option <?php echo vali_iif('Collect' == $payment_details, 'Selected', ''); ?>  value='Collect'>Collect</option>
            
            <option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?>  value='Cash'>Cash</option>
            
            <option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?>  value='Online'>Online</option>
            
            <option <?php echo vali_iif('Card' == $payment_details, 'Selected', ''); ?>  value='Card'>Card</option>
            
            <option <?php echo vali_iif('Nil' == $payment_details, 'Selected', ''); ?>  value='Nil'>Nil</option>
            
            <option <?php echo vali_iif('Return' == $payment_details, 'Selected', ''); ?>  value='Return'>Return</option>
            
            <option <?php echo vali_iif('Closing' == $payment_details, 'Selected', ''); ?>  value='Closing'>Closing</option>

            </select>
                          </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                  <button type="button" class="btn btn-primary" onclick="location.href='payment_list.php?btn_search=&page=<?php echo $page;?>'" name="btn_cancel">Cancel</button>
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