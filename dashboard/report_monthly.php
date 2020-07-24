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
                  <h3>Report Monthly</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Report Monthly</h2>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Year</label>
                                        <select class="form-control" name="search_year" <?php echo $disabled;?>>
                                            <option>-- Please select --</option>
                                            <option value="2018" <?php echo vali_iif('2018'==$search_year,'Selected','') ?>>2018</option>
                                            <option value="2019" <?php echo vali_iif('2019'==$search_year,'Selected','') ?>>2019</option>
                                            <option value="2020" <?php echo vali_iif('2020'==$search_year,'Selected','') ?>>2020</option>
                                            <option value="2021" <?php echo vali_iif('2021'==$search_year,'Selected','') ?>>2021</option>
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
                                <table class='table'>
                                    <thead class="text-primary">
                                        <tr>
                                            <th rowspan='2' style='text-align: center;'>Car Details</th>
                                            <th rowspan='2' style='text-align: center;'>Plate No</th>
                                            <th colspan='12' style='text-align: center;'>Month (RM)</th>
                                        </tr>
                                        <tr>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Jan</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Feb</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>March</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Apr</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>May</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>June</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>July</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Aug</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Sept</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Oct</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Nov</small></th>
                                            <th style='text-align: center; background-color: #f7ebe3;'><small>Dec</small></th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: small;">
                                        <?php

                                        if(isset($btn_search))
                                        {
                                            
                                            $sql = "SELECT
                                            YEAR(sale_log.date) AS year,
                                            vehicle.id,
                                            concat(vehicle.make,' ',model) AS carname,
                                            vehicle.reg_no,
                                            vehicle.color,
                                            SUM(sale_log.jan),
                                            SUM(sale_log.feb),
                                            SUM(sale_log.march),
                                            SUM(sale_log.apr),
                                            SUM(sale_log.may),
                                            SUM(sale_log.june),
                                            SUM(sale_log.july),
                                            SUM(sale_log.aug),
                                            SUM(sale_log.sept),
                                            SUM(sale_log.oct),
                                            SUM(sale_log.nov),
                                            SUM(sale_log.dis),
                                            SUM(sale_log.daily_sale)
                                            FROM sale
                                            LEFT JOIN vehicle ON sale.vehicle_id = vehicle.id
                                            LEFT JOIN sale_log ON sale.id = sale_log.sale_id
                                            where YEAR(sale_log.date) = '".$search_year."'
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
                                                    echo "<tr style='text-align: center;'>
                                                            <td>".db_get($i,2)." <br><label class='control-label'>(".db_get($i,4).")</label></td>
                                                            <td style='width: 100px;'>".db_get($i,3)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,5)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,6)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,7)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,8)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,9)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,10)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,11)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,12)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,13)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,14)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,15)."</td>
                                                            <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,16)."</td>
                                                            ";

                                                }

                                                $sql_total = "SELECT
                                                    SUM(sale_log.jan),
                                                    SUM(sale_log.feb),
                                                    SUM(sale_log.march),
                                                    SUM(sale_log.apr),
                                                    SUM(sale_log.may),
                                                    SUM(sale_log.june),
                                                    SUM(sale_log.july),
                                                    SUM(sale_log.aug),
                                                    SUM(sale_log.sept),
                                                    SUM(sale_log.oct),
                                                    SUM(sale_log.nov),
                                                    SUM(sale_log.dis),
                                                    SUM(sale_log.daily_sale)
                                                    FROM sale_log
                                                    where
                                                    year = '".$search_year."'
                                                ";
                                                // between '".$search_year."/".$search_month."/01' and '".$search_year."/".$search_month."/31'

                                                db_select($sql_total);

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
                                                                        <b>January Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,0).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>February Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,1).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>March Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,2).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>April Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,3).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>May Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,4).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>June Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,5).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>July Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,6).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>August Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,7).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>September Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,8).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>October Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,9).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>November Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,10).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #d1ff99;">
                                                                        <b>December Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,11).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                            </div>
                                                            <div class="panel-group col-md-2">
                                                                <div class="panel panel-default">
                                                                    <div class="panel panel-heading" style="background-color: #ffebb7;">
                                                                        <b>Yearly Sale</b>
                                                                    </div>
                                                                    <div class="panel panel-body">
                                                                        <b><small>RM'.db_get($i,12).'</small></b>
                                                                    </div>
                                                                </div>
                                                            </div>';


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
                                                    WHERE id not in (SELECT vehicle_id FROM sale LEFT JOIN sale_log ON sale.id = sale_log.sale_id where YEAR(sale_log.date) = '".$search_year."')
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

                                                        echo "<tr style='text-align: center;'>
                                                            <td>".db_get($i,4)." <br><label class='control-label'>(".db_get($i,5).")</label></td>
                                                            <td>".db_get($i,1)."</td>
                                                            <td colspan='12' bgcolor='#f2f4f7'><center><i><mark>This vehicle (".db_get($i,1).") has not been booked for the entire year</mark></i></center></td>
                                                            </tr>";
                                                    }
                                                }
                                            }
                                            else
                                            {

                                                echo "<tr><td colspan='14'><center>No records found</center></td></tr>";
                                            }
                                        }
                                        else
                                        {

                                            echo "<tr><td colspan='14'><center>No records found</center></td></tr>";
                                        }

                                        ?>
<!--                                         <tr>
                                            <td colspan="11" style="text-align:center">
                                                <?php  func_getPaging('report_monthly.php?x&btn_search=&search_month='.$search_month.'&search_year='.$search_year.'&search_week='.$search_week); ?>


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