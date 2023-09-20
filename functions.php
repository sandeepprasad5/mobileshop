<?php
include_once('admin/connection.inc.php');

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

function selectTopSixFeaturedProduct(){
    $sqlTopFea = "select * from featured where featured_status='1'  order by rand() limit 6";
    $qurTopFea = mysqli_query($GLOBALS['con'],$sqlTopFea);
    return $qurTopFea;
}

function getProductDetails($productId){
    $sqlFeaPro = "select * from products where id='$productId'";
    $qurFeaPro = mysqli_query($GLOBALS['con'],$sqlFeaPro);
    return $qurFeaPro;
}

function selectOtherProducts(){
    $sqlOthPro = "select * from products where status='1' order by rand() limit 12";
    $qurOthPro = mysqli_query($GLOBALS['con'],$sqlOthPro);
    return $qurOthPro;
}

function maxQuantity($pId){
    $sqlMaxQuan = "select quantity from products where id = '$pId'";
    $qurMaxQuan = mysqli_query($GLOBALS['con'],$sqlMaxQuan);
    $rowMaxQuan = (mysqli_fetch_assoc($qurMaxQuan));
    return $maxQuantity = $rowMaxQuan['quantity'];
    
}

function productDetails($pId){
    $sqlProDuct = "select * from products where id = '$pId'";
    $qurProDuct = mysqli_query($GLOBALS['con'],$sqlProDuct);
    $rowProDuct = mysqli_fetch_assoc($qurProDuct);
    return $rowProDuct;
}

function removeCartItem($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
        $_SESSION['cartCount'] = count($_SESSION['cart']); // Update cart count
        //header('Location: cart.php');
    }
  }

  function addUserInfo($name,$email,$password,$address){
    $ins_user_info = "insert into users (name,email,password,address,is_active) values ('$name','$email','$password','$address','1')";
    $ins_res_user_info = mysqli_query($GLOBALS['con'],$ins_user_info);
    return $ins_res_user_info;
  }

    function getUserNameEmail($user_id){
        $sqlUser = "select name,email from users where user_id = '$user_id'";
        $qurUser = mysqli_query($GLOBALS['con'],$sqlUser);
        $rowUser = (mysqli_fetch_assoc($qurUser));
        return $rowUser;
    }
  
    function myOrders($user_id){
        $sqlOrders = "select * from orders where user_id = $user_id order by order_date DESC";
        $qurOrders = mysqli_query($GLOBALS['con'],$sqlOrders);
        return $qurOrders;
    }

    function orderSpecificDetails($order_id){
        $sqlOrders = "select * from order_items where order_id = $order_id";
        $qurOrders = mysqli_query($GLOBALS['con'],$sqlOrders);
        return $qurOrders;
    }

    function productname($p_id){
        $sqlPname = "select name from products where id = $p_id";
        $qurPname = mysqli_query($GLOBALS['con'],$sqlPname);
        $rowPname = mysqli_fetch_assoc($qurPname);
        return $rowPname['name'];
    }

    function productImage($p_id){
        $sqlPimage = "select image from products where id = $p_id";
        $qurPimage = mysqli_query($GLOBALS['con'],$sqlPimage);
        $rowPimage = mysqli_fetch_assoc($qurPimage);
        return $rowPimage['image'];
    }
?>