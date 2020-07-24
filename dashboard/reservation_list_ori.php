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
  include ("_header.php"); 

  func_setReqVar(); 

  $sql = "SELECT agreement_no, FROM booking_trans WHERE id=".$_GET['booking_id'];

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

          if(isset($_POST['btn_edit'])){


  $sql = "SELECT customer_id FROM booking_trans WHERE id=".$_GET['booking_id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 


          $sql = "UPDATE customer SET 
          title='" . conv_text_to_dbtext3($title) . "',
          firstname='" . conv_text_to_dbtext3($firstname) . "',
          lastname='" . conv_text_to_dbtext3($lastname) . "',
          nric_no='" . conv_text_to_dbtext3($nric_no) . "',
          license_no='" . conv_text_to_dbtext3($license_no) . "',
          license_exp='" . conv_datetodbdate($license_exp) . "',
          age='$age',
          phone_no='" . conv_text_to_dbtext3($phone_no) . "',
          email='" . conv_text_to_dbtext3($email) . "',
          address='" . conv_text_to_dbtext3($address) . "',
          postcode='" . conv_text_to_dbtext3($postcode) . "',
          city='" . conv_text_to_dbtext3($city) . "',
          country='" . conv_text_to_dbtext3($country) . "',
          status='A',
          cid= " . $_SESSION['cid'] . ",
          cdate=CURRENT_TIMESTAMP,
          ref_name='" . conv_text_to_dbtext3($ref_name) . "',
          ref_phoneno='" . conv_text_to_dbtext3($ref_phoneno) . "',
          ref_relationship='" . conv_text_to_dbtext3($ref_relationship) . "',
          ref_address='" . conv_text_to_dbtext3($ref_address) . "',
          drv_name='" . conv_text_to_dbtext3($drv_name) . "',
          drv_nric='" . conv_text_to_dbtext3($drv_nric) . "',
          drv_address='" . conv_text_to_dbtext3($drv_address) . "',
          drv_phoneno='" . conv_text_to_dbtext3($drv_phoneno) . "',
          drv_license_no='" . conv_text_to_dbtext3($drv_license_no) . "',
          drv_license_exp='" . conv_datetodbdate($drv_license_exp) . "',
          survey_type='$survey_type',
          survey_details='" . conv_text_to_dbtext3($survey_details) . "'
           WHERE id='$customer_id'";

          db_update($sql); 



          $sql = "UPDATE booking_trans SET balance = '$payment_amount', refund_dep_payment='$refund_dep_payment', payment_details='$payment_details',refund_dep='$deposit' WHERE id = $id"; 

          db_update($sql); 





            
          }

$sql = "SELECT * FROM booking_trans WHERE id=".$_GET['booking_id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

    } 

          $_SESSION['customer_id'] = $customer_id;
    


          if (isset($_POST['btn_in'])) {

            $upload_dir = "assets/img/"; 
            $img = $_POST['hidden_data']; 
            $img = str_replace('data:image/png;base64,', '', $img); 
            $img = str_replace(' ', '+', $img); 
            $data = base64_decode($img); 
            $file = $upload_dir . time() . ".png"; 
            $success = file_put_contents($file, $data); 
            // print $success ? $file : 'Unable to save the file.'; 

            $sql = "UPDATE checklist SET car_in_start_engine = '$start_engine', car_in_no_alarm = '$no_alarm', car_in_air_conditioner = '$air_conditioner', car_in_radio = '$radio', car_in_power_window = '$power_window', car_in_window_condition = '$window_condition', car_in_perfume = '$perfume', car_in_carpet = '$carpet', car_in_sticker_p = '$sticker', car_in_lamp = '$lamp', car_in_engine_condition = '$engine_condition', car_in_tyres_condition = '$tyres_condition', car_in_jack = '$jack', car_in_tools = '$tools', car_in_signage = '$signage', car_in_child_seat = '$child_seat', car_in_wiper = '$wiper', car_in_gps = '$gps', car_in_tyre_spare = '$tyre_spare', car_in_usb_charger = '$usb_charger', car_in_touch_n_go = '$touch_n_go', car_in_smart_tag = '$smart_tag', car_in_seat_condition = '$car_seat_condition', car_in_cleanliness = '$cleanliness', car_in_fuel_level = '$fuel_level', car_in_image = '$file', car_in_remark = '$remark_return', car_in_checkby = '$name' WHERE booking_trans_id = $id"; 

            db_update($sql); 


          

          
            $sql= "SELECT * FROM booking_trans WHERE agreement_no='$agreement_no'"; 

            db_select($sql); 

            // echo "<script> alert('302) agreement no: ".$agreement_no."'); </script>";

            if(db_rowcount()>0){   

              //update parkextend



              $sql = "UPDATE booking_trans SET 
              other_details = '$other_details', 
              other_details_price = '$other_details_price', 
              other_details_payment_type = '$other_details_payment_type',
              refund_dep = '$refund_dep', 
              refund_dep_payment = '$refund_dep_payment', 
              damage_charges = '$damage_charges', 
              damage_charges_details = '$damage_charges_details', 
              damage_charges_payment_type = '$damage_charges_payment_type', 
              missing_items_charges = '$missing_items_charges', 
              missing_items_charges_details = '$missing_items_charges_details', 
              missing_items_charges_payment_type = '$missing_items_charges_payment_type', 
              additional_cost = '$additional_cost', 
              additional_cost_details = '$additional_cost_details',
              additional_cost_payment_type = '$additional_cost_payment_type',
              outstanding_extend_cost = '$outstanding_extend_charges',
              outstanding_extend_type_of_payment = '$outstanding_extend_payment_type',
              outstanding_extend = '$outstanding_extend', 
              available ='Park' WHERE id = $id"; 

              db_update($sql); 

              // echo "<script> alert('masuk if 330'); </script>";

            }

            else{

              $sql = "UPDATE booking_trans SET 
                other_details = '$other_details', 
                other_details_price = '$other_details_price', 
                other_details_payment_type = '$other_details_payment_type',
                refund_dep = '$refund_dep', 
                refund_dep_payment = '$refund_dep_payment', 
                damage_charges = '$damage_charges', 
                damage_charges_details = '$damage_charges_details', 
                damage_charges_payment_type = '$damage_charges_payment_type', 
                missing_items_charges = '$missing_items_charges', 
                missing_items_charges_details = '$missing_items_charges_details', 
                missing_items_charges_payment_type = '$missing_items_charges_payment_type', 
                additional_cost = '$additional_cost', 
                additional_cost_details = '$additional_cost_details',
                additional_cost_payment_type = '$additional_cost_payment_type',
                outstanding_extend_cost = '$outstanding_extend_charges',
                outstanding_extend_type_of_payment = '$outstanding_extend_payment_type',
                outstanding_extend = '$outstanding_extend' WHERE id = $id
              "; 

              db_update($sql); 

              // echo "<script> alert('masuk else 358'); </script>";

              $sql="SELECT id FROM booking_trans WHERE agreement_no='$agreement_no' ORDER BY id DESC LIMIT 1";

              db_select($sql); 


              for ($i = 0; $i < db_rowcount(); $i++) { 
            
                $extend_latest_id = db_get($i,0);
              }

              $sql = "UPDATE booking_trans SET available ='Park' WHERE id ='$extend_latest_id'"; 

              db_update($sql); 
            }

            // echo "<script> alert('booking id: ".$id."'); </script>";
            // echo "<script> alert('vehicle id: ".$vehicle_id."'); </script>";
            $sql = "UPDATE vehicle SET availability = 'Available' WHERE id=".$vehicle_id;

            db_update($sql); 

            echo "<script type='text/javascript'>window.open('returnreceipt.php?booking_id=".$_GET['booking_id']."');</script>"; 

            // echo "<script>
            //       window.location.href='reservation_list_view.php?booking_id=".$_GET['booking_id']."';
            //     </script>";

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
            $img = $_POST['hidden_datas']; 
            $img = str_replace('data:image/png;base64,', '', $img); 
            $img = str_replace(' ', '+', $img); 
            $data = base64_decode($img); 
            $file = $upload_dir . time() . ".png"; 
            $success = file_put_contents($file, $data); 
            print $success ? $file : 'Unable to save the file.'; 

            $img = $_POST['hidden_data2']; 
            $img = str_replace('data:image/png;base64,', '', $img); 
            $img = str_replace(' ', '+', $img); 
            $data = base64_decode($img); 
            $file2 = $upload_dir . $_SESSION['customer_id'] . ".png";
            $file2name = $_SESSION['customer_id'].".png";
            $success = file_put_contents($file2, $data); 
            // print $success ? $file2 : 'Unable to save the file.'; 

            $sql = "UPDATE checklist SET car_out_start_engine = '$start_engine', car_out_no_alarm = '$no_alarm', car_out_air_conditioner = '$air_conditioner', car_out_radio = '$radio', car_out_power_window = '$power_window', car_out_window_condition = '$window_condition' , car_out_perfume = '$perfume', car_out_carpet = '$carpet', car_out_sticker_p = '$sticker', car_out_lamp = '$lamp', car_out_engine_condition = '$engine_condition', car_out_tyres_condition = '$tyres_condition', car_out_jack = '$jack', car_out_tools = '$tools', car_out_signage = '$signage', car_out_child_seat = '$child_seat' , car_out_wiper = '$wiper', car_out_gps = '$gps' , car_out_tyre_spare = '$tyre_spare', car_out_usb_charger = '$usb_charger', car_out_touch_n_go = '$touch_n_go', car_out_smart_tag = '$smart_tag', car_out_seat_condition = '$car_seat_condition', car_out_cleanliness = '$cleanliness', car_out_fuel_level = '$fuel_level', car_out_image = '$file', car_out_sign_image = '$file2name', car_out_remark = '$remark_pickup', car_out_checkby = '$name' WHERE booking_trans_id = $id"; 

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
            }
            else
            {
              
              $sql = "UPDATE vehicle SET availability = 'Out' WHERE id=".$vehicle_id; 
              db_update($sql);
            }

            if(isset($_FILES['files'])){ 

              foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 

                $file_name = $key.$_FILES['files']['name'][$key]; 

                $file_size =$_FILES['files']['size'][$key]; 

                $file_tmp =$_FILES['files']['tmp_name'][$key]; 

                $file_type=$_FILES['files']['type'][$key]; 

                if($file_size > 2097152){ 

                  $errors[]='File size must be less than 2 MB'; 
                } 

                $sql = "INSERT INTO upload_data (`BOOKING_TRANS_ID`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`) VALUES ('$id','$file_name','$file_size','$file_type'); "; 

                $desired_dir="assets/img/car_state"; 

                if(empty($errors)==true){ 

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

                  db_update($sql); 
                }
              }
            } 

            echo "<script>
              window.location.href='reservation_list_view.php?booking_id=".$_GET['booking_id']."';
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

        if(isset($_POST['btn_extend'])) { 

          func_setReqVar(); 

          $day = dateDifference(conv_datetodbdate($extend_from_date), conv_datetodbdate($extend_to_date),'%d'); 

          $time = dateDifference($extend_from_time, $extend_to_time, '%h'); 

          $rate = "SELECT * FROM car_rate WHERE class_id = '$class_id'"; 

          db_select($rate); 

        if(db_rowcount()>0){ 

          func_setSelectVar(); 

          } 

          $difference_hour = $time - 12; 

        if ($day == 0) { 

          $subtotal = $time * $hour; 

        if ($time == 12) { 

          $subtotal = $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 1) { 

          $subtotal = $oneday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $oneday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $oneday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 2) { 

          $subtotal = $twoday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $twoday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $twoday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 3) { 

          $subtotal = $threeday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $threeday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $threeday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 4) { 

          $subtotal = $fourday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $fourday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $fourday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 5) { 

          $subtotal = $fiveday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $fiveday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $fiveday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 6) { 

          $subtotal = $sixday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $sixday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $sixday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 7) { 

          $subtotal = $weekly + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $weekly + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $weekly + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 8) { 

          $subtotal = $weekly + $oneday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $weekly + $oneday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $weekly + $oneday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif ($day == 9) { 

          $subtotal = $weekly + $twoday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $weekly + $twoday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $weekly + $twoday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif($day == 10) { 

          $subtotal = $weekly + $threeday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $weekly + $threeday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $weekly + $threeday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif($day == 11) { 

          $subtotal = $weekly + $fourday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $weekly + $fourday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $weekly + $fourday + $halfday + ($hour * $difference_hour); 

          } 

          } 

        elseif($day == 12) { 

          $subtotal = $weekly + $fiveday + ($time * $hour); 

        if ($time == 12) { 

          $subtotal = $weekly + $fiveday + $halfday; 

          } 

        elseif ($time >= 13){ 

          $subtotal = $weekly + $fiveday + $halfday + ($hour * $difference_hour); 

        } 

        } elseif($day == 13) { 
          
          $subtotal = $weekly + $sixday + ($time * $hour); 
          if ($time == 12) {
              
            $subtotal = $weekly + $sixday + $halfday;
              
          } elseif ($time >= 13){ 
            
            $subtotal = $weekly + $sixday + $halfday + ($hour * $difference_hour); 
              
          }
          
        } elseif($day == 14) { 
            
          $subtotal = $weekly + $weekly + ($time * $hour); 
          
          if ($time == 12) { 
              
            $subtotal = $weekly + $weekly + $halfday; 
              
          } elseif ($time >= 13){ 
              
            $subtotal = $weekly + $weekly + $halfday + ($hour * $difference_hour); 
              
          } 
            
        } elseif($day == 15) { 
            
          $subtotal = ($weekly * 2) + $oneday + ($time * $hour); 
          
          if ($time == 12) { 
              
            $subtotal = ($weekly * 2) + $oneday + $halfday; 
              
          } elseif ($time >= 13){ 
              
            $subtotal = ($weekly * 2) + $oneday + $halfday + ($hour * $difference_hour); 
              
          } 
            
        } elseif($day == 16) { 
            
          $subtotal = ($weekly * 2) + $twoday + ($time * $hour); 
          
          if ($time == 12) { 
              
            $subtotal = ($weekly * 2) + $twoday + $halfday; 
              
          } elseif ($time >= 13){ 
              
            $subtotal = ($weekly * 2) + $twoday + $halfday + ($hour * $difference_hour); 
              
          } 
            
        } elseif($day == 17) { 
            
          $subtotal = ($weekly * 2) + $threeday + ($time * $hour); 
          
          if ($time == 12) { 
              
            $subtotal = ($weekly * 2) + $threeday + $halfday; 
              
          } elseif ($time >= 13){ 
              
            $subtotal = ($weekly * 2) + $threeday + $halfday + ($hour * $difference_hour); 
              
          } 
            
        } elseif($day == 18) { 
            
          $subtotal = ($weekly * 2) + $fourday + ($time * $hour); 
          
          if ($time == 12) { 
              
            $subtotal = ($weekly * 2) + $fourday + $halfday; 
              
          } elseif ($time >= 13){ 
              
            $subtotal = ($weekly * 2) + $fourday + $halfday + ($hour * $difference_hour); 
              
          } 
            
        } elseif($day == 19) { 
            
          $subtotal = ($weekly * 2) + $fiveday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 2) + $fiveday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 2) + $fiveday + $halfday + ($hour * $difference_hour); } } elseif ($day == 20) { $subtotal = ($weekly * 2) + $sixday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 2) + $sixday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 2) + $sixday + $halfday + ($hour * $difference_hour); } } elseif ($day == 21) { $subtotal = ($weekly * 2) + $weekly + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 2) + $weekly + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 2) + $weekly + $halfday + ($hour * $difference_hour); } } elseif ($day == 22) { $subtotal = ($weekly * 3) + $oneday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $oneday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $oneday + $halfday + ($hour * $difference_hour); } } elseif ($day == 23) { $subtotal = ($weekly * 3) + $twoday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $twoday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $twoday + $halfday + ($hour * $difference_hour); } } elseif ($day == 24) { $subtotal = ($weekly * 3) + $threeday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $threeday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $threeday + $halfday + ($hour * $difference_hour); } } elseif ($day == 25) { $subtotal = ($weekly * 3) + $fourday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $fourday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $fourday + $halfday + ($hour * $difference_hour); } } elseif ($day == 26) { $subtotal = ($weekly * 3) + $fiveday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $fiveday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $fiveday + $halfday + ($hour * $difference_hour); } } else if ($day == 27) { $subtotal = ($weekly * 3) + $sixday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $oneday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $oneday + $halfday + ($hour * $difference_hour); } } elseif ($day == 28) { $subtotal = ($weekly * 3) + $weekly + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 3) + $weekly + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 3) + $weekly + $halfday + ($hour * $difference_hour); } } elseif ($day == 29) { $subtotal = ($weekly * 4) + $oneday + ($time * $hour); if ($time == 12) { $subtotal = ($weekly * 4) + $oneday + $halfday; } elseif ($time >= 13){ $subtotal = ($weekly * 4) + $oneday + $halfday + ($hour * $difference_hour); } } elseif ($day == 30) { $subtotal = $monthly + ($time * $hour); if($time == 12){ $subtotal = $monthly + $halfday; 
      } elseif ($time >= 13){ $subtotal = $monthly + $halfday + ($hour * $difference_hour); }
      } 

          $sql = "SELECT * FROM extend WHERE booking_trans_id=".$_GET['booking_id']; 

          db_select($sql); 

          if(db_rowcount() < 9){ 

            $sql = "INSERT INTO 
                extend 
                (
                booking_trans_id, 
                extend_from_date,
                extend_from_time,
                extend_to_date,
                extend_to_time,
                payment_status,
                payment_type,
                price,
                total,
                vehicle_id
                ) 
                VALUES 
                (
                '".$_GET['booking_id']."', 
                '".conv_datetodbdate($extend_from_date).' '.$extend_from_time.':00'."',
                '$extend_from_time',
                '".conv_datetodbdate($extend_to_date).' '.$extend_to_time.':00'."',
                '$extend_to_time',
                '$payment_status',
                '$payment_type',
                '$price',
                '$price',
                '".$vehicle_id."'
                )"; 



                            db_update($sql); 

                            //start booking


           $sql = "INSERT INTO booking_trans
               (
               agreement_no,
               pickup_date,
               pickup_time,
               return_date,
               return_time,
               option_rental_id,
               cdw,
               vehicle_id,
               status,
               day,
               sub_total,
               customer_id,
               cdate,
               type,
               available,
               payment_details
               )
               VALUES
               (
               '$agreement_no',
               '" . conv_datetodbdate($extend_from_date).' '.$extend_from_time.':00'. "',
               '$extend_from_time',
               '" .conv_datetodbdate($extend_to_date).' '.$extend_to_time.':00'."',
               '$extend_to_time',
               0,
               0,
               " . $vehicle_id . ",
               'E',
               '$day',
               '$price',
               '$customer_id',
               CURRENT_TIMESTAMP,
               0,
                'Extend',
                '$payment_type'
              )
               ";
       
               // end booking

               db_update($sql);

    //place extend

  $sql = "UPDATE booking_trans SET available='Extend' WHERE id =".$_GET['booking_id']; 

  db_update($sql); 

    } else { 

      echo "<script>alert('Extend has reach their limit.')</script>"; 
    } 

            vali_redirect("reservation_list_view.php?booking_id=".$_GET['booking_id']); 
         } ?>



  <style>
  .small .btn, .navbar .navbar-nav > li > a.btn {
    padding: 10px 10px;
  }

  .color-background {
    background-color: #eeeeee;
    border-radius: 5px 5px;
    padding: 10px;
  }

  .modal-backdrop, .modal-backdrop.fade.in {
    opacity: 0;
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
  /*rder: 1px solid #000;*/*/*/
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
                          
                          <a href="#">
                          <button data-toggle="modal" data-target=".bs-pickup-modal-lg" class="btn btn-default" type="button"><i class="fa fa-level-down">&nbsp;</i>Pickup</button></a>

                          <a href="#">
                          <button data-toggle="modal" data-target=".bs-return-modal-lg" class="btn btn-default" type="button"><i class="fa fa-level-up">&nbsp;</i>Return</button></a>


                          <a href="returnreceipt.php?booking_id=<?php echo $_GET['booking_id']; ?>">      
                          <button class="btn btn-default" type="button"><i class="fa fa-file">&nbsp;</i>Return Receipt</button></a>

                          <a href="#">
                          <button data-toggle="modal" data-target=".bs-extend-modal-lg" class="btn btn-default" type="button"><i class="fa fa-external-link">&nbsp;</i>Extend</button></a>&nbsp;

                          <?php

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
                          <a href="#">
                            <button data-toggle="modal" data-target=".bs-edit-modal-lg" class="btn btn-default" type="button"><i class="fa fa-edit">&nbsp;</i>Edit</button></a>&nbsp;

                          <a href="reason_delete.php?agreement_no=<?php echo $agreement_no; ?>&booking_id=<?php echo $id; ?>" onClick="return alert('Please provide reason of deleting this agreement')">
                            <button class="btn btn-default" type="button"><i class="fa fa-trash">&nbsp;</i>Delete</button>
                          </a>
                      </div>

                      
                           
                    <!-- pickup modal -->
          
                    <div class="modal fade bs-pickup-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Pickup</h4>
                          </div>
                          <div class="modal-body">
                                              
                            <form name="modalOut" enctype="multipart/form-data" id="modalOut" data-parsley-validate class="form-horizontal form-label-left"  method="post">

                            <div class="form-group">
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
                              <label class="control-label col-md-3" for="last-name">Reason for Change Vehicle</label>
                              <div class="col-md-6">
                                <input class="form-control" name="reason_chg_car" value="<?php echo $reason_chg_car; ?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3" for="last-name">Total Sale</label>
                              <div class="col-md-6">
                                <input class="form-control" name="total_sale">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3" for="last-name">Amount Collected</label>
                              <div class="col-md-6">
                                <input class="form-control" name="amount_collected" value="<?php echo $balance; ?>" disabled>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3" for="last-name">Balance</label>
                              <div class="col-md-6">
                                <input class="form-control" name="balance" value="<?php echo $total_balance; ?>" disabled>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3" for="last-name">Type Of Payment</label>
                              <div class="col-md-6">
                                <select name="payment" class="form-control">
                                
                                    <option value="">Please Select</option>
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

                                                      echo '<script>alert("Please be reminded that once you have changed, it can not be undone")</script>';
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
                      <canvas id="canvas3" style="border: 1px solid;"></canvas>
                      <!-- <div class="form-group">
                        <a type="button" class="btn btn-sm btn-info" id="marker">Pen</a>
                        <a type="button" class="btn btn-sm btn-info" id="eraser">Eraser</a>
                      </div> -->
                      <script>
                        prepareCanvas3();
                      </script>
                      <div>
                        <input name="hidden_data2" id='hidden_data2' type="hidden"/>
                        <script>
                          function upload() {
                            var board = document.getElementById("board");
                            var canvas3 = document.getElementById("canvas3");
                            var dataURL = board.toDataURL("image/png");
                            var dataURL3 = canvas3.toDataURL("image/png");
                            document.getElementById('hidden_datas').value = dataURL;
                            document.getElementById('hidden_data2').value = dataURL3;
                            var fd = new FormData(document.forms["modalOut"]);

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'reservation_list_view.php', true);
                          
                            xhr.upload.onprogress = function(e) {
                              if (e.lengthComputable) {
                                var percentComplete = (e.loaded / e.total) * 100;
                                console.log(percentComplete + '% uploaded');
                                alert('Succesfully uploaded');
                              }
                            };

                            xhr.onload = function() {

                            };
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
                              <button class="btn btn-primary" name="btn_out" onClick="upload()" value="upload" type="submit">Save changes</button>
                            </div>
                        </form>

                          </div>
                        </div>
                      </div>

                      <!-- return modal -->
            
                      <div class="modal fade bs-return-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                              </button>
                              <h4 class="modal-title" id="myModalLabel">Return</h4>
                            </div>
                            <div class="modal-body">


                              <form name="modalIn" enctype="multipart/form-data" id="modalIn" data-parsley-validate class="form-horizontal form-label-left"  method="post">

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

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Type</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="other_details_payment_type" class="form-control">
                                    <option value='Cash'>Cash</option>
                                    <option value='Online'>Online</option>
                                    <option value='Card'>Card</option>
                                    </select>
                                  </div>
                                </div>

                                <br>


                                <h4>Payment from Customer</h4>

                                <hr>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Outstanding Extend</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="outstanding_extend" class="form-control">
                                      <option value="No Outstanding Extend">No Outstanding Extend</option>
                            
                                        <?php  $value = ""; 

                                        $sql = "SELECT DATE_FORMAT(extend_from_date, '%d/%m/%Y'), DATE_FORMAT(extend_from_time, '%H:%i'), DATE_FORMAT(extend_to_date, '%d/%m/%Y'), DATE_FORMAT(extend_to_time, '%H:%i') FROM extend WHERE booking_trans_id=$id"; 

                                        db_select($sql); 

                                        if(db_rowcount()>0){ 

                                          for($j=0;$j<db_rowcount();$j++) { 

                                            $value = $value."<option value='".db_get($j,0).' - '.db_get($j,1).' @ '.db_get($j,2).' - '.db_get($j,3)."' ".vali_iif(db_get($j,0).' - '.db_get($j,1).' @ '.db_get($j,2).' - '.db_get($j,3)==$outstanding_extend,'Selected','').">".db_get($j,0)." - ".db_get($j,1)." @ ".db_get($j,2)." - ".db_get($j,3)."</option>"; }

                                          } 

                                          echo $value; 

                                        ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Charges for Extend (RM)</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control" name="outstanding_extend_charges" value="<?php echo $outstanding_extend_charges; ?>">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type of Payment</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="outstanding_extend_payment_type" class="form-control">
                                      <option value='Cash' <?php echo vali_iif('Cash' == $outstanding_extend_payment_type, 'Selected', ''); ?>>Cash</option>
                                      <option value='Online' <?php echo vali_iif('Online' == $outstanding_extend_payment_type, 'Selected', ''); ?>>Online</option>
                                      <option value='Card' <?php echo vali_iif('Card' == $outstanding_extend_payment_type, 'Selected', ''); ?>>Card</option>
                                    </select>
                                  </div>
                                </div>

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
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type of Payment</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="damage_charges_payment_type" class="form-control">
                                      <option value='Cash' <?php echo vali_iif('Cash' == $damage_charges_payment_type, 'Selected', ''); ?>>Cash</option>
                                      <option value='Online' <?php echo vali_iif('Online' == $damage_charges_payment_type, 'Selected', ''); ?>>Online</option>
                                      <option value='Card' <?php echo vali_iif('Card' == $damage_charges_payment_type, 'Selected', ''); ?>>Card</option>
                                    </select>
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
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type of Payment</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="missing_items_charges_payment_type" class="form-control">
                                      <option value='Cash' <?php echo vali_iif('Cash' == $missing_items_charges_payment_type, 'Selected', ''); ?>>Cash</option>
                                      <option value='Online' <?php echo vali_iif('Online' == $missing_items_charges_payment_type, 'Selected', ''); ?>>Online</option>
                                      <option value='Card' <?php echo vali_iif('Card' == $missing_items_charges_payment_type, 'Selected', ''); ?>>Card</option>
                                    </select>
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

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Type of Payment</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="additional_cost_payment_type" class="form-control">
                                    <option value='Cash' <?php echo vali_iif('Cash' == $additional_cost_payment_type, 'Selected', ''); ?>>Cash</option>
                                    <option value='Online' <?php echo vali_iif('Online' == $additional_cost_payment_type, 'Selected', ''); ?>>Online</option>
                                    <option value='Card' <?php echo vali_iif('Card' == $additional_cost_payment_type, 'Selected', ''); ?>>Card</option>
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
                                              ?><input type="checkbox" value="Y" id="return_start_engine" name="start_engine" <?php echo vali_iif('Y' == $start_engine, 'Checked', ''); ?>> &nbsp; <?php
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
                              <img src="give.jpg" alt="Girl in a jacket" width="300px" height="180px">
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
                                    alert('Succesfully uploaded');
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
                        </form>

                        </div>
                      </div>
                    </div>

                    <!-- Extend modal -->             
                    </div>
                  </div>



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
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Edit</h4>
                          </div>
                          <div class="modal-body">
                            <form name="editReservation" enctype="multipart/form-data" id="editReservation" data-parsley-validate class="form-horizontal form-label-left"  method="post">

                              <b>Customer Information</b>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC No</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="NRIC No" name="nric_no" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)"> 
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Title</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="title" class="form-control" id="title">
                
                                  <option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
                                  
                                  <option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
                                  
                                  <option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>

                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">First Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" value="<?php echo $lastname; ?>" id="lastname">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Driver's Age</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>" id="age">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Phone No" name="phone_no" value="<?php echo $phone_no; ?>" id="phone_no">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" id="email">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Number</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" id="license_no">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">License Expired</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="License No" name="license_exp" autocomplete="off" value="<?php echo conv_datetodbdate3($license_exp); ?>" id="license_exp">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $address; ?>">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Postcode</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder=" Postcode" name="postcode" value="<?php echo $postcode; ?>" id="postcode">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">City</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="city" class="form-control" id="city">
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
                                  <select ui-jq="chosen" name="country" class="form-control" id="country">
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
                                  <input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno" value="<?php echo $drv_phoneno; ?>" id="ref_phoneno">
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
                                  <input class="form-control" type="text" placeholder="License Expired" name="drv_license_exp" id="drv_license_exp" value="<?php echo conv_datetodbdate3($drv_license_exp); ?>">
                                </div>
                              </div>

                              <b>Reference Information</b>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Reference Name" name="ref_name" value="<?php echo $ref_name; ?>" id="ref_name">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Address</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input class="form-control" placeholder="Reference Address" name="ref_address" id="ref_address" value="<?php echo $ref_address; ?>">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reference Phone No</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Reference Phone No" name="ref_phoneno" value="<?php echo $ref_phoneno; ?>" id="ref_phoneno">
                                </div>
                              </div>

                              <b>Payment Information</b>

                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Amount (MYR)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $balance; ?>" id="payment_amount">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit (MYR)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select name="deposit" class="form-control">
                                    <option value="">Please Select</option>
                                    <option <?php echo vali_iif('50' == $deposit, 'Selected', ''); ?> value='50'>RM50</option>
                                    <option <?php echo vali_iif('100' == $deposit, 'Selected', ''); ?> value='100' selected>RM100</option>
                                    <option <?php echo vali_iif('200' == $deposit, 'Selected', ''); ?> value='200'>RM200</option>
                                    <option <?php echo vali_iif('300' == $deposit, 'Selected', ''); ?> value='300'>RM300</option>
                                    <option <?php echo vali_iif('400' == $deposit, 'Selected', ''); ?> value='400'>RM400</option>
                                    <option <?php echo vali_iif('500' == $deposit, 'Selected', ''); ?> value='500'>RM500</option>
                                    <option <?php echo vali_iif('600' == $deposit, 'Selected', ''); ?> value='600'>RM600</option>
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
                                </div>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" name="btn_edit" onClick="uploadEx()" value="upload" type="submit">Update</button>
                              </div>

                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Edit Modal -->

                    <!-- Extend modal -->             
                    <div class="modal fade bs-extend-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Extend</h4>
                          </div>
                          <div class="modal-body">

  <form method="post" data-parsley-validate class="form-horizontal form-label-left"  method="post">

                        
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Extend from Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="extend_from_date" aria-describedby="inputSuccess2Status" name="extend_from_date" value="" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>  </div>



                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Extend from Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="extend_from_time" class="form-control">
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

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Extend to Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal2" placeholder="extend_to_date" aria-describedby="inputSuccess2Status" name="extend_to_date" value="<?php echo $extend_to_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Extend to Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="extend_to_time" class="form-control">
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
                    </select>   </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="payment_status" class="form-control">
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Type</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="payment_type" class="form-control">

                              <option value='Cash' <?php echo vali_iif('Cash' == $payment_type, 'Selected', ''); ?>>Cash</option>
                              <option value='Online' <?php echo vali_iif('Online' == $payment_type, 'Selected', ''); ?>>Online</option>
                              <option value='Cheque' <?php echo vali_iif('Cheque' == $payment_type, 'Selected', ''); ?>>Cheque</option>
                              <option value='Credit / Debit' <?php echo vali_iif('Credit / Debit' == $payment_type, 'Selected', ''); ?>>Credit / Debit</option>
                            
                            </select> 

                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Price</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">

                            </div>
                        </div>


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button name="btn_extend" type="submit" type="button" class="btn btn-primary">Save changes</button>
                          </div>

                        </form>

                        </div>
                      </div>
                    </div>

                      
                      </div>

                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
   
  <!-- /// -->

  <div class="row">
                      <div class="col-md-4" style="text-align: center;">
                 <img width="240px" src='assets/img/logo.png'>
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
    DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
    DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
    CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
    DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
    DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
    CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
    concat(firstname,' ' ,lastname) AS fullname,
    concat(make, ' ', model) AS car,
    reg_no,
    nric_no,
    address,
    phone_no,
    email,
    license_no,
    sub_total,
    refund_dep,
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
    car_driver
    FROM customer
    JOIN booking_trans ON customer.id = customer_id 
    JOIN vehicle ON vehicle_id = vehicle.id
    JOIN checklist ON booking_trans_id = booking_trans.id
    WHERE booking_trans.id=".$_GET['booking_id']; 

    db_select($sql); 

    if (db_rowcount() > 0) { 

      func_setSelectVar(); 

    } 

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

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone No
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $phone_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Email
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $email; ?>" disabled>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $sub_total; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deposit</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $refund_dep; ?>" disabled>
                          </div>
                        </div>
                      


                   
                           <div class="ln_solid"></div>


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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $car; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Register Number</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $reg_no; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_date; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_time; ?>" disabled>
                          </div>
                        </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_date; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_time; ?>" disabled>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Location</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" value="<?php echo $return_location; ?>" disabled>
                          </div>
                        </div>


                   
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

  $sql = "SELECT * FROM upload_data WHERE BOOKING_TRANS_ID='".$_GET['booking_id']."' ORDER BY ID desc LIMIT 6";

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

          for($i=0;$i<6;$i++){
        
          $no=$i+1; 

          if(db_get($i,4)!=''|db_get($i,4)!=null ){
        
          echo '<td><img src="assets/img/car_state/'.db_get($i,2).'" style="height:190px; width:280px;"></td>';

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
                      <h2>Remark: | = Scratch | O Broden | △ Dent | □ Missing</h2>
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
            <thead>
              <tr>
                <th>Pickup</th>
                <th>Return</th>
              </tr>
            </thead>
            
            <tbody>

            <tr>
      
  <td>
            <?php if($car_out_image==''||$car_out_image==null){  ?>

            
              
            
            <img src="pickup.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php } else{ 

            //for pickup
              
            $png = imagecreatefrompng($car_out_image);
            $jpeg = imagecreatefromjpeg('pickup.jpg');

            list($width, $height) = getimagesize('pickup.jpg');
            list($newwidth, $newheight) = getimagesize($car_out_image);
            $out = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
            imagejpeg($out, 'give.jpg', 100); ?>

            <img src="give.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php } ?>

          </td>

          <td>

            <?php if($car_in_image==''||$car_in_image==null){   ?>
            
            <img src="return2.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php } else{

            //for return
            $png2 = imagecreatefrompng($car_in_image);
            $jpeg2 = imagecreatefromjpeg('return2.jpg');

            list($width2, $height2) = getimagesize('return2.jpg');
            list($newwidth2, $newheight2) = getimagesize($car_in_image);
            $out2 = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($out2, $jpeg2, 0, 0, 0, 0, $newwidth2, $newheight2, $width2, $height2);
            imagecopyresampled($out2, $png2, 0, 0, 0, 0, $newwidth2, $newheight2, $newwidth2, $newheight2);
            imagejpeg($out2, 'take.jpg', 100);

            ?> 

              <img src="take.jpg" alt="Girl in a jacket" width="450px" height="225px">

            <?php }
             ?>

          </td>

          </tr>
          </tbody>
          </table>

          
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
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Extend Date</th>
                            <th>Payment Status</th>
                            <th>Payment Type</th>
                            <th>Payment Date</th>
                            <th>Payment Price</th>
                            </tr>
                         </thead>
                         <tbody>
                      
                      <?php
                      
            $sql= "SELECT 
            DATE_FORMAT(extend_from_date, '%d/%m/%Y'),
            DATE_FORMAT(extend_from_time, '%H:%i'), 
            DATE_FORMAT(extend_to_date, '%d/%m/%Y') AS extend_to_date,
            DATE_FORMAT(extend_to_time, '%H:%i'),
            payment_status,
            payment_type,
            DATE_FORMAT(c_date, '%d/%m/%Y'),
            price
            extend_from_time
            FROM extend
            WHERE booking_trans_id=".$_GET['booking_id']; 

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

                          echo "<tr>
                          <th scope='row'>" . $no . "</th>
                          <td>".db_get($i,0)." @ ".db_get($i,1)." - ".db_get($i,2)." @ ".db_get($i,3)."</td>
                <td>".db_get($i,4)."</td>
                <td>".db_get($i,5)."</td>
                <td>".db_get($i,6)."</td>
                <td>RM ".db_get($i,7)."</td>
                          </tr>";
             
              $extendrow = db_rowcount();


                                  }

                              } else{ echo "<tr><td colspan='8'>No records found</td></tr>"; }
                         

                          ?>

                      </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- End Extend Information -->

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
                          <td><?php echo $return_date; ?></td>
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
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>