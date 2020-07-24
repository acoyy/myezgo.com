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

           if (isset($btn_save)) { 

            func_setValid("Y"); 
            func_isEmpty($newpassword, "newpassword"); 

           if (func_isValid()) { 

            if($_GET['newpassword'] == $_GET['verify']) { 

            $sql = "UPDATE user SET password = '$newpassword' WHERE id =" . $_SESSION['cid']; 

            db_update($sql); 

            echo "<script>alert('Password Updated')</script>"; 

            vali_redirect('settings.php'); 

              } 

              } 

              } 

          else { 

              $sql = "SELECT * FROM user WHERE id=" . $_SESSION['cid']; db_select($sql); 

              if (db_rowcount() > 0) { 

                  func_setSelectVar(); 

              } 

              } 
              ?>

           

          <!-- page content -->
          <div class="right_col" role="main">
            <div class="">

            <div class="page-title">
                <div class="title_left">
                  <h3>Settings</h3>
                </div>

                
              </div>

              <div class="clearfix"></div>
              <div class="row">
             
                            <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Settings</h2>
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
                      
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">


                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_account" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Account</a>
                          </li>

                          <?php if($occupation == 'Admin' || $occupation == 'Manager'){ ?>
                          

                            <li role="presentation" class=""><a href="#tab_company" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Company</a>
                            </li>


                          <?php } ?>


                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_account" aria-labelledby="home-tab">
                      
                      <br>

                      <form data-parsley-validate class="form-horizontal form-label-left"  method="POST" >

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="text" 
                            name="description" 
                            required="required" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $username; ?>" disabled>
                          </div>
                        </div>
                        
                        

                        


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            type="text" 
                            name="description" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $name; ?>"
                            disabled>
                          </div>
                        </div>




                        <div class="form-group">
                          <label for="occupation" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            class="form-control col-md-7 col-xs-12" 
                            type="text" 
                            name="middle-name"
                            value="<?php echo $occupation; ?>" 
                            disabled>
                          </div>
                        </div>



                        <div class="form-group">
                          <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            class="form-control col-md-7 col-xs-12" 
                            type="password" 
                            name="newpassword"
                            value="<?php echo $newpassword; ?>"
                            required>
                          </div>
                        </div>

                <div class="form-group">
                  <label for="passwordconf" class="control-label col-md-3 col-sm-3 col-xs-12">Password Confirmation</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input 
                    class="form-control col-md-7 col-xs-12" 
                    type="password" 
                    name="verify"
                    value="<?php echo $verify; ?>"
                    required>
                  </div>
                </div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                          <div class="ln_solid"></div>


                            <button type="submit" name="btn_save" class="btn btn-success">Submit</button>
                          </div>
                        </div>

                      </form>
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_company" aria-labelledby="profile-tab">
                  

          <?php 

          if (isset($btn_update)) { 

            if (isset($_FILES['image'])) { 

              $upload_dir = "assets/img/"; 

              $file_name = basename($_FILES["image"]["name"]);

              $target_file = $upload_dir . $file_name;

              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "<script> alert('The file has been uploaded.'); </script>";
              } 
              else {

                echo "<script> alert('No files being uploaded.'); </script>";
              }
              // Check if image file is a actual image or fake image

            }

            $sql = "UPDATE company 
                      SET image = '$file_name',
                      company_name = '$company_name', 
                      website_name = '$website_name',
                      registration_no = '$registration_no', 
                      address = '$address', 
                      phone_no = '$phone_no',
                      email = '$email'
                      WHERE id IS NOT NULL"; 

            db_update($sql); 

            echo '<script language="javascript"> alert("Information updated!"); </script>'; 

            vali_redirect('settings.php'); 
          } 
          else { 

            $sql = "SELECT * FROM company WHERE id IS NOT NULL"; 

            db_select($sql); 

            if (db_rowcount() > 0) { 
              func_setSelectVar(); 
            } 
          } ?>         

                  <form data-parsley-validate class="form-horizontal form-label-left"  method="POST" enctype="multipart/form-data">
        

                  <div class="form-group">
                  <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="btn btn-small btn-default" type="file" name="image">
                  </div>
                </div>



                   <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_name">Company Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="text" 
                            name="company_name" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $company_name; ?>" required>
                          </div>
                        </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website_name">Website Name <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="text" 
                            name="website_name" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $website_name; ?>" required>
                          </div>
                        </div> 


                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="registration_no">Registration Number <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="text" 
                            name="registration_no" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $registration_no; ?>" required>
                          </div>
                        </div> 

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="text" 
                            name="address" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $address; ?>" required>
                          </div>
                        </div> 

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_no">Phone Number <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="number" 
                            name="phone_no" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $phone_no; ?>" required>
                          </div>
                        </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input
                            type="email" 
                            name="email" 
                            class="form-control col-md-7 col-xs-12" 
                            value="<?php echo $email; ?>" required>
                          </div>
                        </div> 


                       <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                            <div class="ln_solid"></div>


                            <?php  
                              $sql = "SELECT * FROM company WHERE id IS NOT NULL"; 
                              
                              db_select($sql); 

                              if(db_rowcount() > 0) { 

                                echo "<button type='submit' class='btn btn-success' name='btn_update'>Update</button>"; 
                              } 
                              else {

                                echo "<button type='submit' class='btn btn-success' name='btn_save'>Save</button>"; 
                              } 
                            ?>

                          </div>
                        </div>




            </form>

                          </div>

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