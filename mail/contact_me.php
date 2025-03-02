<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request method!";
    exit(1);
}

// Sanitize and validate inputs
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');
$gotcha = trim($_POST['_gotcha'] ?? '');

// Validate email
$email_address = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email_address) {
    echo "Invalid email address!";
    exit(1);
}

// Check for empty fields
if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    echo "All fields are required!";
    exit(1);
}

// Check honeypot field (_gotcha), if filled then it's a bot
if (!empty($gotcha)) {
    echo "Gotcha, spambot!";
    exit(1);
}

// Recipient email
$to = "geniag25@gmail.com";  // Replace with your actual email
$email_subject = "Website Contact Form: $name";

// Email body
$email_body = "You have received a new message from your website contact form.\n\n";
$email_body .= "Here are the details:\n";
$email_body .= "Name: $name\n";
$email_body .= "Email: $email_address\n";
$email_body .= "Phone: $phone\n";
$email_body .= "Message:\n$message\n";

// Email headers
$headers = "From: noreply@yourdomain.com\r\n";
$headers .= "Reply-To: $email_address\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send the email
if (mail($to, $email_subject, $email_body, $headers)) {
    echo "Message sent successfully!";
    exit(0);
} else {
    echo "Failed to send message!";
    exit(1);
}
?>

