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
vehicle.id,
reg_no,
license_no,
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
balance,
est_total,
refund_dep,
refund_dep_status,
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
car_in_checkby,
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
car_out_checkby,
total,
other_details,
other_details_payment_type,
other_details_price,
damage_charges,
damage_charges_details,
damage_charges_payment_type,
missing_items_charges,
missing_items_charges_details,
missing_items_charges_payment_type,
additional_cost,
additional_cost_details,
additional_cost_payment_type,
outstanding_extend,
outstanding_extend_cost,
outstanding_extend_type_of_payment,
DATE_FORMAT(pickup_date, '%d/%m/%Y') AS pickup_date,
DATE_FORMAT(pickup_time, '%H:%i') AS pickup_time,
DATE_FORMAT(return_date, '%d/%m/%Y') AS return_date,
DATE_FORMAT(return_time, '%H:%i') AS return_time,
SUM(extend.total) AS total_ext,
agreement_no
FROM vehicle
LEFT JOIN booking_trans ON vehicle.id = vehicle_id
LEFT JOIN customer ON customer_id = customer.id
LEFT JOIN checklist ON checklist.booking_trans_id = booking_trans.id
LEFT JOIN extend ON extend.booking_trans_id = booking_trans.id
WHERE booking_trans.id =" . $_GET['booking_id'];



db_select($sql); 

