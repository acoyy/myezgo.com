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

      vali_redirect('report_monthly.php'); 
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
                  <h3>Report Weekly</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Report Weekly</h2>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Month</label>
                                    <select class="form-control" name="search_month" <?php echo $disabled;?>>
                                        <option>-- Please select --</option>
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
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>

                            <button href="report_monthly.php" class="btn btn-warning">Clear</button>
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
                                        <tr>
                                            <th rowspan='2' style='text-align: center;'>#</th>
                                            <th rowspan='2' style='text-align: center;'>Car Details</th>
                                            <th rowspan='2' style='text-align: center;'>Plate No</th>
                                            <th colspan='5' style='text-align: center;'>Week (RM)</th>
                                            <th rowspan='2' style='text-align: center;'>Monthly</th>
                                        </tr>
                                        <tr>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>1</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>2</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>3</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>4</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>5</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
                                        if(isset($btn_search))
                                        {
                                            $initial_date = $search_year."-".$search_month."-01 00:00:00";
                                            $end_date = $search_year."-".$search_month."-31 23:59:59";
                                            
                                            $sql = "SELECT
                                            MONTH(sale_log.date) AS month,
                                            YEAR(sale_log.date) AS year,
                                            vehicle.id,
                                            concat(vehicle.make,' ',model) AS carname,
                                            vehicle.reg_no,
                                            vehicle.color,
                                            SUM(sale_log.week1),
                                            SUM(sale_log.week2),
                                            SUM(sale_log.week3),
                                            SUM(sale_log.week4),
                                            SUM(sale_log.week5),
                                            SUM(sale_log.daily_sale) AS total_sale
                                            -- SUM(total_sale)
                                            FROM sale
                                            LEFT JOIN vehicle ON sale.vehicle_id = vehicle.id
                                            LEFT JOIN sale_log ON sale.id = sale_log.sale_id
                                            where
                                                sale_log.date >= '".$initial_date."'
                                                AND
                                                sale_log.date <= '".$end_date."'
                                            GROUP BY vehicle.id
                                            ORDER BY carname
                                            ";

                                            db_select($sql);

                                            if(db_rowcount()>0) { 

                                                for($i=0;$i<db_rowcount();$i++){
                                                    
                                                    if(func_getOffset()>=10){
                                                        
                                                        $no=func_getOffset()+1+$i;
                                                    }

                                                    else{ 

                                                        $no=$i+1;
                                                    }

                                                    $num = $i +1;
                                                    echo "<tr>
                                                        <td>".$num."</td>
                                                        <td>".db_get($i,3)."<br><label class='control-label'>(".db_get($i,5).")</label></td>
                                                        <td>".db_get($i,4)."</td>
                                                        <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,6)."</td>
                                                        <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,7)."</td>
                                                        <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,8)."</td>
                                                        <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,9)."</td>
                                                        <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,10)."</td>
                                                        <td style='text-align: center;'>".db_get($i,11)."</td>
                                                        </tr>
                                                    ";
                                                }

                                                $sql_month = "SELECT
                                                sale.id,
                                                SUM(sale_log.week1),
                                                SUM(sale_log.week2),
                                                SUM(sale_log.week3),
                                                SUM(sale_log.week4),
                                                SUM(sale_log.week5),
                                                SUM(sale_log.daily_sale)
                                                FROM sale
                                                LEFT JOIN sale_log ON sale.id = sale_log.sale_id
                                                where
                                                sale_log.date >= '".$initial_date."'
                                                AND
                                                sale_log.date <= '".$end_date."'

                                                ";
                                                // between '".$search_year."/".$search_month."/01' and '".$search_year."/".$search_month."/31'

                                                db_select($sql_month);

                                                if(db_rowcount()>0) { 
                                                    $total = 0;
                                                    for($i=0;$i<db_rowcount();$i++){
                                                        
                                                        if(func_getOffset()>=10){
                                                            
                                                            $no=func_getOffset()+1+$i;
                                                        }

                                                        else{ 

                                                            $no=$i+1;
                                                        }
                                                        echo '
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>Week 1 Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,1).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>Week 2 Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,2).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>Week 3 Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,3).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>Week 4 Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,4).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>Week 5 Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,5).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #ffebb7;">
                                                                        <b>Monthly Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,6).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        ';
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<script> alert('cannot display total sale'); </script>";
                                                }



                                                $sql2 = "SELECT
                                                    id,
                                                    reg_no,
                                                    make,
                                                    model,
                                                    concat(make,' ' ,model) AS carname,
                                                    color
                                                    FROM vehicle
                                                    WHERE id not in 
                                                    (SELECT vehicle_id FROM sale LEFT JOIN sale_log ON sale.id = sale_log.sale_id where sale_log.date >= '".$initial_date."' AND sale_log.date <= '".$end_date."')
                                                    AND (availability = 'Available'
                                                    OR availability = 'Booked'
                                                    OR availability = 'Out')
                                                    GROUP BY id ORDER BY carname";

                                                db_select($sql2);

                                                if(db_rowcount()>0) { 
                                                    for($i=0;$i<db_rowcount();$i++){
                                                        
                                                        if(func_getOffset()>=10){
                                                            
                                                            $no=func_getOffset()+1+$i;
                                                        }

                                                        else{ 

                                                            $no=$i+1;
                                                        }
                                                        $num = $num+1;

                                                        echo "<tr>
                                                            <td>".$num."</td>
                                                            <td>".db_get($i,4)."<br><label class='control-label'>(".db_get($i,5).")</label></td>
                                                            <td>".db_get($i,1)."</td>
                                                            <td colspan='6' bgcolor='#f2f4f7'><center><i><mark>This vehicle (".db_get($i,1).") has not been booked for the entire month</mark></i></center></td>
                                                            </tr>";
                                                    }
                                                }

                                                echo "<div class='col-md-12' style='text-align: right;'><a href='report_weekly_excel.php?search_year=" . $search_year."&search_month=".$search_month."'><input type='button' class='btn btn-primary' name='btn_excel' value='Export to Excel'></a></div>";
                                            }
                                            else
                                            {

                                                echo "<tr><td colspan='9'><center>No records found</center></td></tr>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td colspan='9'><center>No records found</center></td></tr>";
                                        }

                                        // if(isset($btn_excel))
                                        // {
                                        //     echo "<script> alert('masuk if'); </script>";
                                        //     vali_redirect("report_excel.php?search_year=" . $search_year."&search_month=".$search_month); 
                                        // }

                                        ?>
<!--                                         <tr>
                                            <td colspan="11" style="text-align:center">
                                                <?php  func_getPaging('report_weekly.php?x&btn_search=&search_month='.$search_month.'&search_year='.$search_year.'&search_week='.$search_week); ?>


                                            </td>
                                        </tr> -->
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