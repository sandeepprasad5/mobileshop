<?php
// Include necessary files and database connection
include_once('functions.php');

if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Fetch product details based on $orderId from your database and store them in an array;
    
    $orderSpecificDetails = orderSpecificDetails($orderId);
    // print '<pre>';
    // print_r($orderSpecificDetails);
    $productDetails = array();

    while ($row = mysqli_fetch_assoc($orderSpecificDetails)) {
        $product = array(
            'product_name' => productname($row['product_id']),
            'product_image' => productImage($row['product_id']),
            //'selling_price' => $row['selling_price'],
            'quantity' => $row['quantity'],
            'subtotal' => $row['subtotal'],
            'sale_date' => $row['sale_date']
        );

        $productDetails[] = $product;
    }
    

    echo json_encode($productDetails);
} else {
    echo json_encode(array('error' => 'Invalid request.'));
}
?>
