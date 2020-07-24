<?php
session_start();
if(isset($_SESSION['user_id']))
{ 
$idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

if (time()-$_SESSION['timestamp']>$idletime){
session_unset();
session_destroy();
echo "<script> alert('You have been logged out due to inactivity'); </script>";
echo "<script>
window.location.href='../login.php';
</script>";
}else{
$_SESSION['timestamp']=time();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('_header.php'); 
require("lib/phpmailer/class.phpmailer.php"); 

// echo $_GET['search_pickup_date'];
$pickup_date = date('m/d/Y', strtotime($_GET['search_pickup_date']));
$pickup_time = $_GET['search_pickup_time'];
$return_date = date('m/d/Y', strtotime($_GET['search_return_date']));
$return_time = $_GET['search_return_time'];
$search_return_dates = date('m/d/Y H:i', strtotime("$return_date $return_time"));
$day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a'); 
// $day = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%a Day %h Hours'); 

// $day = date_diff($pickup,$return); 

$time = dateDifference($pickup_date.$pickup_time, $return_date.$return_time, '%h'); 
// $day = $diff - $hours * (60 * 60);

$mydate = date('m/d/Y', strtotime($_GET['search_pickup_date']));
$mymonth = date("m",strtotime($mydate));
$myday = date("d",strtotime($mydate));
$myyear = date("Y",strtotime($mydate));

// echo "<br>My Day:".$myday;
// echo "<br>My Month:".$mymonth;
// echo "<br>My year:".$myyear;
// echo 'Day: '.$day;
// echo '<br>';
// echo 'Hours: '.$time;
// echo '<br>';
// echo 'No Convert Pickup Date '.$_GET['search_pickup_date'];
// echo '<br>';
// echo 'Convert Pickup Date '.date('m/d/Y', strtotime($_GET['search_pickup_date']));
// echo '<br>';
// echo 'Search pickup time: '.$_GET['search_pickup_time'];
// echo '<br>';
// echo 'Search return time: '.$_GET['search_return_time'];
// echo '<br>';
// echo 'p pickup address: '.$_GET['p_pickup_address'];
// echo '<br>';
// echo 'r pickup address: '.$_GET['r_pickup_address'];
// echo '<br>';
// echo "Pickup Location: ".$_GET['search_pickup_location'];
// echo "<br>";
// echo "Delivery Cost: ".$_GET['delivery_cost'];
// echo "<br>";
// echo "Pickup Cost: ".$_GET['pickup_cost'];


$sql = "SELECT * FROM car_rate WHERE class_id=" . $_GET['class_id']; 
db_select($sql); 

if (db_rowcount() > 0) { 

func_setSelectVar();

$dbcar_rate_class_id = $class_id;
$dbcar_rate_oneday = $oneday;
$dbcar_rate_twoday = $twoday;
$dbcar_rate_threeday = $threeday;
$dbcar_rate_fourday = $fourday;
$dbcar_rate_fiveday = $fiveday;
$dbcar_rate_sixday = $sixday;
$dbcar_rate_weekly = $weekly;
$dbcar_rate_monthly = $monthly;
$dbcar_rate_hour = $hour;
$dbcar_rate_halfday = $halfday;
$dbcar_rate_deposit = $deposit;

} 

// echo date('m/d/Y', strtotime($_GET['search_return_date'])).' '.$_GET['search_return_time'].':00';
// echo '<br>';




$sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day FROM promotion WHERE status = '1'"; 

db_select($sql); 
if (db_rowcount() > 0) { 
func_setSelectVar(); 

$dbpromo_how_many_day_min = $how_many_day_min;
$dbpromo_how_many_day_max = $how_many_day_max;
} 


$freeday = 'false';

$difference_hour = $time - 12; 

if($day == 0) {

if($time < 8){

$subtotal = $time * $dbcar_rate_hour; 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_halfday;
} 

else if($time >= 13){ 

$subtotal = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
} 

} 

elseif ($day == 1) { 


if($time < 8){

$subtotal = $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_oneday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} 

elseif ($day == 2) { 

if($time < 8){

$subtotal = $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_twoday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 3) { 

if($time < 8){

$subtotal = $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_threeday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 4) { 

if($time < 8){

$subtotal = $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_fourday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 5) { 

if($time < 8){

$subtotal = $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_fiveday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 6) { 

if($time < 8){

$subtotal = $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_sixday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
} 

} elseif ($day == 7) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 8) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 9) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 10) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 11) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 12) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 13) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 14) { 

if($time < 8){

$subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_weekly + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 15) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 16) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 17) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + $dbcar_rate_halfday; 

} 

elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour);

} 

} elseif($day == 18) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif($day == 19) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 20) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_sixday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 21) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 2) + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 22) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 23) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_twoday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 24) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_threeday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 25) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fourday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 26) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_fiveday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} else if ($day == 27) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_sixday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 28) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 3) + $dbcar_rate_weekly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 29) { 

if($time < 8){

$subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) {

$subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = ($dbcar_rate_weekly * 4) + $dbcar_rate_oneday + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

} elseif ($day == 30) { 

if($time < 8){

$subtotal = $dbcar_rate_monthly + ($time * $dbcar_rate_hour); 
}

else if($time >= 8 && $time <= 12) { 

$subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday; 

} elseif ($time >= 13){ 

$subtotal = $dbcar_rate_monthly + $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 

} 

}

$six_digit_random_number = mt_rand(100000, 999999); 
func_setReqVar();

$est_total = $subtotal + $_GET['delivery_cost'] + $_GET['pickup_cost'];
// echo "<br>674) est_total: ".$est_total;
$Discount = '0';
$_SESSION['subtotal'] = $subtotal;
// echo "<br>677) session subtotal: ".$_SESSION['subtotal'];
$_SESSION['est_total'] = $est_total;
// echo "<br>679) session est_total: ".$_SESSION['est_total'];
$_SESSION['Discount'] = $Discount;
// echo "<br>681) session Discount: ".$_SESSION['Discount'];
$_SESSION['search_return_dates'] = $search_return_dates;

if(isset($btn_redeem))
{

$sqlDis = "SELECT * FROM discount WHERE code='$coupon'";

db_select($sqlDis);

if (db_rowcount() > 0) 
{

func_setSelectVar();

$dbdis_code = $code;
// echo "<br>695) code: ".$code;
$dbdis_start_date = $start_date;
// echo "<br>697) start_date: ".$start_date;
$dbdis_end_date = $end_date;
// echo "<br>699) end_date: ".$end_date;
$dbdis_value_in = $value_in;
// echo "<br>701) value_in: ".$value_in;
$dbdis_rate = $rate;
// echo "<br>703) rate: ".$rate;
// echo "<br>705) pickupdate: ".date('m/d/Y', strtotime($search_pickup_date));
// echo "<br>706) pickupdatedb: ".date('m/d/Y', strtotime($dbdis_start_date));

// $Discount = number_format($dbdis_rate,2);

// echo "Discount null :".$Discount;

if(date('m/d/Y', strtotime($search_pickup_date))>=date('m/d/Y', strtotime($dbdis_start_date)) && date('m/d/Y', strtotime($search_return_dates)) <= date('m/d/Y', strtotime($dbdis_end_date)) ) 
{

if($dbdis_value_in=='A')
{

$est_total = $est_total - $dbdis_rate;
$Discount = number_format($dbdis_rate,2);
}

else if($dbdis_value_in=='P'){

$percent = $est_total / $dbdis_rate;
$est_total = $est_total - $percent;
$Discount = number_format($percent,2);
}

else if($dbdis_value_in=='H'){

$date = date('m/d/Y H:i:s', strtotime($search_return_dates)); 
$newdate = strtotime('+ '.$dbdis_rate.' hours', strtotime($date));
$newdate = date('m/d/Y H:i', $newdate); 
$counthour = date('Hi', strtotime($newdate));
$note = "";
$exceed = "";
$extend = "";
// $counthour = "900";
// echo "<br>hour: ".$counthour;
if($counthour > "2230")
{
// echo "<br>masuk if1";
$newdate = date('m/d/Y', strtotime($newdate)). " 22:30";
// echo "<br>".$newdate;
$note = "The actual ".$dbdis_rate."-hour extended time exceeded working hours, converting to maximum return time (10:30 pm)";
$exceed = "true";
}
else if($counthour < "800")
{
// echo "<br>masuk if2";
$newdate = date('m/d/Y', strtotime($search_return_dates)). " 22:30";
// echo "<br>".$newdate;
$note = "The actual ".$dbdis_rate."-hour extended time exceeded working hours, converting to maximum return time (10:30 pm)";
$exceed = "true";
}
else
{
$extend = "true";
$note = $dbdis_rate." hours period has been added";
}

$newdate = date('m/d/Y H:i', strtotime($newdate)); 
$search_return_dates = $newdate; 
echo '<script language="javascript">'; 
echo 'alert("Free half Day");'; 
echo '</script>';
$freeday = 'true';

// 			echo $newdate;
}

else if($dbdis_value_in == 'D'){

$date = date('m/d/Y H:i:s', strtotime($search_return_dates)); 
$newdate = strtotime('+ '.$dbdis_rate.' days', strtotime($date));
$newdate = date('m/d/Y H:i', $newdate); 

$newdate = date('m/d/Y H:i', strtotime($newdate)); 
$search_return_dates = $newdate; 
echo '<script language="javascript">'; 
if($dbdis_rate > 1)
echo 'alert("Free '.$dbdis_rate.' Days");'; 
else
echo 'alert("Free '.$dbdis_rate.' Day");'; 
echo '</script>';
$freeday = 'true';

$note = "The return date has been extended";
$extend = "true";
}

$_SESSION['subtotal'] = $subtotal;
$_SESSION['est_total'] = $est_total;
$_SESSION['Discount'] = $Discount;
$_SESSION['search_return_dates'] = $search_return_dates;
}

else {

echo "<script>alert('Coupon is not active');</script>";
}

// echo "<br>code: ".$dbdis_code;
// echo "<br>rate: ".$dbdis_rate;
// echo "<br>start: ".$dbdis_start_date;
// echo "<br>end: ".$dbdis_end_date;
// echo "<br>form pickup date: ".$search_pickup_date;
// echo "<br>form return date: ".$search_return_date;
}
else if(db_rowcount() == 0 && $coupon != '')
{
echo "<script>alert('Coupon does not exist');</script>";
}
}
// else if (!isset($btn_redeem) && !isset($btn_save))
// {

// 	$_SESSION['subtotal'] = $subtotal;
// 	$_SESSION['est_total'] = $est_total;
// 	$_SESSION['Discount'] = $Discount;
// 	echo "<script> alert('takkan masuk sini kot'); </script>";
// }


else if (isset($btn_save)){
//button SAVE clicked

$answer = $_POST['rtype'];
$subtotal = $_POST['subtotal'];
$est_total = $_POST['est_total'];
$Discount = $_POST['discount'];
$search_return_dates = $_SESSION['search_return_dates'];

// echo "<script> alert('772) subtotal: ".$subtotal."'); </script>";
// echo "<script> alert('773) est total: ".$est_total."'); </script>";
// echo "<script> alert('774) Discount: ".$Discount."'); </script>";
// echo "<script> alert('844) search_return_dates: ".$search_return_dates."'); </script>";

if ($answer == "pickup") 
{
func_setValid("Y"); 
func_isEmpty($firstname, "first name"); 
func_isEmpty($lastname, "last name"); 
func_isEmpty($license_no, "license no"); 
func_isEmpty($age, "age"); 
func_isNum($age, "age"); 
func_isEmpty($phone_no, "phone no"); 
func_isEmpty($postcode, "postcode"); 
func_isEmpty($city, "city"); 
func_isEmpty($country, "country"); 
func_isEmpty($payment_amount, "payment amount"); 
func_isEmpty($ref_name, "reference name"); 
func_isEmpty($ref_relationship, "reference relationship"); 
func_isEmpty($ref_address, "reference address"); 
func_isEmpty($ref_phoneno, "reference phone no"); 
func_isNum($payment_amount, "payment amount"); 


if (func_isValid()) 
{
// echo "<script> alert('masuk valid'); </script>";

$sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $_GET['vehicle_id']; 
db_update($sql); 

if($drv_license_exp != '' && $drv_license_exp != NULL)
{
$drv_license_exp = date('Y-m-d', strtotime($drv_license_exp));
}

$sql = "UPDATE customer SET 
firstname = '" . conv_text_to_dbtext3($firstname) . "',
lastname = '" . conv_text_to_dbtext3($lastname) . "',
license_no = '" . conv_text_to_dbtext3($license_no) . "',
license_exp = '" . conv_text_to_dbtext3($license_exp) . "',
age = '" . $age . "',
phone_no = '" . conv_text_to_dbtext3($phone_no) . "',
email = '" . conv_text_to_dbtext3($email) . "',
address = '" . conv_text_to_dbtext3($address) . "',
address = '" . conv_text_to_dbtext3($address) . "',
postcode = '" . conv_text_to_dbtext3($postcode) . "',
city = '" . conv_text_to_dbtext3($city) . "',
country = '" . conv_text_to_dbtext3($country) . "',
status = '" . conv_text_to_dbtext3($status) . "',
cid = '" . $_SESSION['cid'] . "',
cdate = CURRENT_TIMESTAMP,
ref_name = '" . conv_text_to_dbtext3($ref_name) . "',
ref_phoneno = '" . conv_text_to_dbtext3($ref_phoneno) . "',
ref_relationship = '" . conv_text_to_dbtext3($ref_relationship) . "',
ref_address = '" . conv_text_to_dbtext3($ref_address) . "',
drv_name = '" . conv_text_to_dbtext3($drv_name) . "',
drv_nric = '" . conv_text_to_dbtext3($drv_nric) . "',
drv_address = '" . conv_text_to_dbtext3($drv_address) . "',
drv_phoneno = '" . conv_text_to_dbtext3($drv_phoneno) . "',
drv_license_no = '" . conv_text_to_dbtext3($drv_license_no) . "',
drv_license_exp = '" . $drv_license_exp . "',
survey_type = '" . $survey_type . "',
survey_details = '" . conv_text_to_dbtext3($survey_details) . "'
where nric_no = '$nric_no'";

db_update($sql); 

$sql = "SELECT id FROM customer where nric_no = '$nric_no'"; 

db_select($sql); 

if (db_rowcount() > 0) 
{

$dbcustomer_id = db_get(0, 0); 
} 

// echo "<br> customer_id: ".$dbcustomer_id;

if ($_GET['pickup_cost'] >= 1) 
{

$sql = "INSERT INTO booking_trans
(
pickup_date,
pickup_location,
pickup_time,
return_date,
return_location,
return_time,
option_rental_id,
cdw,
discount_amount,
vehicle_id,
day,
sub_total,
est_total,
customer_id,
created,
refund_dep,
refund_dep_payment,
type,
balance,
p_cost,
p_address,
p_address2,
agent_code,
available,
branch
)
VALUES
(
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].':00'. "',
'$search_pickup_location',
'$search_pickup_time',
'" .date('Y-m-d', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).':00'."',
'$search_return_location',
'.date('H:i', strtotime($search_return_dates)).',
0,
0,
'$Discount',
" . $_GET['vehicle_id'] . ",
'$day',
'$est_total',
'$est_total',
'$dbcustomer_id',
CURRENT_TIMESTAMP,
'$deposit',
'$refund_dep_payment',
0,
'$payment_amount',
" . $_GET['pickup_cost'] . ",
'" . conv_text_to_dbtext3($_GET['p_pickup_address']) . "',
'" . conv_text_to_dbtext3($_GET['r_pickup_address']) . "',
'$agent',
'Booked',
'".$_SESSION['user_branch']."'
),
";

db_update($sql);
} 

else if ($_GET['delivery_cost'] >= 1) 
{ 

$sql = "INSERT INTO booking_trans
(
pickup_date,
pickup_location,
pickup_time,
return_date,
return_location,
return_time,
option_rental_id,
cdw,
discount_amount,
vehicle_id,
day,
sub_total,
payment_details,
est_total,
customer_id,
created,
refund_dep,
refund_dep_payment,
type,
balance,
r_cost,
r_address,
r_address2,
agent_code,
available,
branch
)
VALUES
(
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].':00'.  "',
'$search_pickup_location',
'$search_pickup_time',
'" .date('Y-m-d', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).':00'."',
'$search_return_location',
'.date('H:i', strtotime($search_return_dates)).',
0,
0,
'".$Discount."',
" . $_GET['vehicle_id'] . ",
'$day',
'$est_total',
'$payment_details',
'$est_total',
'$dbcustomer_id',
CURRENT_TIMESTAMP,
'$deposit',
'$refund_dep_payment',
0,
'$payment_amount',
" . $_GET['delivery_cost'] . ",
'" . conv_text_to_dbtext3($_GET['p_delivery_address']) . "',
'" . conv_text_to_dbtext3($_GET['r_delivery_address']) . "',
'$agent',
'Booked',
'".$_SESSION['user_branch']."'
)
"; 

db_update($sql); 

} 

else 
{ 

$sql = "INSERT INTO booking_trans
(
pickup_date,
pickup_location,
pickup_time,
return_date,
return_location,
return_time,
option_rental_id,
cdw,
discount_amount,
vehicle_id,
day,
sub_total,
payment_details,
est_total,
customer_id,
created,
refund_dep,
refund_dep_payment,
type,
balance,
agent_code,
available,
branch
)
VALUES
(
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
'$search_pickup_location',
'$search_pickup_time',
'" .date('Y-m-d', strtotime($search_return_dates))." ".date('H:i', strtotime($search_return_dates)).":00"."',
'$search_return_location',
'".date('H:i', strtotime($search_return_dates))."',
0,
0,
'".$Discount."',
" . $_GET['vehicle_id'] . ",
'$day',
'$est_total',
'$payment_details',
'$est_total',
'$dbcustomer_id',
CURRENT_TIMESTAMP,
'$deposit',
'$refund_dep_payment',
0,
'$payment_amount',
'$agent',
'Booked',
'".$_SESSION['user_branch']."'
)
"; 

db_update($sql); 
}

// echo "<br> sql 1101: ".$sql;

// $sql = "SELECT LAST_INSERT_ID() FROM booking_trans"; 
// db_select($sql); 

// if (db_rowcount() > 0) {

$booking_id = mysqli_insert_id($con);
// }

// echo "<br>1111) Booking id: ".$booking_id;

$sql = "SELECT id, description, initial from location WHERE id = '$search_pickup_location'" ;

db_select($sql);

if (db_rowcount() > 0) {

// $pickup_location = db_get(0, 1);

$pickup_initial = db_get(0, 2);

}

if($agent==''){

$agent='000';
}

if($booking_id<10){

$agr_no='000'.$booking_id;
}

elseif ($booking_id<100) {

$agr_no='00'.$booking_id;
}

elseif ($booking_id<1000) {

$agr_no='0'.$booking_id;
}

elseif ($booking_id<10000) {

$agr_no=$booking_id;
}

$agreement_no=$pickup_initial.$agent.$mymonth.$myday.$agr_no;

 echo $agreement_no;

$sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;

db_update($sql);
// echo "<br>1118) masuk booking trans update pickup, agreement no: ".$agreement_no." booking id: ".$booking_id;

$sql = "INSERT INTO checklist (booking_trans_id) VALUES ($booking_id)"; 

db_update($sql);

// echo "<script> alert('db deposit: ".$dbcar_rate_deposit."'); </script>";
// echo "<script> alert('user deposit: ".$deposit."'); </script>";
}

}

