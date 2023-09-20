<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])){
    $id = $_POST['productId'];
    unset($_SESSION['cart'][$id]);
    // Return a success message or response if needed
    echo json_encode(['message' => 'Product removed successfully']);

}else{
    // Return an error message or response if needed
    echo json_encode(['message' => 'Error removing product']);
}
?>