<?php
    session_start();
    require_once 'config.php';

    // Sanitize form data
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);

    // Retrieve the logged-in user's id from the session using their email
    $user_email = $_SESSION['email'];
    $sql = "SELECT id FROM users WHERE email = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    // Check if the event has reached its capacity
    $event_query = "SELECT capacity, wait_list FROM approved_events WHERE id = '$event_id'";
    $event_result = mysqli_query($conn, $event_query);
    $event_row = mysqli_fetch_assoc($event_result);
    $event_capacity = $event_row['capacity'];
    $wait_list = $event_row['wait_list'];

    if ($event_capacity > 0) {
        // The event still has capacity, register the participant

        // Update the event's capacity and participant count in the approved_events table
        $sql = "UPDATE approved_events SET capacity = capacity - 1, participant_count = participant_count + 1 WHERE id = '$event_id'";
        $result = mysqli_query($conn, $sql);

        // Error checking
        if(!$result){
            $error_message = $conn->error;
            $file_name = __FILE__;
            log_error($error_message, $file_name);
        }

        // Insert the participant's record into the participation table in the database
        $sql = "INSERT INTO participation (participant_capacity, wait_list, isFull, user_id, email, event_id) 
                VALUES ('$event_capacity', 0, false, '$user_id', '$user_email', '$event_id')";
        $result = mysqli_query($conn, $sql);

        // Error checking
        if(!$result){
            $error_message = $conn->error;
            $file_name = __FILE__;
            log_error($error_message, $file_name);
        }

        // Display a message to the user indicating the registration was successful
        echo "Registration successful!";
    } elseif ($wait_list > 0) {
        // The event is at full capacity, register the user for the waitlist

        // Update the waitlist count in the approved_events table
        $sql = "UPDATE approved_events SET wait_list = wait_list - 1 WHERE id = '$event_id'";
        $result = mysqli_query($conn, $sql);

        // Error checking
        if(!$result){
            $error_message = $conn->error;
            $file_name = __FILE__;
            log_error($error_message, $file_name);
        }

        // Insert the participant's record into the participation table with waitlist information
        $sql = "INSERT INTO participation (participant_capacity, wait_list, isFull, user_id, email, event_id) 
                VALUES (0, 0, true, '$user_id', '$user_email', '$event_id')";
        $result = mysqli_query($conn, $sql);

        // Error checking
        if(!$result){
            $error_message = $conn->error;
            $file_name = __FILE__;
            log_error($error_message, $file_name);
        }

        // Display a message to the user indicating the waitlist registration was successful
        echo "Registration successful! You have been added to the waitlist.";
    } else {
        // The event and waitlist are both full, inform the user
        echo "Sorry, the event and waitlist are both full. No more registrations can be accepted.";
    }

    mysqli_close($conn);
?>

