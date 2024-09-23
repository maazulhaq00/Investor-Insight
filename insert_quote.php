<?php
// Database connection parameters
$servername = "localhost"; // Change to your database server name
$username = "root"; // Change to your database username
$password = "root"; // Change to your database password
$dbname = "investor_insight"; // Change to your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from the AJAX request
$q_fname = $_POST["q_fname"];
$q_lname = $_POST["q_lname"];
$q_email = $_POST["q_email"];
$q_phone = $_POST["q_phone"];
$q_type = $_POST["q_type"];

// Insert data into the database
$sql = "INSERT INTO quote_requests (first_name, last_name, email, phone, `type`) 
        VALUES ('$q_fname', '$q_lname', '$q_email', '$q_phone', '$q_type')";

if ($conn->query($sql) === TRUE) {
    echo "success"; // Return "success" to the AJAX request
} else {
    echo "error: " . $conn->error; // Return an error message
}

// Close the database connection
$conn->close();
?>
