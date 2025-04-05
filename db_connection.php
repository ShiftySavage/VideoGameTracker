<?php
// db_connection.php

$host = "localhost";
$dbname = "video_game_tracker";  // database name
$username = "root";  // MySQL username
$password = "";  // MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>