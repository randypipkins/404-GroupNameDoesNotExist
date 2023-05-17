<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add event</title>
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
      <h3 class="h3 text-white my-2" id="h3"> I Do Crew
	  </h3>
    <li href="" class="nav-link">
        <i class="bx bxs-dashboard text-white"></i>
        <a href="eventOrg.php" class="btn btn-danger"><span class="mx-2 text-white">Dashboard</span></a>
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
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Location</th>
                    <th>Capacity</th>
                </tr>
            </table>
        </div>

        <div class="tab tab-2">
            <label for="event-title">Event Title:</label>
            <input type="text" placeholder="Event Title" name="fname" id="input-0">

            <label for="Event Type">Event Type:</label>
            <input type="text" placeholder="Event Type" name="event-type" id="input-1">

            <label for="description">Description:</label>
            <input type="text" placeholder="Description" name="lname" id="input-2">

            <label for="start-date">Start Date:</label>
            <input type="text" placeholder="Start Date" name="start-date" id="input-3">

            <label for="end-date">End Date:</label>
            <input type="text" placeholder="End Date" name="end-date" id="input-4">

            <label for="start-time">Start Time:</label>
            <input type="text" placeholder="Start Time" name="start-time" id="input-5">

            <label for="end-time">End Time:</label>
            <input type="text" placeholder="End Time" name="end-time" id="input-6">

            <label for="location">Location:</label>
            <input type="text" placeholder="Location" name="location" id="input-7">

            <label for="capacity">Capacity:</label>
            <input type="text" placeholder="Capacity" name="capacity" id="input-8">

            <div class="button-div">
                <button class="btn add-btn">Add</button>
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

//event construction
class Event{
    public $id;
    public $title;
    public $location;
    public $start_time;
    public $end_time;
    public $description;
    public $organizer_id;
    public $category_id;

    public function __construct($title, $location, $start_time, $end_time, 
    $description, $organizer_id, $category_id){
        $this->$title;
        $this->$location;
        $this->$start_time;
        $this->$end_time;
        $this->$description;
        $this->$organizer_id;
        $this->$category_id;
    }
}

//event management system class
class EventManagementSystem{
    public $events;

    public function __construct(){
        $this->events = array();
    }

    //add event
    public function addEvent($events){
        global $conn;

        //prepare and execute sql statement to prevent injection
        $stmt = $conn->prepare("INSERT INTO events (title, location, start_time, end_time, 
        description, organizer_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssii", $events->title, $events->location, $events->start_time, 
            $events->end_time, $events->description, $events->organizer_id, $events->category_id);

        $stmt->execute();

        $events->id = $stmt->insert_id;

        $this->events[] = $events;

        $stmt->close();
    }

    //modify event
    public function modifyEvent($events){
        global $conn;

        //prepare and execute sql statement to prevent injection
        $stmt = $conn->prepare("UPDATE events SET title=?, location=?, start_time=?, end_time=?, 
            description=?, organizer_id=?, category_id=? WHERE id=?");
        
        $stmt->bind_param("sssssii", $events->title, $events->location, $events->start_time, 
            $events->end_time, $events->description, $events->organizer_id, $events->category_id);

        $stmt->execute();
        $stmt->close();
        
        //update the events in the array
        foreach($this->events as &$e){
            if($e->id == $events->id){
                $e=$events;
                break;
            }
        }
    }

    //delete event
    public function deleteEvent($event_id){
        global $conn;

        //prepare and execute sql statement to prevent injection
        $stmt = $conn->prepare("DELETE FROM events WHERE id=?");

        $stmt->bind_param("i", $event_id);

        $stmt->execute();
        $stmt->close();
    }
}

//check if form is submitted
if($_SERVER["REQUEST_METHOD"] === "POST"){
    
}
?>