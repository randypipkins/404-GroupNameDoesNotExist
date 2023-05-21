<?php
$servername = "localhost";
$username = "root";
$password = "CSCD378GroupWeb";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $location = $_POST["location"];
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $capacity = $_POST["capacity"];
    $description = $_POST["description"];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO events (title, location, date, start_time, end_time, capacity, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $title, $location, $date, $start_time, $end_time, $capacity, $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Event added successfully";
    } else {
        echo "Error adding event: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
