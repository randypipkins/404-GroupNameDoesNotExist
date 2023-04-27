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
if(isset($_POST[`users`])){
    $first_name = $_POST[`first_name`];
    $last_name = $_POST[`last_name`];
    $passwrd = $_POST[`passwrd`];
    $email = $_POST[`email`];
    $roles = $_POST[`Roles`];

    //check if the name already exists
    $stmt = $db -> prepare("SELECT * FROM `users` WHERE first_name = ? AND last_name = ?;");
    $stmt -> bindParam(1, $first_name, PDO::PARAM_STR, 50);
    $stmt -> bindParam(2, $last_name, PDO::PARAM_STR, 50);
    $stmt -> execute();
    if($stmt->rowCount() > 0){
        echo "Name already exists.";
        exit;
    }

    //validate the password strength
    $uppercase = preg_match(`@[A-Z]@`, $passwrd);
    $lowercase = preg_match(`@[a-z]@`, $passwrd);
    $number = preg_match(`@[0-9]@`, $passwrd);
    $specialChar = preg_match(`@[^\w]@`, $passwrd);

    if(!$uppercase || !$lowercase || !$number || !$specialChar || strlen($passwrd) < 8){
        echo "Password needs to be at least 8 characters and must contain at least 1 uppercase, 1 
        lowercase, 1 number, and 1 special character.";
    } else{
        echo "Strong password.";
    }

    //insert the new user into the database
    $stmt = $db -> prepare("INSERT INTO `users` (first_name, last_name, passwrd, email, roles) VALUES (?, ?, ?, ?, ?);");
    $stmt -> execute([$first_name, $last_name, password_hash($passwrd, PASSWORD_DEFAULT), $email, $roles]);
    echo "You have been successfully registered";
}

?>