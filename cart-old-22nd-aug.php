<?php  
require_once('header.php'); 
require_once('navbar.php');
require_once('functions.php');
$cart = $_SESSION['cart'];
//pr($cart);

?>


<body>
<style>
.update-btn,
.remove-btn {
  display: inline-block;
  margin-right: 10px; /* Add spacing between buttons */
}
.update-btn {
  position: absolute;
  left: 204px;
  bottom: 15px;
}
.cart-item{
  position: relative;
}
    
</style>
<header>
  <h1>Shopping Cart</h1>
</header>

<main>
<div class="cart-items">
  <?php
     $totalPrice = 0.00;
     $totalItems = 0;
     foreach($cart as $key => $val){
     $maxQuantity = maxQuantity($key);
     $productDetails = productDetails($key);
     $totalPrice += $productDetails['selling_price'] * $val['quantity'];
     $totalItems = count($cart);
     //print_r($val);
  ?>
  <div class="cart-item">
    <div class="cart-item-image">
    <img src="admin/images/product/<?=$productDetails['image'];?>" alt="Product Image">
    </div>
    <div class="cart-item-details">
      <h2 class="cart-item-name" data-product-name="<?=$productDetails['name'];?>"><?=strtoupper($productDetails['name']);?></h2>
      <p class="cart-item-price" data-product-price="<?=$productDetails['selling_price'];?>">Price: $<?=number_format($productDetails['selling_price'] * $val['quantity'],2);?></p>
      <div class="quantity">
          <label for="quantity">Quantity:</label>
          <input type="number" class="quantity-input" min="1" max="<?=$maxQuantity;?>" value="<?php echo $val['quantity']; ?>" data-product-id="<?=$key;?>">
      </div>
      

      <button class="remove-btn" type="submit">Remove</button>
      
      
      <button class="update-btn">Update</button>
    </div>
  </div>
  <?php } ?>
</div>

    

  <div class="cart-summary new-cart-summary">
  <h3>Cart Summary</h3>
  <p class="total-items">Total Items: <span class="total-items-value"><?=$totalItems;?></span></p>
  <p class="total-price">Total Price: $<span class="total-price-value"><?= number_format($totalPrice, 2); ?></span></p>
  <button class="checkout-btn" type="button" data-toggle="modal" data-target="#checkoutModal">Checkout</button>
</div>
</main>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="checkoutModalLabel">Order Summary</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php //pr($cart);
          foreach($cart as $key => $val){
          $productDetails = productDetails($key);
          ?>
          <ul class="list-group">
            <!-- Loop through cart items and display them here -->
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <?=strtoupper($productDetails['name']);?>
              <span>Quantity: <?=$cart[$key]['quantity'];?></span>
            </li>
            <!-- Repeat for other cart items -->
          </ul>
          <?php } ?>
          <h4 class="mt-3">Total: $<span class="total-price-value2"><?= number_format($totalPrice, 2); ?></span></h4>
          <button type="button" class="btn btn-primary mt-3" data-toggle="collapse" data-target="#couponCollapse" aria-expanded="false" aria-controls="couponCollapse">
            Apply Coupon
          </button>
          <div class="collapse mt-3" id="couponCollapse">
            <div class="card card-body">
            <input type="text" id="couponCode" name="coupon" max="10" value="">
            <button type="button" id="applyCouponBtn">Apply Coupon</button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Proceed to Payment</button>
        </div>
      </div>
    </div>
  </div>




<?php require_once('footer.php'); ?>
  

