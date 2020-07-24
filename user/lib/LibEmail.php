<?php
function mail_noattachment($mailto, $from_mail, $from_name, $replyto, $subject, $message) {
	try {
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = MAIL_PORT;                    // set the SMTP server port
		$mail->Host       = MAIL_SERVER; // SMTP server
		$mail->Username   = MAIL_USERNAME;     // SMTP server username
		$mail->Password   = MAIL_PASSWORD;            // SMTP server password

		//$mail->IsSendmail();  // tell the class to use Sendmail

		$mail->AddReplyTo($replyto,$from_name);

		$mail->From       = $from_mail;
		$mail->FromName   = $from_name;

		$to = $mailto;

		$mail->AddAddress($to);

		$mail->Subject  = $subject;

		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->WordWrap   = 80; // set word wrap

		$mail->MsgHTML($message);

		$mail->IsHTML(true); // send as HTML

		$mail->Send();
		//echo "mail send ... OK - " . $mailto . "<br>";
		//$rs = "<script>alert('mail send ... OK - " . $mailto . "')</script><br>";
		$result = "S";
		$result_msg = "mail send ... OK";
	} catch (phpmailerException $e) {
		//echo "mail send ... ERROR! - " . $mailto . "<br>";
		//echo $e->errorMessage() . "<br>";
		//$rs = "mail send ... ERROR! - " . $mailto . " - " . $e->errorMessage() . "<br>";
		$result = "F";
		$result_msg = $e->errorMessage();
	}
	echo $rs; 
	email_log($mailto, $subject, $message, $result, $result_msg);
	return $result . "|" . $result_msg;
}

function mail_nohtml($mailto, $from_mail, $from_name, $replyto, $subject, $message) {
	try {
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		//$mail->Port       = 465;                    // set the SMTP server port
		$mail->Host       = MAIL_SERVER; // SMTP server
		$mail->Username   = MAIL_USERNAME;     // SMTP server username
		$mail->Password   = MAIL_PASSWORD;            // SMTP server password

		//$mail->IsSendmail();  // tell the class to use Sendmail

		$mail->AddReplyTo($replyto,$from_name);

		$mail->From       = $from_mail;
		$mail->FromName   = $from_name;

		$to = $mailto;

		$mail->AddAddress($to);

		$mail->Subject  = $subject;

		$mail->Body = $message;

		$mail->IsHTML(false); // send as HTML

		$mail->Send();
		//echo "mail send ... OK - " . $mailto . "<br>";
		$rs = "mail send ... OK - " . $mailto . "<br>";
		$result = "S";
		$result_msg = "mail send ... OK";
	} catch (phpmailerException $e) {
		//echo "mail send ... ERROR! - " . $mailto . "<br>";
		//echo $e->errorMessage() . "<br>";
		$rs = "mail send ... ERROR! - " . $mailto . " - " . $e->errorMessage() . "<br>";
		$result = "F";
		$result_msg = $e->errorMessage();
	}
	email_log($mailto, $subject, $message, $result, $result_msg);
	echo $rs; 
	email_log($mailto, $subject, $message, $result, $result_msg);
	return $result . "|" . $result_msg;
}
	
function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
	try {
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
		$mail->IsSMTP();                           // tell the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		//$mail->Port       = 465;                    // set the SMTP server port
		$mail->Host       = MAIL_SERVER; // SMTP server
		$mail->Username   = MAIL_USERNAME;     // SMTP server username
		$mail->Password   = MAIL_PASSWORD;            // SMTP server password

		//$mail->IsSendmail();  // tell the class to use Sendmail

		$mail->AddReplyTo($replyto,$from_name);

		$mail->From       = $from_mail;
		$mail->FromName   = $from_name;
		$mail->AddAttachment($path . $filename);

		$to = $mailto;

		$mail->AddAddress($to);

		$mail->Subject  = $subject;

		$mail->Body = $message;

		$mail->IsHTML(false); // send as HTML

		$mail->Send();
		echo "mail send ... OK - " . $mailto . "|";
	} catch (phpmailerException $e) {
		echo "mail send ... ERROR! - " . $mailto;
		echo $e->errorMessage() . "|";
	}
}

