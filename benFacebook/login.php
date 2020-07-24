<?php
// Pass session data over. Only needed if not already passed by another script like WordPress.
if(!session_id()) {
    session_start();
}

// Include the required dependencies.
require_once( 'vendor/autoload.php' );

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '595173427607571',
  'app_secret'            => 'cd166a2bd90df0f43f4222e473794d21',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://myezgo.com/benFacebook/fb-callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

echo '<br>';

echo 'Current PHP version: ' . phpversion();

echo '<br>';

phpinfo();