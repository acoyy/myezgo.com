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
	
	//including the database connection file
	include("_header.php"); 

	//getting id of the data from url
	$id = $_GET['id'];

	$sql = "DELETE FROM location_point WHERE id=".$_GET['id']; 

	db_update($sql); 

	echo '<script>'; 
	echo 'alert("Location has been deleted")'; 
	echo '</script>';

	vali_redirect("manage_location_edit.php?id=".$_GET['location_id']); 

} 
else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>