function mail_memberregistration($mem_id) {
	db_select("SELECT sysno,mem_username,mem_email,mem_name FROM m_member WHERE mem_id=" . $mem_id);
	$subject = "Auruma International Registration Details";
	$message = 'Dear ' . db_get(0,3) . ',

Thank you for your registration.  The following are your User ID and Password.

User ID : ' . db_get(0,1) . ' (customer User ID)
Password : auruma (customer Password)

We look forward to your participation in the Auruma program to create, to preserve and to prosper your wealth.

Constituo, Conservo et Cresco

Best Regards
Auruma International Limited';
	mail_nohtml(db_get(0,2),"admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("jm@microtech2u.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	//mail_nohtml("rebeccalee@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("carmen@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
}

function mail_memberregistrationresend($mem_id) {
	db_select("SELECT sysno,mem_username,mem_email,mem_name FROM m_member WHERE mem_id=" . $mem_id);
	$subject = "RESEND : Auruma International Registration Details";
	$message = 'Dear ' . db_get(0,3) . ',

Thank you for your registration.  The following are your User ID and Password.

User ID : ' . db_get(0,1) . ' (customer User ID)
Password : auruma (customer Password)

We look forward to your participation in the Auruma program to create, to preserve and to prosper your wealth.

Constituo, Conservo et Cresco

Best Regards
Auruma International Limited';
	mail_nohtml(db_get(0,2),"admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("jm@microtech2u.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	//mail_nohtml("rebeccalee@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("carmen@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
}

function mail_abc($mem_id) {
	db_select("SELECT sysno,mem_username,mem_email,mem_name FROM m_member WHERE mem_id=" . $mem_id);
	$subject = "Thank you for your purchase of the Auruma Business Centre (ABC)";
	$message = "Dear Auruma Member

Thank you for your purchase of the Auruma Business Centre (ABC).  You are now able to access the various features and marketing tools when you next log-in to your account via http://www.aurumainternational.com

Your Unique Page url is - http://www.aurumainternational.com/abc/" . db_get(0,1) . "/  

This is your personal webpage which you can share information on spreading the Auruma International's message of a wealth creation and preservation program with family and friends globally.  They will be able to register for a username and password to view the products we have to offer at the Auruma Retail Store.  All customers registered under your unique page will be placed under your account.  

We look forward to a mutually beneficial long term relationship with you.

Best Regards
AURUMA International Limited

Constituo, conservo et cresco
To create, to preserve and to prosper";
	mail_nohtml(db_get(0,2),"admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("jm@microtech2u.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	//mail_nohtml("rebeccalee@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("carmen@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
}

function mail_invitation($mem_id,$fname,$femail) {
	db_select("SELECT mem_username,mem_name FROM m_member WHERE mem_id=" . $mem_id);
	$subject = "Message for Tell-A Friend";
	$message = 'Dear ' . $fname . ',

I have discovered an innovative business program that helps individuals and their families around the world to create, preserve and to ultimately prosper their wealth.
Visit http://www.aurumainternational.com/abc/' . db_get(0,0) . '/ to find out more.

Thanks

' . db_get(0,1) . '
';
	mail_nohtml($femail,"admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("jm@microtech2u.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	//mail_nohtml("rebeccalee@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
	mail_nohtml("carmen@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
}

function mail_249($mem_id) {
	db_select("SELECT sysno,mem_username,mem_email,mem_name FROM m_member WHERE mem_id=" . $mem_id);
	$subject = "RESEND:AURUMA INTERNATIONAL";
//
	$message = "Dear Auruma Members

Thank you for your pre-launch registration.  Auruma International is now officially launched.

Kindly execute the following steps :
1) Update your details via the log-in at www.aurumainternational.com/  for the official registration. 
2) Purchase your Auruma Business Centre, Silver Accumulation Program and or Gold Accumulation Program via the Auruma Retail Store.

Your log-in details are as follows :
Username  : " . db_get(0,1) . "
Temporary Password : auruma

We are pleased to offer a limited edition, highly collectible 2010 2oz Lunar Tiger silver coin as the introductory silver product under the Silver Accumulation Program.  As our privileged member, we are also offering the Auruma Business Centre (ABC) to you at a one-time special price of USD249.00.  Our ABC is currently priced at USD 299.00 and the rebate of USD 50.00 will be credited to you via your Ezyaccount.  Please confirm your purchase within 3 working days of the receipt of this email to enjoy this one-time special price for the Auruma Business Centre (ABC).

Attached is an article on why we should consider buying silver, for your reading pleasure.

---------------------------------------------------

We look forward to a mutually beneficial long term relationship with you.

Constituo, conservo et cresco
To create, to preserve and to prosper

Best Regards
Auruma International Limited

Kindly take note of the following -
If you intend to purchase more than one Auruma Business Centre (ABC), kindly register a separate individual name/registered business name.  All registration with the same registered name will be rejected.

For your first autoship under the Silver Accumulation Program or Gold Accumulation Program, please note that payment will be via credit card.  For the subsequent months, we will debit your Ezybond Ezyaccount.";
mail_attachment("WhySilver.pdf","/var/www/html/auruma/a2/",db_get(0,2),"admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
mail_attachment("WhySilver.pdf","/var/www/html/auruma/a2/","jm@microtech2u.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
mail_attachment("WhySilver.pdf","/var/www/html/auruma/a2/","carmen@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);

}

function mail_299($mem_id) {
	db_select("SELECT sysno,mem_username,mem_email,mem_name FROM m_member WHERE mem_id=" . $mem_id);
	$subject = "RESEND:AURUMA INTERNATIONAL";
//
	$message = "Dear Auruma Members

Thank you for your pre-launch registration.  Auruma International is now officially launched.

Kindly execute the following steps -
1) Update your details via this log in at www.aurumainternational.com/  for the official registration. 
2) Purchase your Auruma Business Centre, Silver Accumulation Program and or Gold Accumulation Program via the Auruma Retail Store.

Your log-in details are -
Username  : " . db_get(0,1) . "
Temporary Password : auruma

We are pleased to offer a limited edition, highly collectible 2010 2oz Lunar Tiger silver coin as the introductory silver product under the Silver Accumulation Program.

Attached is an article on why we should consider buying silver, for your reading pleasure.

---------------------------------------------------

We look forward to a mutually beneficial long term relationship with you.

Constituo, conservo et cresco
To create, to preserve and to prosper

Best Regards
Auruma International Limited

Kindly take note of the following -
If you intend to purchase more than one Auruma Business Centre (ABC), kindly register a separate individual name/registered business name.  All registration with the same registered name will be rejected.

For your first autoship under the Silver Accumulation Program or Gold Accumulation Program, please note that payment will be via credit card.  For the subsequent months, we will debit your Ezybond Ezyaccount.";
mail_attachment("WhySilver.pdf","/var/www/html/auruma/a2/",db_get(0,2),"admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
mail_attachment("WhySilver.pdf","/var/www/html/auruma/a2/","jm@microtech2u.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);
mail_attachment("WhySilver.pdf","/var/www/html/auruma/a2/","carmen@sgnet5021.com","admin@aurumainternational.com","AURUMA INTERNATIONAL","admin@aurumainternational.com",$subject,$message);

}

Function email_log($mailto, $subject, $message, $result, $result_msg){
	$sql = "INSERT INTO email_log SET 
			mail_to = '$mailto'
			,subject = '$subject'
			,email_content = '$message'
			,result = '$result'
			,result_msg = '$result_msg'";
	db_update($sql);
}
?>
