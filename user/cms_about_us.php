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

          if (isset($_FILES['image'])) { 

          $errors = array(); 

          $file_name = $_FILES['image']['name']; 

          $file_size = $_FILES['image']['size']; 

          $file_tmp = $_FILES['image']['tmp_name']; 

          $file_type = $_FILES['image']['type']; 

          $file_ext = strtolower(end(explode('.', $_FILES['image']['name']))); 
          $expensions = array("jpeg", "jpg", "png"); 

          if (in_array($file_ext, $expensions) === false) { 

          $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

          } 

          if ($file_size > 2097152) { 

          $errors[] = 'File size must be excately 2 MB'; 

          } 

          if (empty($errors) == true) { 

          move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $file_name); 

          echo "Success"; 

          } else 

          { 

          print_r($errors); 

          } 

          } 

          if(isset($btn_save)){ 

          func_setValid("Y"); 

          if (func_isValid()) { 

          $sql = "UPDATE about_us 
          SET 
          introduction_title = '$introduction_title',
          introduction_subtitle = '$introduction_subtitle',
          introduction_desc = '$introduction_desc',
          introduction_img = '$file_name',
          services_title = '$services_title',
          services_subtitle = '$services_subtitle',
          services_desc = '$services_desc',
          box1_title = '$box1_title',
          box1_desc = '$box1_desc',
          box2_title = '$box2_title',
          box2_desc = '$box2_desc',
          box3_title = '$box3_title',
          box3_desc = '$box3_desc',
          box4_title = '$box4_title',
          box4_desc = '$box4_desc'
          WHERE id = 1"; 

          db_update($sql); 
          echo "<script>alert('Updated')</script>"; 

          vali_redirect('cms_about_us.php'); 

              } 

          } 

          else { 

          $sql = "SELECT * FROM about_us WHERE id = 1"; 

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
                  <h3>About Us Customization</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>About Us Customization</h2>
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




                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="introduction_title" 
                            type="text" 
                            id="introduction_title" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $introduction_title; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="introduction_subtitle">Subtitle <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="introduction_subtitle"
                            type="text" 
                            id="introduction_subtitle" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $introduction_subtitle; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="introduction_subtitle">Description <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="introduction_desc"
                            type="text" 
                            id="introduction_desc" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $introduction_desc; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                          <input class="btn btn-small btn-default" type="file" name="image">

                          </div>
                        
                        </div>

                        <br>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                          <h4>Our Services</h4>

                          </div>
                        
                        </div>

                        

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="services_title">Title <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="services_title"
                            type="text" 
                            id="services_title" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $services_title; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="services_subtitle">Subtitle <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="services_subtitle"
                            type="text" 
                            id="services_subtitle" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $services_subtitle; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="services_desc">Description <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="services_desc"
                            type="text" 
                            id="services_desc" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $services_desc; ?>"
                            required>
                            </div>
                        </div>

                  <br>

                  <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                           <h4>Boxes One</h4>

                          </div>
                        
                        </div>


                  <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box1_title">Title <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box1_title"
                            type="text" 
                            id="box1_title" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box1_title; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box1_desc">Description <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box1_desc"
                            type="text" 
                            id="box1_desc" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box1_desc; ?>"
                            required>
                            </div>
                        </div>

                      <br>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                           <h4>Boxes Two</h4>

                          </div>
                        
                        </div>

                      

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box2_title">Title <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box2_title"
                            type="text" 
                            id="box2_title" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box2_title; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box2_desc">Description <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box2_desc"
                            type="text" 
                            id="box2_desc" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box2_desc; ?>"
                            required>
                            </div>
                        </div>

                        <br>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                           <h4>Boxes Three</h4>

                          </div>
                        
                        </div>

                        

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box3_title">Title <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box3_title"
                            type="text" 
                            id="box3_title" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box3_title; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box3_desc">Description <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box3_desc"
                            type="text" 
                            id="box3_desc" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box3_desc; ?>"
                            required>
                            </div>
                        </div>

                      <br>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                           <h4>Boxes Four</h4>

                          </div>
                        
                        </div>

                     

                     <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box4_title">Title <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box4_title"
                            type="text" 
                            id="box4_title" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box4_title; ?>"
                            required>
                            </div>
                        </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="box4_desc">Description <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input 
                            name="box4_desc"
                            type="text" 
                            id="box4_desc" 
                            class="form-control col-md-7 col-xs-12"
                            value="<?php echo $box4_desc; ?>"
                            required>
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                          <iframe id='frame' src="../../about_us.php" width="100%" height="1750px" ></iframe>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">



                          <div class="ln_solid"></div>


                            <button type="submit" name="btn_save" class="btn btn-success">Submit</button>
                          </div>
                        </div>

                         




                  <!--               

                      <div class="form-group">
                          <label class="control-label">Description</label>
                          <input class="form-control" name="box4_desc" value="<?php echo $box4_desc; ?>">
                      </div>

                  -->


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

<?php
} 
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>