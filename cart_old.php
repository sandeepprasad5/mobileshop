<?php   
require_once('header.php'); 
require_once('navbar.php');
require_once('functions.php');

if (isset($_POST['removeProductId'])) {
  $removeProductId = $_POST['removeProductId'];
  removeCartItem($removeProductId);
}
function removeCartItem($productId) {
  foreach ($_SESSION['cartItems'] as $key => $product) {
      if ($product['id'] === $productId) {
          unset($_SESSION['cartItems'][$key]);
          $_SESSION['cartItems'] = array_values($_SESSION['cartItems']); // Reindex the array
          $_SESSION['cartCount'] = count($_SESSION['cartItems']); // Update cart count
          break;
      }
  }
}

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
  left: 196px;
  bottom: 30px;
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
  <?php foreach ($_SESSION['cartItems'] as $product) {
    $maxQuantity = maxQuantity($product['id']);
    //pr($_SESSION['cartItems']);
  ?>

    <div class="cart-item" data-product-ids="<?=$product['id']?>">
      <div class="cart-item-image">
        <img src="<?=$product['image'];?>" alt="Product Image">
      </div>
      <div class="cart-item-details">
        <h2><?=$product['name'];?></h2>
        <p class="cart-item-price">Price: <?=$product['price'];?></p>
        <div class="quantity">
          <label for="quantity">Quantity:</label>
          <input type="number" class="quantity-input" min="1" max="<?=$maxQuantity;?>" value="1" data-product-id="<?=$product['id'];?>">
        </div>
        
        <form method="post">
          <input type="hidden" name="removeProductId" value="<?=$product['id']; ?>">
          <button class="remove-btn" type="submit">Remove</button>
          
        </form>
        <button class="update-btn">Update</button>
      </div>
    </div>
  <?php } ?>
</div>

    

    <div class="cart-summary new-cart-summary">
      <h3>Cart Summary</h3>
      <!-- Example summary information -->
      <!-- Replace this with your actual cart summary information -->
      <?php
        $totalPrice = 0;
        foreach ($_SESSION['cartItems'] as $product) {
            // Extract the numeric value from the price (remove "$" and any other non-numeric characters)
            $priceNumeric = preg_replace('/[^0-9.]/', '', $product['price']);
            $totalPrice += floatval($priceNumeric); // Convert to float and add to total
            //extract total no. of items
            $totalItems = count($_SESSION['cartItems']);
        }
        ?>
      <p class="total-items">Total Items: <span class="total-items-value"><?=$totalItems??'0';?></span></p>
       <p class="total-price">Total Price: $<span class="total-price-value"><?php echo number_format($totalPrice, 2); ?></span></p>
      <button class="checkout-btn" type="button" data-toggle="modal" data-target="#checkoutModal">Checkout</button>
    </div>
  </main>

  <!-- Checked logged in or not -->

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
          <ul class="list-group">
            <!-- Loop through cart items and display them here -->
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Product 1
              <span>Quantity: 2</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Product 2
              <span>Quantity: 1</span>
            </li>
            <!-- Repeat for other cart items -->
          </ul>
          <h4 class="mt-3">Total: $35.00</h4>
          <button type="button" class="btn btn-primary mt-3" data-toggle="collapse" data-target="#couponCollapse" aria-expanded="false" aria-controls="couponCollapse">
            Apply Coupon
          </button>
          <div class="collapse mt-3" id="couponCollapse">
            <div class="card card-body">
              <!-- Coupon code input and apply button here -->
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


  <!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>

  <!-- end login modal -->


<?php require_once('footer.php'); ?>
  

<!-- Add your JavaScript code here -->

<script>
$(document).ready(function() {
  // Handle "Update" button click
  $('.update-btn').click(function() {
    var productId = $(this).closest('.cart-item').find('.quantity-input').data('product-id');
    var newQuantity = $(this).closest('.cart-item').find('.quantity-input').val();
  
    // Send AJAX request to update cart and database
    $.ajax({
        url: 'update_cart.php',
        type: 'POST',
        data: { productId: productId, newQuantity: newQuantity },
        success: function(response) {
        // console.log(response); // Check the structure of the response
        console.log(response); // Check the structure of the response
        const parsedResponse = JSON.parse(response);

        var totalPrice = parsedResponse.totalPrice;
        var updatedProductId = parsedResponse.updatedProduct.id;
        var updatedProductQuantity = parsedResponse.updatedProduct.quantity;
        // Find the appropriate cart item element by matching the data-product-id attribute
        var cartItem = $('.cart-item[data-product-ids="' + updatedProductId + '"]');
        // Update the total price within the cart item element
        cartItem.find('.cart-item-price').text('Total Price: ' + totalPrice);
      
        
       // Calculate total price by adding up the prices of all products
       var calculatedTotalPrice = 0;
        $('.cart-item').each(function() {
          var price = $(this).find('.cart-item-price').text();
          var numericPrice = parseFloat(price.replace('Total Price: $', ''));
          calculatedTotalPrice += numericPrice;
        });
        console.log(calculatedTotalPrice);
        // Update total price in cart summary
        $('.total-price-value').text('$' + calculatedTotalPrice.toFixed(2));

        // Update total items in cart summary
        var totalItems = parsedResponse.totalItems;
        $('.total-items-value').text(totalItems);
    
      },
      error: function(xhr, status, error) {
        console.log('AJAX Error:', status, error);
      }
    });
  });

  // Check if the user is logged in
  var isLoggedIn = false; // Set this based on your authentication logic

  // Open the appropriate modal
  $('#checkoutModal').on('show.bs.modal', function (event) {
      if (isLoggedIn) {
          $('#checkoutModal').modal('show');
          // Add your checkout modal logic here
      } else {
          // User is not logged in, open the login modal
          $('#checkoutModal').modal('hide');
          $('#loginModal').modal('show');
          
      }
  });


});

</script>


  
</body>

</html>
