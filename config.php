<?php
// Database configuration
$host = "localhost"; // Hostname
$username = "root"; // Database username
$password = "CSCD378GroupWeb"; // Database password
$dbname = "mydb"; // Database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
