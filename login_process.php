<?php
include_once('admin/connection.inc.php');

$GLOBALS['con'] = $con;

// Start a session
session_start();

// Assuming you have a users table with fields: id, email, password_hash
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate the user's credentials
    $sql = "select * from users where email = '$email' and password = '$password'";
    $qur = mysqli_query($GLOBALS['con'], $sql);
    

    if ($qur) {
        $user = mysqli_fetch_assoc($qur);

        if ($user) {
            // User found with matching credentials
            // Log the user in
            // Store user ID in session to maintain login state
            $_SESSION["user_id"] = $user['user_id']; // Assuming 'id' is the primary key in the users table
            echo "success";
        } else {
            // No user found with provided credentials
            echo "error";
        }
    } else {
        // Database query error
        echo "Database query error";
    }
} else {
    // Invalid request method, return an error message
    echo "error method";
}
?>
