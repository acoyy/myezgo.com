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

func_isEmpty($description, "location description"); 

func_isEmpty($status, "status"); 

if ($default == "D") { 

$sql = "SELECT * from location WHERE `default`='D'"; 

db_select($sql); 

if (db_rowcount() > 0) { 

func_setErrMsg("- Invalid default location"); 

} 

} 



if (func_isValid()) { 

$sql = "UPDATE location SET 
description = '" . conv_text_to_dbtext3($description) . "', 
status = '" . $status . "',
address =  '".$address."', 
latitude = '".$latitude."',
longitude = '".$longitude."',
cid = '" . $_SESSION['cid'] . "', 
cdate = CURRENT_TIMESTAMP,
radius = '".$radius."' 
WHERE id =".$_GET['id'];

db_update($sql); 

vali_redirect("manage_location.php"); 

} 

} 

else if (isset($btn_delete)) { 

$sql = "DELETE from location WHERE id = " . $_GET['id']; 

db_update($sql); 

vali_redirect("manage_location.php"); 

} else { 

$sql = "SELECT * FROM location WHERE id=" . $_GET['id']; 

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
<h3>Edit Location</h3>
</div>


</div>

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Edit Location</h2>
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
<button type="button" class="btn btn-primary" onclick="location.href='manage_location.php'" name="btn_cancel">Cancel</button>

</div>
</div>




</form>
</div>
</div>

<!-- start new edit -->

<div class="x_panel">

<div class="x_title">
<h2>Location Point</h2>
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

<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Price</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
func_setPage(); 
func_setOffset(); 
func_setLimit(10); 

if (isset($btn_search)) { 

if ($search_description != "") { 

$where = " AND description like '%" . $search_description . "%'"; 

} 

} 

$sql = "SELECT id, name, price,  case status when 'A' then 'Active' when 'I' then 'Inactive' end as status from location_point where location_id=". $_GET['id'];

db_select($sql); 

func_setTotalPage(db_rowcount()); 

db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

if(db_rowcount()>0){

for($i=0;$i<db_rowcount();$i++){

if(func_getOffset()>=10){ 

$no=func_getOffset()+1+$i; 

} 

else{ 

$no=$i+1; 

} 

echo "<tr>
<th scope='row'>" . $no . "</th>
<td>" . db_get($i, 1) . "</td>
<td>" . db_get($i, 2) . "</td>
<td>" . db_get($i, 3) . "</td>
<td><a href='manage_location_point_edit.php?id=".db_get($i,0)."&location_id=". $_GET['id']."'><i class='fa fa-pencil'></i></a>
&nbsp;&nbsp; 

<a href='delete_location_point.php?id=".db_get($i,0)."&location_id=". $_GET['id']."' onClick='return confirm(\"Delete this?\")'><i class='fa fa-trash'></i></a></td>
<td style='display:none'>               
<div id='".db_get($i,7)."' style='display:none;width:800px' class='card__body'>
<img src='img/".db_get($i,8)."'>
</div>
</td>
</tr>";



}

} else{ echo "<tr><td colspan='8'>No records found</td></tr>"; }


?>

<tr>
<td colspan="8" align="center">
<div class="form-group">
<button type="button" class="btn btn-info" name="btn_save" onclick="location.href='manage_location_point_new.php?location_id=<?php echo $_GET['id']; ?>'">Add New</button>
</div>
</td>
</tr>

<tr>
<td colspan="8" style="text-align:center">
<?php  func_getPaging('manage_job.php?x&search_vehicle='.$search_vehicle); ?>
</td>
</tr>

</tbody>
</table>


</div>

</div>

<!-- end new edit -->

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
?>]]