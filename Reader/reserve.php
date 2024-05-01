<?php
session_start();
// Include database connection file
include_once "retrivecountavailable.php";
include_once "../db.php";

// Check if form is submitted
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input data
    $doc_id = mysqli_real_escape_string($conn, $_POST['doc_id']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
    $copies_to_checkout = intval($_POST['copies_to_checkout']);
    $reader_id = 1; // Assuming reader ID is obtained from session or user input

    // Check if copies to checkout is greater than 0
    if ($copies_to_checkout > 0) {
        // Query to find available copies for the document at the branch
        
        $available_copies_query = "SELECT DISTINCT COPY.COPYNO
        FROM COPY
        LEFT JOIN RESERVES ON COPY.DOCID = RESERVES.DOCID AND COPY.COPYNO = RESERVES.COPYNO AND COPY.BID = RESERVES.BID
        LEFT JOIN BORROWS ON COPY.DOCID = BORROWS.DOCID AND COPY.COPYNO = BORROWS.COPYNO AND COPY.BID = BORROWS.BID
        LEFT JOIN BORROWING ON BORROWS.BOR_NO = BORROWING.BOR_NO
        WHERE RESERVES.DOCID IS NULL
          AND (BORROWS.DOCID IS NULL OR BORROWING.RDTIME IS NOT NULL)
          AND COPY.DOCID = $doc_id
          AND COPY.BID = $branch_id";

        // Execute the query
        $available_copies_result = mysqli_query($conn, $available_copies_query);

        // Check if there are enough available copies
        if (mysqli_num_rows($available_copies_result) >= $copies_to_checkout) {
            // Start transaction
            mysqli_begin_transaction($conn);

            // Insert a record into BORROWING table
            $bdtime = date("Y-m-d H:i:s"); // Current time
            $insert_borrowing_query = "INSERT INTO RESERVATION (DTIME) VALUES ('$bdtime')";
            mysqli_query($conn, $insert_borrowing_query);

            // Get the BOR_NO of the inserted borrowing record
            $bor_no = mysqli_insert_id($conn);

            // Insert records into BORROWS table for each copy to checkout
            $i = 0;
            while ( $i < $copies_to_checkout) {
                $row = mysqli_fetch_assoc($available_copies_result);
                
                // Extract COPYNO
                $copy_no = $row['COPYNO'];
                
                // Insert record into BORROWS table
                $insert_borrows_query = "INSERT INTO RESERVES (RID, RESERVATION_NO, DOCID, COPYNO, BID) VALUES ('$reader_id', '$bor_no', '$doc_id', '$copy_no', '$branch_id')";
                mysqli_query($conn, $insert_borrows_query);
                $i++;
            }

            // Commit transaction
            mysqli_commit($conn);

            // Success message
            echo "Reservation successful!";
        } else {
            // Not enough available copies message
            echo "Not enough available copies to reservation.";
        }
    } else {
        // Invalid number of copies message
        echo "Invalid number of copies to reservation.";
    }

    // Close connection
    mysqli_close($conn);
//}
?>