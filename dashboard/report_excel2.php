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

        vali_redirect('report_car_sale.php'); 
    }

    // echo "<script> alert('masuk excel'); </script>";

    $search_year = $_GET['search_year'];
    $search_month = $_GET['search_month'];
    $search_vehicle = $_GET['search_vehicle'];

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

    $sql = "SELECT
        booking_trans.agreement_no AS agreement_no,
        CONCAT(vehicle.make,' ',vehicle.model) AS carname,
        vehicle.reg_no AS reg_no,
        MIN(sale_log.date) AS initial_date,
        CASE booking_trans.pickup_location
            WHEN '4' THEN 'PORT DICKSON'
            WHEN '5' THEN 'SEREMBAN'
        END AS pickup_location,
        MAX(sale_log.date) AS final_date,
        CASE booking_trans.return_location
            WHEN '4' THEN 'PORT DICKSON'
            WHEN '5' THEN 'SEREMBAN'
        END AS return_location,
        CONCAT(customer.firstname,' ' ,customer.lastname) AS fullname,
        customer.nric_no AS nric_no,
        customer.license_no AS license_no,
        customer.age AS cust_age,
        customer.email AS cust_email,
        customer.phone_no AS cust_phone_no,
        customer.address AS cust_address,
        customer.postcode AS cust_postcode,
        customer.city AS cust_city,
        customer.country AS cust_country,
        user.nickname AS staff_name,
        SUM(sale_log.daily_sale) AS total_sale,
        booking_trans.refund_dep AS refund_dep
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

    if (db_rowcount() > 0) { 
        
        func_setSelectVar(); 
    }

    $Content = "Agreement No., Car Details, Plate No., Pickup Date & Time, Pickup Location, Return Date & Time, Return Location, Cust. Name, NRIC No., License No., Age, Email, Phone No., Address, Postcode, City, Country, Staff Name, Total Sale, Deposit\n";
    if(db_rowcount()>0) { 

        for($i=0;$i<db_rowcount();$i++){
            
            if(func_getOffset()>=10){
                
                $no=func_getOffset()+1+$i;
            }

            else{ 

                $no=$i+1;
            }

            $num = $i +1;

            $agreement_no = db_get($i,0);
            $carname = db_get($i,1);
            $reg_no = db_get($i,2);
            $initial_date = db_get($i,3);
            $pickup_location = db_get($i,4);
            $final_date = db_get($i,5);
            $return_location = db_get($i,6);
            $fullname = db_get($i,7);
            $nric_no = db_get($i,8);
            $license_no = db_get($i,9);
            $cust_age = db_get($i,10);
            $cust_email = db_get($i,11);
            $cust_phone_no = db_get($i,12);
            $cust_address = db_get($i,13);
            $cust_address = str_replace(',', ' ', $cust_address);
            $cust_postcode = db_get($i,14);
            $cust_city = db_get($i,15);
            $cust_country = db_get($i,16);
            $staff_name = db_get($i,17);
            $total_sale = db_get($i,18);
            $refund_dep = db_get($i,19);
            # Title of the CSV
            // $Content = "Car Details, Email,alamat";

            //set the data of the CSV
            // $Content .= "$name, $email, $alamat\n\n\n";
            $Content .= "$agreement_no, $carname, $reg_no, ".date('d/m/Y H:i', strtotime($initial_date)).", $pickup_location, ".date('d/m/Y H:i', strtotime($final_date)).", $return_location, $fullname, $nric_no, $license_no, $cust_age, $cust_email, $cust_phone_no, $cust_address, $cust_postcode, $cust_city, $cust_country, $staff_name, $total_sale, $refund_dep\n";

        }

        # set the file name and create CSV file
        $FileName = "Myezgo - Agreement Sale for ".$monthname." ".$search_year.".csv";
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