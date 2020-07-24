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
refund_dep,
DATE_FORMAT(extend_from_date, '%m/%d/%Y %H:%i:%s') as pickup_date,
DATE_FORMAT(extend_to_date, '%m/%d/%Y %H:%i:%s') as return_date,
extend.price AS extend_price,
extend.total AS extend_total,
extend.payment AS extend_payment,
p_cost,
p_address,
r_cost,
r_address,
refund_dep_payment,
payment_details,
extend.discount_coupon AS discount_coupon,
extend.discount_amount AS discount_amount
FROM vehicle
LEFT JOIN booking_trans ON vehicle.id = vehicle_id
LEFT JOIN customer ON customer_id = customer.id
LEFT JOIN checklist ON checklist.booking_trans_id = booking_trans.id
LEFT JOIN extend ON extend.id = ".$_GET['extend_id']."
WHERE booking_trans.id =" . $_GET['booking_id'];



db_select($sql); 

if (db_rowcount() > 0) { 

	func_setSelectVar(); 

} 

$pdf = new Fpdi('P','mm',array(203,305));
$pdf->AddPage(); 
$pdf->setSourceFile('assets/document/extendreceipt.pdf'); 
$tplIdx = $pdf->importPage(1); 
$pdf->useTemplate($tplIdx); 
$pdf->SetFont('Helvetica', '', 10); 
$pdf->SetTextColor(0, 0, 0); 

$pdf->Image('assets/img/'.$company_image, 6.7, 12.6, 16); 

$pdf->SetXY(25, 15); 

$pdf->Write(0, $company_name);

$pdf->Image('assets/img/'.$company_image, 6.7, 159, 16); 

$pdf->SetXY(25, 161.4); 

$pdf->Write(0, $company_name); 

$pdf->SetFont('Helvetica', '', 8); 

$pdf->SetTextColor(0, 0, 0); 

$pdf->SetXY(25, 17.7); 

$pdf->MultiCell(70, 3.5, $company_address, 0); 

$pdf->SetXY(25, 164.1); 

$pdf->MultiCell(70, 3.5, $company_address, 0); 

$pdf->SetXY(25, 27); 

$pdf->Write(0, $company_phone_no);  

$pdf->SetFont('Helvetica', '', 8);  

$pdf->SetXY(25, 173.4); 

$pdf->Write(0, $company_phone_no);  

$pdf->SetFont('Helvetica', '', 8); 

$pdf->SetXY(128.3, 13.5); 

$pdf->Write(0, $agreement_no); 

$pdf->SetXY(128.3, 159.9); 

$pdf->Write(0, $agreement_no); 

$pdf->SetXY(128.3, 16.1); 

$pdf->MultiCell(70, 3.5, $fullname, 0); 

$pdf->SetXY(128.3, 162.5); 

$pdf->MultiCell(70, 3.5, $fullname, 0); 

$pdf->SetXY(128.3, 28); 

$pdf->Write(0, $customer_phone_no);  

$pdf->SetXY(128.3, 174.4); 

$pdf->Write(0, $customer_phone_no); 

$pdf->SetXY(26.5, 32.8); 

$pdf->Write(0, $reg_no); 

$pdf->SetXY(26.5, 179.3); 

$pdf->Write(0, $reg_no);

$pdf->SetXY(101, 32.8); 

$pdf->Write(0, $model); 

$pdf->SetXY(101, 179.3); 

$pdf->Write(0, $model); 

$pdf->SetXY(170, 32.8); 

$pdf->Write(0, "RM ".number_format($refund_dep,2)); 

$pdf->SetXY(170, 179.3); 

$pdf->Write(0, "RM ".number_format($refund_dep,2)); 

$pdf->SetXY(29, 40.05); 

$pdf->Write(0, date('d/m/Y', strtotime($pickup_date))."   @   ".date('h:i A', strtotime($pickup_date))); 

$pdf->SetXY(29, 186.45); 

$pdf->Write(0, date('d/m/Y', strtotime($pickup_date))."   @   ".date('h:i A', strtotime($pickup_date))); 

$pdf->SetXY(103.5, 40.05); 

$pdf->Write(0, date('d/m/Y', strtotime($return_date))."   @   ".date('h:i A', strtotime($return_date))); 

$pdf->SetXY(103.5, 186.45); 

$pdf->Write(0, date('d/m/Y', strtotime($return_date))."   @   ".date('h:i A', strtotime($return_date)));


$pdf->SetXY(170, 40.3);

$pdf->Write(0, "RM ".number_format($extend_payment,2)); 

$pdf->SetXY(170, 186.45); 

$pdf->Write(0, "RM ".number_format($extend_payment,2));

// $pdf->SetFont('Helvetica', '', 7);

// $pdf->SetXY(172, 41.5); 

// $pdf->Write(0,'(Unpaid)');

// $pdf->SetXY(172, 191.9); 

// $pdf->Write(0,'(Unpaid)');

$pdf->SetFont('Helvetica', '', 8);

$pdf->SetXY(60, 47.4); 

$pdf->Write(0, $discount_coupon); 

$pdf->SetXY(60, 193.9); 

$pdf->Write(0, $discount_coupon); 

$pdf->SetXY(170, 47.4); 

$pdf->Write(0, "RM ".number_format($discount_amount,2)); 

$pdf->SetXY(170, 193.9); 

$pdf->Write(0, "RM ".number_format($discount_amount,2)); 

$total_cost = $extend_total + $refund_dep;

$balancenew = $extend_total - $extend_payment;

$pdf->SetXY(119.7, 114); 
$pdf->Write(0,"Total Cost: RM ".number_format($total_cost,2)); 
$pdf->SetXY(119.7, 260); 
$pdf->Write(0,"Total Cost: RM ".number_format($total_cost,2)); 

$pdf->SetFont('Helvetica', 'I', 7);

if($balancenew == '0' || $balancenew < '0')
{
    $balancenew = "(Paid)";
}
else if($balancenew > '0')
{
	$balancenew = "(Collect RM ".$balancenew.")";
}

$pdf->SetXY(124.5, 116.9); 
$pdf->Write(0,$balancenew); 
$pdf->SetXY(124.5, 263.2); 
$pdf->Write(0,$balancenew);  
	
$total = $refund_dep + $extend_payment;

$pdf->SetFont('Helvetica', '', 8);

$pdf->SetXY(170, 115.9); 
$pdf->Write(0, 'RM '.number_format($total,2));
$pdf->SetXY(170, 262.2); 
$pdf->Write(0, 'RM '.number_format($total,2));

$pdf->SetFont('Helvetica', '', 10); 
$pdf->SetXY(5, 128.7); 
$pdf->Write(0, $username); 
$pdf->SetXY(5, 275); 
$pdf->Write(0, $username); 
$pdf->SetFont('Helvetica', '', 8);
$pdf->SetXY(52, 126.7); 
$pdf->MultiCell(70, 3.5, $fullname, 0, 'L');
$pdf->SetXY(52, 273); 
$pdf->MultiCell(70, 3.5, $fullname, 0, 'L');

ob_clean(); 

header("Content-type:application/pdf"); 
header("Content-Disposition:attachment;filename='downloaded.pdf'"); 
$pdf->Output(); 
ob_end_flush(); 