//pickupelse
else if($answer == "booking")
{

func_setValid("Y"); 
func_isEmpty($nric_no, "nric no"); 
func_isEmpty($title, "title"); 
func_isEmpty($firstname, "first name"); 
func_isEmpty($lastname, "last name"); 
func_isEmpty($license_no, "license no"); 
func_isEmpty($age, "age"); 
func_isNum($age, "age"); 
func_isEmpty($phone_no, "phone no"); 
func_isEmpty($postcode, "postcode"); 
func_isEmpty($city, "city"); 
func_isEmpty($country, "country"); 


if (func_isValid()) {

$sql = "UPDATE vehicle SET availability = 'Booked' WHERE id=" . $_GET['vehicle_id']; 
db_update($sql); 

// echo "<br>1151) masuk update vehicle booking, vehicle_id: ".$_GET['vehicle_id'];

$sql = "UPDATE customer SET
firstname = '" . conv_text_to_dbtext3($firstname) . "',
lastname = '" . conv_text_to_dbtext3($lastname) . "',
license_no = '" . conv_text_to_dbtext3($license_no) . "',
license_exp = '" . date('Y-m-d', strtotime($license_exp)) . "',
age = '" . $age . "',
phone_no = '" . conv_text_to_dbtext3($phone_no) . "',
email = '" . conv_text_to_dbtext3($email) . "',
address = '" . conv_text_to_dbtext3($address) . "',
postcode = '" . conv_text_to_dbtext3($postcode) . "',
city = '" . conv_text_to_dbtext3($city) . "',
country = '" . conv_text_to_dbtext3($country) . "',
status = 'A',
cid = '" . $_SESSION['cid'] . "',
cdate = CURRENT_TIMESTAMP
where nric_no = '$nric_no'";

db_update($sql); 

// $sql = "SELECT LAST_INSERT_ID() FROM customer"; 

// db_select($sql); 

// if (db_rowcount() > 0) { 

$dbcustomer_id = mysqli_insert_id($con); 

// } 
// echo "<br>1208) masuk customer booking, latest customer id: ".$dbcustomer_id;

if ($_GET['pickup_cost'] >= 1) { 

$sql = "INSERT INTO booking_trans
(
pickup_date,
pickup_location,
pickup_time,
return_date,
return_location,
return_time,
option_rental_id,
cdw,
discount_amount,
vehicle_id,
day,
sub_total,
payment_details,
est_total,
customer_id,
created,
refund_dep,
refund_dep_payment,
type,
agent_code,
available,
p_cost,
p_address,
p_address2,
branch,
staff_id
)
VALUES
(
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].  "',
'$search_pickup_location',
'$search_pickup_time',
'" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
'$search_return_location',
'$search_return_time',
0,
0,
'".$Discount."',
" . $_GET['vehicle_id'] . ",
'$day',
'$subtotal',
'$payment_details',
'$est_total',
'$dbcustomer_id',
CURRENT_TIMESTAMP,
'$deposit',
'$refund_dep_payment',
0,
'$agent',
'Booked',
" . $_GET['pickup_cost'] . ",
'" . conv_text_to_dbtext3($_GET['p_pickup_address']) . "',
'" . conv_text_to_dbtext3($_GET['r_pickup_address']) . "',
'".$_SESSION['user_branch']."',
'".$_SESSION['cid']."'
)
"; 

db_update($sql);
// echo "<br>1293) masuk customer pickup cost booking";

} 

elseif ($_GET['delivery_cost'] >= 1) { 

$sql = "INSERT INTO booking_trans
(
pickup_date,
pickup_location,
pickup_time,
return_date,
return_location,
return_time,
option_rental_id,
cdw,
discount_amount,
vehicle_id,
day,
sub_total,
payment_details,
est_total,
customer_id,
created,
refund_dep,
refund_dep_payment,
type,
r_cost,
r_address,
r_address2,
agent_code,
available,
branch,
staff_id
)
VALUES
(
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
'$search_pickup_location',
'$search_pickup_time',
'" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
'$search_return_location',
'$search_return_time',
0,
0,
'".$Discount."',
" . $_GET['vehicle_id'] . ",
'$day',
'$subtotal',
'$payment_details',
'$est_total',
'$dbcustomer_id',
CURRENT_TIMESTAMP,
'$deposit',
'$refund_dep_payment',
0,
" . $_GET['delivery_cost'] . ",
'" . conv_text_to_dbtext3($_GET['p_delivery_address']) . "',
'" . conv_text_to_dbtext3($_GET['r_delivery_address']) . "',
'$agent',
'Booked',
'".$_SESSION['user_branch']."',
'".$_SESSION['cid']."'
)
"; 

db_update($sql);
// echo "<br>1360) masuk customer delivery cost booking";



} 

else { 

$sql = "INSERT INTO booking_trans
(
pickup_date,
pickup_location,
pickup_time,
return_date,
return_location,
return_time,
option_rental_id,
cdw,
discount_amount,
vehicle_id,
day,
sub_total,
payment_details,
est_total,
customer_id,
created,
refund_dep,
refund_dep_payment,
type,
agent_code,
available,
branch,
staff_id
)
VALUES
(
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
'$search_pickup_location',
'$search_pickup_time',
'" .date('Y-m-d', strtotime($search_return_dates)).' '.$_GET['search_return_time']."',
'$search_return_location',
'$search_return_time',
0,
0,
'".$Discount."',
" . $_GET['vehicle_id'] . ",
'$day',
'$subtotal',
'$payment_details',
'$est_total',
'$dbcustomer_id',
CURRENT_TIMESTAMP,
'$deposit',
'$refund_dep_payment',
0,
'$agent',
'Booked',
'".$_SESSION['user_branch']."',
'".$_SESSION['cid']."'
)
"; 

db_update($sql);

// echo "<br>1426) masuk customer takada cost booking";
}

$_SESSION["Discount"] = '0';  

// if($result)
// {

// $sql = "SELECT LAST_INSERT_ID() FROM booking_trans "; 
// db_select($sql); 

// if (db_rowcount() > 0) { 

$booking_id = mysql_insert_id(); 

// echo "<script>alert('counter booking id: ".$booking_id."');</script>";
// }
// else
// {
// echo "<script>alert('tak masuk');</script>";
// break;
// }
// echo "<br>1448) latest booking_id: ".$booking_id;

$sql = "SELECT id, description, initial from location WHERE id = '$search_pickup_location'";

db_select($sql);

if (db_rowcount() > 0) {

// $pickup_location = db_get(0, 1);
$pickup_initial = db_get(0, 2);
}
else
{
echo "<script> alert('tak jumpa');</script>";
}

if($agent==''){

$agent='000';
}

if($booking_id<10){

$agr_no='000'.$booking_id;

}

elseif ($booking_id<100) {

$agr_no='00'.$booking_id;
}

elseif ($booking_id<1000) {

$agr_no='0'.$booking_id;
}

$agreement_no=$pickup_initial.$agent.$mymonth.$myday.$agr_no;

// echo $agreement_no;

$sql = "UPDATE booking_trans SET agreement_no =  '".$agreement_no."' WHERE id =".$booking_id;

db_update($sql);
// echo "<br>1488) masuk update booking trans booking, agreement_no: ".$agreement_no." booking_id: ".$booking_id;

$sql = "INSERT INTO checklist (booking_trans_id) VALUES ($booking_id)"; 

db_update($sql); 

// echo "<br>1494) masuk checklist booking, booking id: ".$booking_id;
// }
// }

// else{

// 	echo "<script>alert('tak masuk booking_trans');</script>";
// }

} 
}

