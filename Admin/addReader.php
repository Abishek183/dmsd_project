<?php
error_reporting(E_ALL & ~E_NOTICE);
// Include database connection file
include_once "../db.php";

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($characters);
    $randomString = '';

    // Generate random characters
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }

    return $randomString;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input data
    $rtype = mysqli_real_escape_string($conn, $_POST['rtype']);
    $rname = mysqli_real_escape_string($conn, $_POST['rname']);
    $raddress = mysqli_real_escape_string($conn, $_POST['raddress']);
    $rphone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Query to find available copies for the document at the branch
    
    // Insert into READER table
    $query = "INSERT INTO READER (RTYPE, RNAME, RADDRESS, PHONE_NO) VALUES ('$rtype', '$rname', '$raddress', '$rphone')";
    $result = mysqli_query($conn, $query);

    $cardNumber = generateRandomString(10);

    if ($result) {
        // Retrieve the auto-generated UserID
        $userID = mysqli_insert_id($conn);
        echo "Successfully Added Reader. UserID: " . $userID;
        
        // Insert into USERSLIB table using the retrieved UserID
        $query = "INSERT INTO USERSLIB (USERREADERID, USERTYPE, CARDNUMBER, PASSWORD) VALUES ('$userID', 'reader', '$cardNumber', NULL)";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            //echo "Successfully Added Reader to USERSLIB";
        } else {
            //echo "Error: " . mysqli_error($conn);
        }
    } else {
        //echo "Error: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
