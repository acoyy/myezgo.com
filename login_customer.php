<?php
session_start();
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
    include "dashboard/lib/setup.php";
    $sql = "SELECT * FROM company WHERE id IS NOT NULL";
    db_select($sql);
    if (db_rowcount() > 0) {
        func_setSelectVar();
    }
    func_setReqVar();
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
        require_once "config.php";

        if (isset($_GET['code'])) {
          $client->authenticate($_GET['code']);
          $_SESSION['access_token'] = $client->getAccessToken();
          header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
          exit;
        }

        /************************************************
          If we have an access token, we can make
          requests, else we generate an authentication URL.
         ************************************************/
         
         //after login
         
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
          $client->setAccessToken($_SESSION['access_token']);

            $user = $service->userinfo->get(); //get user info 
          echo $user->id;
          echo $user->name;
          echo $user->email;
          
          ?>
            <script type="text/javascript">
              window.location.href = 'login.php';
            </script>
          <?php 
          //    header('Location: index.php');
          //    exit();
        }
        //  else {
        //   $authUrl = $client->createAuthUrl();
        // }






        // require_once "google-config.php";

        $redirectURL = "https://www.myezgo.com/fb-callback.php";
        $permissions = ['email'];

        $loginURL = $helper->getLoginUrl($redirectURL, $permissions);  
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

<body class="login-page sidebar-collapse">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
        <div class="container">

            <div class="navbar-translate">
                <a class="navbar-brand" href="../new" rel="tooltip" title="Designed by &amp; Coded by D.Danial Zurkanain & acoyy (innovation)" data-placement="bottom">
                <?php echo $website_name; ?>
                </a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="assets/img/blurred-image-1.jpg">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="https://twitter.com/CreativeTim" target="_blank">
                            <i class="fa fa-twitter"></i>
                            <p class="d-lg-none d-xl-none">Twitter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="https://www.facebook.com/CreativeTim" target="_blank">
                            <i class="fa fa-facebook-square"></i>
                            <p class="d-lg-none d-xl-none">Facebook</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="https://www.instagram.com/CreativeTimOfficial" target="_blank">
                            <i class="fa fa-instagram"></i>
                            <p class="d-lg-none d-xl-none">Instagram</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="page-header" filter-color="primary">
        <div class="page-header-image" style="background-image:url(dashboard/assets/img/login.jpg)"></div>
        <div class="container">
            <div class="col-md-4 content-center">
                <div class="card card-login card-plain">
                    <form class="form" method="post" action="">
                        <div class="header header-primary text-center">
                            <div class="logo-container">
                                <img src="dashboard/assets/img/now-logo.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-unlock"></i>
                                </span>
                                <input type="password" placeholder="Password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="btn_login" class="btn btn-primary btn-round btn-lg">Log In</button>
                            <a href="register_customer.php"><button type="button" class="btn btn-info btn-round btn-lg">Sign Up</button></a>
                            <button type="button" class="btn btn-danger btn-round btn-lg" onclick="goBack()">Cancel</button>
                            <script>
                                function goBack() {
                                    window.history.back();
                                }
                            </script>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <ul>
                        <li>
                            <a href="../new">
                            <?php echo $company_name; ?>
                            </a>
                        </li>
                        <li>
                            <a href="about_us.php">
                                About Us
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    innovated by <abbr title="Muhammad Amir Nashrullah">acoyy</abbr>&nbsp;
                    &copy; &nbsp;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </div>
            </div>
        </footer>
    </div>
</body>
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
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


</html>
<?php
}
?>