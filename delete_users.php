<?php
session_start();
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

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Delete the event from the events table
    $delete_sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "user deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>