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

// Retrieve event ID from the POST request
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch the event data from the events table
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $event = $result->fetch_assoc();

        // Insert the event data into the rejected_events table
        $rejected_sql = "INSERT INTO rejected_events (id, title, event_type, location, date, start_time, end_time, capacity, description, organizer_id) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($rejected_sql);
        $stmt->bind_param("issssssssi", $event['id'], $event['title'], $event['event_type'], $event['location'], $event['date'], $event['start_time'], $event['end_time'], $event['capacity'], $event['description'], $event['organizer_id']);
        if ($stmt->execute()) {
            echo "Event rejected successfully";
        } else {
            echo "Error rejecting event: " . $stmt->error;
        }
    } else {
        echo "Event not found";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
