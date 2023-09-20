<?php
require_once('connection.inc.php');
// Assuming you have a database connection
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['reason'])) {
     $ordeId = $_POST['order_id'];
     $reason = $_POST['reason'];
   
    // Perform server-side validation and additional security checks if necessary

    // Update the coupon's status in the database
    // Replace "coupons_table" with your actual table name
    $sql = "UPDATE orders SET reason_for_cancellation ='$reason',status = 'Cancel' WHERE order_id = '$ordeId'";
    $stmt = mysqli_query($con,$sql);
    //$row = mysqli_fetch_assoc($stmt);

    //$data = array('status'=> $newStatus, 'id'=> $couponId);
    // Return a response to the client
    $response = array('success' => true);
    echo json_encode($response);
} else {
    // Return an error response if the request is invalid
    $response = array('success' => false);
    echo json_encode($response);
}
?>