<?php
session_start();

// Check if the cart session exists
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    // Get the product IDs from the cart session
    $productIds = array_keys($_SESSION['cart']);
    //print_r($productIds);
    // Return the product IDs in JSON format
    echo json_encode($productIds);
} else {
    // Return an empty array if the cart session is empty or doesn't exist
    echo json_encode([]);
}
?>
