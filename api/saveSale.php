<?php

    $response = array();
    include 'db/db_connect.php';

    //Get the input request parameters
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE); //convert JSON into array

    $sale_sql = "";
    $booking_sql = "";
    
    $search_pickup_date = $input["pickup_date"];
    
    $pickup_date = date('Y-m-d', strtotime($search_pickup_date));
    $pickup_time = $input["pickup_time"];
    $return_date = $input["return_date"];
    $return_time = $input["return_time"];
    $depositStatus = $input["depositStatus"];
    $sendDeposit = $input["sendDeposit"];
    $payment_amount = $input["payment_amount"];

    $est_total2 = $payment_amount;
            
    $search_pickup_date2 = $input["pickup_date2"];
    $pickup_time2 = $input["pickup_time2"];
    $return_date2 = $input["return_date2"];
    $return_time2 = $input["return_time2"];
    $depositStatus2 = $input["depositStatus2"];
    $sendDeposit2 = $input["sendDeposit2"];
    $payment_amount2 = $input["payment_amount2"];

    $booking_id = $input['booking_id'];

    $agent_id = $input["agent_id"];

    $sale_edit2 = $input["boolSale"];
    $date_edit2= $input["boolDate"];

    $sale_pickup_time = $pickup_time2;
    $sale_pickup_date = $search_pickup_date2. " ".$pickup_time2 . ":00";
    $sale_return_time = $return_time2;
    $sale_return_date = $return_date2. " ".$return_time2 . ":00";

    $subTotal = $input["subTotal"];
    $estTotal = $input["estTotal"];

    $sub_total2 = $input["subTotal2"];
    $estTotal2 = $input["estTotal2"];

    $user_id = $input["user_id"];

    $sale_id2 = $input["sale_id2"];

    $class_id = $input["class_id"];

    $vehicle_id = $input["vehicle_id"];

    $refund_dep2 = $sendDeposit;
    $refund_dep_payment2 = $depositStatus;

    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

    if($sale_edit2 == 'true') // no need
    {
        $sale2 = $payment_amount;
        $sale_pickup_time = $pickup_time2;
        $sale_pickup_date = $search_pickup_date2. " ".$pickup_time2;
        $sale_return_time = $return_time2;
        $sale_return_date = $return_date2. " ".$return_time2;
    }
    else
    {
        if($agent_id != '0')
        {
        $sale2 = $sub_total2;
        }
        else
        {
        $sale2 = $est_total2;
        }

        $refund_dep2 = $sendDeposit2;
        $refund_dep_payment2 = $depositStatus2;
    }

    if($date_edit2 == 'true')
    {
        $sale_pickup_time = $pickup_time;
        $sale_pickup_date = $search_pickup_date. " ".$pickup_time . ":00";
        $sale_return_time = $return_time;
        $sale_return_date = $return_date. " ".$return_time . ":00";

        $booking_sql = " pickup_date = '".$sale_pickup_date."', return_date = '".$sale_return_date."', pickup_time = '".$sale_pickup_time.":00', return_time = '".$sale_return_time.":00', ";

        $sale_sql = " pickup_date = '".$sale_pickup_date."', return_date = '".$sale_return_date."',";

    }

    $day = dateDifference($sale_pickup_date, $sale_return_date, '%a');

    if($agent_id != '0')
    {
        // kat sini nak buat kira2 utk agent

        $day_agent = $day;
        
        $sql = "SELECT * FROM agent_rate";

        $query=mysqli_query($con,$sql);

        if(mysqli_num_rows($query)>0){

          while ($row = mysqli_fetch_array($query)){

              $perhour = $row['perhour'];
              $fivehour = $row['fivehour'];
              $halfday = $row['halfday'];
              $oneday = $row['oneday'];
              $twoday = $row['twoday'];
              $threeday = $row['threeday'];
              $fourday = $row['fourday'];
              $fiveday = $row['fiveday'];
              $sixday = $row['sixday'];
              $weekly = $row['weekly'];
              $monthly = $row['monthly'];

          }  
      }


        if($day_agent < 1)
        {
        if($time < 5 || ($time > 5 && $time < 12))
        {
            $profit = $perhour;
        }
        else if($time == 5)
        {
            $profit = $fivehour;
        }
        else if($time >= 12)
        {
            $profit = $halfday;
        }
        }
        else if($day_agent == 1)
        {
        $profit = $oneday;
        }
        else if($day_agent == 2)
        {
        $profit = $twoday;
        }
        else if($day_agent == 3)
        {
        $profit = $threeday;
        }
        else if($day_agent == 4)
        {
        $profit = $fourday;
        }
        else if($day_agent == 5)
        {
        $profit = $fiveday;
        }
        else if($day_agent == 6)
        {
        $profit = $sixday;
        }
        else if($day_agent >= 7 && $day_agent < 30)
        {
        $profit = $weekly;
        }
        else if($day_agent == 30)
        {
        $profit = $monthly;
        }

        $agent_profit = $sale2 * ($profit/100);
        
        if($day_agent > 30)
        {

        $agent_profit = $dbcar_rate_monthly * ($monthly/100);
        
        $day_agent = $day_agent - 30;

        if($day_agent < 1)
        {
            if($time < 5 || ($time > 5 && $time < 12))
            {
            $profit = $perhour;
            }
            else if($time == 5)
            {
            $profit = $fivehour;
            }
            else if($time >= 12)
            {
            $profit = $halfday;
            }
        }
        else if($day_agent == 1)
        {
            $profit = $oneday;
        }
        else if($day_agent == 2)
        {
            $profit = $twoday;
        }
        else if($day_agent == 3)
        {
            $profit = $threeday;
        }
        else if($day_agent == 4)
        {
            $profit = $fourday;
        }
        else if($day_agent == 5)
        {
            $profit = $fiveday;
        }
        else if($day_agent == 6)
        {
            $profit = $sixday;
        }
        else if($day_agent >= 7 && $day_agent < 30)
        {
            $profit = $weekly;
        }
        else if($day_agent == 30)
        {
            $profit = $monthly;
        }

        include('profit_calculation.php');

        $agent_profit = $agent_profit + ($agent_subtotal * ($profit/100));
        }

        if($sale_id2 != '' OR $sale_id2 != null)
        {
        $sale2 = $sub_total2;
        }

        $est_total2 = $sale2 - $agent_profit;
        
        $sql = "UPDATE booking_trans SET
            ".$booking_sql."
            sub_total = '$sale2',
            est_total = '$est_total2',
            refund_dep = '$refund_dep2',
            refund_dep_payment = '$refund_dep_payment2'
            WHERE id = '$booking_id'
        ";

        $sale2 = $est_total2;
    }
    else
    {

      // this is problems
        
        $sql = "UPDATE booking_trans SET
            ".$booking_sql."
            est_total = '$sale2',
            refund_dep = '$sendDeposit',
            refund_dep_payment = '$depositStatus'
            WHERE id = '$booking_id'
        ";
    }

    mysqli_query($con,$sql);

    if($sale_id2 != '' OR $sale_id2 != null)
    {
        $sql = "UPDATE sale SET
            total_sale = '$sale2',
            ".$sale_sql."
            total_day = '$day',
            mid = '".$user_id."',
            modified = '".date('Y-m-d H:i:s', time())."'
            WHERE id = '$sale_id2'
        ";
        

        mysqli_query($con,$sql);
        
    }

    $sql = "UPDATE sale SET
            deposit = '$refund_dep2',
            ".$sale_sql."
            mid = '".$user_id."',
            modified = '".date('Y-m-d H:i:s', time())."'
            WHERE booking_trans_id = '$booking_id' AND type = 'Booking'
        ";

        mysqli_query($con,$sql);

        $sql = "SELECT * FROM sale WHERE booking_trans_id = '$booking_id' AND type = 'Return'";

        $query=mysqli_query($con,$sql);

        if(mysqli_num_rows($query)>0){

            $sql = "UPDATE sale SET
                    deposit = '-$refund_dep2',
                    ".$sale_sql."
                    mid = '".$user_id."',
                    modified = '".date('Y-m-d H:i:s', time())."'
                    WHERE booking_trans_id = '$booking_id' AND type = 'Return'
                ";

            mysqli_query($con,$sql);

        }

        $sql = "DELETE FROM sale_log WHERE sale_id ='$sale_id2'";

        mysqli_query($con,$sql);

        $sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 

        $query=mysqli_query($con,$sql);

        if(mysqli_num_rows($query)>0){

            while ($row = mysqli_fetch_array($query)){

                $class_id = $row['class_id'];
                $oneday = $row['oneday'];
                $twoday = $row['twoday'];
                $threeday = $row['threeday'];
                $fourday = $row['fourday'];
                $fiveday = $row['fiveday'];
                $sixday = $row['sixday'];
                $weekly = $row['weekly'];
                $monthly = $row['monthly'];
                $hour = $row['hour'];
                $halfday = $row['halfday'];
                $deposit = $row['deposit'];

        
            }

            $dbcar_rate_class_id = $class_id;
            $dbcar_rate_oneday = $oneday;
            $dbcar_rate_twoday = $twoday;
            $dbcar_rate_threeday = $threeday;
            $dbcar_rate_fourday = $fourday;
            $dbcar_rate_fiveday = $fiveday;
            $dbcar_rate_sixday = $sixday;
            $dbcar_rate_weekly = $weekly;
            $dbcar_rate_monthly = $monthly;
            $dbcar_rate_hour = $hour;
            $dbcar_rate_halfday = $halfday;
            $dbcar_rate_deposit = $deposit;

        }

        $sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'";

        $pickup_date = date('m/d/Y', strtotime($sale_pickup_date));
        $pickup_time = date('H:i', strtotime($sale_pickup_date));
        $return_date = date('m/d/Y', strtotime($sale_return_date));
        $return_time = date('H:i', strtotime($sale_return_date));
        $day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a');

        $daylog = '0';
        $datelog = date('Y/m/d', strtotime($pickup_date)).' '.$pickup_time;

        $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
        $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
        $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h'); 

        $a = 0;

        $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

        while($datelog <= $datenew){

            // echo "<br><br><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<LOOP>>>>>>>>>>>>>>>>>>>>>>>>>>";
                              // echo "<br><br>1641) datelog: ".$datelog;
                              
                              $currdate = date('Y-m-d',strtotime($datelog)).' '.$return_time;
                              
                              // echo "<br> return date: ".date('m/d/Y', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00";

                              $daydiff = dateDifference($datelog, date('m/d/Y', strtotime($return_date)).' '.$pickup_time, '%a'); 

                              $mymonth = date("m",strtotime($datelog));
                              $myyear = date("Y",strtotime($datelog));

                              // echo "<br><br>1656)year: ".$myyear;

                              // echo "<br><br>1656)normal date:".date("d/m/Y",strtotime($datelog));

                              $week1date1 = date('Y/m/d', strtotime($mymonth.'/01/'.$myyear))." 00:00:00";
                                $week1date2 = date('Y/m/d', strtotime($mymonth.'/07/'.$myyear))." 23:59:59";
                                $week2date1 = date('Y/m/d', strtotime($mymonth.'/08/'.$myyear))." 00:00:00";
                                $week2date2 = date('Y/m/d', strtotime($mymonth.'/14/'.$myyear))." 23:59:59";
                                $week3date1 = date('Y/m/d', strtotime($mymonth.'/15/'.$myyear))." 00:00:00";
                                $week3date2 = date('Y/m/d', strtotime($mymonth.'/21/'.$myyear))." 23:59:59";
                                $week4date1 = date('Y/m/d', strtotime($mymonth.'/22/'.$myyear))." 00:00:00";
                                $week4date2 = date('Y/m/d', strtotime($mymonth.'/28/'.$myyear))." 23:59:59";
                                $week5date1 = date('Y/m/d', strtotime($mymonth.'/29/'.$myyear))." 00:00:00";
                                $week5date2 = date('Y/m/d', strtotime($mymonth.'/31/'.$myyear))." 23:59:59";

                              if($mymonth == '1')
                              {

                                $monthname = 'jan';
                              }
                              else if($mymonth == '2')
                              {

                                $monthname = 'feb';
                              }
                              else if($mymonth == '3')
                              {

                                $monthname = 'march';
                              }
                              else if($mymonth == '4')
                              {

                                $monthname = 'apr';
                              }
                              else if($mymonth == '5')
                              {

                                $monthname = 'may';
                              }
                              else if($mymonth == '6')
                              {

                                $monthname = 'june';
                              }
                              else if($mymonth == '7')
                              {

                                $monthname = 'july';
                              }
                              else if($mymonth == '8')
                              {

                                $monthname = 'aug';
                              }
                              else if($mymonth == '9')
                              {

                                $monthname = 'sept';
                              }
                              else if($mymonth == '10')
                              {

                                $monthname = 'oct';
                              }
                              else if($mymonth == '11')
                              {

                                $monthname = 'nov';
                              }
                              else if($mymonth == '12')
                              {

                                $monthname = 'dec';
                              }

                              if($datelog >= $week1date1 && $datelog <= $week1date2)
                                {

                                    $week = 'week1';
                                }

                                else if($datelog >= $week2date1 && $datelog <= $week2date2)
                                {

                                    $week = 'week2';
                                }

                                else if($datelog >= $week3date1 && $datelog <= $week3date2)
                                {
                                    
                                    $week = "week3";
                                }

                                else if($datelog >= $week4date1 && $datelog <= $week4date2)
                                {

                                    $week = 'week4';
                                }

                                else if($datelog >= $week5date1 && $datelog <= $week5date2)
                                {

                                    $week = 'week5';
                                }

                              if($hourlog != '0' && ($sale_id2 != '' OR $sale_id2 != null))
                              {
                                  
                                if($time < 5)
                                {
                                  $daily_sale = $sale2;
                                }
                                
                                else if($time < 8 && $time >= 5){

                                  $daily_sale = $time * $dbcar_rate_hour; 
                                }

                                else if($time >= 8 && $time <= 12) {

                                  $daily_sale = $dbcar_rate_halfday;
                                } 

                                else if($time >= 13){ 

                                  $difference_hour = $time - 12;
                                  $daily_sale = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
                                            80 + 80;
                                }

                                if($sale2 < $daily_sale)
                                {
                                  $daily_sale = $sale2;
                                }

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  hour,
                                  type,
                                  ".$week.",
                                  ".$monthname.",
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id2',
                                  '$daily_sale',
                                  '0',
                                  '$hourlog',
                                  'hour',
                                  '$daily_sale',
                                  '$daily_sale',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                mysqli_query($con,$sql);

                                $est_total = $sale2 - $daily_sale;

                                $hourlog = '0';
                              }
                              
                              else if($hourlog == '0' && $a == '0' && ($sale_id2 != '' OR $sale_id2 != null))
                              {

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  hour,
                                  ".$week.",
                                  type,
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id2',
                                  '0',
                                  '0',
                                  '0',
                                  '0',
                                  'firstday',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                mysqli_query($con,$sql);

                                $est_total = $sale2;

                              }
                              
                              else if($hourlog == '0' && $a > 0 && ($sale_id2 != '' OR $sale_id2 != null))
                              {

                                $daily_sale = $est_total / $day;

                                $daylog = $daylog + 1;

                                $sql = "INSERT INTO sale_log 
                                (
                                  sale_id,
                                  daily_sale,
                                  day,
                                  type,
                                  hour,
                                  ".$week.",
                                  ".$monthname.",
                                  year,
                                  date,
                                  created
                                )
                                VALUES (
                                  '$sale_id2',
                                  '$daily_sale',
                                  '$daylog',
                                  'day',
                                  '0',
                                  '$daily_sale',
                                  '$daily_sale',
                                  '$myyear',
                                  '$currdate',
                                  '".date('Y-m-d H:i:s',time())."'
                                )";

                                mysqli_query($con,$sql);

                              }

                              $datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$pickup_time;

                              $a = $a +1;
                                    // window.location.href='reservation_list_view.php?booking_id=$booking_id';

                            //   echo "<script>
                            //       window.alert('Normal sale has been successfully modified');
                            //       </script>";



        }



    $response["message"] = "abc";

    $response["status"] = 0;

    echo json_encode($response);


?>