<?php
session_start();
if(isset($_SESSION["success_msg"])){
    echo '<div class="success-msg">' . $_SESSION['success_msg'] . '</div>';
    unset($_SESSION["success_msg"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body> 
    <nav class="main-nav">
        <h1>
            I Do Crew
        </h1>
    </nav>
    <section class="main-section">
        <article>
            <div>
                <h1>Ever After Events</h1> 
                <p>The stress-free way to plan your perfect wedding.</p>
                <p>Let us plan your happily ever after!</p>
            </div>
            <div>
                <h2><a href="registration.php">Register Today!</a> </h2> <!--change link-->
            </div>
        </article>
        <article class="form-container">
            <form method="POST" class="form" action="index.php">
                <img src="img/loginPhoto.jpg" alt="wedding photo" class="form-image">
                <div>
                    <label for="email" class="email"><strong>Email Address:</strong></label>
                    <br>
                    <input type="text" class="borderE" name="email" id="email" pattern="[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*" placeholder="example@email.com" required>
                    <br>
                    <label for="password" class="password"><strong>Password:</strong></label>
                    <br>
                    <input type="password"class="borderP" name="passwrd">
                    <br>
                    <button type="submit" class="login">Login</button>
                    <br>
                    <p><a href="forgotpassword.html" class="forgot">Forgot Password?</a></p>
                </div>
            </form>
        </article>
    </section> 
</body>
</body>
</html>

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
            header("Location: eventOrg.php");
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