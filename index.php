<?php
session_start();
if(isset($_SESSION['cid']))
{ 
    echo "<script> 
            window.location.href='dashboard/dashboard.php';
        </script>";
}
else if(isset($_SESSION['user_id']))
{ 
    echo "<script> 
            window.location.href='user/dashboard.php';
        </script>";
}
else
{
  ?>

  <!DOCTYPE html>

<html class="load-full-screen">

<?php

require("dashboard/lib/setup.php");

session_start();

$sql = "SELECT 
	company_name,
	website_name,
	registration_no,
	address AS company_address,
	phone_no AS company_phone_no,
	image AS company_image,
	email AS company_email
	FROM company WHERE id IS NOT NULL";

db_select($sql);

if (db_rowcount() > 0) {
	func_setSelectVar();
} ?>

<head>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<link rel="apple-touch-icon" sizes="76x76" href="dashboard/assets/img/<?php echo $company_image; ?>" />
	<link rel="icon" type="image/png" href="dashboard/assets/img/<?php echo $company_image; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="LimpidThemes">
	
	<title><?php echo $website_name; ?></title>
	
    <!-- STYLES -->
	<link href="assets/css/animate.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="assets/css/owl.carousel.css" rel="stylesheet">
	<link href="assets/css/owl-carousel-theme.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="assets/css/flexslider.css" rel="stylesheet" media="screen">
	<link href="assets/css/style.css" rel="stylesheet" media="screen">
	
	<style type="text/css">
		#loader div {
	position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -50px;
}
	</style>
	
	<!-- LIGHT -->
	<link rel="stylesheet" type="text/css" href="assets/css/dummy.html" id="select-style">
	<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	
	<!-- FONTS -->
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600' rel='stylesheet' type='text/css'>

</head>

<?php

$sql = "SELECT * FROM front_page WHERE id = 1";
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

	<!-- BEGIN: SEARCH SECTION -->
	<div class="row">
		<div class="container">
			<div class="col-md-8 col-sm-6 text-center">
					<div class="hotel-tagline text-center">
						<h3><?php echo $carousel_title; ?></h3>
						<h1><?php echo $carousel_subtitle; ?></h1>
						<div class="panel panel-group" style='opacity: 0.87;'>
							<div class='panel-heading'>
								For any enquiries, please WhatsApp us by clicking the button below.<br>

								<div class="panel-body">

									<h4 style="color: black;">
										
										<h3>
											 <a target="_blank" href="https://wa.me/60144005050">
											 	<button class="btn btn-lg btn-success">
											 		<i class="fa fa-whatsapp" style="font-size:20px;color:white"></i>
											 		&nbsp; 
											 		<font color='white'>WhatsApp us now! </font>
											 		&nbsp;
											 		<i class="fa fa-whatsapp" style="font-size:20px;color:white"></i>
											 	</button>
											 </a> 
										</h3>
										<br>
										Untuk sebarang pertanyaan, sila hubungi kami melalui butang whatsapp di atas.
									</h4>
								</div>
							</div>
						</div>
					</div>
			</div>

			<div class="col-md-4 col-sm-6">
				<div class="room-check">
					<h4 class="text-center">BOOK A CAR?</h4>
					<div class="room-check-body">
						<form action="booking.php" onsubmit="return validateForm()">
							<label>Pick Up Branch</label>
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
							<div class="col-md-6 col-sm-6 col-xs-6 padding-right">
							<label>Pick Up Date</label>
							<div class="input-group">
								<input type="text" autocomplete="off" id="check_in" name="search_pickup_date" class="form-control" placeholder="DD/MM/YYYY" required>
								<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 padding-left">
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
							</div>
							<label>Return Branch</label>
							<div class="input-group">
								<select class="form-control" name="search_return_location">
										<?php
										$value = "";
										$sql = "SELECT id, description FROM location WHERE status = 'A'";
										db_select($sql);if (db_rowcount() > 0) {for ($j = 0; $j < db_rowcount(); $j++) {$value = $value . "<option value=" . db_get($j, 0) . " " . vali_iif(db_get($j, 0) == $class_id, 'Selected', '') . ">" . db_get($j, 1) . "</option>";}}
										echo $value;
										?>
								</select>
								<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
							</div>
							
							<div class="col-md-6 col-sm-6 col-xs-6 padding-right">
								<label>Return Date</label>
								<div class="input-group">
									<input type="text" autocomplete="off" id="check_out" name="search_return_date" class="form-control" placeholder="DD/MM/YYYY" required>
									<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 padding-left">
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
							</div>
							<div class="text-center">
								<button name="btn_search" type="submit">Find Cars</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: SEARCH SECTION -->

