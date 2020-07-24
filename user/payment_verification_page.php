<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>MYEZGO Travel & Tours</title>
  
</head>
<body>
<?php

  session_start();
  
  include('_header.php');
  
  if((!isset($_GET['billplz']['id'])) && ($_GET['billplz']['paid'] == NULL || $_GET['billplz']['x_signature'] == NULL))
  {
      
    echo '<script> alert("Payment unsucceeded. Return to agreement")</script>';
    echo "<font color='white'>Something went wrong.</font>";
//    echo "<br><a href='javascript:history.go(-1)'><button class'btn btn-default'>Go back</button></a>";
    echo "<br><a href='rules_confirmation.php'><button class'btn btn-default'>Return</button></a>";

//    echo "<script>
//      window.open('$url');
//      </script>";
  }
  else if((isset($_GET['billplz']['id'])) && ($_GET['billplz']['paid'] == NULL || $_GET['billplz']['x_signature'] == NULL))
  {
      
      $api = '421a747c-6344-463f-aceb-2926767d6a94';
        $bill = $_GET['billplz']['id'];

    require '../vendor/autoload.php';
    $billplz = Billplz\Client::make($api);
    $response = $billplz->bill()->get($bill);
    
//    var_dump($response->getStatusCode(), $response->toArray());
    $response->getStatusCode();
    $response->toArray();

    $huhu = $response->getContent();
    
    $state = $huhu['state'];
    
    if($state == 'deleted' || $state == NULL)
    {
        echo '<script> alert("Payment id does not exist. Return to agreement to create new transaction")</script>';
        vali_redirect('rules_confirmation.php');
    }
    else
    {
        $url = $huhu['url'];
        vali_redirect($url);
    }
  }
  else if((isset($_GET['billplz']['id'])) && ($_GET['billplz']['paid'] != NULL || $_GET['billplz']['x_signature'] != NULL)) {
      
      $payment_id = $_GET['billplz']['id'];
      
      $sql = "SELECT * FROM booking_trans WHERE payment_id='$payment_id'";
      
      db_select($sql);
      
      if(db_rowcount() > 0)
      {
          echo '<script> alert("Payment id is not valid")</script>';
        vali_redirect('rules_confirmation.php');
      }
      
    $api = '421a747c-6344-463f-aceb-2926767d6a94';
        $bill = $_GET['billplz']['id'];

    require '../vendor/autoload.php';
    $billplz = Billplz\Client::make($api);
    $response = $billplz->bill()->get($bill);
    
//    var_dump($response->getStatusCode(), $response->toArray());
    $response->getStatusCode();
    $response->toArray();

    $huhu = $response->getContent();

    $state = $huhu['state'];
    
    if($state =='paid')
    {
        
        $booking = $_SESSION['booking'];
        $cust_class_id = $_SESSION['cust_class_id'];
        $cust_search_pickup_date = conv_datetodbdate($_SESSION['cust_search_pickup_date']);
        $cust_search_pickup_time = $_SESSION['cust_search_pickup_time'];
        $cust_search_return_date = conv_datetodbdate($_SESSION['cust_search_return_date']);
        $cust_search_return_time = $_SESSION['cust_search_return_time'];
        $cust_search_pickup_location = $_SESSION['cust_search_pickup_location'];
        $cust_search_return_location = $_SESSION['cust_search_return_location'];
        $cust_subtotal = $_SESSION['cust_subtotal'];
        $cust_est_total = $_SESSION['cust_est_total'];
        $cust_deposit = $_SESSION['cust_deposit'];
        $cust_day = $_SESSION['cust_day'];
        $cust_status = $_SESSION['cust_status'];
        $checkAddDriver = $_SESSION['checkAddDriver'];
        $checkCdw = $_SESSION['checkCdw'];
        $checkStickerP = $_SESSION['checkStickerP'];
        $checkTouchnGo = $_SESSION['checkTouchnGo'];
        $checkDriver = $_SESSION['checkDriver'];
        $checkCharger = $_SESSION['checkCharger'];
        $checkSmartTag = $_SESSION['checkSmartTag'];
        $checkChildSeat = $_SESSION['checkChildSeat'];
        $checkPickupDelivery = $_SESSION['checkPickupDelivery'];
        $inputPickup = $_SESSION['inputPickup'];
        $inputReturn = $_SESSION['inputReturn'];
            
            $day = dateDifference($cust_search_pickup_date." ".$cust_search_pickup_time, $cust_search_return_date." ".$cust_search_return_time, '%a'); 
            $month = date('m', strtotime($cust_search_pickup_date));
            $mymonth = date('m',time());
            $myday = date('d', time());
            if($month == '01')
            {
              $month_no = $month;
              $month = "jan";
            }
            else if($month == '02')
            {
              $month_no = $month;
              $month = "feb";
            }
            else if($month == '03')
            {
              $month_no = $month;
              $month = "march";
            }
            else if($month == '04')
            {
              $month_no = $month;
              $month = "apr";
            }
            else if($month == '05')
            {
              $month_no = $month;
              $month = "may";
            }
            else if($month == '06')
            {
              $month_no = $month;
              $month = "june";
            }
            else if($month == '07')
            {
              $month_no = $month;
              $month = "july";
            }
            else if($month == '08')
            {
              $month_no = $month;
              $month = "aug";
            }
            else if($month == '09')
            {
              $month_no = $month;
              $month = "sept";
            }
            else if($month == '10')
            {
              $month_no = $month;
              $month = "oct";
            }
            else if($month == '11')
            {
              $month_no = $month;
              $month = "nov";
            }
            else if($month == '12')
            {
              $month_no = $month;
              $month = "dis";
            }
        
            $year = date('Y', strtotime($cust_search_pickup_date));
            
            $sql = "SELECT * FROM booking_trans 
            LEFT JOIN vehicle on booking_trans.vehicle_id = vehicle.id
            WHERE (return_date <= '" . $cust_search_return_date.' '.$cust_search_return_time.':00'."' AND return_date >= 
                '" . $cust_search_pickup_date.' '.$cust_search_pickup_time.':00'."' AND vehicle.class_id = '$cust_class_id')
                OR (pickup_date >= '" . $cust_search_pickup_date.' '.$cust_search_pickup_time.':00'."' AND pickup_date <= 
                '" . $cust_search_return_date.' '.$cust_search_return_time.':00'."' AND vehicle.class_id = '$cust_class_id')
                group by vehicle_id";
                
            // echo "<br>sql 141: ".$sql;
            
            $result = [];
            
            $query=mysqli_query($con,$sql);
            
            while ($row = mysqli_fetch_array($query)) {

               $result[] = $row['vehicle_id'];
            }

            $sqlc = "SELECT * FROM extend 
            LEFT JOIN vehicle on extend.vehicle_id = vehicle.id
            WHERE (extend_to_date   <= '" . $search_return_date.' '.$search_return_time.':00'."' AND extend_to_date  >= 
              '" . $search_pickup_date.' '.$search_pickup_time.':00'."' AND vehicle.class_id = '$cust_class_id') 
              OR (extend_from_date  >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' AND extend_from_date  <= 
              '" . $search_return_date.' '.$search_return_time.':00'."' AND vehicle.class_id = '$cust_class_id')  
              group by vehicle_id";

                  $result2 = [];
                 
                  $query2=mysqli_query($con,$sqlc);

                  while ($row = mysqli_fetch_array($query2)){

                  $result2[] = $row['vehicle_id'];

                  }

                  $list_id=implode(", ", $result);

                  $list_id2=implode(", ", $result2);

                  $list_id3=$list_id.', '.$list_id2;
                  
                //   echo "<br>list_id3: ".$list_id3;

                  $where = ""; 

                  if(($list_id2!='' || $list_id2!=null) && ($list_id!='' || $list_id!=null)){

                  $sql = "SELECT vehicle.id, 
                  vehicle.class_id,
                  SUM(sale_log.$month)
                  FROM vehicle 
                  LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                  LEFT JOIN sale on sale.vehicle_id = vehicle.id
                  LEFT JOIN sale_log on sale.id = sale_log.sale_id
                  WHERE booking_trans.vehicle_id not in ($list_id , $list_id2) 
                  AND sale_log.year = '$year' AND date   <= '" . $year.'-'.$month_no.'-31 23:59'."' AND date  >= 
                  '" . $year.'-'.$month_no.'-01 00:00'."' AND (availability = 'Available' OR availability = 'Booked') AND class_id = '$cust_class_id'
                  GROUP BY vehicle.id
                  ORDER BY SUM(sale_log.$month) ASC";

                  } 

                  elseif (($list_id2=='' || $list_id2==null) && ($list_id!='' || $list_id!=null)) {

                  $sql = "SELECT vehicle.id, 
                  vehicle.class_id,
                  SUM(sale_log.$month)
                  FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                  LEFT JOIN sale on sale.vehicle_id = vehicle.id
                  LEFT JOIN sale_log on sale.id = sale_log.sale_id
                  WHERE booking_trans.vehicle_id not in ($list_id) 
                  AND sale_log.year = '$year' AND date   <= '" . $year.'-'.$month_no.'-31 23:59'."' AND date  >= 
                  '" . $year.'-'.$month_no.'-01 00:00'."' AND (availability = 'Available' OR availability = 'Booked') AND class_id = '$cust_class_id'
                  GROUP BY vehicle.id
                  ORDER BY SUM(sale_log.$month) ASC";

                  }

                  elseif (($list_id2!='' || $list_id2!=null) && ($list_id=='' || $list_id==null)) {

                  $sql = "SELECT vehicle.id, 
                  vehicle.class_id,
                  SUM(sale_log.$month)
                  FROM vehicle 
                  LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                  LEFT JOIN sale on sale.vehicle_id = vehicle.id
                  LEFT JOIN sale_log on sale.id = sale_log.sale_id
                  WHERE booking_trans.vehicle_id not in ($list_id2) 
                  AND sale_log.year = '$year' AND date   <= '" . $year.'-'.$month_no.'-31 23:59'."' AND date  >= 
                  '" . $year.'-'.$month_no.'-01 00:00'."' AND (availability = 'Available' OR availability = 'Booked') AND class_id = '$cust_class_id'
                  GROUP BY vehicle.id
                  ORDER BY SUM(sale_log.$month) ASC";

                  }

                  else{

                  $sql = "SELECT vehicle.id, 
                  vehicle.class_id,
                  SUM(sale_log.$month),
                  COUNT(sale_log.$month)
                  FROM vehicle 
                  LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                  LEFT JOIN sale on sale.vehicle_id = vehicle.id
                  LEFT JOIN sale_log on sale.id = sale_log.sale_id
                  WHERE  sale_log.year = '$year' AND date   <= '" . $year.'-'.$month_no.'-31 23:59'."' AND date  >= 
                  '" . $year.'-'.$month_no.'-01 00:00'."' AND (availability = 'Available' OR availability = 'Booked') AND class_id = '$cust_class_id'
                  GROUP BY vehicle.id
                  ORDER BY SUM(sale_log.$month) ASC ";


                  }
                  
                //   echo "<br>sql: ".$sql;

                  db_select($sql);
                  
                  if(db_rowcount() > 0)
                  {
                      for ($i = 0; $i < db_rowcount(); $i++) {
                          
                        //   echo "<br><br>vehicle_id: ".db_get($i,0);
                        //   echo "<br>sum: ".db_get($i,2);
                        //   echo "<br>count: ".db_get($i,3);
                      }
                  }
                  
            // $sql = "SELECT 
            //   vehicle.id,
            //   availability,
            //   SUM(sale_log.$month) AS sale
            //   FROM vehicle
            //   LEFT JOIN sale on sale.vehicle_id = vehicle.id
            //   LEFT JOIN sale_log on sale.id = sale_log.sale_id
            //   WHERE (availability = 'Available' OR availability = 'Booked') AND sale_log.year = '$year' AND class_id = '$cust_class_id'
            //   GROUP BY vehicle.id
            //   ORDER BY SUM(sale_log.$month) ASC";
            // db_select($sql);
    
            if (db_rowcount() > 0) {
                
                $vehicle_id = db_get(0,0);
            }
            
            $sql = "SELECT * FROM customer WHERE id=".$_SESSION['user_id'];
            db_select($sql);
            
            $subtotal = $cust_subtotal;
        $est_total = $cust_subtotal;
    //    $Discount = $_POST['discount'];
        $search_return_dates = $cust_search_return_date;
        
        $temp_pickup_date = $search_pickup_date.' '.$cust_search_pickup_time.':00';
          $temp_return_date = $search_return_dates.' '.$cust_searh_return_time.':00';
    
    //    $coupon = $_POST['coupon'];
    
          $sql ="SELECT availability FROM vehicle WHERE id =" . $vehicle_id;
          db_select($sql);
    
        if(db_get(0,0) == 'Available')
        {
    
          $sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $vehicle_id; 
          
    //      echo "<br>sql: ".$sql;
          db_update($sql);
        }
    
        $dbcustomer_id = $_SESSION['user_id'];
        
        $sql = "SELECT description, initial from location WHERE id = '" . $cust_search_pickup_location."'";
    
            db_select($sql);
            
            // echo "<br>sql: ".$sql;
    
          if (db_rowcount() > 0) {
    
             // $pickup_location = db_get(0, 1);
                 $pickup_location = db_get(0,0);
             $pickup_initial = db_get(0, 1);
          }
             
            $sql = "INSERT INTO booking_trans
                (
                pickup_date,
                pickup_location,
                pickup_time,
                return_date,
                return_location,
                return_time,
                vehicle_id,
                day,
                sub_total,
                payment_details,
                est_total,
                customer_id,
                created,
                refund_dep,
                refund_dep_payment,
                refund_dep_status,
                type,
                balance,
                available,
                branch,
                staff_id,
                insert_type,
                payment_id
                )
                VALUES
                (
                '" . $cust_search_pickup_date." ".$cust_search_pickup_time."',
                '$cust_search_pickup_location',
                '$cust_search_pickup_time',
                '" .$search_return_dates." ".$cust_search_return_time."',
                '$cust_search_return_location',
                '".$cust_search_return_time."',
                '$vehicle_id',
                '$day',
                '$subtotal',
                'Online',
                '$est_total',
                '$dbcustomer_id',
                '".date('Y-m-d H:i:s',time())."',
                '$cust_deposit',
                'Online',
                'Paid',
                0,
                '$subtotal',
                'Booked',
                '".$pickup_location."',
                '0',
                'Customer',
                '$payment_id'
                )
            ";
            
            // echo "<br>sql: ".$sql;
                
            db_update($sql);
    
      $booking_id = mysqli_insert_id($con);
      
      $agent='000';
    
          if($booking_id<10){
    
              $agr_no='000'.$booking_id;
          }
    
          elseif ($booking_id<100) {
              
              $agr_no='00'.$booking_id;
          }
    
          elseif ($booking_id<1000) {
              
              $agr_no='0'.$booking_id;
          }
    
          elseif ($booking_id<10000) {
              
              $agr_no=$booking_id;
          }
    
        $agreement_no=$pickup_initial.$agent.$mymonth.$myday.$agr_no;
    
        // echo $agreement_no;
    
        $sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;
    
            db_update($sql);
            // echo "<br>1118) masuk booking trans update pickup, agreement no: ".$agreement_no." booking id: ".$booking_id;
    
        $sql = "INSERT INTO checklist
      (
          booking_trans_id,
          car_out_sticker_p,
          car_out_child_seat,
          car_out_usb_charger,
          car_out_touch_n_go,
          car_out_smart_tag,
          car_add_driver,
          car_cdw,
          car_driver
      )
      VALUES
      (
          '$booking_id',
          '" . $checkStickerP . "',
          '" . $checkChildSeat . "',
          '" . $checkCharger . "',
          '" . $checkTouchnGo . "',
          '" . $checkSmartTag . "',
          '" . $checkAddDriver . "',
          '" . $checkCdw . "',
          '" . $checkDriver . "'
      )";
      
//      echo "<br>sql: ".$sql;
      
      db_update($sql);
        
        // echo "<script> alert('db deposit: ".$dbcar_rate_deposit."'); </script>";
        // echo "<script> alert('user deposit: ".$cust_deposit."'); </script>";
        
        
          $sql = "INSERT INTO sale 
          (
            title,
            type,
            booking_trans_id,
            vehicle_id,
            total_day,
            deposit,
            payment_type,
            payment_status,
            pickup_date,
            return_date,
            staff_id,
            created
          )
          VALUES (
            'Booking Deposit in (customer)',
            'Booking',
            '$booking_id',
            '$vehicle_id',
            '$day',
            '$cust_deposit',
            'Online',
            'Paid',
            '" . $cust_search_pickup_date.' '.$cust_search_pickup_time."',
            '" . $cust_search_return_date.' '.$cust_search_return_time."',
            '0',
            '".date('Y-m-d H:i:s',time())."'
          )";
            
              db_update($sql);
            
            // echo "<br>sql: ".$sql;
            
              echo '<script> alert("Successfully booking!")</script>';
              
              vali_redirect('mail.php?booking_id='.$booking_id);
    }
    else {
        
        echo '<script> alert("Payment unsuccessful")</script>';
        
        vali_redirect('rules_confirmation.php');
    }
  }
    ?>
    </body>
</html>