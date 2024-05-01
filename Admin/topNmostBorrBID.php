<?php
// Include database connection file
include_once "../db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $N = $_POST["N"];
    $branch_number = sanitize($_POST["branch_number"]);
    
    // Prepare the SQL query
    $query = "SELECT DOCUMENT.TITLE, COUNT(*) AS borrow_count
              FROM BORROWS
              INNER JOIN COPY ON BORROWS.DOCID = COPY.DOCID AND BORROWS.COPYNO = COPY.COPYNO
              INNER JOIN DOCUMENT ON COPY.DOCID = DOCUMENT.DOCID
              WHERE COPY.BID = ?
              GROUP BY DOCUMENT.DOCID, DOCUMENT.TITLE
              ORDER BY borrow_count DESC
              LIMIT ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $branch_number, $N);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if there are results
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table border='1'>
                <tr>
                    <th>Title</th>
                    <th>Number of Borrows</th>
                </tr>";
        
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["TITLE"] . "</td>";
            echo "<td>" . $row["borrow_count"] . "</td>";
            echo "</tr>";
        }
        
        // Close table
        echo "</table>";
    } else {
        echo "No borrowed books found in branch $branch_number.";
    }
    
    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, display form
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
            Number N: <input type='number' name='N'><br>
            Branch Number I: <input type='number' name='branch_number'><br>
            <input type='submit' value='Submit'>
          </form>";
}

// Close connection
$conn->close();
?>
