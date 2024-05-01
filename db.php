<?php
//ini_set('display_errors', 1);
// Database configuration
$servername = "localhost"; // Change this to your database server hostname
$username = "root";     // Change this to your database username
$password = "Aviabi@#9499";     // Change this to your database password
$database = "library"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>