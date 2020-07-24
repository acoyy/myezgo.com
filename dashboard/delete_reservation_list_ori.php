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
	$agreement_no = $_GET['agreement_no'];
	$booking_id = $_GET['booking_id'];
	$delete = $_GET['delete'];

	$sql = "SELECT * FROM booking_trans where agreement_no = '$agreement_no'";

	db_select($sql);
	 
	if (db_rowcount() > 0) {

		$vehicle_id = db_get(0, 18);
		$result_booking = 'found';
	}
	else
	{
		$result_booking = 'not found';
		echo "<script> alert('agreement not found'); </script>";
		// vali_redirect("reservation_list.php");
	}

	if($delete == "true")
	{


		$sql = "SELECT * FROM checklist where booking_trans_id = '$booking_id'";

		db_select($sql); 

		if (db_rowcount() > 0) {

			$result_checklist = 'found';
		}
		else
		{
			$result_checklist = 'not found';
			echo "<script> alert('checklist not found'); </script>";
			// vali_redirect("reservation_list.php");
		}

		$sql = "SELECT id FROM sale where booking_trans_id = '$booking_id'";

		db_select($sql); 

		if (db_rowcount() > 0) {

			$result_sale = 'found';
			$sale_id = db_get(0,0);
		}
		else
		{
			$result_sale = 'not found';
			echo "<script> alert('sale not found'); </script>";
			// vali_redirect("reservation_list.php");
		}

		$sql = "SELECT * FROM sale_log where sale_id = '$sale_id'";

		db_select($sql); 

		if (db_rowcount() > 0) {

			$result_sale_log = 'found';
		}
		else
		{
			$result_sale_log = 'not found';
			echo "<script> alert('sale log not found'); </script>";
			vali_redirect("reservation_list.php");
		}

		$sql = "SELECT * FROM extend where booking_trans_id = '$booking_id'";

		db_select($sql); 

		if (db_rowcount() > 0) {

			$result_extend = 'found';
		}
		else
		{
			$result_extend = 'not found';
		}


		// if($result_booking == 'found' && $result_checklist == 'found' && $result_sale == 'found' && $result_sale_log == 'found')
		if($result_booking == 'found' && $result_checklist == 'found' && $result_sale == 'found' && $result_sale_log == 'found')
		{

			$sql = "SELECT
				MAX(id)
			    FROM booking_trans
			    where vehicle_id = '$vehicle_id'
		    ";

		    db_select($sql);

		    if(db_rowcount()>0) { 

		        for($i=0;$i<db_rowcount();$i++){
		            
		            $last_id = db_get($i,0);

		            if($booking_id == $last_id)
		            {

						$sql = "UPDATE vehicle SET availability = 'Available' WHERE id='$vehicle_id'";
						db_update($sql);
		            }
		        }
		    }

			$sql = "DELETE FROM booking_trans WHERE agreement_no='$agreement_no'";
			db_update($sql); 

			$sql = "DELETE FROM checklist WHERE booking_trans_id='$booking_id'"; 
			db_update($sql); 

			$sql = "DELETE FROM sale WHERE booking_trans_id='$booking_id'"; 
			db_update($sql); 

			$sql = "DELETE FROM sale_log WHERE sale_id='$sale_id'"; 
			db_update($sql);

			if($result_extend =='found'){

				$sql = "DELETE FROM extend WHERE booking_trans_id='$booking_id'"; 
				db_update($sql); 

				echo '<script>'; 
				echo 'alert("Reservation with extend has been deleted '.$agreement_no.' ")'; 
				echo '</script>';
			}
			else if($result_extend =='not found'){

				echo '<script>'; 
				echo 'alert("Reservation without extend has been deleted '.$agreement_no.' ")'; 
				echo '</script>';
			}

			vali_redirect("delete_list.php"); 
		}

		else
		{
			vali_redirect("delete_list.php"); 
			// header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	else{

		$sql = "UPDATE booking_trans SET delete_status = 'Active', reason =  '' WHERE id =".$booking_id;

	    db_update($sql);

	    $sql = "UPDATE vehicle SET availability = 'Booked' WHERE id = '$vehicle_id'";

	    db_update($sql);

	    echo "<script>
        window.location.href='delete_list.php';
      </script>";
	}
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>