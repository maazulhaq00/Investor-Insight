<?php
// Include any necessary functions or database connection code here.

// Define the about_us function
function forgetpassword() {
    // Create an array to hold the data for the page
    $data_n = [];
    $data_n["html_head"] = '';  // You can set the HTML head content here if needed.
    $data_n["html_title"] = 'About Us'; // Set the title
    $data_n["html_heading"] = 'About Us';


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Step 1: Get the user's email address from the form
        $email = $_POST["email"];

        // Step 2: Check if the email exists in your database (replace with your database logic)
        // Example: $user = getUserByEmail($email);
        // if (!$user) {
        //     // Handle the case where the email doesn't exist
        //     echo "Email not found.";
        //     exit;
        // }

        // Step 3: Generate a temporary password or token for the reset link (you can use a library like random_bytes)
        $tempPassword = bin2hex(random_bytes(8));

        // Step 4: Update the user's password in your database (replace with your database logic)
        // Example: updateUserPassword($email, $tempPassword);

        // Step 5: Send a password reset email to the user
        $subject = "Password Reset Request";
        $message = "Hello,\n\n";
        $message .= "You have requested to reset your password. Your temporary password is:\n";
        $message .= $tempPassword;
        $headers = "From: your@example.com"; // Replace with your email address

        if (mail($email, $subject, $message, $headers)) {
            echo "Password reset email sent. Check your inbox.";
        } else {
            echo "Failed to send the password reset email.";
        }
    }
    return $data_n;
}