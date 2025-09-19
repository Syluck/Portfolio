<?php
// Replace this with your email
$receiving_email_address = "syluck.sl@gmail.com";

// Check if POST request has data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Email content
    $email_subject = "New Contact Form Message: $subject";
    $email_body    = "You have received a new message from your website contact form.\n\n".
                     "Here are the details:\n".
                     "Name: $name\n".
                     "Email: $email\n".
                     "Subject: $subject\n\n".
                     "Message:\n$message\n";

    $headers = "From: $name <$email>";

    // Send email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        http_response_code(200);
        echo "Your message has been sent. Thank you!";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
