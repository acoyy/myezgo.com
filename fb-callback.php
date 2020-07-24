<?php

	require_once "fb-config.php";

	try{

		$accessToken = $helper->getAccessToken();
		
		echo "<script> alert($accessToken); </script>";
		
	} catch(\Facebook\Exceptions\FacebookResponseException $e){

		echo "Response Exception: ". $e->getMessage();
		
		echo "<script> alert($e->getMessage()); </script>";
		exit();

	} catch(\Facebook\Exceptions\FacebookSDKException $e){

		echo "SDK Exception: ". $e->getMessage();
		echo "<script> alert($e->getMessage()); </script>";
		exit();

	}

	if(!$accessToken){
    
        echo "<script> alert('No token'); </script>";
		header('Location: login.php');
		exit();

	}

	$oAuth2Client = $FB->getOAuth2Client();

	if(!$accessToken->isLongLived()){

		$accessToken = $oAuth2Client->getLongLivedAccessToken();
		echo "<script> alert($accessToken); </script>";

	}

	$response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	

	/* Check if the data has passed */
	echo "<pre>";
	var_dump($userData);

	$_SESSION['userData']= $userData;
	$_SESSION['access_token']= $userData;
	header('Location: register_customer_fb.php');
	exit();


?>