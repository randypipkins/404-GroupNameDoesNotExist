<?php
// Add event to the database
require_once 'config.php';

if (isset($_POST['add_event'])) {
    $title = $_POST['title'];
    $event_type = $_POST['event_type'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO events (title, event_type, description, date, start_time, end_time, location, capacity) 
            VALUES ('$title', '$event_type', '$description', '$date', '$start_time', '$end_time', '$location', '$capacity')";

    if ($conn->query($sql) === TRUE) {
        echo "Event added successfully";
    } else {
        echo "Error adding event: " . $conn->error;
    }
}

$conn->close();
?>
