<?php
	
	session_start();

	include('_header.php');

	$_SESSION['booking'] = "yes";
	$_SESSION['cust_vehicle_id'] = $_GET['vehicle_id'];
	$_SESSION['cust_class_id'] = $_GET['class_id'];
	$_SESSION['cust_search_pickup_date'] = $_GET['search_pickup_date'];
	$_SESSION['cust_search_pickup_time'] = $_GET['search_pickup_time'];
	$_SESSION['cust_search_return_date'] = $_GET['search_return_date'];
	$_SESSION['cust_search_return_time'] = $_GET['search_return_time'];
	$_SESSION['cust_search_pickup_location'] = $_GET['search_pickup_location'];
	$_SESSION['cust_search_return_location'] = $_GET['search_return_location'];
	$_SESSION['cust_subtotal'] = $_GET['subtotal'];
	$_SESSION['cust_day'] = $_GET['day'];
	$_SESSION['cust_status'] = "booking";
 	echo "<script> alert('masuk redirect_cust'); </script>";
 	echo "vehicle_id = ".$_SESSION['cust_vehicle_id'];
 	echo "<br>class_id = ".$_SESSION['cust_class_id'];
 	echo "<br>search_pickup_date = ".$_SESSION['cust_search_pickup_date'];
 	echo "<br>search_pickup_time = ".$_SESSION['cust_search_pickup_time'];
 	echo "<br>search_return_date = ".$_SESSION['cust_search_return_date'];
 	echo "<br>search_return_time = ".$_SESSION['cust_search_return_time'];
 	echo "<br>search_pickup_location = ".$_SESSION['cust_search_pickup_location'];
 	echo "<br>search_return_location = ".$_SESSION['cust_search_return_location'];
 	echo "<br>subtotal = ".$_SESSION['cust_subtotal'];
 	echo "<br>day = ".$_SESSION['cust_day'];
 	echo "<br>cust status = ".$_SESSION['cust_status'];

 	vali_redirect("login.php");

?>