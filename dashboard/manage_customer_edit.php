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

   if($_FILES["image"]["name"] != ""){ 

   	$file_name = date("Ymd")."_". basename($_FILES["image"]["name"]); 
   	$target_path = "assets/img/" .$file_name; $file = "image = '".$file_name."',"; 

   		}

   else{ 

   	$file = ""; 

   	} 

   if (($_FILES["image"]["type"] == "") || ($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/jpg") || ($_FILES["image"]["type"] == "image/pjpeg") || ($_FILES["image"]["type"] == "image/x-png") || ($_FILES["image"]["type"] == "image/png")){ 

   	move_uploaded_file($_FILES["image"]["tmp_name"], $target_path); 

   		}

   else{ 

   	func_setErrMsg("- File is not a valid image file"); 

   	} 

   if(isset($btn_save)){ 

   	func_setValid("Y"); 
   	func_isEmpty($nric_no, "nric no"); 
   	func_isEmpty($title, "title"); 
   	func_isEmpty($firstname, "first name"); 
   	func_isEmpty($lastname, "last name"); 
   	func_isEmpty($license_no, "license no"); 
   	func_isEmpty($age, "age"); 
   	func_isNum($age, "age"); 
   	func_isEmpty($phone_no, "phone no"); 
   	func_isEmpty($postcode, "postcode"); 
   	func_isEmpty($city, "city"); 
   	func_isEmpty($country, "country"); 

   if(func_isValid()){ 

    if($status == 'B')
    {

      $sql="UPDATE customer
        SET 
          firstname = '".conv_text_to_dbtext3($firstname)."',
        address = '".conv_text_to_dbtext3($address)."',
        postcode = '".conv_text_to_dbtext3($postcode)."',
        city = '".conv_text_to_dbtext3($city)."',
        country = '".conv_text_to_dbtext3($country)."',
        status = '".$status."',
        reason_blacklist = '".$reason_blacklist."',
        date_blacklist = '".date('Y-m-d H:i:s',time())."',
        cid_blacklist = '".$_SESSION['cid']."',
        mid = ".$_SESSION['cid'].",
        mdate = CURRENT_TIMESTAMP,
        title = '".conv_text_to_dbtext3($title)."', 
        lastname = '".conv_text_to_dbtext3($lastname)."',
        age = ".$age.",
        phone_no = '".conv_text_to_dbtext3($phone_no)."',
        email = '".conv_text_to_dbtext3($email)."',
        ref_name = '".conv_text_to_dbtext3($ref_name)."',
        ref_phoneno = '".conv_text_to_dbtext3($ref_phoneno)."',
        ".$file."
        nric_no = '".conv_text_to_dbtext3($nric_no)."',
        license_no = '".conv_text_to_dbtext3($license_no)."',
        gl_code = '".$gl_code."' 
        WHERE id = ".$_GET['id']; 
    }
    else
    {

   	  $sql="UPDATE customer
  		  SET 
  	      firstname = '".conv_text_to_dbtext3($firstname)."',
  		  address = '".conv_text_to_dbtext3($address)."',
  		  postcode = '".conv_text_to_dbtext3($postcode)."',
  		  city = '".conv_text_to_dbtext3($city)."',
  		  country = '".conv_text_to_dbtext3($country)."',
  		  status = '".$status."',
        reason_blacklist = NULL,
        date_blacklist = NULL,
        cid_blacklist = NULL,
  		  mid = ".$_SESSION['cid'].",
  		  mdate = CURRENT_TIMESTAMP,
  		  title = '".conv_text_to_dbtext3($title)."', 
  		  lastname = '".conv_text_to_dbtext3($lastname)."',
  		  age = ".$age.",
  		  phone_no = '".conv_text_to_dbtext3($phone_no)."',
  		  email = '".conv_text_to_dbtext3($email)."',
  		  ref_name = '".conv_text_to_dbtext3($ref_name)."',
  		  ref_phoneno = '".conv_text_to_dbtext3($ref_phoneno)."',
  		  ".$file."
  		  nric_no = '".conv_text_to_dbtext3($nric_no)."',
  		  license_no = '".conv_text_to_dbtext3($license_no)."',
  		  gl_code = '".$gl_code."' 
  		  WHERE id = ".$_GET['id'];
      } 

  	db_update($sql); 

    echo "<script> alert('Successfully edited'); </script>";

  	vali_redirect('manage_customer.php'); 

  			} 

  		}

  	else if(isset($btn_delete)){ 

  		$sql = "DELETE from customer WHERE id = ".$_GET['id']; 
  		db_update($sql); 
  		vali_redirect("manage_customer.php"); 

  		}

  	else{ 

  		$sql = "SELECT * FROM customer WHERE id=".$_GET['id']; 
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
                  <h3>Edit Customer</h3>
                </div>

                
              </div>

              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Edit Customer</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file"  readonly="" class="form-control" name="image" value=" <?php echo $image; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">NRIC No 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="nric_no" value="<?php echo $nric_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="title" class="form-control">
          										<option <?php echo vali_iif('Mr.'==$title,'Selected','');?> value='Mr.'>Mr.</option>
          										<option <?php echo vali_iif('Mrs.'==$title,'Selected','');?> value='Mrs.'>Mrs.</option>
          										<option <?php echo vali_iif('Miss.'==$title,'Selected','');?> value='Miss.'>Miss.</option>
          									</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">First Name 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="firstname" value="<?php echo $firstname;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nric_no">Last Name 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="lastname" value="<?php echo $lastname;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="license_no">License No 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="license_no" value="<?php echo $license_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="age">Driver's Age 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="age" value="<?php echo $age;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_no">Phone No 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="phone_no" value="<?php echo $phone_no;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="email" value="<?php echo $email;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gl_code">GL Code 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="gl_code">
                							<option value="">Please Select</option>
                							<?php  

                							$sql = "SELECT code,description from gl WHERE status='A'";

                							db_select($sql); 

                							if(db_rowcount()>0){ 

                							for($j=0;$j<db_rowcount();$j++){ 

                							$value = $value."<option value='".db_get($j,0)."' ".vali_iif(db_get($j,0)==$gl_code,'Selected','').">".db_get($j,0)."&nbsp;&nbsp;".db_get($j,1)."</option>"; 

                								} 

                							} 

                							echo $value; 

                							?>
              						  </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" name="address" value="<?php echo $address;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Postcode 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="postcode" value="<?php echo $postcode;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">City 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="city" class="form-control">
          										<option <?php echo vali_iif('Perlis'==$city,'Selected','');?> value='Perlis'>Perlis</option>
          										<option <?php echo vali_iif('Kedah'==$city,'Selected','');?> value='Kedah'>Kedah</option>
          										<option <?php echo vali_iif('Pulau Pinang'==$city,'Selected','');?> value='Pulau Pinang'>Pulau Pinang</option>
          										<option <?php echo vali_iif('Perak'==$city,'Selected','');?> value='Perak'>Perak</option>
          										<option <?php echo vali_iif('Selangor'==$city,'Selected','');?> value='Selangor'>Selangor</option>
          										<option <?php echo vali_iif('Wilayah Persekutuan Kuala Lumpur'==$city,'Selected','');?> value='Wilayah Persekutuan Kuala Lumpur'>Wilayah Persekutuan Kuala Lumpur</option>
          										<option <?php echo vali_iif('Wilayah Persekutuan Putrajaya'==$city,'Selected','');?> value='Wilayah Persekutuan Putrajaya'>Wilayah Persekutuan Putrajaya</option>
          										<option <?php echo vali_iif('Melaka'==$city,'Selected','');?> value='Melaka'>Melaka</option>
          										<option <?php echo vali_iif('Negeri Sembilan'==$city,'Selected','');?> value='Negeri Sembilan'>Negeri Sembilan</option>
          										<option <?php echo vali_iif('Johor'==$city,'Selected','');?> value='Johor'>Johor</option>
          										<option <?php echo vali_iif('Pahang'==$city,'Selected','');?> value='Pahang'>Pahang</option>
          										<option <?php echo vali_iif('Terengganu'==$city,'Selected','');?> value='Terengganu'>Terengganu</option>
          										<option <?php echo vali_iif('Kelantan'==$city,'Selected','');?> value='Kelantan'>Kelantan</option>
          										<option <?php echo vali_iif('Sabah'==$city,'Selected','');?> value='Sabah'>Sabah</option>
          										<option <?php echo vali_iif('Sarawak'==$city,'Selected','');?> value='Sarawak'>Sarawak</option>
          									</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="country" class="form-control">
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
            										<option value="MT">Montana</option><option value="NE">Nebraska</option>
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
            										<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
            										<option value="NY">New York</option>
            										<option value="NC">North Carolina</option>
            										<option value="OH">Ohio</option>
            										<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
            										<option value="VT">Vermont</option><option value="VA">Virginia</option>
            										<option value="WV">West Virginia</option>
            									</optgroup>
            								</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_name">Reference Name 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="ref_name" value="<?php echo $ref_name;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_phoneno">Reference Phone No 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="ref_phoneno" value="<?php echo $ref_phoneno;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status" class="form-control" 
                            <?php if($status != 'B') echo 'id="opt" onchange="change();"'; ?> >
                              <option value='A' <?php echo vali_iif('A'==$status,'Selected','');?>>Active</option>
                              <option value='I' <?php echo vali_iif('I'==$status,'Selected','');?>>In-Active</option>
                              <option value='B' <?php echo vali_iif('B'==$status,'Selected','');?>>Blacklist</option>
                            </select>
                          </div>
                        </div>
                        <div id="opt-cont"></div>

                        <?php
                          if($status == 'B')
                          { ?>
                              <div class='form-group'>
                                <label class='control-label col-md-3 col-sm-3 col-xs-12'>Reason Blacklist</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input class='form-control' type='textbox' name='reason_blacklist' value='<?php echo $reason_blacklist; ?>' >
                                </div>
                              </div>
                              <div class='form-group'>
                                <label class='control-label col-md-3 col-sm-3 col-xs-12'>Date Blacklist</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input class='form-control' type='textbox' name='date_blacklist' value='<?php echo $date_blacklist; ?>' >
                                </div>
                              </div>
                              <div class='form-group'>
                                <label class='control-label col-md-3 col-sm-3 col-xs-12'>Blacklisted By</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input class='form-control' type='textbox' name='cid_blacklist' value='<?php echo $cid_blacklist; ?>' >
                                </div>
                              </div>
                            <?php
                          }
                        ?>


   
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                            <button class="btn btn-primary" type="button" onclick="location.href='manage_customer.php?btn_search=&search_name=<?php echo $search_name;?>&page=<?php echo $page;?>'" name="btn_cancel">Cancel</button>
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
  <script type="text/javascript">
   function change() {
          var select = document.getElementById("opt");
          var divv = document.getElementById("opt-cont");
          var value = select.value;
          if (value == "B") {
              toAppend = "<div class='form-group'><label class='control-label col-md-3 col-sm-3 col-xs-12'>Reason Blacklist</label><div class='col-md-6 col-sm-6 col-xs-12'><input class='form-control' type='textbox' name='reason_blacklist'></div></div>"; divv.innerHTML=toAppend; return;
              }
          if (value == "A") {
              toAppend = ""; divv.innerHTML=toAppend; return;
              }
          if (value == "I") {
              toAppend = ""; divv.innerHTML=toAppend; return;
              }
       }
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