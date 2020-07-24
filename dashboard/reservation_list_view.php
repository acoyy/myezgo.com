<?php
session_cache_limiter('');
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");

// $page = $_SERVER['PHP_SELF'];
// $sec = "10";
// header("Refresh: $sec; url=$page");

// header("Cache-Control: no-cache, must-revalidate");


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
  include ("_header.php");

  func_setReqVar(); 

  $sql = "SELECT agreement_no FROM booking_trans WHERE id=".$_GET['booking_id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 

  $sql = "SELECT * FROM upload_data WHERE BOOKING_TRANS_ID=".$_GET['booking_id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

  } 


  $sql = "SELECT * FROM user WHERE id=".$_SESSION['cid']; 
  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

  } 



    $id = $_GET['booking_id']; 
    $class_id = $_GET['class_id'];

    $sql="SELECT vehicle_id FROM booking_trans WHERE id=".$id;
    db_select($sql); 
    
    for ($i = 0; $i < db_rowcount(); $i++) { 

      $vehicle_id = db_get($i,0);     

    }

    $sql="SELECT class_id FROM vehicle WHERE id=".$vehicle_id;
    db_select($sql); 
    
    for ($i = 0; $i < db_rowcount(); $i++) { 

      $class_id = db_get($i,0);

    }

    if(!isset($_POST['start_engine'])){ 

      $start_engine = "X"; 

    } 

    if(!isset($_POST['no_alarm'])) { 

      $no_alarm = "X"; 

    } 

    if(!isset($_POST['air_conditioner'])){ 

      $air_conditioner = "X"; 

    } 

    if(!isset($_POST['radio'])){ 

      $radio = "X"; 

    } 

    if(!isset($_POST['power_window'])){ 
  
      $power_window = "X"; 

    } 

    if(!isset($_POST['window_condition'])){ 

      $window_condition = "X"; 

    } 

    if(!isset($_POST['perfume'])){ 

      $perfume = "X"; 

    } 

    if(!isset($_POST['carpet'])){ 

      $carpet = "X"; 

    } 

    if(!isset($_POST['sticker'])){ 

      $sticker = "X"; 

    } 

    if(!isset($_POST['lamp'])){ 

      $lamp = "X"; 

    } 

    if(!isset($_POST['engine_condition'])){ 

      $engine_condition = "X"; 

    } 

    if(!isset($_POST['tyres_condition'])){ 

      $tyres_condition = "X"; 

    } 

    if(!isset($_POST['jack'])){ 

      $jack = "X"; 

    } 

    if(!isset($_POST['tools'])){ 

      $tools = "X"; 

    } 

    if(!isset($_POST['signage'])){ 

      $signage = "X"; 

    } 

    if(!isset($_POST['child_seat'])){ 

      $child_seat = "X"; 

    } 

    if(!isset($_POST['wiper'])){ 

      $wiper = "X"; 

    } 

    if(!isset($_POST['gps'])){ 

      $gps = "X"; 

    } 

    if(!isset($_POST['tyre_spare'])){ 

      $tyre_spare = "X"; 

    } 

    if(!isset($_POST['usb_charger'])){ 

      $usb_charger = "X"; 

    } 

    if(!isset($_POST['touch_n_go'])){ 

      $touch_n_go = "X"; 
    } 

    if(!isset($_POST['smart_tag'])){ 

      $smart_tag = "X"; 
    }
          
    if(isset($_POST['btn_registered_cust'])){

      $sql = "SELECT id AS cust_id FROM customer WHERE status = 'B' AND nric_no = ".$_POST['nric_no'];
      db_select($sql); 

      if (db_rowcount() > 0) { 

        echo "<script> alert('Rental could not be continued as the NRIC No. entered has been blacklisted'); </script>";

        echo "<script>
            window.location.href='reservation_list_view.php?booking_id=".$_GET['booking_id']."&nric_blacklisted=".$_POST['nric_no']."';
          </script>";

      }
      else
      {

        $sql = "SELECT id AS cust_id FROM customer WHERE nric_no = ".$_POST['nric_no'];
        
        db_select($sql); 

        func_setSelectVar(); 

        if (db_rowcount() > 0) { 

          if($_POST['customer_id'] == $cust_id)
          {

            $cust_id = $_POST['customer_id'];

            $extra = "";
          }
          else
          {

            $cust_id = $cust_id;

            $extra = ", customer_id = '$cust_id'";

          }
          
          if(isset($_FILES['identity_photo'])){ 

            foreach($_FILES['identity_photo']['tmp_name'] as $key => $tmp_name ){ 

              if($key == 0) {
                
                $file_name = $cust_id."-identity_photo_front.jpg"; 
              } 
              else if($key == 1) {

                $file_name = $cust_id."-identity_photo_back.jpg"; 
              } 
              else if($key == 2) {
                
                $file_name = $cust_id."-utility_photo.jpg"; 
              } 
              else if($key == 3) {
                
                $file_name = $cust_id."-working_photo.jpg"; 
              }

              $file_size =$_FILES['identity_photo']['size'][$key]; 

              $file_tmp =$_FILES['identity_photo']['tmp_name'][$key]; 

              $file_type=$_FILES['identity_photo']['type'][$key]; 

              $sql = "SELECT * FROM customer WHERE id = '$cust_id'";

              db_select($sql);

              if(db_rowcount()>0) {

                if($key == 0) {

                  $sql = "UPDATE customer SET identity_photo_front = '$file_name' WHERE id = '$cust_id'";
                } 
                else if($key == 1) {

                  $sql = "UPDATE customer SET identity_photo_back = '$file_name' WHERE id = '$cust_id'";
                } 
                else if($key == 2) {

                  $sql = "UPDATE customer SET utility_photo = '$file_name' WHERE id = '$cust_id'";
                } 
                else if($key == 3) {

                  $sql = "UPDATE customer SET working_photo = '$file_name' WHERE id = '$cust_id'";
                }
              }

              db_update($sql); 
              // echo "<br>file_name: ".$file_name;
              // echo "<br>$key ----- sql: ".$sql;

              $desired_dir="assets/img/customer";

              if(is_dir($desired_dir)==false){ 

                mkdir("$desired_dir", 0700); 

              } 

              if(is_dir("$desired_dir/".$file_name)==false){ 

                move_uploaded_file($file_tmp,"$desired_dir/".$file_name); 
              }

              else{ 

                $new_dir="$desired_dir/".$file_name.time(); 

                rename($file_tmp,$new_dir) ; 
              } 
            }
          }

          $sql = "UPDATE customer SET 
              title='" . $title . "',
              firstname='" . $firstname . "',
              lastname='" . $lastname . "',
              nric_no='" . $nric_no . "',
              license_no='" . $license_no . "',
              license_exp='" . $license_exp . "',
              age='".$age."',
              phone_no='" . $phone_no . "',
              phone_no2='" . $phone_no2 . "',
              email='" . $email . "',
              address='" . $address . "',
              postcode='" . $postcode . "',
              city='" . $city . "',
              country='" . $country . "',
              status='A',
              mid= " . $_SESSION['cid'] . ",
              mdate='".date('Y-m-d H:i:s',time())."',
              ref_name='" . $ref_name . "',
              ref_phoneno='" . $ref_phoneno . "',
              ref_relationship='" . $ref_relationship . "',
              ref_address='" . $ref_address . "',
              drv_name='" . $drv_name . "',
              drv_nric='" . $drv_nric . "',
              drv_address='" . $drv_address . "',
              drv_phoneno='" . $drv_phoneno . "',
              drv_license_no='" . $drv_license_no . "',
              drv_license_exp='" . $drv_license_exp . "',
              survey_type='".$survey_type."',
              survey_details='" . $survey_details . "'
              WHERE id='".$cust_id."'
            ";

          db_update($sql);

          $sql = "UPDATE booking_trans SET balance = '$payment_amount', refund_dep_payment='$refund_dep_payment', payment_details='$payment_details',refund_dep='$deposit'".$extra." WHERE id = $id"; 

          db_update($sql); 

          echo "<script> alert('Customer has been editted'); </script>";

          echo "<script>
              window.location.href='reservation_list_view.php?booking_id=".$_GET['booking_id']."';
            </script>";
        }
        else
        {

          echo "<script> alert('Please choose Change Customer to add new customer'); </script>";
        }
      }
    
    }
          
    if(isset($_POST['btn_change_cust'])){

      $sql = "SELECT id AS cust_id FROM customer WHERE status = 'A' AND nric_no = ".$_POST['nric_no'];
      db_select($sql);

      if (db_rowcount() > 0) { 

        func_setSelectVar();

        $sql = "UPDATE customer SET title = '$title', firstname = '$firstname', lastname= '$lastname', license_no = '$license_no', license_exp = '$license_exp', age = '$age', phone_no = '$phone_no', phone_no2 = '$phone_no2', email = '$email', address = '$address', postcode = '$postcode', city = '$city', country = '$country', ref_name = '$ref_name', ref_relationship = '$ref_relationship', ref_phoneno = '$ref_phoneno', ref_address = '$ref_address', drv_name = '$drv_name', drv_nric = '$drv_nric', drv_address = '$drv_address', drv_phoneno = '$drv_phoneno', drv_license_no = '$drv_license_no', drv_license_exp = '$drv_license_exp', survey_type = '$survey_type', mid = '".$_SESSION['cid']."', mdate = '".date('Y-m-d H:i:s',time())."' WHERE nric_no = '$nric_no'"; 

        db_update($sql);

        $sql = "UPDATE booking_trans SET balance = '$payment_amount', refund_dep_payment='$refund_dep_payment', payment_details='$payment_details',refund_dep='$deposit', customer_id = '$cust_id' WHERE id = $id"; 

        db_update($sql); 

        echo "<script>
            window.location.href='reservation_list_view.php?booking_id=".$_GET['booking_id']."';
          </script>";

      }
      else
      {

        $sql = "INSERT INTO customer 
              (
                title, 
                firstname, 
                lastname, 
                nric_no, 
                license_no, 
                license_exp, 
                age, 
                phone_no, 
                phone_no2, 
                email, 
                address, 
                postcode, 
                city, 
                country, 
                status, 
                ref_name, 
                ref_phoneno, 
                ref_relationship, 
                ref_address, 
                drv_name, 
                drv_nric, 
                drv_address, 
                drv_phoneno, 
                drv_license_no, 
                drv_license_exp, 
                survey_type, 
                survey_details,
                cid,
                cdate
              ) 
              VALUES 
              (
                '$title',
                '$firstname', 
                '$lastname', 
                '$nric_no', 
                '$license_no', 
                '$license_exp', 
                '$age', 
                '$phone_no', 
                '$phone_no2', 
                '$email',
                '$address',
                '$postcode',
                '$city',
                '$country',
                'A',
                '$ref_name',
                '$ref_phoneno',
                '$ref_relationship',
                '$ref_address',
                '$drv_name',
                '$drv_nric',
                '$drv_address',
                '$drv_phoneno',
                '$drv_license_no',
                '$drv_license_exp',
                '$survey_type',
                '$survey_details',
                '".$_SESSION['cid']."',
                '".date('Y-m-d H:i:s',time())."'
              )";

        db_update($sql);

        $cust_id = mysqli_insert_id($con);

        $sql = "UPDATE booking_trans SET balance = '$payment_amount', refund_dep_payment='$refund_dep_payment', payment_details='$payment_details',refund_dep='$deposit', customer_id = '$cust_id' WHERE id = $id"; 

        db_update($sql); 

        echo "<script>
            window.location.href='reservation_list_view.php?booking_id=".$_GET['booking_id']."';
          </script>";
      }
    
    }

          $_SESSION['customer_id'] = $customer_id;
    


          if (isset($_POST['btn_in'])) {

            $upload_dir = "assets/img/"; 
            $img = $_POST['hidden_data']; 
            $img = str_replace('data:image/png;base64,', '', $img); 
            $img = str_replace(' ', '+', $img); 
            $data = base64_decode($img); 
            $file = $upload_dir . "return" . $id . ".png"; 
            $success = file_put_contents($file, $data); 

            $sql = "UPDATE checklist SET car_in_start_engine = '$start_engine', car_in_no_alarm = '$no_alarm', car_in_air_conditioner = '$air_conditioner', car_in_radio = '$radio', car_in_power_window = '$power_window', car_in_window_condition = '$window_condition', car_in_perfume = '$perfume', car_in_carpet = '$carpet', car_in_sticker_p = '$sticker', car_in_lamp = '$lamp', car_in_engine_condition = '$engine_condition', car_in_tyres_condition = '$tyres_condition', car_in_jack = '$jack', car_in_tools = '$tools', car_in_signage = '$signage', car_in_child_seat = '$child_seat', car_in_wiper = '$wiper', car_in_gps = '$gps', car_in_tyre_spare = '$tyre_spare', car_in_usb_charger = '$usb_charger', car_in_touch_n_go = '$touch_n_go', car_in_smart_tag = '$smart_tag', car_in_seat_condition = '$car_seat_condition', car_in_cleanliness = '$cleanliness', car_in_fuel_level = '$fuel_level', car_in_image = '$file', car_in_remark = '$remark_return', car_in_checkby = '$name' WHERE booking_trans_id = $id"; 

            db_update($sql);

            $where = "";

            if($excess == 'true')
            {
              // echo "ada excess";

              if($disc_coup != '')
              {
                $sql = "SELECT value_in,rate FROM discount WHERE id = '$disc_coup'"; 
                db_select($sql); 

                if (db_rowcount() > 0) { 

                  func_setSelectVar(); 

                }

                if($value_in == "A")
                {
                  if($excess_payment > $rate)
                  {
                    $excess_payment = $excess_payment - $rate;
                  }
                  else if ($excess_payment <$rate)
                  {
                    $excess_payment = '0';
                  }
                }
                else if($value_in == "P")
                {
                  $disc_amount = $excess_payment * ($rate/100);
                  $excess_payment = $excess_payment - $disc_amount;
                }
              }

              $pickup_date = date('m/d/Y H:i:s', strtotime($return_asal));
              $return_date = date('m/d/Y H:i:s', strtotime($return_skrg));

              $sql = "INSERT INTO sale 
              (
                title,
                type,
                booking_trans_id,
                vehicle_id,
                total_day,
                total_sale,
                payment_type,
                payment_status,
                pickup_date,
                return_date,
                staff_id,
                created
              )
              VALUES (
                'Outstanding Extend',
                'Sale',
                '".$_GET['booking_id']."',
                '" . $vehicle_id . "',
                '0',
                '$excess_payment',
                '".$_GET['type_of_payment']."',
                'Paid',
                '" . date('Y-m-d H:i:s', strtotime($pickup_date))."',
                '" . date('Y-m-d H:i:s', strtotime($return_date))."',
                '".$_SESSION['cid']."',
                '".date('Y-m-d H:i:s',time())."'
              )";

              db_update($sql);

              // echo "<br>sql sale: ".$sql;

              // $sql = "SELECT LAST_INSERT_ID() FROM sale"; 
              // db_select($sql); 

              // if (db_rowcount() > 0) { 

                $sale_id = mysqli_insert_id($con); 
              // }


              $daylog = '0';
              $datelog = date('Y/m/d H:i:s', strtotime($pickup_date));

              $hourlog = dateDifference($pickup_date, date('m/d/Y H:i:s', strtotime($return_date)), '%h');

              $datenew = date('Y/m/d H:i:s', strtotime($return_date));

              while($datelog <= $datenew)
              {

                $daydiff = dateDifference($datelog, date('m/d/Y H:i:s', strtotime($return_date)), '%a'); 

                $mymonth = date("m",strtotime($datelog));
                $myyear = date("Y",strtotime($datelog));

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

                  $monthname = 'dis';
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
                  '$sale_id',
                  '$excess_payment',
                  '0',
                  '$hourlog',
                  'hour',
                  '$excess_payment',
                  '$excess_payment',
                  '$myyear',
                  '" . date('Y-m-d H:i:s', strtotime($return_date))."',
                  '".date('Y-m-d H:i:s',time())."'
                )";

                db_update($sql);

                $datelog = date('Y/m/d H:i:s', strtotime("+1 day", strtotime($datelog)));

                // echo "<br> sql sale log: <br>".$sql;
              } 

              $where = "outstanding_extend = '$totalhour hour(s)', outstanding_extend_type_of_payment = '$type_of_payment', outstanding_extend_cost = '$excess_payment',";
            }


            $sql = "UPDATE booking_trans SET 
            return_date_final = '".date('Y-m-d H:i:s', time())."',
            other_details = '$other_details', 
            other_details_price = '$other_details_price', 
            other_details_payment_type = '$type_of_payment',
            refund_dep = '$refund_dep', 
            refund_dep_payment = '$refund_dep_payment', 
            damage_charges = '$damage_charges', 
            damage_charges_details = '$damage_charges_details', 
            damage_charges_payment_type = '$type_of_payment', 
            missing_items_charges = '$missing_items_charges', 
            missing_items_charges_details = '$missing_items_charges_details', 
            missing_items_charges_payment_type = '$type_of_payment', 
            ".$where."
            available ='Park' WHERE id = $id"; 

            db_update($sql); 

            $sql = "SELECT 
              MAX(sale_log.id) AS sale_log_id, 
              MAX(sale_log.sale_id) AS sale_id 
              FROM sale 
              JOIN sale_log ON sale.id = sale_log.sale_id 
              WHERE booking_trans_id = '$id'";

            db_select($sql);

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            }

            $sql = "UPDATE sale_log SET date = '".date('Y-m-d H:i:s', time())."' WHERE id = '$sale_log_id' AND sale_id = '$sale_id'";

            db_update($sql);

            // echo "<script> alert('masuk if 323'); </script>";
            // echo "<br>sql: ".$sql;

            // $sql2 = "<br>discount: $disc_coup <br>excess_payment: $excess_payment <br>type of payment: $type_of_payment";
            // echo "<br>sql: ".$sql2;


            $sql = "UPDATE vehicle SET availability = 'Available' WHERE id=".$vehicle_id;

            db_update($sql); 


            $sql = "SELECT * FROM booking_trans WHERE id = $id"; 
            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            }
            
            $sql = "SELECT payment_status, payment_type FROM sale WHERE booking_trans_id = '$id' AND type = 'Booking'"; 
            
            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            }

            $sql = "INSERT INTO sale 
            (
              title,
              type,
              booking_trans_id,
              vehicle_id,
              total_day,
              deposit,
              payment_status,
              payment_type,
              pickup_date,
              return_date,
              staff_id,
              created
            )
            VALUES (
              'Return Deposit out',
              'Return',
              '$booking_id',
              '" . $vehicle_id . "',
              '0',
              '-$refund_dep',
              '$payment_status',
              '$payment_type',
              '" . date('Y-m-d', strtotime($pickup_date)).' '.$pickup_time."',
              '" . date('Y-m-d', strtotime($return_date)).' '.$return_time."',
              '".$_SESSION['cid']."',
              '".date('Y-m-d H:i:s',time())."'
            )";

            db_update($sql);

            echo "<script>
              window.location.href='sign_return.php?booking_id=".$_GET['booking_id']."';
              </script>
            ";

          }

          else { 

            $sql = "SELECT * FROM booking_trans WHERE id = $id"; 
            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            } 

          } 

          if (isset($_POST['btn_out'])) { 

            // echo "<script> alert('masuk btn_out'); </script>";

            $upload_dir = "assets/img/"; 
            
            /////////////////// UPLOAD IMAGE UPLOAD ///////////////////
            $img = $_POST['hidden_datas']; 
            $img = str_replace('data:image/png;base64,', '', $img); 
            $img = str_replace(' ', '+', $img); 
            $data = base64_decode($img); 
            $file = $upload_dir . "pickup" . $id . ".png"; 
            $success = file_put_contents($file, $data); 
            // print $success ? $file : 'Unable to save the file.'; 


            /////////////////// SIGN IMAGE UPLOAD ///////////////////
            
            ?> 

            <!-- cubaan buka windows baru  -->

              <!-- <script type="text/javascript">
                window.open('baru.php?booking_id=<?php echo $id; ?>','_blank','height=300,width=500,top=200,left=450');                
              </script> -->

            <?php

            // $img = $_POST['hidden_data2']; 
            // $img = str_replace('data:image/png;base64,', '', $img); 
            // $img = str_replace(' ', '+', $img); 
            // $data = base64_decode($img); 
            // $file2name = "sign" . $id . ".png";
            // $file2 = $upload_dir . "sign" . $id . ".png";
            // // $file2name = $id.".png";
            // $success = file_put_contents($file2, $data); 

            $sql = "UPDATE checklist SET car_out_start_engine = '$start_engine', car_out_no_alarm = '$no_alarm', car_out_air_conditioner = '$air_conditioner', car_out_radio = '$radio', car_out_power_window = '$power_window', car_out_window_condition = '$window_condition' , car_out_perfume = '$perfume', car_out_carpet = '$carpet', car_out_sticker_p = '$sticker', car_out_lamp = '$lamp', car_out_engine_condition = '$engine_condition', car_out_tyres_condition = '$tyres_condition', car_out_jack = '$jack', car_out_tools = '$tools', car_out_signage = '$signage', car_out_child_seat = '$child_seat' , car_out_wiper = '$wiper', car_out_gps = '$gps' , car_out_tyre_spare = '$tyre_spare', car_out_usb_charger = '$usb_charger', car_out_touch_n_go = '$touch_n_go', car_out_smart_tag = '$smart_tag', car_out_seat_condition = '$car_seat_condition', car_out_cleanliness = '$cleanliness', car_out_fuel_level = '$fuel_level', car_out_image = '$file', car_out_remark = '$remark_pickup', car_out_checkby = '$name' WHERE booking_trans_id = $id"; 

            db_update($sql); 

            $sql = "UPDATE booking_trans SET available='Out' WHERE id = $id"; 

            db_update($sql); 

            if($change_vehicle != '' || $change_vehicle != null){
                 
              $sql = "UPDATE booking_trans SET vehicle_id = '$change_vehicle', reason = '$reason_chg_car', available='Out' WHERE id = $id";
              db_update($sql);
               
              $sql = "UPDATE vehicle SET availability = 'Out' WHERE id=".$change_vehicle;
              db_update($sql);
               
              $sql = "UPDATE vehicle SET availability = 'Available' WHERE id=".$vehicle_id;
              db_update($sql);

              $vehicle_id = $change_vehicle;

              $sql="SELECT class_id FROM vehicle WHERE id=".$vehicle_id;
              db_select($sql); 
              
              for ($i = 0; $i < db_rowcount(); $i++) { 

                $class_id = db_get($i,0);

              }
            }
            else
            {
              
              $sql = "UPDATE vehicle SET availability = 'Out' WHERE id=".$vehicle_id; 
              db_update($sql);
            }

            if(isset($_FILES['files'])){ 

              $sql = "SELECT sequence FROM upload_data WHERE vehicle_id =".$vehicle_id . " ORDER BY modified DESC LIMIT 1";

              db_select($sql);

              if(db_rowcount()>0){

                func_setSelectVar();

                if($sequence == '1') {

                  $sequence = '2';
                }
                else if($sequence == '2') {
                  
                  $sequence = '3';
                }
                else if($sequence == '3') {
                  
                  $sequence = '4';
                }
                else if($sequence == '4') {
                  
                  $sequence = '5';
                }
                else if($sequence == '5' || $sequence == NULL) {
                  
                  $sequence = '1';
                }
              }

              foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 

                $file_name = $vehicle_id."-pickup-".$key."-".$sequence.".jpg"; 

                $file_size =$_FILES['files']['size'][$key]; 

                $file_tmp =$_FILES['files']['tmp_name'][$key]; 

                $file_type=$_FILES['files']['type'][$key]; 

                // if($file_size > 2097152){ 

                //   $errors[]='File size must be less than 2 MB'; 
                // } 

                $sql = "SELECT * FROM upload_data WHERE VEHICLE_ID = '$vehicle_id' AND no ='$key' AND sequence ='$sequence'";

                db_select($sql);

                if(db_rowcount()>0) {

                  $sql = "UPDATE upload_data SET booking_trans_id = '$id', file_size = '$file_size', file_name = '$file_name', file_type = '$file_type', modified = '".date('Y-m-d H:i:s',time())."', mid = '".$_SESSION['cid']."' WHERE vehicle_id = '$vehicle_id' AND no = '$key' AND sequence = '$sequence'";
                }
                else {

                  $sql = "INSERT INTO upload_data (no, sequence, booking_trans_id, file_name, file_size, file_type, vehicle_id, modified, mid, created, cid) VALUES ('$key','$sequence','$id','$file_name','$file_size','$file_type','$vehicle_id','".date('Y-m-d H:i:s',time())."','".$_SESSION['cid']."','".date('Y-m-d H:i:s',time())."','".$_SESSION['cid']."')"; 
                }

                db_update($sql); 
                // echo "<br>file_name: ".$file_name;
                // echo "<br>$key ----- sql: ".$sql;

                $desired_dir="assets/img/car_state";

                if(is_dir($desired_dir)==false){ 

                  mkdir("$desired_dir", 0700); 

                } 

                if(is_dir("$desired_dir/".$file_name)==false){ 

                  move_uploaded_file($file_tmp,"$desired_dir/".$file_name); 
                }

                else{ 

                  $new_dir="$desired_dir/".$file_name.time(); 

                  rename($file_tmp,$new_dir) ; 
                } 
              }
            }

            $sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 
            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar();

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

            $pickup_date = date('m/d/Y', strtotime($pickup_date));
            $pickup_time = $pickup_time;
            $return_date = date('m/d/Y', strtotime($return_date));
            $return_time = $return_time;
            $day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a');

            $sql = "INSERT INTO sale 
            (
              title,
              type,
              booking_trans_id,
              vehicle_id,
              total_day,
              total_sale,
              payment_status,
              payment_type,
              pickup_date,
              return_date,
              staff_id,
              created
            )
            VALUES (
              'Pickup',
              'Sale',
              '".$_GET['booking_id']."',
              '" . $vehicle_id . "',
              '$day',
              '$est_total',
              'Paid',
              '$payment_type',
              '" . date('Y-m-d', strtotime($pickup_date)).' '.$pickup_time."',
              '" . date('Y-m-d', strtotime($return_date)).' '.$return_time."',
              '".$_SESSION['cid']."',
              '".date('Y-m-d H:i:s',time())."'
            )";

            db_update($sql);

            // $sql = "SELECT LAST_INSERT_ID() FROM sale"; 
            // db_select($sql); 

            // if (db_rowcount() > 0) { 

              $sale_id = mysqli_insert_id($con); 
            // }


            $daylog = '0';
            $datelog = date('Y/m/d', strtotime($pickup_date)).' '.$pickup_time;

            // echo "<br><br>1631) datelog: ".$datelog;

            $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
            $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
            $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h'); 


            $a = 0;

            // echo "<br><br>1638) day: ".$day;

            $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

            // echo "<br><br>1640) datenew: ".$datenew;

            while($datelog <= $datenew)
            {

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

                $monthname = 'dis';
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

              if($hourlog != '0' )
              {

                if($time < 5)
                {
                  $daily_sale = $est_total;
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

                if($est_total < $daily_sale)
                {
                  $daily_sale = $est_total;
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
                  '$sale_id',
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

                db_update($sql);

                $est_total = $est_total - $daily_sale;

                $hourlog = '0';
              }
              
              else if($hourlog == '0' && $a == '0')
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
                  '$sale_id',
                  '0',
                  '0',
                  '0',
                  '0',
                  'firstday',
                  '$myyear',
                  '$currdate',
                  '".date('Y-m-d H:i:s',time())."'
                )";

                db_update($sql);
              }
              
              else if($hourlog == '0' && $a > 0)
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
                  '$sale_id',
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

                db_update($sql);

                // echo "<br><br> 1876) a= '$a' sql:".$sql;
              }

              $datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$pickup_time;

              $a = $a +1;

              // echo "<br><br>1883) datelog bawah: ".$datelog;
              // echo "<br><br>1872) a: ".$a;
            } 
            
            // echo "<script>
            //   alert('Successfully uploaded.');
            //   window.location.href='mail.php?status=pickup&booking_id=".$_GET['booking_id']."';
            //   </script>
            // ";

            echo "<script>
              window.location.href='sign_pickup.php?booking_id=".$_GET['booking_id']."';
              </script>
            ";
          }

          else { 

            $sql = "SELECT * FROM booking_trans WHERE id = $id"; 

            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            } 

            $sql = "SELECT payment_status AS deposit_status, payment_type AS deposit_type FROM sale WHERE booking_trans_id = $id AND type = 'Booking'"; 

            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            } 

            $sql = "SELECT license_no FROM customer WHERE id = $customer_id"; 

            db_select($sql); 

            if (db_rowcount() > 0) { 

              func_setSelectVar(); 

            }

          } 
          ?>

