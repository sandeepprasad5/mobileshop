$(document).ready(function() {
    console.log('test');
    // Fetch data from the PHP script using AJAX
    $.ajax({
      url: "custom_script.php", // Replace with the correct path to your PHP script
      dataType: "json",
      success: function(data) {
        console.log(data);
        // Parse the received JSON data
        var salesData = [];
        var dates = [];
     
        for (var i = 0; i < data.length; i++) {
          salesData.push(data[i].quantity);
          dates.push(data[i].date);
        }
  
        // Create the chart using Chart.js
        var ctx = document.getElementById("productSalesChart").getContext("2d");
        var myChart = new Chart(ctx, {
          type: "line",
          data: {
            labels: dates,
            datasets: [{
              label: "Product Sales",
              data: salesData,
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      },
      error: function() {
        console.log("Failed to fetch data from the server on error handling.");
      }
    });
  });