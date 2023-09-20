<?php
   require_once('header.php');
   require_once('query.php');

   $getlastFiveDaysDate = getlastFiveDaysDate();
   
  // Fetch data into arrays
  $labels = array();
  $data = array();
  while ($row = mysqli_fetch_assoc($getlastFiveDaysDate)) {
      $labels[] = $row['order_date'];
      $data[] = $row['order_count'];
  }
  

?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Admin Dashboard</title>

<body>
  <div class="container mt-5">
    <h2>Product Sales Chart</h2>
    <div class="row">
      <div class="col-md-12">
        <canvas id="productSalesChart"></canvas>
      </div>
    </div>
  </div>

  
</body>

<?php require_once('footer.php');?>
<!-- Include necessary JS libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Sample data (replace with your actual data for the last five days)
  var labels = <?php echo json_encode($labels); ?>;
  var data = <?php echo json_encode($data); ?>;
  var lastFiveDaysData = {
    labels: labels, // Date labels
    datasets: [
      {
        label: "Products Sold",
        data: [5, 8, 12, 10, 15], // Replace with your actual sales data for the last five days
        borderColor: "rgba(75, 192, 192, 1)",
        borderWidth: 2,
        fill: false, // To make it a line chart without area fill
      },
    ],
  };

  // Get the canvas element
  var ctx = document.getElementById("productSalesChart").getContext("2d");

  // Create the chart
  var myLineChart = new Chart(ctx, {
    type: "line", // Use 'line' for a line chart
    data: lastFiveDaysData,
    options: {
      responsive: true,
      scales: {
        x: {
          title: {
            display: true,
            text: "Date",
          },
        },
        y: {
          title: {
            display: true,
            text: "Products Sold",
          },
        },
      },
    },
  });
</script>


         