<style>
  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: Arial;
  }

  /* The grid: Four equal columns that floats next to each other */
  .column {
    float: left;
    width: 25%;
    padding: 10px;
  }

  /* Style the images inside the grid */
  .column img {
    opacity: 0.8; 
    cursor: pointer; 
  }

  .column img:hover {
    opacity: 1;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  /* The expanding image container */
  .container {
    position: relative;
    /*display: none;*/
  }

  /* Expanding image text */
  #imgtext {
    position: absolute;
    bottom: 15px;
    left: 15px;
    color: white;
    font-size: 20px;
  }

  /* Closable button inside the expanded image */
  .closebtn {
    position: absolute;
    top: 10px;
    right: 15px;
    color: white;
    font-size: 35px;
    cursor: pointer;
  }
</style>

  <style>
  .small .btn, .navbar .navbar-nav > li > a.btn {
    padding: 10px 10px;
  }

  .color-background {
    background-color: #eeeeee;
    border-radius: 5px 5px;
    padding: 10px;
  }

  .modal {
    overflow-y:auto !important;
  }

  .modal-backdrop, .modal-backdrop.fade.in {
    /*opacity: 0;*/
  }

  #canvas
  {
  width: 100%;
  height: 100%;
  background: url('assets/img/car.png');
  background-repeat:no-repeat;
  background-size:contain;
  background-position:center;
  }

  #board
  {
  width: 100%;
  height: 100%;
  background: url('assets/img/car.png');
  background-repeat:no-repeat;
  background-size:contain;
  background-position:center;
  }

  #return_sign 
  {
  width: 100%;
  height: 100%;
  /*rder: 1px solid #000;*/
  }
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  </style>

  <style>
    @-webkit-keyframes ring {
      0% {
        -webkit-transform: rotate(-15deg);
        transform: rotate(-15deg);
      }

      2% {
        -webkit-transform: rotate(15deg);
        transform: rotate(15deg);
      }

      4% {
        -webkit-transform: rotate(-18deg);
        transform: rotate(-18deg);
      }

      6% {
        -webkit-transform: rotate(18deg);
        transform: rotate(18deg);
      }

      8% {
        -webkit-transform: rotate(-22deg);
        transform: rotate(-22deg);
      }

      10% {
        -webkit-transform: rotate(22deg);
        transform: rotate(22deg);
      }

      12% {
        -webkit-transform: rotate(-18deg);
        transform: rotate(-18deg);
      }

      14% {
        -webkit-transform: rotate(18deg);
        transform: rotate(18deg);
      }

      16% {
        -webkit-transform: rotate(-12deg);
        transform: rotate(-12deg);
      }

      18% {
        -webkit-transform: rotate(12deg);
        transform: rotate(12deg);
      }

      20% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }
    }

    @keyframes ring {
      0% {
        -webkit-transform: rotate(-15deg);
        -ms-transform: rotate(-15deg);
        transform: rotate(-15deg);
      }

      2% {
        -webkit-transform: rotate(15deg);
        -ms-transform: rotate(15deg);
        transform: rotate(15deg);
      }

      4% {
        -webkit-transform: rotate(-18deg);
        -ms-transform: rotate(-18deg);
        transform: rotate(-18deg);
      }

      6% {
        -webkit-transform: rotate(18deg);
        -ms-transform: rotate(18deg);
        transform: rotate(18deg);
      }

      8% {
        -webkit-transform: rotate(-22deg);
        -ms-transform: rotate(-22deg);
        transform: rotate(-22deg);
      }

      10% {
        -webkit-transform: rotate(22deg);
        -ms-transform: rotate(22deg);
        transform: rotate(22deg);
      }

      12% {
        -webkit-transform: rotate(-18deg);
        -ms-transform: rotate(-18deg);
        transform: rotate(-18deg);
      }

      14% {
        -webkit-transform: rotate(18deg);
        -ms-transform: rotate(18deg);
        transform: rotate(18deg);
      }

      16% {
        -webkit-transform: rotate(-12deg);
        -ms-transform: rotate(-12deg);
        transform: rotate(-12deg);
      }

      18% {
        -webkit-transform: rotate(12deg);
        -ms-transform: rotate(12deg);
        transform: rotate(12deg);
      }

      20% {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
      }
    }

    @-webkit-keyframes horizontal {
      0% {
        -webkit-transform: translate(0,0);
        transform: translate(0,0);
      }

      6% {
        -webkit-transform: translate(-5px,0);
        transform: translate(-5px,0);
      }

      12% {
        -webkit-transform: translate(0,0);
        transform: translate(0,0);
      }

      18% {
        -webkit-transform: translate(-5px,0);
        transform: translate(-5px,0);
      }

      24% {
        -webkit-transform: translate(0,0);
        transform: translate(0,0);
      }

      30% {
        -webkit-transform: translate(-5px,0);
        transform: translate(-5px,0);
      }

      36% {
        -webkit-transform: translate(0,0);
        transform: translate(0,0);
      }
    }

    @keyframes horizontal {
      0% {
        -webkit-transform: translate(0,0);
        -ms-transform: translate(0,0);
        transform: translate(0,0);
      }

      6% {
        -webkit-transform: translate(-5px,0);
        -ms-transform: translate(-5px,0);
        transform: translate(-5px,0);
      }

      12% {
        -webkit-transform: translate(0,0);
        -ms-transform: translate(0,0);
        transform: translate(0,0);
      }

      18% {
        -webkit-transform: translate(-5px,0);
        -ms-transform: translate(-5px,0);
        transform: translate(-5px,0);
      }

      24% {
        -webkit-transform: translate(0,0);
        -ms-transform: translate(0,0);
        transform: translate(0,0);
      }

      30% {
        -webkit-transform: translate(-5px,0);
        -ms-transform: translate(-5px,0);
        transform: translate(-5px,0);
      }

      36% {
        -webkit-transform: translate(0,0);
        -ms-transform: translate(0,0);
        transform: translate(0,0);
      }
    }

    .faa-ring.animated,
    .faa-ring.animated-hover:hover,
    .faa-parent.animated-hover:hover > .faa-ring {
      -webkit-animation: ring 4s ease infinite;
      animation: ring 4s ease infinite;
      transform-origin-x: 50%;
      transform-origin-y: 0px;
      transform-origin-z: initial;

    }

    .faa-horizontal.animated,
    .faa-horizontal.animated-hover:hover,
    .faa-parent.animated-hover:hover > .faa-horizontal {
      -webkit-animation: horizontal 2s ease infinite;
      animation: horizontal 2s ease infinite;
    }
  </style>

  <script src="assets/js/fabric.min.js"></script>
  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="assets/js/html5-canvas-drawing-app.js"></script>

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
                  <h3>Reservation List View</h3>
                </div>
              </div>

              <div class="clearfix"></div>
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <div class="row">
                        <div class="btn-group">

                          <a href="agreement.php?id=<?php echo $_GET['booking_id']; ?>">        
                          <button class="btn btn-default" type="button"><i class="fa fa-clipboard">&nbsp;</i>Agreement</button></a>
                          
                          <?php
                          if($available == "Booked") {
                            ?>                            
                              <a href="bookingreceipt.php?id=<?php echo $_GET['booking_id']; ?>">
                              <button class="btn btn-default" type="button"><i class="fa fa-file">&nbsp;</i>Booking Receipt</button></a>
                              
                              <a href="#">
                              <button <?php if($license_no == NULL){ echo "disabled"; } ?> data-toggle="modal" data-target=".bs-pickup-modal-lg" class="btn btn-default" type="button"><i class="fa fa-level-down">&nbsp;</i>Pickup</button></a>

                              <?php
                              if($license_no == NULL){

                                ?><abbr title="Customer's details is incomplete"><i class="fa fa-info-circle"></i></abbr>&nbsp;<?php
                              }

                          }
                          if($available == "Out" || $available == "Extend") { 
                          
                          ?>
                          <a href="#">
                          <button data-toggle="modal" data-target=".bs-return-modal-lg" class="btn btn-default" type="button"><i class="fa fa-level-up">&nbsp;</i>Return</button></a>
                          
                          <a href="#">
                          <button data-toggle="modal" data-target=".bs-extend-modal-lg" class="btn btn-default" type="button"><i class="fa fa-external-link">&nbsp;</i>Extend</button></a>
                          
                          <?php
                          }
                          if($available == "Park") {
                          ?>
                          
                          <a href="returnreceipt.php?booking_id=<?php echo $_GET['booking_id']; ?>">      
                          <button class="btn btn-default" type="button"><i class="fa fa-file">&nbsp;</i>Return Receipt</button></a>
                          
                          <?php
                          }

                          if(isset($_GET['nric_new']))
                          { 
                            ?>
                            <font color="red">NRIC No. entered has been registered in the system.</font>
                            <?php
                          }

                          if(isset($_GET['nric_blacklisted']))
                          { 
                            ?>
                            <font color="red">NRIC No. entered has been blacklisted</font>
                            <?php
                          }

                            // echo "<script> alert('Staff id: ".$staff_id."'); </script>";

                            $sql = "SELECT available from booking_trans WHERE id = '$booking_id'";
                            db_select($sql);

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();
                              $sql = "SELECT nickname from user WHERE id = '$staff_id'";
                              db_select($sql);

                              if (db_rowcount() > 0) { 
                                
                                func_setSelectVar(); 
                                if($available == "Booked"){
                                  
                                  echo "<br><br>Booked by: ".$nickname;
                                }
                                else if($available == "Out"){

                                  echo "<br><br>Pickup by: ".$nickname;
                                }
                                else if($available == "Park"){

                                  echo "<br><br>Return by: ".$nickname;
                                }
                              }
                            }

                          ?>

                        </div>

                        <div class="btn-group" style="float: right;">                          

                          <button data-toggle="modal" data-target=".bs-edit-modal-lg" class="btn btn-default" type="button"><?php if($license_no == NULL){?> <i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 16px; color: #f95e5e"></i> <?php } ?><i class="fa fa-edit">&nbsp;</i>Edit Customer</button>&nbsp;

                          <a href="reason_delete.php?agreement_no=<?php echo $agreement_no; ?>&booking_id=<?php echo $id; ?>" onClick="return alert('Please provide reason of deleting this agreement')">
                            <button class="btn btn-default" type="button"><i class="fa fa-trash">&nbsp;</i>Delete</button>
                          </a>
                        </div>

                      
                           
                        <!-- pickup modal -->
              
                        <form name="modalOut" enctype="multipart/form-data" id="modalOut" data-parsley-validate class="form-horizontal form-label-left"  method="post">
                          
                          <div class="modal fade bs-pickup-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                  <h4 class="modal-title" id="myModalLabel">Pickup</h4>
                                </div>
                                
                                <div class="modal-body">
                                  <div class="form-group">
                                    <center><font color="blue">*** Please be noted once pickup has been made, the form cannot be changed ***</font><br><br>
                                    <font color="red">
                                    <?php
                                      $sql = "SELECT availability, reg_no FROM vehicle WHERE id = $vehicle_id"; 
                                      db_select($sql); 

                                      if(db_get(0,0) == 'Out')
                                      {
                                        echo "This vehicle (".db_get(0,1).") cannot undergo pickup as it has not been returned yet, please complete previous agreement to continue";
                                        $car_return = "false";
                                      }
                                      else
                                      {
                                        $car_return = "true";
                                      }
                                    ?>
                                    </font></center>
                                    <br>
                                  </div>
                                  
                                  <!-- <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Change Vehicle</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select name="change_vehicle" class="form-control">
                                      
                                        <?php

                                        $value = ""; 
                                        $sql = "SELECT id, reg_no, make, model FROM vehicle WHERE  availability  = 'Available'"; db_select($sql); 

                                        if(db_rowcount()>0){ 

                                          for($j=-1;$j<db_rowcount();$j++){
                                              
                                              if($j == '-1')
                                              {
                                                  $value = $value."<option value=''>No change</option>";
                                              }
                                              else
                                              {
                                                  $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$change_vehicle,'Selected','').">".db_get($j,1)."&nbsp;".db_get($j,2)."&nbsp;".db_get($j,3)."</option>";
                                              }
                                              
                                          }
                                            
                                        } echo $value; 

                                        ?>
                                    
                                      </select>
                                    </div>
                                  </div>
                            
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reason for Change Vehicle</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control" name="reason_chg_car" value="<?php echo $reason_chg_car; ?>">
                                    </div>
                                  </div> -->

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Total Sale (RM)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control" name="total_sale" value='<?php echo $est_total; ?>'>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Amount Collected (RM)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control" name="amount_collected" value="<?php echo $balance; ?>" disabled>
                                    </div>
                                  </div>

                                  <?php 
                                    $total_balance = $sub_total - $balance;
                                  ?>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Balance Payment (RM)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control" name="balance" value="<?php echo number_format($total_balance,2); ?>" disabled>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type Of Payment</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select name="payment_type" class="form-control" required>
                                      
                                          <option value="">Please Select</option>
                                          <option value='Cash'>Cash</option>
                                          <option value='Online'>Online</option>
                                          <option value='Card'>Card</option>

                                      </select>
                                    </div>
                                  </div>
                                  <br><br>

                                  <?php

                                    $sql = "SELECT * from checklist where booking_trans_id = ".$_GET['booking_id'];

                                    $result = mysqli_query($con,$sql);

                                    if($result)
                                    {
                                      while($row = mysqli_fetch_assoc($result))
                                      {
                                  ?>

                                  <div class="col-md-12">
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="start_engine">Start Engine</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_start_engine'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_start_engine'] == "X" || $row['car_out_start_engine'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_start_engine'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="start_engine" name="start_engine"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_start_engine'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_start_engine'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="no_alarm">No Alarm</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_no_alarm'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_no_alarm'] == "X" || $row['car_out_no_alarm'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_no_alarm'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="no_alarm" name="no_alarm"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_no_alarm'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_no_alarm'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="air_conditioner">Air Conditioner</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_air_conditioner'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_air_conditioner'] == "X" || $row['car_out_air_conditioner'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_air_conditioner'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="air_conditioner" name="air_conditioner"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_air_conditioner'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_air_conditioner'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="radio">Radio</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_radio'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_radio'] == "X" || $row['car_out_radio'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_radio'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="radio" name="radio"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_radio'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_radio'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="power_window">Power Window</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_power_window'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_power_window'] == "X" || $row['car_out_power_window'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_power_window'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="power_window" name="power_window"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_power_window'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_power_window'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="window_condition">Window Condition</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_window_condition'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_window_condition'] == "X" || $row['car_out_window_condition'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_window_condition'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="window_condition" name="window_condition"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_window_condition'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_window_condition'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="perfume">Perfume</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_perfume'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_perfume'] == "X" || $row['car_out_perfume'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_perfume'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="perfume" name="perfume"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_perfume'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_perfume'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="carpet">Carpet (RM20/pcs)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_carpet'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_carpet'] == "X" || $row['car_out_carpet'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_carpet'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="carpet" name="carpet"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_carpet'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_carpet'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="sticker_p">Sticker P (RM5)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_sticker_p'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_sticker_p'] == "X" || $row['car_out_sticker_p'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_sticker_p'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="sticker_p" name="sticker_p"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_sticker_p'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_sticker_p'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="lamp">Lamp</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_lamp'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_lamp'] == "X" || $row['car_out_lamp'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_lamp'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="lamp" name="lamp"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_lamp'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_lamp'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="engine_condition">Engine Condition</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_engine_condition'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_engine_condition'] == "X" || $row['car_out_engine_condition'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_engine_condition'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="engine_condition" name="engine_condition"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_engine_condition'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_engine_condition'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="tyres_condition">Tyres Condition</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_tyres_condition'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tyres_condition'] == "X" || $row['car_out_tyres_condition'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_tyres_condition'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="tyres_condition" name="tyres_condition"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tyres_condition'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tyres_condition'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="jack">Jack (RM70)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_jack'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_jack'] == "X" || $row['car_out_jack'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_jack'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="jack" name="jack"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_jack'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_jack'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="tools">Tools (RM30)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_tools'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tools'] == "X" || $row['car_out_tools'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_tools'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="tools" name="tools"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tools'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tools'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="signage">Signage (RM30)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_signage'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_signage'] == "X" || $row['car_out_signage'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_signage'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="signage" name="signage"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_signage'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_signage'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="child_seat">Child Seat</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_child_seat'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_child_seat'] == "X" || $row['car_out_child_seat'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_child_seat'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="child_seat" name="child_seat"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_child_seat'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_child_seat'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="wiper">Wiper</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_wiper'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_wiper'] == "X" || $row['car_out_wiper'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_wiper'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="wiper" name="wiper"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_wiper'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_wiper'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="gps">GPS</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_gps'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_gps'] == "X" || $row['car_out_gps'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_gps'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="gps" name="gps"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_gps'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_gps'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-3">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="tyre_spare">Tyre Spare (RM200)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_tyre_spare'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tyre_spare'] == "X" || $row['car_out_tyre_spare'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_tyre_spare'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="tyre_spare" name="tyre_spare"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tyre_spare'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_tyre_spare'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-3">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="usb_charger">USB Charger (RM50)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_usb_charger'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_usb_charger'] == "X" || $row['car_out_usb_charger'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_usb_charger'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="usb_charger" name="usb_charger"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_usb_charger'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_usb_charger'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-3">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="touch_n_go">Touch n Go (RM50)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_touch_n_go'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_touch_n_go'] == "X" || $row['car_out_touch_n_go'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_touch_n_go'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="touch_n_go" name="touch_n_go"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_touch_n_go'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_touch_n_go'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-3">
                                        <div class="form-group">
                                          <div class="panel panel-default">
                                            <div class="panel panel-body">
                                              <div class="col-md-12">
                                                <div class="row">
                                                  <div class="col-md-9" style="text-align: right;">
                                                    <label for="smart_tag">Smart TAG (RM150)</label>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <label>
                                                      <?php  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?> 
                                                      <?php

                                                        if($occupation != 'Operation Staff')
                                                        {
                                                          if($row['car_out_smart_tag'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_smart_tag'] == "X" || $row['car_out_smart_tag'] == "")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?>> &nbsp; <?php
                                                          }
                                                        }
                                                        else if($occupation == 'Operation Staff')
                                                        {
                                                          if($row['car_out_smart_tag'] == "")
                                                          {

                                                            ?><input type="checkbox" value="Y" id="smart_tag" name="smart_tag"> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_smart_tag'] == "Y")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                                          }
                                                          else if($row['car_out_smart_tag'] == "X")
                                                          {
                                                            ?><input type="checkbox" value="Y" id="smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> disabled> &nbsp; <?php
                                                          }
                                                        }
                                                      ?>
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <?php 
                                      }
                                    }
                                  ?>

                                  <br>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Car Images</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="btn btn-default" type="file" name="files[]" required>
                                    </div>
                                  </div>

                      

                                  <!-- // -->

                                  <br>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Car Seat Condition</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select name="car_seat_condition" class="form-control">
                                        <option value='Clean' <?php echo vali_iif('Clean' == $car_seat_condition, 'Selected', ''); ?>>Clean</option>
                                        <option value='Dirty' <?php echo vali_iif('Dirty' == $car_seat_condition, 'Selected', ''); ?>>Dirty</option>
                                        <option value='1 Cigarettes Bud' <?php echo vali_iif('1 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>1 Cigarettes Bud</option>
                                        <option value='2 Cigarettes Bud' <?php echo vali_iif('2 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>2 Cigarettes Bud</option>
                                        <option value='3 Cigarettes Bud' <?php echo vali_iif('3 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>3 Cigarettes Bud</option>
                                        <option value='4 Cigarettes Bud' <?php echo vali_iif('4 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>4 Cigarettes Bud</option>
                                        <option value='5 Cigarettes Bud' <?php echo vali_iif('5 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>5 Cigarettes Bud</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cleanliness</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select name="cleanliness" class="form-control">
                                        <option value='Clean' <?php echo vali_iif('Clean' == $cleanliness, 'Selected', ''); ?>>Clean</option>
                                        <option value='Dirty' <?php echo vali_iif('Dirty' == $cleanliness, 'Selected', ''); ?>>Dirty</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fuel Level</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select name="fuel_level" class="form-control">
                                        <option value='0' <?php echo vali_iif('0' == $fuel_level, 'Selected', ''); ?>>Empty</option>
                                        <option value='1' <?php echo vali_iif('1' == $fuel_level, 'Selected', ''); ?>>1 Bar</option>
                                        <option value='2' <?php echo vali_iif('2' == $fuel_level, 'Selected', ''); ?>>2 Bar</option>
                                        <option value='3' <?php echo vali_iif('3' == $fuel_level, 'Selected', ''); ?>>3 Bar</option>
                                        <option value='4' <?php echo vali_iif('4' == $fuel_level, 'Selected', ''); ?>>4 Bar</option>
                                        <option value='5' <?php echo vali_iif('5' == $fuel_level, 'Selected', ''); ?>>5 Bar</option>
                                        <option value='6' <?php echo vali_iif('6' == $fuel_level, 'Selected', ''); ?>>6 Bar</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Remark</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input class="form-control" name="remark_pickup" value="<?php echo $remark_pickup; ?>">
                                    </div>
                                  </div>

                                  <!-- // -->

                                  <br>

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                                    <div class="checkbox">
                                      <center>

                                        <label>I (Renter) received this car in <b>CLEAN</b> condition without any <b>FORBIDDEN STUFF</b> or <b>CRIMINAL ACTIVITY STUFF.</b></label> 

                                        <label>
                                           <input type="checkbox" value="Y" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?>> &nbsp;
                                        </label>
                                      </center>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="canvas-holder2">
                                      <center>
                                        <canvas id="board" class="img-responsive" style="border: 1px solid;">canvas</canvas>
                                        <div class="form-group">
                                          <a type="button" class="btn btn-sm btn-info" id="addCircles">+ Broken</a>
                                          <a type="button" class="btn btn-sm btn-info" id="addEquals">+ Scratch</a>
                                          <a type="button" class="btn btn-sm btn-info" id="addRects">+ Missing</a>
                                          <a type="button" class="btn btn-sm btn-info" id="addTriangles">+ Dent</a>
                                        </div>
                                        <br>
                                        <script type="text/javascript">
                                            
                                          var board = new fabric.Canvas('board');
                                          $("#addCircles").click(function(){
                                            board.add(new fabric.Circle({radius: 10, fill: '#000', left: 22, top: 10}));
                                      
                                          for ($x = 0; $x <= 100; $x++) {
                                          
                                            board.item($x).selection = false;

                                            board.item($x).hasControls = board.item($x).hasBorders = false;
                                            board.setActiveObject(board.item($x));

                                          }

                                          });
                                          $("#addEquals").click(function(){
                                            board.add(new fabric.Text('=', { left: 20, top: 35, fill: '#000'}));

                                          for ($y = 0; $y <= 100; $y++) {
                                          
                                            board.item($y).hasControls = board.item($y).hasBorders = false;
                                            board.setActiveObject(board.item($y));

                                          }
                                          

                                          });
                                          $("#addRects").click(function(){
                                            board.add(new fabric.Rect({top: 75, left: 22, width: 18, height: 18, fill: '#000'}));
                                          for ($z = 0; $z <= 100; $z++) {
                                          
                                            board.item($z).hasControls = board.item($z).hasBorders = false;
                                            board.setActiveObject(board.item($z));

                                          }
                                          
                                          });
                                          $("#addTriangles").click(function(){
                                            board.add(new fabric.Triangle({top: 115, left: 22, width: 18, height: 18,fill: '#000'}));
                                          
                                          for ($za = 0; $za <= 100; $za++) {
                                          
                                            board.item($za).hasControls = board.item($za).hasBorders = false;
                                            board.setActiveObject(board.item($za));

                                          }
                                          
                                          });

                                        </script>
                                      </center>
                                      <div>
                                        <input name="hidden_datas" id='hidden_datas' type="hidden"/>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="canvas-holder3">
                                          <center>
                                            <div>
                                              <script>
                                                function upload() {
                                                  var board = document.getElementById("board");
                                                  var dataURL = board.toDataURL("image/png");
                                                  document.getElementById('hidden_datas').value = dataURL;
                                                  var fd = new FormData(document.forms["modalOut"]);

                                                  var xhr = new XMLHttpRequest();
                                                  xhr.open('POST', 'reservation_list_view.php', true);
                                                
                                                  // xhr.upload.onprogress = function(e) {
                                                  //   if (e.lengthComputable) {
                                                  //     var percentComplete = (e.loaded / e.total) * 100;
                                                  //     console.log(percentComplete + '% uploaded');
                                                  //     alert('Successfully uploaded');
                                                  //   }
                                                  // };

                                                  // xhr.onload = function() {

                                                  // };
                                                  xhr.send(fd);
                                                };
                                              </script>
                                            </div>
                                          </center>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                  <?php 
                                    $sql = "SELECT car_out_start_engine as start_engine FROM checklist where booking_trans_id = ".$_GET['booking_id'];

                                    db_select($sql);
                                    if(db_rowcount() > 0)
                                    {
                                      func_setSelectVar();
                                    }

                                  ?>
                                  
                                  <button class="btn btn-primary" name="btn_out" onClick="upload()" value="upload" type="submit" <?php 
                                  if($car_return == 'false'){ echo "disabled style='cursor: not-allowed;' title = 'Car has not been returned'";} 
                                  ?> >Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>

    <!-- return modal -->

    <form name="modalIn" enctype="multipart/form-data" id="modalIn" data-parsley-validate class="form-horizontal form-label-left"  method="post">
      <div class="modal fade bs-return-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Return</h4>
            </div>
            <div class="modal-body">



              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" name="payment" value=<?php echo $balance; ?>>
                </div>
              </div>
              <br>

              <h4>Payment To Customer</h4>

              <hr>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit Status</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="deposit_status" class="form-control">

                    <option value="" disabled >Please Select</option>
                        <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
                        <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
                        <option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
                   </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit Type</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="deposit_type" class="form-control">

                    <option value="" disabled >Please Select</option>
                        <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
                        <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
                        <option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
                   </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit Price</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="refund_dep" value="<?php echo $refund_dep; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Other Details</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="other_details" value="<?php echo $other_details; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Other Details Price</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="other_details_price" value="<?php echo $other_details_price; ?>">
                </div>
              </div>

              <br>


              <h4>Payment from Customer</h4>

              <hr>



              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Damages Details</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="damage_charges_details" value="<?php echo $damage_charges_details; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Charges for Damages (RM)</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="damage_charges" value="<?php echo $damage_charges; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Missing Items Details</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="missing_items_charges_details" value="<?php echo $missing_items_charges_details; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Charges for Missing Items</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="missing_items_charges" value="<?php echo $missing_items_charges; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Additional Cost Details</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="additional_cost_details" value="<?php echo $additional_cost_details; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Additional Cost</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="additional_cost" value="<?php echo $additional_cost; ?>">                   
                </div>
              </div>



              <?php

                $sql = "SELECT * FROM extend WHERE ID = (SELECT MAX(ID) FROM extend WHERE booking_trans_id =" . $booking_id .")"; 
                
                db_select($sql);

                if (db_rowcount() > 0) { 

                  func_setSelectVar();
                  $return_date = $extend_to_date;
                }

                $timereturn = strtotime($return_date);
                $timecurrent = time();
                // $timecurrent = strtotime("6/27/2019 18:00:00");
                $return_asal = date('m/d/Y H:i:s',$timereturn);
                $return_skrg = date('m/d/Y H:i:s',$timecurrent);
                $currenthour = dateDifference($return_asal, $return_skrg, '%h');
                $currentday = dateDifference($return_asal, $return_skrg, '%d');
                $excess = "false";
                $totalhour = ($currentday*24) + $currenthour;

                if($currentday < 1 && $timecurrent > $timereturn && $currenthour > 1 && $currenthour < 13)
                {
                  $sql = "SELECT hour,halfday FROM car_rate WHERE class_id=" . $class_id; 
                  db_select($sql);

                  if (db_rowcount() > 0) { 

                    func_setSelectVar();
                  }

                  if($currenthour > 1 && $currenthour < 9)
                  {
                    $result2 = "Excess of ".$currenthour." hour(s)";
                    $payment = $hour * ($currenthour-1);
                    $remark = "RM ".$payment;
                    $excess = 'true';
                  }
                  else if($currenthour >= 9 && $currenthour < 13)
                  {
                    $result2 = "halfday";
                    $payment = $halfday;
                    $remark = "RM ".$payment;
                    $excess = 'true';
                  }
                }
                else if($timecurrent < $timereturn || $totalhour < 2)
                {
                  $remark = "No excess payment";
                  $excess = 'early';
                }
                else
                {
                  $remark = "please make extend form";
                  $excess = 'false';
                }
                
                if($excess == 'false')
                { 

              ?>
  
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Excess</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" value="Excess of <?php echo $currentday; ?> day(s), <?php echo $currenthour; ?> hour(s)" disabled>
                </div>
              </div>


              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <input class="form-control" value="<?php echo $remark; ?>" disabled>
                </div>
              </div>


              <?php
                
                }
                else if($excess == 'early')
                {

              ?>


              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <input class="form-control" value="<?php echo $remark; ?>" disabled>
                </div>
              </div>

              <?php
                
                }
                else
                {

              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Excess</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" value="<?php echo $totalhour; ?> hour(s)" disabled>
                </div>
              </div>


              <div class="form-group">
                <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">RM</label> -->
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <input class="form-control" value="<?php echo $payment; ?>" disabled>
                  <input type="hidden" name="excess_payment" value="<?php echo $payment; ?>">
                  <input type="hidden" name="totalhour" value="<?php echo $totalhour; ?>">
                  <input type="hidden" name="excess_payment" value="<?php echo $payment; ?>">
                  <input type="hidden" name="excess" value="<?php echo $excess; ?>">
                  <input type="hidden" name="return_asal" value="<?php echo $return_asal; ?>">
                  <input type="hidden" name="return_skrg" value="<?php echo $return_skrg; ?>">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Discount Coupon</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="disc_coup" class="form-control">
                    <option value="">No Discount</option>
                    <?php 

                      $db_return_date = date('Y/m/d H:i:s',strtotime($return_date));
                      $sql = "SELECT id,code FROM discount where start_date <= '".$db_return_date."' AND end_date >= '".$db_return_date."' AND (value_in = 'A' OR value_in = 'P')";

                      db_select($sql);

                      if(db_rowcount() > 0)
                      {
                        func_setSelectVar();  
                      }
                      for($i=0;$i<db_rowcount();$i++)
                      {
                        ?>
                            <option value="<?= db_get($i,0) ?>"> <?= db_get($i,1); ?></option>
                        <?php
                      }


                    ?>
                  </select>
                </div>
              </div>


              <?php
                }
              ?>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type of Payment</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="type_of_payment" class="form-control">
                  <option value='Cash'>Cash</option>
                  <option value='Online'>Online</option>
                  <option value='Card'>Card</option>
                </select>                 
                </div>
              </div>


              <?php

                $sql = "SELECT * from checklist where booking_trans_id = ".$_GET['booking_id'];

                $result = mysqli_query($con,$sql);

                if($result)
                {
                  while($row = mysqli_fetch_assoc($result))
                  {
              ?>
              

              <div class="form-group">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Start Engine</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_start_engine'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_start_engine'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_start_engine">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_start_engine'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_start_engine'] == "X" || $row['car_in_start_engine'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_start_engine" name="start_engine"> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_start_engine'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_start_engine'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_start_engine'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>No Alarm</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_no_alarm'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_no_alarm'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_no_alarm">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_no_alarm'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_no_alarm'] == "X" || $row['car_in_no_alarm'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_no_alarm'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_no_alarm'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_no_alarm'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_no_alarm" name="no_alarm" <?php echo vali_iif('Y' == $no_alarm, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Air Conditioner</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_air_conditioner'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_air_conditioner'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_air_conditioner">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_air_conditioner'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_air_conditioner'] == "X" || $row['car_in_air_conditioner'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_air_conditioner'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_air_conditioner'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_air_conditioner'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_air_conditioner" name="air_conditioner" <?php echo vali_iif('Y' == $air_conditioner, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Radio</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_radio'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_radio'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_radio">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_radio'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_radio'] == "X" || $row['car_in_radio'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_radio'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_radio'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_radio'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_radio" name="radio" <?php echo vali_iif('Y' == $radio, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Power Window</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_power_window'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_power_window'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_power_window">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_power_window'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_power_window'] == "X" || $row['car_in_power_window'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_power_window'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_power_window'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_power_window'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_power_window" name="power_window" <?php echo vali_iif('Y' == $power_window, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Window Condition</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_window_condition'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_window_condition'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_window_condition">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_window_condition'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_window_condition'] == "X" || $row['car_in_window_condition'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_window_condition'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_window_condition'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_window_condition'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_window_condition" name="window_condition" <?php echo vali_iif('Y' == $window_condition, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Perfume</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_perfume'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_perfume'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_perfume">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_perfume'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_perfume'] == "X" || $row['car_in_perfume'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_perfume'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_perfume'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_perfume'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_perfume" name="perfume" <?php echo vali_iif('Y' == $perfume, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Carpet (RM20/pcs)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_carpet'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_carpet'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_carpet">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_carpet'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_carpet'] == "X" || $row['car_in_carpet'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_carpet'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_carpet'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_carpet'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_carpet" name="carpet" <?php echo vali_iif('Y' == $carpet, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Sticker P (RM5)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_sticker_p'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_sticker_p'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_sticker_p">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_sticker_p'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_sticker_p'] == "X" || $row['car_in_sticker_p'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_sticker_p'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_sticker_p'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_sticker_p'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_sticker_p" name="sticker_p" <?php echo vali_iif('Y' == $sticker_p, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Lamp</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_lamp'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_lamp'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_lamp">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_lamp'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_lamp'] == "X" || $row['car_in_lamp'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_lamp'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_lamp'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_lamp'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_lamp" name="lamp" <?php echo vali_iif('Y' == $lamp, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Engine Condition</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_engine_condition'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_engine_condition'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_engine_condition">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_engine_condition'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_engine_condition'] == "X" || $row['car_in_engine_condition'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_engine_condition'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_engine_condition'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_engine_condition'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_engine_condition" name="engine_condition" <?php echo vali_iif('Y' == $engine_condition, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Tyres Condition</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_tyres_condition'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_tyres_condition'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_tyres_condition">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_tyres_condition'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_tyres_condition'] == "X" || $row['car_in_tyres_condition'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_tyres_condition'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_tyres_condition'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_tyres_condition'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyres_condition" name="tyres_condition" <?php echo vali_iif('Y' == $tyres_condition, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Jack (RM70)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_jack'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_jack'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_jack">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_jack'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_jack'] == "X" || $row['car_in_jack'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_jack'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_jack'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_jack'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_jack" name="jack" <?php echo vali_iif('Y' == $jack, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Tools (RM30)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_tools'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_tools'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_tools">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_tools'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_tools'] == "X" || $row['car_in_tools'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_tools'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_tools'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_tools'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tools" name="tools" <?php echo vali_iif('Y' == $tools, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Signage (RM30)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_signage'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_signage'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_signage">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_signage'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_signage'] == "X" || $row['car_in_signage'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_signage'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_signage'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_signage'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_signage" name="signage" <?php echo vali_iif('Y' == $signage, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Child Seat</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_child_seat'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_child_seat'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_child_seat">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_child_seat'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_child_seat'] == "X" || $row['car_in_child_seat'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_child_seat'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_child_seat'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_child_seat'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_child_seat" name="child_seat" <?php echo vali_iif('Y' == $child_seat, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Wiper</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_wiper'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_wiper'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_wiper">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_wiper'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_wiper'] == "X" || $row['car_in_wiper'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_wiper'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_wiper'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_wiper'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_wiper" name="wiper" <?php echo vali_iif('Y' == $wiper, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>GPS</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_gps'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_gps'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_gps">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_gps'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_gps'] == "X" || $row['car_in_gps'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_gps'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_gps'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_gps'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_gps" name="gps" <?php echo vali_iif('Y' == $gps, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Tyre Spare (RM200)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_tyre_spare'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_tyre_spare'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_tyre_spare">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_tyre_spare'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_tyre_spare'] == "X" || $row['car_in_tyre_spare'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_tyre_spare'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_tyre_spare'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_tyre_spare'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_tyre_spare" name="tyre_spare" <?php echo vali_iif('Y' == $tyre_spare, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>USB Charger (RM50)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_usb_charger'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_usb_charger'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_usb_charger">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_usb_charger'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_usb_charger'] == "X" || $row['car_in_usb_charger'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_usb_charger'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_usb_charger'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_usb_charger'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_usb_charger" name="usb_charger" <?php echo vali_iif('Y' == $usb_charger, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Touch n Go (RM50)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_touch_n_go'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_touch_n_go'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_touch_n_go">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_touch_n_go'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_touch_n_go'] == "X" || $row['car_in_touch_n_go'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_touch_n_go'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_touch_n_go'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_touch_n_go'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_touch_n_go" name="touch_n_go" <?php echo vali_iif('Y' == $touch_n_go, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="panel panel-default">
                          <div class="panel panel-body">
                            <div class="panel panel-heading" style="text-align: center;">
                              <label>Smart TAG (150)</label>
                            </div>
                            <div class="row">
                              <div class="col-md-6" style="text-align: center;">
                                <label>Pickup</label>
                                <br>
                                <?php

                                  if($row['car_out_smart_tag'] == "X")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> disabled> &nbsp;
                                <?php
                                  }
                                  else if($row['car_out_smart_tag'] == "Y")
                                  {
                                ?>
                                  <input type="checkbox" value="Y" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> checked="true" disabled> &nbsp;
                                <?php
                                  }
                                ?>
                              </div>
                              <div class="col-md-6" style="text-align: center;">
                                <label for="return_smart_tag">Return</label>
                                <br>
                                <?php  
                                  $sql = "SELECT * FROM user WHERE id = ".$_SESSION['cid']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 

                                  if($occupation != 'Operation Staff')
                                  {

                                    if($row['car_in_smart_tag'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> checked="true"> &nbsp; <?php
                                    }
                                    else if($row['car_in_smart_tag'] == "X" || $row['car_in_smart_tag'] == "")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                  }
                                  else if($occupation == 'Operation Staff')
                                  {

                                    if($row['car_in_smart_tag'] == "")
                                    {

                                      ?><input type="checkbox" value="Y" id="return_smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?>> &nbsp; <?php
                                    }
                                    else if($row['car_in_smart_tag'] == "Y")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> checked="true" disabled> &nbsp; <?php
                                    }
                                    else if($row['car_in_smart_tag'] == "X")
                                    {
                                      ?><input type="checkbox" value="Y" id="return_smart_tag" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?> disabled> &nbsp; <?php
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                  }
                }
              ?>
              <br>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Car Images</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="btn btn-default" type="file" name="files[]" multiple/>               
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="btn btn-default" type="file" name="files[]" multiple/>               
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="btn btn-default" type="file" name="files[]" multiple/>               
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="btn btn-default" type="file" name="files[]" multiple/>               
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="btn btn-default" type="file" name="files[]" multiple/>               
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="btn btn-default" type="file" name="files[]" multiple/>               
                </div>
              </div>

              <br>

              <div class="form-group">
                <div class="color-background">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="col-md-12">
                        <center>Car Seat Condition</center>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label">Pickup</label>
                      </div>
                      <div class="col-md-12">
                        <?php
                          $sql = "select * from checklist where booking_trans_id = ".$_GET['booking_id'];

                          $result = mysqli_query($con,$sql);

                          if($result)
                          {
                            while($row = mysqli_fetch_assoc($result))
                            {
                              ?>
                              <select class="form-control" disabled>
                                <option>
                                  <?php echo $row['car_out_seat_condition']; ?>
                                </option>
                              </select>
                              <?php
                            }
                          }
                        ?>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label">Return</label>
                      </div>
                      <div class="col-md-12">
                        <select name="car_seat_condition" class="form-control">
                          <option value='Clean' <?php echo vali_iif('Clean' == $car_seat_condition, 'Selected', ''); ?>>Clean</option>
                          <option value='Dirty' <?php echo vali_iif('Dirty' == $car_seat_condition, 'Selected', ''); ?>>Dirty</option>
                          <option value='1 Cigarettes Bud' <?php echo vali_iif('1 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>1 Cigarettes Bud</option>
                          <option value='2 Cigarettes Bud' <?php echo vali_iif('2 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>2 Cigarettes Bud</option>
                          <option value='3 Cigarettes Bud' <?php echo vali_iif('3 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>3 Cigarettes Bud</option>
                          <option value='4 Cigarettes Bud' <?php echo vali_iif('4 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>4 Cigarettes Bud</option>
                          <option value='5 Cigarettes Bud' <?php echo vali_iif('5 Cigarettes Bud' == $car_seat_condition, 'Selected', ''); ?>>5 Cigarettes Bud</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-12">
                        <center>Cleanliness</center>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label">Pickup</label>
                      </div>
                      <div class="col-md-12">
                        <?php
                          $sql = "select * from checklist where booking_trans_id = ".$_GET['booking_id'];

                          $result = mysqli_query($con,$sql);

                          if($result)
                          {
                            while($row = mysqli_fetch_assoc($result))
                            {
                              ?>
                              <select class="form-control" disabled>
                                <option>
                                  <?php echo $row['car_out_cleanliness']; ?>
                                </option>
                              </select>
                              <?php
                            }
                          }
                        ?>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label">Return</label>
                      </div>
                      <div class="col-md-12">
                        <select name="cleanliness" class="form-control">
                          <option value='Clean' <?php echo vali_iif('Clean' == $cleanliness, 'Selected', ''); ?>>Clean</option>
                          <option value='Dirty' <?php echo vali_iif('Dirty' == $cleanliness, 'Selected', ''); ?>>Dirty</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-12">
                        <center>Fuel Level</center>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label">Pickup</label>
                      </div>
                      <div class="col-md-12">
                        <?php
                          $sql = "select * from checklist where booking_trans_id = ".$_GET['booking_id'];

                          $result = mysqli_query($con,$sql);

                          if($result)
                          {
                            while($row = mysqli_fetch_assoc($result))
                            {
                              ?>
                              <select class="form-control" disabled>
                                <?php
                                  if($row['car_out_fuel_level'] == 0)
                                  {
                                    ?> <option>Empty</option> <?php
                                  }
                                  else if($row['car_out_fuel_level'] == 1)
                                  {
                                    ?> <option>1 Bar</option> <?php
                                  }
                                  else if($row['car_out_fuel_level'] == 2)
                                  {
                                    ?> <option>2 Bar</option> <?php
                                  }
                                  else if($row['car_out_fuel_level'] == 3)
                                  {
                                    ?> <option>3 Bar</option> <?php
                                  }
                                  else if($row['car_out_fuel_level'] == 4)
                                  {
                                    ?> <option>4 Bar</option> <?php
                                  }
                                  else if($row['car_out_fuel_level'] == 5)
                                  {
                                    ?> <option>5 Bar</option> <?php
                                  }
                                  else if($row['car_out_fuel_level'] == 6)
                                  {
                                    ?> <option>6 Bar</option> <?php
                                  }
                                ?>
                              </select>
                              <?php
                            }
                          }
                        ?>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label">Return</label>
                      </div>
                      <div class="col-md-12">
                        <select name="fuel_level" class="form-control">
                          <option value='0' <?php echo vali_iif('0' == $fuel_level, 'Selected', ''); ?>>Empty</option>
                          <option value='1' <?php echo vali_iif('1' == $fuel_level, 'Selected', ''); ?>>1 Bar</option>
                          <option value='2' <?php echo vali_iif('2' == $fuel_level, 'Selected', ''); ?>>2 Bar</option>
                          <option value='3' <?php echo vali_iif('3' == $fuel_level, 'Selected', ''); ?>>3 Bar</option>
                          <option value='4' <?php echo vali_iif('4' == $fuel_level, 'Selected', ''); ?>>4 Bar</option>
                          <option value='5' <?php echo vali_iif('5' == $fuel_level, 'Selected', ''); ?>>5 Bar</option>
                          <option value='6' <?php echo vali_iif('6' == $fuel_level, 'Selected', ''); ?>>6 Bar</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <center>Remark</center>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Pickup</label>
                            <?php
                              $sql = "select * from checklist where booking_trans_id = ".$_GET['booking_id'];

                              $result = mysqli_query($con,$sql);

                              if($result)
                              {
                                while($row = mysqli_fetch_assoc($result))
                                {
                                  if($row['remark_return'] == "")
                                  {
                                    ?>
                                      <textarea class="form-control" disabled >No remark</textarea>
                                    <?php
                                  }else
                                  {
                                    ?>
                                      <textarea class="form-control" disabled> <?php echo $row['remark_return']; ?></textarea>
                                    <?php
                                  }
                                }
                              }
                            ?>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Return</label>
                            <textarea class="form-control" name="remark_return"><?php echo $remark_return; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <table>
                    <tbody>
                      <tr>
                        <td>
                          <br>
                          <div class="form-check">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" value="Y" name="smart_tag" <?php echo vali_iif('Y' == $smart_tag, 'Checked', ''); ?>> &nbsp;
                              </label>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <label class="muted-text">
                              I (Renter) received this car in <b>CLEAN</b> condition without any <b>FORBIDDEN STUFF</b> or <b>CRIMINAL ACTIVITY STUFF.</b>
                            </label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                </div>
              </div>

              <div style="text-align: center;" class="form-group">
                <label>Before Image</label>
                <div>
                    <?php
                        
                        $sql = "SELECT car_out_image FROM checklist WHERE booking_trans_id = ".$_GET['booking_id'];
                        
                        db_select($sql); 
    
                        if (db_rowcount() > 0) { 
                    
                          func_setSelectVar(); 
                          // func_setReqVar(); 
                    
                        } 
                        $png = imagecreatefrompng($car_out_image);
                        $jpeg = imagecreatefromjpeg('pickup.jpg');
            
                        list($width, $height) = getimagesize('pickup.jpg');
                        list($newwidth, $newheight) = getimagesize($car_out_image);
                        $out = imagecreatetruecolor($newwidth, $newheight);
                        imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
                        imagejpeg($out, 'give.jpg', 100); 
                    ?>
                  <img style="background:url(pickup.jpg); background-size: 300px 180px; size: 300px 180px;" src="<?php echo $car_out_image; ?>?nocache=<?php echo time(); ?>" alt="Girl in a jacket" width="300px" height="180px">
                  <!--<img src="give.jpg?nocache=<?php echo time(); ?>" alt="Girl in a jacket" width="300px" height="180px">-->
                </div>
              </div>
              <br><br>

              <div class="row">
                <div class="col-md-12">
                  <center>
                    <label>Return Image</label>
                    <canvas id="canvas" class="img-responsive">canvas</canvas>
                    <div class="form-group">
                      <a type="button" class="btn btn-sm btn-info" id="addCircle">+ Broken</a>
                      <a type="button" class="btn btn-sm btn-info" id="addEqual">+ Scratch</a>
                      <a type="button" class="btn btn-sm btn-info" id="addRect">+ Missing</a>
                      <a type="button" class="btn btn-sm btn-info" id="addTriangle">+ Dent</a>
                    </div>
                    <script type="text/javascript">
                      
                      var canvas = new fabric.Canvas('canvas'); 
          
                      $("#addCircle").click(function(){
                        canvas.add(new fabric.Circle({radius: 10, fill: '#000', left: 22, top: 10}));

                      for ($x = 0; $x <= 100; $x++) {
                      
                        canvas.item($x).hasControls = canvas.item($x).hasBorders = false;
                        canvas.setActiveObject(canvas.item($x));

                      }
                      
            
                              // canvas.item(0).lockMovementX  = canvas.item(0).lockMovementY = true;

                      });
                      $("#addEqual").click(function(){
                        canvas.add(new fabric.Text('=', { left: 20, top: 35, fill: '#000'}));

                      for ($y = 0; $y <= 100; $y++) {
                      
                        canvas.item($y).hasControls = canvas.item($y).hasBorders = false;
                        canvas.setActiveObject(canvas.item($y));

                      }
                      



                      });
                      $("#addRect").click(function(){
                        canvas.add(new fabric.Rect({top: 75, left: 22, width: 18, height: 18, fill: '#000'}));

                      for ($z = 0; $z <= 100; $z++) {
                      
                        canvas.item($z).hasControls = canvas.item($z).hasBorders = false;
                        canvas.setActiveObject(canvas.item($z));

                      }

                      });
                      $("#addTriangle").click(function(){
                        canvas.add(new fabric.Triangle({top: 115, left: 22, width: 18, height: 18,fill: '#000'}));

                      for ($za = 0; $za <= 100; $za++) {
                      
                        canvas.item($za).hasControls = canvas.item($za).hasBorders = false;
                        canvas.setActiveObject(canvas.item($za));

                      }
        
                      });
                    </script>
                  </center>
                  <input name="hidden_data" id='hidden_data' type="hidden"/>
                  <script>
                    function uploadEx() {
                    var canvas = document.getElementById("canvas");
                    var dataURL = canvas.toDataURL("image/png");
                    document.getElementById('hidden_data').value = dataURL;
                    var fd = new FormData(document.forms["modalIn"]);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'reservation_list_view.php', true);

                    xhr.upload.onprogress = function(e) {
                      if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Successfully uploaded');
                      }
                    };

                    xhr.onload = function() {

                    };
                    xhr.send(fd);
                    };
                  </script>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input class="form-control" name="username" value="<?php echo $name;?>" disabled>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" name="btn_in" onClick="uploadEx()" type="submit">Save changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    
    <!-- return modal -->

    <!-- Edit Reservation -->
    
    <?php

      $sql = "SELECT * FROM booking_trans WHERE id=".$_GET['booking_id'];

      db_select($sql); 

      if (db_rowcount() > 0) { 

      func_setSelectVar(); 

        }

      $sql = "SELECT * FROM customer WHERE id=".$customer_id;

      db_select($sql); 

      if (db_rowcount() > 0) { 

      func_setSelectVar(); 

        }

      // echo 'Customer ID: '.$customer_id; 

    ?>

    <div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel2">Edit Customer</h4>
          </div>
      

          <div class="modal-body">
            <center>
              <br><br>
              <button type="button" data-dismiss="modal" data-toggle="modal" data-target=".bs-registered-customer-modal-lg" class="btn"><?php if(isset($_GET['nric_blacklisted'])){?> <i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 16px; color: #f95e5e"></i> <?php } ?>Current Customer</button>
              <button type="button" data-dismiss="modal" data-toggle="modal" data-target=".bs-new-customer-modal-lg" class="btn btn-default"><?php if(isset($_GET['nric_new'])){?> <i class='fa fa-bell faa-ring animated fa-4x' style="font-size: 16px; color: #f95e5e"></i> <?php } ?>Change Customer</button>
            </center>
            <br><br>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
          
    <div class="modal fade bs-registered-customer-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Current Customer</h4>
          </div>
          <div class="modal-body">
            <form name="editReservation" enctype="multipart/form-data" id="editReservation" data-parsley-validate class="form-horizontal form-label-left"  method="post">

              <b>Customer Information</b>
              <br>
              <font color="blue">This section is to edit current customer. If you're changing to a new customer, please choose "Change Customer" instead.</font>

              <?php 
                if(isset($_GET['nric_blacklisted']))
                {?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC No</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control" placeholder="NRIC No" name="nric_no" value="<?php echo $_GET['nric_blacklisted']; ?>">
                      <font color="red">ALERT: Customer has been blacklisted **</font>
                    </div>
                  </div><?php
                }
                else
                {?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC No</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control" placeholder="NRIC No" name="nric_no" value="<?php echo $nric_no; ?>">
                    </div>
                  </div><?php
                }
              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Title</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="title" class="form-control">

                  <option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
                  
                  <option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
                  
                  <option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">First Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $firstname; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lastname; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Driver's Age</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Phone No" name="phone_no" value="<?php echo $phone_no; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No 2<br><i>(Optional)</i></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Optional" name="phone_no2" value="<?php echo $phone_no2; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Expired</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="date" class="form-control" placeholder="License No" name="license_exp" autocomplete="off" <?php if($license_exp == '0000-00-00' || $license_exp == '1970-01-01') { echo "value=''"; } else { echo "value='".date('Y-m-d',strtotime($license_exp))."'"; } ?> >
                </div>
              </div>
              
              <?php
                
                if($identity_photo_front != NULL) {
                
                  ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (front)</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="assets/img/customer/<?php echo $identity_photo_front.'?nocache='. time(); ?>" style="height:190px;">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (back)</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="assets/img/customer/<?php echo $identity_photo_back.'?nocache='. time(); ?>" style="height:190px;">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Utility Photo</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="assets/img/customer/<?php echo $utility_photo.'?nocache='. time(); ?>" style="height:190px;">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Working Photo</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="assets/img/customer/<?php echo $working_photo.'?nocache='. time(); ?>" style="height:190px;">
                      </div>
                    </div>
                  <?php
                
                } else { 

                  ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (front)</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" class="btn btn-control" name="identity_photo[]" required>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC & License Photo (back)</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" class="btn btn-control" name="identity_photo[]" required>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Utility Bills (Optional)</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" class="btn btn-control" name="identity_photo[]">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Working Card (Optional)</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" class="btn btn-control" name="identity_photo[]">
                      </div>
                    </div>
                  <?php 
                } 
              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Address" name="address"  value="<?php echo $address; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Postcode</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder=" Postcode" name="postcode" value="<?php echo $postcode; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">City</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="city" class="form-control" >
                    <option value="">Please Select</option>
                    <option <?php echo vali_iif('Perlis' == $city, 'Selected', ''); ?> value='Perlis'>Perlis</option>
                    <option <?php echo vali_iif('Kedah' == $city, 'Selected', ''); ?> value='Kedah'>Kedah</option>
                    <option <?php echo vali_iif('Pulau Pinang' == $city, 'Selected', ''); ?> value='Pulau Pinang'>Pulau Pinang</option>
                    <option <?php echo vali_iif('Perak' == $city, 'Selected', ''); ?> value='Perak'>Perak</option>
                    <option <?php echo vali_iif('Selangor' == $city, 'Selected', ''); ?> value='Selangor'>Selangor</option>
                    <option <?php echo vali_iif('Wilayah Persekutuan Kuala Lumpur' == $city, 'Selected', ''); ?> value='Wilayah Persekutuan Kuala Lumpur'>Wilayah Persekutuan Kuala Lumpur</option>
                    <option <?php echo vali_iif('Wilayah Persekutuan Putrajaya' == $city, 'Selected', ''); ?> value='Wilayah Persekutuan Putrajaya'>Wilayah Persekutuan Putrajaya</option>
                    <option <?php echo vali_iif('Melaka' == $city, 'Selected', ''); ?> value='Melaka'>Melaka</option>
                    <option <?php echo vali_iif('Negeri Sembilan' == $city, 'Selected', ''); ?> value='Negeri Sembilan'>Negeri Sembilan</option>
                    <option <?php echo vali_iif('Johor' == $city, 'Selected', ''); ?> value='Johor'>Johor</option>
                    <option <?php echo vali_iif('Pahang' == $city, 'Selected', ''); ?> value='Pahang'>Pahang</option>
                    <option <?php echo vali_iif('Terengganu' == $city, 'Selected', ''); ?> value='Terengganu'>Terengganu</option>
                    <option <?php echo vali_iif('Kelantan' == $city, 'Selected', ''); ?> value='Kelantan'>Kelantan</option>
                    <option <?php echo vali_iif('Sabah' == $city, 'Selected', ''); ?> value='Sabah'>Sabah</option>
                    <option <?php echo vali_iif('Sarawak' == $city, 'Selected', ''); ?> value='Sarawak'>Sarawak</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Country</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select ui-jq="chosen" name="country" class="form-control" >
                    <optgroup label="Alaskan/Hawaiian Time Zone">
                      <option value="AK">Alaska</option>
                      <option value="HI">Hawaii</option>
                      <option value="MY" selected>Malaysia</option>
                    </optgroup>
                    <optgroup label="Pacific Time Zone">
                      <option value="CA">California</option>
                      <option value="NV">Nevada</option>
                      <option value="OR">Oregon</option>
                      <option value="WA">Washington</option>
                    </optgroup>
                    <optgroup label="Mountain Time Zone">
                      <option value="AZ">Arizona</option>
                      <option value="CO">Colorado</option>
                      <option value="ID">Idaho</option>
                      <option value="MT">Montana</option><option value="NE">Nebraska</option>
                      <option value="NM">New Mexico</option>
                      <option value="ND">North Dakota</option>
                      <option value="UT">Utah</option>
                      <option value="WY">Wyoming</option>
                    </optgroup>
                    <optgroup label="Central Time Zone">
                      <option value="AL">Alabama</option>
                      <option value="AR">Arkansas</option>
                      <option value="IL">Illinois</option>
                      <option value="IA">Iowa</option>
                      <option value="KS">Kansas</option>
                      <option value="KY">Kentucky</option>
                      <option value="LA">Louisiana</option>
                      <option value="MN">Minnesota</option>
                      <option value="MS">Mississippi</option>
                      <option value="MO">Missouri</option>
                      <option value="OK">Oklahoma</option>
                      <option value="SD">South Dakota</option>
                      <option value="TX">Texas</option>
                      <option value="TN">Tennessee</option>
                      <option value="WI">Wisconsin</option>
                    </optgroup>
                    <optgroup label="Eastern Time Zone">
                      <option value="CT">Connecticut</option>
                      <option value="DE">Delaware</option>
                      <option value="FL">Florida</option>
                      <option value="GA">Georgia</option>
                      <option value="IN">Indiana</option>
                      <option value="ME">Maine</option>
                      <option value="MD">Maryland</option>
                      <option value="MA">Massachusetts</option>
                      <option value="MI">Michigan</option>
                      <option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
                      <option value="NY">New York</option>
                      <option value="NC">North Carolina</option>
                      <option value="OH">Ohio</option>
                      <option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
                      <option value="VT">Vermont</option><option value="VA">Virginia</option>
                      <option value="WV">West Virginia</option>
                    </optgroup>
                  </select>
                </div>
              </div>

              <b>Additional Driver Information</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Name" name="drv_name" value="<?php echo $drv_name; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">IC No. / Passport</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="IC No. / Passport" name="drv_nric" value="<?php echo $drv_nric; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Address" name="drv_address" value="<?php echo $drv_address; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno" value="<?php echo $drv_phoneno; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License No.</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" type="text" placeholder="License No." name="drv_license_no" value="<?php echo $drv_license_no; ?>">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Expired</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" type="date" placeholder="License Expired" name="drv_license_exp"  <?php if($drv_license_exp != NULL) { echo "value='".date('Y-m-d',strtotime($drv_license_exp))."'"; } ?>>
                </div>
              </div>

              <b>Reference Information</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Reference Name" name="ref_name" value="<?php echo $ref_name; ?>" >
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Relationship</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Reference Relationship" name="ref_relationship" value="<?php echo $ref_relationship; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Reference Address" name="ref_address"  value="<?php echo $ref_address; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Phone No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Reference Phone No" name="ref_phoneno" value="<?php echo $ref_phoneno; ?>" >
                </div>
              </div>

              <b>Payment Information</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Amount (RM)</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $balance; ?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Status</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="payment_details" class="form-control">
                    <option value="">Please Select</option>
                    <option <?php echo vali_iif('Collect' == $payment_details, 'Selected', ''); ?> value='Collect'>Collect</option>

                    <option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?> value='Cash'>Cash</option>

                    <option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?> value='Online'>Online</option>                                    
                    <option <?php echo vali_iif('Card' == $payment_details, 'Selected', ''); ?> value='Card'>Card</option>

                    <option <?php echo vali_iif('Nil' == $payment_details, 'Selected', ''); ?> value='Nil'>Nil</option>

                    <option <?php echo vali_iif('Return' == $payment_details, 'Selected', ''); ?> value='Return'>Return</option>

                    <option <?php echo vali_iif('Closing' == $payment_details, 'Selected', ''); ?> value='Closing'>Closing</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit (RM)</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="deposit" class="form-control">
                    <option value="">Please Select</option>
                    <option <?php echo vali_iif('50' == $refund_dep, 'Selected', ''); ?> value='50'>RM50</option>
                    <option <?php echo vali_iif('100' == $refund_dep, 'Selected', ''); ?> value='100'>RM100</option>
                    <option <?php echo vali_iif('200' == $refund_dep, 'Selected', ''); ?> value='200'>RM200</option>
                    <option <?php echo vali_iif('300' == $refund_dep, 'Selected', ''); ?> value='300'>RM300</option>
                    <option <?php echo vali_iif('400' == $refund_dep, 'Selected', ''); ?> value='400'>RM400</option>
                    <option <?php echo vali_iif('500' == $refund_dep, 'Selected', ''); ?> value='500'>RM500</option>
                    <option <?php echo vali_iif('600' == $refund_dep, 'Selected', ''); ?> value='600'>RM600</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit Status</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="refund_dep_payment" class="form-control">
                    
                    <option value="" disabled>Please Select</option>
                    <option <?php echo vali_iif('Collect' == $refund_dep_payment, 'Selected', ''); ?> value='Collect'>Collect</option>
                    <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
                    <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
                    <option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
                    <option <?php echo vali_iif('Nil' == $refund_dep_payment, 'Selected', ''); ?> value='Nil'>Nil</option>
                    <option <?php echo vali_iif('Return' == $refund_dep_payment, 'Selected', ''); ?> value='Return'>Return</option>
                    <option <?php echo vali_iif('Closing' == $refund_dep_payment, 'Selected', ''); ?> value='Closing'>Closing</option>

                  </select>
                </div>
              </div>

              <b>Survey</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Survey</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="survey_type" class="form-control" id="survey" onchange="change();">
                    <option <?php echo vali_iif('Banner' == $survey_type, 'Selected', ''); ?> value='Banner'>Banner</option>
                    <option <?php echo vali_iif('Bunting' == $survey_type, 'Selected', ''); ?> value='Bunting'>Bunting</option>
                    <option <?php echo vali_iif('Facebook Ads' == $survey_type, 'Selected', ''); ?> value='Freinds'>Facebook Ads</option>
                    <option <?php echo vali_iif('Freind' == $survey_type, 'Selected', ''); ?> value='Freinds'>Freinds</option>
                    <option <?php echo vali_iif('Google Ads' == $survey_type, 'Selected', ''); ?> value='Google Ads'>Google Ads</option>
                    <option <?php echo vali_iif('Magazine' == $survey_type, 'Selected', ''); ?> value='Magazine'>Magazine</option>
                    <option <?php echo vali_iif('Others' == $survey_type, 'Selected', ''); ?> value='Others'>Others</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="username" value="<?php echo $name;?>" disabled>
                  <input class="form-control" type="hidden" name="customer_id" value="<?php echo $customer_id;?>">
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" data-dismiss="modal" data-toggle="modal" data-target=".bs-edit-modal-lg" class="btn btn-default">Back</button>
                <button class="btn btn-primary" name="btn_registered_cust" type="submit">Update</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
          
    <div class="modal fade bs-new-customer-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Change Customer</h4>
          </div>
          <div class="modal-body">
            <form name="editReservation2" enctype="multipart/form-data" id="editReservation2" data-parsley-validate class="form-horizontal form-label-left"  method="post">

              <b>Customer Information</b>

              <!-- <?php 
                if(isset($_GET['nric_new']))
                {?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC No</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control" placeholder="NRIC No" name="nric_no" id="nric_no" value="<?php echo $_GET['nric_new']; ?>" onblur="selectNRIC(this.value)">
                      <font color="red">ALERT: Customer has been registered in the system. If you wish to edit customer, please choose "Registered Customer" button instead. TQ **</font>
                    </div>
                  </div>
              
              <?php
                } else{ ?> -->
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC No</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" class="form-control" placeholder="NRIC No" name="nric_no" id="nric_no" onblur="selectNRIC(this.value)" required> 
                    </div>
                  </div>
              
<!--               <?php
                } 
                ?> -->

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Title</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="title" class="form-control" id="title" required>

                  <option value='Mr.'>Mr.</option>
                  
                  <option value='Mrs.'>Mrs.</option>
                  
                  <option value='Miss.'>Miss.</option>

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">First Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Driver's Age</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Age" name="age" id="age" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Phone No" name="phone_no" id="phone_no" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No 2<br><i>(Optional)</i></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Optional" name="phone_no2">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Number</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="License No" name="license_no" id="license_no" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Expired</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="date" class="form-control" placeholder="License Expired" name="license_exp" autocomplete="off" id="license_exp" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Address" name="address" id="address" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Postcode</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder=" Postcode" name="postcode" id="postcode" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">City</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="city" class="form-control" id="city" required>
                    <option value="">Please Select</option>
                    <option value='Perlis'>Perlis</option>
                    <option value='Kedah'>Kedah</option>
                    <option value='Pulau Pinang'>Pulau Pinang</option>
                    <option value='Perak'>Perak</option>
                    <option value='Selangor'>Selangor</option>
                    <option value='Wilayah Persekutuan Kuala Lumpur'>Wilayah Persekutuan Kuala Lumpur</option>
                    <option value='Wilayah Persekutuan Putrajaya'>Wilayah Persekutuan Putrajaya</option>
                    <option value='Melaka'>Melaka</option>
                    <option value='Negeri Sembilan'>Negeri Sembilan</option>
                    <option value='Johor'>Johor</option>
                    <option value='Pahang'>Pahang</option>
                    <option value='Terengganu'>Terengganu</option>
                    <option value='Kelantan'>Kelantan</option>
                    <option value='Sabah'>Sabah</option>
                    <option value='Sarawak'>Sarawak</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Country</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select ui-jq="chosen" name="country" class="form-control" id="country" required>
                    <optgroup label="Alaskan/Hawaiian Time Zone">
                      <option value="AK">Alaska</option>
                      <option value="HI">Hawaii</option>
                      <option value="MY" selected>Malaysia</option>
                    </optgroup>
                    <optgroup label="Pacific Time Zone">
                      <option value="CA">California</option>
                      <option value="NV">Nevada</option>
                      <option value="OR">Oregon</option>
                      <option value="WA">Washington</option>
                    </optgroup>
                    <optgroup label="Mountain Time Zone">
                      <option value="AZ">Arizona</option>
                      <option value="CO">Colorado</option>
                      <option value="ID">Idaho</option>
                      <option value="MT">Montana</option>
                      <option value="NE">Nebraska</option>
                      <option value="NM">New Mexico</option>
                      <option value="ND">North Dakota</option>
                      <option value="UT">Utah</option>
                      <option value="WY">Wyoming</option>
                    </optgroup>
                    <optgroup label="Central Time Zone">
                      <option value="AL">Alabama</option>
                      <option value="AR">Arkansas</option>
                      <option value="IL">Illinois</option>
                      <option value="IA">Iowa</option>
                      <option value="KS">Kansas</option>
                      <option value="KY">Kentucky</option>
                      <option value="LA">Louisiana</option>
                      <option value="MN">Minnesota</option>
                      <option value="MS">Mississippi</option>
                      <option value="MO">Missouri</option>
                      <option value="OK">Oklahoma</option>
                      <option value="SD">South Dakota</option>
                      <option value="TX">Texas</option>
                      <option value="TN">Tennessee</option>
                      <option value="WI">Wisconsin</option>
                    </optgroup>
                    <optgroup label="Eastern Time Zone">
                      <option value="CT">Connecticut</option>
                      <option value="DE">Delaware</option>
                      <option value="FL">Florida</option>
                      <option value="GA">Georgia</option>
                      <option value="IN">Indiana</option>
                      <option value="ME">Maine</option>
                      <option value="MD">Maryland</option>
                      <option value="MA">Massachusetts</option>
                      <option value="MI">Michigan</option>
                      <option value="NH">New Hampshire</option>
                      <option value="NJ">New Jersey</option>
                      <option value="NY">New York</option>
                      <option value="NC">North Carolina</option>
                      <option value="OH">Ohio</option>
                      <option value="PA">Pennsylvania</option>
                      <option value="RI">Rhode Island</option>
                      <option value="SC">South Carolina</option>
                      <option value="VT">Vermont</option>
                      <option value="VA">Virginia</option>
                      <option value="WV">West Virginia</option>
                    </optgroup>
                  </select>
                </div>
              </div>

              <b>Additional Driver Information</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Name" name="drv_name">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">IC No. / Passport</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="IC No. / Passport" name="drv_nric">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Address" name="drv_address">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License No.</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" type="text" placeholder="License No." name="drv_license_no">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Expired</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" type="date" placeholder="License Expired" name="drv_license_exp">
                </div>
              </div>

              <b>Reference Information</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Name</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Reference Name" name="ref_name" id="ref_name" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Relationship</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Reference Relationship" name="ref_relationship" id="ref_relationship" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Address</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" placeholder="Reference Address" name="ref_address" id="ref_address" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Phone No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Reference Phone No" name="ref_phoneno" id="ref_phoneno" required>
                </div>
              </div>

              <b>Payment Information</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Amount (RM)</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $balance; ?>" id="payment_amount" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Status</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="payment_details" class="form-control" required>
                    <option value="">Please Select</option>
                    <option <?php echo vali_iif('Collect' == $payment_details, 'Selected', ''); ?> value='Collect'>Collect</option>

                    <option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?> value='Cash'>Cash</option>

                    <option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?> value='Online'>Online</option>                                    
                    <option <?php echo vali_iif('Card' == $payment_details, 'Selected', ''); ?> value='Card'>Card</option>

                    <option <?php echo vali_iif('Nil' == $payment_details, 'Selected', ''); ?> value='Nil'>Nil</option>

                    <option <?php echo vali_iif('Return' == $payment_details, 'Selected', ''); ?> value='Return'>Return</option>

                    <option <?php echo vali_iif('Closing' == $payment_details, 'Selected', ''); ?> value='Closing'>Closing</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit (RM)</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="deposit" class="form-control" required>
                    <option value="">Please Select</option>
                    <option <?php echo vali_iif('50' == $refund_dep, 'Selected', ''); ?> value='50'>RM50</option>
                    <option <?php echo vali_iif('100' == $refund_dep, 'Selected', ''); ?> value='100'>RM100</option>
                    <option <?php echo vali_iif('200' == $refund_dep, 'Selected', ''); ?> value='200'>RM200</option>
                    <option <?php echo vali_iif('300' == $refund_dep, 'Selected', ''); ?> value='300'>RM300</option>
                    <option <?php echo vali_iif('400' == $refund_dep, 'Selected', ''); ?> value='400'>RM400</option>
                    <option <?php echo vali_iif('500' == $refund_dep, 'Selected', ''); ?> value='500'>RM500</option>
                    <option <?php echo vali_iif('600' == $refund_dep, 'Selected', ''); ?> value='600'>RM600</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit Status</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="refund_dep_payment" class="form-control" required>
                    
                    <option value="" disabled>Please Select</option>
                    <option <?php echo vali_iif('Collect' == $refund_dep_payment, 'Selected', ''); ?> value='Collect'>Collect</option>
                    <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
                    <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
                    <option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
                    <option <?php echo vali_iif('Nil' == $refund_dep_payment, 'Selected', ''); ?> value='Nil'>Nil</option>
                    <option <?php echo vali_iif('Return' == $refund_dep_payment, 'Selected', ''); ?> value='Return'>Return</option>
                    <option <?php echo vali_iif('Closing' == $refund_dep_payment, 'Selected', ''); ?> value='Closing'>Closing</option>

                  </select>
                </div>
              </div>

              <b>Survey</b>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Survey</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="survey_type" class="form-control" id="survey" onchange="change();">
                    <option value="">Please Select</option>
                    <option <?php echo vali_iif('Banner' == $survey_type, 'Selected', ''); ?> value='Banner'>Banner</option>
                    <option <?php echo vali_iif('Bunting' == $survey_type, 'Selected', ''); ?> value='Bunting'>Bunting</option>
                    <option <?php echo vali_iif('Facebook Ads' == $survey_type, 'Selected', ''); ?> value='Freinds'>Facebook Ads</option>
                    <option <?php echo vali_iif('Freind' == $survey_type, 'Selected', ''); ?> value='Freinds'>Freinds</option>
                    <option <?php echo vali_iif('Google Ads' == $survey_type, 'Selected', ''); ?> value='Google Ads'>Google Ads</option>
                    <option <?php echo vali_iif('Magazine' == $survey_type, 'Selected', ''); ?> value='Magazine'>Magazine</option>
                    <option <?php echo vali_iif('Others' == $survey_type, 'Selected', ''); ?> value='Others'>Others</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" name="username" value="<?php echo $name;?>" disabled>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" data-dismiss="modal" data-toggle="modal" data-target=".bs-edit-modal-lg" class="btn btn-default">Back</button>
                <button class="btn btn-primary" name="btn_change_cust" value="upload" type="submit">Update</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

                    <!-- Extend modal -->
                      <div class="modal fade" id='modal_extend' tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          </div>
                        </div>
                      </div>

                      <div class="modal fade bs-extend-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Extend</h4>
                          </div>
                      

                          <div class="modal-body">
                            <form method="GET" data-parsley-validate class="form-horizontal form-label-left" action='extend.php'>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Extend from</label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <input type="date" autocomplete="off" class="form-control" id="extend_from_date" name="extend_from_date" onkeydown="return false" value='<?php echo date("Y-m-d",strtotime($return_date)); ?>' required>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <select name="extend_from_time" class="form-control" required>
                                    <option value="">Return Time</option>
                                    <option <?php echo vali_iif('08:00:00' == $return_time, 'Selected', ''); ?> value="08:00">08.00</option>
                                    <option <?php echo vali_iif('08:30:00' == $return_time, 'Selected', ''); ?> value="08:30">08.30</option>
                                    <option <?php echo vali_iif('09:00:00' == $return_time, 'Selected', ''); ?> value="09:00">09.00</option>
                                    <option <?php echo vali_iif('09:30:00' == $return_time, 'Selected', ''); ?> value="09:30">09.30</option>
                                    <option <?php echo vali_iif('10:00:00' == $return_time, 'Selected', ''); ?> value="10:00">10.00</option>
                                    <option <?php echo vali_iif('10:30:00' == $return_time, 'Selected', ''); ?> value="10:30">10.30</option>
                                    <option <?php echo vali_iif('11:00:00' == $return_time, 'Selected', ''); ?> value="11:00">11.00</option>
                                    <option <?php echo vali_iif('11:30:00' == $return_time, 'Selected', ''); ?> value="11:30">11.30</option>
                                    <option <?php echo vali_iif('12:00:00' == $return_time, 'Selected', ''); ?> value="12:00">12.00</option>
                                    <option <?php echo vali_iif('12:30:00' == $return_time, 'Selected', ''); ?> value="12:30">12.30</option>
                                    <option <?php echo vali_iif('13:00:00' == $return_time, 'Selected', ''); ?> value="13:00">13.00</option>
                                    <option <?php echo vali_iif('13:30:00' == $return_time, 'Selected', ''); ?> value="13:30">13.30</option>
                                    <option <?php echo vali_iif('14:00:00' == $return_time, 'Selected', ''); ?> value="14:00">14.00</option>
                                    <option <?php echo vali_iif('14:30:00' == $return_time, 'Selected', ''); ?> value="14:30">14.30</option>
                                    <option <?php echo vali_iif('15:00:00' == $return_time, 'Selected', ''); ?> value="15:00">15.00</option>
                                    <option <?php echo vali_iif('15:30:00' == $return_time, 'Selected', ''); ?> value="15:30">15.30</option>
                                    <option <?php echo vali_iif('16:00:00' == $return_time, 'Selected', ''); ?> value="16:00">16.00</option>
                                    <option <?php echo vali_iif('16:30:00' == $return_time, 'Selected', ''); ?> value="16:30">16.30</option>
                                    <option <?php echo vali_iif('17:00:00' == $return_time, 'Selected', ''); ?> value="17:00">17.00</option>
                                    <option <?php echo vali_iif('17:30:00' == $return_time, 'Selected', ''); ?> value="17:30">17.30</option>
                                    <option <?php echo vali_iif('18:00:00' == $return_time, 'Selected', ''); ?> value="18:00">18.00</option>
                                    <option <?php echo vali_iif('18:30:00' == $return_time, 'Selected', ''); ?> value="18:30">18.30</option>
                                    <option <?php echo vali_iif('19:00:00' == $return_time, 'Selected', ''); ?> value="19:00">19.00</option>
                                    <option <?php echo vali_iif('19:30:00' == $return_time, 'Selected', ''); ?> value="19:30">19.30</option>
                                    <option <?php echo vali_iif('20:00:00' == $return_time, 'Selected', ''); ?> value="20:00">20.00</option>
                                    <option <?php echo vali_iif('20:30:00' == $return_time, 'Selected', ''); ?> value="20:30">20.30</option>
                                    <option <?php echo vali_iif('21:00:00' == $return_time, 'Selected', ''); ?> value="21:00">21.00</option>
                                    <option <?php echo vali_iif('21:30:00' == $return_time, 'Selected', ''); ?> value="21:30">21.30</option>
                                    <option <?php echo vali_iif('22:00:00' == $return_time, 'Selected', ''); ?> value="22:00">22.00</option>
                                    <option <?php echo vali_iif('22:30:00' == $return_time, 'Selected', ''); ?> value="22:30">22.30</option>
                                    <option <?php echo vali_iif('23:00:00' == $return_time, 'Selected', ''); ?> value="23:00">23.00</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Extend to</label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <input type="date" autocomplete="off" class="form-control" id="extend_to_date" name="extend_to_date" onkeydown="return false" required>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <select name="extend_to_time" class="form-control" required>
                                    <option value="">Pickup Time</option>
                                    <option value="08:00">08.00</option>
                                    <option value="08:30">08.30</option>
                                    <option value="09:00">09.00</option>
                                    <option value="09:30">09.30</option>
                                    <option value="10:00">10.00</option>
                                    <option value="10:30">10.30</option>
                                    <option value="11:00">11.00</option>
                                    <option value="11:30">11.30</option>
                                    <option value="12:00">12.00</option>
                                    <option value="12:30">12.30</option>
                                    <option value="13:00">13.00</option>
                                    <option value="13:30">13.30</option>
                                    <option value="14:00">14.00</option>
                                    <option value="14:30">14.30</option>
                                    <option value="15:00">15.00</option>
                                    <option value="15:30">15.30</option>
                                    <option value="16:00">16.00</option>
                                    <option value="16:30">16.30</option>
                                    <option value="17:00">17.00</option>
                                    <option value="17:30">17.30</option>
                                    <option value="18:00">18.00</option>
                                    <option value="18:30">18.30</option>
                                    <option value="19:00">19.00</option>
                                    <option value="19:30">19.30</option>
                                    <option value="20:00">20.00</option>
                                    <option value="20:30">20.30</option>
                                    <option value="21:00">21.00</option>
                                    <option value="21:30">21.30</option>
                                    <option value="22:00">22.00</option>
                                    <option value="22:30">22.30</option>
                                    <option value="23:00">23.00</option>
                                  </select>
                                </div>
                              </div>

                              <div class="modal-footer">
                                <input type="hidden" value='<?php echo $vehicle_id; ?>' name='vehicle_id'>
                                <input type="hidden" value='<?php echo $booking_id; ?>' name='booking_id'>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" type="button" class="btn btn-primary">Next</button>
                              </div>

                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="x_content">
   
  <!-- /// -->

  <div class="row">
                      <div class="col-md-4" style="text-align: center;">
                 <img width="240px" src='assets/img/<?php echo $company_image; ?>?nocache=<?php echo time(); ?>'>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                <div class="row">
                  <h4><?php echo $company_name; ?></h4>
                  <p><?php echo $website_name; ?></p>
                  <p><?php echo $company_address; ?></p>
                  <p><?php echo $company_phone_no; ?></p>
                  <p><?php echo $registration_no; ?></p>
                  
                  <div >
                      Reference No.
                      <div class="form-group">
                          <div class='input-group date' id='myDatepicker'>
                              <input class="form-control" type="text" name="refno" value="<?php echo $agreement_no;?>" disabled>
                              
                          </div>
                      </div>
                  </div>
                </div>
                            </div>
                      </div>

        
                 </div>
  <div class="ln_solid"></div>
  <!-- /// -->

  <!-- /// -->
                      <br />
         
                    </div>

                  </div>


                  <!-- Start Customer Information -->

                    <?php
   $sql = "SELECT
    vehicle.id AS vehicle_id,
    booking_trans.pickup_date AS pickup_date,
    booking_trans.pickup_time AS pickup_time,
    CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
    booking_trans.return_date AS return_date,
    CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
    concat(firstname,' ' ,lastname) AS fullname,
    concat(make, ' ', model) AS car,
    reg_no,
    nric_no,
    address,
    phone_no,
    phone_no2,
    email,
    license_no,
    sub_total AS sub_total2,
    est_total AS est_total2,
    refund_dep,
    refund_dep_payment,
    car_in_image,
    car_in_start_engine,
    car_in_no_alarm,
    car_in_air_conditioner,
    car_in_radio,
    car_in_power_window,
    car_in_window_condition,
    car_in_perfume,
    car_in_carpet,
    car_in_sticker_p,
    car_in_lamp,
    car_in_engine_condition,
    car_in_tyres_condition,
    car_in_jack,
    car_in_tools,
    car_in_signage,
    car_in_child_seat,
    car_in_wiper,
    car_in_gps,
    car_in_tyre_spare,
    car_in_usb_charger,
    car_in_touch_n_go,
    car_in_smart_tag,
    car_in_seat_condition,
    car_in_cleanliness,
    car_in_fuel_level,
    car_in_remark,
    car_out_image,
    car_out_sign_image,
    car_out_start_engine,
    car_out_no_alarm,
    car_out_air_conditioner,
    car_out_radio,
    car_out_power_window,
    car_out_window_condition,
    car_out_perfume,
    car_out_carpet,
    car_out_sticker_p,
    car_out_lamp,
    car_out_engine_condition,
    car_out_tyres_condition,
    car_out_jack,
    car_out_tools,
    car_out_signage,
    car_out_child_seat,
    car_out_wiper,
    car_out_gps,
    car_out_tyre_spare,
    car_out_usb_charger,
    car_out_touch_n_go,
    car_out_smart_tag,
    car_out_seat_condition,
    car_out_cleanliness,
    car_out_fuel_level,
    car_out_remark,
    agreement_no,
    car_in_checkby,
    car_add_driver,
    car_cdw,
    car_driver,
    MIN(sale.id) AS sale_id2,
    sale.pickup_date AS sale_pickup_date,
    sale.return_date AS sale_return_date,
    total_sale,
    agent_id,
    identity_photo_front,
    identity_photo_back
    FROM customer
    JOIN booking_trans ON customer.id = customer_id 
    JOIN vehicle ON vehicle_id = vehicle.id
    JOIN checklist ON checklist.booking_trans_id = booking_trans.id
    JOIN sale ON sale.booking_trans_id = booking_trans.id
    WHERE booking_trans.id=".$_GET['booking_id']." AND sale.type='Sale'"; 

    db_select($sql); 
    

    if (db_rowcount() > 0) { 

      func_setSelectVar(); 
      // func_setReqVar(); 

    } 

      // echo "<br>pickup_date: ".$pickup_date;
    ?>


                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Customer Information</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $fullname; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $nric_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone No
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $phone_no; ?>" disabled>
                          </div>
                        </div>

                        <?php
                          if($license_no != NULL)
                          {
                        ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone No 2<br><i>Optional</i>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control" value="<?php if($phone_no2 == NULL){ echo '-'; } else{ echo $phone_no2;} ?>" disabled>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Driving License</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control" value="<?php echo $license_no; ?>" disabled>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Address
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control" value="<?php echo $address; ?>" disabled>
                              </div>
                            </div>
                        <?php
                          }
                        ?>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Email
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $email; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">NRIC Image Front & Back
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <a href="view_image.php?type=customer&image_name=<?php echo $identity_photo_front; ?>"><img width='100%' style="border:5px solid grey" src='assets/img/customer/<?php echo $identity_photo_front; ?>'></a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <a href="view_image.php?type=customer&image_name=<?php echo $identity_photo_back; ?>"><img width='100%' style="border:5px solid grey" src='assets/img/customer/<?php echo $identity_photo_back; ?>'></a>
                            </div>
                          </div>
                        </div>
                        
                        

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Working/Utilities/Others
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <a href="view_image.php?type=customer&image_name=<?php echo $working_photo; ?>"><img width='100%' style="border:5px solid grey" src='assets/img/customer/<?php echo $working_photo; ?>'></a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <a href="view_image.php?type=customer&image_name=<?php echo $utility_photo; ?>"><img width='100%' style="border:5px solid grey" src='assets/img/customer/<?php echo $utility_photo; ?>'></a>
                            </div>
                          </div>
                        </div>
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>

                  <!-- End Customer Information -->


                  <!-- Start Payment Information -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Payment Information</h2>
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
                      <form id="" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                          
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Date?</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type='hidden' name='date_edit2' id='date_edit2' value='true' disabled>
                            <label class='switch'>
                              <input id='date_toggle2' type="checkbox">
                              <span class='slider round'></span>
                            </label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" class="form-control" name='sale_pickup_date' id='sale_pickup_date' value="<?php echo date('Y-m-d', strtotime($pickup_date)); ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="sale_pickup_time" id='sale_pickup_time' class="form-control" disabled>
                              <option <?php echo vali_iif('08:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                              <option <?php echo vali_iif('08:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                              <option <?php echo vali_iif('09:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                              <option <?php echo vali_iif('09:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                              <option <?php echo vali_iif('10:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                              <option <?php echo vali_iif('10:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                              <option <?php echo vali_iif('11:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                              <option <?php echo vali_iif('11:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                              <option <?php echo vali_iif('12:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                              <option <?php echo vali_iif('12:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                              <option <?php echo vali_iif('13:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                              <option <?php echo vali_iif('13:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                              <option <?php echo vali_iif('14:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                              <option <?php echo vali_iif('14:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                              <option <?php echo vali_iif('15:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                              <option <?php echo vali_iif('15:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                              <option <?php echo vali_iif('16:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                              <option <?php echo vali_iif('16:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                              <option <?php echo vali_iif('17:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                              <option <?php echo vali_iif('17:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                              <option <?php echo vali_iif('18:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                              <option <?php echo vali_iif('18:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                              <option <?php echo vali_iif('19:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                              <option <?php echo vali_iif('19:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                              <option <?php echo vali_iif('20:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                              <option <?php echo vali_iif('20:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                              <option <?php echo vali_iif('21:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                              <option <?php echo vali_iif('21:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                              <option <?php echo vali_iif('22:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                              <option <?php echo vali_iif('22:30' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                              <option <?php echo vali_iif('23:00' == date('H:i', strtotime($pickup_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="date" class="form-control" name='sale_return_date' id='sale_return_date' value="<?php echo date('Y-m-d', strtotime($return_date)); ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="sale_return_time" id='sale_return_time' class="form-control" disabled>
                              <option <?php echo vali_iif('08:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                              <option <?php echo vali_iif('08:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                              <option <?php echo vali_iif('09:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                              <option <?php echo vali_iif('09:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                              <option <?php echo vali_iif('10:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                              <option <?php echo vali_iif('10:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                              <option <?php echo vali_iif('11:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                              <option <?php echo vali_iif('11:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                              <option <?php echo vali_iif('12:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                              <option <?php echo vali_iif('12:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                              <option <?php echo vali_iif('13:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                              <option <?php echo vali_iif('13:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                              <option <?php echo vali_iif('14:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                              <option <?php echo vali_iif('14:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                              <option <?php echo vali_iif('15:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                              <option <?php echo vali_iif('15:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                              <option <?php echo vali_iif('16:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                              <option <?php echo vali_iif('16:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                              <option <?php echo vali_iif('17:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                              <option <?php echo vali_iif('17:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                              <option <?php echo vali_iif('18:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                              <option <?php echo vali_iif('18:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                              <option <?php echo vali_iif('19:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                              <option <?php echo vali_iif('19:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                              <option <?php echo vali_iif('20:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                              <option <?php echo vali_iif('20:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                              <option <?php echo vali_iif('21:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                              <option <?php echo vali_iif('21:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                              <option <?php echo vali_iif('22:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                              <option <?php echo vali_iif('22:30' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                              <option <?php echo vali_iif('23:00' == date('H:i', strtotime($return_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                            </select>
                          </div>
                        </div>

                        <div class="ln_solid"></div>
                        
                        <?php if($occupation == 'Admin' || $occupation == 'Manager'){ ?>
                        
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Sale?</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type='hidden' name='sale_edit2' id='sale_edit2' value='true' disabled>
                            <input type='hidden' name='sale_id2' id='sale_id2' value='<?php echo $sale_id2; ?>' disabled>
                            <input type='hidden' name='agent_id2' id='agent_id2' value='<?php echo $agent_id; ?>' disabled>
                            <input type='hidden' name='sale_pickup_date2' id='sale_pickup_date2' value='<?php echo $pickup_date; ?>' disabled>
                            <input type='hidden' name='sale_return_date2' id='sale_return_date2' value='<?php echo $return_date; ?>' disabled>
                            <label class='switch'>
                              <input id='sale_toggle2' type="checkbox">
                              <span class='slider round'></span>
                            </label>
                          </div>
                        </div>

                        <?php
                          }
                          
                          if($agent_id != '0')
                          {
                        ?>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><font size="1"><i>before agent deduction - </i></font>Sale (RM)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min='0.01' step='0.01' class="form-control" name="sale2" value="<?php echo $sub_total; ?>" id="sale2" required disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><font size="1"><i>after agent deduction - </i></font> Sale (RM)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min='0.01' step='0.01' class="form-control" name="agentsale2" value="<?php echo $est_total2; ?>" id="agentsale2" required disabled>
                          </div>
                        </div>
                        
                        <?php
                          }
                          else
                          {
                        ?>
                        
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale (RM)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min='0.01' step='0.01' class="form-control" name="sale2" value="<?php echo $est_total2; ?>" id="sale2" required disabled>
                          </div>
                        </div>

                        <?php
                          }
                        ?>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit (RM)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="refund_dep2" id="refund_dep2" class="form-control" disabled>
                            <option <?php echo vali_iif('0' == $refund_dep, 'Selected', ''); ?> value='0'>0.00</option>
                            <option <?php echo vali_iif('50' == $refund_dep, 'Selected', ''); ?> value='50'>50.00</option>
                            <option <?php echo vali_iif('100' == $refund_dep, 'Selected', ''); ?> value='100'>100.00</option>
                            <option <?php echo vali_iif('200' == $refund_dep, 'Selected', ''); ?> value='200'>200.00</option>
                            <option <?php echo vali_iif('300' == $refund_dep, 'Selected', ''); ?> value='300'>300.00</option>
                            <option <?php echo vali_iif('400' == $refund_dep, 'Selected', ''); ?> value='400'>400.00</option>
                            <option <?php echo vali_iif('500' == $refund_dep, 'Selected', ''); ?> value='500'>500.00</option>
                            <option <?php echo vali_iif('600' == $refund_dep, 'Selected', ''); ?> value='600'>600.00</option>
                          </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="refund_dep_payment2" id="refund_dep_payment2" class="form-control" disabled>
                            <option <?php echo vali_iif('Collect' == $refund_dep_payment, 'Selected', ''); ?> value='Collect'>Collect</option>
                            <option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
                            <option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
                            <option <?php echo vali_iif('Card' == $refund_dep_payment, 'Selected', ''); ?> value='Card'>Card</option>
                            <option <?php echo vali_iif('Nil' == $refund_dep_payment, 'Selected', ''); ?> value='Nil'>Nil</option>
                            <option <?php echo vali_iif('Return' == $refund_dep_payment, 'Selected', ''); ?> value='Return'>Return</option>
                            <option <?php echo vali_iif('Closing' == $refund_dep_payment, 'Selected', ''); ?> value='Closing'>Closing</option>
                          </select>
                          </div>
                        </div>
                        
                        <br>
                        <center>
                          <input class="btn btn-success" style="width: 200px;" type='submit' name='submit_sale' value="Submit">
                        </center>

                        <script>
                          document.getElementById('date_toggle2').onchange = function() {
                              document.getElementById('sale_pickup_date').disabled = !this.checked;
                              document.getElementById('sale_pickup_time').disabled = !this.checked;
                              document.getElementById('sale_return_date').disabled = !this.checked;
                              document.getElementById('sale_return_time').disabled = !this.checked;
                              document.getElementById('date_edit2').disabled = !this.checked;
                          };
                          document.getElementById('sale_toggle2').onchange = function() {
                              document.getElementById('sale2').disabled = !this.checked;
                              document.getElementById('sale_edit2').disabled = !this.checked;
                              document.getElementById('sale_pickup_date2').disabled = !this.checked;
                              document.getElementById('sale_return_date2').disabled = !this.checked;
                              document.getElementById('sale_id2').disabled = !this.checked;
                              document.getElementById('agent_id2').disabled = !this.checked;
                              document.getElementById('refund_dep2').disabled = !this.checked;
                              document.getElementById('refund_dep_payment2').disabled = !this.checked;
                          };
                        </script>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="ln_solid"></div>
                        </div>
                      </form>
                        <?php
                          if(isset($submit_sale))
                          {

                            // echo "<br>sale_pickup_date: ".$_POST['sale_pickup_date'];
                            // echo "<br>sale_pickup_time: ".$sale_pickup_time;
                            // echo "<br>sale_return_date: ".$_POST['sale_return_date'];
                            // echo "<br>sale_return_time: ".$sale_return_time;
                            // echo "<br>sale2: ".$sale2;
                            // echo "<br>sale_edit2: ".$sale_edit2;
                            // echo "<br>sale_id2: ".$sale_id2;
                            // echo "<br>agent_id2: ".$agent_id2;
                            // echo "<br>refund_dep2: ".$refund_dep2;
                            // echo "<br>refund_dep_payment2: ".$refund_dep_payment2;

                            $sale_sql = "";
                            $booking_sql = "";

                            if($sale_edit2 == 'true')
                            {
                              $sale2 = $sale2;
                              $sale_pickup_time = $_POST['sale_pickup_time2'];
                              $sale_pickup_date = $_POST['sale_pickup_date2']. " ".$sale_pickup_time;
                              $sale_return_time = $_POST['sale_return_time2'];
                              $sale_return_date = $_POST['sale_return_date2']. " ".$sale_return_time;
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
                              $refund_dep2 = $refund_dep;
                              $refund_dep_payment2 = $refund_dep_payment;
                            }

                            // echo "<br> sale2: ".$sale2;
                            // echo "<br> refund_dep2: ".$refund_dep2;
                            // echo "<br> refund_dep_payment2: ".$refund_dep_payment2;

                            if($date_edit2 == 'true')
                            {
                              $sale_pickup_time = $_POST['sale_pickup_time'];
                              $sale_pickup_date = $_POST['sale_pickup_date']. " ".$sale_pickup_time;
                              $sale_return_time = $_POST['sale_return_time'];
                              $sale_return_date = $_POST['sale_return_date']. " ".$sale_return_time;

                              $booking_sql = " pickup_date = '".$sale_pickup_date."', return_date = '".$sale_return_date."', pickup_time = '".$sale_pickup_time.":00', return_time = '".$sale_return_time.":00', ";

                              $sale_sql = " pickup_date = '".$sale_pickup_date."', return_date = '".$sale_return_date."',";

                            }

                            $day = dateDifference($sale_pickup_date, $sale_return_date, '%a');

                            if($agent_id != '0')
                            {
                              // kat sini nak buat kira2 utk agent

                              $day_agent = $day;
                              
                              $sql = "SELECT * FROM agent_rate";

                              db_select($sql);

                              func_setSelectVar();

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
                              
                              $sql = "UPDATE booking_trans SET
                                  ".$booking_sql."
                                  est_total = '$sale2',
                                  refund_dep = '$refund_dep2',
                                  refund_dep_payment = '$refund_dep_payment2'
                                  WHERE id = '$booking_id'
                              ";
                            }

                            db_update($sql);

                            // echo $sql;

                            if($sale_id2 != '' OR $sale_id2 != null)
                            {
                              $sql = "UPDATE sale SET
                                  total_sale = '$sale2',
                                  ".$sale_sql."
                                  total_day = '$day',
                                  mid = '".$_SESSION['cid']."',
                                  modified = '".date('Y-m-d H:i:s', time())."'
                                  WHERE id = '$sale_id2'
                              ";

                              db_update($sql);
                            }

                            $sql = "UPDATE sale SET
                                deposit = '$refund_dep2',
                                ".$sale_sql."
                                mid = '".$_SESSION['cid']."',
                                modified = '".date('Y-m-d H:i:s', time())."'
                                WHERE booking_trans_id = '$booking_id' AND type = 'Booking'
                            ";

                            db_update($sql);

                            $sql = "SELECT * FROM sale WHERE booking_trans_id = '$booking_id' AND type = 'Return'";

                            db_select($sql);

                            if(db_rowcount() > 0)
                            {
                              $sql = "UPDATE sale SET
                                  deposit = '-$refund_dep2',
                                  ".$sale_sql."
                                  mid = '".$_SESSION['cid']."',
                                  modified = '".date('Y-m-d H:i:s', time())."'
                                  WHERE booking_trans_id = '$booking_id' AND type = 'Return'
                              ";

                              db_update($sql);
                            }

                            $sql = "DELETE FROM sale_log WHERE sale_id ='$sale_id2'";

                            db_update($sql);

                            $sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 
                            db_select($sql); 

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();

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

                            // echo "<br><br>1631) datelog: ".$datelog;

                            $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
                            $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
                            $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h'); 


                            $a = 0;

                            // echo "<br><br>1638) day: ".$day;

                            $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

                            // echo "<br><br>1640) datenew: ".$datenew;

                            while($datelog <= $datenew)
                            {

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

                                $monthname = 'dis';
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

                                db_update($sql);

                                // echo "<br><br>1641) sql1: ".$sql;

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

                                db_update($sql);

                                // echo "<br><br>1641) sql2: ".$sql;

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
                                  $monthname,
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

                                db_update($sql);

                                // echo "<br><br>1641) sql3: ".$sql;

                              }

                              $datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$pickup_time;

                              $a = $a +1;

                              echo "<script>
                                  window.alert('Normal sale has been successfully modified');
                                  window.location.href='reservation_list_view.php?booking_id=$booking_id';
                                </script>";
                            }
                          }
                        ?>

                      </form>
                    </div>
                  </div>
                  <!-- End Payment Information -->


                  <!-- Start Vehicle Information -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Vehicle Information</h2>
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
                      <form action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                          
                        <?php
                        // if($available == "Booked") 
                        // {
                          ?>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Change Vehicle?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='vehicle_edit2' id='vehicle_edit2' value='true' disabled>
                              <label class='switch'>
                                <input id='vehicle_toggle2' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>
                          <?php
                        // }
                        $sql = "SELECT 
                            id AS vehicle_id1,
                            reg_no AS reg_no1,
                            CONCAT(make, ' ', model) AS car1
                            FROM vehicle
                            WHERE availability = 'Available' OR availability = 'Out' OR availability = 'Booked' OR id = '$vehicle_id'
                            ORDER BY reg_no ASC
                            ";

                        db_select($sql);

                        if (db_rowcount() > 0) {

                          func_setSelectVar(); 
                        } 
                        ?>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="car2" id="car2" class="form-control" disabled>
                              <?php
                                for($i=0;$i<db_rowcount();$i++){
                                  ?>
                                  <option value="<?php echo db_get($i,0); ?>" <?php echo vali_iif(db_get($i,0) == $vehicle_id,'Selected','') ?>><?php echo db_get($i,1).' - '.db_get($i,2); ?></option>
                                  <?php
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <?php
                        // if($available == "Booked") 
                        // {
                          ?>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Coupon</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control" name="coupon2" id="coupon2" disabled>
                            </div>
                          </div>
                          <?php
                        // }
                        ?>
                      
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_location; ?>" disabled>
                          </div>
                        </div>

                        <?php
                        // if($available == "Booked")
                        // {
                          ?>

                          <br>
                          <center>
                            <input class="btn btn-success" style="width: 200px;" type='submit' id='submit_vehicle' name='submit_vehicle' value="Submit" disabled>
                          </center>

                          <script>
                            document.getElementById('vehicle_toggle2').onchange = function() {
                                document.getElementById('car2').disabled = !this.checked;
                                document.getElementById('coupon2').disabled = !this.checked;
                                document.getElementById('submit_vehicle').disabled = !this.checked;
                            };
                          </script>

                          <?php
                        // }
                          if(isset($submit_vehicle))
                          {

                            $sql = "SELECT payment_details FROM booking_trans WHERE id = '$booking_id'";

                            db_select($sql);

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();
                            }

                            $sql = "SELECT class_id FROM vehicle WHERE id = '$car2'";

                            db_select($sql);

                            if (db_rowcount() > 0) {

                              func_setSelectVar();

                              $pickup_date = date('m/d/Y', strtotime($pickup_date));
                              $pickup_time = $pickup_time;
                              $return_date = date('m/d/Y', strtotime($return_date));
                              $return_time = $return_time;

                              $sql = "SELECT * FROM car_rate WHERE class_id = '$class_id'";

                              db_select($sql);

                              $daylog = '0';
                              $datelog = date('Y/m/d', strtotime($pickup_date)).' '.$pickup_time;

                              $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
                              $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
                              $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');

                              if (db_rowcount() > 0) { 

                                func_setSelectVar();
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

                              $difference_hour = $time - 12; 

                              if($day <= '30')
                              {
                                include('sale_calculation.php');
                              }
                              else if($day > '30')
                              {

                                $day = $day - 30;

                                include('sale_calculation.php');
                                
                                $subtotal = $subtotal + $dbcar_rate_monthly;
                              }

                              $subtotal_init = $subtotal;

                              $couponvalidity = 'Not inserted';

                              $resultcoupon = 'Vehicle has been successfully changed';

                              $est_total = $subtotal;

                              if($coupon2 != '' || $coupon2 != null)
                              {

                                $sql = "SELECT * FROM discount WHERE code='$coupon2' AND (value_in != 'D' AND value_in != 'H')";

                                db_select($sql);

                                if (db_rowcount() > 0) {

                                  func_setSelectVar();

                                  $couponvalidity = 'valid';

                                  $dbdis_code = $code;
                                  // echo "<br>695) code: ".$code;
                                  $dbdis_start_date = $start_date;
                                  // echo "<br>697) start_date: ".$start_date;
                                  $dbdis_end_date = $end_date;
                                  // echo "<br>699) end_date: ".$end_date;
                                  $dbdis_value_in = $value_in;
                                  // echo "<br>701) value_in: ".$value_in;
                                  $dbdis_rate = $rate;
                                  // echo "<br>703) rate: ".$rate;
                                  // echo "<br>705) pickupdate: ".date('m/d/Y', strtotime($pickup_date));
                                  // echo "<br>706) pickupdatedb: ".date('m/d/Y', strtotime($dbdis_start_date));

                                  $Discount = number_format($dbdis_rate,2);

                                  // echo "Discount null :".$Discount;

                                  
                                  if(date('m/d/Y', strtotime($pickup_date))>=date('m/d/Y', strtotime($dbdis_start_date)) && date('m/d/Y', strtotime($return_dates)) <= date('m/d/Y', strtotime($dbdis_end_date)) && $couponvalidity == 'valid') 
                                  {

                                    $resultcoupon = 'Coupon has been successfully submitted and vehicle has been changed';

                                    if($dbdis_value_in=='A'){

                                      if($coupon2 == 'LOYALTY150' && $est_total < $dbdis_rate)
                                      {

                                        $Discount = $est_total;
                                        $est_total = '0';
                                      }
                                      else{

                                        $est_total = $est_total - $dbdis_rate;
                                        $Discount = number_format($dbdis_rate,2);
                                      }
                                      $coupontype = 'money';
                                    }

                                    else if($dbdis_value_in=='P'){

                                      $percent = $est_total * ($dbdis_rate/100);
                                      $est_total = $est_total - $percent;
                                      $Discount = number_format($percent,2);
                                      $coupontype = 'money';
                                    }
                                  }
                                  else {

                                    $couponvalidity = 'invalid';
                                    $resultcoupon = 'Coupon is inactive';
                                  }
                                }
                                else
                                {
                                  
                                  $couponvalidity = 'invalid';
                                  $resultcoupon = 'Coupon is not valid for changing vehicle';
                                }
                              }

                              if($couponvalidity == 'valid' || $couponvalidity == 'Not inserted')
                              {

                                $a = 0;

                                $sale = $est_total;
                                $est_total_init = $est_total;

                                $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

                                $sql = "UPDATE booking_trans SET vehicle_id = '$car2', sub_total = '$subtotal_init', est_total = '$est_total_init' WHERE id = '$booking_id'";

                                db_update($sql);
                                // echo "<br>sql booking_trans:".$sql;

                                $sql = "UPDATE sale SET vehicle_id = '$car2', mid = '".$_SESSION['cid']."', modified = '".date('Y-m-d H:i:s', time())."' WHERE booking_trans_id = '$booking_id'";
                                
                                db_update($sql);
                              }
                            }

                            echo "<script>
                                window.alert('".$resultcoupon."');
                                window.location.href='reservation_list_view.php?booking_id=$booking_id';
                              </script>";
                          }
                        ?>
                        <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>
                  <!-- End Vehicle Information -->

                  <!-- Start Vehicle Checklist -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Vehicle Checklist</h2>
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
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Checklist</th>
                            <th>Pickup</th>
                            <th>Return</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">Start Engine</th>
                            <td><?php echo $car_out_start_engine; ?></td>
                            <td><?php echo $car_in_start_engine; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">No Alarm</th>
                            <td><?php echo $car_out_no_alarm; ?></td>
                            <td><?php echo $car_in_no_alarm; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Wiper</th>
                            <td><?php echo $car_out_wiper; ?></td>
                            <td><?php echo $car_in_wiper; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Air Conditioner</th>
                            <td><?php echo $car_out_air_conditioner; ?></td>
                            <td><?php echo $car_in_air_conditioner; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Radio</th>
                            <td><?php echo $car_out_radio; ?></td>
                            <td><?php echo $car_in_radio; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Power Window</th>
                            <td><?php echo $car_out_power_window; ?></td>
                            <td><?php echo $car_in_power_window; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Perfumed</th>
                            <td><?php echo $car_out_perfume; ?></td>
                            <td><?php echo $car_in_perfume; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Carpet</th>
                            <td><?php echo $car_out_carpet; ?></td>
                            <td><?php echo $car_in_carpet; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Lamp</th>
                            <td><?php echo $car_out_lamp; ?></td>
                            <td><?php echo $car_in_lamp; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Engine Condition</th>
                            <td><?php echo $car_out_engine_condition; ?></td>
                            <td><?php echo $car_in_engine_condition; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Tyres Condition</th>
                            <td><?php echo $car_out_tyres_condition; ?></td>
                            <td><?php echo $car_in_tyres_condition; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Jack</th>
                            <td><?php echo $car_out_jack; ?></td>
                            <td><?php echo $car_in_jack; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Tools</th>
                            <td><?php echo $car_out_tools; ?></td>
                            <td><?php echo $car_in_tools; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Signage</th>
                            <td><?php echo $car_out_signage; ?></td>
                            <td><?php echo $car_in_signage; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Tyre Spare</th>
                            <td><?php echo $car_out_tyre_spare; ?></td>
                            <td><?php echo $car_in_tyre_spare; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Sticker P  </th>
                            <td><?php echo $car_out_sticker_p; ?></td>
                            <td><?php echo $car_in_sticker_p; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">USB Charger  </th>
                            <td><?php echo $car_out_usb_charger; ?></td>
                            <td><?php echo $car_in_usb_charger; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Touch N Go  </th>
                            <td><?php echo $car_out_touch_n_go; ?></td>
                            <td><?php echo $car_in_touch_n_go; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">SmartTag  </th>
                            <td><?php echo $car_out_smart_tag; ?></td>
                            <td><?php echo $car_in_smart_tag; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">Child Seat  </th>
                            <td><?php echo $car_out_child_seat; ?></td>
                            <td><?php echo $car_in_child_seat; ?></td>
                          </tr>

                          <tr>
                            <th scope="row">GPS  </th>
                            <td><?php echo $car_out_gps; ?></td>
                            <td><?php echo $car_in_gps; ?></td>
                          </tr>

                        </tbody>
                      </table>
                      
                      <table class="table">
                      
                      <tbody>
                        <tr>
                            <th >CDW</th>
                            <td><?php echo $car_cdw; ?></td>
                            <th>Additional Driver</th>
                            <td><?php echo $car_add_driver; ?></td>
                            <th >Driver</th>
                            <td><?php echo $car_driver; ?></td>
                          </tr>
                        </tbody>

                      </table>

                      </form>
                    </div>
                  </div>
                  <!-- End Vehicle Checklist -->

                  <!-- Start Car Image State -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Car Image State</h2>
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


  <!-- imagestart -->

  <?php

  $sql = "SELECT * FROM upload_data WHERE BOOKING_TRANS_ID='".$_GET['booking_id']."' ORDER BY ID desc LIMIT 7";

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 

  ?>


          <div class="table-responsive">
          <table class="table">
          <tbody>

          <tr>

              <?php

          for($i=7;$i>-1;$i--){

            if(db_get($i,5)!=''|db_get($i,5)!=null ){

              $car_image[$i] = db_get($i,4);

              ?>
          
              <td><a href="view_image.php?type=vehicle&image_name=<?php echo $car_image[$i]; ?>"><img src="assets/img/car_state/<?php echo $car_image[$i].'?nocache='. time(); ?>" style="height:190px;"></a></td>

              <?php
              // echo '<td><img src="assets/img/car_state/'.db_get($i,3).'?nocache='. time().'" style="height:190px; width:280px;"></td>';

            }
          } 
              
        ?>
      </tr>
    </tbody>
  </table>
  </div>


  <!-- imageend -->

                   
                           <div class="ln_solid"></div>


                      </form>
                    </div>
                  </div>
                  <!-- End Car Image State -->

                                  <!-- Start Car Condition -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Car Condition</h2>
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
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Remark P</th>
                            <th>Remark R</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">Car Seat Condition</th>
                            <td><?php echo $car_out_seat_condition; ?></td>
                            <td><?php echo $car_in_seat_condition; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Cleanliness</th>
                            <td><?php echo $car_out_cleanliness; ?></td>
                            <td><?php echo $car_in_cleanliness; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Fuel Level</th>
                            <td><?php echo $car_out_fuel_level; ?></td>
                            <td><?php echo $car_in_fuel_level; ?></td>
                          </tr>

                        </tbody>
                      </table>

                      </form>
                    </div>
                  </div>
                  <!-- End Car Condition -->

                                 <!-- Start Car Condition Pic-->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Remark: | = Scratch | O Broken | △ Dent | □ Missing</h2>
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
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                      <div class="col-md-12">
                                        Pickup
                                      </div>
                                      <div class="col-md-12">
                                        <?php if($car_out_image==''||$car_out_image==null){  ?>
                                        
                                        <center><img src="pickup.jpg?nocache=<?php echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px"></center>
                            
                                        <?php } else{ 
                            
                                        //for pickup image in agreement
                                          
                                        $png = imagecreatefrompng($car_out_image);
                                        $jpeg = imagecreatefromjpeg('pickup.jpg');
                            
                                        list($width, $height) = getimagesize('pickup.jpg');
                                        list($newwidth, $newheight) = getimagesize($car_out_image);
                                        $out = imagecreatetruecolor($newwidth, $newheight);
                                        imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                                        imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
                                        imagejpeg($out, 'give.jpg', 100); ?>
                            
                                        <center><img style="background:url(pickup.jpg); background-size: 450px 225px; size: 450px 225px;" src="<?php echo $car_out_image.'?nocache='.time(); ?>" alt="Girl in a jacket" width="450px" height="225px"></center>
                                        <!--<center><img src="give.jpg?nocache=<?php echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px"></center>-->
                            
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                      <div class="col-md-12">
                                        Return
                                      </div>
                                      <div class="col-md-12">
                                        <?php if($car_in_image==''||$car_in_image==null){   ?>
                        
                                        <center><img src="return2.jpg?nocache=<?php echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px"></center>
                            
                                        <?php } else{
                            
                                        //for return image in agreement
                                        $png2 = imagecreatefrompng($car_in_image);
                                        $jpeg2 = imagecreatefromjpeg('return2.jpg');
                            
                                        list($width2, $height2) = getimagesize('return2.jpg');
                                        list($newwidth2, $newheight2) = getimagesize($car_in_image);
                                        $out2 = imagecreatetruecolor($newwidth, $newheight);
                                        imagecopyresampled($out2, $jpeg2, 0, 0, 0, 0, $newwidth2, $newheight2, $width2, $height2);
                                        imagecopyresampled($out2, $png2, 0, 0, 0, 0, $newwidth2, $newheight2, $newwidth2, $newheight2);
                                        imagejpeg($out2, 'take.jpg', 100);
                                        
                                        ?> 
                            
                                        <center><img style='background:url(return2.jpg); background-size: 450px 225px; size: 450px 225px;' src="<?php echo $car_in_image.'?nocache='.time(); ?>" alt="Girl in a jacket" width="450px" height="225px"></center>
                                        <!--<center><img src="take.jpg?nocache=<?php echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px"></center>-->
                            
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--<div class="table-responsive">-->
                      <!--  <table class="table">-->
                      <!--    <thead>-->
                      <!--      <tr>-->
                      <!--        <th>Pickup</th>-->
                      <!--      </tr>-->
                      <!--    </thead>-->
                      <!--    <tbody>-->
                      <!--      <tr>-->
                      <!--        <td>-->
                                <?php // if($car_out_image==''||$car_out_image==null){  ?>
                                
                      <!--          <img src="pickup.jpg?nocache=<?php //echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px">-->
                                
                                <?php // } else{ 
                                
                                //for pickup
                                
                                // $png = imagecreatefrompng($car_out_image);
                                // $jpeg = imagecreatefromjpeg('pickup.jpg');
                                
                                // list($width, $height) = getimagesize('pickup.jpg');
                                // list($newwidth, $newheight) = getimagesize($car_out_image);
                                // $out = imagecreatetruecolor($newwidth, $newheight);
                                // imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                                // imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
                                // imagejpeg($out, 'give.jpg', 100); 
                                
                                ?>
                    
                                <!--<img src="give.jpg?nocache=<?php // echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px">-->
                    
                                <?php // } ?>
                      <!--        </td>-->
                      <!--      </tr>-->
                      <!--    </tbody>-->
                      <!--    <thead>-->
                      <!--      <tr>-->
                      <!--        <th>Return</th>-->
                      <!--      </tr>-->
                      <!--    </thead>-->
                      <!--    <tbody>-->
                      <!--      <tr>-->
                      <!--        <td>-->
                                <?php // if($car_in_image==''||$car_in_image==null){   ?>
                                
                      <!--          <img src="return2.jpg?nocache=<?php // echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px">-->
                                
                                <?php // } else{
                                
                                //for return
                                // $png2 = imagecreatefrompng($car_in_image);
                                // $jpeg2 = imagecreatefromjpeg('return2.jpg');
                                
                                // list($width2, $height2) = getimagesize('return2.jpg');
                                // list($newwidth2, $newheight2) = getimagesize($car_in_image);
                                // $out2 = imagecreatetruecolor($newwidth, $newheight);
                                // imagecopyresampled($out2, $jpeg2, 0, 0, 0, 0, $newwidth2, $newheight2, $width2, $height2);
                                // imagecopyresampled($out2, $png2, 0, 0, 0, 0, $newwidth2, $newheight2, $newwidth2, $newheight2);
                                // imagejpeg($out2, 'take.jpg', 100);
                                
                                ?> 
                                
                      <!--          <img src="take.jpg?nocache=<?php // echo time(); ?>" alt="Girl in a jacket" width="450px" height="225px">-->
                                
                                <?php // } ?>
                      <!--        </td>-->
                      <!--      </tr>-->
                      <!--    </tbody>-->
                      <!--  </table>-->
                      <!--</div>-->
                      </div>
                    </div>
                  </div>
                  <!-- End Car Condition Pic-->

                  <!-- Start Extend Information -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Extend Information</h2>
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
                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Extend Date</th>
                              <th>Payment Status</th>
                              <th>Payment Type</th>
                              <th>Payment Date</th>
                              <th>Rental</th>
                              <th>Payment</th>
                              <th style='text-align: center;'>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          
                          <?php
                          
                            $sql= "SELECT 
                                DATE_FORMAT(extend_from_date,'%Y-%m-%d'),
                                DATE_FORMAT(extend_from_time, '%H:%i'), 
                                DATE_FORMAT(extend_to_date,'%Y-%m-%d'),
                                DATE_FORMAT(extend_to_time, '%H:%i'),
                                payment_status,
                                payment_type,
                                DATE_FORMAT(c_date, '%d/%m/%Y'),
                                total,
                                payment,
                                id
                                FROM extend
                                WHERE booking_trans_id=".$_GET['booking_id']; 
                
                            db_select($sql); 
                
                            if(db_rowcount()>0){
                
                              for($i=0;$i<db_rowcount();$i++){
                
                                $no=$i+1;
                
                                echo "<tr>
                                  <th scope='row'>" . $no . "</th>
                                    <td>".date('d/m/Y',strtotime(db_get($i,0)))." @ ".db_get($i,1)." - ".date('d/m/Y',strtotime(db_get($i,2)))." @ ".db_get($i,3)."</td>
                                    <td>".db_get($i,4)."</td>
                                    <td>".db_get($i,5)."</td>
                                    <td>".db_get($i,6)."</td>
                                    <td>RM ".db_get($i,7)."</td>
                                    <td>RM ".db_get($i,8)."</td>
                                    <td style='text-align: center;'><a href='extendreceipt.php?booking_id=$booking_id&extend_id=".db_get($i,9)."'><button class='btn'><i class='fa fa-print'>&nbsp;</i>Print</button></a>
                                ";
                              
                                if ($occupation == "Admin" || $occupation == "Manager") { 
                                
                                  echo "<a href='extend_edit.php?extend_id=".db_get($i,9)."&booking_id=$booking_id&extend_from_date=".db_get($i,0)."&extend_from_time=".db_get($i,1)."&extend_to_date=".db_get($i,2)."&extend_to_time=".db_get($i,3)."' data-toggle='modal' data-target='#modal_extend'><button class='btn'><i class='fa fa-external-link'>&nbsp;</i>Edit</button></a>";
                
                                  echo '&nbsp; | &nbsp;<font size="3"><a href="delete_extend.php?extend_id='.db_get($i,9).'&confirm=pending&booking_id='.$booking_id.'"><i class="fa fa-trash-o">&nbsp;</i></a></font>';
                                }
                              
                                echo "</td></tr>";
                             
                                $extendrow = db_rowcount();
                              }
                            } else{ echo "<tr><td colspan='8'>No records found</td></tr>"; }
                          ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- End Extend Information -->
                  <?php
                    
                          if(isset($_POST['edit_extend']))
                          {

                            $extend_sql = "";
                            $sale_sql = "";
                            $sale_date_sql = "";
                            $extend_date_sql = "";

                            // echo "<script> alert('date edit: ".$date_edit."'); </script>";

                            if($sale_edit == 'true')
                            {

                              $extend_sql = "total = '$sale', payment = '$payment_extend', payment_status = '".$_POST['payment_status']."', payment_type = '".$_POST['payment_type']."',";
                              $sale_sql = "payment_status ='".$_POST['payment_status']."', payment_type ='".$_POST['payment_type']."',";
                            }
                            else
                            {
                              
                              $sale = $total;
                            }

                            if($date_edit == 'true')
                            {
                              
                              $extend_from_time = $_POST['extend_from_time'];
                              $extend_from_date = $_POST['extend_from_date']. " ".$extend_from_time;
                              $extend_to_time = $_POST['extend_to_time'];
                              $extend_to_date = $_POST['extend_to_date']. " ".$extend_to_time;

                              $sale_date_sql = " pickup_date = '".$extend_from_date."', return_date = '".$extend_to_date."',";
                              $extend_date_sql = " extend_from_date = '".$extend_from_date."', extend_from_time = '".$extend_from_time."', extend_to_date = '".$extend_to_date."', extend_to_time = '".$extend_to_time."',";
                            }
                            else {

                              $extend_from_date = $_POST['sale_extend_from_date'];
                              $extend_from_time = date('H:i:s', strtotime($_POST['sale_extend_from_date']));
                              $extend_to_date = $_POST['sale_extend_to_date'];
                              $extend_to_time = date('H:i:s', strtotime($_POST['sale_extend_to_date']));
                            }
                            
                            $day = dateDifference($extend_from_date, $extend_to_date, '%a');

                            $sql = "UPDATE sale SET
                                total_sale = '$sale',
                                ".$sale_date_sql."
                                ".$sale_sql."
                                total_day = '$day',
                                mid = '".$_SESSION['cid']."',
                                modified = '".date('Y-m-d H:i:s', time())."'
                                WHERE id = '$sale_id'
                            ";

                            db_update($sql);

                            // echo "<br>sql: ".$sql;

                            $sql = "UPDATE extend SET ".$extend_date_sql." ".$extend_sql." m_date = '".date('Y-m-d H:i:s', time())."' WHERE id = '$extend_id'";
                            
                            // echo "<br>day: ".$day;

                            db_update($sql);

                            $sql = "DELETE FROM sale_log WHERE sale_id ='$sale_id'";

                            db_update($sql);

                            $sql = "SELECT payment_status FROM extend WHERE id = '$extend_id'";

                            db_select($sql);

                            if (db_rowcount() > 0) { 

                              func_setSelectVar();

                              if($payment_status == 'Paid' && $payment_extend >= $sale)
                              {

                                $sql = "SELECT * FROM car_rate WHERE class_id=" . $class_id; 
                                db_select($sql); 

                                if (db_rowcount() > 0) { 

                                  func_setSelectVar();

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

                                $pickup_date = date('m/d/Y', strtotime($extend_from_date));
                                $pickup_time = $extend_from_time;
                                $return_date = date('m/d/Y', strtotime($extend_to_date));
                                $return_time = $extend_to_time;
                                $day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a');

                                $daylog = '0';
                                $datelog = date('Y/m/d', strtotime($pickup_date)).' '.$pickup_time;

                                // echo "<br><br>1631) datelog: ".$datelog;

                                $hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h');
                                $day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%a');
                                $time = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($return_date)).$return_time, '%h'); 


                                $a = 0;

                                // echo "<br><br>1638) day: ".$day;

                                $datenew = date('Y/m/d', strtotime($return_date)).' '.$return_time;

                                // echo "<br><br>1640) datenew: ".$datenew;

                                while($datelog <= $datenew)
                                {

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

                                    $monthname = 'dis';
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

                                  if($hourlog != '0' )
                                  {
                                    
                                    
                                    if($time < 5)
                                    {
                                      $daily_sale = $sale;
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

                                    if($sale < $daily_sale)
                                    {
                                      $daily_sale = $sale;
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
                                      '$sale_id',
                                      '$daily_sale',
                                      '0',
                                      '$hourlog',
                                      'hour (extend)',
                                      '$daily_sale',
                                      '$daily_sale',
                                      '$myyear',
                                      '$currdate',
                                      '".date('Y-m-d H:i:s',time())."'
                                    )";

                                    db_update($sql);

                                    $est_total = $sale - $daily_sale;

                                    $hourlog = '0';
                                  }
                                  
                                  else if($hourlog == '0' && $a == '0')
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
                                      '$sale_id',
                                      '0',
                                      '0',
                                      '0',
                                      '0',
                                      'firstday (extend)',
                                      '$myyear',
                                      '$currdate',
                                      '".date('Y-m-d H:i:s',time())."'
                                    )";

                                    db_update($sql);

                                    $est_total = $sale;
                                  }
                                  
                                  else if($hourlog == '0' && $a > 0)
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
                                      '$sale_id',
                                      '$daily_sale',
                                      '$daylog',
                                      'day (extend)',
                                      '0',
                                      '$daily_sale',
                                      '$daily_sale',
                                      '$myyear',
                                      '$currdate',
                                      '".date('Y-m-d H:i:s',time())."'
                                    )";

                                    db_update($sql);
                                  }

                                  $datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$pickup_time;

                                  $a = $a +1;

                                }
                              }
                              else
                              {
                                // echo "<br><br>tak masuk condition payment_status";
                              }
                            }
                            echo "<script>
                                  window.alert('Extend has been successfully modified');
                                  window.location.href='reservation_list_view.php?booking_id=$booking_id';
                                </script>";
                          }
                        ?>


  <!-- Start Receipt -->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Receipt</h2>
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

                       <style type="text/css">
                          .mytable {
                            border-collapse: collapse;
                            width: 100%;
                            background-color: white;
                          }
                          .mytable-head {
                            border: 1px solid black;
                            margin-bottom: 0;
                            padding-bottom: 0;
                          }
                          .mytable-head td {
                            border: 1px solid black;
                          }
                          .mytable-body {
                            border: 1px solid black;
                            border-top: 0;
                            margin-top: 0;
                            padding-top: 0;
                            margin-bottom: 0;
                            padding-bottom: 0;
                          }
                          .mytable-body td {
                            border: 1px solid black;
                            border-top: 0;
                          }
                          .mytable-footer {
                            border: 1px solid black;
                            border-top: 0;
                            margin-top: 0;
                            padding-top: 0;
                          }
                          .mytable-footer td {
                            border: 1px solid black;
                            border-top: 0;
                          }
                        </style>

                      <!-- start table -->
                      <table class="table table-bordered mytable mytable-head" style="width:100%">
                      <thead>
                        <tr>
                          <th>Pay to (Name)</th>
                          <th>Return Date @ Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="30%"><?php echo $fullname; ?></td>
                          <td><?php if($return_date_final == '' || $return_date_final == NULL){ echo date('d/m/Y H:i:s',strtotime($return_date)); } else { echo date('d/m/Y H:i:s', strtotime($return_date_final));} ?></td>
                        </tr>
                      </tbody>

                    </table>

                    <table class="table table-bordered mytable mytable-body" style="width:100%">

                      <thead>
                        <tr>
                          <th width="3%">#</th>
                          <th>Payment To Customer</th>
                          <th>Details</th>
                          <th>Payment Status</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Deposit</td>
                          <td>Pay Deposit To Customer</td>
                          <td><?php echo $refund_dep_payment; ?></td>
                          <td><?php echo 'RM'.$refund_dep; ?></td>
                        </tr>

                        <tr>
                          <td>2</td>
                          <td><?php

                          if($other_details=='' | $other_details==null ){


                                     }else{

                                   echo 'Others';


                                     }

                           ?></td>
                          <td><?php echo $other_details; ?></td>
                          <td><?php echo $other_details_payment_type; ?></td>
                          <td><?php echo 'RM '.$other_details_price; ?></td>
                        </tr>

                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>Total</td>
                          <td><?php 

                          $total_receipt = ($refund_dep + $other_details_price); 

                          if($other_details_price=='' || $other_details_price==null){

                          echo 'RM '.$refund_dep;               

                          }
                          else{

                          echo 'RM '.$total_receipt;                


                          }

                           ?></td>
                        </tr>



                      </tbody>


                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Payment From Customer</th>
                          <th>Details</th>
                          <th>Payment Type</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Outstanding Extend</td>
                          <td><?php echo $outstanding_extend; ?></td>
                          <td><?php echo $outstanding_extend_type_of_payment ?></td>
                          <td><?php echo 'RM '.$outstanding_extend_cost; ?></td>
                        </tr>

                        <tr>
                          <td>2</td>
                          <td>Charges for Damages</td>
                          <td><?php echo $damage_charges_details; ?></td>
                          <td><?php echo $damage_charges_payment_type; ?></td>
                          <td><?php echo 'RM '.$damage_charges; ?></td>
                        </tr>

                        <tr>
                          <td>3</td>
                          <td>Charges items missing items</td>
                          <td><?php echo $missing_items_charges_details; ?></td>
                          <td><?php echo $missing_items_charges_payment_type; ?></td>
                          <td><?php echo 'RM '.$missing_items_charges; ?></td>
                        </tr>

                        <tr>
                          <td>4</td>
                          <td>Additional Cost</td>
                          <td><?php echo $additional_cost_details; ?></td>
                          <td><?php echo $additional_cost_payment_type; ?></td>
                          <td><?php echo 'RM '.$additional_cost; ?></td>
                        </tr>

                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>Total</td>
                          <td><?php 
                          $total_customer_payment = ($outstanding_extend_cost + $damage_charges + $missing_items_charges + $additional_cost);  

                          echo 'RM '.$total_customer_payment; ?></td>
                        </tr>

                      </tbody>

                    </table>

                    
                    <table class="table table-bordered" style="width:100%">


                      <thead>
                        <tr>
                          <th>Prepared By</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?php echo $car_in_checkby; ?></td>
                        </tr>
                      </tbody>

                    </table>
                    <?php

                      if($occupation == 'Operation Staff' && $row['car_out_start_engine'] == '')
                      {

                        echo '<script>alert("Please be reminded that once you have changed, it can not be undone")</script>';
                      }
                    ?>
                         <div class="ln_solid"></div>
                    </form>

                    </div>
                  </div>
                  <!-- End Receipt -->

                </div>
              </div>



            </div>
          </div>
          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>

      <script>
        var time = new Date().getTime();
        $(document.body).bind("mousemove keypress", function(e) {
          time = new Date().getTime();
        });

        function refresh() {
          if(new Date().getTime() - time >= 1200000) 
            window.location.reload(true);
          else 
            setTimeout(refresh, 1200000);
        }

        setTimeout(refresh, 1200000);

      </script>
    </body>
  </html>
<?php
} else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>