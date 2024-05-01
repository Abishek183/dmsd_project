<?php
// Include database connection file
include_once "../db.php";

// Query to retrieve the count of reserved documents grouped by branch ID
$reservedQuery = "SELECT c.BID AS branchID, c.DOCID AS docID, COUNT(r.COPYNO) AS reservedCount
                  FROM RESERVES r
                  JOIN COPY c ON r.DOCID = c.DOCID AND r.COPYNO = c.COPYNO AND r.BID = c.BID
                  GROUP BY c.BID, c.DOCID";

// Query to retrieve the count of borrowed documents grouped by branch ID
$borrowedQuery = "SELECT c.BID AS branchID, c.DOCID AS docID, COUNT(b.COPYNO) AS borrowedCount
                  FROM BORROWS b
                  JOIN BORROWING br ON b.BOR_NO = br.BOR_NO
                  JOIN COPY c ON b.DOCID = c.DOCID AND b.COPYNO = c.COPYNO AND b.BID = c.BID
                  WHERE br.RDTIME IS NULL
                  GROUP BY c.BID, c.DOCID";

// Execute the queries
$reservedResult = mysqli_query($conn, $reservedQuery);
$borrowedResult = mysqli_query($conn, $borrowedQuery);

// Initialize an array to store the final result
$totalCounts = array();

// Process the results of the reserved query
while ($row = mysqli_fetch_assoc($reservedResult)) {
    $branchID = $row['branchID'];
    $reservedCount = $row['reservedCount'];
    $totalCounts[$branchID]['reservedCount'] = $reservedCount;
}

// Process the results of the borrowed query
while ($row = mysqli_fetch_assoc($borrowedResult)) {
    $branchID = $row['branchID'];
    $borrowedCount = $row['borrowedCount'];
    // If the branch ID already exists in the array, add the borrowed count to the existing entry
    if (isset($totalCounts[$branchID])) {
        $totalCounts[$branchID]['borrowedCount'] = $borrowedCount;
    } else {
        // If the branch ID doesn't exist, create a new entry
        $totalCounts[$branchID] = array('borrowedCount' => $borrowedCount);
    }
}

// Calculate the total count for each branch
foreach ($totalCounts as &$branchCounts) {
    $branchCounts['totalCount'] = $branchCounts['reservedCount'] + $branchCounts['borrowedCount'];
}

// Print or process the final result as needed
//print_r($totalCounts);

// Given SQL query to retrieve the count of all copies by branch
$query = "SELECT 
            D.DOCID,
            D.TITLE,
            D.PDATE,
            P.PUBNAME,
            C.BID,
            COUNT(*) AS document_count
          FROM 
            DOCUMENT D
          JOIN 
            PUBLISHER P ON D.PUBLISHERID = P.PUBLISHERID
          JOIN 
            COPY C ON D.DOCID = C.DOCID
          GROUP BY 
            C.BID, D.DOCID, D.TITLE, D.PDATE, P.PUBNAME";

// Execute the query
$result = mysqli_query($conn, $query);

// Initialize an associative array to store the total counts per branch
$totalCountsPerBranch = array();

// Process the result set
while ($row = mysqli_fetch_assoc($result)) {
    $branchID = $row['BID'];
    $totalCount = $row['document_count'];
    $docID = $row['DOCID'];

    // Subtract the total count for the current branch from the corresponding total count obtained earlier
    if (isset($totalCounts[$branchID]['totalCount'])) {
        $totalCount -= $totalCounts[$branchID]['totalCount'];
    }

    // Store the result in the array
    $totalCountsPerBranch[$branchID][$docID] = $totalCount;

    // Output or process the result as needed
    //echo "<br>Branch ID: $branchID, DocID: $docID, Total Document Count: $totalCount";

}

//var_dump($totalCountsPerBranch);

?>