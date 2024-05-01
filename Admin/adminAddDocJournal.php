<?php
// Include database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../db.php";

$journalVolumeNo = $_POST["journal_volume"];
$issueNum = $_POST["journal_issue_num"];
$journalIssueScope = ($_POST["journal_issue_scope"]);
$journalIssueEditor = ($_POST["journal_issue_editor"]);
$journalVolumeEditor = $_POST["journal_volume_editor"];
$docTitle = $_POST["title"];
$pdate = $_POST["pdate"];
$pid = $_POST["pid"];

$errors = array();

// Step 1: Insert into DOCUMENT table
$query = "INSERT INTO DOCUMENT (TITLE, PDATE, PUBLISHERID) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $docTitle, $pdate, $pid);
if (!$stmt->execute()) {
    $errors[] = "Error inserting into DOCUMENT table: " . $stmt->error;
}


// Retrieve the generated DOCID
$docId = $stmt->insert_id;

// Close the statement
$stmt->close();

// Step 2: Insert the journal volume editor into PERSON table
$insertEditorQuery = "INSERT INTO PERSON (PNAME) VALUES (?)";
$insertEditorStmt = $conn->prepare($insertEditorQuery);
$insertEditorStmt->bind_param("s", $journalVolumeEditor);
$insertEditorStmt->execute();

// Retrieve the generated PID
$editorPid = $insertEditorStmt->insert_id;

// Close the statement
$insertEditorStmt->close();

// Step 3: Insert into JOURNAL_VOLUME table
$insertJournalVolumeQuery = "INSERT INTO JOURNAL_VOLUME (DOCID, VOLUME_NO, EDITOR) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insertJournalVolumeQuery);
$stmt->bind_param("iis", $docId, $journalVolumeNo, $editorPid);
if (!$stmt->execute()) {
    $errors[] = "Error inserting into JOURNAL_VOLUMEtable: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Step 4: Populate JOURNAL_ISSUE table
$scopesArray = explode(", ", $journalIssueScope); // Assuming scopes are comma-separated
for ($i = 0; $i < count($scopesArray); $i++) {
    $issueNum = $i + 1; // Issue numbers from 1 to n
    $scope = $scopesArray[$i];
    
    $insertIssueQuery = "INSERT INTO JOURNAL_ISSUE (DOCID, ISSUE_NO, SCOPE) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertIssueQuery);
    $stmt->bind_param("iis", $docId, $issueNum, $scope);
    if (!$stmt->execute()) {
        $errors[] = "Error inserting into JOURNAL_ISSUE table: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Step 5: Populate PERSON table with journal issue editors
$editorsArray = explode(", ", $journalIssueEditor); // Assuming editors are comma-separated
foreach ($editorsArray as $editor) {
    $issueNum = intval(substr($editor, 0, 1)); // Extract issue number from editor string
    $editorName = substr($editor, 1); // Extract editor's name
    
    // Insert editor into PERSON table
    $insertEditorQuery = "INSERT INTO PERSON (PNAME) VALUES (?)";
    $insertEditorStmt = $conn->prepare($insertEditorQuery);
    $insertEditorStmt->bind_param("s", $editorName);
    $insertEditorStmt->execute();

    // Retrieve the generated PID
    $editorPid = $insertEditorStmt->insert_id;

    // Close the statement
    $insertEditorStmt->close();

    // Step 6: Insert into GEDITS table
    $insertGeditsQuery = "INSERT INTO GEDITS (DOCID, ISSUE_NO, PID) VALUES (?, ?, ?)";
    $insertGeditsStmt = $conn->prepare($insertGeditsQuery);
    $insertGeditsStmt->bind_param("iii", $docId, $issueNum, $editorPid);
    $insertGeditsStmt->execute();

    // Close the statement
    $insertGeditsStmt->close();
}

// Check if there were any errors
if (empty($errors)) {
    echo "SUCCESSFULLY INSERTED NEW JOURNAL";
} else {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

// Close the connection
$conn->close();
?>