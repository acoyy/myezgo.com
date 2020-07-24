<?php

session_start();
require_once "GoogleAPI/vendor/autoload.php";

$gClient = new Google_Client();
$gClient->setClientId("451226004356-mi7i7epm4sbdaltd13f2n5b20eld49f0.apps.googleusercontent.com");
$gClient->setClientSecret("8mFEakOmLuemBoA3SmiSNvW4");
$gClient->setApplicationName("Myezgo Login Tutorial");
$gClient->setRedirectUri("https://myezgo.com/google-callback.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");


?>