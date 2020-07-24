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
   include('_header.php'); 
   func_setReqVar(); 


   if(isset($btn_save)){ 

      func_setValid("Y"); 

      func_isEmpty($description, "location description"); 

      func_isEmpty($status, "status"); 

      if($default == "D"){ 

          $sql = "SELECT * from location WHERE `default`='D'"; 

          db_select($sql); 

      if(db_rowcount()>0){ 

          func_setErrMsg("- Invalid default location");

           }

            } 

      if(func_isValid()){ $sql="INSERT INTO 
              location
              (
              description, 
              status,  
              `default`, 
              address,
              cid, 
              cdate,
              initial,
              radius,
              latitude,
              longitude
              )
              VALUES
              (
              '$description',
              '$status',
              '$default',
              '$address',
              ".$_SESSION['cid'].",
              CURRENT_TIMESTAMP,
              '$initial',
              '$radius',
              '$latitude',
              '$longitude'
              )
              "; 

              db_update($sql); 

              vali_redirect("manage_location.php?search_description=". $_GET["search_description"]."&btn_search=Search&page=".$page); } } ?>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyDOuS7nnbLUzHgx5JSPbx7x7FCMyZ_J7fI'></script>
  <script src="assets/js/locationpicker.jquery.js"></script>
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
                  <h3>Add Location</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Location</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="description" value="<?php echo $description; ?>">
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
                              <option value='A' <?php echo vali_iif('A' == $status, 'Selected', ''); ?>>Active</option>
                              <option value='I' <?php echo vali_iif('I' == $status, 'Selected', ''); ?>>In-Active</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="address" id="address" value="<?php echo $address; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="radius" class="control-label col-md-3 col-sm-3 col-xs-12">Radius</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" id="radius" name="radius" value="<?php echo $radius; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="initial" class="control-label col-md-3 col-sm-3 col-xs-12">Initial Letter</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="initial" value="<?php echo $initial; ?>">
                        </div>
                        </div>

                        <div class="form-group">
                          <label for="latitude" class="control-label col-md-3 col-sm-3 col-xs-12">Latitude</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="latitude" id="latitude" value="<?php echo $latitude; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="longitude" class="control-label col-md-3 col-sm-3 col-xs-12">Longitude</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="longitude" id="longitude" value="<?php echo $longitude; ?>">
                          </div>
                        </div>

                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='manage_location.php?search_description=<?php echo $search_description; ?>&page=<?php echo $page; ?>'" name="btn_cancel">Cancel</button>

                          </div>
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

          <script>
      $('#location').locationpicker({
          location: {
              latitude: 2.682457,
              longitude: 101.903735
          },
          radius: 300,
          inputBinding: {
              latitudeInput: $('#latitude'),
              longitudeInput: $('#longitude'),
              radiusInput: $('#radius'),
              locationNameInput: $('#address')
          }
      });
  </script>
      <!-- Maps  -->
      <sript language="JavaScript" type="text/javascript" src="assets/js/maps.js"></sript>

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