$sql = "INSERT INTO sale 
(
booking_trans_id,
vehicle_id,
total_day,
total_sale,
pickup_date,
return_date,
created
)
VALUES (
'$booking_id',
'" . $_GET['vehicle_id'] . "',
'$day',
'$est_total',
'" . date('Y-m-d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time']."',
'" . date('Y-m-d', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00"."',
CURRENT_TIMESTAMP
)";

db_update($sql);
// echo "<br>1527) masuk sale";

// $sql = "SELECT LAST_INSERT_ID() FROM sale"; 
// db_select($sql); 

// if (db_rowcount() > 0) { 

$sale_id = mysql_insert_id(); 
// }
// else
// {
// echo "<script>alert('tak masuk');</script>";
// // break;
// }

// $sale_id = '2000';
// echo "<br>1545) masuk sale, sale id: ".$sale_id;


$daylog = '0';
$datelog = date('Y/m/d', strtotime($_GET['search_pickup_date'])).' '.$_GET['search_pickup_time'].":00";

// echo "<br><br>1631) datelog: ".$datelog;

$hourlog = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($search_return_dates)).date('H:i', strtotime($search_return_dates)), '%h');
$day = dateDifference($pickup_date.$pickup_time, date('m/d/Y', strtotime($search_return_dates)).date('H:i', strtotime($search_return_dates)), '%a');

