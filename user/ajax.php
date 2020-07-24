<?php
include 'lib/setup.php'; 
func_setReqVar();
if ($t == 'selectNRIC') { 
	$sql = "SELECT firstname, address, postcode, city, country, title, lastname, age, phone_no, email, ref_name, ref_phoneno, license_no, ref_relationship, ref_address FROM customer WHERE nric_no='" . $_GET['nric'] . "'"; 
	db_select($sql);
	
	if (db_rowcount() > 0) { 
		$firstname = db_get(0, 0); 
		$address = db_get(0, 1); 
		$postcode = db_get(0, 2); 
		$city = db_get(0, 3); 
		$country = db_get(0, 4); 
		$title = db_get(0, 5); 
		$lastname = db_get(0, 6); 
		$age = db_get(0, 7); 
		$phone_no = db_get(0, 8); 
		$email = db_get(0, 9); 
		$ref_name = db_get(0, 10); 
		$ref_phoneno = db_get(0, 11); 
		$license_no = db_get(0, 12); 
		$ref_relationship = db_get(0, 13); 
		$ref_address = db_get(0, 14); 
	} 
	echo $firstname . "|||" . $address . "|||" . $postcode . "|||" . $city . "|||" . $country . "|||" . $title . "|||" . $lastname . "|||" . $age . "|||" . $phone_no . "|||" . $email . "|||" . $ref_name . "|||" . $ref_phoneno . "|||" . $license_no . "|||" . $ref_relationship . "|||" . $ref_address; 
} 
else if($t=='calcPrice'){ 
	$total = 0; 
	$estimate_total = 0; 
	$sql = "SELECT amount FROM option_rental WHERE description = '".$_GET['desc']."'"; 
	db_select($sql); 
	if(db_rowcount()>0){ 
		$amount = db_get(0,0); 
	} 

	if($_GET['check'] == "true"){ 
		$total = $amount * $_GET['qty']; 
	$total = $total + $_GET['price']; 
	}
	
	else if($_GET['check'] == "false"){ 
		$total = $amount * $_GET['qty']; 
	$total = $_GET['price'] - $total; 
	}

	$GST = $total * 6/100; 
	$estimate_total = $total + $GST; 
	echo $total. "|||". number_format($GST,2). "|||". number_format($estimate_total,2); 
} 
?>