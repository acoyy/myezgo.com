<?php 

$vehicle_id = $_GET['vehicle_id'];

$sql = "SELECT 
id AS vehicle_id1,
reg_no AS reg_no1,
CONCAT(make, ' ', model) AS car1
FROM vehicle
WHERE availability = 'Available' OR availability = 'Out' OR id = '$vehicle_id'
";
require_once('db/db_connect.php');

//$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
$r = mysqli_query($con,$sql);
$result = array();
while($row = mysqli_fetch_array($r)){
 array_push($result,array(
'car1'=>$row['car1'],
'reg_no1'=>$row['reg_no1'],
'id'=>$row['vehicle_id1']
    ));
}
echo json_encode(array('result'=>$result));
mysqli_close($con);?>