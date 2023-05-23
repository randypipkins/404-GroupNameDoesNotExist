<?php
// approve.php

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

// Retrieve event ID from the POST request
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch the event data from the events table
    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $event = $result->fetch_assoc();

        // Insert the event data into the approved_events table
        $approved_sql = "INSERT INTO approved_events (title, event_type, location, date, start_time, end_time, capacity, description, organizer_id) 
                         VALUES ('{$event['title']}', '{$event['event_type']}', '{$event['location']}', '{$event['date']}', '{$event['start_time']}', '{$event['end_time']}', '{$event['capacity']}', '{$event['description']}', {$event['organizer_id']})";

        if ($conn->query($approved_sql) === TRUE) {
            echo "Event approved successfully";
        } else {
            echo "Error approving event: " . $conn->error;
        }
    } else {
        echo "Event not found";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>


