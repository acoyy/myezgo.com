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
                  <h3>Delete Approval</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
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
                        <div class="table-responsive">
                                        <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Agreement No.</th>
                                                    <th>Vehicle Plate No.</th>
                                                    <th>Status</th>
                                                    <th>Staff</th>
                                                    <th>From Date & Time</th>
                                                    <th>Reason</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                            func_setPage(); 

                            func_setOffset(); 

                            func_setLimit(10); 

                    //   echo "<script> alert('NOTE: if there is no activity in this section for 20 minutes, a refresh will be made to avoid technical issues, TQ.'); </script>";

                                                  $sql = "SELECT
                                                    booking_trans.id AS booking_id,
                                                    class_id,
                                                    reg_no,
                                                    DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
                                                    DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
                                                    DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
                                                    DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
                                                    vehicle.id AS vehicle_id,
                                                    agreement_no,
                                                    booking_trans.staff_id AS staff_id,
                                                    booking_trans.available AS available,
                                                    booking_trans.delete_status,
                                                    booking_trans.reason AS reason,
                                                    user.nickname AS nickname
                                                    FROM booking_trans
                                                    LEFT JOIN vehicle ON vehicle.id = vehicle_id
                                                    LEFT JOIN user ON user.id = staff_id
                                                    WHERE booking_trans.delete_status = 'pending'
                                                    ORDER BY YEAR(created) DESC, MONTH(created) DESC, DAY(created) DESC, HOUR(created) DESC, MINUTE(created) DESC, SECOND(created) DESC
                                                  ";
                                                // $sql ="select * from booking_trans where delete_status = 'pending'";

                                                db_select($sql); 

                                                func_setTotalPage(db_rowcount()); 

                                                db_select($sql . " LIMIT " . func_getLimit() . " OFFSET " . func_getOffset()); 

                                                if (db_rowcount() > 0) { 

                                                    func_setSelectVar();

                                                    for ($i = 0; $i < db_rowcount(); $i++) { 

                                                        if (func_getOffset() >= 10) { 

                                                            $no = func_getOffset() + 1 + $i; 

                                                        } else { 

                                                            $no = $i + 1; 
                                                        }

                                                        echo "<tr>
                                                                <td>" . $no . "</td>
                                                                <td>" . db_get($i, 8). "</td>
                                                                <td>" . db_get($i, 2) . "</td>
                                                                <td>" . db_get($i, 10) . "</td>
                                                                <td>" . db_get($i, 13) . "</td>
                                                                <td>" . db_get($i, 3) . " " . db_get($i, 4) . " | <br> " . db_get($i, 5) . " " . db_get($i, 6) . "</td>
                                                                <td>" . db_get($i, 12) . "</td>
                                                                <td>
                                                                    <a href='delete_list_view.php?booking_id=" . db_get($i, 0) . "&class_id=" . db_get($i, 1) . "'>
                                                                      <i class='fa fa-search'></i>
                                                                    </a>
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
                                                            func_getPaging('delete_list.php?btn_search=&search_nricno='.$search_nricno);
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

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>