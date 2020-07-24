<!DOCTYPE html>

<html class="load-full-screen">

<?php
 include('_header.php'); func_setReqVar(); $sql = "SELECT * FROM about_us WHERE id = 1"; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } ?>

<style>

.alert {
	border: 2px solid #07253F;
	border-radius: 0px;
	background: transparent;
	color: #07253F;
}

.checkup button {
	background: #07253F none repeat scroll 0 0;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    margin-top: 10px;
    padding: 15px 40px;
	border: 2px solid transparent;
	border-radius: 0px;
}
.checkup button:hover {
	border: 2px solid #07253F;
	background: transparent;
	color: #07253F;
}

.col-xs-5ths,
.col-sm-5ths,
.col-md-5ths,
.col-lg-5ths {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}

.col-xs-5ths {
    width: 20%;
    float: left;
}

@media (min-width: 768px) {
    .col-sm-5ths {
        width: 20%;
        float: left;
    }
}

@media (min-width: 992px) {
    .col-md-5ths {
        width: 20%;
        float: left;
    }
}

@media (min-width: 1200px) {
    .col-lg-5ths {
        width: 20%;
        float: left;
    }
}
</style>

<body class="load-full-screen">

<!-- BEGIN: PRELOADER -->
<div id="loader" class="load-full-screen">
	<div class="loading-animation">
		<span><i class="fa fa-plane"></i></span>
		<span><i class="fa fa-bed"></i></span>
		<span><i class="fa fa-ship"></i></span>
		<span><i class="fa fa-suitcase"></i></span>
	</div>
</div>
<!-- END: PRELOADER -->

<?php include('_panel.php'); ?>

<!-- BEGIN: PAGE TITLE SECTION -->
<section>
	<!-- START: PAGE TITLE -->
	<div class="row page-title">
		<div class="container clear-padding text-center flight-title">
			<h1><strong>CONTACT US</strong></h1>
		</div>
	</div>
	<!-- END: PAGE TITLE -->
</section>	
<!-- END: PAGE TITLE SECTION -->

<!-- BEGIN: CONTENT SECTION -->	
<section>
	<!-- START: ABOUT-US -->
	<div class="row about-intro">
		<div class="container clear-padding">
			<div class="col-md-6 col-sm-6">
				<h2><?php echo $introduction_title; ?></h2>
				<h4><?php echo $introduction_subtitle; ?></h4>
				<p><?php echo $introduction_desc; ?></p>
			</div>
			<div class="col-md-6 col-sm-6">
                <img src="dashboard/assets/img/cms/<?php echo $introduction_img; ?>" alt="<?php echo $introduction_img; ?>">
			</div>
		</div>
	</div>
	<!-- END: ABOUT-US -->
	
    <!-- START: OUR TEAM -->
    <?php
 require("dashboard/lib/phpmailer/class.phpmailer.php"); if(isset($submit)) { $mail = new PHPMailer(); $mail->IsSMTP(); $mail->SMTPDebug = 1; $mail->SMTPAuth = true; $mail->SMTPSecure = 'ssl'; $mail->Host = "mail.myezgo.com"; $mail->Port = 465; $mail->IsHTML(true); $mail->Username = "sales@myezgo.com"; $mail->Password = "MYEZGO2018"; $mail->SetFrom("sales@myezgo.com"); $mail->Subject = "Message Us"; $mail->Body = "
        <h4> $message_title </h4>
        <b> From : $name </b>
        <i> Email : $email </i>
        <p> $comment </p>
        "; $mail->isHTML(true); $mail->AddAddress($email); $mail->AddAddress('504150731@etlgr.com'); if (!$mail->Send()) { echo "Mailer Error: " . $mail->ErrorInfo; } vali_redirect("about_us.php"); } ?>

	<div class="row contact-address">
		<div class="container clear-padding">
        <div class="col-md-6 col-sm-6">
				<iframe class="contact-map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15941.785995532651!2d101.9037508!3d2.6824519!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbbcd2b9eb167794c!2sKereta+Sewa+Seremban+Murah-+MYezGO+Car+Rental!5e0!3m2!1sen!2smy!4v1528255099889"></iframe>
                </div>
			<div class="col-md-6 col-sm-6 contact-form">
				<div class="col-md-12">
					<h2>CONTACT US</h2>
					<h5>Drop Us a Message</h5>
				</div>
				<form action="mailto:myezgo01@gmail.com" method="post" enctype="text/plain">
					<div class="col-md-6 col-sm-6">
						<input type="text" name="name" required class="form-control" placeholder="Your Name">
					</div>
					<div class="col-md-6 col-sm-6">
						<input type="email" name="email" required class="form-control" placeholder="Your Email">
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12">
						<input type="text" name="message_title" required class="form-control" placeholder="Message Title">
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12">
						<textarea class="form-control" rows="5" name="comment" placeholder="Your Message"></textarea>
					</div>
					<div class="clearfix"></div>
					<div class="text-center">
						<button type="submit" name="submit" class="btn btn-default submit-review">SEND YOUR MESSAGE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- END: OUR TEAM -->
	
	<!-- START: OUR SERVICE -->
	<div class="row our-service">
		<div class="overlay">
			<div class="container clear-padding">
				<div class="service-left col-md-4">
					<div class="section-title">
						<h2><?php echo $services_title; ?></h2>
						<h4><?php echo $services_subtitle; ?></h4>
					</div>
					<p><?php echo $services_desc; ?></p>
				</div>
				<div class="service-right col-md-8">
					<div class="col-md-6 col-sm-6 text-center service">
						<i class="fa fa-plane"></i>
						<div class="service-desc">
							<h5><?php echo $box1_title; ?></h5>
							<p><?php echo $box1_desc; ?></p>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 text-center service">
						<i class="fa fa-bed"></i>
						<div class="service-desc">
                            <h5><?php echo $box2_title; ?></h5>
							<p><?php echo $box2_desc; ?></p>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6 col-sm-6 text-center service">
						<i class="fa fa-suitcase"></i>
						<div class="service-desc">
                            <h5><?php echo $box3_title; ?></h5>
							<p><?php echo $box3_desc; ?></p>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 text-center service">
						<i class="fa fa-ship"></i>
						<div class="service-desc">
                            <h5><?php echo $box4_title; ?></h5>
							<p><?php echo $box4_desc; ?></p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
    <!-- END: OUR SERVICE -->
    
</section>
<!-- END: CONTENT SECTION -->

<?php include('_footer.php'); ?>