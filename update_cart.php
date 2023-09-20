<?php
session_start();
require_once('functions.php');

if (isset($_POST['productId']) && isset($_POST['newQuantity'])) {
  $productId = $_POST['productId'];
  $newQuantity = $_POST['newQuantity'];



  // Update the cart
  foreach ($_SESSION['cartItems'] as &$product) {
    if ($product['id'] === $productId) {
      $product['quantity'] = $newQuantity;
      break;
    }
  }

  // Update database quantity
  //updateDatabaseQuantity($productId, $newQuantity);

  
  // Calculate new total price and items
  $totalPrice = 0;
  foreach ($_SESSION['cartItems'] as $product) {
    if (isset($product['quantity'])) { // Check if 'quantity' key exists
        $priceNumeric = preg_replace('/[^0-9.]/', '', $product['price']);
        $totalPrice += floatval($priceNumeric) * $product['quantity'];
    }
  }
  $totalItems = count($_SESSION['cartItems']);

  // Prepare response
  $response = [
    'totalPrice' => number_format($totalPrice, 2),
    'totalItems' => $totalItems,
    'updatedProduct' => [
      'id' => $productId,
      'quantity' => $newQuantity
    ]
  ];

  echo json_encode($response);
}
?>
