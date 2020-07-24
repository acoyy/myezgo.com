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

  <?php

   include("_header.php"); 

   func_setReqVar(); 

  if(isset($_POST['btn_save'])){ 

      func_setValid("Y"); 
      func_isEmpty($username, "username"); 
      func_isEmpty($name, "name"); 
      func_isEmpty($password, "password"); 
      func_isEmpty($retype_password, "retype_password"); 
      func_isEmpty($occupation, "occupation"); 
      func_isEmpty($branch, "branch"); 
      if($branch =='')
      {

        echo "<script> alert('You have not selected the branch'); </script>";
      }

      if(func_isValid()){ 

        $sql="INSERT INTO user
             (
             username,
             name,
             password,
             occupation,
             branch,
             status,
             dp
             )
             VALUES
             (
             '".conv_text_to_dbtext3($username)."', 
             '".conv_text_to_dbtext3($name)."',
             '".conv_text_to_dbtext3($password)."',
             '".conv_text_to_dbtext3($occupation)."',
             '".conv_text_to_dbtext3($branch)."',
             'Active',
             'defaultUsr.png'
             )";
              
        db_update($sql); 
        
        vali_redirect('manage_user.php');
      }

  }

       ?>

    <body class="nav-md">
      <div class="container body">
        <div class="main_container">

          <?php include('_leftpanel.php'); ?>

          <?php include('_toppanel.php'); ?>

          <!-- page content -->
          <div class="right_col" role="main">
            <div class="">

            <div class="page-title">
                <div class="title_left">
                  <h3>Add User</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add User</h2>
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
                      <form data-parsley-validate class="form-horizontal form-label-left" method="POST">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="username">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Full Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" class="form-control" name="name">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="password" class="form-control col-md-7 col-xs-12" type="password" name="password">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="retype_password" class="control-label col-md-3 col-sm-3 col-xs-12">Retype Password</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="retype_password" class="form-control col-md-7 col-xs-12" type="password" name="retype_password">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Branch</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="branch" class="form-control">
                               
                               <?php
                               
                               $sql = "SELECT description from location"; 
                               db_select($sql); 

                            if(db_rowcount()>0){ 

                              for($j=-1;$j<db_rowcount();$j++){ 

                                  if($j=='-1'){

                                      $value = $value."<option value=''>-- select branch --</option>";
                                  }

                                  else{

                                      $value = $value."<option value='".db_get($j,0)."'>".db_get($j,0)."</option>";
                                  } 
                              }
                            } 

                              echo $value; ?>
                              </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Occupation
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           <select name="occupation" class="form-control">
                                      <option <?php echo vali_iif('Manager'==$occupation,'Selected','');?> value='Manager'>Manager</option>
                                      <option <?php echo vali_iif('Branch Manager'==$occupation,'Selected','');?> value='Branch Manager'>Branch Manager</option>
                                      <option <?php echo vali_iif('Sales'==$occupation,'Selected','');?> value='Sales'>Sales</option>
                                      <option <?php echo vali_iif('Operation Staff'==$occupation,'Selected','');?> value='Operation Staff'>Operation Staff</option>
                                      <option <?php echo vali_iif('Sale Operation'==$occupation,'Selected','');?> value='Sale Operation'>Sale / Operation</option>
                                  </select>
                          </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                       <input type="submit" class="btn btn-success" name="btn_save" value="Save">
  <button type="button" class="btn btn-primary" onclick="location.href='manage_user.php'" name="btn_cancel">Cancel</button>                        </div>
                        </div>

                      </form>
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
  <script>
    var password = document.getElementById("password")
      , retype_password = document.getElementById("retype_password");

    function validatePassword(){
      if(password.value != retype_password.value) {
        retype_password.setCustomValidity("Passwords Don't Match");
      } else {
        retype_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    retype_password.onkeyup = validatePassword;
  </script>
<?php  
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>