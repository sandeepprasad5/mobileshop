<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminEmail = "sandeep.prasad@codeclouds.in"; // Replace with admin's email address

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    $subject = "Customer Contact";
    $messageBody = "Name: $name\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Phone: $phone\n";
    $messageBody .= "Message:\n$message";

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
        echo "Thank you for contacting us! Your message has been sent.";
    } catch (Exception $e) {
        echo "Sorry, there was an error sending your message. Please try again later. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
