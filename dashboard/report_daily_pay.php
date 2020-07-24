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
                  <h3>Report Daily Pay</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Report Daily Pay</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           
                            <input type="text" class="form-control" id="single_cal1" placeholder="search_date" aria-describedby="inputSuccess2Status" name="search_date" value="<?php echo $search_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>
                            <button href="report_daily_pay.php" class="btn btn-warning">Clear</button>
                          </div>
                        </div>
                        </div>

                      </form>
                    </div>
                  </div>

                  <div class="x_panel">

                    <table border="1">
                        <thead>
                          <tr>
                            <th style='text-align: center;' rowspan="2">#</th>
                            <th style='text-align: center;' rowspan="2">Plate No</th>
                            <th style='text-align: center;' rowspan="2">Car Status</th>
                            <th style='text-align: center;' rowspan="2">Time Pickup</th>
                            <th style='text-align: center;' rowspan="2">Time Return</th>
                            <th style='text-align: center;' rowspan="2">Days</th>
                            <th style='text-align: center;' rowspan="2">Name</th>
                            <th style='text-align: center;' colspan="2">
                              Deposit
                            </th>
                            <th style='text-align: center;' rowspan="2">Discount (RM)</th>
                            <th style='text-align: center;' rowspan="2">Total (RM)</th>
                            <th style='text-align: center;' rowspan="2">Nett Total (RM)</th>
                          </tr>
                          <tr>
                            <th style='text-align: center;'>
                              Amount (RM)
                            </th>
                            <th style='text-align: center;'>
                              Status
                            </th>
                          </tr>
                        </thead>
                        <tbody style="font-size: small;">
                          <?php
                            func_setPage();
                            func_setOffset();
                            func_setLimit(10);
                            if(isset($btn_search)){
                              if($search_date!=""){ 
                                $where=" AND DATE_FORMAT(pickup_date, '%d/%m/%Y') LIKE '%".$search_date."%'"; 
                              } 
                            } 

                            $sql = "SELECT
                              vehicle.id,
                              reg_no,
                              vehicle.availability,
                              refund_dep_status,
                              booking_trans.discount_amount,
                              DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date, 
                              DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time, 
                              DATE_FORMAT(return_date, '%d/%m/%Y') as return_date, 
                              DATE_FORMAT(return_time, '%H:%i:%s') as return_time, 
                                        booking_trans.id,
                              concat(firstname,' ' ,lastname) as name,
                              refund_dep,
                              refund_dep_payment,
                              sub_total
                              FROM vehicle 
                              LEFT JOIN booking_trans ON vehicle.id = vehicle_id 
                              LEFT JOIN class ON class.id = class_id 
                              LEFT JOIN customer ON customer_id = customer.id 
                              WHERE booking_trans.id IS NOT NULL" .$where." ORDER BY YEAR(pickup_date) DESC, MONTH(pickup_date) DESC, DAY(pickup_date) DESC, HOUR(created) DESC, MINUTE(created) DESC, SECOND(created) DESC
                            "; 

                            db_select($sql); 

                            func_setTotalPage(db_rowcount()); 
                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset()); 

                            if(db_rowcount()>0){ 

                              for($i=0;$i<db_rowcount();$i++){ 

                                if(func_getOffset()>=15){ 

                                  $no=func_getOffset()+1+$i; 
                                }
                                else{ 

                                  $no=$i+1; 
                                } 
                                
                                if(db_get($i,2) == 'Available')
                                {
                                  $status = 'Avail.';
                                }
                                
                                else if(db_get($i,2) == 'Booked')
                                {
                                  $status = 'Booked';
                                }
                                
                                else if(db_get($i,2) == 'Out')
                                {
                                  $status = 'Out';
                                }

                                $total = db_get($i,13);
                                $deposit = db_get($i,11);
                                $discount = db_get($i,4);

                                $nett_total = ($total+$deposit)-$discount;

                                echo "<tr>
                                    <td style='text-align: center;'>".$no."</td>
                                    <td style='text-align: center;'>".db_get($i,1)."</td>
                                    <td style='text-align: center;'>".$status."</td>
                                    <td style='text-align: center;'>".db_get($i,5)." ".db_get($i,6)."</td>
                                    <td style='text-align: center;'>".db_get($i,7)." ".db_get($i,8)."</td>
                                    <td style='text-align: center;'>".dateDifference(conv_datetodbdate(db_get($i,5)) . db_get($i,6), conv_datetodbdate(db_get($i,7)) . db_get($i,8), '%d Day %h Hours')."</td>
                                    <td style='text-align: center;'>".db_get($i,10)."</td>
                                    <td style='text-align: center;'>".db_get($i,11)." / ".db_get($i,12)."</td>
                                    <td style='text-align: center;'>".db_get($i,3)."</td>
                                    <td style='text-align: center;'>".db_get($i,4)."</td>
                                    <td style='text-align: center;'>".db_get($i,13)."</td>
                                    <td style='text-align: center;'>".$nett_total."</td>
                                  </tr>
                                "; 
                              } 
                            }

                            else{ 

                              echo "<tr><td colspan='20'>No records found</td></tr>"; 
                            }
                          ?>
                          <tr>
                            <td colspan="20" style="text-align:center">
                            <?php  func_getPaging('report_daily_pay.php?x&btn_search=&search_date='.$search_date.'&page'.$page); ?>
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