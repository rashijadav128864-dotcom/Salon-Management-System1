<?php

// Database Configuration
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "salon_management";

// Create Connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check Connection
if (!$conn) {
    die(
        "Database connection failed.<br>" .
        "Please make sure:<br>" .
        "1. MySQL is running in XAMPP.<br>" .
        "2. Database 'salon_management' exists.<br><br>" .
        "Error: " . mysqli_connect_error()
    );
}

// Set Character Set
if (!mysqli_set_charset($conn, "utf8mb4")) {
    die("Error setting database character set.");
}