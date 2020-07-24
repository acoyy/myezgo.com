<!DOCTYPE html>
<html>
<head>
	<title>Visible (unset)</title>
	<meta http-equiv=content-type content="text/html; charset=UTF8">
</head>
<body>

<script>
	
// "librairie" de gestion de la visibilité
//  var visible = vis(); // donne l'état courant
//  vis(function(){});   // définit un handler pour les changements de visibilité
var vis = (function(){
	var stateKey, eventKey, keys = {
		hidden: "visibilitychange",
		webkitHidden: "webkitvisibilitychange",
		mozHidden: "mozvisibilitychange",
		msHidden: "msvisibilitychange"
	};
	for (stateKey in keys) {
		if (stateKey in document) {
			eventKey = keys[stateKey];
			break;
		}
	}
	return function(c) {
		if (c) {
			document.addEventListener(eventKey, c);
			//document.addEventListener("blur", c);
			//document.addEventListener("focus", c);
		}
		return !document[stateKey];
	}
})();

vis(function(){
	document.title = vis() ? location.reload() : 'Visible';
	console.log(new Date, 'visible ?', vis());
});

// to set the initial state
// document.title = vis() ? 'Visible' : 'Not visible';

</script>
</body>
</html>
<?php

	session_start();

	$idletime=$_SESSION['payment_sess_time'];//after 60 seconds the user gets logged out

	if (time()-$_SESSION['payment_timestamp']>$idletime){

		$waktu = time()-$_SESSION['payment_timestamp'];
		// session_unset();
		// session_destroy();
		echo "<script> alert('waktu = $waktu'); </script>";
		// echo "<script>
		// window.location.href='../';
		// </script>";

		echo "masuk sini 1";
	}else
	{

		$waktu = time()-$_SESSION['payment_timestamp'];
		
		// echo "<script> alert('waktu = $waktu'); </script>";
		$_SESSION['payment_timestamp']=time();
		
		$api = '421a747c-6344-463f-aceb-2926767d6a94';
		$bill = $_SESSION['bill_id'];
		// $bill = 'fksqwmro';

		// echo "<br>bill: ".$bill."<br>";

		require '../vendor/autoload.php';
		// $api = 'xxx';
		// $bill = '6fj1aw';
		$billplz = Billplz\Client::make($api);
		$response = $billplz->bill()->get($bill);
		var_dump($response->getStatusCode(), $response->toArray());

		$huhu = $response->getContent();

		$state = $huhu['state'];

		echo "<br>state: ".$state."<br>";

		if($state == 'paid')
		{
			echo "<script>
		    window.location.href='successful_payment.php';
		    </script>";
		}


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
		// echo "<br><br>";
		// echo "<br>id: ".$id;
		// echo "<br>url: ".$url;
		// echo "<br>collection_id: ".$collection_id;
		// echo "<br>paid: ".$paid;
		// echo "<br>state: ".$state;
		// echo "<br>amount: ".$amount;
		// echo "<br>paid_amount: ".$paid_amount;
		// echo "<br>due_at: ".$due_at;
		// echo "<br>email: ".$email;
		// echo "<br>mobile: ".$mobile;
		// echo "<br>name: ".$name;
		// echo "<br>reference_1_label: ".$reference_1_label;
		// echo "<br>reference_1: ".$reference_1;
		// echo "<br>reference_2_label: ".$reference_2_label;
		// echo "<br>reference_2: ".$reference_2;
		// echo "<br>redirect_url: ".$redirect_url;
		// echo "<br>callback_url: ".$callback_url;
		// echo "<br>description: ".$description;
		// echo "<br>paid_at: ".$paid_at;

		echo "<script>
			window.open('$url');
			</script>";
	}
	else {

		$api = '421a747c-6344-463f-aceb-2926767d6a94';
		$bill = $_SESSION['bill_id'];
		// $bill = 'fksqwmro';

		echo "<br>bill: ".$bill."<br>";

		require '../vendor/autoload.php';
		$billplz = Billplz\Client::make($api);
		$response = $billplz->bill()->get($bill);
		var_dump($response->getStatusCode(), $response->toArray());

		$huhu = $response->getContent();

		$state = $huhu['state'];

		echo "<br>state: ".$state."<br>";

		if($state == 'paid')
		{
			echo "<script>
		    window.location.href='successful_payment.php';
		    </script>";
		}
		else{


			echo "Please return to previous page to restart payment. ";
			echo "<a href='javascript:history.go(-1)'>Go back</a>";
		}
	}
?>
	</body>
</html>