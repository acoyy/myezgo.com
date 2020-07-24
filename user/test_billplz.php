<?php

if (!session_id()) {
    session_start();
}

require '../vendor/autoload.php';
$api = '421a747c-6344-463f-aceb-2926767d6a94';

$collection = '9khp14er';
$billplz = Billplz\Client::make($api);
$response = $billplz->bill()->create(
    $collection,
    'acoydip3a@gmail.com',
    null,
    'Amir',
    100,
    'myezgo.com',
    'Test first bill'
);


$huhu = var_dump($response->getStatusCode(), $response->toArray());

$huhu = $response->getContent();

$id = $huhu['id'];
$url = $huhu['url'];
$collection = $huhu['collection'];
$status = $huhu['status'];
$status = $huhu['status'];
// $huhu = json_decode($huhu);
// $huhu = var_dump($response->getDecodedBody());

// $result = json_decode($huhu);

// $hehe = get_object_vars($huhu);

// header("Location:".$url);

// echo "<br><br>huhu id: ".$huhu['id'];
// echo "<br><br>huhu id: ".$huhu[0]['id'];
// echo "<br><br>huhu id: ".$result;