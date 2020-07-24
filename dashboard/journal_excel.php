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

    $search_date = $_GET['search_date'];

    $where = " AND DATE_FORMAT(sale.created, '%d-%m-%Y') LIKE '%".$search_date."%'";

    if($search_branch!=""){ 
    
        $where2 = " AND booking_trans.branch = '$search_branch'";
    }

    $sql = "SELECT 
        agreement_no,
        reg_no,
        sale.title AS title,
        concat(make, ' ', model) AS car,
        DATE_FORMAT(sale.created, '%d-%m-%Y %H:%i:%s') AS created,
        SUM(sale_log.daily_sale) AS total_sale,
        payment_details,
        sale.deposit AS deposit,
        refund_dep_payment
        FROM booking_trans
        LEFT JOIN sale ON booking_trans.id = sale.booking_trans_id
        LEFT JOIN vehicle ON sale.vehicle_id = vehicle.id
        LEFT JOIN sale_log ON sale.id = sale_log.sale_id
        WHERE booking_trans.id IS NOT NULL
        ".$where.$where2."
        GROUP BY sale.id
        ORDER BY sale.id ASC
    ";

    db_select($sql); 

    $Content = "Agreement No., Plate Number, Title, Model, Date & Time, Rental Amount, Rental Payment Type, Deposit Amount, Deposit Payment Type\n";
    // $Content = "Agreement No.; Plate Number; Title; Model; Date & Time; Rental Amount; Rental Payment Type; Deposit Amount; Deposit Payment Type\n";
    if(db_rowcount()>0) { 

        for($i=0;$i<db_rowcount();$i++){
            
            if(func_getOffset()>=10){
                
                $no=func_getOffset()+1+$i;
            }

            else{ 

                $no=$i+1;
            }

            $agreement_no = db_get($i,0);
            $platenumber = db_get($i,1);
            $title = db_get($i,2);
            $model = db_get($i,3);
            $datetime = db_get($i,4);
            $rental_amount = db_get($i,5);

            if($rental_amount == '' || $rental_amount == '0')
            {
                $rental_amount = '0';
            }
            $rental_payment_type = db_get($i,6);
            $deposit_amount = db_get($i,7);
            $deposit_payment_type = db_get($i,8);

            # Title of the CSV
            // $Content = "Car Details, Email,alamat";

            //set the data of the CSV
            // $Content .= "$name, $email, $alamat\n\n\n";
            $Content .= "$agreement_no, $platenumber, $title, $model, $datetime, $rental_amount, $rental_payment_type, $deposit_amount, $deposit_payment_type\n";
            // $Content .= "$agreement_no; $platenumber; $title; $model; $datetime; $rental_amount; $rental_payment_type; $deposit_amount; $deposit_payment_type\n";

        }

        $sql = "SELECT
        SUM(sale_log.daily_sale) AS total_sale
        FROM sale
        LEFT JOIN sale_log ON sale.id = sale_log.sale_id
        AND DATE_FORMAT(sale.created, '%d-%m-%Y') LIKE '%".$search_date."%'
        ";

        db_select($sql);

        if(db_rowcount()>0) { 
            $total = 0;
            for($i=0;$i<db_rowcount();$i++){
                
                if(func_getOffset()>=10){
                    
                    $no=func_getOffset()+1+$i;
                }

                else{ 

                    $no=$i+1;
                }

                $Content2 .= "\nTotal (RM); ; ; ; ; ".db_get($i,0)."\n";
            }
        }
        else
        {
            echo "<script> alert('cannot display total sale'); </script>";
        }

        # set the file name and create CSV file

        // $search_date = date('d-m-Y',strtotime($search_date));
        $FileName = "MYEZGO - Daily Sale Journal for ".$search_date.".csv";
        header('Content-Type: application/csv'); 
        header('Content-Disposition: attachment; filename="' . $FileName . '"'); 
        echo $Content;
        echo $Content2;


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