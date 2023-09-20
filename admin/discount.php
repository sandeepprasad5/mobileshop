<?php include_once('header.php'); ?>
<style>
    /* CSS to make the class look clickable */
    .dis_activation {
      cursor: pointer; /* Show the pointer cursor on hover */
      background-color: #f2f2f2; /* Optional background color on hover */
      padding: 5px 10px; /* Add some padding to give space around the text */
      border-radius: 5px; /* Optional: Add rounded corners to the box */
    }

    /* Optional: Hover effect to make it more noticeable */
    .dis_activation:hover {
      background-color: #eaeaea; /* Change background color on hover */
    }
  </style>
<div class="container mt-4">
  <h2>Discount Coupons</h2>
  <table id="couponTable" class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>Code <i class="fas fa-sort"></i></th>
        <th>Discount <i class="fas fa-sort"></i></th>
        <th>Discount Category<i class="fas fa-sort"></i></th>
        <th>Discount value<i class="fas fa-sort"></i></th>
        <th>Expiration Date <i class="fas fa-sort"></i></th>
        <th>Status <i class="fas fa-sort"></i></th>
      </tr>
    </thead>
    <tbody>
     <?php
        $queryDiscounts = "select * from discounts";
        $resultDiscounts = mysqli_query($con,$queryDiscounts);
        while($rowDiscounts = mysqli_fetch_assoc($resultDiscounts)){
     ?>
      <tr>
        <td><?=$rowDiscounts['coupon_code']?></td>
        <td><?=$rowDiscounts['discount_type']?></td>
        <td><?=$rowDiscounts['product_category']?></td>
        <td><?=$rowDiscounts['discount_value']?></td>
        <td><?=$rowDiscounts['end_date']?></td>
        <td class="dis_activation" data-id="<?=$rowDiscounts['id'];?>" data-status="<?=$rowDiscounts['is_active'];?>"> <?=$rowDiscounts['is_active']==1?'Active':'Inactive'?></td>
      </tr>
      <?php } ?>
      <!-- Add more coupon rows as needed -->
    </tbody>
  </table>
</div>
<?php include_once('footer.php');?>
<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Add DataTables JS for advanced table features -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize DataTables plugin for advanced table features
    $('#couponTable').DataTable({
      // Enable sorting on all columns
      "ordering": true,
      // Add icons for sorting
      "language": {
        "sortAscending": '<i class="fas fa-sort-up"></i>',
        "sortDescending": '<i class="fas fa-sort-down"></i>'
      }
    });

  });
    // Attach click event handler to each coupon code
    $(".dis_activation").click(function() {
        let couponId = $(this).data("id");
        let couponStatus = $(this).data("status");

        // Send AJAX request to update the coupon status
        $.ajax({
          url: "update_coupon_status.php",
          method: "POST",
          data: { id: couponId, status: couponStatus },
          dataType: "json",
          success: function(response) {

            // Update the status on the page if the update was successful
            if (response.success == true) {
               //alert(response.neWstatus);
              
              // Replace the data-id and data-status attributes with JSON response values
              let newStatusText = response.neWstatus == 1 ? "Active" : "Inactive";

              // Find the <td> element with matching data-id attribute
              var tdElement = $("td.dis_activation[data-id='" + response.id + "']");

              // Update the data-status attribute with JSON response status
              //tdElement.attr("data-status", response.neWstatus);
              tdElement.data("status", response.neWstatus);

              // Update the text content of the <td> element with JSON response text
              tdElement.text(newStatusText);

            }
          }
        });
      });
</script>

