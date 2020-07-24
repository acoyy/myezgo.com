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
	$current_datetime = date('Y-m-d H:i:s', time());

	$sql = "SELECT vehicle_id, pickup_date, return_date FROM booking_trans where agreement_no = '$agreement_no'";

	db_select($sql);

	 
	if (db_rowcount() > 0) {

		$vehicle_id = db_get(0, 0);
		$result_booking = 'found';
		$booking_trans_return_date = db_get(0, 1);
		$booking_trans_pickup_date = db_get(0, 2);
	}
	else
	{
		$result_booking = 'not found';
		echo "<script> alert('agreement not found'); </script>";
		vali_redirect("delete_list.php");
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
			vali_redirect("delete_list.php");
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


		$sql = "SELECT * FROM agent_profit where booking_trans_id = '$booking_id'";

		db_select($sql); 

		if (db_rowcount() > 0) {

			$result_agent_profit = 'found';
		}
		else
		{
			$result_agent_profit = 'not found';
		}


		$sql = "SELECT id,type FROM sale where booking_trans_id = '$booking_id'";

		db_select($sql); 

		if (db_rowcount() > 0) {

			$amountloop = db_rowcount();
			$result_sale = 'found';
			
			for($j=0;$j<$amountloop;$j++) { 

				$type[$j] = db_get($j,1);
				$sale_id[$j] = db_get($j,0);

			}
			for($j=0;$j<$amountloop;$j++) {

				$sql = "SELECT * FROM sale_log where sale_id = '".$sale_id[$j]."'";

				db_select($sql); 

				if (db_rowcount() > 0) {

					$result_sale_log = 'found';
					// echo "<br>saleid: ".$sale_id[$j].", row: ".$j." = masuk if 1";
				}
				else if($type[$j] == 'Booking' || $type[$j] == 'Return')
				{
					$result_sale_log = 'found';
					// echo "<br>saleid: ".$sale_id[$j].", row: ".$j." = masuk if 2";
				}
				else
				{

					// echo "<br>saleid: ".$sale_id[$j].", row: ".$j." = masuk if 3";
					$result_sale_log = 'not found';
					echo "<script> alert('sale log not found'); </script>";
					vali_redirect("delete_list.php");
				}
			}
		}
		else
		{
			$result_sale = 'not found';
			echo "<script> alert('sale not found'); </script>";
			vali_redirect("delete_list.php");
		}


		// if($result_booking == 'found' && $result_checklist == 'found' && $result_sale == 'found' && $result_sale_log == 'found')
		if($result_booking == 'found' && $result_checklist == 'found' && $result_sale == 'found' && $result_sale_log == 'found')
		{

			$sql = "SELECT
				MAX(id),
				pickup_date,
				return_date
			    FROM booking_trans
			    where vehicle_id = '$vehicle_id'
		    ";

		    db_select($sql);

		    if(db_rowcount()>0) { 
		            
	            $last_id = db_get(0,0);
	            $search_pickup_date = db_get(0,1);
	            $search_return_date = db_get(0,2);

	            if($booking_id == $last_id && $booking_trans_pickup_date == $search_pickup_date && $booking_trans_return_date == $search_return_date)
	            {

					$sql = "UPDATE vehicle SET availability = 'Available' WHERE id='$vehicle_id'";
					db_update($sql);
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

			$sql = "DELETE FROM agent_profit WHERE booking_trans_id='$booking_id'"; 
			db_update($sql); 

			for($j=0;$j<$amountloop;$j++) {

				$sql = "DELETE FROM sale_log where sale_id = '".$sale_id[$j]."'";

				db_update($sql);
			}

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

	    $sql = "SELECT available FROM booking_trans 
	      WHERE 
	      id='$booking_id'
	      AND 
	      pickup_date <= '".$current_datetime."'
	      AND
	      return_date >= '".$current_datetime."'
	    ";

	    db_select($sql);

	    if (db_rowcount() > 0) 
	    {

			$sql = "UPDATE vehicle SET availability = '".db_get(0,0)."' WHERE id='$vehicle_id'";
			db_update($sql);
	  	}

	    echo "<script>window.location.href='delete_list.php';</script>";
	}
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>