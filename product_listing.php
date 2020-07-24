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
        float: left;-
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
			<h1><strong>PRODUCT</strong></h1>
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

			<!-- start sql car -->

			<center><h1>List of Our Cars</h1></center>
			<br><br>

<?php

$sql = "SELECT
		class_name,
		class_image,
		people_capacity,
		baggage_capacity,
		doors,
		CASE transmission WHEN 'A' THEN 'Automatic Transmission' WHEN 'M' THEN 'Manual Transmission' END AS transmission,
		CASE air_conditioned WHEN 'Y' THEN 'Air Conditioning' END AS air_conditioned,
		desc_1,
		desc_2,
		desc_3,
		desc_4,
		oneday,
		twoday,
		threeday,
		fourday,
		fiveday,
		sixday,
		weekly,
		monthly,
		hour,
		halfday,
		vehicle.id,
		class.id,
		status
		FROM class
		LEFT JOIN car_rate ON class.id = car_rate.class_id
		LEFT JOIN vehicle ON  class.id = vehicle.class_id
		WHERE status='A'
		GROUP BY class.id";

		db_select($sql);

?>   

<!-- end sql car -->

<?php


 if(db_rowcount()>0){
?>
	

 
				
		<div class="row" id="ads">

		<?php

		for($i=0;$i<db_rowcount();$i++){




		?>

    <!-- Category Card -->
    <div class="col-md-4">
        <div class="card rounded">
            <div class="card-image">
                <img class="img-fluid" src="dashboard/assets/img/class/<?php echo db_get($i, 1); ?>" alt="<?php echo db_get($i, 0); ?>" width="440" height="230" /> 
            </div>
            <br>


            
            <div class="card-body text-center">
                <div class="ad-title m-auto">
                    <h5><?php echo db_get($i, 0); ?></h5>
                </div>

                <div class="card-image-overlay m-auto">

                <span class="card-detail-badge">RM <?php echo (int)db_get($i, 11); ?> / 1 Day</span>
                <span class="card-detail-badge">RM <?php echo (int)db_get($i, 12); ?> / 2 Day</span>
                <span class="card-detail-badge">RM <?php echo (int)db_get($i, 13); ?> / 3 Day</span>
                <span class="card-detail-badge">RM <?php echo (int)db_get($i, 17); ?> / 1 Week</span>
                <span class="card-detail-badge">RM <?php echo (int)db_get($i, 18); ?> / 1 Month</span>

            </div>

                <a class="ad-btn" href="index.php">Book Now</a>


                <br><br>
            </div>
        </div>
    </div>

		<?php


		}





		?>

</div>

<?php


 	}

	?>


			
			</div>
		</div>
	</div>
	<!-- END: ABOUT-US -->
	
	
    
</section>
<!-- END: CONTENT SECTION -->

<!-- start product style -->


<style type="text/css">


/* Category Ads */

#ads {
    margin: 30px 0 30px 0;
   
}

#ads .card-notify-badge {
        position: absolute;
        left: -10px;
        top: -20px;
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px; 
        color: #000;
        padding: 5px 10px;
        font-size: 14px;

    }

#ads .card-notify-year {
        position: absolute;
        right: -10px;
        top: -20px;
        background: #ff4444;
        border-radius: 50%;
        text-align: center;
        color: #fff;      
        font-size: 14px;      
        width: 50px;
        height: 50px;    
        padding: 15px 0 0 0;
}


#ads .card-detail-badge {      
        background: darkgray;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: white;
        padding: 5px 10px;
        font-size: 14px;        
    }

   

#ads .card:hover {
            background: #fff;
            box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

#ads .card-image-overlay {
        font-size: 20px;
        
    }


#ads .card-image-overlay span {
            display: inline-block;              
        }


#ads .ad-btn {
        text-transform: uppercase;
        width: 150px;
        height: 40px;
        border-radius: 80px;
        font-size: 16px;
        line-height: 35px;
        text-align: center;
        border: 3px solid #f9676b;
        display: block;
        text-decoration: none;
        margin: 20px auto 1px auto;
        color: white;
        overflow: hidden;        
        position: relative;
        background-color: #f9676b;
    }


#ads .ad-btn:hover {
            background-color: #e6de08;
            color: #1e1717;
            border: 2px solid #e6de08;
            background: transparent;
            transition: all 0.3s ease;
            box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
        }


#ads .ad-title h5 {
        text-transform: uppercase;
        font-size: 18px;
    }

</style>

<!-- end product style -->

<?php include('_footer.php'); ?>