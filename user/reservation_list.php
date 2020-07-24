<?php
session_start();
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
   include("_header.php"); 
   func_setReqVar(); 

   if (isset($btn_clear)) 
    { 

      vali_redirect('reservation_list.php'); 
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
                  <h3>Reservation List</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Reservation List</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Search
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           
                            <input type="text" class="form-control" name="search_nricno" value="<?php echo $search_nricno; ?>">

                          </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>

                            <button name="btn_clear" class="btn btn-warning">Clear</button>
                          </div>
                        </div>
                        </div>

                      </form>
                    </div>
                  </div>

                  <div class="x_panel">

                    <div class="table-responsive">
                                        <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Agreement No.</th>
                                                    <th>Vehicle Plate No.</th>
                                                    <th>Status</th>
                                                    <th>Branch</th>
                                                    <th>From Date & Time</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                            func_setPage(); 

                            func_setOffset(); 

                            func_setLimit(10); 

                    if (isset($btn_search)) { 

                        if ($search_nricno != "") { 

                            $agreement_search = " AND agreement_no like '%" . $search_nricno . "%'"; 
                            $reg_no_search = " OR reg_no like '%" . $search_nricno . "%'"; 

                        } 

                    }
                    else{

                      echo "<script> alert('NOTE: if there is no activity in this section for 20 minutes, a refresh will be made to avoid technical issues, TQ.'); </script>";
                    } 

                                                if($_SESSION['occupation'] != 'Operation Staff')
                                                {
                                                  $sql = "SELECT
                                                    booking_trans.id,
                                                    class_id,
                                                    firstname,
                                                    lastname,
                                                    nric_no,
                                                    reg_no,
                                                    DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
                                                    DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
                                                    DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
                                                    DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
                                                    DATE_FORMAT(created, '%d/%m/%Y') as created,
                                                    vehicle.id AS vehicle_id,
                                                    agreement_no,
                                                    booking_trans.branch AS branch,
                                                    booking_trans.available
                                                    FROM vehicle
                                                    LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                                                    LEFT JOIN class ON class.id = class_id
                                                    LEFT JOIN customer ON customer.id = customer_id
                                                    WHERE booking_trans.id IS NOT NULL". $agreement_search . $reg_no_search ."
                                                    ORDER BY YEAR(created) DESC, MONTH(created) DESC, DAY(created) DESC, HOUR(created) DESC, MINUTE(created) DESC, SECOND(created) DESC
                                                  ";
                                                }
                                                else if($_SESSION['occupation'] == 'Operation Staff')
                                                {

                                                  $sql = "SELECT
                                                    booking_trans.id,
                                                    class_id,
                                                    firstname,
                                                    lastname,
                                                    nric_no,
                                                    reg_no,
                                                    DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
                                                    DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
                                                    DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
                                                    DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
                                                    DATE_FORMAT(created, '%d/%m/%Y') as created,
                                                    vehicle.id AS vehicle_id,
                                                    agreement_no,
                                                    booking_trans.branch AS branch,
                                                    booking_trans.available
                                                    FROM vehicle
                                                    LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                                                    LEFT JOIN class ON class.id = class_id
                                                    LEFT JOIN customer ON customer.id = customer_id
                                                    WHERE booking_trans.id IS NOT NULL AND booking_trans.branch='".$_SESSION['user_branch']."' ". $agreement_search . $reg_no_search ."
                                                    ORDER BY YEAR(created) DESC, MONTH(created) DESC, DAY(created) DESC, HOUR(created) DESC, MINUTE(created) DESC, SECOND(created) DESC
                                                  "; 
                                                }

                                                db_select($sql); 

                                                func_setTotalPage(db_rowcount()); 

                                                db_select($sql . " LIMIT " . func_getLimit() . " OFFSET " . func_getOffset()); 

                                                if (db_rowcount() > 0) { 

                                                    for ($i = 0; $i < db_rowcount(); $i++) { 

                                                        if (func_getOffset() >= 10) { 

                                                            $no = func_getOffset() + 1 + $i; 

                                                        } else { 

                                                            $no = $i + 1; 
                                                        }
                                                        echo "<tr>
                                                            <td>" . $no . "</td>
                                                            <td>" . db_get($i, 12). "</td>
                                                            <td>" . db_get($i, 5) . "</td>
                                                            <td>" . db_get($i, 14) . "</td>
                                                            <td>" . db_get($i, 13) . "</td>
                                                            <td>" . db_get($i, 6) . " " . db_get($i, 7) . " | <br> " . db_get($i, 8) . " " . db_get($i, 9) . "</td>
                                                            <td>
                                                                <a href='reservation_list_view.php?booking_id=" . db_get($i, 0) . "&class_id=" . db_get($i, 1) . "'>
                                                                <i class='fa fa-search'></i>
                                                            </td>
                                                        </tr>";
                                                    }
                                                }

                                                else {

                                                    echo "<tr><td colspan='8'>No records found</td></tr>";
                                                }   ?>
                                                <tr>
                                                    <td colspan="8" style="text-align:center">
                                                        <?php 
                                                            func_getPaging('reservation_list.php?btn_search=&search_nricno='.$search_nricno);
                                                            // func_getPaging('report_weekly.php?x&btn_search=&search_month='.$search_month.'&search_year='.$search_year.'&search_week='.$search_week);
                                                        ?>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
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
  </html>
<?php  
}
else if(isset($_SESSION['cid']))
{
    echo "<script>
          window.alert('You're not suppose to be here. Redirecting to staff);
            window.location.href='../dashboard/dashboard.php';
          </script>";
}
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>