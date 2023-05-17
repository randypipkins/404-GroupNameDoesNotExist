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

//user registration
$user_id = rand(10,100);
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$passwrd = $_POST["passwrd"];
$email = $_POST["email"];
$user_role = $_POST["Roles"];

//validate email
if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    exit("Email is not valid.");
}

//password character length check
if(strlen($_POST["passwrd"] < 5)){
    exit("Password must be more than 5 characters.");
}

//hashing the password
$hashed_password = password_hash($passwrd, PASSWORD_DEFAULT);

//insert the new user into the database
$sql = "INSERT INTO `users` (`id`, `email`, `passwrd`, `first_name`, `last_name`, `user_role`) VALUES ('$user_id', '$email', '$hashed_password', 
    '$first_name', '$last_name', '$user_role');";

if(mysqli_query($conn, $sql)){
    session_start();
    $_SESSION["success_msg"] = "Registration Success";
    header("Location: /404-GroupNameDoesNotExist");
    exit;
} else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>