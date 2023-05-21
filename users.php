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
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>End Time</th>
                    <th>Ban/Delete/Promote</th>
                </tr>
                <?php
                // Fetch data from the users table
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["user_role"] . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='ban.php'>"; // Change 'ban.php' to the appropriate PHP file for handling ban
                        echo "<button type='submit' class='btn btn-primary'>Ban</button>";
                        echo "</form>";
                        echo "<form method='POST' action='delete.php'>"; // Change 'delete.php' to the appropriate PHP file for handling delete
                        echo "<button type='submit' class='btn btn-primary'>Delete</button>";
                        echo "</form>";
                        echo "<form method='POST' action='promote.php'>"; // Change 'promote.php' to the appropriate PHP file for handling promote
                        echo "<button type='submit' class='btn btn-primary'>Promote</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No users found</td></tr>";
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