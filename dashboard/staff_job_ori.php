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

  <?php include('_header.php'); ?>

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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="search_classes">Vehicle Plate No.
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="search_name" value="<?php echo $search_name;?>">
                          </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>
                          </div>
                        </div>
                        </div>



                      </form>
                    </div>
                  </div>
                  
                  <div class="x_panel">

                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th style="width: 250px;">Job Title</th>
                            <th>Assigned by</th>
                            <th>Date Due</th>
                            <th style="width: 400px;">Description</th>
                            <th style="width: 120px;">Vehicle Plate No.</th>
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

                $where=" AND vehicle.reg_no like '%".$search_name."%'"; 
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
                              WHERE user.id = ".$_SESSION['cid']." AND job.status != 'Deleted'".$where.
                              " ORDER BY created"
                              ; 

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
                                    <td>".db_get($i,1)."</td>";

                                  $link = mysql_connect('localhost', 'root', '');
                                  $db_selected = mysql_select_db('myezgo', $link);
                                  $sql2 = "SELECT nickname FROM user where id = '".db_get($i,3)."'";

                                  $result2 = mysql_query($sql2);
                                  while ($row = mysql_fetch_assoc($result2))
                                  {

                                    echo "<td>".$row['nickname']."</td>";
                                  }

                                  echo "<td>".date('d/m/y',strtotime(db_get($i,6)))."</td>
                                    <td>".db_get($i,8)."</td>
                                    <td>".db_get($i,11)."</td>
                                    <td>".db_get($i,13)."</td>";

                                  if(db_get($i,13) == "Assigned" || db_get($i,13) == "Pending")
                                  {
                                    echo "<td><center><a href='staff_job_view.php?id=".db_get($i,0)."&search_vehicle=".$search_vehicle."'><i class='fa fa-eye'></i></a></center></td>";
                                  }
                                  else
                                  {
                                    
                                    echo "<td><center><i>Unavailable</i></center></td>";
                                  }
                                  
                                  echo "<td style='display:none'>               
                                        <div id='".db_get($i,7)."' style='display:none;width:800px' class='card__body'>
                                            <img src='img/".db_get($i,8)."'>
                                        </div>
                                    </td>
                                    </tr>";
           


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