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

	<?php include('_header.php'); 
	require("lib/phpmailer/class.phpmailer.php"); 

	// start edit 
	
	$sql = "SELECT 
	description, 
	calculation, 
	amount_type, 
	amount, 
	taxable, 
	calculation,
	pic,
	case missing_cond 
	WHEN '0' Then '-' 
	WHEN '5' Then 'If missing, RM5' 
	WHEN '50' Then 'If missing, RM50' 
	WHEN '150' Then 'If missing RM150' 
	WHEN '300' Then 'If missing, RM300' 
	End as missing_cond 
	FROM option_rental";

	db_select($sql);

	if (db_rowcount() > 0) {

		func_setSelectVar();

	}

	$sql = "SELECT min_rental_time FROM vehicle WHERE id=" . $_GET['vehicle_id']; 
	db_select($sql); 

	if (db_rowcount() > 0) { 

		func_setSelectVar();
	}

	$vehicle_id = $_GET['vehicle_id'];
	$pickup_date = date('Y-m-d', strtotime($_GET['search_pickup_date']));
	$pickup_time = $_GET['search_pickup_time'];
	$return_date = date('Y-m-d', strtotime($_GET['search_return_date']));
	$return_time = $_GET['search_return_time'];
	$search_pickup_location = $_GET['search_pickup_location'];
	$search_return_location = $_GET['search_return_location'];
	$class_id = $_GET['class_id'];
	$delivery_cost = $_GET['delivery_cost'];
	$p_delivery_address = $_GET['p_delivery_address'];
	$r_delivery_address = $_GET['r_delivery_address'];
	$pickup_cost = $_GET['pickup_cost'];
	$p_pickup_address = $_GET['p_pickup_address'];
	$r_pickup_address = $_GET['r_pickup_address'];
	$search_return_dates = date('Y-m-d H:i', strtotime("$return_date $return_time"));
	// echo "<br>40)return dates: ".$search_return_dates;

	$checkAddDriver="X";
	$checkCdw="X";
	$checkStickerP="X";
	$checkTouchnGo="X";
	$checkDriver="X";
	$checkCharger="X";
	$checkSmartTag="X";
	$checkChildSeat="X";

	$return_date_ori = $return_date;
	$return_time_ori = $return_time;
	
	$days = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%d');
	$hours = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%h');

	$condition = "true";

	if($days < 1)
	{
		if($min_rental_time == '1 day')
		{
			$condition = "false day";
			// echo $return_date;
			$return_date = strtotime('+1 day', strtotime($return_date));
			$return_date = date('Y-m-d',$return_date);
			$return_time = $pickup_time;

			// sampai sini 5/8/2019

			$sql = "SELECT id AS booking_id FROM booking_trans WHERE vehicle_id = '$vehicle_id' AND ((
                            return_date <= '" . $return_date.' '.$return_time.':00'."' 
                            AND return_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND (available = 'Out' OR available = 'Booked')
                          ) 
                          OR 
                          (
                            pickup_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND pickup_date <= '" . $return_date.' '.$return_time.':00'."'
                            AND (available = 'Out' OR available = 'Booked')
                          ))";

			db_select($sql);

			if (db_rowcount() > 0) { 

				for ($i = 0; $i < db_rowcount(); $i++) { 

					if (func_getOffset() >= 10) { 

						$no = func_getOffset() + 1 + $i; 
					} 
					else { 

						$no = $i + 1;
					}
					
					// echo "<br>booking_id $i: ".db_get($i, 0);
    			}

    			$vehicle_status = 'active';
			}
		}

		else if($min_rental_time == '5 hours')
		{

			$return_date = $return_date . " " . $return_time .":00";
			
			if($hours < 5){

				$condition = "false hour";
				$hours = 5 - $hours;
				$return_date = strtotime('+'.$hours.' hours', strtotime($return_date));
				$return_date = date('Y-m-d H:i:s', $return_date);
				// echo $return_date;

				
			}

			$temp_return_date = date('Y-m-d', strtotime($return_date));
			$temp_return_time = date('Hi', strtotime($return_date));

			// echo $temp_return_time;

			if($temp_return_time > "2230" || $temp_return_time < "800")
			{
				$return_time = "22:30";


				if($temp_return_time >= "0" && $temp_return_date > $return_date_ori)
				{

					$return_date = $return_date_ori . " " . $return_time . ":00";
				}
			}
			else
			{

				$return_time = date('H:i', strtotime($return_date));
			}
			
			$sql = "SELECT id AS booking_id FROM booking_trans WHERE vehicle_id = '$vehicle_id' AND 
					(
						(
                            return_date <= '" . $temp_return_date.' '.$return_time.':00'."' 
                            AND return_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND (available = 'Out' OR available = 'Booked')
                        )
                        OR
                        (
                            pickup_date >= '" . $pickup_date.' '.$pickup_time.':00'."' 
                            AND pickup_date <= '" . $temp_return_date.' '.$return_time.':00'."'
                            AND (available = 'Out' OR available = 'Booked')
                        )
                    )";

			db_select($sql);
			
// 			echo $sql;

			if (db_rowcount() > 0) { 

				for ($i = 0; $i < db_rowcount(); $i++) { 

					if (func_getOffset() >= 10) { 

						$no = func_getOffset() + 1 + $i; 
					} 
					else { 

						$no = $i + 1;
					}
					
					// echo "<br>booking_id $i: ".db_get($i, 0);
    			}

    			$vehicle_status = 'active';
			}
			// echo $return_date;

		}

	}

	if(isset($filter))
	{

		// start edit

		if(isset($_POST['checkbox1'])){

			$checkAddDriver = $_POST['checkbox1'];

		}
		

		if(isset($_POST['checkbox2'])){

			$checkCdw = $_POST['checkbox2'];

		} 

		if(isset($_POST['checkbox3'])){

			$checkStickerP = $_POST['checkbox3'];
			

		} 

		if(isset($_POST['checkbox4'])){

			$checkTouchnGo = $_POST['checkbox4'];

		} 

		if(isset($_POST['checkbox5'])){

			$checkDriver = $_POST['checkbox5'];

		} 

		if(isset($_POST['checkbox6'])){

			$checkCharger = $_POST['checkbox6'];

		} 

		if(isset($_POST['checkbox7'])){

			$checkSmartTag = $_POST['checkbox7'];

		} 

		if(isset($_POST['checkbox8'])){

			$checkChildSeat = $_POST['checkbox8'];

		} 


		// end edit

		$nric_no = $_POST['nric_no'];

		$sql = "SELECT firstname,lastname,status,reason_blacklist FROM customer WHERE nric_no = '$nric_no' AND status = 'B'";

		db_select($sql);

		if (db_rowcount() > 0) { 

			func_setSelectVar();
		}
		else
		{

			vali_redirect("counter_reservation_exist.php?vehicle_id=" . $_GET['vehicle_id'] . "&search_pickup_date=" . $_GET['search_pickup_date'] . "&search_pickup_time=" . $_GET['search_pickup_time'] . "&search_return_date=" . date('Y-m-d',strtotime($return_date)) . "&search_return_time=" . $return_time . "&search_pickup_location=" . $_GET['search_pickup_location'] . "&search_return_location=" . $_GET['search_return_location'] . "&class_id=" . $_GET['class_id'] . "&delivery_cost=" . $_GET['delivery_cost'] . "&p_delivery_address=" . $_GET['p_delivery_address'] . "&r_delivery_address=" . $_GET['r_delivery_address'] . "&pickup_cost=" . $_GET['pickup_cost'] . "&p_pickup_address=" . $_GET['p_pickup_address'] . "&r_pickup_address=" . $_GET['r_pickup_address']."&nric_no=".$nric_no. "&checkAddDriver=" .$checkAddDriver. "&checkCdw=" .$checkCdw. "&checkStickerP=" .$checkStickerP. "&checkTouchnGo=" .$checkTouchnGo. "&checkDriver=" .$checkDriver. "&checkCharger=" .$checkCharger. "&checkSmartTag=" .$checkSmartTag. "&checkChildSeat=" .$checkChildSeat);
		}
	}

