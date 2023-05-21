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

//event construction
class Event{
    public $id;
    public $title;
    public $location;
    public $date;
    public $start_time;
    public $end_time;
    public $capacity;
    public $description;
    public $organizer_id;

    public function __construct($title, $location, $date, $start_time, $end_time, 
    $capacity, $description, $organizer_id){
        $this->title = $title;
        $this->location = $location;
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->capacity = $capacity;
        $this->description = $description;
        $this->organizer_id = $organizer_id;
    }
}

//event management system class
class EventManagementSystem{
    public $events;

    public function __construct(){
        $this->events = array();
    }

    //add event
    public function addEvent($events, $organizer_id, $conn){

        // Prepare and execute SQL statement to prevent injection
        $stmt = $conn->prepare("INSERT INTO events (title, event_type, location, date, start_time, end_time, capacity, description, organizer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if (!$stmt) {
            // Error occurred while preparing the statement
            $errorLogDirectory = "ErrorLogs";
            $errorLogFile = "error.log";
            $errorLogPath = $errorLogDirectory . "/" . $errorLogFile;
    
            if (!is_dir($errorLogDirectory)) {
                // Create the error log directory if it doesn't exist
                mkdir($errorLogDirectory, 0755, true);
                // Set appropriate write permissions for the directory
                chmod($errorLogDirectory, 0755);
            }
    
            if (!file_exists($errorLogPath)) {
                // Create the error log file if it doesn't exist
                touch($errorLogPath);
                // Set appropriate write permissions for the file
                chmod($errorLogPath, 0644);
            }
    
            $errorMessage = "Error preparing the statement: " . $conn->error;
            error_log($errorMessage, 3, $errorLogPath);
            die("An error occurred. Please check the error log for details.");
        }
    
        $stmt->bind_param("ssssssssi", $events->title, $events->event_type, $events->location, $events->date, $events->start_time, $events->end_time, $events->capacity, $events->description, $events->organizer_id);
    
        if (!$stmt->execute()) {
            // Error executing the statement
            $errorLogPath = "ErrorLogs/error.log";
            $errorMessage = "Error executing the statement: " . $conn->error;
            error_log($errorMessage, 3, $errorLogPath);
            die("An error occurred. Please check the error log for details.");
        }
    
        $events->id = $stmt->insert_id;
    
        $this->events[] = $events;
    
        $stmt->close();
    }
    

    //modify event
    public function modifyEvent($events){
        global $conn;

        //prepare and execute sql statement to prevent injection
        $stmt = $conn->prepare("UPDATE events SET title=?, location=?, date=?, start_time=?, end_time=?, 
            capacity=?, description=?, organizer_id=?, category_id=? WHERE id=?");
        
        $stmt->bind_param("ssssssii", $events->title, $events->location, $events->start_time, 
            $events->end_time, $events->capacity, $events->description, $events->organizer_id);

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

//handle the incoming request
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST["title"];
    $location = $_POST["location"];
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $capacity = $_POST["capacity"];
    $description = $_POST["description"];

    $event = new Event($title, $location, $date, $start_time, $end_time, $capacity,
        $description, $organizer_id);

    $eventManagementSystem = new EventManagementSystem();

    //add the event
    $eventManagementSystem->addEvent($event, $organizer_id, $conn);

    //echo the event ID as the response
    echo $event->id;
}
?>