if (db_rowcount() > 0) { 

	func_setSelectVar(); 

	} 

	$pdf = new Fpdi('P','mm',array(203,305));
	$pdf->AddPage(); 
	$pdf->setSourceFile('assets/document/returnreceipt.pdf'); 
	$tplIdx = $pdf->importPage(1); 
	$pdf->useTemplate($tplIdx); 
	$pdf->SetFont('Helvetica', '', 10); 
	$pdf->SetTextColor(0, 0, 0); 
	$pdf->Image('assets/img/'.$company_image, 5, 8, 20); 
	$pdf->SetXY(25, 12); 
	$pdf->Write(0, $company_name); 
	$pdf->SetFont('Helvetica', '', 8); 
	$pdf->SetTextColor(0, 0, 0); 
	$pdf->SetXY(25, 14); 
	$pdf->MultiCell(70, 3.5, $company_address, 0); 
	$pdf->SetXY(25, 23); 
	$pdf->Write(0, $company_phone_no); 
	$pdf->SetXY(137, 8); 
	$pdf->Write(0, $agreement_no);
	$pdf->SetFont('Helvetica', '', 8); 
	$pdf->SetXY(137, 12); 
	$pdf->MultiCell( 65, 3, $fullname); //fullname


    $pdf->SetFont('Helvetica', '', 8); 
	$pdf->SetXY(137, 21); 
	$pdf->Write(0, $reg_no); 
	$pdf->SetXY(153, 21); 
	$pdf->Write(0, '/'); 
	$pdf->SetXY(155, 21); 
	$pdf->Write(0, $model); 
	$pdf->SetXY(137, 8.5); 
	$pdf->Write(0, ''); 
	$pdf->SetFont('Helvetica', '', 6); 
	$pdf->SetXY(137, 26.5); 
	$pdf->Write(0, $pickup_date); 
	$pdf->SetXY(148, 26.5);
	$pdf->Write(0, '@'); 
	$pdf->SetXY(150.5, 26.5); 
	$pdf->Write(0, $pickup_time); 
	$pdf->SetXY(160, 26.5); 
	$pdf->Write(0, '/'); 
	$pdf->SetXY(162, 26.5); 
	$pdf->Write(0, $return_date); 
	$pdf->SetXY(173, 26.5); 
	$pdf->Write(0, '@'); 
	$pdf->SetXY(176, 26.5); 
	$pdf->Write(0, $return_time); 
	$pdf->SetFont('Helvetica', '', 10); 
	$pdf->SetXY(39, 37.2); 
	$pdf->Write(0, $car_out_start_engine); 
	$pdf->SetXY(39, 42.2); 
	$pdf->Write(0, $car_out_no_alarm); 
	$pdf->SetXY(39, 47.2); 
	$pdf->Write(0, $car_out_wiper); 
	$pdf->SetXY(39, 52.2); 
	$pdf->Write(0, $car_out_air_conditioner); 
	$pdf->SetXY(39, 57.2); 
	$pdf->Write(0, $car_out_radio); 
	$pdf->SetXY(39, 62.2); 
	$pdf->Write(0, $car_out_power_window); 
	$pdf->SetXY(39, 67.2); 
	$pdf->Write(0, $car_out_window_condition); 
	$pdf->SetXY(39, 72.2); 
	$pdf->Write(0, $car_out_perfume); 
	$pdf->SetXY(39, 77.2);
	$pdf->Write(0, $car_out_carpet); 
	$pdf->SetXY(39, 82.2); 
	$pdf->Write(0, $car_out_lamp); 
	$pdf->SetXY(39, 87.2); 
	$pdf->Write(0, $car_out_engine_condition); 
	$pdf->SetXY(89, 37.2); 
	$pdf->Write(0, $car_out_tyres_condition); 
	$pdf->SetXY(89, 42.2); 
	$pdf->Write(0, $car_out_jack); 
	$pdf->SetXY(89, 47.2); 
	$pdf->Write(0, $car_out_tools); 
	$pdf->SetXY(89, 52.2); 
	$pdf->Write(0, $car_out_signage); 
	$pdf->SetXY(89, 57.2); 
	$pdf->Write(0, $car_out_tyre_spare); 
	$pdf->SetXY(89, 62.2); 
	$pdf->Write(0, $car_out_sticker_p); 
	$pdf->SetXY(89, 67.2); 
	$pdf->Write(0, $car_out_usb_charger); 
	$pdf->SetXY(89, 72.2); 
	$pdf->Write(0, $car_out_touch_n_go); 
	$pdf->SetXY(89, 77.2); 
	$pdf->Write(0, $car_out_smart_tag); 
	$pdf->SetXY(89, 82.2); 
	$pdf->Write(0, $car_out_child_seat); 
	$pdf->SetXY(89, 87.2); 
	$pdf->Write(0, $car_out_gps); 
	$pdf->SetXY(137, 37.5); 
	$pdf->Write(0, $car_out_seat_condition); 
	$pdf->SetXY(137, 42.5); 
	$pdf->Write(0, $car_out_cleanliness); 

	if($car_out_fuel_level == 1){ 

		$pdf->Rect(142, 52, 3, 2, 'F'); 

		} elseif($car_out_fuel_level == 2) { 

			$pdf->Rect(142, 52, 3, 2, 'F'); 
			$pdf->Rect(146.5, 51, 2.5, 3, 'F'); 

			} 

			elseif($car_out_fuel_level == 3) { 

				$pdf->Rect(142, 52, 3, 2, 'F'); 
				$pdf->Rect(146.5, 51, 2.5, 3, 'F'); 
				$pdf->Rect(150.5, 49.8, 2.5, 4, 'F'); 
				
				} 

				elseif($car_out_fuel_level == 4) { 

					$pdf->Rect(142, 52, 3, 2, 'F'); 
					$pdf->Rect(146.5, 51, 2.5, 3, 'F'); 
					$pdf->Rect(150.5, 49.8, 2.5, 4, 'F'); 
					$pdf->Rect(154.5, 48, 2.5, 6, 'F'); 
					} 

					elseif($car_out_fuel_level == 5) { 

						$pdf->Rect(142, 52, 3, 2, 'F'); 
						$pdf->Rect(146.5, 51, 2.5, 3, 'F'); 
						$pdf->Rect(150.5, 49.8, 2.5, 4, 'F'); 
						$pdf->Rect(154.5, 48, 2.5, 6, 'F'); 
						$pdf->Rect(158.5, 46.5, 2.5, 7.5, 'F'); 
						} 

						elseif($car_out_fuel_level == 6) { 

							$pdf->Rect(141.8, 52, 3, 2, 'F'); 
							$pdf->Rect(146.2, 51, 2.5, 3, 'F'); 
							$pdf->Rect(150.2, 49.8, 2.5, 4, 'F'); 
							$pdf->Rect(154.2, 48, 2.5, 6, 'F'); 
							$pdf->Rect(158.2, 46.5, 2.5, 7.5, 'F'); 
							$pdf->Rect(162.3, 45.2, 2.5, 8.6, 'F'); 

							} 

							$pdf->Image($car_out_image, 101, 63.5, 50);
							$pdf->SetXY(2, 103); 
							$pdf->Write(0, $car_out_remark); 
							$pdf->SetXY(1.8, 112); 
							$pdf->Write(0, 'Y'); 
							$pdf->SetXY(1.8, 119.2); 
							$pdf->Write(0, 'Y'); 
							$pdf->SetXY(45.8, 37.2); 
							$pdf->Write(0, $car_in_start_engine); 
							$pdf->SetXY(45.8, 42.2); 
							$pdf->Write(0, $car_in_no_alarm); 
							$pdf->SetXY(45.8, 47.2); 
							$pdf->Write(0, $car_in_wiper); 
							$pdf->SetXY(45.8, 52.2); 
							$pdf->Write(0, $car_in_air_conditioner); 
							$pdf->SetXY(45.8, 57.2); 
							$pdf->Write(0, $car_in_radio); 
							$pdf->SetXY(45.8, 62.2); 
							$pdf->Write(0, $car_in_power_window); 
							$pdf->SetXY(45.8, 67.2); 
							$pdf->Write(0, $car_in_window_condition); 
							$pdf->SetXY(45.8, 72.2); 
							$pdf->Write(0, $car_in_perfume); 
							$pdf->SetXY(45.8, 77.2); 
							$pdf->Write(0, $car_in_carpet); 
							$pdf->SetXY(45.8, 82.2); 
							$pdf->Write(0, $car_in_lamp); 
							$pdf->SetXY(45.8, 87.2); 
							$pdf->Write(0, $car_in_engine_condition); 
							$pdf->SetXY(95.8, 37.2); 
							$pdf->Write(0, $car_in_tyres_condition); 
							$pdf->SetXY(95.8, 42.2); 
							$pdf->Write(0, $car_in_jack); 
							$pdf->SetXY(95.8, 47.2); 
							$pdf->Write(0, $car_in_tools); 
							$pdf->SetXY(95.8, 52.2); 
							$pdf->Write(0, $car_in_signage); 
							$pdf->SetXY(95.8, 57.2); 
							$pdf->Write(0, $car_in_tyre_spare); 
							$pdf->SetXY(95.8, 62.2); 
							$pdf->Write(0, $car_in_sticker_p); 
							$pdf->SetXY(95.8, 67.2); 
							$pdf->Write(0, $car_in_usb_charger); 
							$pdf->SetXY(95.8, 72.2); 
							$pdf->Write(0, $car_in_touch_n_go); 
							$pdf->SetXY(95.8, 77.2); 
							$pdf->Write(0, $car_in_smart_tag); 
							$pdf->SetXY(95.8, 82.2); 
							$pdf->Write(0, $car_in_child_seat); 
							$pdf->SetXY(95.8, 87.2); 
							$pdf->Write(0, $car_in_gps); 
							$pdf->SetXY(168.5, 37.5); 
							$pdf->Write(0, $car_in_seat_condition); 
							$pdf->SetXY(168.5, 42.5); 
							$pdf->Write(0, $car_in_cleanliness); 

							if($car_in_fuel_level == 1){ 

								$pdf->Rect(175.3, 52, 3, 2, 'F');

								 } 

								 elseif($car_in_fuel_level == 2) { 

								 	$pdf->Rect(175.3, 52, 3, 2, 'F'); 
								 	$pdf->Rect(179.7, 51, 2.5, 3, 'F'); 

								 	} 

								 	elseif($car_in_fuel_level == 3) { 

								 		$pdf->Rect(175.3, 52, 3, 2, 'F'); 
								 		$pdf->Rect(179.7, 51, 2.5, 3, 'F'); 
								 		$pdf->Rect(183.8, 49.8, 2.5, 4, 'F'); 

								 		} 

								 		elseif($car_in_fuel_level == 4) { 

								 			$pdf->Rect(175.3, 52, 3, 2, 'F'); 
								 			$pdf->Rect(179.7, 51, 2.5, 3, 'F'); 
								 			$pdf->Rect(183.8, 49.8, 2.5, 4, 'F'); 
								 			$pdf->Rect(187.8, 48, 2.5, 6, 'F'); 

								 			} 

								 			elseif($car_in_fuel_level == 5) { 

								 				$pdf->Rect(175.3, 52, 3, 2, 'F'); 
								 				$pdf->Rect(179.7, 51, 2.5, 3, 'F'); 
								 				$pdf->Rect(183.8, 49.8, 2.5, 4, 'F'); 
								 				$pdf->Rect(187.8, 48, 2.5, 6, 'F'); 
								 				$pdf->Rect(191.8, 46.5, 2.5, 7.5, 'F'); 

								 				} 

								 				elseif($car_in_fuel_level == 6) { 

								 					$pdf->Rect(175.3, 52, 3, 2, 'F'); 
								 					$pdf->Rect(179.7, 51, 2.5, 3, 'F'); 
								 					$pdf->Rect(183.8, 49.8, 2.5, 4, 'F'); 
								 					$pdf->Rect(187.8, 48, 2.5, 6, 'F'); 
								 					$pdf->Rect(191.8, 46.5, 2.5, 7.5, 'F'); 
								 					$pdf->Rect(195.8, 45.2, 2.5, 8.6, 'F'); 
								 					} 

				if($car_in_image == '' || $car_in_image == null)
				{

				}
				else
				{
					$pdf->Image($car_in_image, 151.2, 63.5, 50); 
				}
				$pdf->SetXY(103, 102.8); 
				$pdf->Write(0, $car_in_remark); 
				$pdf->SetXY(102.8, 112); 
				$pdf->Write(0, 'Y'); 
				$pdf->SetXY(102.8, 119); 
				$pdf->Write(0, 'Y'); 
				$pdf->SetFont('Helvetica', '', 8); 
				$pdf->SetXY(1, 127); 
				$pdf->MultiCell( 25, 4, $car_out_checkby, 0, 'L'); //caroutcheckby
				$pdf->SetXY(28, 129);
				$pdf->MultiCell( 40, 4, $fullname, 0, 'L');
				// $pdf->Write(0, $fullname); 
				
				if($car_out_sign_image == '' || $car_out_sign_image == null)
				{
				    
				}
				else
				{
				    $pdf->Image('assets/img/'.$car_out_sign_image, 75, 124.5, 27); 
				}

				$pdf->SetXY(102, 127); 
				$pdf->MultiCell( 25, 4, $car_in_checkby, 0, 'L');
				$pdf->SetXY(128, 129); 
				$pdf->MultiCell( 40, 4, $fullname, 0, 'L');
				// $pdf->Write(0, $fullname); 
				
				$sql= "SELECT 
				DATE_FORMAT(extend_from_date, '%d/%m/%Y'),
				DATE_FORMAT(extend_from_time, '%H:%i'), 
				DATE_FORMAT(extend_to_date, '%d/%m/%Y') AS extend_to_date,
				DATE_FORMAT(extend_to_time, '%H:%i'),
				payment_status,
				payment_type,
				DATE_FORMAT(c_date, '%d/%m/%Y'),
				price
				FROM extend
				WHERE booking_trans_id=".$_GET['booking_id']; 

				db_select($sql); 
				
				if (db_rowcount() > 0) { 

	for ($i = 0; $i < db_rowcount(); $i++) { 

		$status = ""; 

		if (func_getOffset() >= 10) { 

			$no = func_getOffset() + 1 + $i; 

		} else { 

			$no = $i + 1; 

		} 

		$x = $pdf->GetX(); 
		$y = $pdf->GetY(); 
		$pdf->SetFont('Helvetica', '', 8); 
		$pdf->SetXY( 11, $y); 
		$pdf->MultiCell(50, 48, db_get($i,0), 0, 'L', false); 
		$pdf->SetXY( 26, $y); 
		$pdf->MultiCell(50, 48, '-', 0, 'L', false); 
		$pdf->SetXY( 27.5, $y); 
		$pdf->MultiCell(50, 48, db_get($i,1), 0, 'L', false); 
		$pdf->SetXY( 36, $y); 
		$pdf->MultiCell(50, 48, '@', 0, 'L', false); 
		$pdf->SetXY( 40, $y); 
		$pdf->MultiCell(50, 48, db_get($i,2), 0, 'L', false); 
		$pdf->SetXY( 55, $y); 
		$pdf->MultiCell(50, 48, '-', 0, 'L', false); 
		$pdf->SetXY( 56, $y); 
		$pdf->MultiCell(50, 48, db_get($i,3), 0, 'L', false); 
		$pdf->SetXY( 82, $y); 
		$pdf->MultiCell(50, 48, db_get($i,4), 0, 'L', false); 
		$pdf->SetXY( 108.5, $y); 
		$pdf->MultiCell(50, 48, db_get($i,5), 0, 'L', false); 
		$pdf->SetXY( 138.5, $y); 
		$pdf->MultiCell(50, 48, db_get($i,6), 0, 'L', false); 
		$pdf->SetXY( 168.5, $y); 
		$pdf->MultiCell(50, 48, 'RM '.db_get($i,7), 0, 'L', false); 
		$pdf->SetXY( $x, $y); 
		$pdf->MultiCell(50, 5, ' ', 0, 'L', false); 
		$pdf->Ln(0); } } $pdf->SetXY(168.5, 198); 
		$pdf->Write(0, 'RM '.$total_ext); 
		$pdf->SetFont('Helvetica', '', '8'); 
		$pdf->SetXY(35, 205.75); 
		$pdf->MultiCell( 65, 3, $fullname, 0, 'L');
