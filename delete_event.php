<?php
// deleteEvent.php

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

// Check if the event ID is provided via POST
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Delete the event from the events table
    $delete_sql = "DELETE FROM events WHERE id = $event_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting event: " . $conn->error;
        // Error checking
        $error_message = $conn->error;
        $file_name = __FILE__;
        log_error($error_message, $file_name);
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
