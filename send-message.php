<?php
// filepath: c:\Users\samyt\Documents\OVH Website\send-message.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    $to = 'samy@teilloux.com'; // Replace with your email address
    $subject = 'New Contact Form Submission';
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $emailBody = <<<EOD
    <html>
    <head> 
    </head>
    <body>
        <div style="max-width: 600px; margin: 0 auto; padding: 1em; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <h2 style="color: #8E1616; margin-bottom: 1em; width: 100%; text-align: center;">New Contact Form Submission</h2>
            <p style="margin: 0.5em 0;"><strong>Name:</strong> $name</p>
            <p style="margin: 0.5em 0;"><strong>Email:</strong> $email</p>
            <p style="margin: 0.5em 0;"><strong>Message:</strong></p>
            <p style="background-color: #f0f0f0; padding: 1em; border-radius: 5px; margin-top: 1em;">$message</p>
            <div style="margin-top: 2em; font-size: 0.9em; color: #666; text-align: center;">
                <p>This email was sent via your website's contact form.</p>
            </div>
        </div>
    </body>
    </html>
    EOD;

    if (mail($to, $subject, $emailBody, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send your message. Please try again later.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method: '.$_SERVER['REQUEST_METHOD']]);
}