<?php
    session_start();
    require_once 'config.php';

    // Sanitize form data
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);

    // Retrieve the logged in user's id from the session using their email
    $user_email = $_SESSION['email'];
    $sql = "SELECT id FROM users WHERE email = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    // Insert the user's participation record into the participation table in the database
    $sql = "INSERT INTO participation (participant_capacity, wait_list, isFull, user_id, event_id) 
        VALUES (0, 0, false, '$user_id', '$event_id')";
    $result = mysqli_query($conn, $sql);

    // Update the event's capacity in the events table
    $sql = "UPDATE events SET capacity = capacity - 1 WHERE id = '$event_id'";
    $result = mysqli_query($conn, $sql);

// Set the registration status message in a session variable
if ($result) {
    $_SESSION['registration_status'] = "Registration successful!";
} else {
    $_SESSION['registration_status'] = "Registration failed: " . mysqli_error($conn);
}

mysqli_close($conn);

// Redirect back to the participant.php page
header("Location: participant.php#registration-popup");
exit();
?>
