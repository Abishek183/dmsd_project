<?php
session_start();
// Include database connection file
include_once "../db.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted to return the document
    if (isset($_POST['return_document'])) {
        // Retrieve the bor_no value from the form submission
        $bor_no = mysqli_real_escape_string($conn, $_POST['bor_no']);
        $fee = mysqli_real_escape_string($conn, $_POST['overdue_fee']);
        // Access the bor_no value here and perform further actions as needed
        // For example, you can delete the borrowing and borrows record associated with this bor_no
        
        // Example code to delete borrowing and borrows record (replace with actual query)
        $delete_borrows_query = "UPDATE BORROWING SET RDTIME=NOW() WHERE BOR_NO = '$bor_no'";
        mysqli_query($conn, $delete_borrows_query);
        
        $delete_borrows_query = "UPDATE BORROWING SET BFINE=$fee WHERE BOR_NO = '$bor_no'";
        mysqli_query($conn, $delete_borrows_query);

        // Display success message
        echo "Document returned successfully!";
    }   else    {
        // Retrieve input data
        $doc_id = mysqli_real_escape_string($conn, $_POST['doc_id']);
        $cop_no = mysqli_real_escape_string($conn, $_POST['cop_no']);
        $reader_id = $_SESSION['reader_id']; // Assuming reader ID is obtained from session or user input

        // Query to check if the user is currently borrowing the specified document and it's not overdue
        $check_borrow_query = "SELECT BORROWING.BOR_NO, BORROWING.BDTIME, BORROWING.RDTIME, BORROWS.BOR_NO AS BOR_NO_BORROWS
                            FROM BORROWS
                            INNER JOIN BORROWING ON BORROWS.BOR_NO = BORROWING.BOR_NO
                            WHERE BORROWS.DOCID = '$doc_id' AND BORROWS.RID = '$reader_id' AND BORROWS.COPYNO='$cop_no' AND BORROWING.RDTIME IS NULL";
        $result = mysqli_query($conn, $check_borrow_query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $bor_no = $row['BOR_NO'];
            $rdtime = time();
            $bdtime = strtotime($row['BDTIME']);
            $days_overdue = floor(($rdtime - $bdtime) / (60 * 60 * 24));

            if ($days_overdue <= 20) {
                // Document is not overdue, delete the borrowing and borrows record
                $delete_borrows_query = "UPDATE BORROWING SET RDTIME=NOW() WHERE BOR_NO = '$bor_no'";
                mysqli_query($conn, $delete_borrows_query);
                
                $delete_borrows_query = "UPDATE BORROWING SET BFINE=0 WHERE BOR_NO = '$bor_no'";

                echo "Return successful!";
            } else {
                // Document is overdue, calculate overdue fee
                
                $overdue_fee = $days_overdue * 0.20; // 20 cents per day

                // Display overdue fee and prompt
                echo "You are overdue by $days_overdue days. Overdue fee: $" . number_format($overdue_fee, 2) . "<br>";
                echo "Do you still want to return the document?<br>";
                // Add a form with a submit button to continue returning the document with overdue fee
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="bor_no" value="' . $bor_no . '">';
                echo '<input type="hidden" name="overdue_fee" value="' . $overdue_fee . '">';
                echo '<input type="submit" name="return_document" value="Return Document">';
                echo '</form>';
            }
        } else {
            // User is not currently borrowing the specified document
            echo "You are not currently borrowing the specified document.";
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>
