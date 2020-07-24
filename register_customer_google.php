<?php

  session_start();
  
  include "dashboard/lib/setup.php";
  $sql = "SELECT * FROM company WHERE id IS NOT NULL";
  db_select($sql);
  if (db_rowcount() > 0) {
      func_setSelectVar();
  }
  func_setReqVar();
?>


<!-- start google -->

<?php


echo '<br>userdata.id: '.$userData['id'];

$provider = "google";
$firstnameGoogle = "";
$lastnameGoogle = "";
$emailGoogle = "";

if( !empty($_SESSION['id']) ){

$providerID = $_SESSION['id'];

$sqlProv = "SELECT id FROM customer WHERE provider_id='$providerID' and provider='$provider' LIMIT 1";

  db_select($sqlProv);

  if (db_rowcount() > 0) {

      $sql = "SELECT * FROM customer WHERE provider_id='$providerID' and provider='$provider'";

      db_select($sql);
      
      if (db_rowcount() > 0) {
          
          if(isset($_SESSION['booking']))
                {

                  $_SESSION['user_id'] = db_get(0, 0);
                  $_SESSION['login'] = 1;
                  $_SESSION['timestamp']=time();
                  $_SESSION['sess_time']=86400;

                  vali_redirect("user/rules_confirmation.php");

                 }
        
                   $_SESSION['user_id'] = db_get(0, 0);
                   $_SESSION['login'] = 1;
                   $_SESSION['timestamp']=time();
                   $_SESSION['sess_time']=86400;

                   vali_redirect("user/dashboard.php");
                    // echo "<script> window.location.href='dashboard/dashboard.php'; </script>";
                    // echo "<script> window.location.href='../new/user/dashboard.php';</script>";
                } else {
                    
                    echo "<script> alert('We encountered error when you register your account.'); </script>";
                    echo "<script>
                            window.location.href='login.php';
                        </script>";
                }

      $_SESSION['user_id'] = db_get(0, 0);
      $_SESSION['login'] = 1;
      $_SESSION['timestamp']=time();
      $_SESSION['sess_time']=86400;
 
      vali_redirect("user/dashboard.php");

  } 

} else {

echo "<script> alert('Google ID is not found!'); </script>";
vali_redirect("login.php"); 

  }



if( !empty($_SESSION['givenName']) ){

$firstnameGoogle = $_SESSION['givenName'];

}


if( !empty($_SESSION['familyName']) ){

$lastnameGoogle = $_SESSION['familyName'];

}

if( !empty($_SESSION['email']) ){

$emailGoogle = $_SESSION['email'];

}




?>

<!-- end google -->




<?php

