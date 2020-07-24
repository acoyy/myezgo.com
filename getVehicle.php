<?php

require_once('db/db_connect.php');

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$search_vehicle =  $input[0]["search_vehicle"];
$search_pickup_date = $input[0]["pickupDate"];
$search_return_date = $input[0]["returnDate"];
$search_pickup_time = $input[0]["pickupTime"];
$search_return_time = $input[0]["returnTime"];

    if($_SERVER['REQUEST_METHOD']=='POST'){

    // Filter unavailable car by array id 1

        $sqlb = "SELECT * FROM booking_trans WHERE 
        (
        return_date <= '" . $search_return_date.' '.$search_return_time.':00'."' 
        AND return_date >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
        AND (available = 'Out' OR available = 'Booked')
        ) 
        OR 
        (
        pickup_date >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
        AND pickup_date <= '" . $search_return_date.' '.$search_return_time.':00'."'
        AND (available = 'Out' OR available = 'Booked')
        )
        group by vehicle_id";
        
        $result = [];
        
        $query=mysqli_query($con,$sqlb);

        while ($row = mysqli_fetch_array($query)){

            $result[] = $row['vehicle_id'];

        }

        $sqlc = "SELECT * FROM extend WHERE 
                (
                extend_to_date   <= '" . $search_return_date.' '.$search_return_time.':00'."' 
                AND extend_to_date  >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."'
                AND vehicle_id ='$search_vehicle'
                ) 
                OR 
                (
                extend_from_date  >= '" . $search_pickup_date.' '.$search_pickup_time.':00'."' 
                AND extend_from_date  <= '" . $search_return_date.' '.$search_return_time.':00'."'
                AND vehicle_id ='$search_vehicle'
                )
                group by vehicle_id";  

        $result2 = [];
                                
        $query2=mysqli_query($con,$sqlc);

        while ($row = mysqli_fetch_array($query2)){

        $result2[] = $row['vehicle_id'];

        }

        $list_id=implode(", ", $result);

        $list_id2=implode(", ", $result2);

        $list_id3=$list_id.', '.$list_id2;

        $where = ""; 

        if(($list_id2!='' || $list_id2!=null) && ($list_id!='' || $list_id!=null)){

            if($search_vehicle != '')
            {
            $where = 'AND class_id = '.$search_vehicle;
            }
            else{

            $where = '';
            }

            $sql = "SELECT vehicle.id, 
            vehicle.class_id, 
            vehicle.reg_no, 
            vehicle.make, 
            vehicle.model, 
            vehicle.color, 
            vehicle.year, 
            booking_trans.pickup_date, 
            booking_trans.pickup_time,
            booking_trans.return_date,
            booking_trans.return_time 
            FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
            WHERE booking_trans.vehicle_id not in ($list_id , $list_id2) ".$where."
            GROUP BY vehicle.id ";

        }

        elseif (($list_id2=='' || $list_id2==null) && ($list_id!='' || $list_id!=null)) {

            if($search_vehicle != '')
            {
            $where = 'AND class_id = '.$search_vehicle;
            }
            else{

            $where = '';
            }
                
            $sql = "SELECT vehicle.id, 
                    vehicle.class_id, 
                    vehicle.reg_no, 
                    vehicle.make, 
                    vehicle.model, 
                    vehicle.color, 
                    vehicle.year, 
                    booking_trans.pickup_date, 
                    booking_trans.pickup_time,
                    booking_trans.return_date,
                    booking_trans.return_time 
                    FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                    WHERE booking_trans.vehicle_id not in ($list_id) ".$where."
                    GROUP BY vehicle.id ";
            
            }

            elseif (($list_id2!='' || $list_id2!=null) && ($list_id=='' || $list_id==null)) {

                if($search_vehicle != '')
                {
                $where = 'AND class_id = '.$search_vehicle;
                }
                else{

                $where = '';
                }

                $sql = "SELECT vehicle.id, 
                        vehicle.class_id, 
                        vehicle.reg_no, 
                        vehicle.make, 
                        vehicle.model, 
                        vehicle.color, 
                        vehicle.year, 
                        booking_trans.pickup_date, 
                        booking_trans.pickup_time,
                        booking_trans.return_date,
                        booking_trans.return_time 
                        FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                        WHERE booking_trans.vehicle_id not in ($list_id2) ".$where." 
                        GROUP BY vehicle.id ";
                            
            }

            else{

                if($search_vehicle != '')
                {
                $where = 'WHERE class_id = '.$search_vehicle;
                }
                else{

                $where = '';
                }

                $sql = "SELECT vehicle.id, 
                vehicle.class_id, 
                vehicle.reg_no, 
                vehicle.make, 
                vehicle.model, 
                vehicle.color, 
                vehicle.year, 
                booking_trans.pickup_date, 
                booking_trans.pickup_time,
                booking_trans.return_date,
                booking_trans.return_time 
                FROM vehicle LEFT JOIN booking_trans ON vehicle.id = booking_trans.vehicle_id
                ".$where."
                GROUP BY vehicle.id ";
            
            }
    
            $r = mysqli_query($con,$sql);
            $result = array();
            $no = 0;
            while($row = mysqli_fetch_array($r)){
            $no= $no + 1;
            array_push($result,array(
            'no'=>$no,
            'id'=>$row['id'],
            'class_id'=>$row['class_id'],
            'regNo'=>$row['reg_no'],
            'make'=>$row['make'],
            'model'=>$row['model'],
            'color'=>$row['color']
                ));
            }

            echo json_encode($result);
            mysqli_close($con);

        }


?>