$a = 0;

// echo "<br><br>1638) day: ".$day;

$datenew = date('Y/m/d', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00";

// echo "<br><br>1640) datenew: ".$datenew;

while($datelog <= $datenew)
{

// echo "<br><br><<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<LOOP>>>>>>>>>>>>>>>>>>>>>>>>>>";
// echo "<br><br>1641) datelog: ".$datelog;
$currdate = date('Y-m-d',strtotime($datelog)).' '.$_GET['search_pickup_time'].":00";
// echo "<br> return date: ".date('m/d/Y', strtotime($search_return_dates)).' '.date('H:i', strtotime($search_return_dates)).":00";

$daydiff = dateDifference($datelog, date('m/d/Y', strtotime($search_return_dates)).' '.$_GET['search_pickup_time'], '%a'); 

$mymonth = date("m",strtotime($datelog));
$myyear = date("Y",strtotime($datelog));

// echo "<br><br>1656)year: ".$myyear;

// echo "<br><br>1656)normal date:".date("d/m/Y",strtotime($datelog));

$week1date1 = date('Y/m/d', strtotime($mymonth.'/01/'.$myyear))." 00:00:00";
$week1date2 = date('Y/m/d', strtotime($mymonth.'/07/'.$myyear))." 23:59:59";
$week2date1 = date('Y/m/d', strtotime($mymonth.'/08/'.$myyear))." 00:00:00";
$week2date2 = date('Y/m/d', strtotime($mymonth.'/14/'.$myyear))." 23:59:59";
$week3date1 = date('Y/m/d', strtotime($mymonth.'/15/'.$myyear))." 00:00:00";
$week3date2 = date('Y/m/d', strtotime($mymonth.'/21/'.$myyear))." 23:59:59";
$week4date1 = date('Y/m/d', strtotime($mymonth.'/22/'.$myyear))." 00:00:00";
$week4date2 = date('Y/m/d', strtotime($mymonth.'/28/'.$myyear))." 23:59:59";
$week5date1 = date('Y/m/d', strtotime($mymonth.'/29/'.$myyear))." 00:00:00";
$week5date2 = date('Y/m/d', strtotime($mymonth.'/31/'.$myyear))." 23:59:59";

if($mymonth == '1')
{

$monthname = 'jan';
}
else if($mymonth == '2')
{

$monthname = 'feb';
}
else if($mymonth == '3')
{

$monthname = 'march';
}
else if($mymonth == '4')
{

$monthname = 'apr';
}
else if($mymonth == '5')
{

$monthname = 'may';
}
else if($mymonth == '6')
{

$monthname = 'june';
}
else if($mymonth == '7')
{

$monthname = 'july';
}
else if($mymonth == '8')
{

$monthname = 'aug';
}
else if($mymonth == '9')
{

$monthname = 'sept';
}
else if($mymonth == '10')
{

$monthname = 'oct';
}
else if($mymonth == '11')
{

$monthname = 'nov';
}
else if($mymonth == '12')
{

$monthname = 'dec';
}

if($datelog >= $week1date1 && $datelog <= $week1date2)
{

$week = 'week1';
}

else if($datelog >= $week2date1 && $datelog <= $week2date2)
{

$week = 'week2';
}

else if($datelog >= $week3date1 && $datelog <= $week3date2)
{

$week = "week3";
}

else if($datelog >= $week4date1 && $datelog <= $week4date2)
{

$week = 'week4';
}

else if($datelog >= $week5date1 && $datelog <= $week5date2)
{

$week = 'week5';
}

if($hourlog != '0' )
{

if($time < 8){

$daily_sale = $time * $dbcar_rate_hour; 
}

else if($time >= 8 && $time <= 12) {

$daily_sale = $dbcar_rate_halfday;
} 

else if($time >= 13){ 

$daily_sale = $dbcar_rate_halfday + ($dbcar_rate_hour * $difference_hour); 
80 + 80;
} 

$sql = "INSERT INTO sale_log 
(
sale_id,
daily_sale,
day,
hour,
type,
".$week.",
".$monthname.",
year,
date,
created
)
VALUES (
'$sale_id',
'$daily_sale',
'0',
'$hourlog',
'hour',
'$daily_sale',
'$daily_sale',
'$myyear',
'$currdate',
CURRENT_TIMESTAMP
)";

db_update($sql);
// echo "<br>1707) masuk sale log ".$a;

// echo "<br><br> 1810) a= '$a' sql:".$sql;

$est_total = $est_total - $daily_sale;

$hourlog = '0';
}

else if($hourlog == '0' && $a == '0')
{

$sql = "INSERT INTO sale_log 
(
sale_id,
daily_sale,
day,
hour,
".$week.",
type,
year,
date,
created
)
VALUES (
'$sale_id',
'0',
'0',
'0',
'0',
'firstday',
'$myyear',
'$currdate',
CURRENT_TIMESTAMP
)";

db_update($sql);

// echo "<br><br> 1842) a= '$a' sql:".$sql;
}

else if($hourlog == '0' && $a > 0)
{

$daily_sale = $est_total / $day;

$daylog = $daylog + 1;

$sql = "INSERT INTO sale_log 
(
sale_id,
daily_sale,
day,
type,
hour,
".$week.",
".$monthname.",
year,
date,
created
)
VALUES (
'$sale_id',
'$daily_sale',
'$daylog',
'day',
'0',
'$daily_sale',
'$daily_sale',
'$myyear',
'$currdate',
CURRENT_TIMESTAMP
)";

db_update($sql);

// echo "<br><br> 1876) a= '$a' sql:".$sql;
}

$datelog = date('Y/m/d', strtotime("+1 day", strtotime($datelog)))." ".$_GET['search_pickup_time'].":00";

$a = $a +1;

// echo "<br><br>1883) datelog bawah: ".$datelog;
// echo "<br><br>1872) a: ".$a;
}

echo '<script> alert("Successfully booking!")</script>'; 

vali_redirect("mail.php?booking_id=" . $booking_id); 
} 


