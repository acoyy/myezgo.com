<!DOCTYPE html>

<html class="load-full-screen">

<?php
 include('_header.php'); func_setReqVar(); $sql = "SELECT deposit FROM car_rate WHERE class_id = " . $_GET['class_id']; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } $sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'"; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } if (($search_pickup_date >= $start_date) && ($search_pickup_date <= $end_date)) { if (($_GET['day'] >= $how_many_day_min) && ($_GET['day'] <= $how_many_day_max)) { $date = conv_datetodbdate($_GET['search_return_date']); $newdate = strtotime('+' . $free_day . ' day', strtotime($date)); $newdate = date('d/m/Y', $newdate); $search_return_dates = $newdate; echo '<script language="javascript">'; echo 'alert("Free ' . $free_day . ' Day");'; echo '</script>'; } else { $search_return_dates = $_GET['search_return_date']; } } if (isset($btn_save)) { func_setValid("Y"); if (func_isValid()) { $six_digit_random_number = mt_rand(100000, 999999); $sql = "UPDATE vehicle SET availability = 'Booked' WHERE vehicle.id=".$_GET['vehicle_id']; db_update($sql); $sql = "INSERT INTO customer
			(
			title,
			firstname,
			lastname,
			nric_no,
			license_no,
			license_exp,
			age,
			phone_no,
			email,
			address,
			postcode,
			city,
			country,
			status,
			cid,
			cdate,
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
			survey_details
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
			'$email',
			'$address',
			'$postcode',
			'$city',
			'$country',
			'A',
			'".$_SESSION['cid']."',
			CURRENT_TIMESTAMP,
			'$ref_name',
			'$ref_phoneno',
			'$ref_relationship',
			'$ref_address',
			'$drv_name',
			'$drv_nric',
			'$drv_address',
			'$drv_phoneno',
			'$drv_license_no',
			'$drv_license_exp)',
			'$survey_type',
			'" . conv_text_to_dbtext3($survey_details) . "'
			)
			"; db_update($sql); $sql = "SELECT LAST_INSERT_ID() FROM customer"; db_select($sql); if (db_rowcount() > 0) { $id = db_get(0, 0); } $sql = "INSERT INTO booking_trans
					   (
					   agreement_no,
					   pickup_date,
					   pickup_location,
					   pickup_time,
					   return_date,
					   return_location,
					   return_time,
					   option_rental_id,
					   cdw,
					   discount_id,
					   vehicle_id,
					   status,
					   day,
					   sub_total,
					   payment_details,
					   gst,
					   est_total,
					   customer_id,
					   cdate,
					   refund_dep,
					   refund_dep_payment,
					   type,
					   balance
					   )
					   VALUES
					   (
					   '$six_digit_random_number',
					   '" . conv_datetodbdate($_GET['search_pickup_date']) . "',
					   '$search_pickup_location',
					   '$search_pickup_time',
					   '" . conv_datetodbdate($search_return_dates) ."',
					   '$search_return_location',
					   '$search_return_time',
					   0,
					   0,
					   0,
					   " . $_GET['vehicle_id'] . ",
					   'B',
					   '$day',
					   '$subtotal',
					   '$payment_details',
					   '$gsthidden',
					   '$grand_total',
					   '$id',
					   CURRENT_TIMESTAMP,
					   '$deposit',
					   '$refund_dep_payment',
					   0,
					   '$subtotal'
					   )
					   "; db_update($sql); $sql = "SELECT LAST_INSERT_ID() FROM booking_trans"; db_select($sql); if (db_rowcount() > 0) { $booking_id = db_get(0, 0); } $sql = "INSERT INTO checklist (booking_trans_id) VALUES ($booking_id)"; db_update($sql); echo '<script language="javascript">'; echo 'alert("Successfully booking!")'; echo '</script>'; vali_redirect("mail.php?id=" . $booking_id); } } ?>

<style>

.alert {
	border: 2px solid #07253F;
	border-radius: 0px;
	background: transparent;
	color: #07253F;
}

.checkup button {
	background: #07253F none repeat scroll 0 0;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    margin-top: 10px;
    padding: 15px 40px;
	border: 2px solid transparent;
	border-radius: 0px;
}
.checkup button:hover {
	border: 2px solid #07253F;
	background: transparent;
	color: #07253F;
}

.col-xs-5ths,
.col-sm-5ths,
.col-md-5ths,
.col-lg-5ths {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}

.col-xs-5ths {
    width: 20%;
    float: left;
}

@media (min-width: 768px) {
    .col-sm-5ths {
        width: 20%;
        float: left;
    }
}

