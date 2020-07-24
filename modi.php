<?php

// SELECT * FROM booking_trans WHERE
//         available != 'Park' 
//         AND
//         ((DATE(return_date) 
//         BETWEEN 
//         '01/31/2019 23:15' 
//         AND 
//         '02/2/2019 23:15')
//         OR
//         (DATE(pickup_date) 
//         BETWEEN 
//         '01/31/2019 23:15' 
//         AND 
//         '02/2/2019 23:15'))
//         group by vehicle_id

// SELECT * FROM booking_trans WHERE
//         available != 'Park' 
//         AND
//         ((DATE(return_date) 
//         BETWEEN 
//         '2019-01-31 23:15' 
//         AND 
//         '2019-02-02 23:15')
//         OR
//         (DATE(pickup_date) 
//         BETWEEN 
//         '2019-01-31 23:15' 
//         AND 
//         '2019-02-02 23:15'))
//         group by vehicle_id


require_once('db/db_connect.php');

$inputJSON = file_get_contents('vehicle.json');
$input = json_decode($inputJSON, TRUE);

        $search_pickup_time = $input[0]["pickupTime"];
        $search_return_time = $input[0]["returnTime"];

        //start convert date
        $origPickupDate = $input[0]["pickupDate"];
        $pickupDate = str_replace('/', '-', $origPickupDate );
        $search_pickup_date = date("Y-m-d", strtotime($pickupDate));
        echo $search_pickup_date."<br>";
        //end convert date

        $origReturnDate = $input[0]["returnDate"];
        $returnDate = str_replace('/', '-', $origReturnDate );
        $search_return_date = date("Y-m-d", strtotime($returnDate));
        echo $search_return_date."<br>";

    // Filter unavailable car by array id 1

    $sqlb = "SELECT * FROM booking_trans WHERE
    available != 'Park' 
    AND
    ((DATE(return_date) 
    BETWEEN 
    '" . $search_pickup_date.' '.$search_pickup_time.':00' ."' 
    AND 
    '" . $search_return_date.' '.$search_return_time.':00' ."')
    OR
    (DATE(pickup_date) 
    BETWEEN 
    '" . $search_pickup_date.' '.$search_pickup_time.':00' ."' 
    AND 
    '" . $search_return_date.' '.$search_return_time.':00' ."'))
    group by vehicle_id";
    
    $result = [];
    
    $query=mysqli_query($con,$sqlb);

    while ($row = mysqli_fetch_array($query)){

        $result[] = $row['vehicle_id'];

    }

    $sqlc = "SELECT extend.vehicle_id AS vehicle_id FROM extend 
    LEFT JOIN booking_trans ON booking_trans.id = extend.booking_trans_id
    WHERE 
    booking_trans.available != 'Park' 
    AND
    ((DATE(extend_to_date) 
    BETWEEN 
    '" . $search_pickup_date.' '.$search_pickup_time.':00' ."' 
    AND 
    '" . $search_return_date.' '.$search_return_time.':00' ."')
    OR
    (DATE(extend_from_date) 
    BETWEEN 
    '" . $search_pickup_date.' '.$search_pickup_time.':00' ."' 
    AND 
    '" . $search_return_date.' '.$search_return_time.':00' ."'))
    group by booking_trans.vehicle_id";  

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
        WHERE booking_trans.vehicle_id not in ($list_id , $list_id2) 
        AND (availability = 'Available' OR availability = 'Booked' OR availability = 'Out')
        GROUP BY vehicle.id ";

        }

        elseif (($list_id2=='' || $list_id2==null) && ($list_id!='' || $list_id!=null)) {
                
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
            WHERE booking_trans.vehicle_id not in ($list_id) 
            AND (availability = 'Available' OR availability = 'Booked' OR availability = 'Out')
            GROUP BY vehicle.id ";
            
            }

            elseif (($list_id2!='' || $list_id2!=null) && ($list_id=='' || $list_id==null)) {

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
                WHERE booking_trans.vehicle_id not in ($list_id2) 
                AND (availability = 'Available' OR availability = 'Booked' OR availability = 'Out')
                GROUP BY vehicle.id ";
                            
            }

            else{

            $sql = "SELECT vehicle.id, 
            vehicle.class_id, 
            vehicle.reg_no, 
            vehicle.make, 
            vehicle.model, 
            vehicle.color, 
            vehicle.year
            FROM vehicle
            WHERE availability = 'Available' OR availability = 'Booked' OR availability = 'Out'
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
            'regNo'=>$row['reg_no'],
            'make'=>$row['make'],
            'model'=>$row['model'],
            'color'=>$row['color']
                ));
            }

            echo json_encode($result);
            mysqli_close($con);

        


?>