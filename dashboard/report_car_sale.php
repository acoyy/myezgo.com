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

      vali_redirect('report_car_sale.php'); 
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
                  <h3>Report Car Sale</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Report Car Sale</h2>
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

                        <div class="row">
                            <div class="form-group">
                                <div class = "col-md-6">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Month</label>
                                            <select class="form-control" name="search_month" <?php echo $disabled;?>>
                                                <option value="" <?php echo vali_iif(''==$search_month,'Selected','') ?>>All</option>
                                                <option value="01" <?php echo vali_iif('01'==$search_month,'Selected','') ?>>January</option>
                                                <option value="02" <?php echo vali_iif('02'==$search_month,'Selected','') ?>>February</option>
                                                <option value="03" <?php echo vali_iif('03'==$search_month,'Selected','') ?>>March</option>
                                                <option value="04" <?php echo vali_iif('04'==$search_month,'Selected','') ?>>April</option>
                                                <option value="05" <?php echo vali_iif('05'==$search_month,'Selected','') ?>>May</option>
                                                <option value="06" <?php echo vali_iif('06'==$search_month,'Selected','') ?>>June</option>
                                                <option value="07" <?php echo vali_iif('07'==$search_month,'Selected','') ?>>July</option>
                                                <option value="08" <?php echo vali_iif('08'==$search_month,'Selected','') ?>>August</option>
                                                <option value="09" <?php echo vali_iif('09'==$search_month,'Selected','') ?>>September</option>
                                                <option value="10" <?php echo vali_iif('10'==$search_month,'Selected','') ?>>October</option>
                                                <option value="11" <?php echo vali_iif('11'==$search_month,'Selected','') ?>>November</option>
                                                <option value="12" <?php echo vali_iif('12'==$search_month,'Selected','') ?>>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Year</label>
                                            <select class="form-control" name="search_year" <?php echo $disabled;?>>
                                                <option>-- Please select --</option>
                                                <option value="2018" <?php echo vali_iif('2018'==$search_year,'Selected','') ?>>2018</option>
                                                <option value="2019" <?php echo vali_iif('2019'==$search_year,'Selected','') ?>>2019</option>
                                                <option value="2020" <?php echo vali_iif('2020'==$search_year,'Selected','') ?>>2020</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vehicle</label>
                                        <select class="form-control" name="search_vehicle">
                                            <?php
                                                $value = "";
                                              
                                                $sql = "SELECT 
                                                    id,
                                                    reg_no,
                                                    concat(make,' ' ,model) AS vehicle_name
                                                    FROM vehicle
                                                    ORDER BY reg_no";
                                            
                                                db_select($sql);

                                                if(db_rowcount()>0){ 

                                                    for($j=-1;$j<db_rowcount();$j++){ 

                                                        if($j== '-1')
                                                        {
                                                            $value = $value."<option value='' ".vali_iif(''==$search_vehicle,'Selected','').">All Cars</option>";
                                                        }else
                                                        {
                                                            $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$search_vehicle,'Selected','').">".db_get($j,1)." - ".db_get($j,2). "</option>";
                                                        }
                                                    }
                                                } 

                                                echo $value;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>

                            <button href="report_car_sale.php" class="btn btn-warning">Clear</button>
                          </div>
                        </div>
                        </div>

                      </form>
                    </div>
                  </div>

                  <div class="x_panel">

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>No.</th>
                                <th>Agreement No.</th>
                                <th>Cust. Name</th>
                                <th>Car Details</th>
                                <th style='text-align: center;'>Duration</th>
                                <th>Staff</th>
                                <th style='text-align: center;'>Deposit (RM)</th>
                                <th style='text-align: center;'>Total (RM)</th>
                            </thead>
                            <tbody>
                                <?php
                                    func_setPage();
                                    func_setOffset();
                                    func_setLimit(10);
                                    if(isset($btn_search)){ 
                                        
                                        if($search_month =='')
                                        {
                                            
                                            $month = '';
                                        }
                                        else
                                        {

                                            $month=" AND MONTH(sale_log.date) = '".$search_month."'";
                                        }
                                        if($search_vehicle =='')
                                        {
                                            
                                            $vehicle = '';
                                        }
                                        else
                                        {

                                            $vehicle=" AND booking_trans.vehicle_id = '".$search_vehicle."'";
                                        }
                                        $year=" YEAR(sale_log.date) = '".$search_year."'";
                                    }
                                    else
                                    {
                                        echo '<script> alert("Please fill in the form to view sale"); </script>';
                                    }

                                    $sql = "SELECT
                                        vehicle.id,
                                        sale_log.date,
                                        reg_no,
                                        make,
                                        model,
                                        sale_log.daily_sale,
                                        SUM(sale_log.daily_sale),
                                        booking_trans.agreement_no,
                                        booking_trans.id,
                                        class_id,
                                        booking_trans.pickup_date,
                                        MAX(sale_log.date),
                                        CONCAT(firstname,' ' ,lastname) AS fullname,
                                        refund_dep,
                                        user.nickname
                                        FROM booking_trans 
                                        LEFT JOIN vehicle ON booking_trans.vehicle_id = vehicle.id 
                                        LEFT JOIN sale ON booking_trans.id = sale.booking_trans_id 
                                        LEFT JOIN sale_log ON sale.id = sale_log.sale_id 
                                        LEFT JOIN customer ON booking_trans.customer_id = customer.id 
                                        LEFT JOIN user ON booking_trans.staff_id = user.id 
                                        WHERE ".$year.$month.$vehicle."
                                        GROUP BY booking_trans.id
                                        ORDER BY booking_trans.id DESC
                                    ";

                                    db_select($sql);

                                    // func_setTotalPage(db_rowcount());

                                    // db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                                    if(db_rowcount()>0) { 
                                        for($i=0;$i<db_rowcount();$i++){
                                            
                                            if(func_getOffset()>=10){
                                                
                                                $no=func_getOffset()+1+$i;
                                            }

                                            else{ 

                                                $no=$i+1;
                                            } 

                                            $totalcost = number_format(db_get($i,2) + db_get($i,7) + db_get($i,8),2);
                                            $totalprofit = number_format(db_get($i,9) - $totalcost,2);
                                            $investotprofit = number_format(($totalprofit*40)/100,2);
                                            $companyprotfit = number_format(($totalprofit*60)/100,2);

                                            echo "<tr>
                                                <td>".$no."</td>
                                                <td><a href='reservation_list_view.php?booking_id=" . db_get($i, 8) . "'>".db_get($i,7)."</a></td>
                                                <td>".db_get($i,12)."</td>
                                                <td>".db_get($i,3).' '.db_get($i,4).' <br>('.db_get($i,2).')'."</td>
                                                <td style='text-align: center;'>".date('d/m/Y H:i', strtotime(db_get($i,10)))." <br>- ".date('d/m/Y H:i', strtotime(db_get($i,11)))."</td>
                                                <td>".db_get($i,14)."</td>
                                                <td style='text-align: center;'>".db_get($i,13)."</td>
                                                <td style='text-align: center;'>".db_get($i,6)."</td>
                                                </tr>";
                                        }
                                    }

                                    else{ 

                                        echo "<tr><td colspan='5'><center>No records found</center></td></tr>";
                                    }
                                ?>
                                <tr>
                                    <?php
                                        $sql = "SELECT
                                        vehicle.id,
                                        sale_log.date,
                                        reg_no,
                                        make,
                                        model,
                                        sale_log.daily_sale,
                                        SUM(sale_log.daily_sale),
                                        booking_trans.agreement_no,
                                        booking_trans.id,
                                        class_id,
                                        sale.id
                                        FROM booking_trans 
                                        LEFT JOIN vehicle ON booking_trans.vehicle_id = vehicle.id 
                                        LEFT JOIN sale ON booking_trans.id = sale.booking_trans_id 
                                        LEFT JOIN sale_log ON sale.id = sale_log.sale_id 
                                        WHERE ".$year.$month.$vehicle."
                                        GROUP BY YEAR(sale_log.date)";

                                    db_select($sql);

                                    // func_setTotalPage(db_rowcount());

                                    // db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                                    if(db_rowcount()>0) { 
                                        for($i=0;$i<db_rowcount();$i++){
                                            
                                            if(func_getOffset()>=10){
                                                
                                                $no=func_getOffset()+1+$i;
                                            }

                                            else{ 

                                                $no=$i+1;
                                            } 

                                            echo "
                                                <td colspan='7' style='text-align: right;''> Total Sale: </td>
                                                <td>RM ".db_get($i,6)."</td>
                                            ";
                                        }

                                        echo "<div class='col-md-12' style='text-align: right;'><a href='report_excel2.php?search_year=" . $search_year."&search_month=".$search_month."&search_vehicle=".$search_vehicle."'><input type='button' class='btn btn-primary' name='btn_excel' value='Export to Excel'></a></div>";
                                    }

                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align:center">
                                        <!-- <?php  func_getPaging('report_car_sale.php?x&search_month='.$search_month.'&search_year='.$search_year.'&search_vehicle='.$search_vehicle); ?> -->
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