$sqlDis = "SELECT * FROM discount WHERE code='$coupon'";

db_select($sqlDis);

if (db_rowcount() > 0) {

func_setSelectVar();
}   

$sql = "SELECT * FROM customer WHERE nric_no='$nric_no'";

db_select($sql);

if (db_rowcount() > 0) {

func_setSelectVar();
}   




?>

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
<h3>Counter Reservation View</h3>
</div>
</div>
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>NRIC No</h2>
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
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="number" class="form-control" placeholder="NRIC No" name="nric_no" value="<?php echo $_GET['nric_no']; ?>" readonly>
<br><br>
</div>
<div class="col-md-1 col-sm-1 col-xs-1">
<abbr title='Please ensure the NRIC No is correct'><i class="fa fa-info-circle"></i></abbr>
</div>
</div>
</form>
<div class="ln_solid"></div>
</div>
</div>
</div>
<div class="x_panel">
<div class="x_title">
<h2>Coupon</h2>
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
<form id="demo-form1" name="demo-form1" data-parsley-validate class="form-horizontal form-label-left" method="POST">
<div class="container">
<div class="">
<div class='col-sm-4'>
Base Rate
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input class="form-control" value="<?php echo dateDifference($pickup_date . $search_pickup_time, $return_date . $search_return_time, '%a Day %h Hours'); ?>" disabled>
</div>
</div>
</div>
<div class='col-sm-4'>
Discount (MYR)
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input class="form-control" type="text" value="<?php echo $Discount; ?>" name="discount" id="discount" disabled>
</div>
</div>
</div>
<div class='col-sm-4'>
Sub Total (MYR)
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input class="form-control" type="text" value="<?php echo number_format($subtotal,2);?>" id="subtotal" disabled>
</div>
</div>
</div>
<?php
if($pickup_cost != '')
{
?>
<div class='col-sm-4'>
Pickup Cost (MYR)
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input class="form-control" type="number" value="<?php echo $pickup_cost; ?>" name="pickup_cost" disabled>
</div>
</div>
</div>
<?php
}

else if($delivery_cost != '')
{

?>
<div class='col-sm-4'>
Delivery Cost (MYR)
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<?php echo $pickup_cost; ?>
<input class="form-control" type="number" value="<?php echo $delivery_cost; ?>" name="delivery_cost" disabled>

</div>
</div>
</div>
<?php
} 
?>
<div class='col-sm-4'>
Grand Total (MYR)
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input class="form-control" type="text" value="<?php echo number_format($est_total,2); ?>" name="est_total" disabled>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3">
<div class="table-responsive">
<table class="table">
<thead>
<?php
$sql = "SELECT description, amount, taxable FROM option_rental"; 

db_select($sql); 

if (db_rowcount() > 0) { 

for ($i = 0; $i < db_rowcount(); $i++) { 

echo "<tr>
<td>
<input type='checkbox' value='Y' " . vali_iif('Y' == $description[$i], 'Checked', '') . " name='description[$i].' onclick='calcPrice(document.getElementById(\"subtotal\").value,\"" . db_get($i, 0) . "\",document.getElementById(\"qty[$i]\").value,\"" . db_rowcount() . "\")' id='description[$i]'>
</td>
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
</tr>";
} 
}
?>
<tr>
<td>
<input type="checkbox" value='Y' <?php echo vali_iif('Y' == $cdw, 'Checked', ''); ?> name="cdw">
</td>
<td>C.D.W</td>
<td colspan="2">13.00 % Per Day</td>
</tr>
</thead>
</table>
</div>
</div>
</div>
<br>
<div class="">
<div class='col-sm-4'>
Pickup Location
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<?php
$sql = "SELECT id, description from location WHERE id=" . $_GET['search_pickup_location'];

