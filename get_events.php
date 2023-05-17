<?php
  // Include database connection code
  $servername = "localhost";
  $username = "root";
  $password = "CSCD378GroupWeb";
  $dbname = "myDB";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch events data from the database
  $sql = "SELECT * FROM events";
  $result = $conn->query($sql);

  // Format events data as HTML table rows
  $rows = "";
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $rows .= "<tr>";
      $rows .= "<td>" . $row["title"] . "</td>";
      $rows .= "<td>" . $row["location"] . "</td>";
      $rows .= "<td>" . $row["date"] . "</td>";
      $rows .= "<td>" . $row["start_time"] . "</td>";
      $rows .= "<td>" . $row["end_time"] . "</td>";
      $rows .= "<td>" . $row["description"] . "</td>";
      $rows .= "<td>" . $row["organizer_id"] . "</td>";
      $rows .= "<td>" . $row["category_id"] . "</td>";
      $rows .= "</tr>";
    }
  }

  // Return the generated HTML table rows
  echo $rows;

  $conn->close();
?>
