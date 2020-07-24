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
                  <h3>Upcoming Schedule</h3>
                </div>

                
              </div>

              <div class="clearfix"></div>
              <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Upcoming Schedule</h2>
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
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Car No.</th>
                           <th>Car Details</th>
                           <th>Date</th>
                           <th>Name</th>
                           <th>Rental & Status</th>
                           <th>Deposit</th>
                           <th>Days</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                          func_setPage(); 
                          func_setOffset(); 
                          func_setLimit(10); 

                          $sql = "SELECT
                              vehicle.id,
                              reg_no,
                              model,
                              make,
                              vehicle.availability,
                              DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_dates,
                              DATE_FORMAT(pickup_time, '%H:%i') as pickup_times,
                              DATE_FORMAT(return_date, '%d/%m/%Y') as return_dates,
                              DATE_FORMAT(return_time, '%H:%i') as return_times,
                              booking_trans.id,
                              concat(firstname,' ' ,lastname) as name,
                              sub_total,
                              payment_details,
                              refund_dep
                              FROM vehicle
                              LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                              LEFT JOIN class ON class.id = class_id
                              LEFT JOIN customer ON customer_id = customer.id
                              WHERE booking_trans.id IS NOT NULL" . $where. "
                               AND return_date >= CURDATE() 
                              ORDER BY return_date desc "; 

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
                          <th scope='row'>" . $no . "</th>
                          <td>" . db_get($i, 0) . "</td>
                          <td>" . db_get($i, 1) . " (" . db_get($i, 2) . " " . db_get($i, 3) . ")</td>
                          <td>" . db_get($i, 5) . " " . db_get($i, 6) . " | " . db_get($i, 7) . " " . db_get($i, 8) . "</td>
                          <td>" . db_get($i, 10) . "</td>
                          <td>RM " . db_get($i, 11) . " | " . db_get($i, 12) . "</td>
                          <td>RM " . db_get($i, 13) . "</td>
                          <td>" . dateDifference(conv_datetodbdate(db_get($i, 5)) . db_get($i, 6), conv_datetodbdate(db_get($i, 7)) . db_get($i, 8), '%d Day %h Hours') . "</td>
                          </tr>";


                          
                          //start nested loop

                             


                          }

                          }else {

                      echo "<tr><td colspan='9'>No records found</td></tr>";

                  }  ?>

                  <tr>
                              <td colspan="9" style="text-align:center">
                              <?php  func_getPaging('upcoming_schedule.php?x&availability='.$availability); ?>
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