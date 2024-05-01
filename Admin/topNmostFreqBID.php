<?php
// Include database connection file
include_once "../db.php";


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $N = $_POST["n"];
    $I = $_POST["bid"];
    
    // Prepare the SQL query
    $query = "SELECT READER.RID, READER.RNAME, COUNT(*) AS borrowed_count
              FROM BORROWS
              INNER JOIN READER ON BORROWS.RID = READER.RID
              INNER JOIN COPY ON BORROWS.DOCID = COPY.DOCID AND BORROWS.COPYNO = COPY.COPYNO
              WHERE COPY.BID = ? AND BORROWS.RID IS NOT NULL
              GROUP BY READER.RID, READER.RNAME
              ORDER BY borrowed_count DESC
              LIMIT ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
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
            echo "<td>" . $row["RID"] . "</td>";
            echo "<td>" . $row["RNAME"] . "</td>";
            echo "<td>" . $row["borrowed_count"] . "</td>";
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