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
    $banQuery = "UPDATE users SET is_banned = 1 WHERE id = $userId";
    if ($conn->query($banQuery) === TRUE) {
        echo "<span class='text-success'>User banned</span>";
    } else {
        echo "<span class='text-danger'>Error banning user: " . $conn->error . "</span>";
        // Error checking
        $error_message = $conn->error;
        $file_name = __FILE__;
        log_error($error_message, $file_name);
    }
}
?>