db_select($sql);

if (db_rowcount() > 0) {

$pickup_location = db_get(0, 1);
}
?>
<input class="form-control" value="<?php echo $pickup_location; ?>" disabled>
</div>
</div>
</div>
<div class='col-sm-4'>
Return Location
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<?php
$sql = "SELECT id, description from location WHERE id=" . $_GET['search_return_location']; db_select($sql);
if (db_rowcount() > 0) 
{
$return_location = db_get(0, 1);
}
?>
<input class="form-control" value="<?php echo $return_location; ?>" disabled>
</div>
</div>
</div>
<div class='col-sm-4'>
Pickup Date & Time
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input class="form-control" value="<?php echo date('d/m/Y', strtotime($_GET['search_pickup_date'])) . " - " . $_GET['search_pickup_time']; ?>" disabled>
</div>
</div>
</div>
<div class='col-sm-4'>
Return Date & Time
<?php
if($exceed == "true")
{
echo '<abbr title="'.$note.'"><i class="fa fa-info-circle" style="color:red"></i></abbr>';
}

if($extend == "true")
{
echo '<abbr title="'.$note.'"><i class="fa fa-info-circle" style="color:green"></i></abbr>';
}
?>
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<?php
if (($day >= $how_many_day_min) && ($day <= $how_many_day_max)) 
{ 
?>
<input class="form-control" value="<?php echo date('d/m/Y', strtotime($_GET['search_return_date'])) . " - " . $return_time . " -> " . date('d/m/Y', strtotime($search_return_dates)) . " - " . date('H:i', strtotime($search_return_dates)); ?>" disabled>
<?php
} else {
?>
<input class="form-control" value="<?php echo date('d/m/Y', strtotime($search_return_dates)) . " - " . date('H:i', strtotime($search_return_dates)); ?>" disabled>
<?php 
}
?>
</div>
</div>
</div>
<div class='col-sm-4'>
Coupon Code
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input type="text" class="form-control" name="coupon" value="<?php echo $coupon; ?>">
</div>
</div>
</div>
<div class='col-sm-4'>
Agent Code
<div class="form-group">
<div class='input-group date col-md-12 col-sm-6 col-xs-12' >
<input type="text" class="form-control" name="agent" value="<?php echo $agent; ?>">
</div>
</div>
</div>
</div>
</div>
<div class="ln_solid"></div>
<div class="form-group" style="text-align: center;">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<button type="submit" class="btn btn-success"  name="btn_redeem" formnovalidate>Submit Discount</button>
</div>
</div>
</form>
</div>
</div>
<div class="x_panel">
<form id="demo-form2" name="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">
<input type="hidden" class="form-control" name="discount" value="<?php echo $Discount; ?>"><br>
<input class="form-control" type="hidden" value="<?php echo $est_total; ?>" name="est_total"><br>
<input class="form-control" type="hidden" value="<?php echo $subtotal;?>" name="subtotal" id="subtotal">
<div class="x_title">
<h2>Customer Information</h2>
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

<div class="form-group">
<div class="col-md-9 col-sm-9 col-xs-12">
<div class="radio">
<label>
<input  type="radio" value="pickup" class="flat" checked name="rtype" onclick="pickupFunction()"> Pickup
</label>
</div>
<div class="radio">
<label>
<input type="radio" class="flat" value="booking" name="rtype"  onclick="bookingFunction()"> Booking
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="NRIC No" name="nric_no" id="nric_no" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)" disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="title" class="form-control" id="title">
<option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
<option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
<option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>
</select>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" value="<?php echo $firstname; ?>" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" value="<?php echo $lastname; ?>" id="lastname" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Driver's Age</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Age" name="age" value="<?php echo $age; ?>" id="age" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_no">Phone No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Phone No" name="phone_no" value="<?php echo $phone_no; ?>" id="phone_no" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" id="email" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_no">License Number</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" id="license_no" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_exp">License Expired</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" class="form-control" placeholder="License Expired" name="license_exp" value="<?php echo $license_exp; ?>" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $address; ?>" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postcode">Postcode</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="number" class="form-control" placeholder=" Postcode" name="postcode" value="<?php echo $postcode; ?>" id="postcode" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">State</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="city" class="form-control" id="city" required>
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

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select ui-jq="chosen" name="country" class="form-control" id="country" required>
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
<option value="MT">Montana</option>
<option value="NE">Nebraska</option>
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
<option value="NH">New Hampshire</option>
<option value="NJ">New Jersey</option>
<option value="NY">New York</option>
<option value="NC">North Carolina</option>
<option value="OH">Ohio</option>
<option value="PA">Pennsylvania</option>
<option value="RI">Rhode Island</option>
<option value="SC">South Carolina</option>
<option value="VT">Vermont</option>
<option value="VA">Virginia</option>
<option value="WV">West Virginia</option>
</optgroup>

</select>
</div>
</div>
<div class="ln_solid"></div>
</div>
</div>
</div>

<div class="x_panel">
<div class="x_title">
<h2>Additional Driver Information</h2>
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

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_name">Name</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Name" name="drv_name" value="<?php echo $drv_name; ?>" id="drv_name">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_nric">NRIC No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="IC No. / Passport" name="drv_nric" value="<?php echo $drv_nric; ?>" id="drv_nric">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_address">Address</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" placeholder="Address" name="drv_address" value="<?php echo $drv_address; ?>" id="drv_address">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_phoneno">Phone No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno" value="<?php echo $drv_phoneno; ?>" id="drv_phoneno">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_no">License No.</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" type="text" placeholder="License No." name="drv_license_no" id="drv_license_no" value="<?php echo $drv_license_no; ?>">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_exp">License Expired</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" class="form-control" name="drv_license_exp" value="<?php echo $drv_license_exp; ?>" placeholder="License Expired">
<!-- <input type="text" class="form-control" name="drv_license_exp" id="single_cal2" placeholder="License Expired"> -->
</div>
</div>

<div class="ln_solid"></div>
</div>
</div>
</div>


