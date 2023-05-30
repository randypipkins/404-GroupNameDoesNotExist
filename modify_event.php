<?php
// Check if the event ID is provided in the query parameter
if (!isset($_GET['event_id'])) {
    echo "Event ID not provided";
    exit;
}

$event_id = $_GET['event_id'];

// Retrieve the event details from the database
$select_sql = "SELECT * FROM events WHERE id = '$event_id'";
$result = $conn->query($select_sql);

if ($result->num_rows != 1) {
    echo "Event not found";
    exit;
}

$row = $result->fetch_assoc();
$event_title = $row['title'];
$event_type = $row['event_type'];
$event_location = $row['location'];
$event_date = $row['date'];
$event_start_time = $row['start_time'];
$event_end_time = $row['end_time'];
$event_capacity = $row['capacity'];
$event_description = $row['description'];

// Handle event update
if (isset($_POST['update_event'])) {
    $event_title = $_POST['title'];
    $event_type = $_POST['event_type'];
    $event_location = $_POST['location'];
    $event_date = $_POST['date'];
    $event_start_time = $_POST['start_time'];
    $event_end_time = $_POST['end_time'];
    $event_capacity = $_POST['capacity'];
    $event_description = $_POST['description'];

    $update_sql = "UPDATE events SET title='$event_title', event_type='$event_type', location='$event_location', date='$event_date', start_time='$event_start_time', end_time='$event_end_time', capacity='$event_capacity', description='$event_description' WHERE id='$event_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "Event updated successfully";
        // Redirect to the events.php page after successful update
        header("Location: events.php");
        exit;
    } else {
        echo "Error updating event: " . $conn->error;
    }
}
?>