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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the event ID from the form
    $event_id = $_POST["event_id"];

    // Retrieve the event data from the database
    $select_sql = "SELECT * FROM events WHERE id = '$event_id'";
    $result = $conn->query($select_sql);

    // Check if the event exists
    if ($result->num_rows > 0) {
        // Get the event data
        $row = $result->fetch_assoc();
        $event_title = $row['title'];
        $event_type = $row['event_type'];
        $event_location = $row['location'];
        $event_date = $row['date'];
        $event_start_time = $row['start_time'];
        $event_end_time = $row['end_time'];
        $event_capacity = $row['capacity'];
        $event_description = $row['description'];
    } else {
        // Redirect to the events page if the event does not exist
        header("Location: events.php");
        exit();
    }
} else {
    // Redirect to the events page if the form has not been submitted
    header("Location: events.php");
    exit();
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
  <!-- BOX ICONS CSS-->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <!-- Side-Nav -->
    <div class="side-nav active-nav" id="sidebar">
        <ul class="nav flex-column text-white w-100">
            <h3 class="h3 text-white my-2" id="h3"> I Do Crew </h3>
            <li href="" class="nav-link">
                <i class="bx bxs-dashboard text-white"></i>
                <a href="eventOrg.html" class="btn btn-danger"><span class="mx-2 text-white">Dashboard</span></a>
            </li>
            <li href="" class="nav-link">
                <i class="bx bxs-dashboard text-white"></i>
                <a href="events.php" class="btn btn-danger"><span class="mx-2 text-white">Events</span></a>
            </li>
            <li href="" class="nav-link">
                <i class="bx bx-user-check text-white"></i>
                <a href="logout.php" class="btn btn-danger"><span class="mx-2 text-white">Logout</span></a>
            </li>
        </ul>
    </div>
    <div class="container">
        <main>
            <div class="tab tab-1">
                <h1 class="h1 text-center mt-3">Modify Event</h1>
                <form action="update_event.php" method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                    <div class="form-group">
                        <label for="title">Event Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $event_title; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Event Type:</label>
                        <select class="form-control" id="type" name="type" required>
                        <option value="Wedding" <?php if ($event_type == "Wedding") { echo "selected"; } ?>>Wedding</option>
                            <option value="Birthday" <?php if ($event_type == "Birthday") { echo "selected"; } ?>>Birthday</option>
                            <option value="Corporate" <?php if ($event_type == "Corporate") { echo "selected"; } ?>>Corporate</option>
                            <option value="Other" <?php if ($event_type == "Other") { echo "selected"; } ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Event Location:</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $event_location; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Event Date:</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $event_date; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Event Start Time:</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $event_start_time; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">Event End Time:</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $event_end_time; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Event Capacity:</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo $event_capacity; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Event Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $event_description; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </form>
            </div>
        </main>
    </div>
    <!-- bootstrap 5 js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-DJZ/6bbd6Ls6jQlQlY9DRk6PkBbXBzIyH/JUZt9Vv9dQzZjvYkaGZ9KWnX8jPm9" crossorigin="anonymous"></script>
    <!-- custom js -->
    <script src="js/main.js"></script>
</body>

</html>
?>