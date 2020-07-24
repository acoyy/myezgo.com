<?php
use setasign\Fpdi\Fpdi; 

require_once ('pdf/fpdf.php'); 
require_once ('pdf/autoload.php'); 
include ('_header.php'); 
func_setReqVar(); 

$sql = "SELECT * FROM user WHERE id=".$_SESSION['cid']; 
db_select($sql); 

if (db_rowcount() > 0) {

  func_setSelectVar(); 

} 

$sql = "SELECT
agreement_no,
concat(firstname,' ' ,lastname) as fullname,
phone_no AS customer_phone_no,
reg_no,
model,
class_id,
refund_dep,
pickup_date,
return_date,
sub_total,
est_total,
balance,
discount_coupon,
discount_amount,
p_cost,
p_address,
r_cost,
r_address,
refund_dep_payment,
payment_details,
car_out_child_seat,
car_add_driver,
car_cdw,
car_driver,
car_out_sticker_p,
car_out_usb_charger,
car_out_touch_n_go,
car_out_smart_tag,
agent_id
FROM vehicle
LEFT JOIN booking_trans ON vehicle.id = vehicle_id
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

$pdf = new Fpdi('P','mm',array(203,305));
$pdf->AddPage(); 
$pdf->setSourceFile('assets/document/bookingreceipt.pdf'); 
$tplIdx = $pdf->importPage(1); 
$pdf->useTemplate($tplIdx); 
$pdf->SetFont('Helvetica', '', 10); 
$pdf->SetTextColor(0, 0, 0); 

$pdf->Image('assets/img/'.$company_image, 6.7, 12.6, 16); 

$pdf->SetXY(25, 15); 

$pdf->Write(0, $company_name);

$pdf->Image('assets/img/'.$company_image, 6.7, 163, 16); 

$pdf->SetXY(25, 165.4); 

$pdf->Write(0, $company_name);

$pdf->SetFont('Helvetica', '', 8); 

$pdf->SetTextColor(0, 0, 0); 

$pdf->SetXY(175, 8); 

$pdf->Write(0, date('d/m/Y', time()));

$pdf->SetXY(175, 158.4); 

$pdf->Write(0, date('d/m/Y', time()));

$pdf->SetXY(25, 17.7); 

$pdf->MultiCell(70, 3.5, $company_address, 0); 

$pdf->SetXY(25, 168.1); 

$pdf->MultiCell(70, 3.5, $company_address, 0); 

$pdf->SetXY(25, 27); 

$pdf->Write(0, $company_phone_no);  

$pdf->SetFont('Helvetica', '', 8);  

$pdf->SetXY(25, 177.4); 

$pdf->Write(0, $company_phone_no);  

$pdf->SetFont('Helvetica', '', 8); 

$pdf->SetXY(128.3, 13.5); 

$pdf->Write(0, $agreement_no); 

$pdf->SetXY(128.3, 163.9); 

$pdf->Write(0, $agreement_no); 

$pdf->SetXY(128.3, 16.1); 

$pdf->MultiCell(70, 3.5, $fullname, 0); 

$pdf->SetXY(128.3, 166.5); 

$pdf->MultiCell(70, 3.5, $fullname, 0); 

$pdf->SetXY(128.3, 28); 

$pdf->Write(0, $customer_phone_no);  

$pdf->SetXY(128.3, 178.4); 

$pdf->Write(0, $customer_phone_no); 

$pdf->SetXY(26.5, 32.8); 

$pdf->Write(0, $reg_no); 

$pdf->SetXY(26.5, 183.3); 

$pdf->Write(0, $reg_no);

$pdf->SetXY(101, 32.8); 

$pdf->Write(0, $model); 

$pdf->SetXY(101, 183.3); 

$pdf->Write(0, $model); 

$pdf->SetXY(170, 32.8); 

$pdf->Write(0, "RM ".$refund_dep); 

$pdf->SetXY(170, 183.3); 

$pdf->Write(0, "RM ".$refund_dep); 

$pdf->SetXY(29, 40.05); 

$pdf->Write(0, date('d/m/Y', strtotime($pickup_date))."   @   ".date('h:i A', strtotime($pickup_date))); 

$pdf->SetXY(29, 190.45); 

$pdf->Write(0, date('d/m/Y', strtotime($pickup_date))."   @   ".date('h:i A', strtotime($pickup_date))); 

$pdf->SetXY(103.5, 40.05); 

$pdf->Write(0, date('d/m/Y', strtotime($return_date))."   @   ".date('h:i A', strtotime($return_date))); 

$pdf->SetXY(103.5, 190.45); 

$pdf->Write(0, date('d/m/Y', strtotime($return_date))."   @   ".date('h:i A', strtotime($return_date)));  


$pdf->SetXY(170, 40.3);

$pdf->Write(0, "RM ".$balance); 

$pdf->SetXY(170, 190.6); 

$pdf->Write(0, "RM ".$balance);

// $pdf->SetFont('Helvetica', '', 7);

// $pdf->SetXY(172, 41.5); 

// $pdf->Write(0,'(Unpaid)');

// $pdf->SetXY(172, 191.9); 

