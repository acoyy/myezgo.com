<!DOCTYPE html>

<html class="load-full-screen">

<?php 

	include('_header.php'); 

	func_setReqVar();

	$sql = "SELECT
	vehicle.id AS vehicle_id,
    reg_no,
	make,
    model,
	DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
	DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
    CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
	DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
	DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
    CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
	concat(firstname,' ' ,lastname) AS fullname,
	age,
    email,
    license_no,
	nric_no,
	phone_no,
	address,
    postcode,
    city,
    country,
	sub_total,
	refund_dep
	FROM customer
	JOIN booking_trans ON customer.id = customer_id 
	JOIN vehicle ON vehicle_id = vehicle.id
	WHERE booking_trans.id=".$_GET['id'];
	//echo $sql;
	db_select($sql);
	if (db_rowcount() > 0) {
	func_setSelectVar();
	}

?>

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
			<h3>THANK YOU</h3>
			<h4 class="thank"><i class="fa fa-thumbs-o-up"></i> Your Booking is Confirmed!</h4>
		</div>
	</div>
	<!-- END: PAGE TITLE -->
	
	<!-- START: BOOKING DETAILS -->
	<div class="row">
		<div class="container clear-padding">
			<div>
				<div class="col-md-8 col-sm-8">
					<div class=" confirmation-detail">
						<h3>Booking Details</h3>
						<table class="table">
							<tr>
								<td>Booking ID</td>
								<td><?php echo $_GET['id']; ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php echo $fullname; ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo $email; ?></td>
							</tr>
							<tr>
								<td>Pickup Location</td>
								<td><?php echo $pickup_location; ?></td>
							</tr>
							<tr>
								<td>Pickup Date</td>
								<td><?php echo $pickup_date; ?></td>
							</tr>
							<tr>
								<td>Pickup Time</td>
								<td><?php echo $pickup_time; ?></td>
							</tr>
							<tr>
								<td>Return Location</td>
								<td><?php echo $return_location; ?></td>
							</tr>
							<tr>
								<td>Return Date</td>
								<td><?php echo $return_date; ?></td>
							</tr>
							<tr>
								<td>Return Time</td>
								<td><?php echo $return_time; ?></td>
							</tr>
						</table>
						<p>Check your email for further details. We have sent you a mail with details.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 booking-sidebar">
					<div class="sidebar-item contact-box">
						<h4><i class="fa fa-phone"></i>Need Help?</h4>
						<div class="sidebar-body text-center">
							<p>Need Help? Call us or drop a message. Our agents will be in touch shortly.</p>
							<h2>+6<?php echo $company_phone_no; ?></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: BOOKING DETAILS -->

<?php include('_footer.php'); ?>
</body>