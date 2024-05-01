<?php
// Include database connection file
include_once "../db.php";


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $N = $_POST["n"];
    $I = $_POST["bid"];
    
    $query = "SELECT READER.RID, READER.RNAME, COUNT(BORROWS.BOR_NO) AS borrowed_count
              FROM BORROWS
              JOIN READER ON BORROWS.RID = READER.RID
              JOIN COPY ON BORROWS.DOCID = COPY.DOCID AND BORROWS.COPYNO = COPY.COPYNO AND BORROWS.BID = COPY.BID
              WHERE COPY.BID = ?  -- Ensure this is filtering by branch
              GROUP BY READER.RID, READER.RNAME
              ORDER BY borrowed_count DESC
              LIMIT ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Error preparing statement: " . htmlspecialchars($conn->error);
        exit;
    }
    $stmt->bind_param("ii", $I, $N);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if there are results
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table border='1'>
                <tr>
                    <th>Reader ID</th>
                    <th>Reader Name</th>
                    <th>Number of Books Borrowed</th>
                </tr>";
        
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["RID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["RNAME"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["borrowed_count"]) . "</td>";
            echo "</tr>";
        }
        
        // Close table
        echo "</table>";
    } else {
        echo "No borrowers found for branch $I.";
    }
    
    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, display form
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
            Number N: <input type='number' name='N'><br>
            Branch Number I: <input type='number' name='I'><br>
            <input type='submit' value='Submit'>
          </form>";
}

// Close connection
$conn->close();
?>