?>

<style>

table {
    border-spacing: 8px;
    border-collapse: inherit;
}

</style>

<!-- starto edito -->


<?php



?>

<!-- endo edito -->

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
								<h3>Counter Reservation</h3>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Agreement Details</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
												<ul class="dropdown-menu" role="menu">
													<li><a href="#">Settings 1</a></li>
													<li><a href="#">Settings 2</a></li>
												</ul>
											</li>
											<li><a class="close-link"><i class="fa fa-close"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<br>
										<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
											<form method='POST' action="">
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">Minimum Rental Time</label>
													<div class="col-md-5 col-sm-5 col-xs-11">
														<input type="text" class="form-control" value="<?php echo $min_rental_time; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">Pickup Date</label>
													<div class="col-md-5 col-sm-5 col-xs-11">
														<input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($pickup_date)); ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">Pickup Time</label>
													<div class="col-md-5 col-sm-5 col-xs-11">
														<input type="text" class="form-control" value="<?php echo $pickup_time; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">
														Return Date
														<?php
															
															if($condition != 'true')
															{
																?>
																&nbsp;<font color="red"><abbr title='Return Date has been automatically changed due to minimum rental time or exceeding business hours'><i class="fa fa-info-circle"></i></abbr></font>
																<?php
															}

														?> 
													</label>
													<div class="col-md-5 col-sm-5 col-xs-11">
														<input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($return_date_ori)); if($condition == 'false day') { echo ' -> '.date('d/m/Y', strtotime($return_date)); } ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">
														Return Time
													</label>
													<div class="col-md-5 col-sm-5 col-xs-11">
														<input type="text" class="form-control" value="<?php echo $return_time; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No &nbsp;<font color="blue"><abbr title='Please ensure the NRIC No is correct'><i class="fa fa-info-circle"></i></abbr></font></label>
													<div class="col-md-5 col-sm-5 col-xs-11">
														<input type="text" class="form-control" placeholder="NRIC No" name="nric_no" value="<?php echo $nric_no; ?>" required>
														<i><small>For malaysian IC, please remove the symbol "-" before submitting.</small></i>
														<br><br>
														<?php
														if($status == 'B')
														{ ?>

															<font color='red'><i><small>
																Customer named </small></i><b><?php echo $firstname." ".$lastname; ?></b><small><i> with </i></small><b> NRIC No: <?php echo $nric_no; ?></b><small><i> has been blacklisted due to </i></small>"<b><?php echo $reason_blacklist; ?></b>".</font>
														<?php } ?>
													</div>
												</div>
												<?php
													
													if($vehicle_status == 'active')
													{
														?>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no"></label>
															<div class="col-md-5 col-sm-5 col-xs-11">
																<font color="red">Booking cannot continue because vehicle chosen is not available during the pickup/return date that has been set.</font>
																<br><br>
																<button class="btn btn-primary" type="button" onclick="goBack()">Return</button>
									                            <script>
									                                function goBack() {
									                                    window.history.back();
									                                }
									                            </script>
															</div>
														</div>
														<?php
													}

												?>
										</div>
										<div class="ln_solid"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel" <?php if($vehicle_status == 'active') echo ' style="display: none;"'; ?>>
									<div class="x_title">
										<h2>Checklist</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-wrench"></i></a>
												<ul class="dropdown-menu" role="menu">
													<li><a href="#">Settings 1</a></li>
													<li><a href="#">Settings 2</a></li>
												</ul>
											</li>
											<li><a class="close-link"><i class="fa fa-close"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<br>
										<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
								
								

										<table width="60%" style="margin: auto;">

