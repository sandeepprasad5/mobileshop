<?php   
session_start();
require_once('header.php'); 
//require_once('navbar.php');
 
if (isset($_POST['logout'])) {
  unset($_SESSION['user_id']); // Unset the session variable
}
//$cart = $_SESSION;
//print '<pre>';
//print_r($_SESSION);
// Retrieve the query parameters

if(!isset($_SESSION['user_id'])){
    echo '<h1>Not Accesable</h1>';
}else{

?>
<script src="https://js.stripe.com/v3/"></script>

<body>
<a href="index.php" class="btn btn-secondary" style="position: absolute;top: 11px;left: 110px;">Home</a>
<br>
    <div class="container mt-5">
        <h1 class="mb-4">Payment Process</h1>
        
        <form action="successful_payment.php" method="post">
        <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="shipping_address">Street Address:</label>
                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="4"></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="form-group col-md-3">
                    <label for="cistatestatety">State:</label>
                    <input type="text" class="form-control" id="state" name="state">
                </div>
                <div class="form-group col-md-6">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" name="country">
                </div>
            </div>
            <div class="form-group" id="card-element">
            </div>
            
            
            
            <div class="form-group">
                <label for="payment_amount">Payment Amount:</label>
                <input type="text" class="form-control" id="payment_amount" name="payment_amount" value="<?=$_SESSION['total_amount_to_deduct']?>" readonly>
            </div>
            <!-- Add a hidden field for the Stripe Payment Intent client secret -->
            <input type="hidden" id="payment_intent_client_secret" name="payment_intent_client_secret">

            <button type="submit" class="btn btn-primary" id="proceed_to_payment">Proceed to Payment</button>
            
        </form>
    </div>

<?php
}
    require_once('footer.php'); 
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Initialize Stripe with your publishable key
    var stripe = Stripe('pk_test_51Nl54DSFJbAEARhV5xTBetPXHXB1U096ACRwzqetLwXmUvXtJ7cmfC5wxiCoJCv0lkpDc1CnwhsYIYrjVv5K9VbZ00SdIAIYs8');
    
    // Initialize the Elements
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element'); // Replace '#card-element' with the ID or class of your card element container
    // Create a Payment Intent on the server
    fetch('create_payment_intent.php', {
        method: 'POST'
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        var paymentIntentClientSecret = data.client_secret;

        // Set the Payment Intent client secret in the hidden field
        document.getElementById('payment_intent_client_secret').value = paymentIntentClientSecret;

        // Handle button click to proceed to payment
        document.getElementById('proceed_to_payment').addEventListener('click', function() {
            // Create a payment method object with the card element
            stripe.createPaymentMethod('card', cardElement)
            .then(function(result) {
                if (result.error) {
                    // Handle errors, such as card validation errors
                    // You can display an error message to the user
                    console.error(result.error.message);
                } else {
                    // Payment method creation was successful
                    // Pass the payment method ID to confirmCardPayment
                    stripe.confirmCardPayment(paymentIntentClientSecret, {
                        payment_method: result.paymentMethod.id
                    })
                    .then(function(confirmResult) {
                        if (confirmResult.error) {
                            // Handle payment confirmation errors
                            console.error(confirmResult.error.message);
                        } else {
                            
                            // Payment successful, submit the form
                           document.querySelector('form').submit();
                           // Payment successful, redirect to index.php
                            //window.location.href = 'successful_payment.php';
                        }
                    });
                }
            });
    });
    });


});
    </script>

</body>