<?php
// Include database connection file
include_once "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input value
    $year = $_POST["year"];
    
    // Prepare the SQL query
    $query = "SELECT DOCUMENT.TITLE, COUNT(*) AS borrow_count
                FROM BORROWING
                INNER JOIN BORROWS ON BORROWING.BOR_NO = BORROWS.BOR_NO
                INNER JOIN COPY ON BORROWS.DOCID = COPY.DOCID AND BORROWS.COPYNO = COPY.COPYNO
                INNER JOIN DOCUMENT ON COPY.DOCID = DOCUMENT.DOCID
                WHERE YEAR(BORROWING.BDTIME) = ?
                GROUP BY DOCUMENT.DOCID, DOCUMENT.TITLE
                ORDER BY borrow_count DESC
                LIMIT 10";
     
    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
    
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
        echo "No popular books found for the year $year.";
    }
    
    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, display form
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
            Year: <input type='number' name='year'><br>
            <input type='submit' value='Submit'>
          </form>";
}

// Close connection
$conn->close();
?>
