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
  pickup_date,
  return_date,
  agreement_no,
  agent_id,
  discount_coupon,
  discount_amount,
  car_out_child_seat,
  car_cdw,
  car_add_driver,
  car_driver,
  car_out_sticker_p,
  car_out_usb_charger,
  car_out_touch_n_go,
  car_out_smart_tag
  FROM vehicle
  LEFT JOIN booking_trans ON vehicle.id = vehicle_id
  LEFT JOIN class ON class.id = class_id
  LEFT JOIN customer ON customer_id = customer.id
  LEFT JOIN checklist ON checklist.booking_trans_id = booking_trans.id
  WHERE booking_trans.id =" . $_GET['id'];

  db_select($sql); 

  if (db_rowcount() > 0) { 

    func_setSelectVar(); 

  } 

  $day = dateDifference($pickup_date, $return_date, '%a');

$sql = "SELECT * FROM class WHERE id = '$class_id'";

db_select($sql);

if(db_rowcount() > 0) {
  
  func_setSelectVar();
}

$sql = "SELECT 
description, 
calculation,
amount_type, 
amount, 
taxable, 
calculation,
pic
FROM option_rental";

db_select($sql);

if (db_rowcount() > 0) {
  
  func_setSelectVar();
}

if($car_add_driver=="Y"){

  $priceAddDriver = db_get(0, 3);
}
else {

  $priceAddDriver = 0;  
}

if($car_cdw=="Y") {

  $priceCdw = $sub_total*((db_get(1, 3))/100);
}
else {

  $priceCdw = 0;
}

if($car_driver=="Y") {

  $priceDriver = (db_get(4, 3))/8;
  $priceDayDriver = ($day*24)*$priceDriver;
  $priceHourDriver = $time*$priceDriver;
  $priceDriverTotal= $priceDayDriver + $priceHourDriver;
}
else {

  $priceDriverTotal = 0;
}

if($car_out_child_seat=="Y") {

  $priceChildSeat = $day * 5;
}
else {

  $priceChildSeat = 0;
}

