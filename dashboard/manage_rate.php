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
      func_isEmpty($oneday, "oneday");
      func_isEmpty($twoday, "twodays");
      func_isEmpty($threeday, "threedays");
      func_isEmpty($fourday, "fourdays");
      func_isEmpty($fiveday, "fivedays");
      func_isEmpty($sixday, "sixdays");
      func_isEmpty($weekly, "weekly");
      func_isEmpty($monthly, "monthly");
      func_isEmpty($hour, "hour");
      func_isEmpty($halfday, "halfday");
      func_isEmpty($deposit, "deposit");
      func_isNum($oneday, "oneday");
      func_isNum($twoday, "twodays");
      func_isNum($threeday, "threedays");
      func_isNum($fourday, "fourdays");
      func_isNum($fiveday, "fivedays");
      func_isNum($sixday, "sixdays");
      func_isNum($weekly, "weekly");
      func_isNum($monthly, "monthly");
      func_isNum($hour, "hour");
      func_isNum($halfday, "halfday");
      func_isNum($deposit, "deposit");
      if (func_isValid()) {
          $sql = "UPDATE car_rate SET 
                  oneday='$oneday', 
                  twoday='$twoday', 
                  threeday='$threeday', 
                  fourday='$fourday', 
                  fiveday='$fiveday', 
                  sixday='$sixday', 
                  weekly='$weekly', 
                  monthly='$monthly', 
                  hour='$hour',
                  halfday='$halfday',
                  deposit='$deposit'
                  WHERE class_id=" . $_GET['id'];
          db_update($sql);
          vali_redirect("manage_classes.php?btn_search=Search&page=" . $page . "&search_name=" . $search_name);
      }
  } else {
      $sql = "SELECT * FROM car_rate WHERE class_id=" . $_GET['id'];
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
                  <h3>Manage Rate</h3>
                </div>

                
              </div>

              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Manage Rate</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hour">Per Hour (MYR)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="hour" value="<?php echo $hour; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="halfday">Half Day (MYR)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="halfday"  value="<?php echo $halfday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="oneday" class="control-label col-md-3 col-sm-3 col-xs-12">1 Day (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="oneday"  value="<?php echo $oneday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="twoday" class="control-label col-md-3 col-sm-3 col-xs-12">2 Days (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="twoday"  value="<?php echo $twoday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="threeday" class="control-label col-md-3 col-sm-3 col-xs-12">3 Days (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="threeday"  value="<?php echo $threeday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="fourday" class="control-label col-md-3 col-sm-3 col-xs-12">4 Days (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="fourday"  value="<?php echo $fourday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="fiveday" class="control-label col-md-3 col-sm-3 col-xs-12">5 Days (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="fiveday" value="<?php echo $fiveday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="sixday" class="control-label col-md-3 col-sm-3 col-xs-12">6 Days (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="sixday" value="<?php echo $sixday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="weekly" class="control-label col-md-3 col-sm-3 col-xs-12">Weekly (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="weekly"  value="<?php echo $weekly; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="monthly" class="control-label col-md-3 col-sm-3 col-xs-12">Monthly (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="monthly" value="<?php echo $monthly; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="deposit" class="control-label col-md-3 col-sm-3 col-xs-12">Deposit (MYR)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="deposit" value="<?php echo $deposit; ?>">
                          </div>
                        </div>
          
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
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