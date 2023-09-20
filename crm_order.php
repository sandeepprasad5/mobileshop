<?php
//CRM credentials section

$CRMusername = ''; // to get the username of the CRM

$CRMpassword = ''; //to get the password of the CRM


$creditCardNumber = $_POST['cardNumber'];

//error section starts

$errorsArray = array();

if (empty($_POST["firstName"])){

    array_push($errorsArray ,"First name is required!");

}

if (empty($_POST["lastName"])){

    array_push($errorsArray ,"Last name is required!");

}

if (empty($_POST["shippingAddress1"])){

    array_push($errorsArray ,"Address is required!");

}

if (empty($_POST["shippingCity"])){

    array_push($errorsArray ,"City is required!");

}

if (empty($_POST["shippingState"])){

    array_push($errorsArray ,"State is required!");

}

if (empty($_POST["shippingCountry"])){

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

if (empty($_POST["phone"])){

    array_push($errorsArray ,"Phone is required!");

}

if (empty($_POST["billingSameAsShipping"])){

    array_push($errorsArray ,"Billing same as Shipping is required!");

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
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$shippingAddress1 = $_POST['shippingAddress1'];
$shippingAddress2 = $_POST['shippingAddress2'];
$shippingCity = $_POST['shippingCity'];
$shippingState = $_POST['shippingState'];
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
?>











