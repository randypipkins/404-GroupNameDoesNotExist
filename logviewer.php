<!DOCTYPE html>
<html>
<head>
  <title>Error Logs</title>
  <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 5px;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <?php
  $hostName = "localhost";
  $userName = "root";
  $password = "CSCD378GroupWeb";
  $databaseName = "mydb";
  $conn = new mysqli($hostName, $userName, $password, $databaseName);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM error_logs";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Error Message</th><th>File Name</th></tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr><td>" . $row["error_message"] . "</td><td>" . $row["file_name"] . "</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
  $conn->close();
  ?>
</body>
</html>