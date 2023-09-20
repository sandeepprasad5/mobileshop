<?php
require_once('connection.inc.php');
// Assuming you have a database connection
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $userId = $_POST['id'];
    $oldStatus = $_POST['status'];
    $newStatus = '0';
    
    $oldStatus =='1'?$newStatus = '0':$newStatus = '1';

    // Perform server-side validation and additional security checks if necessary

    // Update the coupon's status in the database
    // Replace "coupons_table" with your actual table name
    $sql = "UPDATE users SET is_active ='$newStatus' WHERE user_id = '$userId'";
    $stmt = mysqli_query($con,$sql);
    //$row = mysqli_fetch_assoc($stmt);

    //$data = array('status'=> $newStatus, 'id'=> $userId);
    // Return a response to the client
    $response = array('success' => true,'neWstatus'=> $newStatus, 'id'=> $userId);
    echo json_encode($response);
} else {
    // Return an error response if the request is invalid
    $response = array('success' => false);
    echo json_encode($response);
}
?>