<?php

// require 'vendor/autoload.php';
$api = '421a747c-6344-463f-aceb-2926767d6a94';
$bill = 'o40fq4dv';
// $billplz = Billplz\Client::make($api);
// $response = $billplz->bill()->transaction($bill);
// var_dump($response->getStatusCode(), $response->toArray());

// require 'vendor/autoload.php';
// // $api = 'xxx';
// $billplz = Billplz\Client::make($api);
// $bank = $billplz->bank();
// $response = $bank->supportedForFpx();
// var_dump($response->getStatusCode(), $response->toArray());


require '../vendor/autoload.php';
// $api = 'xxx';
// $bill = '6fj1aw';
$billplz = Billplz\Client::make($api);
$response = $billplz->bill()->get($bill);
var_dump($response->getStatusCode(), $response->toArray());

$huhu = $response->getContent();



$id = $huhu['id'];
$url = $huhu['url'];
$collection_id = $huhu['collection_id'];
$paid = $huhu['paid'];
$state = $huhu['state'];
$amount = $huhu['amount'];
$paid_amount = $huhu['paid_amount'];
$due_at = $huhu['due_at'];
$email = $huhu['email'];
$mobile = $huhu['mobile'];
$name = $huhu['name'];
$reference_1_label = $huhu['reference_1_label'];
$reference_1 = $huhu['reference_1'];
$reference_2_label = $huhu['reference_2_label'];
$reference_2 = $huhu['reference_2'];
$redirect_url = $huhu['redirect_url'];
$callback_url = $huhu['callback_url'];
$description = $huhu['description'];
$paid_at = $huhu['paid_at'];
echo "<br><br>";
echo "<br>id: ".$id;
echo "<br>url: ".$url;
echo "<br>collection_id: ".$collection_id;
echo "<br>paid: ".$paid;
echo "<br>state: ".$state;
echo "<br>amount: ".$amount;
echo "<br>paid_amount: ".$paid_amount;
echo "<br>due_at: ".$due_at;
echo "<br>email: ".$email;
echo "<br>mobile: ".$mobile;
echo "<br>name: ".$name;
echo "<br>reference_1_label: ".$reference_1_label;
echo "<br>reference_1: ".$reference_1;
echo "<br>reference_2_label: ".$reference_2_label;
echo "<br>reference_2: ".$reference_2;
echo "<br>redirect_url: ".$redirect_url;
echo "<br>callback_url: ".$callback_url;
echo "<br>description: ".$description;
echo "<br>paid_at: ".$paid_at;

echo "<script>
	window.open('$url','_blank');
	</script>";
?>