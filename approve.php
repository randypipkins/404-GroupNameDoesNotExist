<?php
// approve.php

// Include the database connection file
require_once 'database.php';

// Retrieve event ID from the POST request
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch the event data from the events table
    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $event = $result->fetch_assoc();

        // Insert the event data into the approved_events table
        $title = $event['title'];
        $event_type = $event['event_type'];
        $location = $event['location'];
        $date = $event['date'];
        $start_time = $event['start_time'];
        $end_time = $event['end_time'];
        $capacity = $event['capacity'];
        $description = $event['description'];
        $organizer_id = $event['organizer_id'];

        $approved_sql = "INSERT INTO approved_events (title, event_type, location, date, start_time, end_time, capacity, description, organizer_id) VALUES ('$title', '$event_type', '$location', '$date', '$start_time', '$end_time', '$capacity', '$description', $organizer_id)";

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

