<?php
    function log_error($error_message, $file_name){
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

        $sql = "INSERT INTO error_logs (error_message, file_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $error_message, $file_name);
        $stmt->execute();
        $stmt->close();

        $conn->close();
    }
?>