<!-- START: HOW IT WORK -->
<section id="how-it-work">
		<div class="row work-row">
			<div class="container">
				<div class="section-title text-center">
					<h2><?php echo $hero_title; ?></h2>
					<h4><?php echo $hero_subtitle; ?></h4>
					<div class="space"></div>
					<p>
						<?php echo $hero_paragraph; ?>
					</p>
				</div>
				<div class="work-step">
					<div class="col-md-4 col-sm-4 first-step text-center">
						<i class="fa fa-calendar"></i>
						<h5><?php echo $heroes_title1; ?></h5>
						<p><?php echo $heroes_sub1; ?></p>
					</div>
					<div class="col-md-4 col-sm-4 second-step text-center">
						<i class="fa fa-car"></i>
						<h5><?php echo $heroes_title2; ?></h5>
						<p><?php echo $heroes_sub2; ?></p>
					</div>
					<div class="col-md-4 col-sm-4 third-step text-center">
						<i class="fa fa-shopping-cart"></i>
						<h5><?php echo $heroes_title3; ?></h5>
						<p><?php echo $heroes_sub3; ?></p>
					</div>
				</div>
			</div>
		</div>
</section>
<!-- END: HOW IT WORK -->

<!-- START: PRODUCT SECTION-->

<section id="how-it-work">
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<style type="text/css">
h2 {
	color: #000;
	font-size: 26px;
	font-weight: 300;
	text-align: center;
	text-transform: uppercase;
	position: relative;
	margin: 30px 0 80px;
}
h2 b {
	color: #ffc000;
}
h2::after {
	content: "";
	width: 100px;
	position: absolute;
	margin: 0 auto;
	height: 4px;
	background: rgba(0, 0, 0, 0.2);
	left: 0;
	right: 0;
	bottom: -20px;
}
.carousel {
	margin: 50px auto;
	padding: 0 70px;
}
.carousel .item {
	min-height: 330px;
    text-align: center;
	overflow: hidden;
}
.carousel .item .img-box {
	height: 160px;
	width: 100%;
	position: relative;
}
.carousel .item img {	
	max-width: 100%;
	max-height: 100%;
	display: inline-block;
	position: absolute;
	bottom: 0;
	margin: 0 auto;
	left: 0;
	right: 0;
}
.carousel .item h4 {
	font-size: 18px;
	margin: 10px 0;
}
.carousel .item .btn {
	color: #333;
    border-radius: 0;
    font-size: 11px;
    text-transform: uppercase;
    font-weight: bold;
    background: none;
    border: 1px solid #ccc;
    padding: 5px 10px;
    margin-top: 5px;
    line-height: 16px;
}
.carousel .item .btn:hover, .carousel .item .btn:focus {
	color: #fff;
	background: #000;
	border-color: #000;
	box-shadow: none;
}
.carousel .item .btn i {
	font-size: 14px;
    font-weight: bold;
    margin-left: 5px;
}
.carousel .thumb-wrapper {
	text-align: center;
}
.carousel .thumb-content {
	padding: 15px;
}
.carousel .carousel-control {
	height: 100px;
    width: 40px;
    background: none;
    margin: auto 0;
    background: rgba(0, 0, 0, 0.2);
}
.carousel .carousel-control i {
    font-size: 30px;
    position: absolute;
    top: 50%;
    display: inline-block;
    margin: -16px 0 0 0;
    z-index: 5;
    left: 0;
    right: 0;
    color: rgba(0, 0, 0, 0.8);
    text-shadow: none;
    font-weight: bold;
}
.carousel .item-price {
	font-size: 13px;
	padding: 2px 0;
}
.carousel .item-price strike {
	color: #999;
	margin-right: 5px;
}
.carousel .item-price span {
	color: #f9676b;
	font-size: 110%;
}
.carousel .carousel-control.left i {
	margin-left: -3px;
}
.carousel .carousel-control.left i {
	margin-right: -3px;
}
.carousel .carousel-indicators {
	bottom: -50px;
}
.carousel-indicators li, .carousel-indicators li.active {
	width: 10px;
	height: 10px;
	margin: 4px;
	border-radius: 50%;
	border-color: transparent;
}
.carousel-indicators li {	
	background: rgba(0, 0, 0, 0.2);
}
.carousel-indicators li.active {	
	background: rgba(0, 0, 0, 0.6);
}
.star-rating li {
	padding: 0;
}
.star-rating i {
	font-size: 14px;
	color: #ffc000;
}
</style>
</head>


<?php

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
		status
		FROM class
		LEFT JOIN car_rate ON class.id = car_rate.class_id
		LEFT JOIN vehicle ON  class.id = vehicle.class_id
		WHERE status='A'
		GROUP BY class.id";

		db_select($sql);