// 		$pdf->Write(0, $fullname); 
		$pdf->SetXY(140, 209); 
		$pdf->Write(0, $return_date); 
		$pdf->SetXY(160, 209); 
		$pdf->Write(0, '@'); 
		$pdf->SetXY(165, 209); 
		$pdf->Write(0, $return_time); 

		$pdf->SetXY(15, 220); 
		$pdf->Write(0, 'Deposit'); //this dep

		if($refund_dep_payment=='' | $refund_dep_payment==null )
		{



		}

		else
		{

			$pdf->SetXY(15, 225); 
			$pdf->Write(0, 'Others'); //this dep

		}

		

		$pdf->SetXY(65, 220); 
		$pdf->Write(0, 'Pay Deposit to Customer'); //this dep


		$pdf->SetXY(140, 220); 
		$pdf->Write(0, $refund_dep_payment); //i
		$pdf->SetXY(170, 220); 
		$pdf->Write(0, 'RM '.$refund_dep); 

		if($other_details=='' | $other_details==null ){


		}else{

			$pdf->SetXY(15, 225); 
			$pdf->Write(0, 'Others'); //this dep


		}



		$pdf->SetXY(65, 225); 
		$pdf->Write(0, $other_details); 
		$pdf->SetXY(140, 225); 
		$pdf->Write(0, $other_details_payment_type); 
		$pdf->SetXY(170, 225); 
		$pdf->Write(0, 'RM '.$other_details_price); 
		$total_receipt = ($refund_dep + $other_details_price); 


		$pdf->SetXY(170, 230); 
		$pdf->Write(0, 'RM '.$total_receipt); 

		// extend

		$pdf->SetXY(65, 240); 
		$pdf->Write(0, $outstanding_extend); 
		$pdf->SetXY(140, 240); 
		$pdf->Write(0, $outstanding_extend_type_of_payment); 
		$pdf->SetXY(170, 240); 
		$pdf->Write(0, 'RM '.$outstanding_extend_cost); 
		$pdf->SetXY(65, 245); 


		$pdf->Write(0, $damage_charges_details); 
		$pdf->SetXY(140, 245); 
		$pdf->Write(0, $damage_charges_payment_type); 
		$pdf->SetXY(170, 245); 
		$pdf->Write(0, 'RM '.$damage_charges); 
		$pdf->SetXY(65, 250); 




		$pdf->Write(0, $missing_items_charges_details); 
		$pdf->SetXY(140, 250); 
		$pdf->Write(0, $missing_items_charges_payment_type); 
		$pdf->SetXY(170, 250); 
		$pdf->Write(0, 'RM '.$missing_items_charges); 
		$pdf->SetXY(65, 255); 


		$pdf->Write(0, $additional_cost_details); 
		$pdf->SetXY(140, 255); 
		$pdf->Write(0, $additional_cost_payment_type); 
		$pdf->SetXY(170, 255); 
		$pdf->Write(0, 'RM '.$additional_cost); 
		$total_customer_payment = ($outstanding_extend_cost + $damage_charges + $missing_items_charges + $additional_cost); 
		$pdf->SetXY(170, 260); 
		$pdf->Write(0, 'RM '.$total_customer_payment); 
		$pdf->SetXY(10, 280); 
		$pdf->Write(0, $car_in_checkby); 
		$pdf->SetXY(99, 277); 
		$pdf->MultiCell( 60, 3, $fullname, 0, 'L');
// 		$pdf->Write(0, $fullname); 

		ob_clean(); 

		header("Content-type:application/pdf"); 
		header("Content-Disposition:attachment;filename='downloaded.pdf'"); 
		$pdf->Output(); 
		ob_end_flush(); 