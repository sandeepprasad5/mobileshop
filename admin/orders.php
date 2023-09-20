<?php 
require_once('header.php'); 
require_once('query.php');
?>
  <div class="container mt-5">
    <h2 >Order List</h2><br>
    <table id="ordersTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Total Amount</th>
          <th>Status</th>
          <th>Order Date</th>
          <th>Order Details</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $queryOrders = "select * from orders";
        $resultOrders = mysqli_query($con,$queryOrders);
        while($rowOrders = mysqli_fetch_assoc($resultOrders)){
        ?>
        <tr>
          <td><?=$rowOrders['order_id']?></td>
          <td><?= getUserName($rowOrders['user_id']); ?></td>
          <td><?=$rowOrders['total_amount']?></td>
          <td><?=$rowOrders['status']?></td>
          <td><?=$rowOrders['order_date']?></td>
          <td>
              <a href="order_details.php?order=<?=$rowOrders['order_id']?>"><span class="badge badge-complete">View Details</span></a>
          </td>
          <td class="userModal">
            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelModal" data-order-id="<?=$rowOrders['order_id']?>">Cancel</a>
          </td>
        </tr>
        <?php } ?>
        <!-- Add more rows for other orders here -->
      </tbody>
    </table>
  </div>

  <!-- Cancel Order Modal -->
  <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelModalLabel">Cancel Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="cancelForm">
            <div class="form-group">
              <label for="cancelReason">Reason for Cancellation</label>
              <textarea class="form-control" id="cancelReason" rows="3" required></textarea>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Cancel Order</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('footer.php'); ?>

  <!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Add DataTables JS for advanced table features -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

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

 
      // Handle form submission
      $("#cancelForm").submit(function(event) {
        event.preventDefault();

        // Get order ID and cancellation reason from the form
        let orderId = $(".userModal .btn-danger").data("order-id");
    
        let reason = $("#cancelReason").val();

        // Send AJAX request to update the reason_of_cancellation
        $.ajax({
          url: "update_order_cancellation.php", // Replace with the URL to your PHP file
          method: "POST",
          data: { order_id: orderId, reason: reason },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              // Update the UI or show a success message if needed
              //alert("Order cancellation reason updated successfully.");
              // Close the modal
              jQuery("#cancelModal").modal("hide");
              location.reload(true);
            } else {
              alert("Failed to update order cancellation reason. Please try again.");
            }
          },
          error: function() {
            alert("Error: Unable to process the request.");
          }
        });
      });
    });
  </script>