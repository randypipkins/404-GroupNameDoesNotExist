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
   <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!-- Side-Nav -->
    <div class="side-nav active-nav" id="sidebar">
        <ul class="nav flex-column text-white w-100">
            <h3 class="h3 text-white my-2" id="h3"> I Do Crew</h3>
            <li href="" class="nav-link">
                <i class="bx bxs-dashboard text-white"></i>
                <span class="mx-2 text-white">Dashboard</span>
            </li>
            <li href="" class="nav-link">
                <i class="bx bxs-dashboard text-white"></i>
                <span class="mx-2 text-white">Events</span>
            </li>
            <li href="" class="nav-link">
                <i class="bx bx-user-check text-white"></i>
                <span class="mx-2 text-white">Logout</span>
            </li>
        </ul>
    </div>


    <div class="p-1 my-container active-cont">
        
        <!-- Top Nav -->
        <header>
            <h1>Events</h1>
            <p class="description-p">Add event title, description, start date (d/m/yr), start time(hh:mm AM/PM), end
                day(d/m/yr), end time(hh:mm AM/PM), location, capacity, event type(ex: Bridal Shower)</p>
            <form id="new-task-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="new-task-input" id="new-task-input" placeholder="Enter Event" />
                <input type="submit" id="new-task-submit" value="Add event" />
            </form>
        </header>
        <main>
            <section class="task-list">
                <div class="tabs">
                    <h2>Event title ||</h2>
                    <h2>description ||</h2>
                    <h2>start time ||</h2>
                    <h2>end time ||</h2>
                    <h2>location ||</h2>
                    <h2>capacity ||</h2>
                    <h2>event type ||</h2>
                </div>
                <div id="tasks"></div>
            </section>
        </main>
    </div>


    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="script.js"></script>
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