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
                  <h3>Journal</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Journal</h2>
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
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <label class="control-label">Date</label>
                             
                              <input type="text" class="form-control" id="single_cal1" placeholder="search_date" aria-describedby="inputSuccess2Status" name="search_date" value="<?php echo $search_date;?>" autocomplete="off">
                                    
                              <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Branch</label>
                              <select class="form-control" name="search_branch" <?php echo $disabled;?>>
                                <option value="" <?php echo vali_iif(''==$search_branch,'Selected','') ?>>All</option>
                                <option value="SEREMBAN" <?php echo vali_iif('SEREMBAN'==$search_branch,'Selected','') ?>>Seremban</option>
                                <option value="PORT DICKSON" <?php echo vali_iif('PORT DICKSON'==$search_branch,'Selected','') ?>>Port Dickson</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>
                            <button href="journal.php" class="btn btn-warning">Clear</button>
                          </div>
                        </div>
                        </div>

                      </form>
                    </div>
                  </div>

                  <?php

                  if(isset($btn_search)){
                              if($search_date!=""){
                                
                                $search_date = str_replace('/', '-', $search_date);
                                $where = " AND DATE_FORMAT(sale.created, '%d-%m-%Y') LIKE '%".$search_date."%'"; 
                              }
                              else
                              {
                                $search_date = date('d-m-Y',time());
                                $where = " AND DATE_FORMAT(sale.created, '%d-%m-%Y') LIKE '%".$search_date."%'";
                              }

                              if($search_branch!=""){ 
                                $where2 = " AND booking_trans.branch = '$search_branch'"; 
                              } 
                            } 
                            else
                            {
                              $search_date = date('d-m-Y',time());
                              $where = " AND DATE_FORMAT(sale.created, '%d-%m-%Y') LIKE '%".$search_date."%'"; 
                              $where2 = "";
                            }

                            // $sql = "SELECT
                            //   vehicle.id,
                            //   reg_no,
                            //   vehicle.availability,
                            //   refund_dep_status,
                            //   booking_trans.discount_amount,
                            //   DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date, 
                            //   DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time, 
                            //   DATE_FORMAT(return_date, '%d/%m/%Y') as return_date, 
                            //   DATE_FORMAT(return_time, '%H:%i:%s') as return_time, 
                            //             booking_trans.id,
                            //   concat(firstname,' ' ,lastname) as name,
                            //   refund_dep,
                            //   refund_dep_payment,
                            //   sub_total
                            //   FROM vehicle 
                            //   LEFT JOIN booking_trans ON vehicle.id = vehicle_id 
                            //   LEFT JOIN class ON class.id = class_id 
                            //   LEFT JOIN customer ON customer_id = customer.id 
                            //   WHERE booking_trans.id IS NOT NULL" .$where." ORDER BY YEAR(pickup_date) DESC, MONTH(pickup_date) DESC, DAY(pickup_date) DESC, HOUR(created) DESC, MINUTE(created) DESC, SECOND(created) DESC
                            // "; 

                            $sql = "SELECT 
                                reg_no,
                                sale.title,
                                agreement_no,
                                concat(make, ' ', model) AS car,
                                SUM(sale_log.daily_sale) as total_sale,
                                sale.payment_status,
                                sale.deposit,
                                refund_dep_payment,
                                DATE_FORMAT(sale.created, '%d-%m-%Y %H:%i:%s'),
                                sale.payment_type
                                FROM booking_trans
                                LEFT JOIN sale ON booking_trans.id = sale.booking_trans_id
                                LEFT JOIN vehicle ON sale.vehicle_id = vehicle.id
                                LEFT JOIN sale_log ON sale.id = sale_log.sale_id
                                WHERE booking_trans.id IS NOT NULL
                                ".$where.$where2."
                                GROUP BY sale.id
                                ORDER BY sale.id DESC
                            ";

                            db_select($sql);

                            func_setPage();
                            func_setOffset();
                            func_setLimit(10);
                            func_setTotalPage(db_rowcount()); 
                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset()); 

                            if(db_rowcount()>0){ 

                  ?>

                  <div class="x_panel">

                    <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th style='vertical-align: middle; text-align: center;' rowspan="2">#</th>
                            <th style='vertical-align: middle; text-align: center;' rowspan="2">Agreement No</th>
                            <th style='vertical-align: middle; text-align: center;' rowspan="2">Plate No</th>
                            <th style='vertical-align: middle; text-align: center;' rowspan="2">Title</th>
                            <th style='vertical-align: middle; text-align: center;' rowspan="2">Model</th>
                            <th style='vertical-align: middle; text-align: center;' rowspan="2">Created</th>
                            <th style='text-align: center; border-left: 1px solid #a6a7a8;' colspan="2">Rental</th>
                            <th style='text-align: center; border-right: 1px solid #a6a7a8;' colspan="2">Deposit</th>
                          </tr>
                          <tr>
                            <th style='text-align: center; border-left: 1px solid #a6a7a8;'>Amount</th>
                            <th style='text-align: center;'>Payment Type</th>
                            <th style='text-align: center;'>Amount</th>
                            <th style='text-align: center; border-right: 1px solid #a6a7a8;'>Payment Type</th>
                          </tr>
                        </thead>
                        <tbody style="font-size: small;">
                          <?php

                            echo "<div class='col-md-12'><a href='journal_excel.php?search_date=" . $search_date."'><input type='button' class='btn btn-primary' name='btn_excel' value='Export to Excel'></a></div><br><br><br>";
                                
                                for($i=0;$i<db_rowcount();$i++){
                                    
                                    for($i=0;$i<db_rowcount();$i++){
                                        
                                        if(func_getOffset()>=10){
                                            
                                            $no=func_getOffset()+1+$i;
                                        } 
                                        else{
                                            
                                            $no=$i+1;
                                        }
                                        
                                        echo "<tr>
                                            <td style='text-align: center;'>".$no."</td>
                                            <td style='text-align: center;'>".db_get($i,2)."</td>
                                            <td style='text-align: center;'>".db_get($i,0)."</td>
                                            <td style='text-align: center;'>".db_get($i,1)."</td>
                                            <td style='text-align: center;'>".db_get($i,3)."</td>
                                            <td style='text-align: center;'>".db_get($i,8)."</td>
                                            <td style='text-align: center; background-color: #edeeef; border-left: 1px solid #a6a7a8;'>"; 
                                                if(db_get($i,4) == ''){ echo "0.00"; } else{ echo db_get($i,4); }
                                        echo "</td>
                                            <td style='text-align: center;'>";
                                              if(db_get($i,5) != 'Collect'){ echo db_get($i,9); } else{ echo db_get($i,5); }
                                        echo "</td>
                                            <td style='text-align: center; background-color: #edeeef;'>".db_get($i,6)."</td>
                                            <td style='text-align: center; border-right: 1px solid #a6a7a8;'>".db_get($i,7)."</td>
                                            </tr>
                                        ";
                                    }
                                }
                          ?>
                          <tr>
                            <td colspan="20" style="text-align:center">
                            <?php   func_getPaging('journal.php?x&btn_search=&search_date='.$search_date.'&search_branch='.$search_branch.'&page'.$page); ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
                  <?php
                    }

                    else{ 

                      echo "<tr><td colspan='20'>No records found</td></tr>"; 
                    }
                  ?>
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