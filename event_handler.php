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
      // Prepare the insert statement
      $stmt = $conn->prepare("INSERT INTO events (title, location, date, start_time, end_time, capacity, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
      // Bind the parameters
      $stmt->bind_param("sssssss", $title, $location, $date, $start_time, $end_time, $capacity, $description);
  
      // Retrieve the form values
      $title = $_POST["title"];
      $location = $_POST["location"];
      $date = $_POST["date"];
      $start_time = $_POST["start_time"];
      $end_time = $_POST["end_time"];
      $capacity = $_POST["capacity"];
      $description = $_POST["description"];
  
      // Execute the statement
      if ($stmt->execute()) {
          echo "Event added successfully";
      } else {
          echo "Error adding event: " . $stmt->error;
      }
  
      // Close the statement and connection
      $stmt->close();
      $conn->close();
  }
  ?>