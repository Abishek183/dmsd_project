<?php
session_start();
include_once "../db.php";
// Assuming you have already established a database connection

// Function to retrieve and print reserved documents by reader ID
function printReservedDocuments($readerID, $conn) {
    // Query to retrieve reserved documents by reader ID
    $reservedQuery = "SELECT r.DOCID, r.COPYNO, d.TITLE, d.PDATE, p.PUBNAME
                      FROM RESERVES r
                      JOIN DOCUMENT d ON r.DOCID = d.DOCID
                      JOIN PUBLISHER p ON d.PUBLISHERID = p.PUBLISHERID
                      WHERE r.RID = $readerID";

    // Execute the query
    $reservedResult = mysqli_query($conn, $reservedQuery);

    // Check if there are reserved documents
    if (mysqli_num_rows($reservedResult) > 0) {
        echo "Reserved Documents:<br>";
        // Output each reserved document and its status
        while ($row = mysqli_fetch_assoc($reservedResult)) {
            echo "Document ID: " . $row['DOCID'] . "<br>";
            echo "Copy Number: " . $row['COPYNO'] . "<br>";
            echo "Title: " . $row['TITLE'] . "<br>";
            echo "Publication Date: " . $row['PDATE'] . "<br>";
            echo "Publisher: " . $row['PUBNAME'] . "<br>";
            echo "Status: Reserved<br>";
            echo "<br>";
        }
    } else {
        echo "No reserved documents found for reader ID $readerID.<br>";
    }
}

// Function to retrieve and print borrowed documents by reader ID
function printBorrowedDocuments($readerID, $conn) {
    // Query to retrieve borrowed documents by reader ID
    $borrowedQuery = "SELECT b.DOCID, d.TITLE, b.COPYNO, d.PDATE, p.PUBNAME, br.BDTIME, br.RDTIME
                      FROM BORROWS b
                      JOIN DOCUMENT d ON b.DOCID = d.DOCID
                      JOIN PUBLISHER p ON d.PUBLISHERID = p.PUBLISHERID
                      JOIN BORROWING br ON b.BOR_NO = br.BOR_NO
                      WHERE b.RID = $readerID";

    // Execute the query
    $borrowedResult = mysqli_query($conn, $borrowedQuery);

    // Check if there are borrowed documents
    if (mysqli_num_rows($borrowedResult) > 0) {
        echo "Borrowed Documents:<br>";
        // Output each borrowed document and its status
        while ($row = mysqli_fetch_assoc($borrowedResult)) {
            echo "Document ID: " . $row['DOCID'] . "<br>";
            echo "Copy Number: " . $row['COPYNO'] . "<br>";
            echo "Title: " . $row['TITLE'] . "<br>";
            echo "Publication Date: " . $row['PDATE'] . "<br>";
            echo "Publisher: " . $row['PUBNAME'] . "<br>";
            $overdue = 0;
            $fine = 0;
            if ($row['RDTIME'] == NULL) {
                $rdtime = time();
                $bdtime = strtotime($row['BDTIME']);
                $overdue = floor(($rdtime - $bdtime) / (60 * 60 * 24));
                $fine = $overdue * 0.2;
            }
            // Check if the document has been returned
            $status = $row['RDTIME'] ? "Returned" : (( $overdue > 20) ? "Overdue by $overdue days. Fine of $$fine required." : "Not Returned");

            echo "Status: $status<br>";
            echo "<br>";
        }
    } else {
        echo "No borrowed documents found for reader ID $readerID.<br>";
    }
}

// Example usage: Reader ID
$readerID = $_SESSION['reader_id'];

// Call functions to print reserved and borrowed documents
printReservedDocuments($readerID, $conn);
printBorrowedDocuments($readerID, $conn);

?>