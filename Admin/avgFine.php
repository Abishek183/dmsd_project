<?php
// Include database connection file
include_once "../db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    
    // Prepare the SQL query
    $query = "SELECT BRANCH.BID, BRANCH.LNAME, AVG(BORROWING_FINE) AS avg_fine
              FROM BRANCH
              LEFT JOIN BORROWING ON BRANCH.BID = BORROWING.BID
              WHERE BORROWING.BDTIME BETWEEN ? AND ?
              GROUP BY BRANCH.BID, BRANCH.LNAME";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $start_date, $end_date);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if there are results
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table border='1'>
                <tr>
                    <th>Branch ID</th>
                    <th>Branch Name</th>
                    <th>Average Fine Paid</th>
                </tr>";
        
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["BID"] . "</td>";
            echo "<td>" . $row["LNAME"] . "</td>";
            echo "<td>$" . number_format($row["avg_fine"], 2) . "</td>";
            echo "</tr>";
        }
        
        // Close table
        echo "</table>";
    } else {
        echo "No data found for the specified period.";
    }
    
    // Close statement
    $stmt->close();
} else {
    // If form is not submitted, display form
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
            Start Date: <input type='date' name='start_date'><br>
            End Date: <input type='date' name='end_date'><br>
            <input type='submit' value='Submit'>
          </form>";
}

// Close connection
$conn->close();
?>
