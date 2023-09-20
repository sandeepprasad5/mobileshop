<?php 
include_once('header.php'); 
include_once('navbar.php'); 
include_once('functions.php');
?>
<?php
if(isset($_SESSION['user_id'])){
    $user_id =  $_SESSION['user_id'];
    $myOrders = myOrders($user_id);
}else{
    echo 'not accesable';die;
}
    
?>
<body>
    <div class="container">
        <h1>Order History</h1>
        <!-- Filtering options here -->
        <table class="table table-bordered table-striped" id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date & Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP loop to populate order history table -->
                <?php while($order = mysqli_fetch_assoc($myOrders)){ ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm open-modal" data-toggle="modal" data-target="#orderModal" data-order-id="<?=$order['order_id']?>">View Details</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<!--  Order Details Modal -->
<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row" id="productDetails">
                        
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <img src="" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <p class="card-text">Price: $</p>
                                        
                                            <p class="card-text">Quantity: $</p>
                                        
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
                <p>Total Price: <span id="totalPrice"></span></p>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<!-- Add DataTables JS for advanced table features -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>


<script>

// Add an event listener to the buttons with the "open-modal" class
$('.open-modal').click(function(event) {
    event.preventDefault(); // Prevent the default behavior of the link
    
    var orderId = $(this).data('order-id'); // Extract order ID from the clicked button
    console.log(orderId);
    // Open the modal with the specified ID
    $('#orderModal').modal('show');

    // AJAX request to fetch and populate modal content
    $.ajax({
        type: 'POST',
        url: 'get_order_details.php',
        data: { order_id: orderId },
        dataType: 'json',
        success: function (response) {
        // Assuming response is an array of product objects

        // Select the container where you want to display product details
        var productDetailsContainer = $('#productDetails');

        // Clear any existing content in the container
        productDetailsContainer.empty();

        // Initialize a variable to calculate the total price
        var totalPrice = 0;

        // Loop through each product in the response
        $.each(response, function (index, product) {
            // Create a new card for the product
            var productCard = $('<div class="col-md-4"><div class="card mb-3">' +
                '<img src="admin/images/product/' + product.product_image + '" class="card-img-top" alt="Product Image">' +
                '<div class="card-body">' +
                '<h5 class="card-title">' + product.product_name + '</h5>' +
                '<p class="card-text quantity">Quantity: ' + product.quantity + '</p>' +
                '<p class="card-text subtotal">Subtotal: $' + parseFloat(product.subtotal).toFixed(2) + '</p>' +
                '<p class="card-text sale-date">Date: ' + product.sale_date + '</p>' +
                '</div></div></div>');

            // Append the product card to the container
            productDetailsContainer.append(productCard);

            // Add the subtotal to the total price
            totalPrice += parseFloat(product.subtotal);
        });

        // Update the total price in the modal
        $('#totalPrice').text('Total Price: $' + totalPrice.toFixed(2));
        },
        error: function () {
            alert('Error loading product details.');
        }
    });
});


</script>
<script>
  $(document).ready(function() {

    // Initialize DataTables plugin for advanced table features
    $('#ordersTable').DataTable({
      // Enable sorting on all columns
      "ordering": true,
      // Add icons for sorting
      "language": {
        "sortAscending": '<i class="fas fa-sort-up"></i>',
        "sortDescending": '<i class="fas fa-sort-down"></i>'
      }
    });

});
</script>
</html>
