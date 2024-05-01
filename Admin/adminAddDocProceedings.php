<?php
// Include database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../db.php";
$docTitle = $_POST["proceedings_title"];
$conferenceDate = $_POST["conference_date"];
$conferenceLocation = $_POST["conference_location"];
$conferenceChairs = ($_POST["conference_chair"]);
$pdate = $_POST["pdate"];
$pid = $_POST["pid"];

$errors = array();

// Step 1: Insert into DOCUMENT table
$query = "INSERT INTO DOCUMENT (TITLE, PDATE, PUBLISHERID) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $docTitle, $pdate, $pid);
if (!$stmt->execute()) {
    $errors[] = "Error inserting into DOCUMENT table: " . $stmt->error;
}

// Retrieve the generated DOCID
$docId = $stmt->insert_id;

// Close the statement
$stmt->close();

// Step 2: Insert into PROCEEDINGS table
$insertProceedingsQuery = "INSERT INTO PROCEEDINGS (DOCID, CDATE, CLOCATION) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insertProceedingsQuery);
$stmt->bind_param("iss", $docId, $conferenceDate, $conferenceLocation);
if (!$stmt->execute()) {
    $errors[] = "Error inserting into PROCEEDINGS table: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Step 3: Insert conference chairs into PERSON table
$chairsArray = explode(", ", $conferenceChairs); // Assuming chairs are comma-separated
foreach ($chairsArray as $chair) {
    // Insert chair into PERSON table
    $insertChairQuery = "INSERT INTO PERSON (PNAME) VALUES (?)";
    $insertChairStmt = $conn->prepare($insertChairQuery);
    $insertChairStmt->bind_param("s", $chair);
    $insertChairStmt->execute();

    // Retrieve the generated PID
    $chairPid = $insertChairStmt->insert_id;

    // Close the statement
    $insertChairStmt->close();

    // Step 4: Insert into CHAIRS table
    $insertChairsQuery = "INSERT INTO CHAIRS (DOCID, PID) VALUES (?, ?)";
    $insertChairsStmt = $conn->prepare($insertChairsQuery);
    $insertChairsStmt->bind_param("ii", $docId, $chairPid);
    if (!$insertChairsStmt->execute()) {
        $errors[] = "Error inserting chair '$chair' into CHAIRS table: " . $insertChairsStmt->error;
    }


    // Close the statement
    $insertChairsStmt->close();
}


// Check if there were any errors
if (empty($errors)) {
    echo "SUCCESSFULLY INSERTED NEW PROCEEDINGS";
} else {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

// Close the connection
$conn->close();
?>