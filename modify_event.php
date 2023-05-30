<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "CSCD378GroupWeb";
$dbname = "mydb";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the event ID is provided in the query parameter
if (!isset($_GET['event_id'])) {
    echo "Event ID not provided";
    $error_message = $conn->error;
    $file_name = __FILE__;
    log_error($error_message, $file_name);
    exit;
}

$event_id = $_GET['event_id'];

// Retrieve the event details from the database
$select_sql = "SELECT * FROM events WHERE id = '$event_id'";
$result = $conn->query($select_sql);
if(!$result){
    $error_message = $conn->error;
    $file_name = __FILE__;
    log_error($error_message, $file_name);
}

if ($result->num_rows != 1) {
    echo "Event not found";
    $error_message = $conn->error;
    $file_name = __FILE__;
    log_error($error_message, $file_name);
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

    $update_sql = "UPDATE events SET title='$event_title', event_type='$event_type', location='$event_location', date='$event_date', 
        start_time='$event_start_time', end_time='$event_end_time', capacity='$event_capacity', description='$event_description' WHERE id='$event_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "Event updated successfully";
        // Redirect to the events.php page after successful update
        header("Location: events.php");
        exit;
    } else {
        echo "Error updating event: " . $conn->error;
        $error_message = $conn->error;
        $file_name = __FILE__;
        log_error($error_message, $file_name);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Event</title>
    <!-- bootstrap 5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <!-- custom css -->
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="container">
        <h1>Modify Event</h1>
        <form method="POST">
            <label for="event-title">Event Title:</label>
            <input type="text" placeholder="Event Title" name="title" value="<?php echo $event_title; ?>" required>

            <label for="event-type">Event Type:</label>
            <input type="text" placeholder="Event Type" name="event_type" value="<?php echo $event_type; ?>" required>

            <label for="description">Description:</label>
            <input type="text" placeholder="Description" name="description"
                value="<?php echo $event_description; ?>" required>

            <label for="date">Date:</label>
            <input type="text" name="date" value="<?php echo $event_date; ?>" required>

            <label for="start-time">Start Time:</label>
            <input type="text" name="start_time" value="<?php echo $event_start_time; ?>" required>

            <label for="end-time">End Time:</label>
            <input type="text" placeholder="HH:MM PM/AM" name="end_time" value="<?php echo $event_end_time; ?>"
                required>

            <label for="location">Location:</label>
            <input type="text" placeholder="Location" name="location" value="<?php echo $event_location; ?>" required>

            <label for="capacity">Capacity:</label>
            <input type="text" placeholder="Capacity" name="capacity" value="<?php echo $event_capacity; ?>" required>

            <input type="hidden" name="id" value="<?php echo $event_id; ?>">
            <button class="btn" type="submit" name="update_event">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
</body>

</html>