<?php
// Include database connection file
include_once "../db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input value
    $N = $_POST["N"];
    
    // Prepare the SQL query
    $query = "SELECT DOCUMENT.TITLE, COUNT(*) AS borrow_count
              FROM BORROWS
              INNER JOIN COPY ON BORROWS.DOCID = COPY.DOCID AND BORROWS.COPYNO = COPY.COPYNO
              INNER JOIN DOCUMENT ON COPY.DOCID = DOCUMENT.DOCID
              GROUP BY DOCUMENT.DOCID, DOCUMENT.TITLE
              ORDER BY borrow_count DESC
              LIMIT ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $N);
    
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
        echo "No borrowed books found in the library.";
    }
    
    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, display form
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
            Number N: <input type='number' name='N'><br>
            <input type='submit' value='Submit'>
          </form>";
}

// Close connection
$conn->close();
?>
