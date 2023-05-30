<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "CSCD378GroupWeb";
    $dbname = "myDB";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the event ID from the request
$eventId = $_POST["event_id"];

// Prepare and execute the SQL statement to remove the event
$sql = "DELETE FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $eventId);
$stmt->execute();

$stmt->close();
$conn->close();
?>
