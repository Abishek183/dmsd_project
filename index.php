<?php
// Start session
session_start();

// Check if user is logged in
if(isset($_SESSION["user_type"])) {
    // Display appropriate links based on user type
    if($_SESSION["user_type"] == "reader") {
        // Display links for reader
        echo "<h1>Reader Functions</h1><br>";
        echo "<a href='/Reader/search_form.html'>Search for a Document</a><br>";
        echo "<a href='/Reader/checkout.html'>Checkout Documents</a><br>";
        echo "<a href='/Reader/return.html'>Return Documents</a><br>";
        echo "<a href='/Reader/reserve.html'>Reserve Documents</a><br>";
        echo "<a href='/Reader/listReserved.html'>Print Reserved Documents</a><br>";
        echo "<a href='/Reader/print_publishers.html'>Print Publisher Documents</a><br>";
    } elseif($_SESSION["user_type"] == "admin") {
        // Display links for admin
        echo "<h1>Admin Functions</h1><br>";
        echo "<a href='adminAddDoc.html'>Add a Document Copy</a>";
        echo "<a href='adminSearchDoc.html'>Seach Document Copy and Check Status</a>";
        echo "<a href='adminAddReader.html'>Add New Reader</a>";
        echo "<a href='adminPrintBranch.html'>Print Branch Information</a>";
        echo "<a href='admintopNforBID.html'>Print Top N Most Frequent Borrowers In Branch I</a>";
        echo "<a href='admintopN.html'>Print Top N Most Frequent Borrowers In Library</a>";
        echo "<a href='adminNmostborrowedforBID.html'>Top N Most Borrowed Books In Branch I</a>";
        echo "<a href='adminNmostborrowed.html'>Top N Most Borrowed Books In Library</a>";
        echo "<a href='admintop10foryear.html'>Top 10 Most Popular Books In A Year</a>";
        echo "<a href='adminFineAVGforSandE.html'>Get Average Fine Paid By Borrowers</a>";
    }
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>