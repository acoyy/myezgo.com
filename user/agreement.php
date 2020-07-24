<?php
use setasign\Fpdi\Fpdi; 
session_start();
if(isset($_SESSION['cid']))
{ 
   require_once ('pdf/fpdf.php'); 
   require_once ('pdf/autoload.php'); 
   include ('_header.php'); 
   func_setReqVar(); 
   $sql = "SELECT * FROM user WHERE id=".$_SESSION['cid']; 
   db_select($sql); 
   if (db_rowcount() > 0) { 

    func_setSelectVar(); 
    } $sql = "SELECT
   vehicle.id,
   reg_no,
   license_no,
   license_exp,
   model,
   concat(firstname,' ' ,lastname) as fullname,
   nric_no,
   address AS customer_address,
   postcode,
   city,
   country,
   phone_no AS customer_phone_no,
   email,
   ref_name,
   ref_relationship,
   ref_phoneno,
   sub_total,
   payment_details,
   balance,
   est_total,
   refund_dep,
   refund_dep_payment,
   refund_dep_status,
   p_cost,
   p_address,
   p_address2,
   r_cost,
   r_address,
   r_address2,
   other_details,
   other_details_payment_type,
   other_details_price,
   drv_name,
   drv_nric,
   drv_address,
   drv_phoneno,
   drv_license_no,
   drv_license_exp,
   DATE_FORMAT(pickup_date, '%d/%m/%Y') AS pickup_date,
   DATE_FORMAT(pickup_time, '%H:%i:%s') AS pickup_time,
   DATE_FORMAT(return_date, '%d/%m/%Y') AS return_date,
   DATE_FORMAT(return_time, '%H:%i:%s') AS return_time,
   agreement_no
   FROM vehicle
   LEFT JOIN booking_trans ON vehicle.id = vehicle_id
   LEFT JOIN class ON class.id = class_id
   LEFT JOIN customer ON customer_id = customer.id
   WHERE booking_trans.id =" . $_GET['id'];

    db_select($sql); 

    if (db_rowcount() > 0) { 

      func_setSelectVar(); 

    } 


    $pdf = new Fpdi('P', 'mm', array(208, 302)); $pdf->AddPage(); 

    $pdf->setSourceFile('assets/document/agreement.pdf'); 

    $tplIdx = $pdf->importPage(1); 

    $pdf->useTemplate($tplIdx); 

    $pdf->SetFont('Helvetica', '', 10); 

    $pdf->SetTextColor(0, 0, 0); 

    $pdf->Image('assets/img/'.$company_image, 5, 7, 15); 

    $pdf->SetXY(25, 10); 

    $pdf->Write(0, $company_name); 

    $pdf->SetFont('Helvetica', '', 8); 

    $pdf->SetTextColor(0, 0, 0); 

    $pdf->SetXY(25, 12); 

    $pdf->MultiCell(70, 3.5, $company_address, 0); 

    $pdf->SetXY(25, 21); 

    $pdf->Write(0, $company_phone_no); 

    $pdf->SetXY(138, 9);

    $pdf->Write(0, $agreement_no); 

    $pdf->SetXY(150, 3.5); 

    $pdf->Write(0, $reg_no); 

    $pdf->SetFont('Helvetica', '', 8); 

    $pdf->SetXY(174, 3.5); 

    $pdf->Write(0, $pickup_date); 

    $pdf->SetXY(34, 25); 

    $pdf->MultiCell(50, 4, $fullname, 0); 

    $pdf->SetXY(34, 36.5); 

    $pdf->Write(0, $customer_phone_no); 

    $pdf->SetXY(34, 41.5); 

    $pdf->Write(0, $email); 

    $pdf->SetXY(34, 46.5); 

    $pdf->Write(0, $ref_name); 

    $pdf->SetXY(87.5, 46.5); 

    $pdf->Write(0, $ref_relationship); 

    $pdf->SetXY(34, 51.5); 

    if($drv_name == "" && $drv_name == NULL)
    {
      $pdf->Write(0, "No additional Driver"); 
    }
    else{

      $pdf->Write(0, $drv_name); 
    }

    $pdf->SetXY(34, 56.5); 

    $pdf->Write(0, $drv_nric); 

    $pdf->SetXY(145, 51.5); 

    $pdf->Write(0, $drv_license_no); 

    $pdf->SetXY(180, 51.5);  

    if($drv_license_exp != "0000-00-00")
    {

      $pdf->Write(0, date('d/m/Y', strtotime($drv_license_exp))); 
    }
    else
    {
      $pdf->Write(0, "-"); 
    }


    $pdf->SetXY(137, 56.5); 

    $pdf->Write(0, $drv_phoneno); 

    $pdf->SetXY(138, 15); 

    $pdf->Write(0, $nric_no); 

    $pdf->SetXY(138, 21); 

    $pdf->Write(0, $country); 

    $pdf->SetXY(145, 26.5); 

    $pdf->Write(0, date('d/m/Y', strtotime($license_exp))); 

    $pdf->SetXY(180, 26.5); 

    $pdf->Write(0, $license_no); 

    $pdf->SetXY(138, 30); 

    $pdf->MultiCell(63, 4, $customer_address, 0); 

    $pdf->SetXY(138, 41); 

    $pdf->Write(0, $postcode); 

    $pdf->SetXY(148, 41); 

    $pdf->Write(0, $city); 

    $pdf->SetXY(173, 41); 

    $pdf->Write(0, $country); 

    $pdf->SetXY(138, 46.5); 

    $pdf->Write(0, $ref_phoneno); 

    $pdf->SetFont('Helvetica', '', 10);

    $pdf->SetXY(4, 175); 

    $pdf->Write(0, $username); 

    $pdf->SetXY(54, 175); 

    $pdf->Write(0, $fullname); 

    $pdf->SetFont('Helvetica', '', 8); 

    $pdf->SetXY(24, 188.5); 

    $pdf->Write(0, $reg_no); 

    $pdf->SetXY(101, 188.5); 

    $pdf->Write(0, $model); 

    $pdf->SetXY(171, 188.5); 

    $pdf->Write(0, 'RM '.$refund_dep); 

    $pdf->SetXY(24, 195); 

    $pdf->Write(0, $pickup_date); 

    $pdf->SetXY(40, 195); 

    $pdf->Write(0, '@'); 

    $pdf->SetXY(45, 195); 

    $pdf->Write(0, $pickup_time); 

    $pdf->SetXY(101, 195); 

    $pdf->Write(0, $return_date); 

    $pdf->SetXY(118, 195); 

    $pdf->Write(0, '@'); 

    $pdf->SetXY(123, 195); 

    $pdf->Write(0, $return_time); 

    $pdf->SetXY(171, 195); 

    $pdf->Write(0, 'RM'.$sub_total); 

    $pdf->SetXY(24, 201); 

    $pdf->Write(0, ''); 

    $pdf->SetXY(171, 195); 

    $pdf->Write(0, ''); 

    $pdf->SetFont('Helvetica', '', 8); 

    if($p_cost >= 1){

    $pdf->SetXY(24.5, 210); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 206); 
    $pdf->Write(0, $p_address); 
    $pdf->SetXY(24.5, 223); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 220); 
    $pdf->Write(0, $p_address); 
    $pdf->SetXY(180, 206); 
    $pdf->Write(0, 'RM '.$p_cost); 

   } elseif($r_cost >= 1){ 

    $pdf->SetXY(24.5, 214.5); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 206); 
    $pdf->Write(0, $r_address); 
    $pdf->SetXY(24.5, 227.5); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 220); 
    $pdf->Write(0, $r_address); 
    $pdf->SetXY(171, 216); 
    $pdf->Write(0, 'RM '.$r_cost); 

   } else { 
    $pdf->SetXY(24.5, 206); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 206); 
    $pdf->Write(0, $pickup_location); 
    $pdf->SetXY(24.5, 219); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 220); 
    $pdf->Write(0, $return_location); 

   } 

   if($refund_dep_payment == "Cash"){ 

    $pdf->SetXY(24.5, 262); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(44, 266); 
    $pdf->Write(0,'RM '.$refund_dep); 
      } 
      elseif($refund_dep_payment == "Online"){ 

        $pdf->SetXY(24.5, 266); $pdf->Write(0, 'Y'); 
        $pdf->SetXY(44, 266); $pdf->Write(0,'RM '.$refund_dep); 
      } 

      elseif($refund_dep_payment == "Card"){ 

        $pdf->SetXY(24.5, 270);
        $pdf->Write(0, 'Y'); 
        $pdf->SetXY(44, 266); 
        $pdf->Write(0,'RM '.$refund_dep); 

      } 

      else { 

        $pdf->SetXY(44, 266); 
        $pdf->Write(0,' '); 
      } 

      if($payment_details == 'Cash'){ 

        $pdf->SetXY(102, 262); 
        $pdf->Write(0, 'Y'); 
        $pdf->SetXY(122, 266); 
        $pdf->Write(0,'RM '.$sub_total); 

      }

      elseif($payment_details == 'Online'){ 

        $pdf->SetXY(102, 266); 
        $pdf->Write(0, 'Y'); 
        $pdf->SetXY(122, 266); 
        $pdf->Write(0,'RM '.$sub_total); 
      }

      elseif($payment_details == 'Card'){ 

        $pdf->SetXY(102, 270); 
        $pdf->Write(0, 'Y'); 
        $pdf->SetXY(122, 266); 
        $pdf->Write(0,'RM '.$sub_total); 

      }

      else{ 

        $pdf->SetXY(122, 266); 
        $pdf->Write(0,' '); 
      } 

      $total = ($refund_dep + $sub_total + $p_cost + $r_cost); 
      
      if($total >= 1){ 
        $pdf->SetXY(171, 266); 
        $pdf->Write(0, 'RM '.$total); 
      } 

      else { 
        $pdf->SetXY(171, 266); $pdf->Write(0, ' '); 
      } 

      $pdf->SetFont('Helvetica', '', 8); 
      $pdf->SetXY(4, 278); 
      $pdf->Write(0, $username); 
      $pdf->SetXY(54, 275.9); 
      $pdf->MultiCell( 55, 3, $fullname, 0, 'L'); 
    //   $pdf->Write(0, $fullname); 
      $pdf->AddPage(); 
      $tplIdx = $pdf->importPage(2); 
      $pdf->useTemplate($tplIdx); 
      $pdf->SetXY(55, 17.5); 
      $pdf->Write(0, $fullname); 
      $pdf->SetXY(55, 26); 
      $pdf->Write(0, $nric_no); 
      $pdf->SetFont('Helvetica', '', 8); 
      $pdf->SetXY(55, 31); 
      $pdf->MultiCell(70, 4, $customer_address, 0); 
      $pdf->SetXY(55, 41); 
      $pdf->Write(0, $postcode); 
      $pdf->SetXY(65, 41); 
      $pdf->Write(0, $city); 
      $pdf->SetXY(90, 41); 
      $pdf->Write(0, $country); 
      $pdf->SetFont('Helvetica', '', 10); 
      $pdf->SetXY(153, 32.5); 
      $pdf->Write(0, $pickup_date); 
      $pdf->SetXY(145, 95); 
      $pdf->Write(0, $reg_no); 
      $pdf->SetXY(75, 119); 
      $pdf->Write(0, $pickup_date); 
      $pdf->SetXY(125, 119); 
      $pdf->Write(0, $pickup_time); 
      $pdf->SetXY(75, 142); 
      $pdf->Write(0, ''); 
      $pdf->SetXY(121, 142); 
      $pdf->Write(0, ''); 
      $pdf->SetXY(49, 157); 
      $pdf->Write(0, $reg_no); 
      ob_clean(); 
      header("Content-type:application/pdf"); 
      header("Content-Disposition:attachment;filename='downloaded.pdf'"); 
      $pdf->Output(); 
      ob_end_flush(); 

} 
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>