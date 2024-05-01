<?php
// Include database connection file
include_once "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

var_dump($_POST);

$title = $_POST["title"];
$authors = $_POST["book_author"];
$isbn = $_POST["book_isbn"];
$pdate = $_POST["pdate"];
$pid = $_POST["pid"];

$errors = array();

// Step 1: Insert into DOCUMENT table
$query = "INSERT INTO DOCUMENT (TITLE, PDATE, PUBLISHERID) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $title, $pdate, $pid);
if (!$stmt->execute()) {
    $errors[] = "Error inserting into DOCUMENT table: " . $stmt->error;
}

// Retrieve the generated DOCID
$docId = $stmt->insert_id;

// Close the statement
$stmt->close();

// Step 2: Insert into BOOK table
$query = "INSERT INTO BOOK (DOCID, ISBN) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $docId, $isbn);
if (!$stmt->execute()) {
    $errors[] = "Error inserting into BOOK table: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Step 3: Parse authors and insert into PERSON table
$authorsArray = explode(", ", $authors); // Assuming authors are comma-separated
foreach ($authorsArray as $authorName) {
    // Check if the author already exists in the PERSON table
    $query = "SELECT PID FROM PERSON WHERE PNAME = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $authorName);
    if (!$stmt->execute()) {
        $errors[] = "Error inserting into PERSON table: " . $stmt->error;
    }
    $result = $stmt->get_result();

    // If author doesn't exist, insert them into PERSON table
    if ($result->num_rows == 0) {
        $insertQuery = "INSERT INTO PERSON (PNAME) VALUES (?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("s", $authorName);
        $insertStmt->execute();

        // Retrieve the generated PID
        $authorId = $insertStmt->insert_id;

        // Close the statement
        $insertStmt->close();
    } else {
        // If author exists, retrieve their PID
        $row = $result->fetch_assoc();
        $authorId = $row['PID'];
    }

    // Close the statement
    $stmt->close();

    // Step 4: Insert into AUTHORS table
    $insertAuthorQuery = "INSERT INTO AUTHORS (PID, DOCID) VALUES (?, ?)";
    $insertAuthorStmt = $conn->prepare($insertAuthorQuery);
    $insertAuthorStmt->bind_param("ii", $authorId, $docId);
    $insertAuthorStmt->execute();

    // Close the statement
    $insertAuthorStmt->close();
}

// Check if there were any errors
if (empty($errors)) {
    echo "SUCCESSFULLY INSERTED NEW BOOK";
} else {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

// Close the connection
$conn->close();
?>