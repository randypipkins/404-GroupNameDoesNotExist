<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="main-nav2">
        <h1>
            I Do Crew
        </h1>
    </nav>
    <section class="main-section2">
        <article class="form-container2">
            <h1>
                <strong>Registration</strong>
            </h1>
            <form method="POST" class="form" action="registration.php">
                <div>
                    <label for="firstName" class="firstName"><strong>Enter First Name:</strong></label>
                    <br>
                    <input type="text" class="fullNametxt" name="first_name" id="first_name" required>
                    <br>
                    <label for="lastName" class="lastName"><strong>Enter Last Name:</strong></label>
                    <br>
                    <input type="text" class="fullNametxt" name="last_name" id="last_name" required>
                    <br>
                    <label for="email" class="email2"><strong>Enter Email Address:</strong></label>
                    <br>
                    <input type="text" class="borderE2" name="email" id="email" pattern="[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*" placeholder="example@email.com" required>
                    <br>
                    <label for="password" class="password2"><strong>Enter Password:</strong></label>
                    <br>
                    <input type="password"class="borderP2" name="passwrd">
                    <br>
                    <label for="Roles" class="Roles"><strong>Choose a role:</strong></label>
                    <br>
                    <select name="Roles" class="list">
                        <option value="Admin">Admin</option>
                        <option value="Event Organizer">Event Organizer</option>
                        <option value="Participant">Participant</option>
                    </select>
                    <br>
                    <button type="submit" class="submit2">Submit</button>
                </div>
            </form>
        </article>
    </section>
</body>
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

//validate the password strength
$uppercase = preg_match(`@[A-Z]@`, $passwrd);
$lowercase = preg_match(`@[a-z]@`, $passwrd);
$number = preg_match(`@[0-9]@`, $passwrd);
$specialChar = preg_match(`@[^\w]@`, $passwrd);

if(!$uppercase || !$lowercase || !$number || !$specialChar || strlen($passwrd) < 8){
    echo "Password needs to be at least 8 characters and must contain at least 1 uppercase, 1 
    lowercase, 1 number, and 1 special character.";
} else{
    $hashed_password = password_hash($passwrd, PASSWORD_DEFAULT);
}

//insert the new user into the database
$sql = "INSERT INTO `users` (`id`, `email`, `passwrd`, `first_name`, `last_name`, `user_role`) VALUES ('$user_id', '$email', '$passwrd', 
    '$first_name', '$last_name', '$user_role');";

if(mysqli_query($conn, $sql)){
    header("Location: /404-GroupNameDoesNotExist/index.html");
    exit;
} else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>