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

  $id = $_GET['id'];

  if ($_FILES['image']['size'] > 0) {
  	$errors = array();
  	$file_name = $_FILES['image']['name'];
  	$file_size = $_FILES['image']['size'];
  	$file_tmp = $_FILES['image']['tmp_name'];
  	$file_type = $_FILES['image']['type'];
  	$file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

  	$expensions = array("jpeg", "jpg", "png");

  	if (in_array($file_ext, $expensions) === false) {
  		$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
  	}

  	if ($file_size > 2097152) {
  		$errors[] = 'File size must be excately 2 MB';
  	}

  	if (empty($errors) == true) {
  		move_uploaded_file($file_tmp, "assets/img/class/" . $file_name);
  	} else {
  		print_r($errors);
  	}

    $imagequery = "class_image='$file_name',";
  }
  else
  {
    $imagequery = "";
  }

  if (isset($btn_save)) {

  	func_setValid("Y");
  	func_isEmpty($status, "status");
  	if (func_isValid()) {

  		$sql = "UPDATE 
  			class SET 
  			class_name='$class_name',
  			".$imagequery."
  			desc_1='$desc_1',
  			desc_2='$desc_2',
  			desc_3='$desc_3',
  			desc_4='$desc_4',
  			people_capacity = '$people_capacity',
  			baggage_capacity = '$baggage_capacity',
  			doors = '$doors',
  			air_conditioned = '$air_conditioned',
  			max_weight = '$max_weight',
  			transmission = '$transmission',
  			status='$status',
  			mid=" . $_SESSION['cid'] . ", 
  			mdate=CURRENT_TIMESTAMP 
  			WHERE id=" . $_GET['id'];

  		db_update($sql);
  		vali_redirect("manage_rate.php?id=$id");
  	}

  } else {

  	$sql = "SELECT id, class_name, desc_1, desc_2, desc_3, desc_4, case status when 'A' then 'Active' when 'I' then 'Inactive' end as status, people_capacity, baggage_capacity, doors, air_conditioned, max_weight, transmission from class where id=" . $_GET['id'];
  	db_select($sql);

  	if (db_rowcount() > 0) {
  		for ($i = 0; $i < db_rowcount(); $i++) {
  			func_setSelectVar($i);
  		}
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
                  <h3>Edit Classes</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Classes</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_name">Class Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="class_name" value="<?php echo $class_name; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="btn btn-info" type="file" name="image">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="people_capacity" class="control-label col-md-3 col-sm-3 col-xs-12">People Capacity</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="people_capacity" value="<?= $people_capacity; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="baggage_capacity" class="control-label col-md-3 col-sm-3 col-xs-12">Baggage Capacity</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="baggage_capacity" value="<?= $baggage_capacity; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="vehicle_door" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Door</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="vehicle_door" value="<?= $doors; ?>">
                          </div>
                        </div>
    					  <div class="form-group">
                          <label for="max_weight" class="control-label col-md-3 col-sm-3 col-xs-12">Maximum Weight</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="max_weight" value="<?= $max_weight; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="vehicle_door" class="control-label col-md-3 col-sm-3 col-xs-12">Air Conditioned</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" value="Y" name="air_conditioned" <?php echo vali_iif('Y' == $air_conditioned, 'Checked', ''); ?>> 
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="transmission" class="control-label col-md-3 col-sm-3 col-xs-12">Transmission</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="transmission" class="form-control">
                                              <option value='A' <?php echo vali_iif('A' == $transmission, 'Selected', ''); ?>>Automatic</option>
                                              <option value='M' <?php echo vali_iif('M' == $transmission, 'Selected', ''); ?>>Manual</option>
                                          </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="desc_1" class="control-label col-md-3 col-sm-3 col-xs-12">Description One</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="desc_1" value="<?php echo $desc_1; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="desc_2" class="control-label col-md-3 col-sm-3 col-xs-12">Description Two</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="desc_2" value="<?php echo $desc_2; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="desc_3" class="control-label col-md-3 col-sm-3 col-xs-12">Description Three</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="desc_3" value="<?php echo $desc_3; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="desc_4" class="control-label col-md-3 col-sm-3 col-xs-12">Description Four</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="desc_4" value="<?php echo $desc_4; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control">
  									<option value='A' <?php echo vali_iif('A' == $status, 'Selected', ''); ?>>Active</option>
  									<option value='I' <?php echo vali_iif('I' == $status, 'Selected', ''); ?>>In-Active</option>
  								</select>
                          </div>
                        </div>
                        
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="btn_save">Submit</button>
                          <button class="btn btn-primary" type="button">Cancel</button>
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