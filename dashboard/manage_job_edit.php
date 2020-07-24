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

      func_setValid("Y"); 

  if(func_isValid()){ 

      $sql="UPDATE job
            SET 
            job_title = '$job_title',
            assigned_to = '$assigned_to',
            assigned_by = '".$_SESSION['cid']."',
            modified = CURRENT_TIMESTAMP,
            due_date = '$due_date',
            job_desc = '$job_desc',
            vehicle_id = '$vehicle_id',
            others = '$others',
            branch = '$branch'
            WHERE id = ".$_GET['id']; 

      db_update($sql); 
      vali_redirect('manage_job.php?btn_search=&search_name='.$search_name.'&page='.$page); 

              } 

          }  

  else { 

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
                            <select name="job_title" class="form-control">
                              <option value="Job1" <?php echo vali_iif('Job1' == $job_title, 'selected', ''); ?>>Job 1</option>
                              <option value="Job2" <?php echo vali_iif('Job2' == $job_title, 'selected', ''); ?>>Job 2</option>
                              <option value="Job3" <?php echo vali_iif('Job3' == $job_title, 'selected', ''); ?>>Job 3</option>
                              <option value="Job4" <?php echo vali_iif('Job4' == $job_title, 'selected', ''); ?>>Job 4</option>
                            </select>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Branch
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="branch" class="form-control">
                                  <?php
                               
                                  $sql = "SELECT id,description FROM location where status = 'A'"; 
                                  db_select($sql); 

                                  if(db_rowcount()>0){ 

                                    for($j=0;$j<db_rowcount();$j++){ 

                                      echo "<option value='".db_get($j,0)."' ". vali_iif(db_get($j,0) == $branch, 'selected', '').">".db_get($j,1)."</option>";
                                    } 

                                  } 

                                  ?>
                                  </select>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Vehicle Plate No.
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="vehicle_id" class="form-control">
                                  <?php
                               
                                  $sql = "SELECT id,reg_no FROM vehicle"; 
                                  db_select($sql); 

                                  if(db_rowcount()>0){ 

                                    for($j=0;$j<db_rowcount();$j++){ 

                                      echo "<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$vehicle_id,'Selected','').">".db_get($j,1)."</option>";
                                    } 

                                  }  

                                  ?>
                                  </select>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Assigning to
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="assigned_to" class="form-control">
                                  <?php
                               
                                  $sql = "SELECT id,nickname FROM user"; 
                                  db_select($sql); 

                                  if(db_rowcount()>0){ 

                                    for($j=0;$j<db_rowcount();$j++){ 

                                      echo "<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$assigned_to,'Selected','').">".db_get($j,1)."</option>";
                                    } 

                                  }  

                                  ?>
                                  </select>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date">Due Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" class="form-control" placeholder="due_date" name="due_date" value="<?php echo date('Y-m-d',strtotime($due_date));?>">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span> 
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="job_desc" class="control-label col-md-3 col-sm-3 col-xs-12">Job Description</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="job_desc"><?php echo $job_desc; ?></textarea>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="others" class="control-label col-md-3 col-sm-3 col-xs-12">Others</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="others"><?php echo $others; ?></textarea>
                          </div>
                        </div>



                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                          <button type="button" class="btn btn-primary" onclick="location.href='manage_job.php?btn_search=&search_name=<?php echo $search_name;?>&page=<?php echo $page;?>'" name="btn_cancel">Cancel</button>
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