?>   
		<div class="row work-row">
			<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2><strong>Trending Cars</strong></h2>
			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
			<!-- Carousel indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>   
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
				<div class="item carousel-item active">
					<div class="row">

						<!-- start edit -->

						<?php

						if(db_rowcount()>0){

						for($i=0;$i<4;$i++){

						?>

						<div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
									<img src="dashboard/assets/img/class/<?php echo db_get($i, 1); ?>" class="img-responsive img-fluid" alt="">
								</div>
								<div class="thumb-content">
									<h4><?php echo db_get($i, 0); ?></h4>
									<p class="item-price"><span><strong><?php echo "RM".db_get($i, 11)." / Per Day"; ?></strong></span></p>
									<div class="star-rating">
										<ul class="list-inline">
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star-o"></i></li>
										</ul>
									</div>
									<a href="#" class="btn btn-primary">Book</a>
								</div>						
							</div>
						</div>



						<?php
						}

						} else{

						echo "<tr><td colspan='8'>No records found huhu</td></tr>"; }

						?>

						<!-- end edit -->
						
						

		


					</div>
				</div>


				<div class="item carousel-item">
					<div class="row">
						
						<!-- start edit -->

						<?php

						if(db_rowcount()>0){

						for($i=4;$i<8;$i++){

						?>

						<div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
									<img src="dashboard/assets/img/class/<?php echo db_get($i, 1); ?>" class="img-responsive img-fluid" alt="">
								</div>
								<div class="thumb-content">
									<h4><?php echo db_get($i, 0); ?></h4>
									<p class="item-price"><span><strong><?php echo "RM".db_get($i, 11)." / Per Day"; ?></strong></span></p>
									<div class="star-rating">
										<ul class="list-inline">
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star-o"></i></li>
										</ul>
									</div>
									<a href="#" class="btn btn-primary">Book</a>
								</div>						
							</div>
						</div>



						<?php
						}

						} else{

						echo "<tr><td colspan='8'>No records found</td></tr>"; }

						?>

						<!-- end edit -->



					</div>
				</div>
				<div class="item carousel-item">
					<div class="row">
						
						<!-- start edit -->

						<?php

						if(db_rowcount()>0){

						for($i=8;$i<12;$i++){

						?>

						<div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
									<img src="dashboard/assets/img/class/<?php echo db_get($i, 1); ?>" class="img-responsive img-fluid" alt="">
								</div>
								<div class="thumb-content">
									<h4><?php echo db_get($i, 0); ?></h4>
									<p class="item-price"><span><strong><?php echo "RM".db_get($i, 11)." / Per Day"; ?></strong></span></p>
									<div class="star-rating">
										<ul class="list-inline">
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star-o"></i></li>
										</ul>
									</div>
									<a href="#" class="btn btn-primary">Book</a>
								</div>						
							</div>
						</div>



						<?php
						}

						} else{

						echo "<tr><td colspan='8'>No records found</td></tr>"; }

						?>

						<!-- end edit -->


					</div>
				</div>
			</div>
			<!-- Carousel controls -->
			<a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
		</div>
	</div>
</div>
</div>
</section>
<!-- END: PRODUCT SECTION -->

<!-- START: WHY CHOOSE US SECTION -->
<section id="why-choose-us">
	<div class="row choose-us-row">
		<div class="container clear-padding">
			<div class="light-section-title text-center">
				<h2 style='color: white;'>MYEZGO TRAVEL & TOURS</h2>
				<h4>Why choose us?</h4>
				<div class="space"></div>
				<p>
					Myezgo Travel & Tours Sdn Bhd (1223205-K) is a company that has stands for 3 years.
				</p>
			</div>
			<div class="col-md-4 col-sm-4 wow slideInLeft">
				<div class="choose-us-item text-center">
					<div class="choose-icon"><i class="fa fa-briefcase"></i></div>
					<h4>TRUSTED COMPANY</h4>
					<div class="panel panel-body">
						<ul class="tick text-left">
							<li class="tick">Follows Standard Operation Procedure (SOP) for systematic operation</li>
							<li class="list-item">Problem solving for help customer needs</li>
							<li class="list-item">Walk in to our branch for easy rental</li>
							<li class="list-item">Online reservation system for easy booking</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 wow slideInUp">
				<div class="choose-us-item text-center">
					<div class="choose-icon"><i class="fa fa-wrench"></i></div>
					<h4>CAR MAINTENANCE OUR TOP PRIORITY</h4>
					<div class="panel panel-body">
						<ul class="list text-left">
							<li class="list-item">Our policy to make sure all fleets on top and like new car condition at every time</li>
							<li class="list-item">Car will always be clean</li>
							<li class="list-item">Fragrance is included</li>
							<li class="list-item">Comfortable for individual/family</li>
							<li class="list-item">For your safety journey</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 wow slideInRight">
				<div class="choose-us-item text-center">
					<div class="choose-icon"><i class="fa fa-smile-o"></i></div>
					<h4>CUSTOMER FIRST</h4>
					<div class="panel panel-body">
						<ul class="list text-left">
							<li class="list-item">Good team player to handle customer need and handle customer need and handle all problems as fast as we can.</li>
							<li class="list-item">Booking first provide excellent customer satisfaction.</li>
							<li class="list-item">Deposit monet gives customers the convenience to extend and returnable</li>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- END: WHY CHOOSE US SECTION -->

