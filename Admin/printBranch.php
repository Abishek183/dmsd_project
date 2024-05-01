<?php
// Include database connection file
include_once "../db.php";
// Start session
session_start();

// Prepare the SQL query
$query = "SELECT LNAME, LOCATION FROM BRANCH";

// Execute the query
$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    // Output table header
    echo "<table border='1'>
            <tr>
                <th>Branch Name</th>
                <th>Location</th>
            </tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["LNAME"] . "</td>";
        echo "<td>" . $row["LOCATION"] . "</td>";
        echo "</tr>";
    }
    
    // Close table
    echo "</table>";
} else {
    echo "No branches found.";
}

// Close connection
$conn->close();
?>
