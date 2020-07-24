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
include ('_header.php'); 

func_setReqVar(); 

if (isset($btn_save)) { 

func_setValid("Y"); 


func_isEmpty($status, "status"); 


if (func_isValid()) { 

$sql = "UPDATE location_point SET  
location_id = '" . $_GET['location_id'] . "',
cid =  '".$_SESSION['cid']."', 
name = '".$nameLocation."',
price = '".$price."',
cid = '" . $_SESSION['cid'] . "', 
status = '".$status."',
date_created = CURRENT_TIMESTAMP,
date_updated = CURRENT_TIMESTAMP
WHERE id =".$_GET['id'];

db_update($sql); 

vali_redirect("manage_location_edit.php?id=". $_GET["location_id"]); 

} 

} 

else if (isset($btn_delete)) { 

$sql = "DELETE from location WHERE id = " . $_GET['id']; 

db_update($sql); 

vali_redirect("manage_location.php"); 

} else { 

$sql = "SELECT * FROM location_point WHERE id=" . $_GET['id']; 

db_select($sql); 

if (db_rowcount() > 0) { 

func_setSelectVar(); 

} 

} ?>

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
<h3>Edit Location Point</h3>
</div>


</div>

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Edit Location Point</h2>
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
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Name
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" name="nameLocation" value="<?php echo $name; ?>">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Price
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input class="form-control" name="price" value="<?php echo $price; ?>">
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

<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<button type="submit" class="btn btn-success" name="btn_save">Submit</button>
<button type="button" class="btn btn-primary" onclick="location.href='manage_location_edit.php?id=<?php echo $_GET['location_id']; ?>'" name="btn_cancel">Cancel</button>



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