<?php

$response = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
$booking_id = $input["booking_id"];
$uid = $input["user_id"];

if($_SERVER['REQUEST_METHOD']=='POST'){
    

    $sql = "SELECT agreement_no FROM booking_trans WHERE id=".$booking_id;

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        $response["result"] = 0;

        while ($row = mysqli_fetch_array($query)){

            $agreement_no = $row['agreement_no'];
    
        }

        $response['agreement_no'] = $agreement_no;

    }

    else{

        $response["result"] = 1;

    }
    
    $sql = "SELECT * FROM upload_data WHERE BOOKING_TRANS_ID=".$booking_id;

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $ID = $row['ID'];
            $BOOKING_TRANS_ID = $row['BOOKING_TRANS_ID'];
            $FILE_NAME = $row['FILE_NAME'];
            $FILE_SIZE = $row['FILE_SIZE'];
            $FILE_TYPE = $row['FILE_TYPE'];
    
        }

        $response['ID'] = $ID;
        $response['BOOKING_TRANS_ID'] = $BOOKING_TRANS_ID;
        $response['FILE_NAME'] = $FILE_NAME;
        $response['FILE_SIZE'] = $FILE_SIZE;
        $response['FILE_TYPE'] = $FILE_TYPE;

    }

    $sql = "SELECT * FROM user WHERE id=".$uid;

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $username = $row['username'];
            $name = $row['name'];
            $nickname = $row['nickname'];
            $occupation = $row['occupation'];
            $branch = $row['branch'];
            $status = $row['status'];
            $created_at = $row['created_at'];
            $dp = $row['dp'];
    
        }

        $response['username'] = $username;
        $response['name'] = $name;
        $response['nickname'] = $nickname;
        $response['occupation'] = $occupation;
        $response['branch'] = $branch;
        $response['status'] = $status;
        $response['created_at'] = $created_at;
        $response['dp'] = $dp;
    

    }

    $id = $input["booking_id"]; 

    $sql="SELECT vehicle_id FROM booking_trans WHERE id=".$id;

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $vehicle_id = $row['vehicle_id'];
    
        }

            $response['vehicle_id'] = $vehicle_id;        

    }

    $sql="SELECT class_id FROM vehicle WHERE id=".$vehicle_id;

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $class_id = $row['class_id'];
    
        }

        $response['class_id'] = $class_id;

    }

    // $sql = "SELECT * FROM booking_trans WHERE id = $id"; 

    $sql = "SELECT
    vehicle.id AS vehicle_id,
    booking_trans.pickup_date as pickup_date,
    booking_trans.pickup_time as pickup_time,
    CASE pickup_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS pickup_location,
    booking_trans.return_date as return_date,
    CASE return_location WHEN '4' THEN 'Port Dickson' WHEN '5' THEN 'Seremban' END AS return_location,
    customer.id AS customer_id,
    firstname,
    lastname,
    concat(firstname,' ' ,lastname) AS fullname,
    concat(make, ' ', model) AS car,
    reg_no,
    nric_no,
    address,
    phone_no,
    phone_no2,
    email,
    license_no,
    sub_total AS sub_total2,
    est_total AS est_total2,
    refund_dep,
    refund_dep_payment,
    car_in_image,
    car_in_start_engine,
    car_in_no_alarm,
    car_in_air_conditioner,
    car_in_radio,
    car_in_power_window,
    car_in_window_condition,
    car_in_perfume,
    car_in_carpet,
    car_in_sticker_p,
    car_in_lamp,
    car_in_engine_condition,
    car_in_tyres_condition,
    car_in_jack,
    car_in_tools,
    car_in_signage,
    car_in_child_seat,
    car_in_wiper,
    car_in_gps,
    car_in_tyre_spare,
    car_in_usb_charger,
    car_in_touch_n_go,
    car_in_smart_tag,
    car_in_seat_condition,
    car_in_cleanliness,
    car_in_fuel_level,
    car_in_remark,
    car_out_image,
    car_out_sign_image,
    car_out_start_engine,
    car_out_no_alarm,
    car_out_air_conditioner,
    car_out_radio,
    car_out_power_window,
    car_out_window_condition,
    car_out_perfume,
    car_out_carpet,
    car_out_sticker_p,
    car_out_lamp,
    car_out_engine_condition,
    car_out_tyres_condition,
    car_out_jack,
    car_out_tools,
    car_out_signage,
    car_out_child_seat,
    car_out_wiper,
    car_out_gps,
    car_out_tyre_spare,
    car_out_usb_charger,
    car_out_touch_n_go,
    car_out_smart_tag,
    car_out_seat_condition,
    car_out_cleanliness,
    car_out_fuel_level,
    car_out_remark,
    agreement_no,
    car_in_checkby,
    car_add_driver,
    car_cdw,
    car_driver,
    MIN(sale.id) AS sale_id2,
    sale.pickup_date AS sale_pickup_date,
    sale.return_date AS sale_return_date,
    total_sale,
    agent_id
    FROM customer
    JOIN booking_trans ON customer.id = customer_id 
    JOIN vehicle ON vehicle_id = vehicle.id
    JOIN checklist ON checklist.booking_trans_id = booking_trans.id
    JOIN sale ON sale.booking_trans_id = booking_trans.id
    WHERE booking_trans.id=".$id." AND sale.type='Sale'";

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $vehicle_id = $row['vehicle_id'];
            $pickup_date = $row['pickup_date'];
            $pickup_time = $row['pickup_time'];
            $pickup_location = $row['pickup_location'];
            $return_date = $row['return_date'];
            $return_location = $row['return_location'];
            $fullname = $row['fullname'];
            $car = $row['car'];
            $reg_no = $row['reg_no'];
            $nric_no = $row['nric_no'];
            $address = $row['address'];
            $phone_no = $row['phone_no'];
            $phone_no2 = $row['phone_no2'];
            $email = $row['email'];
            $license_no = $row['license_no'];
            $sub_total2 = $row['sub_total2'];
            $est_total2 = $row['est_total2'];
            $refund_dep = $row['refund_dep'];
            $refund_dep_payment = $row['refund_dep_payment'];
            $car_in_image = $row['car_in_image'];
            $car_in_start_engine = $row['car_in_start_engine'];
            $car_in_no_alarm = $row['car_in_no_alarm'];
            $car_in_air_conditioner = $row['car_in_air_conditioner'];
            $car_in_radio = $row['car_in_radio'];
            $car_in_power_window = $row['car_in_power_window'];
            $car_in_window_condition = $row['car_in_window_condition'];
            $car_in_perfume = $row['car_in_perfume'];
            $car_in_carpet = $row['car_in_carpet'];
            $car_in_sticker_p = $row['car_in_sticker_p'];
            $car_in_lamp = $row['car_in_lamp'];
            $car_in_engine_condition = $row['car_in_engine_condition'];
            $car_in_tyres_condition = $row['car_in_tyres_condition'];
            $car_in_jack = $row['car_in_jack'];
            $car_in_tools = $row['car_in_tools'];
            $car_in_signage = $row['car_in_signage'];
            $car_in_child_seat = $row['car_in_child_seat'];
            $car_in_wiper = $row['car_in_wiper'];
            $car_in_gps = $row['car_in_gps'];
            $car_in_tyre_spare = $row['car_in_tyre_spare'];
            $car_in_usb_charger = $row['car_in_usb_charger'];
            $car_in_touch_n_go = $row['car_in_touch_n_go'];
            $car_in_smart_tag = $row['car_in_smart_tag'];
            $car_in_seat_condition = $row['car_in_seat_condition'];
            $car_in_cleanliness = $row['car_in_cleanliness'];
            $car_in_fuel_level = $row['car_in_fuel_level'];
            $car_in_remark = $row['car_in_remark'];
            $car_out_image = $row['car_out_image'];
            $car_out_sign_image = $row['car_out_sign_image'];
            $car_out_start_engine = $row['car_out_start_engine'];
            $car_out_no_alarm = $row['car_out_no_alarm'];
            $car_out_air_conditioner = $row['car_out_air_conditioner'];
            $car_out_radio = $row['car_out_radio'];
            $car_out_power_window = $row['car_out_power_window'];
            $car_out_window_condition = $row['car_out_window_condition'];
            $car_out_perfume = $row['car_out_perfume'];
            $car_out_carpet = $row['car_out_carpet'];
            $car_out_sticker_p = $row['car_out_sticker_p'];
            $car_out_lamp = $row['car_out_lamp'];
            $car_out_engine_condition = $row['car_out_engine_condition'];
            $car_out_tyres_condition = $row['car_out_tyres_condition'];
            $car_out_jack = $row['car_out_jack'];
            $car_out_tools = $row['car_out_tools'];
            $car_out_signage = $row['car_out_signage'];
            $car_out_child_seat = $row['car_out_child_seat'];
            $car_out_wiper = $row['car_out_wiper'];
            $car_out_gps = $row['car_out_gps'];
            $car_out_tyre_spare = $row['car_out_tyre_spare'];
            $car_out_usb_charger = $row['car_out_usb_charger'];
            $car_out_touch_n_go = $row['car_out_touch_n_go'];
            $car_out_smart_tag = $row['car_out_smart_tag'];
            $car_out_seat_condition = $row['car_out_seat_condition'];
            $car_out_cleanliness = $row['car_out_cleanliness'];
            $car_out_fuel_level = $row['car_out_fuel_level'];
            $car_out_remark = $row['car_out_remark'];
            $agreement_no = $row['agreement_no'];
            $car_in_checkby = $row['car_in_checkby'];
            $car_add_driver = $row['car_add_driver'];
            $car_cdw = $row['car_cdw'];
            $car_driver = $row['car_driver'];
            $sale_id2 = $row['sale_id2'];
            $sale_pickup_date = $row['sale_pickup_date'];
            $sale_return_date = $row['sale_return_date'];
            $total_sale = $row['total_sale'];
            $agent_id = $row['agent_id'];
            $customer_id = $row['customer_id'];


            // $agreement_no = $row['agreement_no'];
            // $pickup_date = $row['pickup_date'];
            // $pickup_location = $row['pickup_location'];
            // $pickup_time = $row['pickup_time'];
            // $return_date = $row['return_date'];
            // $return_date_final = $row['return_date_final'];
            // $return_location = $row['return_location'];
            // $return_time = $row['return_time'];
            // $p_cost = $row['p_cost'];
            // $p_address = $row['p_address'];
            // $p_address2 = $row['p_address2'];
            // $r_cost = $row['r_cost'];
            // $r_address = $row['r_address'];
            // $r_address2 = $row['r_address2'];
            // $charges = $row['charges'];
            // $option_rental_id = $row['option_rental_id'];
            // $cdw = $row['cdw'];
            // $discount_coupon = $row['discount_coupon'];
            // $discount_amount = $row['discount_amount'];
            // $vehicle_id = $row['vehicle_id'];
            // $day = $row['day'];
            // $sub_total = $row['sub_total'];
            // $payment_details = $row['payment_details'];
            // $gst = $row['gst'];
            // $est_total = $row['est_total'];
            
            // $created = $row['created'];
            // $refund_dep = $row['refund_dep'];
            // $refund_dep_payment = $row['refund_dep_payment'];
            // $refund_dep_status = $row['refund_dep_status'];
            // $type = $row['type'];
            // $balance = $row['balance'];
            // $other_details = $row['other_details'];
            // $other_details_payment_type = $row['other_details_payment_type'];
            // $other_details_price = $row['other_details_price'];
            // $damage_charges = $row['damage_charges'];
            // $damage_charges_details = $row['damage_charges_details'];
            // $damage_charges_payment_type = $row['damage_charges_payment_type'];
            // $missing_items_charges = $row['missing_items_charges'];
            // $missing_items_charges_details = $row['missing_items_charges_details'];
            // $missing_items_charges_payment_type = $row['missing_items_charges_payment_type'];
            // $additional_cost = $row['additional_cost'];
            // $additional_cost_details = $row['additional_cost_details'];
            // $additional_cost_payment_type = $row['additional_cost_payment_type'];
            // $outstanding_extend_cost = $row['outstanding_extend_cost'];
            // $outstanding_extend = $row['outstanding_extend'];
            // $outstanding_extend_type_of_payment = $row['outstanding_extend_type_of_payment'];
            // $agent_id = $row['agent_id'];
            // $delete_status = $row['delete_status'];
            // $reason = $row['reason'];
            // $available = $row['available'];
            // $branch = $row['branch'];
            // $staff_id = $row['staff_id'];
    
        }

         
         

            $response['agreement_no'] = $agreement_no;
            $response['pickup_date'] = $pickup_date;
            $response['format_pickup_date'] = date('d/m/Y', strtotime($pickup_date));
            $response['pickup_location'] = $pickup_location;
            $response['pickup_time'] = $pickup_time;
            $response['format_pickup_time'] = date('H:i', strtotime($pickup_time));
            $response['return_date'] = $return_date;
            $response['format_return_date'] = date('d/m/Y', strtotime($return_date));
            
            $response['return_location'] = $return_location;

            // $response['return_time'] = $return_time;
            $response['format_return_time'] = date('H:i', strtotime($return_date));

            // $response['return_time'] = $return_time;
            // $response['format_return_time'] = date('H:i', strtotime($return_time));

            $response['firstname'] =  $firstname;
            $response['lastname'] = $lastname;

            $response['fullname'] = $fullname;
            $response['car'] = $car;
            $response['reg_no'] = $reg_no;
            $response['nric_no'] = $nric_no;
            $response['address'] = $address;
            $response['phone_no'] = $phone_no;
            $response['phone_no2'] = $phone_no2;
            $response['email'] = $email;
            $response['license_no'] = $license_no;
            $response['sale_id2'] = $sale_id2;

            //

            $response['car_in_image'] = $car_in_image;
            $response['car_in_start_engine'] = $car_in_start_engine;
            $response['car_in_no_alarm'] = $car_in_no_alarm;
            $response['car_in_air_conditioner'] = $car_in_air_conditioner;
            $response['car_in_radio'] = $car_in_radio;
            $response['car_in_power_window'] = $car_in_power_window;
            $response['car_in_window_condition'] = $car_in_window_condition;
            $response['car_in_perfume'] = $car_in_perfume;
            $response['car_in_carpet'] = $car_in_carpet;
            $response['car_in_sticker_p'] = $car_in_sticker_p;
            $response['car_in_lamp'] = $car_in_lamp; 
            $response['car_in_engine_condition'] = $car_in_engine_condition;
            $response['car_in_tyres_condition'] = $car_in_tyres_condition;
            $response['car_in_jack'] = $car_in_jack;
            $response['car_in_tools'] = $car_in_tools;
            $response['car_in_signage'] = $car_in_signage;
            $response['car_in_child_seat'] = $car_in_child_seat;
            $response['car_in_wiper'] = $car_in_wiper;
            $response['car_in_gps'] = $car_in_gps;
            $response['car_in_tyre_spare'] = $car_in_tyre_spare;
            $response['car_in_usb_charger'] = $car_in_usb_charger;
            $response['car_in_touch_n_go'] = $car_in_touch_n_go;
            $response['car_in_smart_tag'] = $car_in_smart_tag;
            $response['car_in_seat_condition'] = $car_in_seat_condition;
            $response['car_in_cleanliness'] = $car_in_cleanliness;
            $response['car_in_fuel_level'] = $car_in_fuel_level;
            $response['car_in_remark'] = $car_in_remark;
            $response['car_out_image'] = $car_out_image;
            $response['car_out_sign_image'] = $car_out_sign_image;
            $response['car_out_start_engine'] = $car_out_start_engine;
            $response['car_out_no_alarm'] = $car_out_no_alarm;
            $response['car_out_air_conditioner'] = $car_out_air_conditioner;
            $response['car_out_radio'] = $car_out_radio;
            $response['car_out_power_window'] = $car_out_power_window;
            $response['car_out_window_condition'] = $car_out_window_condition;
            $response['car_out_perfume'] = $car_out_perfume;
            $response['car_out_carpet'] = $car_out_carpet;
            $response['car_out_sticker_p'] = $car_out_sticker_p;
            $response['car_out_lamp'] = $car_out_lamp;
            $response['car_out_engine_condition'] = $car_out_engine_condition;
            $response['car_out_tyres_condition'] = $car_out_tyres_condition;
            $response['car_out_jack'] = $car_out_jack;
            $response['car_out_tools'] = $car_out_tools;
            $response['car_out_signage'] = $car_out_signage;
            $response['car_out_child_seat'] = $car_out_child_seat;
            $response['car_out_wiper'] = $car_out_wiper;
            $response['car_out_gps'] = $car_out_gps;
            $response['car_out_tyre_spare'] = $car_out_tyre_spare;
            $response['car_out_usb_charger'] = $car_out_usb_charger;
            $response['car_out_touch_n_go'] = $car_out_touch_n_go;
            $response['car_out_smart_tag'] = $car_out_smart_tag;
            $response['car_out_seat_condition'] = $car_out_seat_condition;
            $response['car_out_cleanliness'] = $car_out_cleanliness;
            $response['car_out_fuel_level'] = $car_out_fuel_level;
            $response['car_out_remark'] = $car_out_remark;
            $response['car_in_checkby'] = $car_in_checkby;
            $response['car_add_driver'] = $car_add_driver;
            $response['car_cdw'] = $car_cdw;
            $response['car_driver'] = $car_driver;

            //

            // $response['p_cost'] = $p_cost;
            // $response['p_address'] = $p_address;
            // $response['p_address2'] = $p_address2;
            // $response['r_cost'] = $r_cost;
            // $response['r_address'] = $r_address;
            // $response['r_address2'] = $r_address2;
            // $response['charges'] = $charges;
            // $response['option_rental_id'] = $option_rental_id;
            // $response['cdw'] = $cdw;
            // $response['discount_coupon'] = $discount_coupon;
            // $response['discount_amount'] = $discount_amount;
            $response['vehicle_id'] = $vehicle_id;
            // $response['day'] = $day;
            $response['subTotal'] = $sub_total2;;
            // $response['payment_details'] = $payment_details;
            // $response['gst'] = $gst;
            $response['est_total'] = $est_total2;
            $response['customer_id'] = $customer_id;
            // $response['created'] = $created;
            $response['refund_dep'] = $refund_dep;
            $response['refund_dep_payment'] = $refund_dep_payment;
            // $response['refund_dep_status'] = $refund_dep_status;
            // $response['type'] = $type;
            // $response['balance'] = $balance;
            // $response['other_details'] = $other_details;
            // $response['other_details_payment_type'] = $other_details_payment_type;
            // $response['other_details_price'] = $other_details_price;
            // $response['damage_charges'] = $damage_charges;
            // $response['damage_charges_details'] = $damage_charges_details;
            // $response['damage_charges_payment_type'] = $damage_charges_payment_type;
            // $response['missing_items_charges'] = $missing_items_charges;
            // $response['missing_items_charges_details'] = $missing_items_charges_details;
            // $response['missing_items_charges_payment_type'] = $missing_items_charges_payment_type;
            // $response['additional_cost'] = $additional_cost;
            // $response['additional_cost_details'] = $additional_cost_details;
            // $response['additional_cost_payment_type'] = $additional_cost_payment_type;
            // $response['outstanding_extend_cost'] = $outstanding_extend_cost;
            // $response['outstanding_extend'] = $outstanding_extend;
            // $response['outstanding_extend_type_of_payment'] = $outstanding_extend_type_of_payment;
            $response['agent_id'] = $agent_id;
            // $response['delete_status'] = $delete_status;
            // $response['reason'] = $reason;
            // $response['available'] = $available;
            // $response['branch'] = $branch;
            // $response['staff_id'] = $staff_id;

    }

    $sql = "SELECT license_no FROM customer WHERE id = $customer_id"; 

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $license_no = $row['license_no'];
    
        }

        $response["license_no"] = $license_no;

    }

    $sql = "SELECT * FROM customer WHERE id=".$customer_id;

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){
            
            $title = $row['title'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $nric_no = $row['nric_no'];
            $license_no = $row['license_no'];
            $license_exp = $row['license_exp'];
            $phone_no = $row['phone_no'];
            $phone_no2 = $row['phone_no2'];
            $email = $row['email'];
            $address = $row['address'];
            $postcode = $row['postcode'];
            $city = $row['city'];
            $country = $row['country'];
            $status = $row['status'];
            $cid = $row['cid'];
            $cdate = $row['cdate'];
            $mid = $row['mid'];
            $mdate = $row['mdate'];
            $ref_name = $row['ref_name'];
            $ref_phoneno = $row['ref_phoneno'];
            $age = $row['age'];
            $image = $row['image'];
            $drv_name = $row['drv_name'];
            $drv_nric = $row['drv_nric'];
            $drv_address = $row['drv_address'];
            $drv_phoneno = $row['drv_phoneno'];
            $drv_license_no = $row['drv_license_no'];
            $drv_license_exp = $row['drv_license_exp'];
            $gl_code = $row['gl_code'];
            $ref_relationship = $row['ref_relationship'];
            $ref_address = $row['ref_address'];
            $reason_blacklist = $row['reason_blacklist'];
            $date_blacklist = $row['date_blacklist'];
            $cid_blacklist = $row['cid_blacklist'];
            $survey_type = $row['survey_type'];
            $survey_details = $row['survey_details'];
            $provider_id = $row['provider_id'];
            $provider = $row['provider'];
    
        }

            $response["title"] = $title;
            $response["firstname"] = $firstname;
            $response["lastname"] = $lastname;
            $response["nric_no"] = $nric_no;
            $response["license_no"] = $license_no;
            $response["license_exp"] = $license_exp;
            $response["phone_no"] = $phone_no;
            $response["phone_no2"] = $phone_no2;
            $response["email"] = $email;
            $response["address"] = $address;
            $response["postcode"] = $postcode;
            $response["city"] = $city;
            $response["country"] = $country;
            $response["status"] = $status;
            $response["cid"] = $cid;
            $response["cdate"] = $cdate;
            $response["mid"] = $mid;
            $response["mdate"] = $mdate;
            $response["ref_name"] = $ref_name;
            $response["ref_phoneno"] = $ref_phoneno;
            $response["age"] = $age;
            $response["image"] = $image;
            $response["drv_name"] = $drv_name;
            $response["drv_nric"] = $drv_nric;
            $response["drv_address"] = $drv_address;
            $response["drv_phoneno"] = $drv_phoneno;
            $response["drv_license_no"] = $drv_license_no;
            $response["drv_license_exp"] = $drv_license_exp;
            $response["gl_code"] = $gl_code;
            $response["ref_relationship"] = $ref_relationship;
            $response["ref_address"] = $ref_address;
            $response["reason_blacklist"] = $reason_blacklist;
            $response["date_blacklist"] = $date_blacklist;
            $response["cid_blacklist"] = $cid_blacklist;
            $response["survey_type"] = $survey_type;
            $response["survey_details"] = $survey_details;
            $response["provider_id"] = $provider_id;
            $response["provider"] = $provider;

    }

    $sql = "SELECT available from booking_trans WHERE id = '$booking_id'";

    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $available = $row['available'];
    
        }

        $response["available"] = $available;

    }

    $sql = "SELECT nickname from user WHERE id = '$cid'";

        $query=mysqli_query($con,$sql);

        if(mysqli_num_rows($query)>0){

            while ($row = mysqli_fetch_array($query)){

                $nickname = $row['nickname'];
        
            }

            $response["nickname"] = $nickname;

        }

    $sql = "SELECT 
        company_name,
        website_name,
        registration_no,
        address AS company_address,
        phone_no AS company_phone_no,
        image AS company_image
        FROM company WHERE id IS NOT NULL"; 


    $query=mysqli_query($con,$sql);

    if(mysqli_num_rows($query)>0){

        while ($row = mysqli_fetch_array($query)){

            $company_name = $row['company_name'];
            $website_name = $row['website_name'];
            $registration_no = $row['registration_no'];
            $company_address = $row['company_address'];
            $company_phone_no = $row['company_phone_no'];
            $company_image = $row['company_image'];

        }

            $response["company_name"] = $company_name;
            $response["website_name"] = $website_name;
            $response["registration_no"] = $registration_no;
            $response["company_address"] = $company_address;
            $response["company_phone_no"] = $company_phone_no;
            $response["company_image"] = $company_image;


    }

    echo json_encode($response);

}

?>