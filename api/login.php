<?php
$response = array();
include 'db/db_connect.php';
include 'functions.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if(isset($input['username']) && isset($input['password'])){
	$username = $input['username'];
	$password = $input['password'];
	$query    = "SELECT id, name, password, occupation, branch FROM user WHERE username = ?";


	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->bind_result($id, $fullName, $passwordDB, $occupation, $branch);
		if($stmt->fetch()){
			//Validate the password
			if($password==$passwordDB){
				$response["status"] = 0;
				$response["message"] = "Login successful";
				$response["full_name"] = $fullName;
				$response["id"] = $id;
				$response["occupation"] = $occupation;
				$response["branch"] = $branch;
			}
			else{
				$response["status"] = 1;
				$response["message"] = "Invalid username and password combination 1";
			}
		}
		else{
			$response["status"] = 1;
			$response["message"] = "Invalid username and password combination 2";
		}
		
		$stmt->close();
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}
//Display the JSON response
echo json_encode($response);
?>