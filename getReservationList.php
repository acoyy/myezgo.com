<?php 
 
	//Getting the page number which is to be displayed  
	$page = $_GET['page'];	

	$search = $_GET['search'];

	$agreement_search = "";
    $reg_no_search = "";

	if($search != ""){

		$agreement_search = " AND agreement_no like '%" . $search . "%'"; 
        $reg_no_search = " OR reg_no like '%" . $search . "%'"; 

	}
	
	
	//Initially we show the data from 1st row that means the 0th row 
	$start = 0; 
	
	//Limit is 3 that means we will show 3 items at once
	$limit = 10; 
	
	//Importing the database connection 
	require_once('db/db_connect.php');
 
	//Counting the total item available in the database 

	// $sql = "SELECT id from feed ";

	$sql = "SELECT id from booking_trans ";

	$total = mysqli_num_rows(mysqli_query($con, $sql));
	
	//We can go atmost to page number total/limit
	$page_limit = ceil($total/$limit); 
	
	//If the page number is more than the limit we cannot show anything 
	if($page<=$page_limit){
		
		//Calculating start for every given page number 
		$start = ($page - 1) * $limit; 
		
		//SQL query to fetch data of a range 

		$sql = "SELECT
			booking_trans.id,
			class_id,
			firstname,
			lastname,
			nric_no,
			reg_no,
			DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_date,
			DATE_FORMAT(pickup_time, '%H:%i:%s') as pickup_time,
			DATE_FORMAT(return_date, '%d/%m/%Y') as return_date,
			DATE_FORMAT(return_time, '%H:%i:%s') as return_time,
			DATE_FORMAT(created, '%d/%m/%Y') as created,
			vehicle.id AS vehicle_id,
			agreement_no,
			booking_trans.branch AS branch,
			booking_trans.available,
			booking_trans.delete_status
			FROM vehicle
			LEFT JOIN booking_trans ON vehicle.id = vehicle_id
			LEFT JOIN class ON class.id = class_id
			LEFT JOIN customer ON customer.id = customer_id
			WHERE booking_trans.id IS NOT NULL". $agreement_search . $reg_no_search ."
			ORDER BY YEAR(created) DESC, MONTH(created) DESC, DAY(created) DESC, HOUR(created) DESC, MINUTE(created) DESC, SECOND(created) DESC
			limit $start, $limit";

		// $sql = "SELECT * from booking_trans limit $start, $limit";

		// 15
 
		//Getting result 
		$result = mysqli_query($con,$sql); 
		
		//Adding results to an array 
		$res = array(); 
		$no=($page-1)*10;
 
		while($row = mysqli_fetch_array($result)){
			
			$no= $no+1;
			array_push($res, array(
				"no"=>$no,
				"id"=>$row['id'],
				"publisher"=>$row['agreement_no'],
				"vehicle_plate_no"=>$row['reg_no'],
				"branch"=>$row['branch'],
				"available"=>$row['available'],
				"pickup_date"=>$row['pickup_date'],
				"pickup_time"=>$row['pickup_time'],
				"return_date"=>$row['return_date'],
				"return_time"=>$row['return_time'],
				"delete_status"=>$row['delete_status']
				)
				);
		}

		
		//Displaying the array in json format 
		echo json_encode($res);
	}else{
            echo "over";
    }

    ?>