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
      func_isEmpty($perhour, "perhour");
      func_isEmpty($fivehour, "fivehour");
      func_isEmpty($halfday, "halfday");
      func_isEmpty($oneday, "oneday");
      func_isEmpty($twoday, "twoday");
      func_isEmpty($threeday, "threeday");
      func_isEmpty($fourday, "fourday");
      func_isEmpty($fiveday, "fiveday");
      func_isEmpty($sixday, "sixday");
      func_isEmpty($weekly, "weekly");
      func_isEmpty($monthly, "monthly");
      func_isNum($perhour, "perhour");
      func_isNum($fivehour, "fivehour");
      func_isNum($halfday, "halfday");
      func_isNum($oneday, "oneday");
      func_isNum($twoday, "twoday");
      func_isNum($threeday, "threeday");
      func_isNum($fourday, "fourday");
      func_isNum($fiveday, "fiveday");
      func_isNum($sixday, "sixday");
      func_isNum($weekly, "weekly");
      func_isNum($monthly, "monthly");
      
      if (func_isValid()) {
          $sql = "UPDATE agent_rate SET 
                  perhour='$perhour',
                  fivehour='$fivehour',
                  halfday='$halfday',
                  oneday='$oneday', 
                  twoday='$twoday', 
                  threeday='$threeday', 
                  fourday='$fourday', 
                  fiveday='$fiveday', 
                  sixday='$sixday', 
                  weekly='$weekly', 
                  monthly='$monthly'
                  WHERE id = '1' ";
          db_update($sql);
          vali_redirect("manage_agent_rate.php");
      }
  } else {
      $sql = "SELECT * FROM agent_rate WHERE id='1'";
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
                  <h3>Agent</h3>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="perhour">Per Hour (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="perhour" value="<?php echo $perhour; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fivehour">5 hours (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="fivehour" value="<?php echo $fivehour; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="halfday">Halfday (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="halfday" value="<?php echo $halfday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oneday">1 day (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="oneday" value="<?php echo $oneday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twoday">2 days (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="twoday" value="<?php echo $twoday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="threeday">3 days (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="threeday" value="<?php echo $threeday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fourday">4 days (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="fourday" value="<?php echo $fourday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fiveday">5 days (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="fiveday" value="<?php echo $fiveday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sixday">6 days (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="sixday" value="<?php echo $sixday; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="weekly">Weekly (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="weekly" value="<?php echo $weekly; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="monthly">Monthly (%)
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" max="100" class="form-control" name="monthly" value="<?php echo $monthly; ?>">
                          </div>
                        </div>
          
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                            <button class="btn btn-primary" type="button" onclick="goBack()">Cancel</button>
                            <script>
                                function goBack() {
                                    window.history.back();
                                }
                            </script>
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