<?php
require_once('connection.inc.php');

   
$GLOBALS['con'] = $con;
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

// Query to fetch product sales data
$sql = "SELECT DATE(sale_date) AS sale_date, SUM(quantity) AS total_sold
        FROM order_items
        GROUP BY DATE(sale_date)
        ORDER BY DATE(sale_date)";

$result = mysqli_query($GLOBALS['con'], $sql);

// Fetch data and prepare for JSON response
$productSalesData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $productSalesData[] = array(
        "date" => $row['sale_date'],
        "quantity" => intval($row['total_sold'])
    );
}

// Close the connection
//mysqli_close($GLOBALS['con']);

// Return the data as JSON
echo json_encode($productSalesData);die;
?>
