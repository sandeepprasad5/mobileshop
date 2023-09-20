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
  <h2>Store Users</h2>
  <table id="usersTable" class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>Name <i class="fas fa-sort"></i></th>
        <th>Email <i class="fas fa-sort"></i></th>
        <th>Password<i class="fas fa-sort"></i></th>
        <th>Address<i class="fas fa-sort"></i></th>
        <th>status<i class="fas fa-sort"></i></th>
        <th>View<i class="fas fa-sort"></i></th>
      </tr>
    </thead>
    <tbody>
     <?php
        $queryUsers = "select * from users";
        $resultUsers = mysqli_query($con,$queryUsers);
        while($rowUsers = mysqli_fetch_assoc($resultUsers)){
     ?>
      <tr>
        <td><?=$rowUsers['name']?></td>
        <td><?=$rowUsers['email']?></td>
        <td><?=$rowUsers['password']?></td>
        <td><?=$rowUsers['address']?></td>
        <td class="dis_activation" data-id="<?=$rowUsers['user_id'];?>" data-status="<?=$rowUsers['is_active'];?>"> <?=$rowUsers['is_active']==1?'Active':'Inactive'?></td>
        <td>
            <a href="store_user_details.php?view=<?=$rowUsers['user_id']?>"><span class="badge badge-complete">Edit</span></a>
        </td>
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
    $('#usersTable').DataTable({
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
          url: "update_store_user_status.php",
          method: "POST",
          data: { id: couponId, status: couponStatus },
          dataType: "json",
          success: function(response) {

            // Update the status on the page if the update was successful
            if (response.success == true) {
               
              
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

