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
   include("_header.php"); func_setReqVar(); if (isset($btn_clear)) { vali_redirect('report_profit.php'); } ?>

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
                  <h3>Report Profit</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Report Profit</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Profit
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           
                            <select class="form-control" name="search_investor" <?php echo $disabled;?>>
                                      <?php  $value = ""; $sql = "SELECT id, investor_name FROM investor"; db_select($sql); if(db_rowcount()>0){ for($j=0;$j<db_rowcount();$j++){ $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$search_investor,'Selected','').">".db_get($j,1)."</option>"; } } echo $value; ?>
                                  </select>

                          </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>
                            <button href="report_profit.php" class="btn btn-warning">Clear</button>
                          </div>
                        </div>
                        </div>

                      </form>
                    </div>
                  </div>

                  <div class="x_panel">

                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Investor</th>
                            <th>Car</th>
                            <th>Sales</th>
                            <th>Monthly Loan</th>
                            <th>Maintenance</th>
                            <th>Roadtax + Insurance</th>
                            <th>Total Cost</th>
                            <th>Total Profit</th>
                            <th>Investor Profit (40%)</th>
                            <th>Company Profit (60%)</th>
                          </tr>
                        </thead>
                        <tbody>
                      
                      <?php
                          func_setPage(); 
                          func_setOffset(); 
                          func_setLimit(10); 

                          if(isset($btn_search)){ 

          if($search_investor!=""){ 

              $where=" AND investor.id = '".$search_investor."'"; 

                  } 

              }

          $sql = "SELECT 
              vehicle.id,
              investor_name,
              monthly_loan,
              reg_no,
              make,
              model,
              loan_account_no,
              cost,
              amount,
              sum(sub_total)
              FROM vehicle 
              LEFT JOIN investor ON vehicle.id = investor.vehicle_id 
              LEFT JOIN fleet_maintenance ON vehicle.id = fleet_maintenance.vehicle_id 
              LEFT JOIN fleet_insurance ON vehicle.id = fleet_insurance .vehicle_id 
              LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id 
              WHERE investor.id IS NOT NULL
              GROUP BY vehicle.id " .$where; 


                              db_select($sql); 

                              func_setTotalPage(db_rowcount()); 

                              db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                              if(db_rowcount()>0){

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
              <td>".db_get($i,1)."</td>
              <td>".db_get($i,4).' '.db_get($i,5).' ('.db_get($i,3).')'."</td>
              <td>RM ".db_get($i,9)."</td>
              <td>RM ".db_get($i,2)."</td>
              <td>RM ".db_get($i,7)."</td>
              <td>RM ".db_get($i,8)."</td>
              <td>RM ".$totalcost."</td>
              <td>RM ".$totalprofit."</td>
              <td>RM ".$investotprofit."</td>
              <td>RM ".$companyprotfit."</td>
                      </tr>"; 


              


                                  }

                              } else{ echo "<tr><td colspan='8'>No records found</td></tr>"; }
                         

                          ?>

                          <tr>
                              <td colspan="8" style="text-align:center">
                                  <?php  func_getPaging('report_profit.php?x&search_vehicle='.$search_vehicle); ?>
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