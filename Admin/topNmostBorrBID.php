<?php
// Include database connection file
include_once "../db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $N = $_POST["n"];
    $branch_number = mysqli_real_escape_string($conn,$_POST["bid"]);
    
    // Prepare the SQL query
    $query = "SELECT d.TITLE, COUNT(b.BOR_NO) AS borrow_count
                FROM DOCUMENT d
                JOIN COPY c ON d.DOCID = c.DOCID
                JOIN BORROWS b ON c.DOCID = b.DOCID AND c.COPYNO = b.COPYNO
                WHERE c.BID = ? AND b.BID = c.BID
                GROUP BY d.TITLE
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
