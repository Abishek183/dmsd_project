<?php
error_reporting(E_ALL & ~E_NOTICE);
// Include database connection file
include_once "retrivecountavailable.php";
include_once "../db.php";

// Check if search query is submitted
if (isset($_GET['query'])) {
    $docId = intval($_GET['query']); // Convert input to an integer for security

    // SQL query to retrieve document information along with copy counts by branch
    $sql = "SELECT d.DOCID, d.TITLE, p.PUBNAME, c.BID, COUNT(c.COPYNO) AS TotalCopies,
            COALESCE(SUM(b.borrowed), 0) AS CopiesBorrowed, COALESCE(SUM(r.reserved), 0) AS CopiesReserved
            FROM DOCUMENT d
            JOIN PUBLISHER p ON d.PUBLISHERID = p.PUBLISHERID
            JOIN COPY c ON d.DOCID = c.DOCID
            LEFT JOIN (
                SELECT b.DOCID, b.COPYNO, b.BID, COUNT(*) AS borrowed
                FROM BORROWS b
                JOIN BORROWING bo ON b.BOR_NO = bo.BOR_NO AND bo.RDTIME IS NULL
                GROUP BY b.DOCID, b.COPYNO, b.BID
            ) b ON c.DOCID = b.DOCID AND c.COPYNO = b.COPYNO AND c.BID = b.BID
            LEFT JOIN (
                SELECT r.DOCID, r.COPYNO, r.BID, COUNT(*) AS reserved
                FROM RESERVES r
                GROUP BY r.DOCID, r.COPYNO, r.BID
            ) r ON c.DOCID = r.DOCID AND c.COPYNO = r.COPYNO AND c.BID = r.BID
            WHERE d.DOCID = ?
            GROUP BY d.DOCID, d.TITLE, p.PUBNAME, c.BID";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $docId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($docId, $title, $pubName, $branchId, $totalCopies, $copiesBorrowed, $copiesReserved);

        // Check if any results are returned
        echo "<h2>Document Details</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Document ID</th><th>Title</th><th>Publisher</th><th>Branch ID</th><th>Total Copies</th><th>Copies Borrowed</th><th>Copies Reserved</th><th>Available Copies</th></tr>";
        while ($stmt->fetch()) {
            $availableCopies = $totalCopies - ($copiesBorrowed + $copiesReserved);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($docId) . "</td>";
            echo "<td>" . htmlspecialchars($title) . "</td>";
            echo "<td>" . htmlspecialchars($pubName) . "</td>";
            echo "<td>" . htmlspecialchars($branchId) . "</td>";
            echo "<td>" . htmlspecialchars($totalCopies) . "</td>";
            echo "<td>" . htmlspecialchars($copiesBorrowed) . "</td>";
            echo "<td>" . htmlspecialchars($copiesReserved) . "</td>";
            echo "<td>" . htmlspecialchars($availableCopies) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . htmlspecialchars($conn->error);
    }
} else {
    echo "No Document ID provided.";
}
?>