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

    // Update the 'is_banned' column in the database for the selected user
    $DeleteQuery = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($DeleteQuery) === TRUE) {
        echo "<span class='text-success'>User Deleted</span>";
    } else {
        echo "<span class='text-danger'>Error deleting user: " . $conn->error . "</span>";
    }
}
?>