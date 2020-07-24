<?php
session_start();
if(isset($_SESSION['cid']) || isset($_SESSION['user_id']))
{ 
  $idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out
  
  if (time()-$_SESSION['timestamp']>$idletime){
    session_unset();
    session_destroy();
    echo "<script> alert('You have been logged out due to inactivity'); </script>";
                echo "<script>
                        window.location.href='../login.php';
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
                <h3>Welcome!</h3>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2><i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 24px; color: turquoise;"></i> My Booking </h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <td><b>#</b></td>
                                  <td><b>Agreement No.</b></td>
                                  <td><b>Vehicle Plate No.</b></td>
                                  <td><b>Branch</b></td>
                                  <td><b>Pickup Date & Time</b></td>
                                  <td><b>Return Date & Time</b></td>
                                  <td><b>Status</b></td>
                                  <td><b><center>Action</center></b></td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                func_setPage(); 

                                func_setOffset(); 

                                func_setLimit(10);
                                  
                                  $sql = "SELECT 
                                    booking_trans.agreement_no AS agreement_no,
                                    reg_no,
                                    booking_trans.branch AS branch,
                                    booking_trans.pickup_date AS pickup_date,
                                    booking_trans.return_date AS return_date,
                                    booking_trans.id AS booking_id,
                                    available
                                    FROM vehicle
                                    RIGHT JOIN booking_trans ON vehicle.id = vehicle_id
                                    RIGHT JOIN customer ON customer.id = customer_id
                                    WHERE customer_id = ".$_SESSION['user_id'];
                                    
                                    /********* above date is for malaysian time zone********/

                                  db_select($sql);

                                  func_setTotalPage(db_rowcount()); 

                                  db_select($sql . " LIMIT " . func_getLimit() . " OFFSET " . func_getOffset());

                                  if (db_rowcount() > 0) {

                                    for ($i = 0; $i < db_rowcount(); $i++) {

                                      //   if (func_getOffset() >= 10) {

                                      //     $no = func_getOffset() + 1 + $i;

                                      //   } else {

                                      //     $no = $i + 1;

                                      //   }
                                    
                                      $no = $i+1;

                                      $pickup_date = date('jS M Y, g.iA', strtotime(db_get($i,3)));
                                      $return_date = date('jS M Y, g.iA', strtotime(db_get($i,4)));

                                      if(db_get($i,6) == "Out") {

                                        $status = "<font color='blue'>On going</font>";
                                      }
                                      else if(db_get($i,6) == "Extend") {

                                        $status = "<font color='blue'>On going (Extend)</font>";
                                      }
                                      else if(db_get($i,6) == "Park") {

                                        $status = "<font color='green'><i>Done</i></font>";
                                      }
                                      else if(db_get($i,6) == "Booked") {

                                        $status = "<font color='orange'><i>Booked</i></font>";
                                      }
                                      // echo $date;
                                      // $db_date date_format($date, 'd-m-Y H:i:s');
                                      echo
                                        "<tr>
                                          <td>".$no."</td>
                                          <td>".db_get($i,0)."</td>
                                          <td>".db_get($i,1)."</td>
                                          <td>".db_get($i,2)."</td>
                                          <td>".$pickup_date."</td>
                                          <td>".$return_date."</td>
                                          <td>".$status."</td>";
                                        
                                      echo
                                          "<td>
                                            <center>
                                              <a href='booking_details.php?booking_id=" . db_get($i,5) . "'>
                                                <i class='fa fa-search'></i>
                                            </center>
                                          </td>
                                        </tr>
                                      ";
                                    }
                                  }   
                                  else{ 

                                    echo "<tr><td colspan='7'>No records found</td></tr>"; 
                                  }

                                  ?>
                                    <tr>
                                        <td colspan="8" style="text-align:center">
                                            <?php 
                                                func_getPaging('reservation_list.php?btn_search=&search_nricno='.$search_nricno);
                                                // func_getPaging('report_weekly.php?x&btn_search=&search_month='.$search_month.'&search_year='.$search_year.'&search_week='.$search_week);
                                            ?>
                                        </td>
                                    </tr>
                                  <?php
                                  
                                  $sqlcuba = "SELECT CONVERT_TZ(now(),'+00:00','+8:00') as 'now'";
                                  $result = mysqli_query($con, $sqlcuba);
                                  
                                  $row = mysqli_fetch_assoc($result);
                                  
                                  // echo "Date: ".date('d/m/Y', strtotime($row['now']));
                                  // echo "<br>Time (24-hour): ".date('H:i:s', strtotime($row['now']));
                                  // echo "<br>Time (12-hour): ".date('h:i:s a', strtotime($row['now']));
                                  // echo "<br>DateTime: ".$row['now'];

                                ?>
                              </tbody>
                            </table>
                          </div>

                      </div>

                    </div>
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
</html>
<style>
  @-webkit-keyframes ring {
    0% {
      -webkit-transform: rotate(-15deg);
      transform: rotate(-15deg);
    }

    2% {
      -webkit-transform: rotate(15deg);
      transform: rotate(15deg);
    }

    4% {
      -webkit-transform: rotate(-18deg);
      transform: rotate(-18deg);
    }

    6% {
      -webkit-transform: rotate(18deg);
      transform: rotate(18deg);
    }

    8% {
      -webkit-transform: rotate(-22deg);
      transform: rotate(-22deg);
    }

    10% {
      -webkit-transform: rotate(22deg);
      transform: rotate(22deg);
    }

    12% {
      -webkit-transform: rotate(-18deg);
      transform: rotate(-18deg);
    }

    14% {
      -webkit-transform: rotate(18deg);
      transform: rotate(18deg);
    }

    16% {
      -webkit-transform: rotate(-12deg);
      transform: rotate(-12deg);
    }

    18% {
      -webkit-transform: rotate(12deg);
      transform: rotate(12deg);
    }

    20% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
  }

  @keyframes ring {
    0% {
      -webkit-transform: rotate(-15deg);
      -ms-transform: rotate(-15deg);
      transform: rotate(-15deg);
    }

    2% {
      -webkit-transform: rotate(15deg);
      -ms-transform: rotate(15deg);
      transform: rotate(15deg);
    }

    4% {
      -webkit-transform: rotate(-18deg);
      -ms-transform: rotate(-18deg);
      transform: rotate(-18deg);
    }

    6% {
      -webkit-transform: rotate(18deg);
      -ms-transform: rotate(18deg);
      transform: rotate(18deg);
    }

    8% {
      -webkit-transform: rotate(-22deg);
      -ms-transform: rotate(-22deg);
      transform: rotate(-22deg);
    }

    10% {
      -webkit-transform: rotate(22deg);
      -ms-transform: rotate(22deg);
      transform: rotate(22deg);
    }

    12% {
      -webkit-transform: rotate(-18deg);
      -ms-transform: rotate(-18deg);
      transform: rotate(-18deg);
    }

    14% {
      -webkit-transform: rotate(18deg);
      -ms-transform: rotate(18deg);
      transform: rotate(18deg);
    }

    16% {
      -webkit-transform: rotate(-12deg);
      -ms-transform: rotate(-12deg);
      transform: rotate(-12deg);
    }

    18% {
      -webkit-transform: rotate(12deg);
      -ms-transform: rotate(12deg);
      transform: rotate(12deg);
    }

    20% {
      -webkit-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      transform: rotate(0deg);
    }
  }

  @-webkit-keyframes horizontal {
    0% {
      -webkit-transform: translate(0,0);
      transform: translate(0,0);
    }

    6% {
      -webkit-transform: translate(-5px,0);
      transform: translate(-5px,0);
    }

    12% {
      -webkit-transform: translate(0,0);
      transform: translate(0,0);
    }

    18% {
      -webkit-transform: translate(-5px,0);
      transform: translate(-5px,0);
    }

    24% {
      -webkit-transform: translate(0,0);
      transform: translate(0,0);
    }

    30% {
      -webkit-transform: translate(-5px,0);
      transform: translate(-5px,0);
    }

    36% {
      -webkit-transform: translate(0,0);
      transform: translate(0,0);
    }
  }

  @keyframes horizontal {
    0% {
      -webkit-transform: translate(0,0);
      -ms-transform: translate(0,0);
      transform: translate(0,0);
    }

    6% {
      -webkit-transform: translate(-5px,0);
      -ms-transform: translate(-5px,0);
      transform: translate(-5px,0);
    }

    12% {
      -webkit-transform: translate(0,0);
      -ms-transform: translate(0,0);
      transform: translate(0,0);
    }

    18% {
      -webkit-transform: translate(-5px,0);
      -ms-transform: translate(-5px,0);
      transform: translate(-5px,0);
    }

    24% {
      -webkit-transform: translate(0,0);
      -ms-transform: translate(0,0);
      transform: translate(0,0);
    }

    30% {
      -webkit-transform: translate(-5px,0);
      -ms-transform: translate(-5px,0);
      transform: translate(-5px,0);
    }

    36% {
      -webkit-transform: translate(0,0);
      -ms-transform: translate(0,0);
      transform: translate(0,0);
    }
  }

  .faa-ring.animated,
  .faa-ring.animated-hover:hover,
  .faa-parent.animated-hover:hover > .faa-ring {
    -webkit-animation: ring 4s ease infinite;
    animation: ring 4s ease infinite;
    transform-origin-x: 50%;
    transform-origin-y: 0px;
    transform-origin-z: initial;

  }

  .faa-horizontal.animated,
  .faa-horizontal.animated-hover:hover,
  .faa-parent.animated-hover:hover > .faa-horizontal {
    -webkit-animation: horizontal 2s ease infinite;
    animation: horizontal 2s ease infinite;
  }

</style>
<?php
} 
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>