<?php
// 	session_start();

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '165152870790791',
		'app_secret' => '1f3c03130bce269334c045a6c7fe00f1',
		'default_graph_version' => 'v3.1'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>