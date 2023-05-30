<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "CSCD378GroupWeb";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["user_id"]) && isset($_POST["promote_user"])) {
        $userId = $_POST["user_id"];

        // Fetch the user's current role from the database
        $sql = "SELECT user_role FROM users WHERE id = $userId";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userRole = $row["user_role"];

            if ($userRole === "participant") {
                // Promote the user to "event_organizer"
                $newRole = "event_organizer";

                // Update the user's role in the database
                $updateSql = "UPDATE users SET user_role = '$newRole' WHERE id = $userId";
                if ($conn->query($updateSql) === TRUE) {
                    echo "User promoted successfully.";
                } else {
                    echo "Error promoting user: " . $conn->error;
                }
            } else {
                echo "Only 'participant' users can be promoted to 'event_organizer'.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Invalid request.";
    }
}
?>
