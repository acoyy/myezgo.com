<?php
session_start();
if(isset($_SESSION['cid']))
{ 
  $idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out
  
  if (time()-$_SESSION['timestamp']>$idletime){
    session_unset();
    session_destroy();
    echo "<script> alert('You have been logged out due to inactivity'); </script>";
                echo "<script>
                        window.location.href='index.php';
                    </script>";
  }else{
    $_SESSION['timestamp']=time();
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <?php include('_header.php'); ?>

    <body class="nav-md">
      <div class="container body">
        <div class="main_container">

          <?php include('_leftpanel.php'); ?>

          <?php include('_toppanel.php'); 



          if(isset($btn_save)){ 

          func_setValid("Y"); 

          if (func_isValid()) { 

          $sql = "UPDATE privacy_policy 
          SET 
          content = '$htmlcontent'
          WHERE id = 1"; 

          db_update($sql); 
          echo "<script>alert('Updated')</script>"; 

          vali_redirect('cms_privacy_policy.php'); 

              } 

          } 

          else { 

          $sql = "SELECT content FROM privacy_policy WHERE id = 1"; 

          db_select($sql); 

          if (db_rowcount() > 0) { 

          func_setSelectVar(); 

          } 
          
          } ?>



          <!-- page content -->
          <div class="right_col" role="main">
            <div class="">

            <div class="page-title">
                <div class="title_left">
                  <h3>Privacy Policy Customization</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Privacy Policy Customization</h2>
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
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


<body>

<div ng-app="textAngularTest" ng-controller="wysiwygeditor" class="container app">
  <div text-angular="text-angular" name="htmlcontent" ng-model="htmlcontent" ta-disabled='disabled'></div>

  <button type="button" ng-click="htmlcontent = orightml">Reset</button>


</div>


  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.4/angular.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.4/angular-sanitize.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/textAngular/1.1.2/textAngular.min.js'></script>

</body>

</html>

<style type="text/css">
  
  .ta-editor {
  min-height: 300px;
  height: auto;
  overflow: auto;
  font-family: inherit;
  font-size: 100%;
}


</style>

<script type="text/javascript">
  
    angular.module("textAngularTest", ['textAngular']);
  function wysiwygeditor($scope) {
    $scope.orightml = '<?php echo db_get(0, 0); ?>';
    $scope.htmlcontent = $scope.orightml;
    $scope.disabled = false;
  };

</script>





                          <div class="ln_solid"></div>


                            <button type="submit" name="btn_save" class="btn btn-success">Submit</button>
                          </div>
                        </div>

        



                      </form>

                      <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                            <iframe id='frame' src="../privacy_policy.php" width="100%" height="800" ></iframe>
                            </div>
                          </div>
                    </div>
                  </div>


      


                </div>
              </div>



            </div>
          </div>
          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>


    </body>
  </html>

<?php
} 
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>