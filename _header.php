<?php

require("dashboard/lib/setup.php");

session_start();

$sql = "SELECT 
	company_name,
	website_name,
	registration_no,
	address AS company_address,
	phone_no AS company_phone_no,
	image AS company_image
	FROM company";

db_select($sql);

if (db_rowcount() > 0) {
	func_setSelectVar();
} ?>

<head>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
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