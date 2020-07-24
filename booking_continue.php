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

$pickup_date = date('m/d/Y', strtotime($_GET['search_pickup_date']));
	$pickup_time = $_GET['search_pickup_time'];
	$return_date = date('m/d/Y', strtotime($_GET['search_return_date']));
	$return_time = $_GET['search_return_time'];
	$search_return_dates = date('m/d/Y H:i', strtotime("$return_date $return_time"));

	$day = dateDifference(conv_datetodbdate($search_pickup_date), conv_datetodbdate($search_return_date), '%a');
	$time = dateDifference($search_pickup_time, $search_return_time, '%h');


//	echo $day." Days &amp; ".$time." Hours"; 


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

<?php

$sql = "SELECT 
description, 
calculation, 
amount_type, 
amount, 
taxable, 
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




?>


<?php 

include '_panel.php';

	$booking = "yes";
	$cust_class_id = $_GET['class_id'];
	$cust_search_pickup_date = $_GET['search_pickup_date'];
	$cust_search_pickup_time = $_GET['search_pickup_time'];
	$cust_search_return_date = $_GET['search_return_date'];
	$cust_search_return_time = $_GET['search_return_time'];
	$cust_search_pickup_location = $_GET['search_pickup_location'];
	$cust_search_return_location = $_GET['search_return_location'];
	$cust_subtotal = $_GET['subtotal'];
	$cust_day = $_GET['day'];
	$cust_status = "booking";
 //	echo "<script> alert('booking continue'); </script>";
//	echo $cust_subtotal;


?>

<?php

$checkAddDriver="X";
$checkCdw="X";
$checkStickerP="X";
$checkTouchnGo="X";
$checkDriver="X";
$checkCharger="X";
$checkSmartTag="X";
$checkChildSeat="X";
$checkPickupDelivery="X";
$inputPickup="X";
$inputReturn="X";


if (isset($btnSubmit)) {


	if(isset($_POST['checkbox1'])){

		$checkAddDriver = $_POST['checkbox1'];
		// $priceAddDriver = db_get(0, 3);

	}
	 

	if(isset($_POST['checkbox2'])){

		$checkCdw = $_POST['checkbox2'];
		// $priceCdw = $cust_subtotal*((db_get(1, 3))/100);

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
		// $priceChildSeat = $day * 5;

	} 

	if(isset($_POST['checkboxPickup'])){

		$checkPickupDelivery = $_POST['checkboxPickup'];

		// start edit

		if(!empty($_POST['pickupLocation'])){

			$inputPickup = $_POST['pickupLocation'];
			$inputReturn = $_POST['pickupLocation'];

		} 

		if(!empty($_POST['returnLocation'])){

			$inputReturn = $_POST['returnLocation'];

		} 

	// end edit

	} 

	// start edit 2

	if(isset($_POST['checkboxDeliver'])){

		$checkPickupDelivery = $_POST['checkboxDeliver'];

		if(!empty($_POST['deliveryLocation'])){

			$inputPickup = $_POST['deliveryLocation'];
			$inputReturn = $_POST['deliveryLocation'];
		
		} 
		
		if(!empty($_POST['returnDeliveryLocation'])){
		
			$inputReturn = $_POST['returnDeliveryLocation'];
		
		} 

	} 
	

	// end edit 2

	$_SESSION['booking'] = $booking;
	$_SESSION['cust_class_id'] = $cust_class_id;
	$_SESSION['cust_search_pickup_date'] = $cust_search_pickup_date;
	$_SESSION['cust_search_pickup_time'] = $cust_search_pickup_time;
	$_SESSION['cust_search_return_date'] = $cust_search_return_date;
	$_SESSION['cust_search_return_time'] = $cust_search_return_time;
	$_SESSION['cust_search_pickup_location'] = $cust_search_pickup_location;
	$_SESSION['cust_search_return_location'] = $cust_search_return_location;
	$_SESSION['cust_subtotal'] = $cust_subtotal;
	$_SESSION['cust_day'] = $cust_day;
	$_SESSION['cust_status'] = $cust_status;
	$_SESSION['checkAddDriver'] = $checkAddDriver;
	$_SESSION['checkCdw'] = $checkCdw;
	$_SESSION['checkStickerP'] = $checkStickerP;
	$_SESSION['checkTouchnGo'] = $checkTouchnGo;
	$_SESSION['checkDriver'] = $checkDriver;
	$_SESSION['checkCharger'] = $checkCharger;
	$_SESSION['checkSmartTag'] = $checkSmartTag;
	$_SESSION['checkChildSeat'] = $checkChildSeat;
	$_SESSION['checkPickupDelivery'] = $checkPickupDelivery;
	$_SESSION['inputPickup'] = $inputPickup;
	$_SESSION['inputReturn'] = $inputReturn;


	// echo "<br>";
	// echo $priceAddDriver."<br>";
	// echo $priceCdw."<br>";
	// echo $priceDriverTotal."<br>";
	// echo $priceChildSeat;


	vali_redirect("login.php");

}

