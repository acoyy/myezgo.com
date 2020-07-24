<?php
$inputJSON = file_get_contents('vehicle.json');
$input = json_decode($inputJSON, true); 

$someJSON = '[{"name":"Jonathan Suh","gender":"male"},{"name":"William Philbin","gender":"male"},{"name":"Allison McKinnery","gender":"female"}]';

  // Convert JSON string to Array
  $someArray = json_decode($someJSON, true);

  

  echo $someJSON;


echo $inputJSON;
echo $someArray[0]["name"];
echo $input[0]["pickupDateTime"];

?>