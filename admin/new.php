<!DOCTYPE html>
<html>
<head>
  <title>Manage Coupons</title>
  <!-- Add jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h2>Manage Coupons</h2>
  <table id="couponTable" border="1">
    <thead>
      <tr>
        <th>Coupon Code</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td data-id="1">SALE20</td>
        <td><span class="status" data-status="1">Active</span></td>
      </tr>
      <tr>
        <td data-id="2">SUMMER25</td>
        <td><span class="status" data-status="1">Active</span></td>
      </tr>
      <!-- Add more coupon rows as needed -->
    </tbody>
  </table>

  <script>
    $(document).ready(function() {
      // Attach click event handler to each coupon code
      $("td[data-id]").click(function() {
        let couponId = $(this).data("id");
        let currentStatus = $(this).find(".status").data("status");
        let newStatus = currentStatus === 1 ? 0 : 1; // Toggle status

        // Send AJAX request to update the coupon status
        $.ajax({
          url: "update_coupon_status.php",
          method: "POST",
          data: { id: couponId, status: newStatus },
          dataType: "json",
          success: function(response) {
            // Update the status on the page if the update was successful
            if (response.success) {
              let newStatusText = newStatus === 1 ? "Active" : "Inactive";
              $(`td[data-id="${couponId}"] .status`).text(newStatusText);
              $(`td[data-id="${couponId}"] .status`).data("status", newStatus);
            }
          }
        });
      });
    });
  </script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Coupons</title>
  <!-- Add jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h2>Manage Coupons</h2>
  <table id="couponTable" border="1">
    <thead>
      <tr>
        <th>Coupon Code</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td data-id="1">SALE20</td>
        <td><span class="status" data-status="1">Active</span></td>
      </tr>
      <tr>
        <td data-id="2">SUMMER25</td>
        <td><span class="status" data-status="1">Active</span></td>
      </tr>
      <!-- Add more coupon rows as needed -->
    </tbody>
  </table>

  <script>
    $(document).ready(function() {
      // Attach click event handler to each coupon code
      $("td[data-id]").click(function() {
        let couponId = $(this).data("id");
        let currentStatus = $(this).find(".status").data("status");
        let newStatus = currentStatus === 1 ? 0 : 1; // Toggle status

        // Send AJAX request to update the coupon status
        $.ajax({
          url: "update_coupon_status.php",
          method: "POST",
          data: { id: couponId, status: newStatus },
          dataType: "json",
          success: function(response) {
            // Update the status on the page if the update was successful
            if (response.success) {
              let newStatusText = newStatus === 1 ? "Active" : "Inactive";
              $(`td[data-id="${couponId}"] .status`).text(newStatusText);
              $(`td[data-id="${couponId}"] .status`).data("status", newStatus);
            }
          }
        });
      });
    });
  </script>
</body>
</html>
