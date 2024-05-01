<?php
session_start();
include_once "../db.php";
// Assuming you have already established a database connection

// Function to retrieve and print documents by publisher ID
function printDocumentsByPublisher($publisherID, $conn) {
    // Query to retrieve documents by publisher ID
    $query = "SELECT DOCID, TITLE
              FROM DOCUMENT
              WHERE PUBLISHERID = $publisherID";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if there are documents published by the given publisher
    if (mysqli_num_rows($result) > 0) {
        echo "Documents Published by Publisher ID $publisherID:<br>";
        // Output each document ID and title
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Document ID: " . $row['DOCID'] . "<br>";
            echo "Title: " . $row['TITLE'] . "<br>";
            echo "<br>";
        }
    } else {
        echo "No documents found for publisher ID $publisherID.<br>";
    }
}

// Example usage: Publisher ID
$publisherID = $_POST['pub_id'];

// Call the function to print documents by publisher ID
printDocumentsByPublisher($publisherID, $conn);

// Close the database connection
mysqli_close($conn);

?>
