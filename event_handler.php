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
    public $capacity;
    public $description;
    public $organizer_id;
    public $category_id;

    public function __construct($title, $location, $start_time, $end_time, 
    $capacity, $description, $organizer_id, $category_id){
        $this->title = $title;
        $this->location = $location;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->capacity = $capacity;
        $this->description = $description;
        $this->organizer_id = $organizer_id;
        $this->category_id = $category_id;
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
        capacity, description, organizer_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssii", $events->title, $events->location, $events->start_time, 
            $events->end_time, $events->capacity, $events->description, $events->organizer_id, $events->category_id);

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
            capacity=?, description=?, organizer_id=?, category_id=? WHERE id=?");
        
        $stmt->bind_param("sssssii", $events->title, $events->location, $events->start_time, 
            $events->end_time, $events->capacity, $events->description, $events->organizer_id, $events->category_id);

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

        $stmt->bind_param("i", $id);

        $stmt->execute();
        $stmt->close();
    }
}