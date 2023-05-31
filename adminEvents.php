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
   // Error checking
   if(!$result){
    $error_message = $conn->error;
    $file_name = __FILE__;
    log_error($error_message, $file_name);
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <!-- bootstrap 5 css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
  <!-- BOX ICONS CSS-->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="wrapper">
  <!-- Side-Nav -->
  <div class="side-nav active-nav" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <h3 class="h3 text-white my-2" id="h3"> I Do Crew
	  </h3>
    <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <a href="admin.php" class="btn btn-danger"><span class="mx-2 text-white">Dashboard</span></a>
      </li>
      <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <a href="adminEvents.php" class="btn btn-danger"><span class="mx-2 text-white">Events</span></a>
      </li>
      <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <a href="users.php" class="btn btn-danger"><span class="mx-2 text-white">Users</span></a>
      </li>
      <li href="" class="nav-link">
        <i class="bx bx-user-check text-white"></i>
        <a href="logout.php" class="btn btn-danger"><span class="mx-2 text-white">Logout</span></a>
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
                    <th>Location</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Capacity</th>
                    <th>Description</th>
                    <th>Organizer ID</th>
                    <th>Approve</th>
                    <th>Reject</th>
                    <th>Delete</th>

                </tr>
                <?php
                // Fetch data from the events table
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["location"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["start_time"] . "</td>";
                        echo "<td>" . $row["end_time"] . "</td>";
                        echo "<td>" . $row["capacity"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["organizer_id"] . "</td>";
                        echo "<td>";
                        // Check if the event is in the approved_events table
                        $event_id = $row["id"];
                        $approved_query = "SELECT * FROM approved_events WHERE id = '$event_id'";
                        $approved_result = $conn->query($approved_query);
                        // Error checking
                        if(!$approved_result){
                          $error_message = $conn->error;
                          $file_name = __FILE__;
                          log_error($error_message, $file_name);
                        }
        
                        if ($approved_result && $approved_result->num_rows > 0) {
                            // Event is approved, display a checkmark
                            echo "<span class='btn btn-success'><i class='bx bx-check'></i></span>";
                        } else {
                            // Event is not approved, display the Approve button
                            echo "<form method='POST' action='approve.php'>"; 
                            echo "<input type='hidden' name='event_id' value='" . $row["id"] . "'>";
                            echo "<button type='submit' class='btn btn-primary'>Approve</button>";
                            echo "</form>";
                        }
                        echo "<td>";
                        $rejected_query = "SELECT * FROM rejected_events WHERE id = '$event_id'";
                        $rejected_result = $conn->query($rejected_query);
                        // Error checking
                        if(!$result){
                          $error_message = $conn->error;
                          $file_name = __FILE__;
                          log_error($error_message, $file_name);
                        }
                        if ($rejected_result && $rejected_result->num_rows > 0) {
                            // Event is rejected, display a checkmark
                            echo "<span class='btn btn-success'><i class='bx bx-check'></i></span>";
                        } else {
                            // Event is not rejected, display the Approve button
                            echo "<form method='POST' action='reject.php'>"; 
                            echo "<input type='hidden' name='event_id' value='" . $row["id"] . "'>";
                            echo "<button type='submit' class='btn btn-primary'>Reject</button>";
                            echo "</form>";
                        }
                        echo "<td>";
                        echo "<form method='POST' action='admindelete_event.php'>"; 
                        echo "<input type='hidden' name='event_id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' class='btn btn-primary'>Delete</button>";
                        echo "</form>";
        
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>No events found</td></tr>";
}
?>
            </table>
        </div>
    </main>
  </div>
</div>

    <!-- Top Nav -->
  <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>