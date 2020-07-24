<?php

session_start();

require_once "Facebook/autoload.php";

$FB = new \Facebook\Facebook([
	'app_id' => '575081149569870',
	'app_secret' => '07d6ca9bc78efa3636feb18f6b670f98',
	'default_graph version' => 'v2.10'
	]);

$helper = $FB->getRedirectLoginHelper();




?>
