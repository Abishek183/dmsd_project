<?php
error_reporting(E_ALL & ~E_NOTICE);
// Include database connection file
include_once "retrivecountavailable.php";
include_once "../db.php";

// Check if search query is submitted
if (isset($_GET['query'])) {
    // Sanitize the search query
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);

    // Construct the SQL query to retrieve available copies per branch for the given document
    $sql = "SELECT DOCUMENT.DOCID, DOCUMENT.TITLE, PUBLISHER.PUBNAME
            FROM DOCUMENT
            LEFT JOIN PUBLISHER ON DOCUMENT.PUBLISHERID = PUBLISHER.PUBLISHERID
            WHERE DOCUMENT.DOCID = '$search_query' OR DOCUMENT.TITLE LIKE '$search_query' OR PUBLISHER.PUBNAME LIKE '$search_query'
            GROUP BY DOCUMENT.DOCID, DOCUMENT.TITLE, PUBLISHER.PUBNAME";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Display the search results
        echo "<h2>Search Results</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Document ID</th><th>Title</th><th>Publisher</th><th>Branch ID</th><th>Available Copies</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['DOCID'] . "</td>";
            echo "<td>" . $row['TITLE'] . "</td>";
            echo "<td>" . $row['PUBNAME'] . "</td>";
            foreach ($totalCountsPerBranch as $branchID => $docCounts) {
                if (isset($docCounts[$row['DOCID']])) {
                    $totalCount = $docCounts[$row['DOCID']];
                    echo "<td>" . $branchID . "</td>";
                    echo "<td>" . $totalCount . "</td>";
                    $found = true;
                    break; // Exit the loop once the DOCID is found
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No documents found.";
    }
}
?>