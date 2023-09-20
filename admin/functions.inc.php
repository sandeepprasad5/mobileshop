<?php
    require_once('connection.inc.php');
    $GLOBALS['con'] = $con;
    
    function pr($arr){
        echo '<pre>';
        print_r($arr);
    }

    function prx($arr){
        echo '<pre>';
        print_r($arr);
        die();
    }

    function get_safe_value($con,$str){
        return mysqli_real_escape_string($con,$str);
    }

    ///upload image for logo/logo

    function uploadImageLogo($image_file_name,$image_file_tmp_name){
        $error_array =array();

        $target_dir = "images/logo/";
        $target_file = $target_dir . basename($image_file_name);
        $image_name = get_safe_value($GLOBALS['con'],$image_file_name);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $checkSize = getimagesize($image_file_tmp_name);
        if($checkSize !== false) {
            $uploadOk = 1;
        } else {
            array_push($error_array,"File is not an image.");
            $uploadOk = 0;
        }
        // Check if file already exists
        // if (file_exists($target_file)) {
        //     array_push($error_array,"Sorry, file already exists.");
        //     $uploadOk = 0;
        // }
        // Check file size
        if ($_FILES["image_file"]["size"] > 500000) {
            array_push($error_array,"Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "webp" ) {
            array_push($error_array,"Sorry, only JPG, JPEG, PNG & WEBP files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($error_array,"Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                    array_push($error_array,"The file ". htmlspecialchars( basename( $image_file_name)). " has been uploaded.");
                } else {
                    array_push($error_array,"Sorry, there was an error uploading your file.");
                }
        }
        return $response = array("status"=>$uploadOk,"message"=>$error_array);
    }

    ///upload image for product/product

    function uploadProductImage($image_file_name,$image_file_tmp_name){
        $error_array =array();

        $target_dir = "images/product/";
        $target_file = $target_dir . basename($image_file_name);
        $image_name = get_safe_value($GLOBALS['con'],$image_file_name);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $checkSize = getimagesize($image_file_tmp_name);
        if($checkSize !== false) {
            $uploadOk = 1;
        } else {
            array_push($error_array,"File is not an image.");
            $uploadOk = 0;
        }
        // Check if file already exists
        // if (file_exists($target_file)) {
        //     array_push($error_array,"Sorry, file already exists.");
        //     $uploadOk = 0;
        // }
        // Check file size
        if ($_FILES["image_file"]["size"] > 1000000) {
            array_push($error_array,"Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "webp" ) {
            array_push($error_array,"Sorry, only JPG, JPEG, PNG & WEBP files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($error_array,"Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                    array_push($error_array,"The file ". htmlspecialchars( basename( $image_file_name)). " has been uploaded.");
                } else {
                    array_push($error_array,"Sorry, there was an error uploading your file.");
                }
        }
        return $response = array("status"=>$uploadOk,"message"=>$error_array);
    }

    function getUserName($user_id){
        $qu = "select * from users where user_id ='$user_id'";
        $res = mysqli_query($GLOBALS['con'],$qu);
        $value = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)>0){
            return $value['name'];
        }else{
            return 'Dumy';
        }
        
    }
?>