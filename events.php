<?php
// events.php

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

// Retrieve events from the database
$select_sql = "SELECT * FROM events";
$result = $conn->query($select_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Event</title>
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
            <li>
                <button class="display-modal">Add Event</button>
            </li>
        </ul>
    </div>
    <div class="container">
        <main>
            <div class="tab tab-1">
                <table id="table" border="1">
                    <tr>
                        <th>Event Title</th>
                        <th>Event Type</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Options</th>
                    </tr>

                    <?php
                    // Display the events in the table
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $event_id = $row['id'];
                            $event_title = $row['title'];
                            $event_type = $row['event_type'];
                            $event_location = $row['location'];
                            $event_date = $row['date'];
                            $event_start_time = $row['start_time'];
                            $event_end_time = $row['end_time'];
                            $event_capacity = $row['capacity'];
                            $event_description = $row['description'];
                    ?>

                    <tr>
                        <td><?php echo $event_title; ?></td>
                        <td><?php echo $event_type; ?></td>
                        <td><?php echo $event_location; ?></td>
                        <td><?php echo $event_date; ?></td>
                        <td><?php echo $event_start_time; ?></td>
                        <td><?php echo $event_end_time; ?></td>
                        <td><?php echo $event_capacity; ?></td>
                        <td><?php echo $event_description; ?></td>
                        <td>
                            <form action="delete_event.php" method="POST" style="display: inline;">
                                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                <button type="submit" name="delete_event">Delete</button>
                            </form>
                            <a href="modify_event.php?event_id=<?php echo $event_id; ?>">Modify</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else{
                        echo "<tr><td colspan='9'>No events found</td></tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="tab tab-2">
                    <label for="event-title">Event Title:</label>
                    <input type="text" placeholder="Event Title" name="title" id="input-0">

          <label for="Event Type">Event Type:</label>
          <input type="text" placeholder="Event Type" name="event_type" id="input-1">

          <label for="description">Description:</label>
          <input type="text" placeholder="Description" name="description" id="input-2">

          <label for="date">Date:</label>
          <input type="text" name="date" id="input-3" placeholder="mm/dd/yyyy">

          <label for="start-time">Start Time:</label>
          <input type="text" name="start_time" id="input-4" placeholder="HH:MM PM/AM">

          <label for="end-time">End Time:</label>
          <input type="text" placeholder="HH:MM PM/AM" name="end_time" id="input-5">

          <label for="location">Location:</label>
          <input type="text" placeholder="Location" name="location" id="input-6">

          <label for="capacity">Capacity:</label>
          <input type="text" placeholder="Capacity" name="capacity" id="input-7">

          <input type="hidden" name="id" id="input-8">

                    <div class="button-div">
                        <button class="btn add-btn" name="add_event">Add</button>
                        <button class="btn edit-btn">Edit</button>
                        <button class="btn remove-btn" onclick="confirmDeleteEvent()">Remove</button>
                    </div>
            </div>
        </main>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="script.js" async defer></script>
</body>

</html>
