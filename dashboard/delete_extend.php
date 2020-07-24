<?php
  $extend_id = $_GET['extend_id'];
  $booking_id = $_GET['booking_id'];
  $confirm = $_GET['confirm'];

  include ("_header.php"); 

  if($confirm == 'true')
  {
    $sql = "SELECT 
      sale.id AS sale_id,
      booking_trans.id AS booking_id
      FROM extend
      LEFT JOIN booking_trans ON booking_trans.id = extend.booking_trans_id
      LEFT JOIN sale ON sale.booking_trans_id = booking_trans.id
      WHERE extend.id = '$extend_id' AND sale.type = 'Extend' AND extend_from_date = sale.pickup_date AND extend_to_date = sale.return_date
    ";

    db_select($sql);

    if(db_rowcount() > 0)
    {
    func_setSelectVar();
    }

    $sql = "DELETE FROM extend WHERE id = '$extend_id'";

    db_update($sql);

    $sql = "DELETE FROM sale WHERE id = '$sale_id'";

    db_update($sql);

    $sql = "DELETE FROM sale_log WHERE sale_id ='$sale_id'";

    db_update($sql);

    // echo "yeah boi!";

    echo "<script> window.location.href='reservation_list_view.php?booking_id=$booking_id'; </script>";
  }

  else if($confirm == "pending"){

    echo '<script> 
              if(confirm("Are you sure you want to delete this extend?")){ 
                window.location.href="delete_extend.php?extend_id='.$extend_id.'&confirm=true&booking_id='.$booking_id.'";
              }
              else{
                window.location.href="reservation_list_view.php?booking_id='.$booking_id.'";
              }
          </script>';
  }

?>