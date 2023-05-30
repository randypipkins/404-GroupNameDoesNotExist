<?php

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "CSCD378GroupWeb";
$dbname = "myDB";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Delete the event from the events table
    $delete_sql = "DELETE FROM events WHERE id = ?";
    
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $event_id);
    
    if ($stmt->execute()) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting event: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>