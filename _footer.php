<style>
.block-with-text {
  /* hide text if it more than N lines  */
  overflow: hidden;
  /* for set '...' in absolute position */
  position: relative; 
  /* use this value to count block height */
  line-height: 1.2em;
  /* max-height = line-height (1.2) * lines max number (3) */
  max-height: 10em; 
  /* fix problem when last visible word doesn't adjoin right side  */
  text-align: justify;
  
  /* */
  margin-right: -1em;
  padding-right: 1em;
}
.block-with-text:before {
  /* points in the end */
  content: '...';
  /* absolute position */
  position: absolute;
  /* set position to right bottom corner of block */
  right: 0;
  bottom: 0;
}
.block-with-text:after {
  /* points in the end */
  content: '';
  /* absolute position */
  position: absolute;
  /* set position to right bottom corner of text */
  right: 0;
  width: 1em;
  /* set width and height */
  height: 1em;
  margin-top: 0.2em;
  background: white;
}
</style>

<!-- START: FOOTER -->
<section id="footer">
	<footer>
		<div class="row sm-footer">
			<div class="container clear-padding">
				<div class="col-md-3 col-sm-6 footer-about-box">
					<h4><?php echo $website_name; ?></h4>
					<?php  $sql = "SELECT introduction_desc FROM about_us WHERE id = 1"; db_select($sql); if (db_rowcount() > 0) { func_setSelectVar(); } 
					
					$sql = "SELECT 
	company_name,
	website_name,
	registration_no,
	address AS company_address,
	phone_no AS company_phone_no,
	image AS company_image,
	email AS company_email
	FROM company WHERE id IS NOT NULL";

db_select($sql);

if (db_rowcount() > 0) {
	func_setSelectVar();
} 

$sql = "SELECT * FROM front_page WHERE id = 1";
db_select($sql);
if (db_rowcount() > 0) {
    func_setSelectVar();

} 
					
					?> 
					<p class="block-with-text"><?php echo $introduction_desc; ?></p>
					<a href="about_us.php">READ MORE</a>
				</div>
				<div class="col-md-3 col-sm-6 contact-box">
					<h4>CONTACT US</h4>
					<p><i class="fa fa-home"></i><?php echo $company_address; ?></p>
					<p><i class="fa fa-envelope-o"></i><?php echo $company_email; ?></p>
					<p><i class="fa fa-phone"></i><?php echo $company_phone_no; ?></p>
					<p class="social-media">
						<?php
 if($company_facebook != ''){ echo "<a href='.$company_facebook.'><i class='fa fa-facebook'></i></a>"; } if($company_twitter != ''){ echo "<a href='.$company_twitter.'><i class='fa fa-twitter'></i></a>"; } if($company_google != ''){ echo "<a href='.$company_google.'><i class='fa fa-google'></i></a>"; } if($company_instagram != ''){ echo "<a href='.$company_instagram.'><i class='fa fa-instagram'></i></a>"; } ?>
					</p>
				</div>
				<div class="clearfix visible-sm-block"></div>
				<div class="col-md-3 col-sm-6 footer-gallery">
					<h4>PRODUCT</h4>
					<img src="dashboard/assets/img/cms/<?php echo $gallery_one; ?>" alt="<?php echo $gallery_one; ?>">
					<img src="dashboard/assets/img/cms/<?php echo $gallery_two; ?>" alt="<?php echo $gallery_two; ?>">
					<img src="dashboard/assets/img/cms/<?php echo $gallery_three; ?>" alt="<?php echo $gallery_three; ?>">
					<img src="dashboard/assets/img/cms/<?php echo $gallery_four; ?>" alt="<?php echo $gallery_four; ?>">
					<img src="dashboard/assets/img/cms/<?php echo $gallery_five; ?>" alt="<?php echo $gallery_five; ?>">
					<img src="dashboard/assets/img/cms/<?php echo $gallery_six; ?>" alt="<?php echo $gallery_six; ?>">
					
									<br><br>
				<div class="footer-about-box">
					<a href="product_listing.php">VIEW MORE</a>

				</div>
				</div>
				<div class="col-md-3 col-sm-6 footer-subscribe">
					<h4>SUBSCRIBE</h4>
					<p>Don't miss any deal. Subscribe to get offers alerts.</p>
					<form action="" method="POST">
						<div class="col-md-10 col-sm-10 col-xs-9 clear-padding">
							<input type="email" name="cust_email" required class="form-control" placeholder="Enter Your Email">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-3 clear-padding">
							<button type="submit" name="btn_subscribe"><i class="fa fa-paper-plane"></i></button>
						</div>
					</form>
<!-- 
					<?php

						if(isset($_POST['btn_subscribe']))
						{
							echo "masuk";
							echo "<br>";
							echo $_POST['cust_email'];
						}
						else{

							echo "belum masuk";
						}
					?> -->
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row sm-footer-nav text-center">
			<p class="copyright">
				&copy; <?php echo $company_name; ?>
			</p>
			<div class="go-up">
				<a href="#"><i class="fa fa-arrow-up"></i></a>
			</div>
		</div>
	</footer>
</section>
<!-- END: FOOTER -->

</div>
<!-- END: SITE-WRAPPER -->
<!-- Load Scripts -->
<script src="assets/js/respond.js"></script>
<script src="assets/js/jquery.js"></script>
<script src="assets/plugins/owl.carousel.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/plugins/wow.min.js"></script>
<script type="text/javascript" src="assets/plugins/supersized.3.1.3.min.js"></script>
<script src="assets/js/js.js"></script>


