<?php
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

//retrieve the id of the organizer currently logged in
session_start();

if(isset($_SESSION["email"])){
    $organizer_email = $_SESSION["email"];

    //prepare the sql statement to retrieve the ID based on the email of the logged in user
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $organizer_email);
    $stmt->execute();

    //get the result
    $result = $stmt->get_result();

    //check if a row is returned(i.e. there is an ID with the associated email)
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $organizer_id = $row["id"];
    }

    $stmt->close();
}

// Retrieve the value of the "action" field from the $_POST array
$action = $_POST['action'];

switch ($action) {
  case 'add':
    // Retrieve user input values from the $_POST array
    $title = $_POST['title'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];

    // Insert the data into the "events" table using an INSERT INTO statement
    $sql = "INSERT INTO events (title, location, date, start_time, end_time, capacity, description, organizer_id) 
    VALUES ('$title', '$location', '$date', '$start_time', '$end_time', '$capacity', '$description', '1')";

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    break;
    
  case 'edit':
    // Retrieve user input values from the $_POST array
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];

    // Update the data in the "events" table using an UPDATE statement
    $sql = "UPDATE events SET title='$title', location='$location', date='$date', start_time='$start_time', end_time='$end_time', capacity='$capacity', description='$description' WHERE id='$event_id'";

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    break;
    
  case 'delete':
    // Retrieve the event ID from the $_POST array
    $event_id = $_POST['event_id'];

    // Delete the data from the "events" table using a DELETE statement
    $sql = "DELETE FROM events WHERE id='$event_id'";

    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    break;
}

$conn->close();
?>