<?php
// Retrieve the email from the request
$email = $_POST['email'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "CSCD378GroupWeb";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the users table to check if the email exists
$sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
$result = $conn->query($sql);
$row = $result->fetch_row();
$count = $row[0];

// Return the response
if ($count > 0) {
    echo "exists";
} else {
    echo "not_exists";
}

$conn->close();
?>
