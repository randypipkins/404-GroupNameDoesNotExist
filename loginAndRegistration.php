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
    $user_id = rand(10,100);
    $first_name = $_REQUEST[`first_name`];
    $last_name = $_REQUEST[`last_name`];
    $passwrd = $_REQUEST[`passwrd`];
    $email = $_REQUEST[`email`];
    $user_role = $_REQUEST[`Roles`];

    //check if the name already exists
    //$stmt = $sql = "SELECT * FROM `users` WHERE first_name = $first_name AND last_name = last_name;";
    //$stmt -> bindParam(1, $first_name, PDO::PARAM_STR, 50);
    //$stmt -> bindParam(2, $last_name, PDO::PARAM_STR, 50);
    //$stmt -> execute();
    //if($stmt -> num_rows>= 1)

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

    //$stmt = $db -> prepare("INSERT INTO `users` (email, passwrd, first_name, last_name, user_role) VALUES (?, ?, ?, ?, ?);");
    //$stmt -> execute([$first_name, $last_name, password_hash($passwrd, PASSWORD_DEFAULT), $email, $roles]);
    $sql = "INSERT INTO `users` (id, email, passwrd, first_name, last_name, user_role) VALUES ($user_id, $email, $passwrd, 
    $first_name, $last_name, $user_role;";
    echo "You have been successfully registered";
}

//user login
if(isset($_POST['login'])){
    $email = $_REQUEST(`email`);
    $passwrd = $_REQUEST(`passwrd`);

    //get the email passed in the database
    $stmt = $db -> prepare("SELECT from `users` WHERE email = ?");
    $stmt -> execute([$email]);

    //if email is not found
    if($stmt -> rowCount() == 0){
        echo "Email not found.";
        exit;
    }

    $user = $stmt -> fetch();

    //password match
    if(password_verify($passwrd, $user[`passwrd`])){
        $_SESSION[`user_id`] = $user[`id`];
        echo "Logged in successfully";
    } else{
        echo "Incorrect password.";
    }
}

?>