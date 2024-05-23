<?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        // Handle the error appropriately
        echo "Please fill in all required fields.";
        exit;
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Assuming everything is validated and sanitized
    // Here you would generally handle the data, like sending an email or storing it in a database
    // For demonstration, let's just display the data back (do not use this in production!)
    echo "Thank you, " . htmlspecialchars($name) . "!<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Subject: " . htmlspecialchars($subject) . "<br>";
    echo "Message: " . htmlspecialchars($message) . "<br>";

    // In a real application, here you might redirect or inform the user of success
    // header('Location: thank_you_page.php');
} else {
    // Not a POST request
    echo "Invalid request method.";
}
?>
