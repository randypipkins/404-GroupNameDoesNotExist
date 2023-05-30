<?php
    session_start();
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
   // Construct the base SQL query
   $sql = "SELECT * FROM events WHERE 1=1";
   $result = $conn->query($sql);

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
    <div class="tab tab-1" id="participantT">
            <table id="table" border="1">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Event Type</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Capacity</th>
                    <th>Description</th>
                    <th>Organizer ID</th>
                </tr>
                <?php
                // Fetch data from the events table
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["event_type"] . "</td>";
                        echo "<td>" . $row["location"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["start_time"] . "</td>";
                        echo "<td>" . $row["end_time"] . "</td>";
                        echo "<td>" . $row["capacity"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["organizer_id"] . "</td>";
                        echo "<td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No events found</td></tr>";
                }
            ?>
        </table>
    </div>

        <div class="tab tab-2">
            <label for="event-title">Event Title:</label>
            <input type="text" placeholder="Event Title" name="title" id="input-1">

            <label for="Event Type">Event Type:</label>
            <input type="text" placeholder="Event Type" name="event_type" id="input-2">

            <label for="location">Location:</label>
            <input type="text" placeholder="Location" name="location" id="input-3">

            <label for="date">Date:</label>
            <input type="text" name="date" id="input-4" placeholder="mm/dd/yyyy">

            <label for="start-time">Start Time:</label>
            <input type="text" name="start_time" id="input-5" placeholder="HH:MM PM/AM">

            <label for="end-time">End Time:</label>
            <input type="text" placeholder="HH:MM PM/AM" name="end_time" id="input-6">

            <label for="capacity">Capacity:</label>
            <input type="text" placeholder="Capacity" name="capacity" id="input-7">

            <label for="description">Description:</label>
            <input type="text" placeholder="Description" name="description" id="input-8">


                    <div class="button-div">
                        <button class="btn add-btn" name="add_event">Add</button>
                        <button class="btn edit-btn">Edit</button>
                        <button class="btn remove-btn">Remove</button>
                    </div>
            </div>
        </main>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="script.js" async defer></script>
</body>

</html>
