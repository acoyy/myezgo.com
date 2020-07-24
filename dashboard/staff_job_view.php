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

  if(isset($start)){ 

    $sql="UPDATE job
          SET 
          status = 'Pending',
          modified = CURRENT_TIMESTAMP
          WHERE id = ".$_GET['id']; 

    db_update($sql); 
    vali_redirect('staff_job.php'); 

  } else if(isset($done)){

    $sql="UPDATE job
          SET 
          status = 'Done',
          modified = CURRENT_TIMESTAMP,
          completed_date = CURRENT_TIMESTAMP
          WHERE id = ".$_GET['id']; 

    db_update($sql); 
    vali_redirect('staff_job.php'); 
  } else { 

    $sql = "SELECT * FROM job WHERE id=".$_GET['id']; 
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
                  <h3>Edit Job</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Job</h2>
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
                          <label for="job_title" class="control-label col-md-3 col-sm-3 col-xs-12">Job Title</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label">
                              <i><?php echo $job_title; ?></i>
                            </label>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Branch
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class='control-label'>
                                  <i>
                                    <?php
                               
                                    $sql = "SELECT description FROM location where id = $branch"; 
                                    db_select($sql); 

                                    if(db_rowcount()>0){ 
                                      for($j=0;$j<db_rowcount();$j++){ 
                                        echo db_get($j,0); 
                                      }
                                    }
                                    ?>
                                  </i>
                                </label>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Vehicle Plate No.
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label">
                              <i><?php
                           
                              $sql = "SELECT reg_no FROM vehicle where id = '$vehicle_id'"; 
                              db_select($sql); 

                              if(db_rowcount()>0){ 

                                for($j=0;$j<db_rowcount();$j++){ 

                                  echo db_get($j,0);
                                } 
                              }  

                              ?>
                              </i>
                            </label>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date">Due Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label"><i><?php echo date('d/m/Y',strtotime($due_date));?></i></label> 
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="job_desc" class="control-label col-md-3 col-sm-3 col-xs-12">Job Description</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" style="text-align: left;"><i><?php echo $job_desc; ?></i></font></label>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="others" class="control-label col-md-3 col-sm-3 col-xs-12">Others</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class='control-label'><i><?php echo $others; ?></i></label>
                          </div>
                        </div>



                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?php 
                            if ($status == 'Assigned')
                            {
                              ?>
                              <button type="submit" class="btn btn-success" name="start">Start</button>
                            <?php
                            }
                            else if($status == 'Pending')
                            {
                              ?><button type="submit" class="btn btn-success" name="done">Done</button><?php
                            } 
                            ?>
                          <button type="button" class="btn btn-primary" onclick="goBack()">Back</button>
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