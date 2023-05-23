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

        // Get the organizer ID
        $organizer_id = $event['organizer_id'];

        // Check if the organizer ID exists in the users table
        $check_organizer_sql = "SELECT * FROM users WHERE id = $organizer_id";
        $check_organizer_result = $conn->query($check_organizer_sql);

        if ($check_organizer_result && $check_organizer_result->num_rows > 0) {
            // Organizer ID exists, proceed with inserting the event data into the approved_events table

            $title = $event['title'];
            $event_type = $event['event_type'];
            $location = $event['location'];
            $date = $event['date'];
            $start_time = $event['start_time'];
            $end_time = $event['end_time'];
            $capacity = $event['capacity'];
            $description = $event['description'];

            $approved_sql = "INSERT INTO approved_events (title, event_type, location, date, start_time, end_time, capacity, description, organizer_id) VALUES ('$title', '$event_type', '$location', '$date', '$start_time', '$end_time', '$capacity', '$description', $organizer_id)";

            if ($conn->query($approved_sql) === TRUE) {
                echo "Event approved successfully";
            } else {
                echo "Error approving event: " . $conn->error;
            }
        } else {
            echo "Invalid organizer ID";
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

