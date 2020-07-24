<?php
session_start();
require("lib/setup.php"); 
if(isset($_SESSION['cid']))
{ 

    $idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

    if (time()-$_SESSION['timestamp']>$idletime){
        session_unset();
        session_destroy();
        echo "<script> alert('You have been logged out due to inactivity'); </script>";
        echo "<script>
                window.location.href='index.php';
            /script>";
    }

    else{
        
        $_SESSION['timestamp']=time();
    }

     $sql = "SELECT 
        company_name,
        website_name,
        registration_no,
        address AS company_address,
        phone_no AS company_phone_no,
        image AS company_image
        FROM company WHERE id IS NOT NULL"; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); }

    func_setReqVar();

    if(isset($btn_clear)){ 

        vali_redirect('report_weekly.php'); 
    }

    // echo "<script> alert('masuk excel'); </script>";

    $search_year = $_GET['search_year'];
    $search_month = $_GET['search_month'];

    if($search_month == '1')
    {

        $monthname = 'January';
    }
    else if($search_month == '2')
    {

        $monthname = 'February';
    }
    else if($search_month == '3')
    {

        $monthname = 'March';
    }
    else if($search_month == '4')
    {

        $monthname = 'April';
    }
    else if($search_month == '5')
    {

        $monthname = 'May';
    }
    else if($search_month == '6')
    {

        $monthname = 'June';
    }
    else if($search_month == '7')
    {

        $monthname = 'July';
    }
    else if($search_month == '8')
    {

        $monthname = 'August';
    }
    else if($search_month == '9')
    {

        $monthname = 'September';
    }
    else if($search_month == '10')
    {

        $monthname = 'October';
    }
    else if($search_month == '11')
    {

        $monthname = 'November';
    }
    else if($search_month == '12')
    {

        $monthname = 'December';
    }

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

    $Content = "Car Details, Plate Number, Week 1 (RM), Week 2 (RM), Week 3 (RM), Week 4 (RM), Week 5 (RM), Monthly (RM)\n";
    if(db_rowcount()>0) { 

        for($i=0;$i<db_rowcount();$i++){
            
            if(func_getOffset()>=10){
                
                $no=func_getOffset()+1+$i;
            }

            else{ 

                $no=$i+1;
            }

            $num = $i +1;

            $cardetails = db_get($i,3);
            $platenumber = db_get($i,4);
            $week1car1 = db_get($i,6);
            $week2car1 = db_get($i,7);
            $week3car1 = db_get($i,8);
            $week4car1 = db_get($i,9);
            $week5car1 = db_get($i,10);
            $monthlycar1 = db_get($i,11);


            # Title of the CSV
            // $Content = "Car Details, Email,alamat";

            //set the data of the CSV
            // $Content .= "$name, $email, $alamat\n\n\n";
            $Content .= "$cardetails, $platenumber, $week1car1, $week2car1, $week3car1, $week4car1, $week5car1, $monthlycar1\n";

        }
        
        $sql2 = "SELECT
            id,
            reg_no,
            make,
            model,
            concat(make,' ' ,model) AS carname,
            availability
            FROM vehicle
            WHERE id not in (SELECT vehicle_id FROM sale 
            LEFT JOIN sale_log ON sale.id = sale_log.sale_id
            where
            sale_log.date >= '".$initial_date."'
            AND
            sale_log.date <= '".$end_date."')
            AND availability != 'Test'
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

                $platenumber = db_get($i,1);
                $carname = db_get($i,4);
                $status = db_get($i,5);

                $Content2 .= "$carname ($status), $platenumber, 0, 0, 0, 0, 0, 0\n";

            }
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
                $saleweek1 = db_get($i,1);
                $saleweek2 = db_get($i,2);
                $saleweek3 = db_get($i,3);
                $saleweek4 = db_get($i,4);
                $saleweek5 = db_get($i,5);
                $salemonthly = db_get($i,6);

                $Content3 .= "\nTotal (RM), ,$saleweek1,$saleweek2,$saleweek3,$saleweek4,$saleweek5,$salemonthly\n";
            }
        }
        else
        {
            echo "<script> alert('cannot display total sale'); </script>";
        }

        # set the file name and create CSV file
        $FileName = "myezgo - Weekly Sale for ".$monthname." ".$search_year.".csv";
        header('Content-Type: application/csv'); 
        header('Content-Disposition: attachment; filename="' . $FileName . '"'); 
        echo $Content;
        echo $Content2;
        echo $Content3;


    }
    else
    {

        echo "<script>alert('No records found'); </script>";
    }
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>