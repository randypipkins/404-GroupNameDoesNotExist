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
$user_id = rand(10,100);
$first_name = $_GET[`first_name`];
$last_name = $_GET[`last_name`];
$passwrd = $_GET[`passwrd`];
$email = $_GET[`email`];
$user_role = $_GET[`Roles`];

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
$sql = "INSERT INTO `users` (`id`, `email`, `passwrd`, `first_name`, `last_name`, `user_role`) VALUES ($user_id, $email, $passwrd, 
    $first_name, $last_name, $user_role);";
echo "You have been successfully registered";
?>