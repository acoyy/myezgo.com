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
  $sql = "SELECT * FROM user WHERE id=" . $_SESSION['cid'];
  db_select($sql);
  if (db_rowcount() > 0) {
      func_setSelectVar();
  }
  if (isset($btn_save)) {
    func_setValid("Y");
    if (func_isValid()) {

      $sql = "INSERT INTO job
        (
        job_title,
        assigned_to,
        assigned_by,
        created,
        modified,
        due_date,
        job_desc,
        vehicle_id,
        others,
        branch,
        completed_date,
        status
        )
        VALUES
        ( 
        '" . conv_text_to_dbtext3($_POST['job_title']) . "',
        '" . conv_text_to_dbtext3($_POST['assigned_to']) . "',
        '" . conv_text_to_dbtext3($_SESSION['cid']) . "',
        CURRENT_TIMESTAMP,
        CURRENT_TIMESTAMP,
        '" . date('Y-m-d',strtotime($_POST['due_date'])) . "',
        '" . conv_text_to_dbtext3($_POST['job_desc']) . "',
        '" . conv_text_to_dbtext3($_POST['vehicle_id']) . "',
        '" . conv_text_to_dbtext3($_POST['others']) . "',
        '" . conv_text_to_dbtext3($_POST['branch']) . "',
        'Incomplete',
        'Assigned'
        )
        ";

      db_update($sql);
      vali_redirect('manage_job.php?btn_search=&search_name=' . $search_name . '&page=' . $page);
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
                    <h3>Job</h3>
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Job</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                      	<div class="form-group">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <center>
                              <button type="submit" class="btn btn-primary" name="btn_add">Add Job</button>
                              <button type="submit" class="btn btn-success" name="btn_active">Active Job</button>
                              <button type="submit" class="btn btn-warning" name="btn_pending">Pending Job</button>
                              <button type="submit" class="btn btn-info" name="btn_completed">Completed Job</button>
                              <button type="submit" class="btn btn-danger" name="btn_overdue">Overdue Job</button>
                              <button type="submit" class="btn btn-default" name="btn_deleted">Deleted Job</button>
                            </center>
                          </div>
                        </div>
                        <div class="ln_solid"></div>



                      </form>
                    </div>
                  </div>

                  <?php
                  if(isset($btn_add))
                  {
                    ?>
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Add Job</h2>
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
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="">


                          <div class="form-group">
                            <label for="job_title" class="control-label col-md-3 col-sm-3 col-xs-12">Job Title</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="job_title" class="form-control" required>
                                <option value=''> ---- Please select ---- </option>
                                <option value="Job1">Job 1</option>
                                <option value="Job2">Job 2</option>
                                <option value="Job3">Job 3</option>
                                <option value="Job4">Job 4</option>
                              </select>
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">Branch
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="branch" class="form-control" required>
                                    <?php
                                 
                                    $sql = "SELECT id,description FROM location where status = 'A'"; 
                                    db_select($sql); 

                                    if(db_rowcount()>0){ 

                                      for($j=-1;$j<db_rowcount();$j++){ 

                                        if($j == -1)
                                        {

                                          echo "<option value=''> ---- Please select ---- </option>";
                                        }
                                        else
                                        {

                                          echo "<option value='".db_get($j,0)."'>".db_get($j,1)."</option>";
                                        } 
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
                              <select name="vehicle_id" class="form-control" required>
                                    <?php
                                 
                                    $sql = "SELECT id,reg_no FROM vehicle"; 
                                    db_select($sql); 

                                    if(db_rowcount()>0){ 

                                      for($j=-1;$j<db_rowcount();$j++){ 

                                        if($j == -1)
                                        {

                                          echo "<option value=''> ---- Please select ---- </option>";
                                        }
                                        else if(db_get($j,0) != '1')
                                        {
                                          echo "<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$vehicle_id,'Selected','').">".db_get($j,1)."</option>";
                                        }
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
                              <select name="assigned_to" class="form-control" required>
                                    <?php
                                 
                                    $sql = "SELECT id,nickname FROM user"; 
                                    db_select($sql); 

                                    if(db_rowcount()>0){ 

                                      for($j=-1;$j<db_rowcount();$j++){ 

                                        if($j == -1)
                                        {

                                          echo "<option value=''> ---- Please select ---- </option>";
                                        }
                                        else if(db_get($j,0) != '1')
                                        {
                                          echo "<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$assign_to,'Selected','').">".db_get($j,1)."</option>";
                                        }
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
                              <input type="date" class="form-control" placeholder="due_date" name="due_date" value="<?php echo $due_date;?>" required>
                                    
                              <span id="inputSuccess2Status" class="sr-only">(success)</span> 
                            </div>
                          </div>


                          <div class="form-group">
                            <label for="job_desc" class="control-label col-md-3 col-sm-3 col-xs-12">Job Description</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <textarea class="form-control" name="job_desc" value="<?php echo $job_desc; ?>" required></textarea>
                            </div>
                          </div>


                          <div class="form-group">
                            <label for="others" class="control-label col-md-3 col-sm-3 col-xs-12">Others</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <textarea class="form-control" name="others" value="<?php echo $others; ?>" required></textarea>
                            </div>
                          </div>


                          <div class="ln_solid"></div>
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Create Job</button>
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>

                    <?php
                  }

                  if(isset($btn_active))
                  {

                    ?>
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Active Job</h2>
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

                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>job desc</th>
                                <th>reg No</th>
                                <th>Assigned to</th>
                                <th>due date</th>
                                <th>Branch</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                              <?php
                                func_setPage(); 
                                func_setOffset(); 
                                func_setLimit(10); 

                                if(isset($btn_search)){ 

                                  if($search_name!=""){ 

                                    $where=" AND user like '%".$search_name."%'"; 
                                  }
                                }
                                $sql = "SELECT id,nickname FROM user";
                                db_select($sql); 

                                if (db_rowcount() > 0) { 

                                  func_setSelectVar();
                                }

                                $sql = "SELECT 
                                    job.id,
                                    job_title,
                                    assigned_to,
                                    assigned_by,
                                    created,
                                    modified, 
                                    due_date,
                                    completed_date,
                                    job_desc,
                                    vehicle_id,
                                    job.branch,
                                    vehicle.reg_no,
                                    location.description,
                                    job.status
                                    FROM job
                                    LEFT JOIN user ON assigned_to = user.id
                                    LEFT JOIN vehicle ON vehicle_id = vehicle.id
                                    LEFT JOIN location ON job.branch = location.id
                                    WHERE job.id IS NOT NULL AND job.status = 'Assigned'" .$where; 

                                db_select($sql); 

                                func_setTotalPage(db_rowcount()); 

                                db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                                if(db_rowcount()>0){

                                  for($i=0;$i<db_rowcount();$i++){

                                    if(func_getOffset()>=10){ 

                                      $no=func_getOffset()+1+$i; 
                                    }
                                    else{ 

                                      $no=$i+1; 
                                    }

                                    echo "<tr>
                                          <th scope='row'>" . $no . "</th>
                                          <td>".db_get($i,1)."</td>
                                          <td>".db_get($i,8)."</td>
                                          <td>".db_get($i,11)."</td>";

                                    $sql1 = "SELECT nickname FROM user where id = '".db_get($i,2)."'";

                                    $result1 = mysqli_query($con,$sql1);

                                    while ($row = mysqli_fetch_assoc($result1)){

                                      echo "<td>".$row['nickname']."</td>";
                                    }

                                    echo "<td>".db_get($i,6)."</td>
                                          <td>".db_get($i,12)."</td>";

                                    if(db_get($i,13) == 'Assigned'){

                                      echo "<td><center>
                                              <a href='manage_job_edit.php?id=".db_get($i,0)."&search_vehicle=".$search_vehicle."'><i class='fa fa-pencil'></i></a>
                                              &nbsp;&nbsp;
                                              <a href='delete_job.php?id=".db_get($i,0)."' onClick='return confirm(\"Delete this?\")'><i class='fa fa-trash'></i></a></center>
                                            </td>";
                                    }
                                    else{

                                      echo "<td><i>Unavailable</i></td>";
                                    }
                                        
                                    echo "</tr>";
                                  }
                                }
                                else{ 

                                  echo "<tr><td colspan='13'>No records found</td></tr>"; 
                                }
                              ?>

                              <tr>
                                <td colspan="13" style="text-align:center">
                                  <?php  func_getPaging('manage_job.php?x&search_vehicle='.$search_vehicle); ?>
                                </td>
                              </tr>

                            </tbody>
                          </table>
                        </div>
                      </div>
                  <?php
                  }

                  if(isset($btn_pending))
                  {
                  ?>
                  
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Pending Job</h2>
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

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>job desc</th>
                            <th>reg No</th>
                            <th>Assigned to</th>
                            <th>Assigned by</th>
                            <th>due date</th>
                            <th>Branch</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                          <?php
                            func_setPage(); 
                            func_setOffset(); 
                            func_setLimit(10); 

                            if(isset($btn_search)){ 

                              if($search_name!=""){ 

                                $where=" AND user like '%".$search_name."%'"; 
                              }
                            }
                            $sql = "SELECT id,nickname FROM user";
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();
                            }

                            $sql = "SELECT 
                                job.id,
                                job_title,
                                assigned_to,
                                assigned_by,
                                created,
                                modified, 
                                due_date,
                                completed_date,
                                job_desc,
                                vehicle_id,
                                job.branch,
                                vehicle.reg_no,
                                location.description,
                                job.status
                                FROM job
                                LEFT JOIN user ON assigned_to = user.id
                                LEFT JOIN vehicle ON vehicle_id = vehicle.id
                                LEFT JOIN location ON job.branch = location.id
                                WHERE job.id IS NOT NULL AND job.status = 'Pending'" .$where; 

                            db_select($sql); 

                            func_setTotalPage(db_rowcount()); 

                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                            if(db_rowcount()>0){

                              for($i=0;$i<db_rowcount();$i++){

                                if(func_getOffset()>=10){ 

                                  $no=func_getOffset()+1+$i; 
                                }
                                else{ 

                                  $no=$i+1; 
                                }

                                echo "<tr>
                                      <th scope='row'>" . $no . "</th>
                                      <td>".db_get($i,1)."</td>
                                      <td>".db_get($i,8)."</td>
                                      <td>".db_get($i,11)."</td>";

                                $sql1 = "SELECT nickname FROM user where id = '".db_get($i,2)."'";
                                $sql2 = "SELECT nickname FROM user where id = '".db_get($i,3)."'";

                                $result1 = mysqli_query($con,$sql1);
                                $result2 = mysqli_query($con,$sql2);

                                while ($row = mysqli_fetch_assoc($result1)){

                                  echo "<td>".$row['nickname']."</td>";
                                }
                                while ($row = mysqli_fetch_assoc($result2))
                                {

                                  echo "<td>".$row['nickname']."</td>";
                                }

                                echo "<td>".db_get($i,6)."</td>
                                      <td>".db_get($i,12)."</td>";
                                    
                                echo "</tr>";
                              }
                            }
                            else{ 

                              echo "<tr><td colspan='13'>No records found</td></tr>"; 
                            }
                          ?>

                          <tr>
                            <td colspan="13" style="text-align:center">
                              <?php  func_getPaging('manage_job.php?x&search_vehicle='.$search_vehicle); ?>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>

                  <?php
                  }

                  if(isset($btn_overdue))
                  {
                  ?>
                  
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Overdue Job</h2>
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

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>job ID</th>
                            <th>Job Title</th>
                            <th>job desc</th>
                            <th>reg No</th>
                            <th>Assigned to</th>
                            <th>Assigned by</th>
                            <th>due date</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                          <?php
                            func_setPage(); 
                            func_setOffset(); 
                            func_setLimit(10); 

                            $sql = "SELECT id,nickname FROM user";
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();
                            }

                            $sql = "SELECT 
                                job.id,
                                job_title,
                                assigned_to,
                                assigned_by,
                                created,
                                modified, 
                                due_date,
                                completed_date,
                                job_desc,
                                vehicle_id,
                                job.branch,
                                vehicle.reg_no,
                                location.description,
                                job.status
                                FROM job
                                LEFT JOIN user ON assigned_to = user.id
                                LEFT JOIN vehicle ON vehicle_id = vehicle.id
                                LEFT JOIN location ON job.branch = location.id
                                WHERE job.id IS NOT NULL AND job.due_date <= CONVERT_TZ(now(),'+00:00','+8:00') AND (job.status = 'Pending' OR job.status = 'Assigned')"; 

                            db_select($sql); 

                            func_setTotalPage(db_rowcount()); 

                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                            if(db_rowcount()>0){

                              for($i=0;$i<db_rowcount();$i++){

                                if(func_getOffset()>=10){ 

                                  $no=func_getOffset()+1+$i; 
                                }
                                else{ 

                                  $no=$i+1; 
                                }

                                echo "<tr>
                                      <th scope='row'>" . $no . "</th>
                                      <td>".db_get($i,0)."</td>
                                      <td>".db_get($i,1)."</td>
                                      <td>".db_get($i,8)."</td>
                                      <td>".db_get($i,11)."</td>";

                                $sql1 = "SELECT nickname FROM user where id = '".db_get($i,2)."'";
                                $sql2 = "SELECT nickname FROM user where id = '".db_get($i,3)."'";

                                $result1 = mysqli_query($con,$sql1);
                                $result2 = mysqli_query($con,$sql2);

                                while ($row = mysqli_fetch_assoc($result1)){

                                  echo "<td>".$row['nickname']."</td>";
                                }
                                while ($row = mysqli_fetch_assoc($result2))
                                {

                                  echo "<td>".$row['nickname']."</td>";
                                }

                                echo "<td>".db_get($i,6)."</td>
                                      <td>".db_get($i,12)."</td>
                                      <td>".db_get($i,13)."</td>";

                                if(db_get($i,13) == 'Assigned'){

                                  echo "<td><center>
                                          <a href='manage_job_edit.php?id=".db_get($i,0)."&search_vehicle=".$search_vehicle."'><i class='fa fa-pencil'></i></a>
                                          &nbsp;&nbsp;
                                          <a href='delete_job.php?id=".db_get($i,0)."' onClick='return confirm(\"Delete this?\")'><i class='fa fa-trash'></i></a></center>
                                        </td>";
                                }
                                else{

                                  echo "<td><i>Unavailable</i></td>";
                                }
                                    
                                echo "</tr>";
                              }
                            }
                            else{ 

                              echo "<tr><td colspan='13'>No records found</td></tr>"; 
                            }
                          ?>

                          <tr>
                            <td colspan="13" style="text-align:center">
                              <?php  func_getPaging('manage_job.php?x&search_vehicle='.$search_vehicle); ?>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>

                  <?php
                  }

                  if(isset($btn_completed))
                  {
                  ?>
                  
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Completed Job</h2>
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

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>job ID</th>
                            <th>Job Title</th>
                            <th>job desc</th>
                            <th>reg No</th>
                            <th>Assigned to</th>
                            <th>Assigned by</th>
                            <th>due date</th>
                            <th>Branch</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                          <?php
                            func_setPage(); 
                            func_setOffset(); 
                            func_setLimit(10); 

                            if(isset($btn_search)){ 

                              if($search_name!=""){ 

                                $where=" AND user like '%".$search_name."%'"; 
                              }
                            }
                            $sql = "SELECT id,nickname FROM user";
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();
                            }

                            $sql = "SELECT 
                                job.id,
                                job_title,
                                assigned_to,
                                assigned_by,
                                created,
                                modified, 
                                due_date,
                                completed_date,
                                job_desc,
                                vehicle_id,
                                job.branch,
                                vehicle.reg_no,
                                location.description,
                                job.status
                                FROM job
                                LEFT JOIN user ON assigned_to = user.id
                                LEFT JOIN vehicle ON vehicle_id = vehicle.id
                                LEFT JOIN location ON job.branch = location.id
                                WHERE job.id IS NOT NULL AND job.status = 'Done'" .$where; 

                            db_select($sql); 

                            func_setTotalPage(db_rowcount()); 

                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                            if(db_rowcount()>0){

                              for($i=0;$i<db_rowcount();$i++){

                                if(func_getOffset()>=10){ 

                                  $no=func_getOffset()+1+$i; 
                                }
                                else{ 

                                  $no=$i+1; 
                                }

                                echo "<tr>
                                      <th scope='row'>" . $no . "</th>
                                      <td>".db_get($i,0)."</td>
                                      <td>".db_get($i,1)."</td>
                                      <td>".db_get($i,8)."</td>
                                      <td>".db_get($i,11)."</td>";

                                $sql1 = "SELECT nickname FROM user where id = '".db_get($i,2)."'";
                                $sql2 = "SELECT nickname FROM user where id = '".db_get($i,3)."'";

                                $result1 = mysqli_query($con,$sql1);
                                $result2 = mysqli_query($con,$sql2);

                                while ($row = mysqli_fetch_assoc($result1)){

                                  echo "<td>".$row['nickname']."</td>";
                                }
                                while ($row = mysqli_fetch_assoc($result2))
                                {

                                  echo "<td>".$row['nickname']."</td>";
                                }

                                echo "<td>".db_get($i,6)."</td>
                                      <td>".db_get($i,12)."</td>";
                                    
                                echo "</tr>";
                              }
                            }
                            else{ 

                              echo "<tr><td colspan='13'>No records found</td></tr>"; 
                            }
                          ?>

                          <tr>
                            <td colspan="13" style="text-align:center">
                              <?php  func_getPaging('manage_job.php?x&search_vehicle='.$search_vehicle); ?>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>

                  <?php
                  }

                  if(isset($btn_deleted))
                  {
                  ?>
                  
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Deleted Job</h2>
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

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>job ID</th>
                            <th>Job Title</th>
                            <th>job desc</th>
                            <th>reg No</th>
                            <th>Assigned to</th>
                            <th>Assigned by</th>
                            <th>due date</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                          <?php
                            func_setPage(); 
                            func_setOffset(); 
                            func_setLimit(10); 

                            if(isset($btn_search)){ 

                              if($search_name!=""){ 

                                $where=" AND user like '%".$search_name."%'"; 
                              }
                            }
                            $sql = "SELECT id,nickname FROM user";
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();
                            }

                            $sql = "SELECT 
                                job.id,
                                job_title,
                                assigned_to,
                                assigned_by,
                                created,
                                modified, 
                                due_date,
                                completed_date,
                                job_desc,
                                vehicle_id,
                                job.branch,
                                vehicle.reg_no,
                                location.description,
                                job.status
                                FROM job
                                LEFT JOIN user ON assigned_to = user.id
                                LEFT JOIN vehicle ON vehicle_id = vehicle.id
                                LEFT JOIN location ON job.branch = location.id
                                WHERE job.id IS NOT NULL AND job.status = 'Deleted'" .$where; 

                            db_select($sql); 

                            func_setTotalPage(db_rowcount()); 

                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                            if(db_rowcount()>0){

                              for($i=0;$i<db_rowcount();$i++){

                                if(func_getOffset()>=10){ 

                                  $no=func_getOffset()+1+$i; 
                                }
                                else{ 

                                  $no=$i+1; 
                                }

                                echo "<tr>
                                      <th scope='row'>" . $no . "</th>
                                      <td>".db_get($i,0)."</td>
                                      <td>".db_get($i,1)."</td>
                                      <td>".db_get($i,8)."</td>
                                      <td>".db_get($i,11)."</td>";

                                $sql1 = "SELECT nickname FROM user where id = '".db_get($i,2)."'";
                                $sql2 = "SELECT nickname FROM user where id = '".db_get($i,3)."'";

                                $result1 = mysqli_query($con,$sql1);
                                $result2 = mysqli_query($con,$sql2);

                                while ($row = mysqli_fetch_assoc($result1)){

                                  echo "<td>".$row['nickname']."</td>";
                                }
                                while ($row = mysqli_fetch_assoc($result2))
                                {

                                  echo "<td>".$row['nickname']."</td>";
                                }

                                echo "<td>".db_get($i,6)."</td>
                                      <td>".db_get($i,12)."</td>
                                      <td>".db_get($i,13)."</td>";

                                if(db_get($i,13) == 'Assigned'){

                                  echo "<td><center>
                                          <a href='manage_job_edit.php?id=".db_get($i,0)."&search_vehicle=".$search_vehicle."'><i class='fa fa-pencil'></i></a>
                                          &nbsp;&nbsp;
                                          <a href='delete_job.php?id=".db_get($i,0)."' onClick='return confirm(\"Delete this?\")'><i class='fa fa-trash'></i></a></center>
                                        </td>";
                                }
                                else{

                                  echo "<td><i>Unavailable</i></td>";
                                }
                                    
                                echo "</tr>";
                              }
                            }
                            else{ 

                              echo "<tr><td colspan='13'>No records found</td></tr>"; 
                            }
                          ?>

                          <tr>
                            <td colspan="13" style="text-align:center">
                              <?php  func_getPaging('manage_job.php?x&search_vehicle='.$search_vehicle); ?>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>

                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          
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