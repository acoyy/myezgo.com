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

   if(isset($btn_save)){ 

   $id = $_GET['id']; 
   $sql="UPDATE user SET 
        username = '$username', 
        name = '$name', 
        occupation = '$occupation', 
        branch = '$branch', 
        status = '$status' 
        WHERE id = '$id'"; 
        db_update($sql); 
        vali_redirect('manage_user.php?btn_search=&search_name='.$search_name.'&page='.$page);

         } 

   else if(isset($btn_delete)){ 

   $sql = "DELETE from user WHERE id = ".$_GET['id']; 
   db_update($sql); 
   vali_redirect("manage_user.php?btn_search=Search&page=".$page."&search_vehicle=".$search_vehicle); 

          } 

   else{ 

   $sql = "SELECT * FROM user WHERE id=".$_GET['id']; 

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
                  <h3>Edit User</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit User</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="username" value="<?php echo $username;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Full Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="occupation" class="form-control">
                                      <option <?php echo vali_iif('Admin'==$occupation,'Selected','');?> value='Admin'>Admin</option>
                                      <option <?php echo vali_iif('Manager'==$occupation,'Selected','');?> value='Manager'>Manager</option>
                                      <option <?php echo vali_iif('Executive'==$occupation,'Selected','');?> value='Executive'>Executive</option>
                                      <option <?php echo vali_iif('Sale Executive'==$occupation,'Selected','');?> value='Sale Executive'>Sale Executive</option>
                                      <option <?php echo vali_iif('Operation Staff'==$occupation,'Selected','');?> value='Operation Staff'>Operation Staff</option>
                                  </select>
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

                              for($j=0;$j<db_rowcount();$j++){ 

                                  $value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$branch,'Selected','').">".db_get($j,0)."&nbsp;&nbsp;".db_get($j,1)."</option>";
                                      } 

                                  } 

                              echo $value; ?>
                              </select>
                          </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='manage_user.php?btn_search=&search_name=<?php echo $search_name;?>&page=<?php echo $page;?>'" name="btn_cancel">Cancel</button>
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