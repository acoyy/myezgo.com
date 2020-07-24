<?php 

$sql = "SELECT id, class_name from class"; 
                              

require_once('db/db_connect.php');

//$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
$r = mysqli_query($con,$sql);
$result = array();
while($row = mysqli_fetch_array($r)){
 array_push($result,array(
'car1'=>$row['class_name'],
'id'=>$row['id']
    ));
}
echo json_encode(array('result'=>$result));
mysqli_close($con);?>