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
                <h2><a href="registration.html">Register Today!</a> </h2> <!--change link-->
            </div>
        </article>
        <article class="form-container">
            <form method="POST" class="form" action="login.php">
                <img src="img/loginPhoto.jpg" alt="Man and woman creating a heart with their hands" class="form-image"> <!--adding alt for a accessibility(feature 1)-->
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