<?php

	$sql = "SELECT 
	description, 
	calculation, 
	amount_type, 
	amount, 
	taxable, 
	calculation,
	pic,
	case missing_cond 
	WHEN '0' Then '-' 
	WHEN '5' Then 'If missing, RM5' 
	WHEN '50' Then 'If missing, RM50' 
	WHEN '150' Then 'If missing RM150' 
	WHEN '300' Then 'If missing, RM300' 
	End as missing_cond 
	FROM option_rental";

	db_select($sql);

if (db_rowcount() > 0) {

for ($i = 0; $i < db_rowcount(); $i++) {

	?>
	<tr>
					<td><img src="assets/img/rental_option/<?php echo db_get($i, 6); ?>" width="100px" ></td>
					<td><?php echo db_get($i, 0);  ?></td>
					<td><?php 

					if(db_get($i, 2)=="RM"){ 

						if(db_get($i, 3)==0.00){

						echo db_get($i, 1);
						
						echo "<br>(".db_get($i, 7).")";


						}else{

						echo "RM".db_get($i, 3)." | ". db_get($i, 1);

						if(db_get($i, 7)!='-'){
						
							echo " <br>(".db_get($i, 7).")";

						}
						

						}

						
					}  
					else if(db_get($i, 2)=="P"){

						echo db_get($i, 3)."% | ".db_get($i, 1); 

						if(db_get($i, 7)!='-'){
						
							echo " <br>(".db_get($i, 7).")";

						}

					}

					?></td>
					<td>
						<div>
							<input type="checkbox" value="Y" name="checkbox<?php echo $i+1;?>" />

						    <span></span>


						</div>
					</td>


</tr>

				
<?php

								}

						}


?>



				
				

				
			</table>
		
			<center><input type="submit" class="btn btn-warning" name="filter" <?php if($vehicle_status == 'active') echo "disabled" ?>></center>


								
											</form>
											<div class="ln_solid"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	        <!-- /page content -->



    	<?php include('_footer.php') ?>

	    <script>
			var time = new Date().getTime();
			$(document.body).bind("mousemove keypress", function(e) {
				time = new Date().getTime();
			});

			function refresh() {
				if(new Date().getTime() - time >= 1800000) 
					window.location.reload(true);
				else 
					setTimeout(refresh, 1800000);
			}

			setTimeout(refresh, 1800000);
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