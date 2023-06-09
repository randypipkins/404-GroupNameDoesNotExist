<?php
    $servername = "localhost";
    $username = "root";
    $password = "CSCD378GroupWeb";

    //Create connection
    $conn = new mysqli($servername, $username, $password);
    //Check connection
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    //Create database
    $sql = "CREATE DATABASE IF NOT EXISTS myDB";
    if($conn->query($sql) === TRUE){
        echo "Database created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }
    $conn->close();

    //Re-create connection, this time connecting to the DB as well
    $dbname = "myDB";
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    //Create users table
    $sql = "CREATE TABLE IF NOT EXISTS `users`(
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) UNIQUE NOT NULL,
        `passwrd` VARCHAR(255) NOT NULL,
        `first_name` VARCHAR(50) NOT NULL,
        `last_name` VARCHAR(50) NOT NULL,
        `user_role` ENUM('event_organizer', 'participant', 'admin') NOT NULL DEFAULT 'participant',
        `is_banned` INT NOT NULL DEFAULT 0,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if($conn->query($sql) === TRUE){
        echo "Table users created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }

    //Create admin table
    $sql = "CREATE TABLE IF NOT EXISTS `admin`(
       `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       `user_id` INT UNSIGNED NOT NULL,
       FOREIGN KEY (user_id) REFERENCES users(id) 
    )";
    if($conn->query($sql) === TRUE){
        echo "Table admin created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }

    //Create event_categories table
    $sql = "CREATE TABLE IF NOT EXISTS `event_categories`(
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(50) NOT NULL,
        `description` TEXT
    )";
    if($conn->query($sql) === TRUE){
        echo "Table event_categories created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }

    //Create event table
    $sql = "CREATE TABLE IF NOT EXISTS `events`(
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `event_type` VARCHAR(255) NOT NULL,
        `location` VARCHAR(255) NOT NULL,
        `date` VARCHAR(255) NOT NULL,
        `start_time` VARCHAR(255) NOT NULL,
        `end_time` VARCHAR(255) NOT NULL,
        `capacity` VARCHAR(255) NOT NULL,
        `description` VARCHAR(255) NOT NULL,
        `organizer_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (organizer_id) REFERENCES users(id)
    )";
    if($conn->query($sql) === TRUE){
        echo "Table events created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }
       //Create approve event table
       $sql = "CREATE TABLE IF NOT EXISTS `approved_events`(
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `event_type` VARCHAR(255) NOT NULL,
        `location` VARCHAR(255) NOT NULL,
        `date` VARCHAR(255) NOT NULL,
        `start_time` VARCHAR(255) NOT NULL,
        `end_time` VARCHAR(255) NOT NULL,
        `capacity` VARCHAR(255) NOT NULL,
        `wait_list` INT NOT NULL DEFAULT 10,
        `description` VARCHAR(255) NOT NULL,
        `organizer_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (organizer_id) REFERENCES users(id)
    )";
    if($conn->query($sql) === TRUE){
        echo "Table approved_events created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }
       //Create reject event table
       $sql = "CREATE TABLE IF NOT EXISTS `rejected_events`(
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `event_type` VARCHAR(255) NOT NULL,
        `location` VARCHAR(255) NOT NULL,
        `date` VARCHAR(255) NOT NULL,
        `start_time` VARCHAR(255) NOT NULL,
        `end_time` VARCHAR(255) NOT NULL,
        `capacity` VARCHAR(255) NOT NULL,
        `description` VARCHAR(255) NOT NULL,
        `organizer_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (organizer_id) REFERENCES users(id)
    )";
    if($conn->query($sql) === TRUE){
        echo "Table rejected_events created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }

    //Create participation table
    $sql = "CREATE TABLE IF NOT EXISTS `participation`(
        `participant_capacity` INT NOT NULL,
        `wait_list` INT NOT NULL,
        `isFull` BOOLEAN NOT NULL DEFAULT FALSE, 
        `user_id` INT UNSIGNED NOT NULL,
        `email` VARCHAR(255) NOT NULL, 
        `event_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (event_id) REFERENCES events(id)
     )"; //added email for waitlist 
     if($conn->query($sql) === TRUE){
         echo "Table participation created successfully";
     } else{
         echo "Error creating database: " . $conn->error;
     }

    //Create registration table
    $sql = "CREATE TABLE IF NOT EXISTS `registration`(
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `email` VARCHAR(255) UNIQUE NOT NULL,
        `event_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (event_id) REFERENCES events(id)
    )";
    if($conn->query($sql) === TRUE){
        echo "Table registration created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }

    //Create error log table
    $sql = "CREATE TABLE IF NOT EXISTS `error_logs`(
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `error_message` TEXT,
        `file_name` VARCHAR(255),
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    if($conn->query($sql) === TRUE){
        echo "Table error_logs created successfully";
    } else{
        echo "Error creating database: " . $conn->error;
    }

    //Create cookies table
    $sql = "CREATE TABLE IF NOT EXISTS `cookies`(
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `token` VARCHAR(255) NOT NULL,
        last_access_timestamp INT NOT NULL,
        expiry INT NOT NULL,
        CONSTRAINT fk_user_id 
            FOREIGN KEY (user_id)
            REFERENCES users(id)
            ON DELETE CASCADE
        )";
        if($conn->query($sql) === TRUE){
            echo "Table cookies created successfully";
        } else{
            echo "Error creating database: " . $conn->error;
        }

?>