@media (min-width: 992px) {
    .col-md-5ths {
        width: 20%;
        float: left;
    }
}

@media (min-width: 1200px) {
    .col-lg-5ths {
        width: 20%;
        float: left;
    }
}
</style>

<body class="load-full-screen">

<!-- BEGIN: PRELOADER -->
<div id="loader" class="load-full-screen">
	<div class="loading-animation">
		<span><i class="fa fa-plane"></i></span>
		<span><i class="fa fa-bed"></i></span>
		<span><i class="fa fa-ship"></i></span>
		<span><i class="fa fa-suitcase"></i></span>
	</div>
</div>
<!-- END: PRELOADER -->

<?php include('_panel.php'); ?>

<!-- START: PAGE TITLE -->
<div class="row page-title">
		<div class="container clear-padding text-center flight-title">
			<h3>CUSTOMER INFORMATION</h3>
			<h4 class="thank">Your Details</h4>
		</div>
	</div>
	<!-- END: PAGE TITLE -->
	
	<!-- START: LOGIN/REGISTER -->
	<div class="row login-row">
		<div class="container clear-padding">
			<div class="col-md-12 login-form">

	<div class="row">
	
							 <div class="col-md-5ths col-xs-6">
										<div class="form-group">
											<label class="control-label">Base Rate</label>
											<input class="form-control" value="<?php echo dateDifference(conv_datetodbdate($search_pickup_date) . $search_pickup_time, conv_datetodbdate($search_return_dates) . $search_return_time, '%a Day %h Hours'); ?>" disabled>
										</div>
							</div>
							<div class="col-md-5ths col-xs-6">
										<div class="form-group">
											<label class="control-label">Discount (MYR)</label>
											<label class="form-control" disabled>
										</div>
							</div>
							<div class="col-md-5ths col-xs-6">
										<div class="form-group">
											<label class="control-label">Sub Total (MYR)</label>
											<input class="form-control" type="text" value="<?php echo $subtotal; ?>" name="subtotal" id="subtotal" disabled>
										</div>
							</div>
							<div class="col-md-5ths col-xs-6">
										<div class="form-group">
											<label class="control-label">GST (MYR)</label>
											<input class="form-control" type="text" value="<?php echo 'Non'; ?>" name="gsthidden" disabled>
										</div>
							</div>
							<div class="col-md-5ths col-xs-6">
										<div class="form-group">
											<label class="control-label">Grand Total (MYR)</label>
											<?php $est_total = $subtotal + $_GET['delivery_cost'] + $_GET['pickup_cost']; $grand_total = $est_total; ?>
											<input class="form-control" type="text" value="<?php echo $grand_total; ?>" name="est_total" disabled>
										</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
										<table class="table">
											<thead>
											<?php
 $sql = "SELECT description, amount, taxable FROM option_rental"; db_select($sql); if (db_rowcount() > 0) { for ($i = 0; $i < db_rowcount(); $i++) { echo "<tr>
																<td>
																	<input type='checkbox' value='Y' " . vali_iif('Y' == $description[$i], 'Checked', '') . " name='description[$i].' onclick='calcPrice(document.getElementById(\"subtotal\").value,\"" . db_get($i, 0) . "\",document.getElementById(\"qty[$i]\").value,\"" . db_rowcount() . "\")' id='description[$i]'></td>
																<td>" . db_get($i, 0) . "</td>
																<td>
																	<select name='number' class='form-control m-b' style='width:5em' id='qty[$i]'>
																		<option value='1' " . vali_iif('1' == $number, 'Selected', '') . ">1</option>
																		<option value='2' " . vali_iif('2' == $number, 'Selected', '') . ">2</option>
																		<option value='3' " . vali_iif('3' == $number, 'Selected', '') . ">3</option>
																		<option value='4' " . vali_iif('4' == $number, 'Selected', '') . ">4</option>
																		<option value='5' " . vali_iif('5' == $number, 'Selected', '') . ">5</option>
																	</select>
																</td>
																<td>
																	RM&nbsp;" . db_get($i, 1) . "
																</td>
															</tr>"; } } ?>
													<tr>
														<td><input type="checkbox" value='Y' <?php echo vali_iif('Y' == $cdw, 'Checked', ''); ?> name="cdw"></td>
														<td>C.D.W</td>
														<td colspan="2">13.00 % Per Day</td>
													</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>

							<div class="row">

								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Pickup Location</label>
											<?php
 $sql = "SELECT id, description from location WHERE id=" . $_GET['search_pickup_location']; db_select($sql);if (db_rowcount() > 0) {$pickup_location = db_get(0, 1);} ?>
										<input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Pickup Date & Time</label>
										<input class="form-control" value="<?php echo $_GET['search_pickup_date'] . "@" . $_GET['search_pickup_time']; ?>" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Return Location</label>
											<?php
 $sql = "SELECT id, description from location WHERE id=" . $_GET['search_return_location']; db_select($sql);if (db_rowcount() > 0) {$return_location = db_get(0, 1);} ?>
										<input class="form-control" value="<?php echo $return_location; ?>" disabled>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Return Date & Time</label>
										<?php if (($day >= $how_many_day_min) && ($day <= $how_many_day_max)) { ?>
											<input class="form-control" value="<?php echo $_GET['search_return_date'] . " > " . $search_return_dates . "@" . $_GET['search_return_time']; ?>" disabled>
										<?php } else { ?>
											<input class="form-control" value="<?php echo $_GET['search_return_date'] . "@" . $_GET['search_return_time']; ?>" disabled>
										<?php } ?>
									</div>
								</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Coupon Code</label>
									<input type="text" class="form-control" name="code" value="<?php echo $code; ?>">
									<div class="checkup">
										<center>
											<button type="submit" class="btn btn-success" name="btn_redeem">Redeem</button>
										</center>
									</div>
								</div>
							</div>
						</div>

<form method="post">

<span style="color:red"><?php echo func_getErrMsg(); ?></span>

<div class="row">
	<div class="col-md-12">
		<center>
			<div class="alert alert-warning" role="alert">
				<b>Customer Information</b>
			</div>
		</center>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
			<div class="form-group">
				<label class="control-label">NRIC No</label>
				<input type="text" class="form-control" placeholder="NRIC No" name="nric_no" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)">
			</div>
		</div>
		<div class="col-md-3">
		<div class="form-group">
			<label class="control-label">Title</label>
			<select name="title" class="form-control" id="title">
				<option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
				<option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
				<option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>
			</select>
		</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label class="control-label">First Name</label>
				<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label class="control-label">Last Name</label>
				<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" value="<?php echo $lastname; ?>" id="lastname">
			</div>
		</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label">Driver's Age</label>
			<input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>" id="age">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label">Phone No</label>
			<input type="text" class="form-control" placeholder="Phone No" name="phone_no" value="<?php echo $phone_no; ?>" id="phone_no">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label">Email</label>
			<input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" id="email">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">License Number</label>
			<input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" id="license_no">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">License Expired</label>
			<input type="text" class="form-control" placeholder="License No" name="license_exp" value="<?php echo $license_exp; ?>" id="license_no">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label class="control-label">Address</label>
			<input class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $address; ?>">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label class="control-label">Postcode</label>
			<input type="text" class="form-control" placeholder=" Postcode" name="postcode" value="<?php echo $postcode; ?>" id="postcode">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
				<label class="control-label">City</label>
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
	<div class="col-md-3">
		<div class="form-group">
				<label class="control-label">Country</label>
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
	</div>




<div class="row">
	<div class="col-md-12">
		<center>
			<div class="alert alert-warning" role="alert">
				<b>Payment Information</b>
			</div>
		</center>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label class="control-label">Payment Amount (MYR)</label>
			<input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $subtotal; ?>" id="payment_amount" disabled>
		</div>
	</div>


</div>

<div class="row">
	<div class="col-md-12">
		<center>
			<div class="alert alert-warning" role="alert">
				<b>Survey</b>
			</div>
		</center>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">Survey</label>
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
	<div id="survey_details">
			
	</div>
</div>

<center>
	<div class="row">
		<div class="checkup">
			<div class="form-group">
				<button type="submit" class="btn btn-success" name="btn_save">Save</button>
			</div>
		</div>
	</div>
</center>
</div>
</div>
</form>
			</div>
		</div>
	</div>
	<!-- END: LOGIN/REGISTER -->

	<?php include('_footer.php'); ?>

	<script type="text/javascript">
	function change() {
			var select = document.getElementById("survey");
			var divv = document.getElementById("survey_details");
			var value = select.value;
			if (value == "Others") {
				toAppend = "<div class='col-md-6'><div class='form-group'><label class='control-label'>Survey Details</label><input class='form-control' type='textbox' name='survey_details' value='<?php echo $survey_details; ?>' ></div></div>"; divv.innerHTML=toAppend; return;
				}
				if (value == "non") {
						toAppend = "<div class='col-md-6'><div class='form-group'></div></div>";divv.innerHTML = toAppend;  return;
					}
		}
	</script>


	</body>