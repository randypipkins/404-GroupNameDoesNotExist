<?php
// delete_events.php

// Check if the event ID is provided via POST
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

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

    // Delete the event from the events table
    $delete_sql = "DELETE FROM events WHERE id = '" . $event_id . "'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting event: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request";
}
?>
