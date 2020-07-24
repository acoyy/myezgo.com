<?php
session_start();
if(isset($_SESSION['cid']) || isset($_SESSION['user_id']))
{ 
$idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

if (time()-$_SESSION['timestamp']>$idletime){
  session_unset();
  session_destroy();
  echo "<script> alert('You have been logged out due to inactivity'); </script>";
              echo "<script>
                      window.location.href='../user/index.php';
                  </script>";
}else{
  $_SESSION['timestamp']=time();
}

// echo "<br>session: ".$_SESSION['user_id'];
?>



<!DOCTYPE html>
<html lang="en">

<?php include('_header.php'); ?>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <?php include('_leftpanel.php'); ?>

      <?php include('_toppanel.php'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

         <!-- start edit -->

         <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>User Information <!-- <small>Activity shares</small> --></h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
</li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a>
</li>
<li><a href="#">Settings 2</a>
</li>
</ul>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form name="editReservation" enctype="multipart/form-data" id="editReservation" data-parsley-validate class="form-horizontal form-label-left"  method="post">

<br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NRIC No</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" placeholder="Empty" name="nric_no" value="<?php echo $nric_no; ?>" onblur="selectNRIC(this.value)" disabled> 
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Title</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="title" class="form-control" id="title" disabled>
            
                              <option <?php echo vali_iif('Mr.' == $title, 'Selected', ''); ?> value='Mr.'>Mr.</option>
                              
                              <option <?php echo vali_iif('Mrs.' == $title, 'Selected', ''); ?> value='Mrs.'>Mrs.</option>
                              
                              <option <?php echo vali_iif('Miss.' == $title, 'Selected', ''); ?> value='Miss.'>Miss.</option>

                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">First Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" placeholder="Empty" name="firstname" id="firstname" value="<?php echo $firstname; ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" placeholder="Empty" name="lastname" id="lastname" value="<?php echo $lastname; ?>" id="lastname" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Driver's Age</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" placeholder="Empty" name="age" value="<?php echo $age; ?>" id="age" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone No</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" placeholder="Empty" name="phone_no" value="<?php echo $phone_no; ?>" id="phone_no" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" class="form-control" placeholder="Empty" name="email" value="<?php echo $email; ?>" id="email" disabled>
                            </div>
                          </div>

                          <div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_no">License Number</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="License No" name="license_no" value="<?php echo $license_no; ?>" id="license_no" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_exp">License Expired</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" class="form-control" placeholder="License Expired" name="license_exp" value="<?php echo $license_exp; ?>" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $address; ?>" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postcode">Postcode</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="number" class="form-control" placeholder=" Postcode" name="postcode" value="<?php echo $postcode; ?>" id="postcode" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">State</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="city" class="form-control" id="city" required disabled>
<option value="">Please Select</option>
<option <?php echo vali_iif('Perlis' == $city, 'Selected', ''); ?> value='Perlis'>Perlis</option>
<option <?php echo vali_iif('Kedah' == $city, 'Selected', ''); ?> value='Kedah'>Kedah</option>
<option <?php echo vali_iif('Pulau Pinang' == $city, 'Selected', ''); ?> value='Pulau Pinang'>Pulau Pinang</option>
<option <?php echo vali_iif('Perak' == $city, 'Selected', ''); ?> value='Perak'>Perak</option>
<option <?php echo vali_iif('Selangor' == $city, 'Selected', ''); ?> value='Selangor'>Selangor</option>
<option <?php echo vali_iif('Wilayah Persekutuan Kuala Lumpur' == $city, 'Selected', ''); ?> value='Wilayah Persekutuan Kuala Lumpur'>Wilayah Persekutuan Kuala Lumpur</option>
<option <?php echo vali_iif('Wilayah Persekutuan Putrajaya' == $city, 'Selected', ''); ?> value='Wilayah Persekutuan Putrajaya'>Wilayah Persekutuan Putrajaya</option>
<option <?php echo vali_iif('Melaka' == $city, 'Selected', ''); ?> value='Melaka'>Melaka</option>
<option <?php echo vali_iif('Negeri Sembilan' == $city, 'Selected', ''); ?> value='Negeri Sembilan'>Negeri Sembilan</option>
<option <?php echo vali_iif('Johor' == $city, 'Selected', ''); ?> value='Johor'>Johor</option>
<option <?php echo vali_iif('Pahang' == $city, 'Selected', ''); ?> value='Pahang'>Pahang</option>
<option <?php echo vali_iif('Terengganu' == $city, 'Selected', ''); ?> value='Terengganu'>Terengganu</option>
<option <?php echo vali_iif('Kelantan' == $city, 'Selected', ''); ?> value='Kelantan'>Kelantan</option>
<option <?php echo vali_iif('Sabah' == $city, 'Selected', ''); ?> value='Sabah'>Sabah</option>
<option <?php echo vali_iif('Sarawak' == $city, 'Selected', ''); ?> value='Sarawak'>Sarawak</option>
</select>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select ui-jq="chosen" name="country" class="form-control" id="country" required disabled>
<optgroup label="Alaskan/Hawaiian Time Zone">
<option value="AK">Alaska</option>
<option value="HI">Hawaii</option>
<option value="MY" selected>Malaysia</option>
</optgroup>

<optgroup label="Pacific Time Zone">
<option value="CA">California</option>
<option value="NV">Nevada</option>
<option value="OR">Oregon</option>
<option value="WA">Washington</option>
</optgroup>

<optgroup label="Mountain Time Zone">
<option value="AZ">Arizona</option>
<option value="CO">Colorado</option>
<option value="ID">Idaho</option>
<option value="MT">Montana</option>
<option value="NE">Nebraska</option>
<option value="NM">New Mexico</option>
<option value="ND">North Dakota</option>
<option value="UT">Utah</option>
<option value="WY">Wyoming</option>
</optgroup>

<optgroup label="Central Time Zone">
<option value="AL">Alabama</option>
<option value="AR">Arkansas</option>
<option value="IL">Illinois</option>
<option value="IA">Iowa</option>
<option value="KS">Kansas</option>
<option value="KY">Kentucky</option>
<option value="LA">Louisiana</option>
<option value="MN">Minnesota</option>
<option value="MS">Mississippi</option>
<option value="MO">Missouri</option>
<option value="OK">Oklahoma</option>
<option value="SD">South Dakota</option>
<option value="TX">Texas</option>
<option value="TN">Tennessee</option>
<option value="WI">Wisconsin</option>
</optgroup>

<optgroup label="Eastern Time Zone">
<option value="CT">Connecticut</option>
<option value="DE">Delaware</option>
<option value="FL">Florida</option>
<option value="GA">Georgia</option>
<option value="IN">Indiana</option>
<option value="ME">Maine</option>
<option value="MD">Maryland</option>
<option value="MA">Massachusetts</option>
<option value="MI">Michigan</option>
<option value="NH">New Hampshire</option>
<option value="NJ">New Jersey</option>
<option value="NY">New York</option>
<option value="NC">North Carolina</option>
<option value="OH">Ohio</option>
<option value="PA">Pennsylvania</option>
<option value="RI">Rhode Island</option>
<option value="SC">South Carolina</option>
<option value="VT">Vermont</option>
<option value="VA">Virginia</option>
<option value="WV">West Virginia</option>
</optgroup>

</select>
</div>
</div>

                          <div class="ln_solid"></div>

                        </form>


</div>
</div>

<div class="x_panel">
<div class="x_title">
<h2>Additional Driver Information</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br>
<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_name">Name</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Name" name="drv_name" value="<?php echo $drv_name; ?>" id="drv_name" disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_nric">NRIC No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="IC No. / Passport" name="drv_nric" value="<?php echo $drv_nric; ?>" id="drv_nric" disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_address">Address</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" placeholder="Address" name="drv_address" value="<?php echo $drv_address; ?>" id="drv_address" disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_phoneno">Phone No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Phone No" name="drv_phoneno" value="<?php echo $drv_phoneno; ?>" id="drv_phoneno" disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_no">License No.</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" type="text" placeholder="License No." name="drv_license_no" id="drv_license_no" value="<?php echo $drv_license_no; ?>" disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="drv_license_exp">License Expired</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" class="form-control" name="drv_license_exp" value="<?php echo $drv_license_exp; ?>"  placeholder="License Expired" id="drv_license_exp" required disabled>
</div>
</div>

<div class="ln_solid"></div>
</div>
</div>
</div>

<div class="x_panel">
<div class="x_title">
<h2>Reference Information</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br>
<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Name</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Reference Name" name="ref_name" value="<?php echo $ref_name; ?>" id="ref_name" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Relationship</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Reference Relationship" name="ref_relationship" value="<?php echo $ref_relationship; ?>" id="ref_relationship" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Address</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" placeholder="Reference Address" name="ref_address" id="ref_address" value="<?php echo $ref_address; ?>" required disabled>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Reference Phone No</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" placeholder="Reference Phone No" name="ref_phoneno" value="<?php echo $ref_phoneno; ?>" id="ref_phoneno" required disabled>
</div>
</div>

<div class="ln_solid"></div>

</div>
</div>
</div>


<div class="x_panel">
<div class="x_title">
<h2>Survey</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>

<div class="x_content">
<br>
<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Survey</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="survey_type" id="survey_type" class="form-control" id="survey" onchange="change();" required disabled>
<option <?php echo vali_iif('Banner' == $survey_type, 'Selected', ''); ?> value='Banner'>Banner</option>
<option <?php echo vali_iif('Bunting' == $survey_type, 'Selected', ''); ?> value='Bunting'>Bunting</option>
<option <?php echo vali_iif('Facebook Ads' == $survey_type, 'Selected', ''); ?> value='Freinds'>Facebook Ads</option>
<option <?php echo vali_iif('Friends' == $survey_type, 'Selected', ''); ?> value='Friends'>Friends</option>
<option <?php echo vali_iif('Google Ads' == $survey_type, 'Selected', ''); ?> value='Google Ads'>Google Ads</option>
<option <?php echo vali_iif('Magazine' == $survey_type, 'Selected', ''); ?> value='Magazine'>Magazine</option>
<option <?php echo vali_iif('Others' == $survey_type, 'Selected', ''); ?> value='Others'>Others</option>
</select>
</div>
</div>
<div class="ln_solid"></div>

<div class="form-group" style="text-align: center;">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--<button type="submit" name="btn_save" class="btn btn-success">Submit</button>-->
</div>
</div>
</div>
</div>
</div>
</div>

         <!-- end edit -->

        </div>
      </div>
      <!-- /page content -->

      <?php include('_footer.php') ?>

    </div>
  </div>


</body>
</html>
<style>
@-webkit-keyframes ring {
  0% {
    -webkit-transform: rotate(-15deg);
    transform: rotate(-15deg);
  }

  2% {
    -webkit-transform: rotate(15deg);
    transform: rotate(15deg);
  }

  4% {
    -webkit-transform: rotate(-18deg);
    transform: rotate(-18deg);
  }

  6% {
    -webkit-transform: rotate(18deg);
    transform: rotate(18deg);
  }

  8% {
    -webkit-transform: rotate(-22deg);
    transform: rotate(-22deg);
  }

  10% {
    -webkit-transform: rotate(22deg);
    transform: rotate(22deg);
  }

  12% {
    -webkit-transform: rotate(-18deg);
    transform: rotate(-18deg);
  }

  14% {
    -webkit-transform: rotate(18deg);
    transform: rotate(18deg);
  }

  16% {
    -webkit-transform: rotate(-12deg);
    transform: rotate(-12deg);
  }

  18% {
    -webkit-transform: rotate(12deg);
    transform: rotate(12deg);
  }

  20% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@keyframes ring {
  0% {
    -webkit-transform: rotate(-15deg);
    -ms-transform: rotate(-15deg);
    transform: rotate(-15deg);
  }

  2% {
    -webkit-transform: rotate(15deg);
    -ms-transform: rotate(15deg);
    transform: rotate(15deg);
  }

  4% {
    -webkit-transform: rotate(-18deg);
    -ms-transform: rotate(-18deg);
    transform: rotate(-18deg);
  }

  6% {
    -webkit-transform: rotate(18deg);
    -ms-transform: rotate(18deg);
    transform: rotate(18deg);
  }

  8% {
    -webkit-transform: rotate(-22deg);
    -ms-transform: rotate(-22deg);
    transform: rotate(-22deg);
  }

  10% {
    -webkit-transform: rotate(22deg);
    -ms-transform: rotate(22deg);
    transform: rotate(22deg);
  }

  12% {
    -webkit-transform: rotate(-18deg);
    -ms-transform: rotate(-18deg);
    transform: rotate(-18deg);
  }

  14% {
    -webkit-transform: rotate(18deg);
    -ms-transform: rotate(18deg);
    transform: rotate(18deg);
  }

  16% {
    -webkit-transform: rotate(-12deg);
    -ms-transform: rotate(-12deg);
    transform: rotate(-12deg);
  }

  18% {
    -webkit-transform: rotate(12deg);
    -ms-transform: rotate(12deg);
    transform: rotate(12deg);
  }

  20% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@-webkit-keyframes horizontal {
  0% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
  }

  6% {
    -webkit-transform: translate(-5px,0);
    transform: translate(-5px,0);
  }

  12% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
  }

  18% {
    -webkit-transform: translate(-5px,0);
    transform: translate(-5px,0);
  }

  24% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
  }

  30% {
    -webkit-transform: translate(-5px,0);
    transform: translate(-5px,0);
  }

  36% {
    -webkit-transform: translate(0,0);
    transform: translate(0,0);
  }
}

@keyframes horizontal {
  0% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
  }

  6% {
    -webkit-transform: translate(-5px,0);
    -ms-transform: translate(-5px,0);
    transform: translate(-5px,0);
  }

  12% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
  }

  18% {
    -webkit-transform: translate(-5px,0);
    -ms-transform: translate(-5px,0);
    transform: translate(-5px,0);
  }

  24% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
  }

  30% {
    -webkit-transform: translate(-5px,0);
    -ms-transform: translate(-5px,0);
    transform: translate(-5px,0);
  }

  36% {
    -webkit-transform: translate(0,0);
    -ms-transform: translate(0,0);
    transform: translate(0,0);
  }
}

.faa-ring.animated,
.faa-ring.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-ring {
  -webkit-animation: ring 4s ease infinite;
  animation: ring 4s ease infinite;
  transform-origin-x: 50%;
  transform-origin-y: 0px;
  transform-origin-z: initial;

}

.faa-horizontal.animated,
.faa-horizontal.animated-hover:hover,
.faa-parent.animated-hover:hover > .faa-horizontal {
  -webkit-animation: horizontal 2s ease infinite;
  animation: horizontal 2s ease infinite;
}

</style>
<?php
} 
else{

echo "<script>
        window.alert('You need to login to continue');
          window.location.href='../user/index.php';
        </script>";
}
?>