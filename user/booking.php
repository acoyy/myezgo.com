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
                  <h3>Car Status</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Car Status</h2>
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
                            <th>Car No</th>
                            <th>Car Details</th>
                            <th>Status Car</th>
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

                          $sql = "SELECT vehicle.id, 
                          vehicle.class_id, 
                          vehicle.reg_no, 
                          vehicle.make, 
                          vehicle.model, 
                          vehicle.color, 
                          vehicle.year, 
                          DATE_FORMAT(booking_trans.pickup_date, '%d/%m/%Y')  as pickup_date, 
                          DATE_FORMAT(booking_trans.pickup_time, '%H:%i') as pickup_time,
                          DATE_FORMAT(booking_trans.return_date, '%d/%m/%Y') as return_date,
                          DATE_FORMAT(booking_trans.return_time, '%H:%i') as return_time 
                          FROM vehicle LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                          GROUP BY vehicle.id";

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
                          echo 
                          "<tr style='background-color:#2A3F54;'>
                          <th scope='row'><div style='color:white;'>" . $no . "</div></th>
                          <td><div style='color:white;'>" . db_get($i, 0) . "</div></td>
                          <td><div style='color:white;'>" . db_get($i, 2) . "<br>(" . db_get($i, 4) . " " . ")</div></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          </tr>";

                          //start nested loop

                              $sqlb = "SELECT
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
                              booking_trans.available,
                              concat(firstname,' ' ,lastname) as name,
                              sub_total,
                              payment_details,
                              refund_dep
                              FROM vehicle
                              LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                              LEFT JOIN class ON class.id = class_id
                              LEFT JOIN customer ON customer_id = customer.id
                              WHERE  reg_no='".db_get($i, 2)."' ORDER BY return_date asc"; 

                              $result=mysql_query($sqlb);

                              while ($row = mysql_fetch_array($result))  
                              {

                              if($result!=0){

                              if($row[5]==null || $row[5]==''){

                                  $day='';
                                         
                              }

                              else{
                                   
                              $day= dateDifference(conv_datetodbdate($row[5]) . $row[6], conv_datetodbdate($row[7]) . $row[8], '%d Day %h Hours'); 
                                   
                              }

                              echo "<tr>
                                          <td>" . $no . "</td>
                                          <td>" . db_get($i, 0) . "</td>
                                          <td>" . db_get($i, 2) . "<br> (" . db_get($i, 4) . " " . ")</td>
                                          <td>" . $row[10] . "</td>
                                          <td>" . $row[5] ." ". $row[6] ." | ". $row[7] ." ". $row[8] ."</td>
                                          <td>" . $row[11] . "</td>
                              <td>RM " . $row[12] ." | ". $row[13] ."</td>
                                          <td>RM " . $row[14] . "</td>
                                          <td>" .
                                           $day

                                           . "</td>
                                          </tr>";


                              }
                              else{
                                          
                              echo "<tr>
                              <td>No result</td>
                              </tr>";
                                    }    

                              }



                          }

                          }else {

                      echo "<tr><td colspan='9'>No records found</td></tr>";

                  }  ?>

                  <tr>
                              <td colspan="9" style="text-align:center">
                              <?php  func_getPaging('booking.php?x&availability='.$availability); ?>
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