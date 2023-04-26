<?php

$servername = "localhost";
$username = "root";
$password = "CSCD378GroupWeb";
$dbname = "myDB";

//create connection to the server and the database
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

//user registration
if(isset($_POST['register'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $passwrd = $_POST['passwrd'];
    $email = $_POST['email'];

    //check if the name already exists
    $stmt = $db -> prepare("SELECT * FROM users WHERE first_name = ? AND last_name = ?");
    $stmt -> bindParam(1, $first_name, PDO::PARAM_STR, 50);
    $stmt -> bindParam(2, $last_name, PDO::PARAM_STR, 50);
    $stmt -> execute();
    if($stmt->rowCount() > 0){
        echo "Name already exists.";
        exit;
    }

    //insert the new user into the database
    $stmt = $db -> prepare("INSERT INTO users (first_name, last_name, passwrd, email) VALUES (?, ?, ?, ?)");
    $stmt -> execute([$first_name, $last_name, password_hash($password, PASSWORD_DEFAULT), $email]);
    echo "You have been successfully registered";
}

?>