// $pdf->Write(0,'(Unpaid)');

$pdf->SetFont('Helvetica', '', 8);

$pdf->SetXY(70, 47.4); 

$pdf->Write(0, $discount_coupon); 

$pdf->SetXY(70, 197.9); 

$pdf->Write(0, $discount_coupon); 

$pdf->SetXY(170, 47.4); 

$pdf->Write(0, "RM ".$discount_amount); 

$pdf->SetXY(170, 197.9); 

$pdf->Write(0, "RM ".$discount_amount); 

$pdf->SetFont('Helvetica', '', 8); 

if($p_cost >= 1){

	$pdf->SetXY(25.3, 57.2); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 207.7); 
	$pdf->Write(0, 'Y');

	$pdf->SetXY(60.1, 52.5); 
	$pdf->Write(0, $p_address); 
	$pdf->SetXY(60.1, 202.8); 
	$pdf->Write(0, $p_address); 

	$pdf->SetXY(25.3, 71.8); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 222.4); 
	$pdf->Write(0, 'Y'); 

	$pdf->SetXY(60.1, 66.8); 
	$pdf->Write(0, $p_address);
	$pdf->SetXY(60.1, 217.3); 
	$pdf->Write(0, $p_address);

	$pdf->SetXY(170, 64.4); 
	$pdf->Write(0, 'RM '.$p_cost);
	$pdf->SetXY(170, 214.7); 
	$pdf->Write(0, 'RM '.$p_cost); 

} elseif($r_cost >= 1){ 

	$pdf->SetXY(25.3, 62.2); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 212.7); 
	$pdf->Write(0, 'Y'); 

	$pdf->SetXY(60.1, 67); 
	$pdf->Write(0, $r_address);
	$pdf->SetXY(60.1, 202.8); 
	$pdf->Write(0, $r_address); 

	$pdf->SetXY(25.3, 76.7); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 227.28); 
	$pdf->Write(0, 'Y'); 

	$pdf->SetXY(60.1, 66.8); 
	$pdf->Write(0, $r_address); 
	$pdf->SetXY(60.1, 217.3); 
	$pdf->Write(0, $r_address); 

	$pdf->SetXY(170, 64.4); 
	$pdf->Write(0, 'RM '.$r_cost); 
	$pdf->SetXY(170, 214.7); 
	$pdf->Write(0, 'RM '.$r_cost); 

} else { 

	$pdf->SetXY(25.3, 52.5); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 202.8); 
	$pdf->Write(0, 'Y'); 

	$pdf->SetXY(60.1, 52.5); 
	$pdf->Write(0, $pickup_location); 
	$pdf->SetXY(60.1, 202.8); 
	$pdf->Write(0, $pickup_location); 

	$pdf->SetXY(25.3, 66.8); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 217.5); 
	$pdf->Write(0, 'Y'); 

	$pdf->SetXY(60.1, 66.8); 
	$pdf->Write(0, $return_location); 
	$pdf->SetXY(60.1, 217.3); 
	$pdf->Write(0, $return_location); 

	$pdf->SetXY(170, 64.4); 
	$pdf->Write(0, 'RM 0.00');
	$pdf->SetXY(170, 214.7); 
	$pdf->Write(0, 'RM 0.00');

} 

if($car_add_driver == 'Y') {

	$pdf->SetXY(25.3, 81.5); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(25.3, 231.8); 
	$pdf->Write(0, 'Y');

} 

$pdf->SetXY(170, 81.5); 
$pdf->Write(0, "RM ".number_format($priceFirstRow,2));
$pdf->SetXY(170, 231.8); 
$pdf->Write(0, "RM ".number_format($priceFirstRow,2));

if($car_driver == 'Y') {

	$pdf->SetXY(93.6, 81.5); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(93.6, 231.8); 
	$pdf->Write(0, 'Y');
}

if($car_cdw == 'Y') {

	$pdf->SetXY(25.3, 86.4); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(25.3, 236.7); 
	$pdf->Write(0, 'Y');

}

$pdf->SetXY(170, 86.4); 
$pdf->Write(0, "RM ".number_format($priceCdw,2));
$pdf->SetXY(170, 236.7); 
$pdf->Write(0, "RM ".number_format($priceCdw,2));

if($car_out_sticker_p == 'Y') {

	$pdf->SetXY(25.3, 91.4); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(25.3, 241.7); 
	$pdf->Write(0, 'Y');
}

$pdf->SetXY(170, 91.4); 
$pdf->Write(0, "RM 0.00");
$pdf->SetXY(170, 241.7); 
$pdf->Write(0, "RM 0.00");

if($car_out_usb_charger == 'Y') {

	$pdf->SetXY(93.6, 91.4); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(93.6, 241.7); 
	$pdf->Write(0, 'Y');
}

if($car_out_touch_n_go == 'Y') {

	$pdf->SetXY(25.3, 96.1); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(25.3, 246.4); 
	$pdf->Write(0, 'Y');
}

$pdf->SetXY(170, 96.1); 
$pdf->Write(0, 'RM 0.00');
$pdf->SetXY(170, 246.4); 
$pdf->Write(0, 'RM 0.00');

