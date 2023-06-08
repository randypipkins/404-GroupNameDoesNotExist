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

$currentTime = time();

//check if the token is set
if(isset($_COOKIE["token"])){
    //prepare sql to prevent sql injection
    if($stmt = $conn->prepare("SELECT user_id, last_access_timestamp, expiry FROM cookies WHERE token = ?")){
        $stmt->bind_param('s', $_COOKIE["token"]);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows > 0){
            $stmt->bind_result($user_id, $last_access_timestamp, $expiry);
            $stmt->fetch();
            
            //check if the token has expired
            if($expiry < time()){
                //delete the token from the database and redirect to login page
                $stmt = $conn->prepare("DELETE FROM cookies WHERE token = ?");
                $stmt->bind_param('s', $_COOKIE["token"]);
                $stmt->execute();
                setcookie("token", "", time() - 3600, "/", "", true, true);
                header("Location: login.php");
                exit();
            } else{
                //refresh the last access timestamp
                $stmt = $conn->prepare("UPDATE cookies SET last_access_timestamp = ? WHERE token = ?");
                $stmt->bind_param('is', $currentTime, $_COOKIE["token"]);
                $stmt->execute();
            }
        } else{
            //invalid token
            setcookie("token", "", time() - 3600, "/", "", true, true);
            header("Location: login.php");
            exit();
        }
        $stmt->close();
    }
}

//check if form is filled correctly
if(!isset($_POST["email"], $_POST["passwrd"])){
    exit("Please fill out the required fields.");
}

//prepare sql to prevent sql injection
if($stmt = $conn->prepare("SELECT id, passwrd, user_role, is_banned FROM users WHERE email = ?")){
    $stmt->bind_param('s', $_POST["email"]);
    $stmt->execute();
    //store results to check if exists in db
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $passwrd, $user_role, $isBanned); // Add $isBanned variable
        $stmt->fetch();
    
        if ($isBanned) {
            echo "This account has been banned.";
            exit();
        }
        //verify the password
        if(password_verify($_POST["passwrd"], $passwrd)){
            session_regenerate_id();
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["id"] = $id;
            
            //generate a unique token for the user and store it in the database
            if($user_role === "temporary_visitor"){
                $token = md5(rand());
            } else {
                $token = bin2hex(random_bytes(16));
            }
            $expiry = time() + (86400 * 30); // 30 days from now
            $stmt = $conn->prepare("INSERT INTO cookies (user_id, token, last_access_timestamp, expiry) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('issi', $id, $token, $currentTime, $expiry);
            $stmt->execute();
            
            //set the token as a cookie
            setcookie("token", $token, $expiry, "/", "", true, true);
            
            //redirect based on user role
            if($user_role === "participant"){
                header("Location: participant.php");
            } else if($user_role === "event_organizer"){
                header("Location: eventOrg.php");
            } else if($user_role === "admin"){
                header("Location: adminEvents.php");
            } else{
                echo "Invalid role";
            }
            exit();
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