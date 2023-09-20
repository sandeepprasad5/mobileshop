<?php

require_once('header.php'); 
require_once('navbar.php');

?>
<head>
    <title>Thank You for Your Order</title>
</head>
<body>
    <div style="text-align: center;margin-top: 60px;">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been successfully processed.</p>

        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> <?php echo isset($_GET['order_id']) ? $_GET['order_id'] : 'N/A'; ?></p>
    </div>
</body>
</html>

<?php
// Clear session data except for user_id
///if (isset($_SESSION['order_id'])) {
    unset($_SESSION['order_id']);
    unset($_SESSION['total_amount_to_deduct']);
    unset($_SESSION['cart']);
//}

require_once('footer.php');

?>
 <script>
    $(document).ready(function() {
        // remove class cart
        $('.cart').hide();
    });
</script>
