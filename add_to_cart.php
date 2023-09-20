<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])){
    
    if(isset($_POST['newQuantity'])){
        $quantity = $_POST['newQuantity'];
    }else{
        $quantity = 1;
    }
    $id = $_POST['productId'];
    $_SESSION['cart'][$id] = array('quantity' => $quantity);
    header('Location: cart.php');
    
}else{
    echo 'Product has not been selected correctly';
}
?>
