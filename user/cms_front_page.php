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

        include('_header.php');
        func_setReqVar(); 


    if (isset($_FILES['testimonial_image'])) { 

        $errors = array(); 
        $file_name = $_FILES['testimonial_image']['name']; 
        $file_size = $_FILES['testimonial_image']['size']; 
        $file_tmp = $_FILES['testimonial_image']['tmp_name']; 
        $file_type = $_FILES['testimonial_image']['type']; 
        $file_ext = strtolower(end(explode('.', $_FILES['testimonial_image']['name']))); 
        $expensions = array("jpeg", "jpg", "png"); 

    if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

    if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

    if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $file_name); 

        echo "Success"; 

        } 

    else { 

        print_r($errors); 

        } 

        } 

    if (isset($_FILES['testimonial_images'])) { 

        $errors = array(); 

        $file_names = $_FILES['testimonial_images']['name']; 

        $file_size = $_FILES['testimonial_images']['size']; 

        $file_tmp = $_FILES['testimonial_images']['tmp_name']; 

        $file_type = $_FILES['testimonial_images']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['testimonial_images']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

    if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

    if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

    if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $file_names); 

        echo "Success"; 

        } 

    else { 

        print_r($errors); 

        } 

        } 

    if (isset($_FILES['productone_img'])) { 

        $errors = array(); 

        $file_name1 = $_FILES['productone_img']['name']; 

        $file_size = $_FILES['productone_img']['size']; 

        $file_tmp = $_FILES['productone_img']['tmp_name']; 

        $file_type = $_FILES['productone_img']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['productone_img']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

    if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

    if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

    if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $file_name1); 
        echo "Success"; 

        } 

    else { 

        print_r($errors); 

        } 

        } 

    if (isset($_FILES['producttwo_img'])) { 

        $errors = array(); 
        $file_name2 = $_FILES['producttwo_img']['name']; 
        $file_size = $_FILES['producttwo_img']['size']; 
        $file_tmp = $_FILES['producttwo_img']['tmp_name']; 
        $file_type = $_FILES['producttwo_img']['type']; 
        $file_ext = strtolower(end(explode('.', $_FILES['producttwo_img']['name']))); 
        $expensions = array("jpeg", "jpg", "png"); 

    if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

    if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

    if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $file_name2); 

        echo "Success"; 

        } 

    else { 

        print_r($errors); 

        } 

        } 

    if (isset($_FILES['productthree_img'])) { 

        $errors = array(); 

        $file_name3 = $_FILES['productthree_img']['name']; 

        $file_size = $_FILES['productthree_img']['size']; 

        $file_tmp = $_FILES['productthree_img']['tmp_name']; 

        $file_type = $_FILES['productthree_img']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['productthree_img']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $file_name3); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['gallery_one'])) { 

        $errors = array(); 

        $gallery_one = $_FILES['gallery_one']['name']; 

        $file_size = $_FILES['gallery_one']['size']; 

        $file_tmp = $_FILES['gallery_one']['tmp_name']; 

        $file_type = $_FILES['gallery_one']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['gallery_one']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $gallery_one); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['gallery_two'])) { 

        $errors = array(); 

        $gallery_two = $_FILES['gallery_two']['name']; 

        $file_size = $_FILES['gallery_two']['size']; 

        $file_tmp = $_FILES['gallery_two']['tmp_name']; 

        $file_type = $_FILES['gallery_two']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['gallery_two']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $gallery_two); echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['gallery_three'])) { 

        $errors = array(); 
        $gallery_three = $_FILES['gallery_three']['name']; 
        $file_size = $_FILES['gallery_three']['size']; 
        $file_tmp = $_FILES['gallery_three']['tmp_name']; 
        $file_type = $_FILES['gallery_three']['type']; 
        $file_ext = strtolower(end(explode('.', $_FILES['gallery_three']['name']))); 
        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $gallery_three); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['gallery_four'])) { 

        $errors = array(); 

        $gallery_four = $_FILES['gallery_four']['name']; 

        $file_size = $_FILES['gallery_four']['size']; 

        $file_tmp = $_FILES['gallery_four']['tmp_name']; 

        $file_type = $_FILES['gallery_four']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['gallery_four']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $gallery_four); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['gallery_five'])) { 

        $errors = array(); 

        $gallery_five = $_FILES['gallery_five']['name']; 

        $file_size = $_FILES['gallery_five']['size']; 

        $file_tmp = $_FILES['gallery_five']['tmp_name']; 

        $file_type = $_FILES['gallery_five']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['gallery_five']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $gallery_five); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['gallery_six'])) { 

        $errors = array(); 

        $gallery_six = $_FILES['gallery_six']['name']; 

        $file_size = $_FILES['gallery_six']['size']; 

        $file_tmp = $_FILES['gallery_six']['tmp_name']; 

        $file_type = $_FILES['gallery_six']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['gallery_six']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $gallery_six); 
        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['carousel_one'])) { 

        $errors = array(); 

        $carousel_one = $_FILES['carousel_one']['name']; 

        $file_size = $_FILES['carousel_one']['size']; 

        $file_tmp = $_FILES['carousel_one']['tmp_name']; 

        $file_type = $_FILES['carousel_one']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['carousel_one']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $carousel_one); 
        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['carousel_two'])) { 

        $errors = array(); 
        $carousel_two = $_FILES['carousel_two']['name']; 
        $file_size = $_FILES['carousel_two']['size']; 
        $file_tmp = $_FILES['carousel_two']['tmp_name']; 
        $file_type = $_FILES['carousel_two']['type']; 
        $file_ext = strtolower(end(explode('.', $_FILES['carousel_two']['name']))); 
        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $carousel_two); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image1'])) { 

        $errors = array(); 

        $vehicle_image1 = $_FILES['vehicle_image1']['name']; 

        $file_size = $_FILES['vehicle_image1']['size']; 

        $file_tmp = $_FILES['vehicle_image1']['tmp_name']; 

        $file_type = $_FILES['vehicle_image1']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image1']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image1); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        }

        if (isset($_FILES['vehicle_image2'])) { 

        $errors = array(); 

        $vehicle_image2 = $_FILES['vehicle_image2']['name']; 

        $file_size = $_FILES['vehicle_image2']['size']; 

        $file_tmp = $_FILES['vehicle_image2']['tmp_name']; 

        $file_type = $_FILES['vehicle_image2']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image2']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image2); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image3'])) { 

        $errors = array(); 

        $vehicle_image3 = $_FILES['vehicle_image3']['name']; 

        $file_size = $_FILES['vehicle_image3']['size']; 

        $file_tmp = $_FILES['vehicle_image3']['tmp_name']; 

        $file_type = $_FILES['vehicle_image3']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image3']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image3); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image4'])) { 

        $errors = array(); 

        $vehicle_image4 = $_FILES['vehicle_image4']['name']; 

        $file_size = $_FILES['vehicle_image4']['size']; 

        $file_tmp = $_FILES['vehicle_image4']['tmp_name']; 

        $file_type = $_FILES['vehicle_image4']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image4']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image4); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image5'])) { 

        $errors = array(); 

        $vehicle_image5 = $_FILES['vehicle_image5']['name']; 

        $file_size = $_FILES['vehicle_image5']['size']; 

        $file_tmp = $_FILES['vehicle_image5']['tmp_name']; 

        $file_type = $_FILES['vehicle_image5']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image5']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image5); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image6'])) { 

        $errors = array(); 

        $vehicle_image6 = $_FILES['vehicle_image6']['name']; 

        $file_size = $_FILES['vehicle_image6']['size']; 

        $file_tmp = $_FILES['vehicle_image6']['tmp_name']; 

        $file_type = $_FILES['vehicle_image6']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image6']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image6); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image7'])) { 

        $errors = array(); 

        $vehicle_image7 = $_FILES['vehicle_image7']['name']; 

        $file_size = $_FILES['vehicle_image7']['size']; 

        $file_tmp = $_FILES['vehicle_image7']['tmp_name']; 

        $file_type = $_FILES['vehicle_image7']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image7']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image7); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image8'])) { 

        $errors = array(); 

        $vehicle_image8 = $_FILES['vehicle_image8']['name']; 

        $file_size = $_FILES['vehicle_image8']['size']; 

        $file_tmp = $_FILES['vehicle_image8']['tmp_name']; 

        $file_type = $_FILES['vehicle_image8']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image8']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image8); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

        if (isset($_FILES['vehicle_image9'])) { 

        $errors = array(); 

        $vehicle_image9 = $_FILES['vehicle_image9']['name']; 

        $file_size = $_FILES['vehicle_image9']['size']; 

        $file_tmp = $_FILES['vehicle_image9']['tmp_name']; 

        $file_type = $_FILES['vehicle_image9']['type']; 

        $file_ext = strtolower(end(explode('.', $_FILES['vehicle_image9']['name']))); 

        $expensions = array("jpeg", "jpg", "png"); 

        if (in_array($file_ext, $expensions) === false) { 

        $errors[] = "Extension not allowed, please choose a JPEG or PNG file."; 

        } 

        if ($file_size > 2097152) { 

        $errors[] = 'File size must be excately 2 MB'; 

        } 

        if (empty($errors) == true) { 

        move_uploaded_file($file_tmp, "../dashboard/assets/img/cms/" . $vehicle_image9); 

        echo "Success"; 

        } 

        else { 

        print_r($errors); 

        } 

        } 

     

        if(isset($btn_save)){ 

        func_setValid("Y"); 

        if (func_isValid()) { 

        $sql = "UPDATE front_page 
        SET 
        carousel_title = '$carousel_title',
        carousel_subtitle = '$carousel_subtitle',
        hero_title = '$hero_title',
        hero_subtitle = '$hero_subtitle',
        hero_paragraph = '$hero_paragraph',
        heroes_title1 = '$heroes_title1',
        heroes_sub1 = '$heroes_sub1',
        heroes_title2 = '$heroes_title2',
        heroes_sub2 = '$heroes_sub1',
        heroes_title3 = '$heroes_title3',
        heroes_sub3 = '$heroes_sub3',
        productone_title = '$productone_title',
        productone_subtitle = '$productone_subtitle',
        productone_desc = '$productone_desc',
        productone_price = '$productone_price',
        producttwo_title = '$producttwo_title',
        producttwo_subtitle = '$producttwo_subtitle',
        producttwo_desc = '$producttwo_desc',
        producttwo_price = '$producttwo_price',
        productthree_title = '$productthree_title',
        productthree_subtitle = '$productthree_subtitle',
        productthree_desc = '$productthree_desc',
        productthree_price = '$productthree_price',
        choose_titlebar = '$choose_titlebar',
        choose_sub_title = '$choose_sub_title',
        choose_desc = '$choose_desc',
        choose_card_title1 = '$choose_card_title1',
        choose_card_subtitle1 = '$choose_card_subtitle1',
        choose_card_title2 = '$choose_card_title2',
        choose_card_subtitle2 = '$choose_card_subtitle2',
        choose_card_title3 = '$choose_card_title3',
        choose_card_subtitle3 = '$choose_card_subtitle3',
        testimonial_feedback = '$testimonial_feedback',
        testimonial_origin = '$testimonial_origin',
        testimonial_user = '$testimonial_user',
        testimonial_users = '$testimonial_users',
        testimonial_feedbacks = '$testimonial_feedbacks',
        testimonial_origins = '$testimonial_origins',
        testimonial_title = '$testimonial_title',
        testimonial_subtitle = '$testimonial_subtitle'
        WHERE id = 1"; 

        db_update($sql); 


        $sql = "UPDATE display 
        SET 
        car_type = '$car_type1',
        vehicle_name = '$vehicle_name1',
        vehicle_price = '$vehicle_price1'
        WHERE id = 1"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type2',
        vehicle_name = '$vehicle_name2',
        vehicle_price = '$vehicle_price2'
        WHERE id = 2"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type3',
        vehicle_name = '$vehicle_name3',
        vehicle_price = '$vehicle_price3'
        WHERE id = 3"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type4',
        vehicle_name = '$vehicle_name4',
        vehicle_price = '$vehicle_price4'
        WHERE id = 4"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type5',
        vehicle_name = '$vehicle_name5',
        vehicle_price = '$vehicle_price5'
        WHERE id = 5"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type6',
        vehicle_name = '$vehicle_name6',
        vehicle_price = '$vehicle_price6'
        WHERE id = 6"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type7',
        vehicle_name = '$vehicle_name7',
        vehicle_price = '$vehicle_price7'
        WHERE id = 7"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type8',
        vehicle_name = '$vehicle_name8',
        vehicle_price = '$vehicle_price8'
        WHERE id = 8"; 

        db_update($sql); 

        $sql = "UPDATE display 
        SET 
        car_type = '$car_type9',
        vehicle_name = '$vehicle_name9',
        vehicle_price = '$vehicle_price9'
        WHERE id = 9"; 

        db_update($sql); 

        if (!empty($vehicle_image1)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image1'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image2)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image2'
        WHERE id = 2"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image3)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image3'
        WHERE id = 3"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image4)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image4'
        WHERE id = 4"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image5)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image5'
        WHERE id = 5"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image6)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image6'
        WHERE id = 6"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image7)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image7'
        WHERE id = 7"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image8)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image8'
        WHERE id = 8"; 

        db_update($sql); 

        }

        if (!empty($vehicle_image9)) {

        $sql = "UPDATE display 
        SET 
        vehicle_image = '$vehicle_image9'
        WHERE id = 9"; 

        db_update($sql); 

        }

        if (!empty($carousel_one)) {

        $sql = "UPDATE front_page 
        SET 
        carousel_one = '$carousel_one'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($carousel_two)) {

        $sql = "UPDATE front_page 
        SET 
        carousel_two = '$carousel_two'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($file_name1)) {

        $sql = "UPDATE front_page 
        SET 
        productone_img = '$file_name1'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($file_name2)) {

        $sql = "UPDATE front_page 
        SET 
        producttwo_img = '$file_name2'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($file_name3)) {

        $sql = "UPDATE front_page 
        SET 
        productthree_img = '$file_name3'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($file_name)) {

        $sql = "UPDATE front_page 
        SET 
        testimonial_pic = '$file_name'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($file_names)) {

        $sql = "UPDATE front_page 
        SET 
        testimonial_img = '$file_names'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($gallery_one)) {

        $sql = "UPDATE front_page 
        SET 
        gallery_one = '$gallery_one'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($gallery_two)) {

        $sql = "UPDATE front_page 
        SET 
        gallery_two = '$gallery_two'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($gallery_three)) {

        $sql = "UPDATE front_page 
        SET 
        gallery_three = '$gallery_three'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($gallery_four)) {

        $sql = "UPDATE front_page 
        SET 
        gallery_four = '$gallery_four'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($gallery_five)) {

        $sql = "UPDATE front_page 
        SET 
        gallery_five = '$gallery_five'
        WHERE id = 1"; 

        db_update($sql); 

        }

        if (!empty($gallery_six)) {

        $sql = "UPDATE front_page 
        SET 
        gallery_six = '$gallery_six'
        WHERE id = 1"; 

        db_update($sql); 

        }


        echo "<script>alert('Updated')</script>"; 
        vali_redirect('cms_front_page.php'); 

            } 

        } else { 

        $sql = "SELECT * FROM front_page WHERE id = 1"; 

        db_select($sql); 

        if (db_rowcount() > 0) { 
            func_setSelectVar(); 

            } 
        } 

        $sqlCar1="SELECT * FROM display WHERE id='1'";
        $car1_query=mysqli_query($con,$sqlCar1);//run sql
        $rowCar1=mysqli_fetch_array($car1_query);//capture one record

        $sqlCar2="SELECT * FROM display WHERE id='2'";
        $car2_query=mysqli_query($con,$sqlCar2);//run sql
        $rowCar2=mysqli_fetch_array($car2_query);//capture one record

        $sqlCar3="SELECT * FROM display WHERE id='3'";
        $car3_query=mysqli_query($con,$sqlCar3);//run sql
        $rowCar3=mysqli_fetch_array($car3_query);//capture one record

        $sqlCar4="SELECT * FROM display WHERE id='4'";
        $car4_query=mysqli_query($con,$sqlCar4);//run sql
        $rowCar4=mysqli_fetch_array($car4_query);//capture one record


        $sqlCar5="SELECT * FROM display WHERE id='5'";
        $car5_query=mysqli_query($con,$sqlCar5);//run sql
        $rowCar5=mysqli_fetch_array($car5_query);//capture one record

        $sqlCar6="SELECT * FROM display WHERE id='6'";
        $car6_query=mysqli_query($con,$sqlCar6);//run sql
        $rowCar6=mysqli_fetch_array($car6_query);//capture one record

        $sqlCar7="SELECT * FROM display WHERE id='7'";
        $car7_query=mysqli_query($con,$sqlCar7);//run sql
        $rowCar7=mysqli_fetch_array($car7_query);//capture one record

        $sqlCar8="SELECT * FROM display WHERE id='8'";
        $car8_query=mysqli_query($con,$sqlCar8);//run sql
        $rowCar8=mysqli_fetch_array($car8_query);//capture one record

        $sqlCar9="SELECT * FROM display WHERE id='9'";
        $car9_query=mysqli_query($con,$sqlCar9);//run sql
        $rowCar9=mysqli_fetch_array($car9_query);//capture one record


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
                    <h3>Front Page Customisation</h3>
                  </div>

                  
                </div>

                            <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Front Page Customisation</h2>
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
                        <form action="" method="post" enctype = "multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Carousel</h4>

                            </div>
                          
                        </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="carousel_title">Title 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" name="carousel_title" id="carousel_title" 
                              value="<?php echo $carousel_title; ?>"
                               class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="carousel_subtitle">Subtitle 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="carousel_subtitle" name="carousel_subtitle" class="form-control col-md-7 col-xs-12" value="<?php echo $carousel_subtitle; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="carousel_one">Carousel Image One 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="carousel_one">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="carousel_two">Carousel Image Two 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="carousel_two">
                            </div>
                          </div>

                          <br>

                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>How it Works</h4>

                            </div>
                          
                        </div>

                <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hero_title">Title 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="hero_title" name="hero_title"  class="form-control col-md-7 col-xs-12" value="<?php echo $hero_title; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hero_subtitle">Sub Title 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="hero_subtitle" name="hero_subtitle"  class="form-control col-md-7 col-xs-12" value="<?php echo $hero_subtitle; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hero_paragraph">Description 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="hero_paragraph" name="hero_paragraph"  class="form-control col-md-7 col-xs-12" value="<?php echo $hero_paragraph; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heroes_title1">Description One - Title 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="heroes_title1" name="heroes_title1"  class="form-control col-md-7 col-xs-12" value="<?php echo $heroes_title1; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heroes_sub1">Description One - Description 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="heroes_sub1" name="heroes_sub1"  class="form-control col-md-7 col-xs-12" value="<?php echo $heroes_sub1; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heroes_title2">Description Two - Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="heroes_title2" name="heroes_title2"  class="form-control col-md-7 col-xs-12" value="<?php echo $heroes_title2; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heroes_sub2">Description Two - Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="heroes_sub2" name="heroes_sub2"  class="form-control col-md-7 col-xs-12" value="<?php echo $heroes_sub2; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heroes_title3">Description Three - Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="heroes_title3" name="heroes_title3"  class="form-control col-md-7 col-xs-12" value="<?php echo $heroes_title3; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heroes_sub3">Description Three - Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="heroes_sub3" name="heroes_sub3"  class="form-control col-md-7 col-xs-12" value="<?php echo $heroes_sub3; ?>">
                            </div>
                          </div>

                          <br>
                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Product</h4>

                            </div>
                          
                        </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productone_img">Product One - Picture
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              
                              <input class="btn btn-small btn-default" type="file" name="productone_img">

                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productone_title">Product One - Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productone_title" name="productone_title"  class="form-control col-md-7 col-xs-12" value="<?php echo $productone_title; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productone_subtitle">Product One - Subtitle
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productone_subtitle" name="productone_subtitle"  class="form-control col-md-7 col-xs-12" value="<?php echo $productone_subtitle; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productone_desc">Product One - Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productone_desc" name="productone_desc"  class="form-control col-md-7 col-xs-12" value="<?php echo $productone_desc; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productone_price">Product One - Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productone_price" name="productone_price"  class="form-control col-md-7 col-xs-12" value="<?php echo $productone_price; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="producttwo_img">Product Two - Picture
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="producttwo_img">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="producttwo_title">Product Two - Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="producttwo_title" name="producttwo_title"  class="form-control col-md-7 col-xs-12" value="<?php echo $producttwo_title; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="producttwo_subtitle">Product Two - Subtitle
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="producttwo_subtitle" name="producttwo_subtitle"  class="form-control col-md-7 col-xs-12" value="<?php echo $producttwo_subtitle; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="producttwo_desc">Product Two - Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="producttwo_desc" name="producttwo_desc"  class="form-control col-md-7 col-xs-12" value="<?php echo $producttwo_desc; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="producttwo_price">Product Two - Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="producttwo_price" name="producttwo_price"  class="form-control col-md-7 col-xs-12" value="<?php echo $producttwo_price; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productthree_img">Product Three - Picture
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="btn btn-small btn-default" type="file" name="productthree_img">

                            </div>
                    </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productthree_title">Product Three - Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productthree_title" name="productthree_title"  class="form-control col-md-7 col-xs-12" value="<?php echo $productthree_title; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productthree_subtitle">Product Three - Subtitle
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productthree_subtitle" name="productthree_subtitle"  class="form-control col-md-7 col-xs-12" value="<?php echo $productthree_subtitle; ?>">
                            </div>
                          </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productthree_desc">Product Three - Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productthree_desc" name="productthree_desc"  class="form-control col-md-7 col-xs-12" value="<?php echo $productthree_desc; ?>">
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="productthree_price">Product Three - Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="productthree_price" name="productthree_price"  class="form-control col-md-7 col-xs-12" value="<?php echo $productthree_price; ?>">
                            </div>
                    </div>

                        <br>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                        <h4>Why Choose Us</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_titlebar">Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_titlebar" name="choose_titlebar"  class="form-control col-md-7 col-xs-12" value="<?php echo $choose_titlebar; ?>">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_sub_title">Sub Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_sub_title" name="choose_sub_title"  class="form-control col-md-7 col-xs-12" value="<?php echo $choose_sub_title; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_desc">Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_desc" name="choose_desc"  class="form-control col-md-7 col-xs-12" value="<?php echo $choose_desc; ?>">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>First Card</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_title1">Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_card_title1" name="choose_card_title1"  class="form-control col-md-7 col-xs-12"  value="<?php echo $choose_card_title1; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_subtitle1">Sub Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_card_subtitle1" name="choose_card_subtitle1"  class="form-control col-md-7 col-xs-12"  value="<?php echo $choose_card_subtitle1; ?>">
                            </div>
                          </div>


                          <br>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Second Card</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_title2">Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_card_title2" name="choose_card_title2"  class="form-control col-md-7 col-xs-12" value="<?php echo $choose_card_title2; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_subtitle2">Sub Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_card_subtitle2" name="choose_card_subtitle2"  class="form-control col-md-7 col-xs-12" value="<?php echo $choose_card_subtitle2; ?>">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Third Card</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_title3">Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_card_title3" name="choose_card_title3"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $choose_card_title3; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_subtitle3">Sub Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="choose_card_subtitle3" name="choose_card_subtitle3"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $choose_card_subtitle3; ?>">
                            </div>
                          </div>

                          <br>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Testimonial</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="choose_card_subtitle3">Title
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_title" name="testimonial_title"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_title; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_subtitle">Subtitle
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_subtitle" name="testimonial_subtitle"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_subtitle; ?>">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>First Testimonial</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_image">Picture
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="testimonial_image">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_feedback">Feedback
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_feedback" name="testimonial_feedback"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_feedback; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_origin">Origin
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_origin" name="testimonial_origin"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_origin; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_user">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_user" name="testimonial_user"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_user; ?>">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Second Testimonial</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_images">Picture
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="btn btn-small btn-default" type="file" name="testimonial_images">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_feedbacks">Feedback
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_feedbacks" name="testimonial_feedbacks"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_feedbacks; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_users">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_users" name="testimonial_users"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_users; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="testimonial_origins">Origin
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="testimonial_origins" name="testimonial_origins"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $testimonial_origins; ?>">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Footer Gallery</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gallery_one">Image One
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="gallery_one">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gallery_two">Image Two
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="gallery_two">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gallery_three">Image Three
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="gallery_three">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gallery_four">Image Four
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="gallery_four">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gallery_five">Image Five
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="gallery_five">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gallery_six">Image Six
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="gallery_six">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 1</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type1">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type1" class="form-control">

                            <option value="small" <?php if($rowCar1['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar1['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar1['car_type']=='big'){ echo 'selected';} ?>>Big</option>

                            </select>
                         


                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name1">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name1" name="vehicle_name1"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar1['vehicle_name']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price1">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_price1" name="vehicle_price1"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar1['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image1">Vehicle Image 1
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="vehicle_image1">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 2</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type1">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type2" class="form-control">
                            
                            <option value="small" <?php if($rowCar2['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar2['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar2['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                            
                            </select>
                         


                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name2">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name2" name="vehicle_name2"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar2['vehicle_name']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price2">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_price2" name="vehicle_price2"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar2['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image2">Vehicle Image 2
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="btn btn-small btn-default" type="file" name="vehicle_image2">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 3</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type3">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type3" class="form-control">
                            <option value="small" <?php if($rowCar3['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar3['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar3['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                            </select>
                         


                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name3">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name3" name="vehicle_name3"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar3['vehicle_name']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price3">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name3" name="vehicle_price3"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar3['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image3">Vehicle Image 3
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="btn btn-small btn-default" type="file" name="vehicle_image3">
                            </div>
                          </div>

                          <br>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 4</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type3">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type4" class="form-control">
                            <option value="small" <?php if($rowCar4['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar4['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar4['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                        </select>
                         


                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name4">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name4" name="vehicle_name4"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar4['vehicle_name']; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price4">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_price4" name="vehicle_price4"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar4['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image4">Vehicle Image 4
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="btn btn-small btn-default" type="file" name="vehicle_image4">

                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 5</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type5">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type5" class="form-control">
                            <option value="small" <?php if($rowCar5['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar5['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar5['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                        </select>
                         


                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name5">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name5" name="vehicle_name5"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar5['vehicle_name']; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price5">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" id="vehicle_price5" name="vehicle_price5"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar5['vehicle_price']; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image5">Vehicle Image 5
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="btn btn-small btn-default" type="file" name="vehicle_image5">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 6</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type6">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type6" class="form-control">
                            <option value="small" <?php if($rowCar6['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar6['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar6['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                        </select>
                         


                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name6">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name6" name="vehicle_name6"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar6['vehicle_name']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price6">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" id="vehicle_price6" name="vehicle_price6"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar6['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image6">Vehicle Image 6
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="btn btn-small btn-default" type="file" name="vehicle_image6">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 7</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type6">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type7" class="form-control">
                            <option value="small" <?php if($rowCar7['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar7['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar7['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                            </select>
                         


                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name7">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name7" name="vehicle_name7"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar7['vehicle_name']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price7">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" id="vehicle_price7" name="vehicle_price7"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar7['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price7">Vehicle Image 7
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <input class="btn btn-small btn-default" type="file" name="vehicle_image7">


                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 8</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type6">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type8" class="form-control">
                            <option value="small" <?php if($rowCar8['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar8['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar8['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                            </select>
                         


                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name8">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name8" name="vehicle_name8"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar8['vehicle_name']; ?>">
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price8">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_price8" name="vehicle_price8"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar8['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image8">Vehicle Image 8
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="btn btn-small btn-default" type="file" name="vehicle_image8">
                            </div>
                          </div>

                          <br>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <h4>Vehicle Display 9</h4>

                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="car_type9">Car Type
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="car_type9" class="form-control">
                            <option value="small" <?php if($rowCar9['car_type']=='small'){ echo 'selected';} ?>>Small</option>
                            <option value="medium" <?php if($rowCar9['car_type']=='medium'){ echo 'selected';} ?>>Medium</option>
                            <option value="big" <?php if($rowCar9['car_type']=='big'){ echo 'selected';} ?>>Big</option>
                        </select>
                         
                        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_name9">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_name9" name="vehicle_name9"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar9['vehicle_name']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_price9">Price
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="vehicle_price9" name="vehicle_price9"  class="form-control col-md-7 col-xs-12"
                              value="<?php echo $rowCar9['vehicle_price']; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vehicle_image9">Vehicle Image 9 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             
                                <input class="btn btn-small btn-default" type="file" name="vehicle_image9">

                            </div>
                          </div>

                         <br>

                         <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                            <iframe id='frame' src="../../index.php" width="100%" height="6000px" ></iframe>
                            </div>
                          </div>

                          <div class="ln_solid"></div>
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button name="btn_save" type="submit" class="btn btn-success">Submit</button>
                            </div>
                          </div>




                <!--
                  
                    <div>
                        <label class="control-label">Vehicle Image 6</label>
                        <input class="btn btn-small btn-default" type="file" name="vehicle_image9">
                    </div>

                     -->

                          

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