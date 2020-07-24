<?php 
    include('_header.php'); 
	require("lib/phpmailer/class.phpmailer.php");
?>	
<html>
    <body>
        <center>
            <table class="table">
                <thead class="text-primary">
                    <tr>
                        <th rowspan='2' style='text-align: center;'>#</th>
                        <th rowspan='2' style='text-align: center;'>Agreement No.</th>
                        <th rowspan='2' style='text-align: center;'>Pickup</th>
                        <th rowspan='2' style='text-align: center;'>Return</th>
                        <th rowspan='2' style='text-align: center;'>Sale id</th>
                        <th rowspan='2' style='text-align: center;'>Total sale</th>
                        <th rowspan='2' style='text-align: center;'>No of sale log</th>
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
                    
                        $search_year = "2019";
                        $search_month = "01";
                        
                        $initial_date = $search_year."-".$search_month."-01 00:00:00";
                        $end_date = $search_year."-".$search_month."-31 23:59:59";
                        
                        $sql = "SELECT
                        booking_trans.agreement_no,
                        booking_trans.pickup_date,
                        booking_trans.return_date,
                        MONTH(sale_log.date) AS month,
                        YEAR(sale_log.date) AS year,
                        SUM(sale_log.week1),
                        SUM(sale_log.week2),
                        SUM(sale_log.week3),
                        SUM(sale_log.week4),
                        SUM(sale_log.week5),
                        SUM(sale_log.daily_sale) AS total_sale,
                        booking_trans.id,
                        sale.id,
                        COUNT(sale_log.id) AS total_sale
                        FROM booking_trans
                        LEFT JOIN sale ON sale.booking_trans_id = booking_trans.id
                        LEFT JOIN sale_log ON sale.id = sale_log.sale_id
                        GROUP BY booking_trans.id
                        ORDER BY booking_trans.created DESC
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
                                <td style='text-align: center; background-color: #fff8f4;'><a href='reservation_list_view.php?booking_id=".db_get($i,11)."'>".db_get($i,0)."</a></td>
                                <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,1)."</td>
                                <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,2)."</td>
                                <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,12)."</td>
                                <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,10)."</td>
                                <td style='text-align: center; background-color: #fff8f4;'>".db_get($i,13)."</td>
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
                    }
        					
                    ?>
            </table>
        </center>
    </body>
</html>