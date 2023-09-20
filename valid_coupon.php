<?php
include_once('admin/connection.inc.php');
$GLOBALS['con'] = $con;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the coupon code from the POST data
    $couponCode = $_POST["coupon"];

    // Function to fetch valid coupon codes
    function validCoupons() {
        $sqlValidCoupons = "SELECT coupon_code FROM discounts WHERE is_active = '1'";
        $qurValidCoupons = mysqli_query($GLOBALS['con'], $sqlValidCoupons);
        $validCouponCodes = array();

        while ($row = mysqli_fetch_assoc($qurValidCoupons)) {
            $validCouponCodes[] = $row['coupon_code'];
        }

        return $validCouponCodes;
    }

    // Function to fetch coupon details
    function detailedCoupons($couponCode) {
        $sqlDetailedCoupons = "SELECT discount_type, discount_value FROM discounts WHERE coupon_code = '$couponCode' AND is_active = '1'";
        $qurDetailedCoupons = mysqli_query($GLOBALS['con'], $sqlDetailedCoupons);
        $couponDetails = mysqli_fetch_assoc($qurDetailedCoupons);

        return $couponDetails;
    }

    $validCouponCodes = validCoupons();

    if (in_array($couponCode, $validCouponCodes)) {
        // Coupon code is valid
        $couponDetails = detailedCoupons($couponCode);
        echo json_encode($couponDetails); // Send coupon details as JSON response
    } else {
        // Invalid coupon code
        echo "invalid";
    }
}
?>