if (isset($btn_save))
{

  func_setValid("Y"); 

    if(func_isValid()){ 

    if($_POST['password']==$_POST['confirmPassword']){

    $sqlEmail = "SELECT id FROM customer WHERE email='".$_POST['email']."' and password is not null LIMIT 1";

    db_select($sqlEmail); 
                          
    if (db_rowcount() > 0) {     

        echo "<script> alert('The email you entered is already taken'); </script>";
        
    } else {

        $sqlIC = "SELECT id FROM customer WHERE nric_no='".$_POST['nric_no']."' and password is not null LIMIT 1";

        db_select($sqlIC); 

        if (db_rowcount() > 0) {   

        echo "<script> alert('The ic you entered is already taken'); </script>";

        } else {


          // start check

          $sqlCheck = "SELECT id FROM customer WHERE email='".$_POST['email']."' and password is null LIMIT 1";

          db_select($sqlCheck); 

          $checkId=db_get(0, 0);

          if (db_rowcount() > 0) {     

          // start update

          $sql = "UPDATE customer SET 
            nric_no='".$_POST['nric_no']."',
            email='".$_POST['email']."',
            phone_no='".$_POST['phone_no']."',
            title='".$_POST['title']."',
            firstname='$firstnameFb', 
            lastname='$lastnameFb',
            address='".$_POST['address']."',
            postcode='".$_POST['postcode']."',
            city='".$_POST['city']."',
            country='".$_POST['country']."',
            provider='$provider',
            provider_id='$providerID',
            password='".$_POST['password']."',
            mdate=CURRENT_TIMESTAMP 
            WHERE id=".$checkId; 

            db_update($sql); 

      echo "<script> alert('The user has been register successfully!'); </script>";

      $sql = "SELECT * FROM customer WHERE id='$checkId'";

              db_select($sql);
              if (db_rowcount() > 0) {
                  
                  if(isset($_SESSION['booking']))
                {

                  $_SESSION['user_id'] = db_get(0, 0);
                  $_SESSION['login'] = 1;
                  $_SESSION['timestamp']=time();
                  $_SESSION['sess_time']=86400;

                  vali_redirect("user/rules_confirmation.php");

                 }
                  
                   $_SESSION['user_id'] = db_get(0, 0);
                   $_SESSION['login'] = 1;
                   $_SESSION['timestamp']=time();
                   $_SESSION['sess_time']=86400;

                   vali_redirect("user/dashboard.php");
                    // echo "<script> window.location.href='dashboard/dashboard.php'; </script>";
                    // echo "<script> window.location.href='../new/user/dashboard.php';</script>";
                } else {
                    
                    echo "<script> alert('We encountered error when you register your account. Your Id is '".$checkId."'); </script>";
                    echo "<script>
                            window.location.href='login.php';
                        </script>";
                }

      $_SESSION['user_id'] = db_get(0, 0);
      $_SESSION['login'] = 1;
      $_SESSION['timestamp']=time();
      $_SESSION['sess_time']=86400;
 
      echo "<script> alert('".$_SESSION['user_id']."'); </script>";
      vali_redirect("user/dashboard.php");


          // end update

          }


          // end check

          else{

          // start insert

          $sql="INSERT INTO 
         customer
         (
         nric_no,
         email,
         phone_no,
         title,
         firstname,
         lastname,
         address,
         postcode,
         city,
         country,
         provider,
         provider_id,
         password,
         cdate,
         mdate
         )
         VALUES
         (
         '".$_POST['nric_no']."',
         '".$_POST['email']."',
         '".$_POST['phone_no']."',
         '".$_POST['title']."',
         '$firstnameGoogle',
         '$lastnameGoogle',
         '".$_POST['address']."',
         '".$_POST['postcode']."',
         '".$_POST['city']."',
         '".$_POST['country']."',
         '$provider',
         '$providerID',
         '".$_POST['password']."',
         CURRENT_TIMESTAMP,
         CURRENT_TIMESTAMP
         )
         "; 

      db_update($sql); 

      echo "<script> alert('The user has been register successfully!'); </script>";

      $uid = mysqli_insert_id($con);

      $sql = "SELECT * FROM customer WHERE id='$uid'";

      db_select($sql);
      
      if (db_rowcount() > 0) {
          
          if(isset($_SESSION['booking']))
                {

                  $_SESSION['user_id'] = db_get(0, 0);
                  $_SESSION['login'] = 1;
                  $_SESSION['timestamp']=time();
                  $_SESSION['sess_time']=86400;

                  vali_redirect("user/rules_confirmation.php");

                 }

                   $_SESSION['user_id'] = db_get(0, 0);
                   $_SESSION['login'] = 1;
                   $_SESSION['timestamp']=time();
                   $_SESSION['sess_time']=86400;

                   vali_redirect("user/dashboard.php");
                    // echo "<script> window.location.href='dashboard/dashboard.php'; </script>";
                    // echo "<script> window.location.href='../new/user/dashboard.php';</script>";
                } else {
                    
                    echo "<script> alert('We encountered error when you register your account.'); </script>";
                    echo "<script>
                            window.location.href='login.php';
                        </script>";
                }

      $_SESSION['user_id'] = db_get(0, 0);
      $_SESSION['login'] = 1;
      $_SESSION['timestamp']=time();
      $_SESSION['sess_time']=86400;
 
      vali_redirect("user/dashboard.php");

      }

      // end insert

          }

        } 
      

      }

      else{

      echo "<script> alert('Your password and confirm password is not matched!'); </script>";

    }



  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="dashboard/assets/img/<?php echo $company_image; ?>" />
    <link rel="icon" type="image/png" href="dashboard/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $website_name; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="dashboard/assets/css/core/bootstrap.min.css" rel="stylesheet" />
    <link href="dashboard/assets/css/core/now-ui-kit.css" rel="stylesheet" />
</head>

<?php
if(isset($_SESSION['cid']))
{ 

    include "dashboard/lib/setup.php";
    vali_redirect("dashboard/");
    // echo "<script>
    //         window.location.href='dashboard.php';
    //     </script>";
}
if(isset($_SESSION['user_id']))
{ 

    include "dashboard/lib/setup.php";
    vali_redirect("user/dashboard");
    // echo "<script>
    //         window.location.href='dashboard.php';
    //     </script>";
}

else if(!isset($_SESSION['cid']) || !isset($_SESSION['user_id']))
{
    if (isset($btn_login)) {
        func_setValid("Y");
        if (func_isValid()) {

            if($_SESSION['cust_status'] == "booking")
            {
                echo "masuk status";
                $sql = "SELECT * FROM user2 WHERE username='" . $username . "' and password='" . $password . "'";
                db_select($sql);
                if (db_rowcount() > 0) {
                    $_SESSION['user_id'] = db_get(0, 0);
                    $_SESSION['login'] = 1;
                    $_SESSION['timestamp']=time();
                    $_SESSION['sess_time']=86400;

                    echo "<script> alert('".$_SESSION['user_id']."'); </script>";

                    vali_redirect("user/dashboard");
                    // echo "<script> window.location.href='dashboard/dashboard.php'; </script>";
                    // echo "<script> window.location.href='../new/user/dashboard.php';</script>";
                } else {
                    
                    echo "<script> alert('Invalid username or password'); </script>";
                    echo "<script>
                            window.location.href='index.php';
                        </script>";
                }
            }
        }
    }
    else
    {
    }
?>

<body class="login-page sidebar-collapse" style="background-image:url(dashboard/assets/img/login.jpg); background-size: 100%;">
  <div class="">
    

    <div class="page-header" filter-color="primary">
      <br>
      <div class="container">
        <form method="POST" action="">
          <div class="row">
            <div class="col-2">
              
            </div>
            <div class="col-8">
              <a class="navbar-brand" href="../" rel="tooltip" title="Designed by &amp; Coded by D.Danial Zurkanain & acoyy (innovation)" data-placement="bottom" style="color: white;">
              <?php echo $website_name; ?>
              </a>
            </div>
            <div class="col-2">
              
            </div>
            <div class="col-xs-0 col-sm-0 col-md-0 col-lg-2 content-center"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 content-center">
              <div class="right_col" role="main">
                <div class="row">
                  <div class="col-md-12">
                    <center>
                      <div class="alert alert-warning" role="alert">
                        <b>Customer Information</b>
                      </div>
                    </center>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">NRIC No</label>
                      <input type="number" class="form-control" style="color: gray; font-weight: bold;" name="nric_no" onblur="selectNRIC(this.value)" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Email</label>

                      <?php

                      if(!empty($emailGoogle)){

                      ?>

                      <input type="email" class="form-control" style="color: gray; font-weight: bold;" name="email" id="email" value="<?php echo $emailGoogle; ?>" required  readonly>



                      <?php

                      } else{

                      ?>

                      <input type="email" class="form-control" style="color: gray; font-weight: bold;" name="email" id="email" value="<?php echo $emailGoogle; ?>" required  >


                      <?php

                      }

                      ?>

                      

                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Phone No</label>
                      <input type="tel" class="form-control" style="color: gray; font-weight: bold;" name="phone_no" id="phone_no" required>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label">Title</label>
                      <select name="title" class="form-control" style="color: gray; font-weight: bold;" id="title">
                        <option value='Mr.'>Mr.</option>
                        <option value='Mrs.'>Mrs.</option>
                        <option value='Miss'>Miss</option>
                      </select>
                    </div>
                  </div>

                </div>
       

                <div class="row">
                  <div class="col-md-7">
                    <div class="form-group">
                      <label class="control-label">Address</label>
                      <input class="form-control" style="color: gray; font-weight: bold;" name="address" id="address" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label">Postcode</label>
                      <input type="number" class="form-control" style="color: gray; font-weight: bold;" name="postcode" id="postcode" required>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">State</label>
                      <select name="city" class="form-control" style="color: gray; font-weight: bold;" id="city">
                        <option value="">Please Select</option>
                        <option value='Perlis'>Perlis</option>
                        <option value='Kedah'>Kedah</option>
                        <option value='Pulau Pinang'>Pulau Pinang</option>
                        <option value='Perak'>Perak</option>
                        <option value='Selangor'>Selangor</option>
                        <option value='Wilayah Persekutuan Kuala Lumpur'>Wilayah Persekutuan Kuala Lumpur</option>
                        <option value='Wilayah Persekutuan Putrajaya'>Wilayah Persekutuan Putrajaya</option>
                        <option value='Melaka'>Melaka</option>
                        <option value='Negeri Sembilan'>Negeri Sembilan</option>
                        <option value='Johor'>Johor</option>
                        <option value='Pahang'>Pahang</option>
                        <option value='Terengganu'>Terengganu</option>
                        <option value='Kelantan'>Kelantan</option>
                        <option value='Sabah'>Sabah</option>
                        <option value='Sarawak'>Sarawak</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Country</label>
                      <select ui-jq="chosen" name="country" class="form-control" style="color: gray; font-weight: bold;" id="country" required>
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

          
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Password</label>
                      <input type="password" class="form-control" style="color: gray; font-weight: bold;" name="password" id="password" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Confirm Password</label>
                      <input type="password" class="form-control" style="color: gray; font-weight: bold;" name="confirmPassword" id="confirmPassword" required>
                    </div>
                  </div>
           
                </div>

                  

                <br>

                <button class="btn btn-warning" type="submit" name="btn_save"><font size="4">Continue <i class="fa fa-arrow-circle-right"></i></font></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

<?php }
?>

<!--   Core JS Files   -->
  <script src="dashboard/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
  <script src="dashboard/assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="dashboard/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="dashboard/assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="dashboard/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
  <script src="dashboard/assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
  <!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
  <script src="dashboard/assets/js/now-ui-kit.js?v=1.1.0" type="text/javascript"></script>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
</html>