<?php
// Add event to the database
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
    // Error checking
    if(!$result){
        $error_message = $conn->error;
        $file_name = __FILE__;
        log_error($error_message, $file_name);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Get the organizer_id of the logged-in user
        $organizer_id = $conn->real_escape_string($user_id);

        $sql = "INSERT INTO events (title, event_type, description, date, start_time, end_time, location, capacity, organizer_id) 
                VALUES ('$title', '$event_type', '$description', '$date', '$start_time', '$end_time', '$location', '$capacity', '$organizer_id')";

        // Retrieve the event_id for the newly inserted event
        $event_id = $conn->insert_id;

        // Set the event_id value in the input field
        echo '<script>document.getElementById("input-8").value = "' . $event_id . '";</script>';

        if ($conn->query($sql) === TRUE) {
            echo "Event added successfully";
        } else {
            $error_message = $conn->error;
            $file_name = __FILE__;
            log_error($error_message, $file_name);
        }
    } else {
        echo "User not found";
    }
} else {
    echo "Incomplete event data";
}

$conn->close();
?>

