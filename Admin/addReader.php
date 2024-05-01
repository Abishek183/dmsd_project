<?php
error_reporting(E_ALL & ~E_NOTICE);
// Include database connection file
include_once "../db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input data
    $rtype = mysqli_real_escape_string($conn, $_POST['rtype']);
    $rname = mysqli_real_escape_string($conn, $_POST['rname']);
    $raddress = mysqli_real_escape_string($conn, $_POST['raddress']);
    $rphone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Query to find available copies for the document at the branch
    
    $query = "INSERT INTO READER (RTYPE, RNAME, RADDRESS, PHONE_NO) VALUES ('$rtype', '$rname', '$raddress', '$rphone')";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    if ($result == TRUE)    {
        echo "Successfully Added Reader";
    }   else    {
        echo "Error: Reader already exists";
    }

    // Close connection
    mysqli_close($conn);
}
?>