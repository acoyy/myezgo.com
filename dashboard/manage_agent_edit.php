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

      $id = $_GET['id']; 
      $sql="UPDATE agent SET 
          company_name = '$company_name', 
          name = '$name', 
          address = '$address', 
          state = '$state', 
          city = '$city', 
          zipcode = '$zipcode', 
          country = '$country',
          modified = '".date('Y-m-d H:i:s',time())."',
          mid = '".$_SESSION['cid']."'
          WHERE id = '$id'"; 

      db_update($sql);
      vali_redirect('manage_agent.php?btn_search=&search_name='.$search_name.'&page='.$page); 

      } 

   else if(isset($btn_delete)){ 

      $sql = "DELETE from agent WHERE id = ".$_GET['id']; 
      db_update($sql); 
      vali_redirect("manage_agent.php?btn_search=Search&page=".$page."&search_vehicle=".$search_vehicle); 

          }

   else{ 

      $sql = "SELECT * FROM agent WHERE id=".$_GET['id']; 
      db_select($sql); 

   if(db_rowcount()>0){ 

      func_setSelectVar(); 

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
                  <h3>Edit Manage</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Manage</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_name">Company Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="company_name" value="<?php echo $company_name; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="address" value="<?php echo $address;?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="state" value="<?php echo $state;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="city" value="<?php echo $city;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="zipcode" class="control-label col-md-3 col-sm-3 col-xs-12">Zip Code</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="zipcode" value="<?php echo $zipcode; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="country" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="country" value="<?php echo $country; ?>">
                          </div>
                        </div>
                        


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="button" onclick="goBack()">Cancel</button>
                            <script>
                                function goBack() {
                                    window.history.back();
                                }
                            </script>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
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