<!-- Add your JavaScript code here -->
<script>
$(document).ready(function() {

  // Add an event listener to the modal's show.bs.modal event
  $('#checkoutModal').on('show.bs.modal', function(event) {
        // Reset the displayed price to the original total price
        $(".total-price-value2").html(<?= number_format($totalPrice, 2); ?>.toFixed(2));
    });

    var applyCouponBtn = $("#applyCouponBtn");
    // Attach keyup event handler to the coupon code input
    $("#applyCouponBtn").on("click", function() {
        // Call the coupon validation function on button click
        validateCouponCode();
    });

    function validateCouponCode() {
        var couponCode = $("#couponCode").val();
        
        // Make an AJAX request to validate the coupon code
        $.post("valid_coupon.php", {
            coupon: couponCode
        }, function(data) {
            // Handle the response
            if (data !== "invalid") {
                const parsedCouponData = JSON.parse(data);
                let discount_type = parsedCouponData.discount_type;
                let discount_value = parseFloat(parsedCouponData.discount_value);
                let totalPrice = parseFloat(<?= $totalPrice ?>); // Ensure $totalPrice is a PHP variable
                console.log(totalPrice);
                if (discount_type === 'percentage') {
                    let discountedFinalPrice = totalPrice * (1 - discount_value / 100);
                    console.log(discountedFinalPrice);
                    // Update the displayed price with the discounted value
                    $(".total-price-value2").html(discountedFinalPrice.toFixed(2));
                } else if (discount_type === 'fixed_amount') {
                    let discountedFinalPrice = totalPrice - discount_value;
                    console.log(discountedFinalPrice);
                    // Update the displayed price with the discounted value
                    $(".total-price-value2").html(discountedFinalPrice.toFixed(2));
                } else {
                    alert("Coupon code type is not defined");
                }
            } else {
                alert("Invalid coupon code.");
                // You can reset the displayed price to the original value here
            }
        });
    }
});
  ////Handle "update quantity"
  $(".update-btn").on("click", function() {
    // Retrieve product details from form
    var productId = $(this).closest('.cart-item').find('.quantity-input').data('product-id');
    var newQuantity = $(this).closest('.cart-item').find('.quantity-input').val();
    var productPrice = $(this).closest('.cart-item').find('.cart-item-price').data("product-price");
    var newTotalPrice = (parseFloat(productPrice) * parseInt(newQuantity)).toFixed(2);
    
    // Update the displayed price
    $(this).closest('.cart-item').find('.cart-item-price').html("Price: $" + newTotalPrice);

    //update total price in cart summery
    var cartTotalPrice = 0.00;
    $(".cart-item").each(function() {
      var cartProductPrice = $(this).find('.cart-item-price').data("product-price");
      var cartProductQuantity = $(this).find('.quantity-input').val();
      cartTotalPrice += parseFloat(cartProductPrice) * parseInt(cartProductQuantity);
    });
    
    // Update the displayed total price in the cart summary
    $(".total-price-value").html(cartTotalPrice.toFixed(2));
    $(".total-price-value2").html(cartTotalPrice.toFixed(2));
    localStorage.setItem('cartTotalPrice', cartTotalPrice.toFixed(2));
    // Add the product details to the session using AJAX
    $.post("add_to_cart.php", 
    {
      productId: productId,
      newQuantity: newQuantity,
    }, function(data) {
       //console.log(data);
    // Update cart count after successful addition
    });
  });

  //handel remove button
  $(".remove-btn").on("click", function() {
    var $this = $(this);
    // Retrieve product details from the button's data attribute
    var productId = $(this).closest('.cart-item').find('.quantity-input').data('product-id');
    
    // Remove the product using AJAX
    $.post("delete_to_cart.php", 
    {
      productId: productId
    }, function(data) {
      //zconsole.log(data); // You can use this to check the response from the server
      const parsedData = JSON.parse(data);
      // If the removal was successful, remove the cart item from the UI
      if (parsedData.message === 'Product removed successfully') {
        $this.closest('.cart-item').remove();
        
        // Update total price in cart summary
        var cartTotalPrice = 0.00;
        var totalItems = 0;
        $(".cart-item").each(function() {
          var cartProductPrice = $(this).find('.cart-item-price').data("product-price");
          var cartProductQuantity = $(this).find('.quantity-input').val();
          cartTotalPrice += parseFloat(cartProductPrice) * parseInt(cartProductQuantity);
          totalItems += parseInt(cartProductQuantity); // Update totalItems count
          
        });

        // Update the displayed total price in the cart summary
        $(".total-price-value").html(cartTotalPrice.toFixed(2));
        
        localStorage.setItem('cartTotalPrice', cartTotalPrice.toFixed(2));
        $(".total-items-value").html(totalItems);
      }
    });
  });

</script>
  
</body>

</html>