$priceFirstRow = $priceAddDriver + $priceDriverTotal;


  $pdf = new Fpdi('P', 'mm', array(208, 302)); $pdf->AddPage(); 

  $pdf->setSourceFile('assets/document/agreement.pdf'); 

  $tplIdx = $pdf->importPage(1); 

  $pdf->useTemplate($tplIdx); 

  $pdf->SetFont('Helvetica', '', 10); 

  $pdf->SetTextColor(0, 0, 0); 

  $pdf->Image('assets/img/'.$company_image, 9, 10, 16); 

  $pdf->SetXY(30, 12.5); 

  $pdf->Write(0, $company_name); 

  $pdf->SetFont('Helvetica', '', 8); 

  $pdf->SetTextColor(0, 0, 0); 

  $pdf->SetXY(30, 14.5); 

  $pdf->MultiCell(70, 3.5, $company_address, 0); 

  $pdf->SetXY(30, 24); 

  $pdf->Write(0, $company_phone_no);  

  $pdf->SetXY(148.5, 6.7); 

  $pdf->Write(0, $reg_no) ; 

  $pdf->SetFont('Helvetica', '', 7); 

  $pdf->SetXY(171.7, 7); 

  $pdf->Write(0, date('d/m/Y',strtotime($pickup_date))); 

  $pdf->SetXY(33.5, 27.8); 

  $pdf->MultiCell(68, 3, $fullname, 0); 

  $pdf->SetXY(33.5, 39.8); 

  $pdf->Write(0, $customer_phone_no); 

  $pdf->SetXY(33.5, 44); 

  $pdf->Write(0, $email); 

  $pdf->SetXY(33.5, 49); 

  $pdf->Write(0, $ref_name); 

  $pdf->SetXY(86, 49); 

  $pdf->Write(0, $ref_relationship); 

  $pdf->SetXY(33.5, 54); 

  if($drv_name == "" && $drv_name == NULL)
  {
    $pdf->Write(0, "No additional Driver"); 
  }
  else{

    $pdf->Write(0, $drv_name); 
  }

  $pdf->SetXY(33.5, 58.7); 

  $pdf->Write(0, $drv_nric); 

  $pdf->SetXY(142, 54); 

  $pdf->Write(0, $drv_license_no); 

  $pdf->SetXY(178, 54);  

  if($drv_license_exp != "1970-01-01" && $drv_license_exp != "0000-00-00")
  {

    $pdf->Write(0, date('d/m/Y', strtotime($drv_license_exp))); 
  }
  else
  {
    $pdf->Write(0, "-"); 
  }


  $pdf->SetXY(135, 58.7); 

  $pdf->Write(0, $drv_phoneno); 

  $pdf->SetXY(135, 12.2);

  $pdf->Write(0, $agreement_no);

  $pdf->SetXY(135, 18); 

  $pdf->Write(0, $nric_no); 

  $pdf->SetXY(135, 24.2); 

  $pdf->Write(0, $country); 

  $pdf->SetXY(143.5, 29.8); 

  $pdf->Write(0, date('d/m/Y', strtotime($license_exp))); 

  $pdf->SetXY(170, 29.8); 

  $pdf->Write(0, $license_no); 

  $pdf->SetXY(135, 33.0); 

  $pdf->MultiCell(63, 3, $customer_address, 0); 

  $pdf->SetXY(135, 44.2); 

  $pdf->Write(0, $postcode); 

  $pdf->SetXY(168, 44.2); 

  $pdf->Write(0, $city); 

  $pdf->SetXY(192.2, 44.2); 

  $pdf->Write(0, $country); 

  $pdf->SetXY(135, 49.1); 

  $pdf->Write(0, $ref_phoneno); 

  $pdf->SetFont('Helvetica', '', 10);

  $pdf->SetXY(5, 172.5); 

  $pdf->Write(0, $username); 

  $pdf->SetXY(52, 170.5); 

  $pdf->SetFont('Helvetica', '', 8);

  $pdf->MultiCell(56, 3.5, $fullname, 0);

  $pdf->SetFont('Helvetica', '', 8);

  // $pdf->SetFont('Helvetica', 'IBU', 10); bold italic underline

  $pdf->SetXY(43, 187.3); 

  $pdf->Write(0, $reg_no); 

  $pdf->SetXY(101, 187.3); 

  $pdf->Write(0, $model); 

  $pdf->SetXY(171, 187.3); 

  $pdf->Write(0, 'RM '.$refund_dep); 

  $pdf->SetXY(32.5, 193.5); 

  $pdf->Write(0, date('d/m/Y',strtotime($pickup_date))."   @   ".date('H:i',strtotime($pickup_date))); 

  $pdf->SetXY(106.7, 193.5); 

  $pdf->Write(0, date('d/m/Y',strtotime($return_date))."   @   ".date('H:i',strtotime($return_date)));

  $pdf->SetXY(171, 193.5); 

  if($agent_id != '0')
  {
    $pdf->Write(0, 'RM '.$sub_total); 
  }
  else{
    $pdf->Write(0, 'RM '.$est_total); 
  }

  $pdf->SetXY(32.5, 199.7); 

  $pdf->Write(0, $discount_coupon); 

  $pdf->SetXY(171, 199.7); 

  if($discount_amount != '' && $discount_amount != '0' && $discount_amount != NULL){

    $pdf->Write(0, "RM " . $discount_amount); 
  }

  if($car_add_driver == 'Y') {

    $pdf->SetXY(25.3, 230); 
    $pdf->Write(0, 'Y');

  } 

  $pdf->SetXY(171, 230);
  $pdf->Write(0, "RM ".number_format($priceFirstRow,2));

  if($car_driver == 'Y') {

    $pdf->SetXY(93.6, 230); 
    $pdf->Write(0, 'Y');
  }

  if($car_cdw == 'Y') {

    $pdf->SetXY(25.3, 235); 
    $pdf->Write(0, 'Y');

  }

  $pdf->SetXY(171, 235); 
  $pdf->Write(0, "RM ".number_format($priceCdw,2));

  if($car_out_sticker_p == 'Y') {

    $pdf->SetXY(25.3, 239.8); 
    $pdf->Write(0, 'Y');
  }

  $pdf->SetXY(171, 239.8); 
  $pdf->Write(0, "RM 0.00");

  if($car_out_usb_charger == 'Y') {

    $pdf->SetXY(93.6, 239.8); 
    $pdf->Write(0, 'Y');
  }

  if($car_out_touch_n_go == 'Y') {

    $pdf->SetXY(25.3, 244.7); 
    $pdf->Write(0, 'Y');
  }

  $pdf->SetXY(171, 244.7); 
  $pdf->Write(0, 'RM 0.00');

  if($car_out_smart_tag == 'Y') {

    $pdf->SetXY(93.6, 244.7); 
    $pdf->Write(0, 'Y');
  }

  if($car_out_child_seat == 'Y') {

    $pdf->SetXY(93.6, 249.5); 
    $pdf->Write(0, 'Y');
  }

  $pdf->SetXY(171, 249.5); 
  $pdf->Write(0, "RM ".number_format($priceChildSeat,2));

  $totalall = $priceChildSeat + $priceFirstRow + $priceCdw;

  $pdf->SetXY(171, 254.5); 
  $pdf->Write(0, "RM ".number_format($totalall,2));

  $pdf->SetFont('Helvetica', '', 8); 

  if($p_cost >= 1){

  $pdf->SetXY(25, 208.8); 
  $pdf->Write(0, 'Y'); 
  $pdf->SetXY(60.5, 204.6); 
  $pdf->Write(0, $p_address); 
  $pdf->SetXY(25, 221.3); 
  $pdf->Write(0, 'Y'); 
  $pdf->SetXY(60.5, 217.1); 
  $pdf->Write(0, $p_address); 
  $pdf->SetXY(180, 208.8); 
  $pdf->Write(0, 'RM '.$p_cost); 

  } elseif($r_cost >= 1){ 

    $pdf->SetXY(25, 212.9); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 204.6); 
    $pdf->Write(0, $r_address); 
    $pdf->SetXY(25, 225.6); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 217.1); 
    $pdf->Write(0, $r_address); 
    $pdf->SetXY(180, 221.3); 
    $pdf->Write(0, 'RM '.$r_cost); 

  } else { 
    
    $pdf->SetXY(25, 204.6); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 204.6); 
    $pdf->Write(0, $pickup_location); 
    $pdf->SetXY(25, 217.1); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(60.5, 217.1); 
    $pdf->Write(0, $return_location); 

  } 

  if($refund_dep_payment == "Cash"){ 

    $pdf->SetXY(25, 259); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(47, 263.2); 
    $pdf->Write(0,'RM '.$refund_dep); 
  } 
  elseif($refund_dep_payment == "Online"){ 

    $pdf->SetXY(25, 263.2); $pdf->Write(0, 'Y'); 
    $pdf->SetXY(47, 263.2); $pdf->Write(0,'RM '.$refund_dep); 
  } 

  elseif($refund_dep_payment == "Card"){ 

    $pdf->SetXY(25, 267.5);
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(47, 263.2); 
    $pdf->Write(0,'RM '.$refund_dep); 

  } 

  else { 

    $pdf->SetXY(47, 263.2); 
    $pdf->Write(0,' '); 
  } 

  if($payment_details == 'Cash'){ 

    $pdf->SetXY(99.5, 259); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(126, 263.2); 
    if($agent_id != '0')
    {
      $pdf->Write(0, 'RM '.$sub_total); 
    }
    else{
      $pdf->Write(0, 'RM '.$est_total); 
    }
  }

  elseif($payment_details == 'Online'){ 

    $pdf->SetXY(99.5, 263.2); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(126, 263.2);
    if($agent_id != '0')
    {
      $pdf->Write(0, 'RM '.$sub_total); 
    }
    else{
      $pdf->Write(0, 'RM '.$est_total); 
    }
  }

  elseif($payment_details == 'Card'){ 

    $pdf->SetXY(99.5, 267.5); 
    $pdf->Write(0, 'Y'); 
    $pdf->SetXY(126, 263.2);
    if($agent_id != '0')
    {
      $pdf->Write(0, 'RM '.$sub_total); 
    }
    else{
      $pdf->Write(0, 'RM '.$est_total); 
    } 

  }

  else{ 

    $pdf->SetXY(122, 263.2); 
    $pdf->Write(0,' '); 
  }   

  if($agent_id != '0')
  {
    $total = ($refund_dep + $sub_total + $p_cost + $r_cost); 
  }
  else{
    $total = ($refund_dep + $est_total + $p_cost + $r_cost);
  }
  
  if($total >= 1){ 
    $pdf->SetXY(171, 263.2); 
    $pdf->Write(0, 'RM '.number_format($total,2)); 
  } 

  else { 
    $pdf->SetXY(171, 263.2); $pdf->Write(0, ' '); 
  } 

  $pdf->SetFont('Helvetica', '', 10); 
  $pdf->SetXY(5, 276); 
  $pdf->Write(0, $username); 
  $pdf->SetXY(52, 273.5); 
  $pdf->SetFont('Helvetica', '', 8);
  $pdf->MultiCell(56, 3.5, $fullname, 0, 'L');
  $pdf->AddPage(); 
  $tplIdx = $pdf->importPage(2); 
  $pdf->useTemplate($tplIdx); 
  $pdf->SetXY(55, 17.5); 
  $pdf->Write(0, $fullname); 
  $pdf->SetXY(55, 26); 
  $pdf->Write(0, $nric_no); 
  $pdf->SetFont('Helvetica', '', 8); 
  $pdf->SetXY(55, 31); 
  $pdf->MultiCell(70, 3, $customer_address, 0); 
  $pdf->SetXY(55, 41.5); 
  $pdf->Write(0, $postcode); 
  $pdf->SetXY(92, 41.5); 
  $pdf->Write(0, $city); 
  $pdf->SetXY(119, 41.5); 
  $pdf->Write(0, $country); 
  $pdf->SetFont('Helvetica', '', 10); 
  $pdf->SetXY(153, 32.5); 
  $pdf->Write(0, date('d/m/Y',strtotime($pickup_date))); 
  $pdf->SetXY(145, 95); 
  $pdf->Write(0, $reg_no); 
  $pdf->SetXY(75, 119); 
  $pdf->Write(0, date('d/m/Y',strtotime($pickup_date))); 
  $pdf->SetXY(125, 119); 
  $pdf->Write(0, date('H:i',strtotime($pickup_date))); 
  $pdf->SetXY(75, 142); 
  $pdf->Write(0, ''); 
  $pdf->SetXY(121, 142); 
  $pdf->Write(0, ''); 
  $pdf->SetXY(49, 157); 
  $pdf->Write(0, $reg_no); 
  ob_clean(); 
  header("Content-type:application/pdf"); 
  header("Content-Disposition:attachment;filename='test.pdf'"); 
  
  // // create pdf to specific folder
  // $filename="../dashboard/return_receipt.pdf";
  // $pdf->Output('F',$filename);
  
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