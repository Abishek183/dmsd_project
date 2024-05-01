<?php
// Include database connection file
include_once "db.php";
// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user type is set
    if (isset($_POST["user_type"])) {
        $user_type = $_POST["user_type"];
        
        // Perform login based on user type
        if ($user_type == "reader") {
            // Check if card number is set
            if (isset($_POST["card_number"])) {
                $card_number = $_POST["card_number"];
                
                // Query database for reader
                $query = "SELECT * FROM USERSLIB WHERE CARDNUMBER = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $card_number);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows == 1) {
                    // Redirect to readerFunctions.php
                    $row = $result->fetch_assoc();
                    $_SESSION["user_type"] = "reader";
                    $_SESSION["reader_id"] = $row['USERREADERID'];

                    header("Location: index.php");
                    exit();
                } else {
                    echo "Invalid card number.";
                }
            } else {
                echo "Card number is required.";
            }
        } elseif ($user_type == "admin") {
            // Check if admin ID and password are set
            if (isset($_POST["admin_id"]) && isset($_POST["password"])) {
                $admin_id = $_POST["admin_id"];
                $password = $_POST["password"];
                
                // Query database for admin
                $query = "SELECT * FROM USERSLIB WHERE USERID = ? AND PASSWORD = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $admin_id, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows == 1) {
                    // Redirect to adminFunctions.php
                    $_SESSION["user_type"] = "admin";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Invalid admin ID or password.";
                }
            } else {
                echo "Admin ID and password are required.";
            }
        }
    } else {
        echo "User type is required.";
    }
}
?>