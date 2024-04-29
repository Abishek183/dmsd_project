<?php
$host = 'localhost';
$dbname = 'library';
$username = 'root';
$password = 'Aviabi@#9499';

// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
   // echo "<p>Connection successful.</p>";  // Display a success message
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
