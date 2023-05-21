<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "CSCD378GroupWeb";
    $dbname = "mydb";

    //create connection to the server and the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    //check connection
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
       // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO events (title, location, date, start_time, end_time, capacity, description, organizer_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $event_title, $location, $date, $start_time, $end_time, $capacity, $description, $organizer_id, $category_id);

    // Get the form data
    $event_title = $_POST['event_title'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];
    $organizer_id = 1; // Assuming organizer_id is 1 (you may need to change this)
    $category_id = 1; // Assuming category_id is 1 (you may need to change this)

    // Execute the statement
    if ($stmt->execute()) {
        // Event added successfully
        echo "Event added successfully";
        $stmt->close();
        $conn->close();
        exit;
    } else {
        // Error adding event
        echo "Error adding event: " . $stmt->error;
        $stmt->close();
        $conn->close();
        exit;
    }
}

// Redirect to the form page if accessed directly
header("Location: events.php");
exit;
?>