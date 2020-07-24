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

            <div class="row">
              <div class="col-md-8">
                  <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 24px; color: #f95e5e"></i> Booked By Customer <i class="fa fa-hand-o-left faa-horizontal animated fa-4x" style="font-size: 24px; color: #f95e5e"></i></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <td>#</td>
                                <td>Agreement No.</td>
                                <td>Vehicle Plate No.</td>
                                <td>Branch</td>
                                <td>Pickup Date</td>
                                <td>Time</td>
                                <td>Return Date</td>
                                <td>Time</td>
                                <td>View</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                
                                $sql = "SELECT
                                  agreement_no,
                                  vehicle.reg_no,
                                  booking_trans.branch,
                                  pickup_date,
                                  return_date,
                                  booking_trans.id AS booking_id
                                  FROM booking_trans
                                  LEFT JOIN vehicle ON vehicle.id = booking_trans.vehicle_id
                                  WHERE available = 'Booked' AND payment_id is NOT NULL
                                  GROUP BY booking_trans.id";
                                  
                                  /********* above date is for malaysian time zone********/

                                // $sqlb = "SELECT * FROM booking_trans WHERE (return_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."' AND return_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."') OR (pickup_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."' AND pickup_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."') group by vehicle_id";
                                db_select($sql);

                                if (db_rowcount() > 0) {

                                  for ($i = 0; $i < db_rowcount(); $i++) {

                                    // if (func_getOffset() >= 10) {

                                    //   $no = func_getOffset() + 1 + $i;

                                    // } else {

                                    //   $no = $i + 1;

                                    // }
                                    
                                    $no = $i+1;

                                    $pickup_date = date('d/m/y', strtotime(db_get($i,3)));
                                    $return_date = date('d/m/y', strtotime(db_get($i,4)));
                                    $pickup_time = date('H:i', strtotime(db_get($i,3)));
                                    $return_time = date('H:i', strtotime(db_get($i,4)));
                                    // echo $date;
                                    // $db_date date_format($date, 'd-m-Y H:i:s');
                                    echo
                                      "<tr>
                                        <td>".$no."</td>
                                        <td>".db_get($i,0)."</td>
                                        <td>".db_get($i,1)."</td>
                                        <td>".db_get($i,2)."</td>
                                        <td>".$pickup_date."</td>
                                        <td>".$pickup_time."</td>
                                        <td>".$return_date."</td>
                                        <td>".$return_time."</td>";
                                    
                                    echo
                                        "<td>
                                          <a href='reservation_list_view.php?booking_id=" . db_get($i, 5) . "'>
                                            <i class='fa fa-search'></i>
                                          </td>
                                      </tr>
                                      ";
                                  }
                                }   
                                else{ 

                                  echo "<tr><td colspan='9'>No records found</td></tr>"; 
                                }

                              ?>
                            </tbody>
                          </table>
                        </div>

                    </div>

                  </div>
                </div>
                </div>
                <div class="col-md-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2><i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 24px; color: #f95e5e"></i> Overdue Job <i class="fa fa-hand-o-left faa-horizontal animated fa-4x" style="font-size: 24px; color: #f95e5e"></i></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <td>#</td>
                                  <td>Job Title</td>
                                  <td>job desc</td>
                                  <td>reg No</td>
                                  <?php
                                    if($occupation == 'Operation Staff')
                                    {
                                      $where = ' AND assigned_to = '.$_SESSION['cid'].'';
                                      echo "<td>Assigned by</td>";
                                    }
                                    else{
                                      echo "<td>Assigned to</td>";
                                    }
                                  ?>
                                  <td>due date</td>
                                  <td>Status</td>
                                  <?php
                                    if($occupation == 'Operation Staff')
                                    {
                                      echo "<td>Action</td>";
                                    }
                                  ?>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  
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
                                      WHERE job.id IS NOT NULL AND job.due_date <= '".date('Y-m-d H:i:s', time())."' AND job.status != 'Deleted' AND job.status != 'Done'".$where; 
                                    
                                    /********* above date is for malaysian time zone********/

                                  // $sqlb = "SELECT * FROM booking_trans WHERE (return_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."' AND return_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."') OR (pickup_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."' AND pickup_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."') group by vehicle_id";
                                  db_select($sql);

                                  if (db_rowcount() > 0) {

                                    for($i=0;$i<db_rowcount();$i++){

                                    //   if(func_getOffset()>=10){ 

                                    //     $no=func_getOffset()+1+$i; 
                                    //   }
                                    //   else{ 

                                    //     $no=$i+1; 
                                    //   }
                                      $no = $i+1;

                                      echo "<tr>
                                            <td scope='row'>" . $no . "</td>
                                            <td>".db_get($i,1)."</td>
                                            <td>".db_get($i,8)."</td>
                                            <td>".db_get($i,11)."</td>";

                                      // $link = mysqli_connect('localhost', 'root', '', 'myezgo');

                                      if($occupation == 'Operation Staff'){
                                        
                                        $sql2 = "SELECT nickname FROM user where id = '".db_get($i,3)."'";
                                      }else{

                                        $sql2 = "SELECT nickname FROM user where id = '".db_get($i,2)."'";
                                      }

                                      $result2 = mysqli_query($con,$sql2);

                                      while ($row = mysqli_fetch_assoc($result2))
                                      {

                                        echo "<td>".$row['nickname']."</td>";
                                      }

                                      echo "<td>".date('d/m/y',strtotime(db_get($i,6)))."</td>
                                            <td>".db_get($i,13)."</td>";

                                      if((db_get($i,13) == "Assigned" || db_get($i,13) == "Pending") && $occupation =='Operation Staff')
                                  {
                                    echo "<td><center><a href='staff_job_view.php?id=".db_get($i,0)."&search_vehicle=".$search_vehicle."'><i class='fa fa-search'></i></a></center></td>";
                                  }
                                          
                                      echo "</tr>";
                                    }
                                  }   
                                  else{ 

                                    echo "<tr><td colspan='8'>No records found</td></tr>"; 
                                  }

                                ?>
                              </tbody>
                            </table>
                          </div>

                      </div>

                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2><i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 24px; color: #f95e5e"></i> Overdue Booked Vehicle <i class="fa fa-hand-o-left faa-horizontal animated fa-4x" style="font-size: 24px; color: #f95e5e"></i></h2>
                      <div class="clearfix"></div>
                    </div>
                    
                    <?php
                    
                    if($_SESSION['occupation'] == "Operation Staff")
                      {
                        $where = " AND booking_trans.branch = '".$_SESSION['user_branch']."'";
                      }
                      else
                      {
                        $where = "";
                        $td1 = "<td>Staff</td>";
                      }
                    ?>
                    <div class="x_content">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <td>#</td>
                                  <td>Agreement No.</td>
                                  <td>Vehicle Plate No.</td>
                                  <td>Branch</td>
                                  <td>Pickup Date</td>
                                  <td>Time</td>
                                  <?php echo $td1; ?>
                                  <td>View</td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  
                                  $sql = "SELECT 
                                    booking_trans.agreement_no AS agreement_no,
                                    reg_no,
                                    booking_trans.branch AS branch,
                                    booking_trans.pickup_date AS pickup_date,
                                    booking_trans.id AS booking_id,
                                    class_id,
                                    nickname
                                    FROM vehicle
                                    LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                                    LEFT JOIN customer ON customer.id = customer_id
                                    LEFT JOIN user ON booking_trans.staff_id = user.id
                                    WHERE booking_trans.available = 'Booked'".$where." AND pickup_date <= '".date('Y-m-d H:i:s', time())."' ORDER BY pickup_date DESC";
                                    
                                    /********* above date is for malaysian time zone********/

                                  // $sqlb = "SELECT * FROM booking_trans WHERE (return_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."' AND return_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."') OR (pickup_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."' AND pickup_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."') group by vehicle_id";
                                  db_select($sql);

                                  if (db_rowcount() > 0) {

                                    for ($i = 0; $i < db_rowcount(); $i++) {

                                    //   if (func_getOffset() >= 10) {

                                    //     $no = func_getOffset() + 1 + $i;

                                    //   } else {

                                    //     $no = $i + 1;

                                    //   }
                                    
                                      $no = $i+1;

                                      $date = date('d/m/y', strtotime(db_get($i,3)));
                                      $time = date('H:i', strtotime(db_get($i,3)));
                                      // echo $date;
                                      // $db_date date_format($date, 'd-m-Y H:i:s');
                                      echo
                                        "<tr>
                                          <td>".$no."</td>
                                          <td>".db_get($i,0)."</td>
                                          <td>".db_get($i,1)."</td>
                                          <td>".db_get($i,2)."</td>
                                          <td>".$date."</td>
                                          <td>".$time."</td>";
                                    
                                        if($_SESSION['occupation'] != "Operation Staff" )
                                        {
                                          echo "<td>".db_get($i,6)."</td>";
                                        }
                                        
                                        echo
                                          "<td>
                                            <a href='reservation_list_view.php?booking_id=" . db_get($i, 4) . "'>
                                              <i class='fa fa-search'></i>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                  }   
                                  else{ 

                                    echo "<tr><td colspan='8'>No records found</td></tr>"; 
                                  }
                                  
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
                <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 24px; color: #f95e5e"></i> Overdue Return Vehicle <i class="fa fa-hand-o-left faa-horizontal animated fa-4x" style="font-size: 24px; color: #f95e5e"></i></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <td>#</td>
                                <td>Agreement No.</td>
                                <td>Vehicle Plate No.</td>
                                <td>Branch</td>
                                <td>Return Date</td>
                                <td>Time</td>
                                <?php echo $td1; ?>
                                <td>View</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                
                                $sql = "SELECT 
                                  booking_trans.agreement_no AS agreement_no,
                                  reg_no,
                                  booking_trans.branch AS branch,
                                  booking_trans.return_date AS return_date,
                                  booking_trans.id AS booking_id,
                                  class_id,
                                  nickname
                                  FROM vehicle
                                  LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                                  LEFT JOIN user ON booking_trans.staff_id = user.id
                                  WHERE booking_trans.available = 'Out'".$where." AND return_date <='".date('Y-m-d H:i:s', time())."'
                                  GROUP BY booking_trans.id
                                  ORDER BY return_date DESC";
                                  
                                  /********* above date is for malaysian time zone********/

                                // $sqlb = "SELECT * FROM booking_trans WHERE (return_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."' AND return_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."') OR (pickup_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."' AND pickup_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."') group by vehicle_id";
                                db_select($sql);

                                if (db_rowcount() > 0) {

                                  for ($i = 0; $i < db_rowcount(); $i++) {

                                    // if (func_getOffset() >= 10) {

                                    //   $no = func_getOffset() + 1 + $i;

                                    // } else {

                                    //   $no = $i + 1;

                                    // }
                                    
                                    $no = $i+1;

                                    $date = date('d/m/y', strtotime(db_get($i,3)));
                                    $time = date('H:i', strtotime(db_get($i,3)));
                                    // echo $date;
                                    // $db_date date_format($date, 'd-m-Y H:i:s');
                                    echo
                                      "<tr>
                                        <td>".$no."</td>
                                        <td>".db_get($i,0)."</td>
                                        <td>".db_get($i,1)."</td>
                                        <td>".db_get($i,2)."</td>
                                        <td>".$date."</td>
                                        <td>".$time."</td>";
                                    
                                    if($_SESSION['occupation'] != "Operation Staff" )
                                    {
                                      echo "<td>".db_get($i,6)."</td>";
                                    }
                                    
                                    echo
                                        "<td>
                                          <a href='reservation_list_view.php?booking_id=" . db_get($i, 4) . "'>
                                            <i class='fa fa-search'></i>
                                          </td>
                                      </tr>
                                      ";
                                  }
                                }   
                                else{ 

                                  echo "<tr><td colspan='7'>No records found</td></tr>"; 
                                }

                              ?>
                            </tbody>
                          </table>
                        </div>

                    </div>

                  </div>
                </div>
                </div>
                <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 24px; color: #f95e5e"></i> Overdue Extend Vehicle <i class="fa fa-hand-o-left faa-horizontal animated fa-4x" style="font-size: 24px; color: #f95e5e"></i></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <td>#</td>
                                <td>Agreement No.</td>
                                <td>Vehicle Plate No.</td>
                                <td>Branch</td>
                                <td>Return Date</td>
                                <td>Time</td>
                                <?php echo $td1; ?>
                                <td>View</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                
                                $sql = "SELECT 
                                  booking_trans.agreement_no AS agreement_no,
                                  reg_no,
                                  booking_trans.branch AS branch,
                                  MAX(extend.extend_to_date) AS return_date,
                                  booking_trans.id AS booking_id,
                                  class_id,
                                  nickname
                                  FROM vehicle
                                  LEFT JOIN booking_trans ON vehicle.id = vehicle_id
                                  LEFT JOIN user ON booking_trans.staff_id = user.id
                                  LEFT JOIN extend ON booking_trans.id = extend.booking_trans_id
                                  WHERE booking_trans.available = 'Extend'".$where." 
                                  AND 
                                  booking_trans.id NOT IN (SELECT booking_trans_id FROM extend WHERE extend_to_date >='".date('Y-m-d H:i:s', time())."' GROUP BY booking_trans_id ORDER BY extend.id ASC)
                                  GROUP BY booking_trans.id
                                  ORDER BY extend_to_date DESC";
                                  
                                  /********* above date is for malaysian time zone********/

                                // $sqlb = "SELECT * FROM booking_trans WHERE (return_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."' AND return_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."') OR (pickup_date >= '" . conv_datetodbdate($search_pickup_date).' '.$search_pickup_time.':00'."' AND pickup_date <= '" . conv_datetodbdate($search_return_date).' '.$search_return_time.':00'."') group by vehicle_id";
                                db_select($sql);

                                if (db_rowcount() > 0) {

                                  for ($i = 0; $i < db_rowcount(); $i++) {

                                    // if (func_getOffset() >= 10) {

                                    //   $no = func_getOffset() + 1 + $i;

                                    // } else {

                                    //   $no = $i + 1;

                                    // }
                                    
                                    $no = $i+1;

                                    $date = date('d/m/y', strtotime(db_get($i,3)));
                                    $time = date('H:i', strtotime(db_get($i,3)));
                                    // echo $date;
                                    // $db_date date_format($date, 'd-m-Y H:i:s');
                                    echo
                                      "<tr>
                                        <td>".$no."</td>
                                        <td>".db_get($i,0)."</td>
                                        <td>".db_get($i,1)."</td>
                                        <td>".db_get($i,2)."</td>
                                        <td>".$date."</td>
                                        <td>".$time."</td>";
                                    
                                    if($_SESSION['occupation'] != "Operation Staff" )
                                    {
                                      echo "<td>".db_get($i,6)."</td>";
                                    }
                                    
                                    echo
                                        "<td>
                                          <a href='reservation_list_view.php?booking_id=" . db_get($i, 4) . "'>
                                            <i class='fa fa-search'></i>
                                          </td>
                                      </tr>
                                      ";
                                  }
                                }   
                                else{ 

                                  echo "<tr><td colspan='8'>No records found</td></tr>"; 
                                }

                              ?>
                            </tbody>
                          </table>
                        </div>

                    </div>

                  </div>
                </div>
                </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Available Vehicle</h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <td>#</td>
                            <td>Vehicle Plate No. (Status)</td>
                            <td>Vehicle Name</td>
                            <td>Sale (RM)</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            $month = date('m', time());
                            if($month == '01')
                            {
                              $month_no = $month;
                              $month = "jan";
                            }
                            else if($month == '02')
                            {
                              $month_no = $month;
                              $month = "feb";
                            }
                            else if($month == '03')
                            {
                              $month_no = $month;
                              $month = "march";
                            }
                            else if($month == '04')
                            {
                              $month_no = $month;
                              $month = "apr";
                            }
                            else if($month == '05')
                            {
                              $month_no = $month;
                              $month = "may";
                            }
                            else if($month == '06')
                            {
                              $month_no = $month;
                              $month = "june";
                            }
                            else if($month == '07')
                            {
                              $month_no = $month;
                              $month = "july";
                            }
                            else if($month == '08')
                            {
                              $month_no = $month;
                              $month = "aug";
                            }
                            else if($month == '09')
                            {
                              $month_no = $month;
                              $month = "sept";
                            }
                            else if($month == '10')
                            {
                              $month_no = $month;
                              $month = "oct";
                            }
                            else if($month == '11')
                            {
                              $month_no = $month;
                              $month = "nov";
                            }
                            else if($month == '12')
                            {
                              $month_no = $month;
                              $month = "dis";
                            }

                            $year = date('Y', time());
                            $sql = "SELECT 
                              vehicle.id,
                              reg_no,
                              concat(make,' ',model) AS carname,
                              availability,
                              SUM(sale_log.$month) AS sale
                              FROM vehicle
                              LEFT JOIN sale on sale.vehicle_id = vehicle.id
                              LEFT JOIN sale_log on sale.id = sale_log.sale_id
                              WHERE (availability = 'Available' OR availability = 'Booked') AND sale_log.year = '$year'
                              GROUP BY vehicle.id
                              ORDER BY SUM(sale_log.$month) ASC";
                            db_select($sql);

                            if (db_rowcount() > 0) {

                              for ($i = 0; $i < db_rowcount(); $i++) {

                                // if (func_getOffset() >= 10) {

                                //   $no = func_getOffset() + 1 + $i;

                                // } else {

                                //   $no = $i + 1;

                                // }
                                
                                $no = $i+1;
                                
                                echo
                                  "<tr>
                                    <td>".$no."</td>
                                    <td><a href='report_car_sale.php?search_month=$month_no&search_year=$year&search_vehicle=".db_get($i,0)."&btn_search='>".db_get($i,1)."</a><br>(".db_get($i,3).")</td>
                                    <td>".db_get($i,2)."</td>
                                    <td>".db_get($i,4)."</td>
                                  </tr>
                                  ";
                              }
                            }

                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>



            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Weekly Summary <small>Activity shares</small></h2>
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

                    <div class="row" style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
                      <div class="col-md-7" style="overflow:hidden;">
                        <span class="sparkline_one" style="height: 160px; padding: 10px 25px;">
                                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                  </span>
                        <h4 style="margin:18px">Weekly sales progress</h4>
                      </div>

                      <div class="col-md-5">
                        <div class="row" style="text-align: center;">
                          <div class="col-md-4">
                            <canvas class="canvasDoughnut" height="110" width="110" style="margin: 5px 10px 10px 0"></canvas>
                            <h4 style="margin:0">Bounce Rates</h4>
                          </div>
                          <div class="col-md-4">
                            <canvas class="canvasDoughnut" height="110" width="110" style="margin: 5px 10px 10px 0"></canvas>
                            <h4 style="margin:0">New Traffic</h4>
                          </div>
                          <div class="col-md-4">
                            <canvas class="canvasDoughnut" height="110" width="110" style="margin: 5px 10px 10px 0"></canvas>
                            <h4 style="margin:0">Device Share</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top Profiles <small>Sessions</small></h2>
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
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item One Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Three Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top Profiles <small>Sessions</small></h2>
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
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item One Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Three Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top Profiles <small>Sessions</small></h2>
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
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item One Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Three Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
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
    
    // echo "<br>id: ".$_SESSION['cid'];
    session_unset();
    session_destroy();
  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>