?>




	<!-- START: PAGE TITLE -->
	<div class="row page-title modify-car">
		<div class="container clear-padding text-center flight-title">
			<h3>Choose Extra Services</h3>
			<h4 class="thank">List Of Extra Services</h4>
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



	</div>
</div>
<!-- END: LISTING AREA -->



<!-- START: ABOUT-US -->
	<div class="row about-intro">
		<div class="container clear-padding">
			<div class="col-md-12 col-sm-12">

				<center><h2>Click "<strong style="color: red">X</strong>" to pick service</h2></center>

	<div class="row">

			<div class="holder">
<form method="post">

<table width="100%">

<?php

if (db_rowcount() > 0) {

for ($i = 0; $i < db_rowcount(); $i++) {

	?>
	<tr>
					<td><img src="dashboard/assets/img/rental_option/<?php echo db_get($i, 5); ?>" width="100%" ></td>
					<td><?php echo db_get($i, 0);  ?></td>
					<td><?php 

					if(db_get($i, 2)=="RM"){ 

						if(db_get($i, 3)==0.00){

						echo db_get($i, 1);
						
						echo "<br>(".db_get($i, 6).")";


						}else{

						echo "RM".db_get($i, 3)." | ". db_get($i, 1);

						if(db_get($i, 6)!='-'){
						
							echo " <br>(".db_get($i, 6).")";

						}
						

						}

						
					}  
					else if(db_get($i, 2)=="P"){

						echo db_get($i, 3)."% | ".db_get($i, 1); 

						if(db_get($i, 6)!='-'){
						
							echo " <br>(".db_get($i, 6).")";

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

					

					

					<!-- start edit -->
					<tr>
					<td><img src="dashboard/assets/img/rental_option/pickup.jpg" width="100%" ></td>
					<td width="449px">
					Pickup Customer
					<br>
					<em>(We will pick you up from your location)</em>
					</td>
					<td>According to Location (Additional charge)</td>
					<td>
						<div>
							<input type="checkbox" value="Ypickup" name="checkboxPickup" id="checkboxPickup" onclick="showLocation()" />

						    <span></span>


						</div>
					</td>
					</tr>

					<tr>
					<td colspan="4">
					<br>
					<div id="myLocation" style="display: none;">
					Enter Pickup Location:<br>
					<textarea name="pickupLocation" id="pickupLocation" rows="3"></textarea>
					<br>
					<input type="radio" name="displayReturnLocation" id="displayReturnLocation" onclick="showReturnLocation()" /> Return to different location<br>
					<br>

					<div  id="myReturnLocation" style="display: none;">
					Enter Return Location:<br>
					<textarea name="returnLocation" id="returnLocation" rows="3"></textarea>
					</div>

					</div>
					</td>
				</tr>


				<!-- start edit2 -->

				<tr>
					<td><img src="dashboard/assets/img/rental_option/delivery.jpg" width="100%" ></td>
					<td width="449px">
					Deliver to Customer
					<br>
					<em>(We will deliver the vehicle to your location)</em>
					</td>
					<td>According to Location (Additional charge)</td>
					<td>
						<div>
							<input type="checkbox" value="YDelivery" name="checkboxDeliver" id="checkboxDeliver" onclick="showDelivery()" />
						    <span></span>
						</div>
					</td>
					</tr>

					<tr>
					<td colspan="4">
					<br>
					<div id="myDelivery" style="display: none;">
					Enter Delivery Location:<br>
					<textarea name="deliveryLocation" id="deliveryLocation" rows="3"></textarea>
					<br>
					<input type="radio" name="displayReturnDeliveryLocation" id="displayReturnDeliveryLocation" onclick="showReturnDeliveryLocation()" /> Return to different location<br>
					<br>


					<div  id="myReturnDeliveryLocation" style="display: none;">
					Enter Return Location:<br>
					<textarea name="returnDeliveryLocation" id="returnDeliveryLocation" rows="3"></textarea>
					</div>

					</div>
					</td>
				</tr>

				<!-- end edit2 -->


				<script>

					var myRadios = document.getElementsByName('displayReturnLocation');
					var setCheck;
					var num = 0;

					var myRadios2 = document.getElementsByName('displayReturnDeliveryLocation');
					var setCheck2;
					var num2 = 0;

					 // Get the output text
  					var text = document.getElementById("text");

					var myLocation = document.getElementById("myLocation");
					var myDelivery = document.getElementById("myDelivery");
					var myReturnLocation = document.getElementById("myReturnLocation");
					var myReturnDeliveryLocation = document.getElementById("myReturnDeliveryLocation");

					function showLocation() {
						
	
					  if (myLocation.style.display === "none") {
					    myLocation.style.display = "block";
					    $("#pickupLocation").attr('required', ''); 

						$("#checkboxDeliver").removeAttr('checked'); 
						myDelivery.style.display = "none";
					    $("#deliveryLocation").removeAttr('required');
					  	$("#returnDeliveryLocation").removeAttr('required');
						

					  } else {
					    myLocation.style.display = "none";
					    $("#pickupLocation").removeAttr('required');
					  }
					}

					function showDelivery() {
	
					  if (myDelivery.style.display === "none") {
					    myDelivery.style.display = "block";
					    $("#deliveryLocation").attr('required', ''); 

						$("#checkboxPickup").removeAttr('checked'); 
						myLocation.style.display = "none";
					    $("#pickupLocation").removeAttr('required');
						$("#returnLocation").removeAttr('required');



					  } else {
					    myDelivery.style.display = "none";
					    $("#deliveryLocation").removeAttr('required');
					  }
					}


					for(num = 0; num < myRadios.length; num++){

					    myRadios[num].onclick = function(){
					        if(setCheck != this){
					        
					         setCheck = this;

					         myReturnLocation.style.display = "block";
					         $("#returnLocation").attr('required', '');

					        }else{
					        
					        this.checked = false;
					        setCheck = null;

					        myReturnLocation.style.display = "none";
					  		$("#returnLocation").removeAttr('required');

					    	}
					    };

					}

					for(num2 = 0; num2 < myRadios2.length; num2++){

					    myRadios2[num2].onclick = function(){
					        if(setCheck2 != this){
					        
					         setCheck2 = this;

					         myReturnDeliveryLocation.style.display = "block";
					         $("#returnDeliveryLocation").attr('required', '');

					        }else{
					        
					        this.checked = false;
					        setCheck2 = null;

					        myReturnDeliveryLocation.style.display = "none";
					  		$("#returnDeliveryLocation").removeAttr('required');

					    	}
					    };

					}
					

					window.onbeforeunload = function() {
         			//unchecked your check box here.  
      				$("input[type='checkbox']").prop('checked', false);

      				$("input[type='radio']").prop('checked', false);
					 
					};


					</script>


					<!-- end edit -->

				
		
	
				<tr>
					<td colspan="4">
						<button name="btnSubmit" type="submit">Continue</button>
					</td>
				</tr>
			</table>

		</form>
		</div>

	</div>

<!-- start css for check -->

<style type="text/css">


	body{
  background: #ecf0f1;
  font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 16px;
}

.about-intro img {
    padding: 0px; 
}

.holder{
  background: #fff;
  border-radius:5px; 	
  box-shadow: 0 2px 3px 0 rgba(0,0,0,.1);	
  margin:10px auto;
  padding:30px 20px 20px;
  width:70%;
}



td{
  border-bottom:1px solid #f6f6f6;
  padding:5px 10px;
}

td:nth-child(1){
  width: 150px;
}

@media only screen and (max-width:600px) {
  
  .holder{

  	width: 100%;

  }

  td:nth-child(1) {
    width: 350px;
  }

  td{
  border-bottom:3px solid #f6f6f6;
  padding: 0px;
  padding-bottom: 3px;
  padding-top: 3px;
	}

}

td:nth-child(2){
  width: 500px;
}
td:nth-child(3){
  width: 130px;
}

tr:last-child td{
  border:none;
  padding:30px 10px 10px;
  text-align: center;
}

input[type=checkbox] {
  cursor: pointer;
  height: 30px;
  margin:4px 0 0;
  position: absolute;
  opacity: 0;
  width: 30px;
  z-index: 2;
}

input[type=checkbox] + span {
  background: #e74c3c;
  border-radius: 50%;
  box-shadow: 0 2px 3px 0 rgba(0,0,0,.1);
  display: inline-block;
  height: 30px;
  margin:4px 0 0;
  position:relative;
  width: 30px;
  transition: all .2s ease;
}

input[type=checkbox] + span::before, input[type=checkbox] + span::after{
  background:#fff;
  content:'';
  display:block;
  position:absolute;
  width:4px;
  transition: all .2s ease;
}

input[type=checkbox] + span::before{
  height:16px;
  left:13px;
  top:7px;
  -webkit-transform:rotate(-45deg);
  transform:rotate(-45deg);
}

input[type=checkbox] + span::after{
  height:16px;
  right:13px;
  top:7px;
  -webkit-transform:rotate(45deg);
  transform:rotate(45deg);
}

input[type=checkbox]:checked + span {
  background:#2ecc71;			    
}

input[type=checkbox]:checked + span::before{
  height: 9px;
  left: 9px;
  top: 13px;
  -webkit-transform:rotate(-47deg);
  transform:rotate(-47deg);
}

input[type=checkbox]:checked + span::after{
  height: 15px;
  right: 11px;
  top: 8px;
}

input[type=submit] {
  background-color: #2ecc71;
  border: 0;
  border-radius: 4px;
  color: #FFF;
  cursor: pointer;
  display: inline-block;
  font-size:16px;
  text-align: center;
  padding: 12px 20px 14px;
}

</style>

<!-- end css for check -->
		





			</div>
			<div class="col-md-12 col-sm-12">
                <img src="dashboard/assets/img/cms/<?php echo $introduction_img; ?>" alt="<?php echo $introduction_img; ?>">
			</div>
		</div>
	</div>
	<!-- END: ABOUT-US -->

<!-- START: FOOTER -->
<?php include '_footer.php';?>
<!-- END: FOOTER -->

<script>
	var check_in = $('#check_in').datepicker({ dateFormat: 'dd/mm/yy' }).val();
	var check_out = $('#check_out').datepicker({ dateFormat: 'dd/mm/yy' }).val();
</script>

</html>