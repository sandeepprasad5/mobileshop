<?php
session_start();
include_once('admin/connection.inc.php');
include_once('functions.php');
$GLOBALS['con'] = $con;

//php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


// 1. Retrieve Session Data
$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total_amount_to_deduct = $_SESSION['total_amount_to_deduct'];

$userData = getUserNameEmail($user_id);

if ($userData) {
    $user_name = $userData['name'];
    $user_email = $userData['email'];
} else {
    echo 'No user with the given ID was found';
}

//pr($cart);die;
// 2. Create an Order Record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //createCrmOrder();
    $shipping_address = $_POST['shipping_address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Validate and sanitize user input (consider using a validation library)
    $shipping_address = mysqli_real_escape_string($GLOBALS['con'], $_POST['shipping_address']);
    $city = mysqli_real_escape_string($GLOBALS['con'], $_POST['city']);
    $country = mysqli_real_escape_string($GLOBALS['con'], $_POST['country']);
} else {
    die('Method not POST'); // Terminate script if not a POST request
}

try {
    // Start a database transaction
    $GLOBALS['con']->begin_transaction();

    // Create the SQL statement to insert the order record using a prepared statement
    $order_date = date('Y-m-d H:i:s');
    $status = 'Paid';

    $insertOrderStmt = $GLOBALS['con']->prepare("INSERT INTO orders (user_id, product_ids, order_date, total_amount, shipping_address, city, country, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$insertOrderStmt) {
        die("Prepare failed: (" . $GLOBALS['con']->errno . ") " . $GLOBALS['con']->error);
    }

    $product_ids = implode(',', array_keys($cart));
    $insertOrderStmt->bind_param("issdssss", $user_id, $product_ids, $order_date, $total_amount_to_deduct, $shipping_address, $city, $country, $status);


    if ($insertOrderStmt->execute()) {
        // Get the last inserted order ID
        $order_id = $GLOBALS['con']->insert_id;

        // Iterate through cart items
        foreach ($cart as $product_id => $product) {
            $quantity = $product['quantity'];

            // Fetch the selling price of the product from the 'products' table
            $fetchPriceStmt = $GLOBALS['con']->prepare("SELECT selling_price FROM products WHERE id = ?");
            $fetchPriceStmt->bind_param("i", $product_id);
            $fetchPriceStmt->execute();
            $fetchPriceStmt->bind_result($selling_price);

            // Check if a row was found (product exists)
            if ($fetchPriceStmt->fetch()) {
                $fetchPriceStmt->close();

                // Calculate the total price for this product
                $total_price = $selling_price * $quantity;

                // Update the quantity in the 'products' table (Use a prepared statement)
                $updateQuantityStmt = $GLOBALS['con']->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
                $updateQuantityStmt->bind_param("ii", $quantity, $product_id);
                $updateQuantityStmt->execute();

                // Insert into 'order_items' using a prepared statement
                $insertOrderItemStmt = $GLOBALS['con']->prepare("INSERT INTO order_items (order_id, product_id, quantity, subtotal, sale_date)
                                                                VALUES (?, ?, ?, ?, ?)");
                $insertOrderItemStmt->bind_param("iiids", $order_id, $product_id, $quantity, $total_price, $order_date);
                $insertOrderItemStmt->execute();
            } else {
                // Handle the case where the product doesn't exist
                // You can choose to skip, log, or handle this situation as needed
            }
        }

        // Commit the transaction
        $GLOBALS['con']->commit();

        // Redirect to the thank-you page
        header('Location: thank-you.php?order_id=' . $order_id);
    } else {
        // Handle database insert error
        throw new Exception("Execute failed: (" . $insertOrderStmt->errno . ") " . $insertOrderStmt->error);
    }

    // Close the prepared statements
    $insertOrderStmt->close();
    $updateQuantityStmt->close();
    $insertOrderItemStmt->close();
} catch (Exception $e) {
    // Handle exceptions, such as database errors or invalid input
    $GLOBALS['con']->rollback(); // Roll back the transaction
    echo 'Error: ' . $e->getMessage();
}

// Close the database connection
$GLOBALS['con']->close();

    //php mailer order confirmation
    $adminEmail = $user_email; // Replace with admin's email address
    $subject = "Order Confirmation";
    $messageBody = "Hello $user_name, your order has been placed successfully.\n";
    $messageBody .= "Order Id: $order_id\n";
    $messageBody .= "Total Amount : $total_amount_to_deduct\n";
    // Send email to admin using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.sendgrid.net'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'apikey'; // Replace with your SMTP username
        $mail->Password = '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'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('shamik.mitra@codeclouds.com', 'Shamik Mitra'); // Replace with admin's email and name
        $mail->addAddress($adminEmail);
        $mail->Subject = $subject;
        $mail->Body = $messageBody;

        $mail->send();
        echo "Thank you for contacting us! Your order confirmation mail has been sent.";
    } catch (Exception $e) {
        echo "Sorry, there was an error sending your message. Please try again later. Error: {$mail->ErrorInfo}";
    }

    function createCrmOrder(){
        //CRM credentials section

        $CRMusername = ''; // to get the username of the CRM

        $CRMpassword = ''; //to get the password of the CRM


        $creditCardNumber = $_POST['cardNumber'];

        //error section starts

        $errorsArray = array();

        if (empty($_POST["first_name"])){

            array_push($errorsArray ,"First name is required!");

        }

        if (empty($_POST["last_name"])){

            array_push($errorsArray ,"Last name is required!");

        }

        if (empty($_POST["shipping_address"])){

            array_push($errorsArray ,"Address is required!");

        }

        if (empty($_POST["city"])){

            array_push($errorsArray ,"City is required!");

        }

        if (empty($_POST["state"])){

            array_push($errorsArray ,"State is required!");

        }

        if (empty($_POST["country"])){

            array_push($errorsArray ,"Country is required!");

        }

        if (empty($_POST["shippingZip"])){

            array_push($errorsArray ,"Zip code is required!");

        }

        if (empty($_POST["clientIp"])){

            array_push($errorsArray ,"Client IP is required!");

        }

        if (empty($_POST["cardType"])){

            array_push($errorsArray ,"Credit Card type is required!");

        }

        if (empty($_POST["email"])){

            array_push($errorsArray ,"Email is required!");

        }

        if (empty($_POST["phone_number"])){

            array_push($errorsArray ,"Phone is required!");

        }


        if (empty($creditCardNumber)){

            array_push($errorsArray ,"Valid credit card number is required!");

        }

        if (empty($_POST["cardExpiryMonth"])){

            array_push($errorsArray ,"Valid expiry month is required!");

        }

        if (empty($_POST["cardExpiryYear"])){

            array_push($errorsArray ,"Valid expiry year is required!");

        }

        if (empty($_POST["cvv"])){

            array_push($errorsArray ,"CVV is required!");

        }


        if (count($errorsArray) >= 1) {

            $responce = array("status"=> "Failed", "errors"=> $errorsArray );

            echo json_encode($responce);

            exit();

        }

        $shippingId = 2;
        $campaignId = 1;
        $offer_id = 1;
        $product_id = 1;
        $billing_model_id = 3;
        $quantity = 1;
        $clientIP = $_POST['clientIp'];
        $creditCardType = $_POST['cardType'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $shippingAddress1 = $_POST['shipping_address'];
        $shippingAddress2 = '';
        $shippingCity = $_POST['city'];
        $shippingState = $_POST['state'];
        $shippingZip = $_POST['shippingZip'];
        $shippingCountry = $_POST['shippingCountry'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $billingSameAsShipping = $_POST['billingSameAsShipping'];
        $billingFirstName = $_POST['firstName'];
        $billingLastName = $_POST['lastName'];
        $billingAddress1 = $_POST['shippingAddress1'];
        $billingAddress2 = $_POST['shippingAddress2'];
        $billingCity = $_POST['shippingCity'];
        $billingState = $_POST['shippingState'];
        $billingZip = $_POST['shippingZip'];
        $billingCountry = $_POST['shippingCountry'];

        $expmonth = $_POST['cardExpiryMonth'];
        $expyear = $_POST['cardExpiryYear'];
        $CVV =  $_POST['cvv'];


        $api_username = $CRMusername;
        $api_password = $CRMpassword;
        $neworder_payload = array (
        'firstName' => $firstName,
        'lastName' => $lastName,
        'billingFirstName' => $billingFirstName,
        'billingLastName' => $billingLastName,
        'billingAddress1' => $billingAddress1,
        'billingAddress2' => $billingAddress2,
        'billingCity' => $billingCity,
        'billingState' => $billingState,
        'billingZip' => $billingZip,
        'billingCountry' => $billingCountry,
        'phone' => $phone,
        'email' => $email,
        'creditCardType' => $creditCardType,
        'creditCardNumber' => $creditCardNumber,
        'expirationDate' => $expmonth.$expyear,
        'CVV' => $CVV,
        'shippingId' => $shippingId,
        'tranType' => 'Sale',
        'ipAddress' => $clientIP,
        'campaignId' => $campaignId,
        'offers' => 
        array (
            0 => 
            array (
            'offer_id' => $offer_id,
            'product_id' => $product_id,
            'billing_model_id' => $billing_model_id,
            'quantity' => $quantity,
            'step_num' => '1',
            ),
        ),
        'billingSameAsShipping' => $billingSameAsShipping,
        "AFID"=>$_GET['AFID'], // all these need to be checked
        "SID"=>$_GET['SID'],
        "AFFID"=>$_GET['AFFID'],
        "C1"=>$_GET['C1'],
        "C2"=>$_GET['C2'],
        "C3"=>$_GET['C3'],
        "AID"=>$_GET['AID'],
        "OPT"=>$_GET['OPT'],
        "click_id"=>$_GET['click_id'],
        'shippingAddress1' => $shippingAddress1,
        'shippingAddress2' => $shippingAddress2,
        'shippingCity' => $shippingCity,
        'shippingState' => $shippingState,
        'shippingZip' => $shippingZip,
        'shippingCountry' => $shippingCountry,
        "forceGatewayId" => "",
        "preserve_force_gateway" => "",
        "thm_session_id" => "",
        "total_installments" => "",
        "alt_pay_token" => "",
        "alt_pay_payer_id" => "",
        "secretSSN" => "",
        "promoCode" => "",
        "temp_customer_id" => "",
        "three_d_redirect_url" => "",
        "alt_pay_return_url" => "",
        "sessionId" => "",
        "cascade_override" => "",
        "create_member" => "",
        "event_id" => "",
        "ssn_nmi" => "",
        "utm_source" => "source",
        "utm_medium" => "medium",
        "utm_campaign" => "",
        "utm_content" => "",
        "utm_term" => "",
        "device_category" => "",
        "checkingAccountNumber" => "",
        "checkingRoutingNumber" => "",
        "sepa_iban" => "",
        "sepa_bic" => "",
        "eurodebit_acct_num" => "",
        "eurodebit_route_num" => "",
        "referrer_id"  =>  "",
        "conversion_id"  =>  "",
        "cavv"  =>  "",
        "eci"  =>  "",
        "xid"  =>  ""
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://highcrestpublishing.sticky.io/api/v1/new_order',
        CURLOPT_USERPWD => $api_username . ":" . $api_password,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($neworder_payload),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl); 
        print_r($response);
    }

?>
<?php include_once('footer.php');?>
<script>

$(document).ready(function() {
    //console.log('JavaScript is running');
    //   var userName = '<?=$user_name;?>';
    //   var userEmail = '<?=$user_email;?>';
    //   var totalAmountToDeduct = <?=$total_amount_to_deduct;?>;
    //   var orderId = <?=$order_id;?>;

    //   $.post("order_confirmation.php", {
    //     userName: userName,
    //     userEmail: userEmail,
    //     orderId: order_id,
    //     totalAmountToDeduct: totalAmountToDeduct
    //   }, function(data) {
    //       console.log(data); // Display the server response to the user
    //   });
});

</script>
