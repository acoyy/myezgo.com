<!DOCTYPE html>

<html class="load-full-screen">

<?php
include('_header.php');
func_setReqVar();
$sql = "SELECT 
season_name, 
DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, 
DATE_FORMAT(end_date, '%d/%m/%Y') AS end_date 
FROM season_rental WHERE status = 1";

db_select($sql);

if (db_rowcount() > 0) {
	func_setSelectVar();
}
?>

<style>

.alert {
	border: 2px solid #f9676b;
	border-radius: 0px;
	background: transparent;
	color: #f9676b;
	text-transform: uppercase;
}

.col-md-3 .room-check {
	margin: 40px auto 100px auto;
    box-shadow: 0px 0px 5px #e6e6e6;
    overflow: hidden;
}

.col-md-6 .node {
	margin-left: 24px;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	border-top: #fff;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	padding: 3px;
}

@media screen and (max-width: 767px)  {

.table-responsive {
	border: 1px solid #fff;
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

<?php include '_panel.php';?>

	<!-- START: PAGE TITLE -->
	<div class="row page-title modify-car">
		<div class="container clear-padding text-center flight-title">
			<h3>OUR TOP CARS</h3>
			<h4 class="thank">List Of Available CARS</h4>
		</div>
	</div>
	<!-- END: PAGE TITLE -->
<!-- START: LISTING AREA-->
<br>

<div class="row">
	<div class="container">
		
		<?php if(($search_pickup_date >= $season_start_date) && ($search_pickup_date <= $season_end_date)) { ?>
				<div class="col-md-12">
					<center>
						<div class="alert alert-warning" role="alert">
							<b>Booking Car are not available at this moment because of <i><?php echo $season_name; ?></i> occasion.</b>
						</div>
					</center>
				</div>
		<?php } ?>

		<!-- START: FILTER AREA -->
		<div class="col-md-3 clear-padding">
			<div class="room-check">
				<h4 class="text-center">CHANGE DESTINATION</h4>
				<div class="room-check-body">
					<form action="booking.php" onsubmit="return validateForm()">
						<label>Pick Up Location</label>
						<div class="input-group">
							<select class="form-control" name="search_pickup_location">
								<?php
									$value = "";
									$sql = "SELECT id, description FROM location WHERE status = 'A'";
									db_select($sql);
									if (db_rowcount() > 0) {
										for ($j = 0; $j < db_rowcount(); $j++) {
											$value = $value . "<option value=" . db_get($j, 0) . " " . vali_iif(db_get($j, 0) == $class_id, 'Selected', '') . ">" . db_get($j, 1) . "</option>";
										}
									}
									echo $value;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						</div>
						<!-- <div class="col-md-12 col-sm-12 col-xs-12 padding-right"> -->
							<label>Pick Up Date</label>
							<div class="input-group">
								<input type="text" autocomplete="off" id="check_in" name="search_pickup_date" class="form-control" placeholder="DD/MM/YYYY" required value="<?php echo $_GET['search_pickup_date']; ?>">
								<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							</div>
						<!-- </div> -->
						<!-- <div class="col-md-12 col-sm-12 col-xs-12 padding-left"> -->
							<label>Pick Up Time</label>
							<div class="input-group">
								<select name="search_pickup_time" class="form-control">
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
								<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>
							</div>
						<!-- </div> -->
						<label>Return Location</label>
						<div class="input-group">
							<select class="form-control" name="search_return_location">
								<?php
									$value = "";
									$sql = "SELECT id, description FROM location WHERE status = 'A'";
									db_select($sql);
									if (db_rowcount() > 0) {
										for ($j = 0; $j < db_rowcount(); $j++) {
											$value = $value . "<option value=" . db_get($j, 0) . " " . vali_iif(db_get($j, 0) == $class_id, 'Selected', '') . ">" . db_get($j, 1) . "</option>";
										}
									}
									echo $value;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						</div>

						<!-- <div class="col-md-12 col-sm-12 col-xs-12 padding-right"> -->
							<label>Return Date</label>
							<div class="input-group">
								<input type="text" autocomplete="off" id="check_out" name="search_return_date" class="form-control" placeholder="DD/MM/YYYY" required value="<?php echo $_GET['search_return_date']; ?>">
								<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							</div>
						<!-- </div> -->
						<!-- <div class="col-md-12 col-sm-12 col-xs-12 padding-left"> -->
							<label>Return Time</label>
							<div class="input-group">
								<select name="search_return_time" class="form-control">
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
								<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>
							</div>
						<!-- </div> -->
						<div class="text-center">
							<button name="btn_search" type="submit">Find Cars</button>
						</div>
					</form>
				</div>
			</div>

			<div class="room-check">
				<h4 class="text-center">NEED ASSISTANCE</h4>
				<div class="room-box-body text-center">
					<br>
					<h5>Need Help? Call Us</h5>
					<b>+6014 400 5050</b>
				</div>
			</div>
		</div>
		<!-- END: FILTER AREA -->

		<!-- START: INDIVIDUAL LISTING AREA -->
		<div class="col-md-9 hotel-listing">
			<div class="clearfix"></div>
			<!-- START: HOTEL LIST VIEW -->
			<?php
				if (isset($btn_search)) {

					func_setPage();
					func_setOffset();
					func_setLimit(5);
					
					$db_pickup_date = conv_datetodbdate($search_pickup_date);
					$db_return_date = conv_datetodbdate($search_return_date);

					$day = dateDifference($db_pickup_date, $db_return_date, '%a');
					$time = dateDifference($search_pickup_time, $search_return_time, '%h');

					if(($search_pickup_date >= $start_date) && ($search_pickup_date <= $end_date)) {
						echo "<script>";
						echo "alert('Booking car are not avalaible at this moment because ".$season_name." occasion.')";
						echo "</script>";
						vali_redirect('index.php');
					}

					if(($search_return_date >= $start_date) && ($search_return_date <= $end_date)) {
						echo "<script>";
						echo "alert('Booking car are not avalaible at this moment because ".$season_name." occasion.')";
						echo "</script>";
						vali_redirect('index.php');
					}

					if(($day == 0) && ($time <= 4)){
						echo "<script>alert('Renting need to be at least five(5) hours.')</script>";
						vali_redirect('index.php');
					} else {

						$sql = "SELECT * FROM booking_trans WHERE 
                        (
                          return_date <= '" . $db_return_date.' '.$search_return_time.':00'."' 
                          AND return_date >= '" . $db_pickup_date.' '.$search_pickup_time.':00'."' 
                          AND (available = 'Out' OR available = 'Booked')
                        ) 
                        OR 
                        (
                          pickup_date >= '" . $db_pickup_date.' '.$search_pickup_time.':00'."' 
                          AND pickup_date <= '" . $db_return_date.' '.$search_return_time.':00'."'
                          AND (available = 'Out' OR available = 'Booked')
                        )
                        group by vehicle_id";
                        
                        $result = [];
                        
                        $query=mysqli_query($con,$sql);

                        while ($row = mysqli_fetch_array($query)){

                          $result[] = $row['vehicle_id'];

                        }

                        // echo $result[0];

                        $sql = "SELECT * FROM extend WHERE 
                        (
                          extend_to_date   <= '" . $db_return_date.' '.$search_return_time.':00'."' 
                          AND extend_to_date  >= '" . $db_pickup_date.' '.$search_pickup_time.':00'."'
                          AND vehicle_id ='$search_vehicle'
                        ) 
                        OR 
                        (
                          extend_from_date  >= '" . $db_pickup_date.' '.$search_pickup_time.':00'."' 
                          AND extend_from_date  <= '" . $db_return_date.' '.$search_return_time.':00'."'
                          AND vehicle_id ='$search_vehicle'
                        )
                        group by vehicle_id";  

                        $result2 = [];

                        $query=mysqli_query($con,$sql);

                        while ($row = mysqli_fetch_array($query)){

                          $result2[] = $row['vehicle_id'];

                        }

                        $list_id=implode(", ", $result);

                        $list_id2=implode(", ", $result2);

                        if(($list_id2!='' || $list_id2!=null) && ($list_id!='' || $list_id!=null)){

                        	$sql = "SELECT 
                        	class_name,
							class_image,
							people_capacity,
							baggage_capacity,
							doors,
							CASE transmission WHEN 'A' THEN 'Automatic Transmission' WHEN 'M' THEN 'Manual Transmission' END AS transmission,
							CASE air_conditioned WHEN 'Y' THEN 'Air Conditioning' END AS air_conditioned,
							desc_1,
							desc_2,
							desc_3,
							desc_4,
							oneday,
							twoday,
							threeday,
							fourday,
							fiveday,
							sixday,
							weekly,
							monthly,
							hour,
							halfday,
							vehicle.id,
							class.id,
							vehicle.reg_no AS plate
							FROM class
							LEFT JOIN car_rate ON class.id = car_rate.class_id
							LEFT JOIN vehicle ON  class.id = vehicle.class_id
							LEFT JOIN booking_trans ON  vehicle.id = booking_trans.vehicle_id
                        	WHERE vehicle.id not in ($list_id , $list_id2)
                        	AND class.status = 'A'
                        	GROUP BY class.id";

                        } 

                        elseif (($list_id2=='' || $list_id2==null) && ($list_id!='' || $list_id!=null)) {

                        	$sql = "SELECT 
                        	class_name,
							class_image,
							people_capacity,
							baggage_capacity,
							doors,
							CASE transmission WHEN 'A' THEN 'Automatic Transmission' WHEN 'M' THEN 'Manual Transmission' END AS transmission,
							CASE air_conditioned WHEN 'Y' THEN 'Air Conditioning' END AS air_conditioned,
							desc_1,
							desc_2,
							desc_3,
							desc_4,
							oneday,
							twoday,
							threeday,
							fourday,
							fiveday,
							sixday,
							weekly,
							monthly,
							hour,
							halfday,
							vehicle.id,
							class.id,
							vehicle.reg_no AS plate
							FROM class
							LEFT JOIN car_rate ON class.id = car_rate.class_id
							LEFT JOIN vehicle ON  class.id = vehicle.class_id
							LEFT JOIN booking_trans ON  vehicle.id = booking_trans.vehicle_id
                        	WHERE vehicle.id not in ($list_id)
                        	AND class.status = 'A'
                        	GROUP BY class.id ";

                        }

                        elseif (($list_id2!='' || $list_id2!=null) && ($list_id=='' || $list_id==null)) {

	                        $sql = "SELECT 
	                        class_name,
							class_image,
							people_capacity,
							baggage_capacity,
							doors,
							CASE transmission WHEN 'A' THEN 'Automatic Transmission' WHEN 'M' THEN 'Manual Transmission' END AS transmission,
							CASE air_conditioned WHEN 'Y' THEN 'Air Conditioning' END AS air_conditioned,
							desc_1,
							desc_2,
							desc_3,
							desc_4,
							oneday,
							twoday,
							threeday,
							fourday,
							fiveday,
							sixday,
							weekly,
							monthly,
							hour,
							halfday,
							vehicle.id,
							class.id
							FROM class
							LEFT JOIN car_rate ON class.id = car_rate.class_id
							LEFT JOIN vehicle ON  class.id = vehicle.class_id
							LEFT JOIN booking_trans ON  vehicle.id = booking_trans.vehicle_id
							WHERE vehicle.id not in ($list_id2)
							AND class.status = 'A'
							GROUP BY class.id ";

                        }

                        else{

                          	$sql = "SELECT 
							class_name,
							class_image,
							people_capacity,
							baggage_capacity,
							doors,
							CASE transmission WHEN 'A' THEN 'Automatic Transmission' WHEN 'M' THEN 'Manual Transmission' END AS transmission,
							CASE air_conditioned WHEN 'Y' THEN 'Air Conditioning' END AS air_conditioned,
							desc_1,
							desc_2,
							desc_3,
							desc_4,
							oneday,
							twoday,
							threeday,
							fourday,
							fiveday,
							sixday,
							weekly,
							monthly,
							hour,
							halfday,
							vehicle.id,
							class.id
							FROM class
							LEFT JOIN car_rate ON class.id = car_rate.class_id
							LEFT JOIN vehicle ON  class.id = vehicle.class_id
							LEFT JOIN booking_trans ON  vehicle.id = booking_trans.vehicle_id
							WHERE class.status = 'A'
							GROUP BY class.id";
                        }

						db_select($sql);

						func_setTotalPage(db_rowcount());
						db_select($sql . " LIMIT " . func_getLimit() . " OFFSET " . func_getOffset());

						if (db_rowcount() > 0) {
							for ($i = 0; $i < db_rowcount(); $i++) {
								if (func_getOffset() >= 10) {
									$no = func_getOffset() + 1 + $i;
								} else {
									$no = $i + 1;
								}

					            if ($_GET['search_pickup_location'] == 4) {
					                $pickup_location = "Port Dickson";
					            } elseif ($_GET['search_pickup_location'] == 5) {
					                $pickup_location = "Seremban";
					            } else {
					                echo "Contact System Adminstrator";
					            }

					            if ($_GET['search_return_location'] == 4) {
					                $return_location = "Port Dickson";
					            } elseif ($_GET['search_return_location'] == 5) {
					                $return_location = "Seremban";
					            } else {
					                echo "Contact System Adminstrator";
					            }
            ?>
			<div class="col-md-12 clear-padding">
				<div  class="hotel-list-view">
					<div class="wrapper">
						<div class="col-md-4 col-sm-6 switch-img clear-padding">
							<?php echo "<img src='dashboard/assets/img/class/".db_get($i, 1)."' alt='".db_get($i,0)."'>"; ?>
							<div class="col-md-12">
								<ul class="check-list">
									<li><?php echo db_get($i, 5); ?></li>
									<li><?php echo db_get($i, 6); ?></li>
									<li><?= $difference_hour; ?></li>
								</ul>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 hotel-info">
							<div>
								<div class="hotel-header">
									<h5><?php echo db_get($i, 0); ?></h5>
								</div>
								<div class="hotel-desc"></div>
								<div class="car-detail">
									<div class="row">
										<center>
											<div class="col-md-4 col-sm-4 col-xs-4 clear-padding">
												<span><i class="fa fa-user"></i>&nbsp;<?php echo db_get($i, 2); ?></span>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-4 clear-padding">
												<span><i class="fa fa-suitcase"></i>&nbsp;<?php echo db_get($i, 3); ?></span>
											</div>
											<div class="col-md-4 col-sm-3 col-xs-4 clear-padding">
												<span><i class="fa fa-car"></i>&nbsp;<?php echo db_get($i, 4); ?></span>
											</div>
										</center>
									</div>
									<hr>
									<div class="row">
										<div class="table-responsive">
											<table class="table">
												<tr>
													<td><span><i class="fa fa-map-marker"></i>Pickup Location</span></td>
													<td><span><i class="fa fa-map-marker"></i>Return Location</span></td>
												</tr>
												<tr>
													<td><small class="node"><?php echo $pickup_location; ?></small></td>
													<td><small class="node"><?php echo $return_location; ?></small></td>
												</tr>
												<tr>
													<td><span><i class="fa fa-calendar"></i>Pickup Date</span></td>
													<td><span><i class="fa fa-calendar"></i>Return Date</span></td>
												</tr>
												<tr>
													<td><small class="node"><?php echo $search_pickup_date; ?></small></td>
													<td><small class="node"><?php echo $search_return_date; ?></small></td>
												</tr>
												<tr>
													<td><span><i class="fa fa-clock-o"></i>Pickup Time</span></td>
													<td><span><i class="fa fa-clock-o"></i>Return Time</span></td>
												</tr>
												<tr>
													<td><small class="node"><?php echo $search_pickup_time; ?></small></td>
													<td><small class="node"><?php echo $search_return_time; ?></small></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix visible-sm-block"></div>
						<div class="col-md-2 rating-price-box text-center clear-padding car-item">
							<div class="rating-box">
								<div class="user-rating">
									<?php
									
										$difference_hour = $time - 12;

										if ($day == 0) {
											$subtotal = $time * db_get($i, 19);
											if($time == 12){
												$subtotal = db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 1) {
											$subtotal = db_get($i, 11) + ($time * db_get($i, 19));	
											if($time == 12){
												$subtotal = db_get($i, 11) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i,11) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 2) {
											$subtotal = db_get($i, 12) + ($time * db_get($i, 19));	
											if($time == 12){
												$subtotal = db_get($i, 12) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i,12) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}				
										} elseif ($day == 3) {
											$subtotal = db_get($i, 13) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i, 13) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i, 13) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 4) {
											$subtotal = db_get($i, 14) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i, 14) + db_get($i,20);
											} elseif($time >= 13){
												$subtotal = db_get($i,14) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 5) {
											$subtotal = db_get($i, 15) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i, 15) + db_get($i,20);
											} elseif($time >= 13) {
												$subtotal = db_get($i,15) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 6) {
											$subtotal = db_get($i, 16) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i, 16) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i,16) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 7) {
											$subtotal = db_get($i, 17) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i, 17) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i,17) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 8) {
											$subtotal = db_get($i,17) + db_get($i,11) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,11) + db_get($i,20);
											} elseif ($time >= 12) {
												$subtotal = (db_get($i,17) + db_get($i,11) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 9) {
											$subtotal = db_get($i,17) + db_get($i,12) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,12) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = db_get($i,17) + db_get($i,12) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 10) {
											$subtotal = db_get($i,17) + db_get($i,13) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,13) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = (db_get($i,17) + db_get($i,13) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 11) {
											$subtotal = db_get($i,17) + db_get($i,14) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,14) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = (db_get($i,17) + db_get($i,14) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 12) {
											$subtotal = db_get($i,17) + db_get($i,15) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,15) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = (db_get($i,17) + db_get($i,15) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 13) {
											$subtotal = db_get($i,17) + db_get($i,16) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,16) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = (db_get($i,17) + db_get($i,16) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 14) {
											$subtotal = db_get($i,17) + db_get($i,17) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i,17) + db_get($i,17) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal = (db_get($i,17) + db_get($i,17) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 15) {
											$subtotal = (db_get($i,17)*2) + db_get($i,11) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,11) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,11) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 16) {
											$subtotal = (db_get($i,17)*2) + db_get($i,12) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,12) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,12) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 17) {
											$subtotal = (db_get($i,17)*2) + db_get($i,13) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,13) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,13) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 18) {
											$subtotal = (db_get($i,17)*2) + db_get($i,14) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,14) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,14) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 19) {
											$subtotal = (db_get($i,17)*2) + db_get($i,15) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,15) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,15) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 20) {
											$subtotal = (db_get($i,17)*2) + db_get($i,16) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,16) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,16) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 21) {
											$subtotal = (db_get($i,17)*2) + db_get($i,17) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*2) + db_get($i,17) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*2) + db_get($i,17) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 22) {
											$subtotal = (db_get($i,17)*3) + db_get($i,11) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,11) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,11) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 23) {
											$subtotal = (db_get($i,17)*3) + db_get($i,12) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,12) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,12) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 24) {
											$subtotal = (db_get($i,17)*3) + db_get($i,13) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,13) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,13) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 25) {
											$subtotal = (db_get($i,17)*3) + db_get($i,14) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,14) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,14) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 26) {
											$subtotal = (db_get($i,17)*3) + db_get($i,15) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,15) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,15) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 27) {
											$subtotal = (db_get($i,17)*3) + db_get($i,16) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,16) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,16) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 28) {
											$subtotal = (db_get($i,17)*3) + db_get($i,17) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*3) + db_get($i,17) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*3) + db_get($i,17) + db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										} elseif ($day == 29) {
											$subtotal = (db_get($i,17)*4) + db_get($i,11) + ($time * db_get($i, 19)) ;
											if($time == 12){
												$subtotal =  (db_get($i,17)*4) + db_get($i,11) + db_get($i,20);
											} elseif ($time >= 13) {
												$subtotal =  ((db_get($i,17)*4) + db_get($i,11)+ db_get($i,20)) + (db_get($i,19) * $difference_hour);
											}
										}
										elseif ($day == 30) {
											$subtotal = db_get($i, 18) + ($time * db_get($i, 19));
											if($time == 12){
												$subtotal = db_get($i, 18) + db_get($i,20);
											} elseif($time >= 13) {
												$subtotal = db_get($i,18) + db_get($i,20) + (db_get($i,19) * $difference_hour);
											}
										} 
									 // echo "vehicle_id: ". db_get($i,21);
									?>
									<span><i class='fa fa-money'></i>&nbsp;<b>RM<?php echo $subtotal; ?></b></span>
									<small><?php echo $day." Day(s) &amp; ".$time; ?> Hour(s)</small>
								</div>
							</div>
							<div class="room-book-box">
								<div class="book">
									<?php 
										echo "<a href='booking_continue.php?class_id=" . db_get($i,22) . "&search_pickup_date=" . $search_pickup_date . "&search_pickup_time=" . $search_pickup_time . "&search_return_date=" . $search_return_date . "&search_return_time=" . $search_return_time . "&search_pickup_location=" . $search_pickup_location . "&search_return_location=" . $search_return_location . "&subtotal=" . $subtotal. "&day=" . $day . "&login=0'><span>BOOK</span></a>";

										// session_start();

										// $_SESSION['vehicle_id'] = db_get($i,21);
										// $_SESSION['class_id'] = db_get($i,22);
										// $_SESSION['search_pickup_date'] = $search_pickup_date;
										// $_SESSION['search_pickup_time'] = $search_pickup_time;
										// $_SESSION['search_return_date'] = $search_return_date;
										// $_SESSION['search_return_time'] = $search_return_time;
										// $_SESSION['search_pickup_location'] = $search_pickup_location;
										// $_SESSION['search_return_location'] = $search_return_location;
										// $_SESSION['subtotal'] = $subtotal;
										// $_SESSION['day'] = $day;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
				<?php
							}
						} else {
								echo "No Records Found";
						}
					}
				}
				?>
				<!-- END: HOTEL LIST VIEW -->
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<!-- START: PAGINATION -->
			<div class="bottom-pagination">
				<nav class="pull-right">
					<div class="pagination">
						<?php func_getPaging('booking.php?x&btn_search=&search_pickup_date=' . $search_pickup_date . '&search_pickup_time=' . $search_pickup_time . '&search_return_date=' . $search_return_date . '&search_return_time=' . $search_return_time . '&search_pickup_location=' . $search_pickup_location . '&search_return_location=' . $search_return_location); ?>
				</div>
				</nav>
			</div>
			<!-- END: PAGINATION -->
		</div>
		<!-- END: INDIVIDUAL LISTING AREA -->
	</div>
</div>
<!-- END: LISTING AREA -->

<!-- START: FOOTER -->
<?php include '_footer.php';?>
<!-- END: FOOTER -->

<script>
	var check_in = $('#check_in').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	var check_out = $('#check_out').datepicker({ dateFormat: 'dd/mm/yy' }).val();
</script>

</html>