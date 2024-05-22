<?php
// Database Configuration (Replace with your credentials)
$servername = "localhost"; //e.g., "localhost"
$username = "root"; //e.g., "root"
$password = "root"; 
$dbname = "portfolio_contacts"; //e.g., "portfolio_contacts"

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and sanitize input
$fullName = htmlspecialchars($_POST['fullName']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars($_POST['phone']);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);

// SQL INSERT (Adjust table and column names if needed)
$sql = "INSERT INTO contacts (fullName, email, phone, subject, message) 
        VALUES ('$fullName', '$email', '$phone', '$subject', '$message')";

if ($conn->query($sql) === TRUE) {
    // Send email 
    $to = "admin@yourdomain.com"; // Replace with your admin email
    $subject = "New Contact Form Submission";
    $body = "Full Name: $fullName\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Subject: $subject\n";
    $body .= "Message: $message\n";
    $headers = "From: $email"; 

    if (mail($to, $subject, $body, $headers)) {
        echo "<p>Thank you for your message! We'll get back to you soon.</p>";
    } else {
        echo "<p>Error sending email. Please try again later.</p>";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close(); 
?>
