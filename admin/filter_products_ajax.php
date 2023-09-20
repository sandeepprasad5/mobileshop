<?php
include_once('functions.inc.php');
require_once('connection.inc.php');
$GLOBALS['con'] = $con;

$product_code = get_safe_value($GLOBALS['con'], $_POST['product_code']) ?? '';
$product_name = get_safe_value($GLOBALS['con'], $_POST['product_name']) ?? '';
$product_status = get_safe_value($GLOBALS['con'], $_POST['product_status']) ?? '';

// Prepare the SQL query based on the provided criteria
$sql = "select * from products where 1=1";

if (!empty($product_code)) {
    $sql .= " and sku LIKE '%$product_code%'";
}
if (!empty($product_name)) {
    $sql .= " and name LIKE '%$product_name%'";
}

if (!empty($product_status)) {
    $sql .= " and status = $product_status";
} else if($product_status =='0'){
    $sql .= " and status ='0'";
} else{
    $sql .= "";
}

$result = mysqli_query($GLOBALS['con'], $sql);

if (mysqli_num_rows($result) > 0) {
    $i = 0;
    $output = ''; // Initialize the output variable
    while ($row = mysqli_fetch_assoc($result)) {
        $i++;
        $output .= '
            <tr>
                <td class="serial">' . $i . '.</td>
                <td> <span class="name">' . $row['name'] . '</span> </td>
                <td> <span class="name">' . $row['sku'] . '</span> </td>
                <td class="avatar pb-0">
                    <div class="round-img">
                        <a href="#"><img class="rounded-circle" src="images/product/' . $row['image'] . '" alt=""></a>
                    </div>
                </td>
                <td>'; // Add status column here
    if ($row['status'] == 1) {
        $output .= '<a href="products.php?set_id=' . $row['id'] . '&set_status=' . $row['status'] . '"><span class="badge badge-complete">ACTIVED</span></a>';
    } else {
        $output .= '<a href="products.php?set_id=' . $row['id'] . '&set_status=' . $row['status'] . '"><span class="badge badge-complete">DEACTIVED</span></a>';
    }
    $output .= '</td>
            <td> <span class="name">' . ($row['featured_status'] == '1' ? 'Yes' : 'No') . '</span> </td>
            <td>
                <a href="add_product.php?id=' . $row['id'] . '"><span class="badge badge-complete">Edit</span></a>
            </td>
            <td>
                <a href="products.php?delete=' . $row['id'] . '"><span class="badge badge-complete">DELETE</span></a>
            </td>
        </tr>';
    }
} else {
    $output = '<tr><td colspan="5">No products found.</td></tr>';
}

// Echo the output to send it back to the AJAX request
echo $output;
?>
