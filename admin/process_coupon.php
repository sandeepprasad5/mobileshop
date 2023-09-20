<?php ob_start(); require_once('header.php');
if(isset($_POST['add_coupon'])){
    $coupon_code = get_safe_value($con,$_POST['coupon_code']);
    $discount_type = get_safe_value($con,$_POST['discount_type']);
    $discount_value = get_safe_value($con,$_POST['discount_value']);
    $product_category = get_safe_value($con,$_POST['product_category']);
    $start_date = get_safe_value($con,$_POST['start_date'])??'';
    $end_date = get_safe_value($con,$_POST['end_date'])??'';
    $is_active = get_safe_value($con,$_POST['is_active']??'0');

    $ins_discount_query = "insert into discounts (coupon_code,discount_type,discount_value,product_category,start_date,end_date,is_active) values ('$coupon_code','$discount_type','$discount_value','$product_category','$start_date','$end_date','$is_active')";
    $ins_discount_result = mysqli_query($GLOBALS['con'],$ins_discount_query);
    if($ins_discount_result == '1'){
        header('location:discount.php');
    }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
}


?>