<?php 
require_once('functions.php');
   // Check if any POST data exists
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $_POST['registerAddress'];
    if (isset($_POST['registerName'], $_POST['registerEmail'], $_POST['registerPassword'], $_POST['registerAddress'])) {
        // All the required fields are set, so you can proceed with registration
        $registered = addUserInfo($_POST['registerName'], $_POST['registerEmail'], $_POST['registerPassword'], $_POST['registerAddress']);
        //$encodedpassData = $_POST['encodedpassData'];
        if ($registered == 1) {
            echo "Registration successful!";
        } else {
            echo "Registration failed.";
        }
        exit;
    } else {
        echo 'Required POST data is missing.';
    }
} else {
    echo 'Invalid request.';
}
?>