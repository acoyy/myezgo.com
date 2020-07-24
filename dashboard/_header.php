<?php
 require("lib/setup.php"); 

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

  } 

  ?>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/<?php echo $company_image; ?>" />
	<link rel="icon" type="image/png" href="assets/img/<?php echo $company_image; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $website_name; ?></title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/datepicker.css" />
    
    <script type="text/javascript" src="assets/js/html5-canvas-drawing-app.js"></script>
    <script src="assets/js/fabric.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

  </head>

  <?php
  func_setReqVar(); 
  
  $sql = "SELECT * FROM user WHERE id=" . $_SESSION['cid']; 
  db_select($sql); 
  
  if (db_rowcount() > 0) { 

  	func_setSelectVar(); 

  } 

  ?>