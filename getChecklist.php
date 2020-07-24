<?php

require_once('db/db_connect.php');

if($_SERVER['REQUEST_METHOD']=='POST'){

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
    
    $r = mysqli_query($con,$sql);
    $result = array();
    $no = 0;
        while($row = mysqli_fetch_array($r)){

            $no= $no + 1;
            array_push($result,array(

            'no'=>$no,
            'description'=>$row['description'],
            'calculation'=>$row['calculation'],
            'amount_type'=>$row['amount_type'],
            'amount'=>$row['amount'],
            'taxable'=>$row['taxable'],
            'pic'=>$row['pic'],
            'missing_cond'=>$row['missing_cond']

            ));
        }

    echo json_encode($result);
    mysqli_close($con);


}

?>