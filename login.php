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
if ($stmt = $conn->prepare("SELECT id, passwrd, user_role FROM users WHERE email = ?")) {
    $stmt->bind_param('s', $_POST["email"]);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $passwrd, $user_role);
        $stmt->fetch();
        // Verify the password
        if (password_verify($_POST["passwrd"], $passwrd)) {
            if ($user_role === "participant") {
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["id"] = $id;
                $_SESSION["user_role"] = $user_role;
                header("Location: events.php");
                exit();
            } else {
                // User role is not participant
                echo "You are not authorized to login.";
            }
        } else {
            // Incorrect password
            echo "Incorrect password.";
        }
    } else {
        // Incorrect email
        echo "Incorrect username";
    }

    $stmt->close();
}

$conn->close();
?>