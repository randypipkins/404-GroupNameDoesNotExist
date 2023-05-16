<?php
session_start();

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

//check if form is filled correctly
if(!isset($_POST["email"], $_POST["passwrd"])){
    exit("Please fill out the required fields.");
}

//prepare sql to prevent sql injection
if($stmt = $conn->prepare("SELECT id, passwrd FROM users WHERE email = ?")){
    $stmt->bind_param('s', $_POST["email"]);
    $stmt->execute();
    //store results to check if exists in db
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($id, $passwrd);
        $stmt->fetch();
        //verify the password
        if(password_verify($_POST["passwrd"], $passwrd)){
            session_regenerate_id();
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["id"] = $id;
            $stmt = $conn->prepare("SELECT user_role FROM users WHERE email = ?");
            $stmt->bind_param('s', $_POST["email"]);
            $stmt->execute();
            $stmt->bind_result($role);
            $stmt->fetch();
            $stmt->close();
            
            if ($user_role == "participant") {
                header("Location: registration.php");
                exit();
            } else {
                header("Location: eventOrg.php");
                exit();
            }
        } else{
            //incorrect password
            echo "Incorrect password.";
        }
    } else{
        //incorrect email
        echo "Incorrect username";
    }

    $stmt->close();
}
?>