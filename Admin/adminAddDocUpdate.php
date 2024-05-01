<?php
// Include database connection file
include_once "../db.php";

// Function to increment the last character of the position string
function incrementPosition($position) {
    // Convert the last character to its ASCII value and increment by 1
    $lastChar = ord(substr($position, -1));
    $lastChar++;
    // If the incremented value exceeds 'f' (ASCII 102), reset to '0' (ASCII 48)
    if ($lastChar > 102) {
        $lastChar = 48;
    }
    // Replace the last character with the incremented value
    $position = substr($position, 0, -1) . chr($lastChar);
    return $position;
}

// Get the input values
$docId = $_POST['doc_id'];
$branchId = $_POST['branch_id'];
$incrementBy = $_POST['add'];
$pos = $_POST['pos'];

// Get the current maximum COPYNO for the given DOCID and BID
$getMaxCopyNoQuery = "SELECT MAX(COPYNO) AS max_copyno FROM COPY WHERE DOCID = ? AND BID = ?";
$stmt = $conn->prepare($getMaxCopyNoQuery);
$stmt->bind_param("ii", $docId, $branchId);
$stmt->execute();
$stmt->bind_result($maxCopyNo);
$stmt->fetch();
$stmt->close();

// If no previous COPYNO exists, start from 1
if ($maxCopyNo === null) {
    $maxCopyNo = 0;
}

// Prepare the insertion query
$insertCopyQuery = "INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($insertCopyQuery);

// Insert rows with incremented COPYNO values
for ($i = 1; $i <= $incrementBy; $i++) {
    $copyNo = $maxCopyNo + $i;
    $stmt->bind_param("iiis", $docId, $copyNo, $branchId, $pos);
    $pos = incrementPosition($pos);
    $stmt->execute();
}

// Check if any rows were inserted
if ($stmt->affected_rows > 0) {
    echo "Rows inserted successfully.";
} else {
    echo "Failed to insert rows.";
}

// Close the statement
$stmt->close();
?>