if($car_out_smart_tag == 'Y') {

	$pdf->SetXY(93.6, 96.1); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(93.6, 246.4); 
	$pdf->Write(0, 'Y');
}

if($car_out_child_seat == 'Y') {

	$pdf->SetXY(93.6, 101); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(93.6, 251.3); 
	$pdf->Write(0, 'Y');
}

$pdf->SetXY(170, 101); 
$pdf->Write(0, "RM ".number_format($priceChildSeat,2));
$pdf->SetXY(170, 251.3); 
$pdf->Write(0, "RM ".number_format($priceChildSeat,2));

$totalall = $priceChildSeat + $priceFirstRow + $priceCdw;

$pdf->SetXY(170, 106); 
$pdf->Write(0, "RM ".number_format($totalall,2));
$pdf->SetXY(170, 256.3); 
$pdf->Write(0, "RM ".number_format($totalall,2));


if($refund_dep_payment == "Cash"){ 

	$pdf->SetXY(25.3, 111); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 261.3); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(50, 115.9); 
	$pdf->Write(0,'RM '.$refund_dep);
	$pdf->SetXY(50, 266.2); 
	$pdf->Write(0,'RM '.$refund_dep); 
}
elseif($refund_dep_payment == "Collect"){ 

	$pdf->SetXY(46, 115.9); 
	$pdf->Write(0,'Collect RM '.$refund_dep);
	$pdf->SetXY(46, 266.2); 
	$pdf->Write(0,'Collect RM '.$refund_dep); 
} 
elseif($refund_dep_payment == "Online"){ 

	$pdf->SetXY(25.3, 115.9); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 266.2); 
	$pdf->Write(0, 'Y');
	$pdf->SetXY(50, 115.9); 
	$pdf->Write(0,'RM '.$refund_dep);
	$pdf->SetXY(50, 266.2); 
	$pdf->Write(0,'RM '.$refund_dep); 
} 

elseif($refund_dep_payment == "Card"){ 

	$pdf->SetXY(25.3, 120.7);
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(25.3, 271);
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(50, 115.9); 
	$pdf->Write(0,'RM '.$refund_dep);
	$pdf->SetXY(50, 266.2); 
	$pdf->Write(0,'RM '.$refund_dep); 
} 

else { 

	$pdf->SetXY(50, 115.9); 
	$pdf->Write(0,' '); 
	$pdf->SetXY(50, 266.2); 
	$pdf->Write(0,' '); 
} 

if($payment_details == "Cash"){ 

	$pdf->SetXY(100, 111); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(100, 261.3); 
	$pdf->Write(0, 'Y');  
}
elseif($payment_details == "Online"){ 

	$pdf->SetXY(100, 115.9); 
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(100, 266.2); 
	$pdf->Write(0, 'Y');
} 

elseif($payment_details == "Card"){ 

	$pdf->SetXY(100, 120.7);
	$pdf->Write(0, 'Y'); 
	$pdf->SetXY(100, 271);
	$pdf->Write(0, 'Y'); 
} 


$pdf->SetXY(119.5, 113.5); 
$pdf->Write(0,"Payment: RM ".$balance); 
$pdf->SetXY(119.5, 263.8); 
$pdf->Write(0,"Payment: RM ".$balance); 

$pdf->SetFont('Helvetica', 'I', 8);

// $balance = '100';

if($agent_id == '0') {
    
    $balancenew = $est_total - $balance;
} else {
    
    $balancenew = $sub_total - $balance;
}

if($balancenew == '0' || $balancenew < '0')
{
	$balancenew = "(Paid)";
	$pdf->SetXY(130, 116.9); 
	$pdf->Write(0,$balancenew); 
	$pdf->SetXY(130, 267.2); 
	$pdf->Write(0,$balancenew); 
}
else if($balancenew > '0')
{

	$balancenew = "(Collect RM ".number_format($balancenew,2).")";
	$pdf->SetXY(120.5, 116.9); 
	$pdf->Write(0,$balancenew); 
	$pdf->SetXY(120.5, 267.2); 
	$pdf->Write(0,$balancenew);  
}

$grandtotal = $refund_dep + $balance;

$pdf->SetFont('Helvetica', '', 8); 
$pdf->SetXY(170, 115.9); 
$pdf->Write(0, 'RM '.number_format($grandtotal,2));
$pdf->SetXY(170, 266.2); 
$pdf->Write(0, 'RM '.number_format($grandtotal,2));

$pdf->SetFont('Helvetica', '', 10); 
$pdf->SetXY(5, 128.7); 
$pdf->Write(0, $username); 
$pdf->SetXY(5, 279); 
$pdf->Write(0, $username); 
$pdf->SetFont('Helvetica', '', 8);
$pdf->SetXY(52, 126.7); 
$pdf->MultiCell(70, 3.5, $fullname, 0, 'L');
$pdf->SetXY(52, 277); 
$pdf->MultiCell(70, 3.5, $fullname, 0, 'L');

ob_clean(); 

header("Content-type:application/pdf"); 
header("Content-Disposition:attachment;filename='downloaded.pdf'"); 
$pdf->Output(); 
ob_end_flush(); 