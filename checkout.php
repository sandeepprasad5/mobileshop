<?php   
require_once('header.php');
require_once('navbar.php');
require_once('jsfunction.php');
require_once('functions.php');
//$cart = $_SESSION['cart'];
//pr($cart);
//print '<pre>';
//print_r($_SESSION);
// Retrieve the query parameters
$passData = $_GET;
//print_r($passData);
$passDataJson = json_encode($passData);
$encodedpassData = urlencode($passDataJson);
$total = $_GET['total'];
$_SESSION['total_amount_to_deduct'] = $total;
$cartDetails = json_decode(urldecode($_GET['cart']), true);
$discountedTotal = isset($_GET['couponValue']) ? $_GET['couponValue'] : null;
$couponDetailsCode = isset($_GET['couponCode']) ? $_GET['couponCode'] : null;
$couponDetailsType = isset($_GET['couponType']) ? $_GET['couponType'] : null;


?>
<head>
    <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<style>
    .modal{
        z-index: 99999;
    }
</style>

</head>
<body>
<div class="container mt-5">
        <h1 class="mb-4">Checkout</h1>
        <h2 class="mb-3">Cart Summary</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartDetails as $item) : ?>
                <tr>
                    <td><?= $item['productName'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($discountedTotal == '') : ?>
        <p class="h4">Total Price: $<?= number_format($total, 2) ?></p>
        <?php endif; ?>

        <?php if ($discountedTotal != '') : ?>
        <h2 class="mb-3">Discount Breakdown</h2>
        <p>Coupon Code: <?=$couponDetailsCode ?></p>
        <?php if ($couponDetailsType === 'percentage') : ?>
        <p>Discount: $<?= number_format($discountedTotal,2) ?></p>
        <?php elseif ($couponDetailsType === 'fixed_amount') : ?>
        <p>Discount: $<?= number_format($discountedTotal, 2) ?></p>
        <?php endif; ?>
        <p class="h4">Final Amount (with Discount): $<?= number_format($total, 2) ?></p>
        <?php endif; ?>

        <div class="mt-4">
            <h2 class="mb-3">Payment</h2>
            
                <input type="hidden" name="total" value="<?= $discountedTotal !== null ? $discountedTotal : $total ?>">
                <!--<input type="hidden" name="cartDetails" value=" //htmlspecialchars(json_encode($cartDetails)) ">-->
                <button class="btn btn-primary" id="proceedToPaymentBtn" type="submit">Proceed to Payment</button>
            
        </div>
    </div>

    

<?php   
require_once('footer.php'); 
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script>
$(document).ready(function() {
   
});
</script>
</body>
</html>