<div class="x_panel">
<div class="x_title">
<h2>Reference Information</h2>
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

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Name</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Reference Name" name="ref_name" value="<?php echo $ref_name; ?>" id="ref_name" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Relationship</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Reference Relationship" name="ref_relationship" value="<?php echo $ref_relationship; ?>" id="ref_relationship" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Address</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" placeholder="Reference Address" name="ref_address" id="ref_address" value="<?php echo $ref_address; ?>" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Phone No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Reference Phone No" name="ref_phoneno" value="<?php echo $ref_phoneno; ?>" id="ref_phoneno" required>
</div>
</div>

<div class="ln_solid"></div>

</div>
</div>
</div>



<div class="x_panel">

<div class="x_title">
<h2>Payment Information</h2>
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

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_amount">Payment Amount (MYR)</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Payment Amount" name="payment_amount" value="<?php echo $payment_amount; ?>" id="payment_amount" required>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_details">Payment Status</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="payment_details" id="payment_details" class="form-control" required>
<option value="">Please Select</option>
<option <?php echo vali_iif('Collect' == $payment_details, 'Selected', ''); ?> value='Collect'>Collect</option>
<option <?php echo vali_iif('Cash' == $payment_details, 'Selected', ''); ?> value='Cash'>Cash</option>
<option <?php echo vali_iif('Online' == $payment_details, 'Selected', ''); ?> value='Online'>Online</option>
<option <?php echo vali_iif('Card' == $payment_details, 'Selected', ''); ?> value='Card'>Card</option>
<option <?php echo vali_iif('Nil' == $payment_details, 'Selected', ''); ?> value='Nil'>Nil</option>
<option <?php echo vali_iif('Return' == $payment_details, 'Selected', ''); ?> value='Return'>Return</option>
<option <?php echo vali_iif('Closing' == $payment_details, 'Selected', ''); ?> value='Closing'>Closing</option>
</select>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="deposit">Deposit (MYR)</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="deposit" id="deposit" class="form-control" required>
<option value="">Please Select</option>
<option <?php echo vali_iif('50' == $deposit, 'Selected', ''); ?> value='50'>RM50</option>
<option <?php echo vali_iif('100' == $deposit, 'Selected', ''); ?> value='100' selected>RM100</option>
<option <?php echo vali_iif('200' == $deposit, 'Selected', ''); ?> value='200'>RM200</option>
<option <?php echo vali_iif('300' == $deposit, 'Selected', ''); ?> value='300'>RM300</option>
<option <?php echo vali_iif('400' == $deposit, 'Selected', ''); ?> value='400'>RM400</option>
<option <?php echo vali_iif('500' == $deposit, 'Selected', ''); ?> value='500'>RM500</option>
<option <?php echo vali_iif('600' == $deposit, 'Selected', ''); ?> value='600'>RM600</option>
</select>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deposit Status</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="refund_dep_payment" id="refund_dep_payment" class="form-control" required>
<option value="" disabled>Please Select</option>
<option <?php echo vali_iif('Nil' == $refund_dep_payment, 'Selected', ''); ?> value='Nil'>Online</option>
<option <?php echo vali_iif('Cash' == $refund_dep_payment, 'Selected', ''); ?> value='Cash'>Cash</option>
<option <?php echo vali_iif('Online' == $refund_dep_payment, 'Selected', ''); ?> value='Online'>Online</option>
</select>
</div>
</div>

<div class="ln_solid"></div>

</div>
</div>
</div>


<div class="x_panel">
<div class="x_title">
<h2>Survey</h2>
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
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Survey</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="survey_type" id="survey_type" class="form-control" id="survey" onchange="change();" required>
<option <?php echo vali_iif('Banner' == $survey_type, 'Selected', ''); ?> value='Banner'>Banner</option>
<option <?php echo vali_iif('Bunting' == $survey_type, 'Selected', ''); ?> value='Bunting'>Bunting</option>
<option <?php echo vali_iif('Facebook Ads' == $survey_type, 'Selected', ''); ?> value='Freinds'>Facebook Ads</option>
<option <?php echo vali_iif('Friends' == $survey_type, 'Selected', ''); ?> value='Friends'>Friends</option>
<option <?php echo vali_iif('Google Ads' == $survey_type, 'Selected', ''); ?> value='Google Ads'>Google Ads</option>
<option <?php echo vali_iif('Magazine' == $survey_type, 'Selected', ''); ?> value='Magazine'>Magazine</option>
<option <?php echo vali_iif('Others' == $survey_type, 'Selected', ''); ?> value='Others'>Others</option>
</select>
</div>
</div>
<div class="ln_solid"></div>

<div class="form-group" style="text-align: center;">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<button type="submit" name="btn_save" class="btn btn-success">Submit</button>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /page content -->

<?php include('_footer.php') ?>

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


function bookingFunction() {

document.getElementById("drv_name").disabled = true;
document.getElementById("drv_nric").disabled = true;
document.getElementById("drv_address").disabled = true;
document.getElementById("drv_phoneno").disabled = true;
document.getElementById("drv_license_no").disabled = true;
document.getElementById("drv_license_exp").disabled = true;
document.getElementById("ref_name").disabled = true;
document.getElementById("ref_relationship").disabled = true;
document.getElementById("ref_address").disabled = true;
document.getElementById("ref_phoneno").disabled = true;
document.getElementById("payment_amount").disabled = true;
document.getElementById("payment_details").disabled = true;
document.getElementById("deposit").disabled = true;
document.getElementById("refund_dep_payment").disabled = true;
document.getElementById("survey_type").disabled = true;



}

function pickupFunction(){

document.getElementById("drv_name").disabled = false;
document.getElementById("drv_nric").disabled = false;
document.getElementById("drv_address").disabled = false;
document.getElementById("drv_phoneno").disabled = false;
document.getElementById("drv_license_no").disabled = false;
document.getElementById("drv_license_exp").disabled = false;
document.getElementById("ref_name").disabled = false;
document.getElementById("ref_relationship").disabled = false;
document.getElementById("ref_address").disabled = false;
document.getElementById("ref_phoneno").disabled = false;
document.getElementById("payment_amount").disabled = false;
document.getElementById("payment_details").disabled = false;
document.getElementById("deposit").disabled = false;
document.getElementById("refund_dep_payment").disabled = false;
document.getElementById("survey_type").disabled = false;


}

</script>


</div>
</div>

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