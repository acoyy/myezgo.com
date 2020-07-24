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
include "_header.php"; 
func_setReqVar(); 

if (isset($btn_save)) { 

func_setValid("Y"); 

if (func_isValid()) { 


///
 if (isset($_FILES['image'])) {
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
  		move_uploaded_file($file_tmp, "assets/img/rental_option/" . $file_name);
  		echo "Success";
  	} else {
  		print_r($errors);
  	}

  	if(!empty($file_name)){

  		  	$sql = "UPDATE option_rental SET
description = '" . conv_text_to_dbtext3($description) . "',
calculation = '" . $calculation . "',
amount = " . $amount . ",
taxable = '" . $taxable . "',
pic = '". $file_name."',
mid = " . $_SESSION['cid'] . ",
missing_cond ='". $missing_cond ."',
mdate = CURRENT_TIMESTAMP
WHERE id = " . $_GET['id']; 

db_update($sql); 

echo "<script> alert('Update Success'); </script>";


vali_redirect("rental_options.php?btn_search=Search&page=" . $page . "&search_rental_description=" . $search_rental_description); 

  	}
else{

$sql = "UPDATE option_rental SET
description = '" . conv_text_to_dbtext3($description) . "',
calculation = '" . $calculation . "',
amount = " . $amount . ",
taxable = '" . $taxable . "',
mid = " . $_SESSION['cid'] . ",
mdate = CURRENT_TIMESTAMP,
missing_cond = '". $missing_cond ."'
WHERE id = " . $_GET['id']; 

db_update($sql); 

echo "<script> alert('Update Success'); </script>";


vali_redirect("rental_options.php?btn_search=Search&page=" . $page . "&search_rental_description=" . $search_rental_description); 

}



  }


} 

} 



else { 

$sql = "SELECT id,
        description,
        calculation,
        amount,
        amount_type,
        taxable,
        pic,
		missing_cond
        FROM option_rental
        WHERE id =" . $id; 

db_select($sql); 

if (db_rowcount() > 0) { 

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
<h3>Edit Rental Options</h3>
</div>


</div>

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Edit Rental Options</h2>
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
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image 
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="btn btn-small btn-default" type="file" name="image">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="img"> 
</label>
<div class="col-md-6 col-sm-6 col-xs-12">

<img src="assets/img/rental_option/<?php echo $pic; ?>">

</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<textarea class="form-control" name="description"><?php echo $description; ?></textarea>
</div>
</div>

<div class="form-group">
<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Calculation</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="calculation" class="form-control">
<option value='One Time' <?php echo vali_iif( 'One Time'==$calculation, 'Selected', ''); ?>>One Time</option>
<option value='Per 8 Hour' <?php echo vali_iif( 'Per 8 Hour'==$calculation, 'Selected', ''); ?>>Per 8 Hour</option>
<option value='Per Day' <?php echo vali_iif( 'Per Day'==$calculation, 'Selected', ''); ?>>Per Day</option>
<option value='Per Person' <?php echo vali_iif( 'Per Person'==$calculation, 'Selected', ''); ?>>Per Person</option>
<option value='Free' <?php echo vali_iif( 'Free'==$calculation, 'Selected', ''); ?>>Free</option>

</select>
</div>
</div>


<div class="form-group">
<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Condition</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="missing_cond" class="form-control">
<option value='0' <?php echo vali_iif( '0'==$missing_cond, 'Selected', ''); ?>>None</option>
<option value='5' <?php echo vali_iif( '5'==$missing_cond, 'Selected', ''); ?>>If missing, RM5</option>
<option value='50' <?php echo vali_iif( '50'==$missing_cond, 'Selected', ''); ?>>If missing, RM50</option>
<option value='150' <?php echo vali_iif( '150'==$missing_cond, 'Selected', ''); ?>>If missing, RM150</option>
<option value='300' <?php echo vali_iif( '300'==$missing_cond, 'Selected', ''); ?>>If missing, RM300</option>

</select>
</div>
</div>



<div class="form-group">
<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Amount Type</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="amount_type" class="form-control">
<option value='P' <?php echo vali_iif( 'P'==$amount_type, 'Selected', ''); ?>>Percent</option>
<option value='RM' <?php echo vali_iif( 'RM'==$amount_type, 'Selected', ''); ?>>RM</option>
</select>
</div>
</div>

<div class="form-group">
<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Amount</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>">
</div>
</div>

<div class="form-group">
<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Taxable</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="taxable" class="form-control">
<option value='Y' <?php echo vali_iif( 'Y'==$taxable, 'Selected', ''); ?>>Yes</option>
<option value='N' <?php echo vali_iif( 'N'==$taxable, 'Selected', ''); ?>>No</option>
</select>
</div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<button type="submit" class="btn btn-success" name="btn_save">Save</button>
<button type="button" class="btn btn-primary" onclick="location.href='rental_options.php?btn_search=&search_rental_description=<?php echo $search_rental_description; ?>'">Cancel</button>

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