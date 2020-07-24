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
			<h1><strong>PRIVACY POLICY</strong></h1>
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
			<div class="col-md-12 col-sm-12">
				
				<?php


				$sql = "SELECT content FROM privacy_policy where id=1";

				db_select($sql);

				if (db_rowcount() > 0) {
					func_setSelectVar();
				}

				

					echo db_get(0, 0).'<br>';


				





				?>

			</div>
		</div>
	</div>
	<!-- END: ABOUT-US -->
	
	
    
</section>
<!-- END: CONTENT SECTION -->

<?php include('_footer.php'); ?>