<?php
//if "email" variable is filled out, send email

  $result = '';
  if (isset($_POST['submit']))  {
  
  require 'lib/phpmailer/PHPMailerAutoload.php';

  $mail = new PHPMailer;

  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tls';
  $mail->Username = 'nashrulamir79@gmail.com';
  $mail->Password = 'Nashrullah12';

  $mail->setFrom($_POST['email']);
  $mail->addAddress('acoydip3a@gmail.com');
  $mail->addReplyTo($_POST['email']);

  $mail->isHTML(true);
  $mail->Subject = 'Form Submission: '. $_POST['subject'];
  $mail->Body = '<br><br>Comment: ' . $_POST['comment']."<br>Email:" . $_POST['email'];

  if(!$mail->send())
  {
    $result = "<br><br>Something went wrong!";
  }
  else
  {
    $result = "<br><br>Successful!";
  }

  //Email information
  // $admin_email = "nashrulamir79@gmail.com";
  // $email = $_REQUEST['email'];
  // $subject = $_REQUEST['subject'];
  // $comment = $_REQUEST['comment'];
  
  //send email
  // mail($admin_email, "$subject", $comment, "From:" . $email);
  
  //Email response
  // echo "Thank you for contacting us!";
  }
  
  //if "email" variable is not filled out, display the form
  else  {
?>

 <form method="post">

  <?php echo $result; ?>

  Email: <input name="email" type="text" />

  <br>

  Subject: <input name="subject" type="text" />

  <br>

  Message:

  <textarea name="comment" rows="15" cols="40"></textarea>

  <br>

  <input type="submit" name="submit" value="Submit" />
  </form>
  
<?php
  }
?>