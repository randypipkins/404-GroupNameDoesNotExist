<?php
// Remove event from the database
require_once 'config.php';

// Start the session
session_start();

if (isset($_POST['title']) && isset($_POST['event_type']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['location']) && isset($_POST['capacity'])) {
    $title = $_POST['title'];
    $event_type = $_POST['event_type'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    // Retrieve the email of the logged-in user from the session or authentication data
    $logged_in_email = $_SESSION['email']; // Replace with your specific session variable or authentication data

    // Get the user ID based on the logged-in email
    $query = "SELECT id FROM users WHERE email = '$logged_in_email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Get the organizer_id of the logged-in user
        $organizer_id = $conn->real_escape_string($user_id);

        // Remove the event from the database based on the specified criteria
        $sql = "DELETE FROM events 
                WHERE title = '$title' AND event_type = '$event_type' AND description = '$description' AND date = '$date' AND start_time = '$start_time' AND end_time = '$end_time' AND location = '$location' AND capacity = '$capacity' AND organizer_id = '$organizer_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Event removed successfully";
        } else {
            echo "Error removing event: " . $conn->error;
        }
    } else {
        echo "User not found";
    }
} else {
    echo "Incomplete event data";
}

$conn->close();
?>
