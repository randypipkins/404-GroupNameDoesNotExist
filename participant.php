<?php
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

       // Fetch data from the events table with filters
       $search_location = $_POST['search_location'] ?? '';
       $search_capacity = $_POST['search_capacity'] ?? '';
       $search_date = $_POST['search_date'] ?? '';
       $search_keywords = $_POST['search_keywords'] ?? '';
   
       // Construct the base SQL query
       $sql = "SELECT * FROM events WHERE 1=1";
   
       // Add filters based on the search criteria
       if (!empty($search_date)) {
        $sql .= " AND date LIKE '%$search_date%'";
    }
       if (!empty($search_location)) {
           $sql .= " AND location = '$search_location'";
       }
       if (!empty($search_capacity)) {
        $sql .= " AND capacity = '$search_capacity'";
    }

       if (!empty($search_keywords)) {
        // Split the keywords into an array
        $keywords = explode(" ", $search_keywords);
        $conditions = [];
        foreach ($keywords as $keyword) {
            $conditions[] = "title LIKE '%$keyword%' OR description LIKE '%$keyword%'";
        }
        $sql .= " AND (" . implode(" OR ", $conditions) . ")";
    }
   
       $result = $conn->query($sql);
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
        <a href="participant.php" class="btn btn-danger"><span class="mx-2 text-white">Dashboard</span></a>
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
        <form method="POST" action="">
                    <div class="row mb-3">
                    <div class="col-md-3">
                            <label for="search_date" class="form-label">Search by Date:</label>
                            <input type="text" class="form-control" id="search_date" name="search_date" value="<?php echo $search_date; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="search_location" class="form-label">Search by Location:</label>
                            <input type="text" class="form-control" id="search_location" name="search_location" value="<?php echo $search_location; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="search_capacity" class="form-label">Search by Capacity:</label>
                            <input type="text" class="form-control" id="search_capacity" name="search_capacity" value="<?php echo $search_capacity; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="search_keywords" class="form-label">Search by Keywords:</label>
                            <input type="text" class="form-control" id="search_keywords" name="search_keywords" value="<?php echo $search_keywords; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
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
                    <th>Register</th>
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
                        echo "<form method='POST' action='event_registration.php'>"; // Change 'register.php' to the appropriate PHP file for handling registration
                        echo "<input type='hidden' name='event_id' value='" . $row["id"] . "'>"; // Hidden input field to store the event ID
                        echo "<button type='submit' class='btn btn-primary'>Register</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No events found</td></tr>";
                }
                ?>
            </table>
            <!-- Add the JavaScript code for displaying the popup -->
    <script>
        // Check if the URL contains the registration popup anchor
        if (window.location.hash === '#registration-popup') {
            // Show the popup
            alert("<?php echo $_SESSION['registration_status']; ?>");

            // Clear the registration status message
            <?php unset($_SESSION['registration_status']); ?>
        }
    </script>
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