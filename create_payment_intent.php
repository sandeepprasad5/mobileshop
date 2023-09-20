<?php
session_start();
include_once('admin/connection.inc.php'); // Include your database or configuration file
require_once 'vendor/autoload.php'; // Include the Composer autoloader
// Calculate the payment amount (replace this with your logic)

if (isset($_SESSION['total_amount_to_deduct'])) {
    $paymentAmount = intval($_SESSION['total_amount_to_deduct']);
}else{
    $paymentAmount = 01; // Example amount in cents
}

// Create a Payment Intent on the server
\Stripe\Stripe::setApiKey('sk_test_51Nl54DSFJbAEARhVcW6cTq6tBSWkKUmmIasnRsqfwo6ZzFvRwsy5pkbPDrrTDUJvNNWNUARqnnlrMRlGo8GmNmzC00ydYHvpyj'); // Replace with your Stripe secret key

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $paymentAmount,
        'currency' => 'inr', // Replace with your desired currency
        'payment_method_types' => ['card'],
    ]);

    // Return the client secret as JSON
    echo json_encode([
        'client_secret' => $paymentIntent->client_secret,
    ]);
} catch (Exception $e) {
    // Handle any errors
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
