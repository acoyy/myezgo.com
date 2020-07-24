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
func_isEmpty($description, "description"); 
func_isEmpty($calculation, "calculation"); 
func_isEmpty($amount, "amount"); 
func_isEmpty($amount, "amount_type"); 
func_isEmpty($taxable, "taxable"); 

if (func_isValid()) { 

$sql = "INSERT INTO
option_rental
(
description,
calculation,
amount,
taxable,
mid,
cid,
amount_type,
mdate,
cdate
)
VALUES
(
'" . conv_text_to_dbtext3($description) . "',
'" . $calculation . "',
" . $amount . ",
'" . $taxable . "',
" . $_SESSION['cid'] . ",
" . $_SESSION['cid'] . ",
'" . $amount_type . "',
CURRENT_TIMESTAMP,
CURRENT_TIMESTAMP
)"; 

db_update($sql); 

vali_redirect("rental_options.php?btn_search=Search&page=" . $page . "&search_rental_description=" . $search_rental_description); 


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
<h3>Add Rental Options</h3>
</div>


</div>

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Add Rental Options</h2>
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
<option value='O' <?php echo vali_iif( 'O'==$calculation, 'Selected', ''); ?>>One Time</option>
<option value='H' <?php echo vali_iif( 'H'==$calculation, 'Selected', ''); ?>>Per Hour</option>
<option value='H8' <?php echo vali_iif( 'H8'==$calculation, 'Selected', ''); ?>>Per 8 Hour</option>
<option value='D' <?php echo vali_iif( 'D'==$calculation, 'Selected', ''); ?>>Per Day</option>
<option value='P' <?php echo vali_iif( 'P'==$calculation, 'Selected', ''); ?>>Per Person</option>
<option value='F5' <?php echo vali_iif( 'F'==$calculation, 'Selected', ''); ?>>Free (If missing, RM5)</option>
<option value='F50' <?php echo vali_iif( 'F50'==$calculation, 'Selected', ''); ?>>Free (If missing, RM50)</option>
<option value='F150' <?php echo vali_iif( 'F150'==$calculation, 'Selected', ''); ?>>Free (If missing, RM150)</option>
<option value='R300' <?php echo vali_iif( 'R300'==$calculation, 'Selected', ''); ?>>RM30 (If missing, RM300)</option>
</select>
</div>
</div>

<div class="form-group">
<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Amount Type</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="amount_type" class="form-control">
<option value='P' <?php echo vali_iif( 'P'==$calculation, 'Selected', ''); ?>>Percent</option>
<option value='RM' <?php echo vali_iif( 'RM'==$calculation, 'Selected', ''); ?>>RM</option>
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
<button type="submit" class="btn btn-success" name="btn_save">Save & Next</button>
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