<?php

require_once "google-config.php";

require("dashboard/lib/setup.php");

// Start session
if(!session_id()){
    session_start();
}


if(isset($_GET['access_token'])){

$gClient->setAccessToken($_SESSION['access_token']);

}

else if(isset($_GET['code'])){

	$token = $gClient-> fetchAccessTokenWithAuthCode($_GET['code']);
	$_SESSION['access_token'] = $token;

}

else {

	header('Location: login.php');
	exit();

}

$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();

$sql = "SELECT * FROM customer WHERE email='".$userData['email']."'";
db_select($sql);

if (db_rowcount() > 0) {
	func_setSelectVar();
}

$_SESSION['id'] = $userData['id'];
$_SESSION['email'] = $userData['email'];
$_SESSION['gender'] = $userData['gender'];
$_SESSION['picture'] = $userData['picture'];
$_SESSION['familyName'] = $userData['familyName'];
$_SESSION['givenName'] = $userData['givenName'];

header('Location: register_customer_google.php');
exit();

?>