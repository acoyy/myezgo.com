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
                              <h3>Report Agent Profit</h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>by Agreement</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Settings 1</a></li>
                                                    <li><a href="#">Settings 2</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <br />

                                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Search</label>
                                                            <input class="form-control" name="search_agreement" value="<?php echo $search_agreement;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="text-align: left;">
                                                <div class="form-group">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <button name="btn_search" type="submit" class="btn btn-success">Search</button>
                                                        <button href="report_car_sale.php" class="btn btn-warning">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                            <br><br>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="text-primary">
                                                        <th>#</th>
                                                        <th>Agreement No.</th>
                                                        <th>Agent Code</th>
                                                        <th>Agent Name</th>
                                                        <th>Agreement Sale (RM)</th>
                                                        <th>Profit (RM)</th>
                                                        <th>Date</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            func_setPage();
                                                            func_setOffset();
                                                            func_setLimit(10);
                                                            if(isset($btn_search)){ 
                                                                
                                                                if($search_agreement =='')
                                                                {
                                                                    
                                                                    $agreement = '';
                                                                }
                                                                else
                                                                {

                                                                    $agreement=" WHERE booking_trans.agreement_no LIKE '%".$search_agreement."%' OR agent.code LIKE '%".$search_agreement."%'";
                                                                }
                                                            }

                                                            $sql = "SELECT
                                                                booking_trans.agreement_no AS agreement_no,
                                                                agent.code AS agent_code,
                                                                agent.name AS agent_name,
                                                                booking_trans.sub_total AS sub_total,
                                                                agent_profit.amount as amount,
                                                                agent_profit.created as created,
                                                                agent.id AS agent_id,
                                                                booking_trans.id AS booking_id,
                                                                booking_trans.vehicle_id AS vehicle_id,
                                                                vehicle.class_id AS class_id
                                                                FROM agent_profit
                                                                LEFT JOIN agent ON agent_profit.agent_id = agent.id 
                                                                LEFT JOIN booking_trans ON agent_profit.booking_trans_id = booking_trans.id 
                                                                LEFT JOIN vehicle ON booking_trans.vehicle_id = vehicle.id 
                                                                ".$agreement."
                                                                GROUP BY booking_id
                                                                ORDER BY created DESC
                                                            ";

                                                            db_select($sql);

                                                            func_setTotalPage(db_rowcount());

                                                            db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                                                            if(db_rowcount()>0) { 
                                                                for($i=0;$i<db_rowcount();$i++){
                                                                    
                                                                    if(func_getOffset()>=10){
                                                                        
                                                                        $no=func_getOffset()+1+$i;
                                                                    }

                                                                    else{ 

                                                                        $no=$i+1;
                                                                    } 

                                                                    echo "<tr>
                                                                        <td>".$no."</td>
                                                                        <td><a href='reservation_list_view.php?booking_id=".db_get($i,7)."'>".db_get($i,0)."</a></td>
                                                                        <td>".db_get($i,1)."</td>
                                                                        <td>".db_get($i,2)."</td>
                                                                        <td>".db_get($i,3)."</td>
                                                                        <td>".db_get($i,4)."</td>
                                                                        <td>".date('d/m/Y', strtotime(db_get($i,5)))."</td>
                                                                        </tr>";
                                                                }
                                                            }

                                                            else{ 

                                                                echo "<tr><td colspan='5'><center>No records found</center></td></tr>";
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td colspan="11" style="text-align:center">
                                                                <?php  func_getPaging('report_agent_profit.php?x&search_agreement='.$search_agreement.'&page'.$page); ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if(isset($btn_search)){ 
                                                            
                                    if($search_month =='')
                                    {
                                        
                                        $month = '';
                                    }
                                    else
                                    {

                                        $month=" AND MONTH(agent_profit.created) = '".$search_month."'";
                                    }
                                    $year=" YEAR(agent_profit.created) = '".$search_year."'";
                                }
                                else
                                {   
                                    $search_month = date('m', time());
                                    $search_year = date('Y', time());
                                    $month=" AND MONTH(agent_profit.created) = '".$search_month."'";
                                    $year =" YEAR(agent_profit.created) = '".$search_year."'";
                                }
                            ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>by Month</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Settings 1</a></li>
                                                    <li><a href="#">Settings 2</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <br />

                                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                            <div class="row">
                                                <div class="form-group">
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
                                            </div>
                                            <div style="text-align: right;">
                                                <div class="form-group">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <button name="btn_search" type="submit" class="btn btn-success">Search</button>
                                                        <button href="report_car_sale.php" class="btn btn-warning">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ln_solid"></div>
                                        </form>
                                        <br><br>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <th>No.</th>
                                                    <th>Agent Code</th>
                                                    <th>Agent Name</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // func_setPage();
                                                        // func_setOffset();
                                                        // func_setLimit(10);

                                                        $sql = "SELECT
                                                            agent.id AS agent_id,
                                                            agent.code AS agent_code,
                                                            agent.name AS agent_name,
                                                            SUM(agent_profit.amount) as amount
                                                            FROM agent_profit
                                                            LEFT JOIN agent ON agent_profit.agent_id = agent.id 
                                                            WHERE ".$year.$month."
                                                            GROUP BY agent.id
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

                                                                echo "<tr>
                                                                    <td>".$no."</td>
                                                                    <td>".db_get($i,1)."</td>
                                                                    <td>".db_get($i,2)."</td>
                                                                    <td>".db_get($i,3)."</td>
                                                                    </tr>";
                                                            }
                                                        }

                                                        else{ 

                                                            echo "<tr><td colspan='5'><center>No records found</center></td></tr>";
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="11" style="text-align:center">
                                                            <!-- <?php  func_getPaging('report_car_sale.php?x&search_month='.$search_month.'&search_year='.$search_year); ?> -->
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