<!-- START: TESTIMONIAL SECTION -->
<section id="customer-testimonial">
	<div class="row">
		<div class="container">
			<div class="section-title text-center">
				<h2><?php echo $testimonial_title; ?></h2>
				<h4><?php echo $testimonial_subtitle; ?></h4>
			</div>
			<div class="owl-carousel" id="review-customer">
				<div class="individual">
					<div class="col-md-2 col-sm-3 text-center">
						<img src="dashboard/assets/img/cms/<?php echo $testimonial_pic; ?>" alt="<?php echo $testimonial_pic; ?>">
					</div>
					<div class="col-md-10 col-sm-9 customer-word">
						<p class="text-center">
							<span><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
							<?php echo $testimonial_feedback; ?>
						</p>
						<h5 class="text-center"><?php echo $testimonial_name; ?></h5>
						<h6 class="text-center"><?php echo $testimonial_origin; ?></h6>
					</div>
				</div>
				<div class="individual">
					<div class="col-md-2 col-sm-3 text-center">
						<img src="dashboard/assets/img/cms/<?php echo $testimonial_img; ?>" alt="<?php echo $testimonial_img; ?>">
					</div>
					<div class="col-md-10 col-sm-9 customer-word">
						<p class="text-center">
							<span><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
							<?php echo $testimonial_feedbacks; ?>
						</p>
						<h5 class="text-center"><?php echo $testimonial_users; ?></h5>
						<h6 class="text-center"><?php echo $testimonial_origins; ?></h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-group text-center" style='opacity: 0.87;'>
		<div class='panel-heading'>
			For any enquiries, please WhatsApp us by clicking the button below.<br>

			<div class="panel-body">

				<h4 style="color: black;">
					
					<h3>
						 <a target="_blank" href="https://wa.me/60144005050">
						 	<button class="btn btn-lg btn-success">
						 		<i class="fa fa-whatsapp" style="font-size:20px;color:white"></i>
						 		&nbsp; 
						 		<font color='white'>WhatsApp us now! </font>
						 		&nbsp;
						 		<i class="fa fa-whatsapp" style="font-size:20px;color:white"></i>
						 	</button>
						 </a> 
					</h3>
					<br>
					Untuk sebarang pertanyaan, sila hubungi kami melalui butang whatsapp di atas.
				</h4>
			</div>
		</div>
	</div>
</section>
<!-- END: TESTIMONIAL SECTION -->

<?php include('_footer.php'); ?>

<script>
	var check_in = $('#check_in').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	var check_out = $('#check_out').datepicker({ dateFormat: 'dd/mm/yy' }).val();
</script>

<script type="text/javascript">

jQuery(function($){
	"use strict";
	$.supersized({

		//Functionality
		slideshow               :   1,		//Slideshow on/off
		autoplay				:	1,		//Slideshow starts playing automatically
		start_slide             :   1,		//Start slide (0 is random)
		random					: 	0,		//Randomize slide order (Ignores start slide)
		slide_interval          :   10000,	//Length between transitions
		transition              :   1, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
		transition_speed		:	500,	//Speed of transition
		new_window				:	1,		//Image links open in new window/tab
		pause_hover             :   0,		//Pause slideshow on hover
		keyboard_nav            :   0,		//Keyboard navigation on/off
		performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
		image_protect			:	1,		//Disables image dragging and right click with Javascript

		//Size & Position
		min_width		        :   0,		//Min width allowed (in pixels)
		min_height		        :   0,		//Min height allowed (in pixels)
		vertical_center         :   1,		//Vertically center background
		horizontal_center       :   1,		//Horizontally center background
		fit_portrait         	:   1,		//Portrait images will not exceed browser height
		fit_landscape			:   0,		//Landscape images will not exceed browser width

		//Components
		navigation              :   1,		//Slideshow controls on/off
		thumbnail_navigation    :   1,		//Thumbnail navigation
		slide_counter           :   1,		//Display slide numbers
		slide_captions          :   1,		//Slide caption (Pull from "title" in slides array)
		slides 					:  	[		//Slideshow Images
											{image : 'dashboard/assets/img/cms/<?php echo $carousel_one; ?>', title : 'Slide 2'},
											{image : 'dashboard/assets/img/cms/<?php echo $carousel_two; ?>', title : 'Slide 1'}
									]

	});
});

</script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','../../../../../www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-68058832-1', 'auto');
ga('send', 'pageview');
</script>

</body>

</html>
<?php
}
?>