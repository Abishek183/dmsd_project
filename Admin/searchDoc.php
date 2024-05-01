<?php
// Include database connection file
include_once "../db.php";
// Start session
session_start();

// Check if document ID is provided
if(isset($_POST['doc_id'])) {
    $doc_id = $_POST['doc_id'];

    // Prepare the SQL query
    $query = "SELECT 
                DOCUMENT.DOCID,
                DOCUMENT.TITLE,
                COPY.COPYNO,
                CASE
                    WHEN RESERVES.DOCID IS NOT NULL THEN 'Reserved'
                    WHEN BORROWS.DOCID IS NOT NULL THEN 
                        CASE
                            WHEN BORROWING.RDTIME IS NULL THEN 'Borrowed'
                            ELSE 'Available'
                        END
                    ELSE 'Available'
                END AS STATUS
            FROM 
                DOCUMENT
            JOIN 
                COPY ON DOCUMENT.DOCID = COPY.DOCID
            LEFT JOIN 
                RESERVES ON DOCUMENT.DOCID = RESERVES.DOCID AND COPY.COPYNO = RESERVES.COPYNO AND COPY.BID = RESERVES.BID
            LEFT JOIN 
                BORROWS ON DOCUMENT.DOCID = BORROWS.DOCID AND COPY.COPYNO = BORROWS.COPYNO AND COPY.BID = BORROWS.BID AND BORROWS.RID IS NOT NULL
            LEFT JOIN 
                BORROWING ON BORROWS.BOR_NO = BORROWING.BOR_NO
            WHERE 
                DOCUMENT.DOCID = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $doc_id);
    
    // Execute the query
    $stmt->execute();
    
    // Bind result variables
    $stmt->bind_result($doc_id, $title, $copy_no, $status);
    
    // Fetch result
    echo "<table border='1'>
            <tr>
                <th>DOCID</th>
                <th>Title</th>
                <th>Copy Number</th>
                <th>Status</th>
            </tr>";
    while($stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . $doc_id . "</td>";
        echo "<td>" . $title . "</td>";
        echo "<td>" . $copy_no . "</td>";
        echo "<td>" . $status . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Close statement
    $stmt->close();
} else {
    echo "Document ID not provided.";
}
?>
