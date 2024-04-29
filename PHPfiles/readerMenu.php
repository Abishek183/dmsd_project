<?php
session_start();
include 'db.php'; // This file should establish a PDO connection to your database

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['readerId'])) {
        $readerId = $_POST['readerId'];
        $stmt = $pdo->prepare("SELECT * FROM READER WHERE RID = ?");
        $stmt->execute([$readerId]);
        $reader = $stmt->fetch();
    
        if ($reader) {
            // Reader found, store in session and show menu
            $_SESSION['readerId'] = $readerId;
            showReaderMenu();
        } else {
            header('Location: index.php');
            exit;
        }
    } else {
        showReaderMenu();
        exit;
    }
}

function showReaderMenu() {
    echo '<h1>Reader Functions Menu</h1>
          <form action="readerFunctions.php" method="post">
            <select name="action" id="actionSelect" onchange="this.form.submit()">
                <option value="">Select an action...</option>
                <option value="search_document">Search Document</option>
                <option value="checkout_document">Checkout Document</option>
                <option value="return_document">Return Document</option>
                <option value="reserve_document">Reserve Document</option>
                <option value="compute_fine">Compute Fine</option>
                <option value="print_reserved">Print Reserved Documents</option>
                <option value="print_by_publisher">Print Documents by Publisher</option>
            </select>
            <input type="button" value="Quit" onclick="quitSession()" />
          </form>
          <script>
              function quitSession() {
                  window.location.href = \'readerFunctions.php?action=quit\';
              }
          </script>';
}

// Display menu
showReaderMenu();

// Handle post actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    handleReaderAction($_POST['action']);
} else if (isset($_GET['action']) && $_GET['action'] === 'quit') {
    handleReaderAction('quit');
}

function handleReaderAction($action) {
    switch ($action) {
        case 'search_document':
            showSearchForm();
            break;
        case 'checkout_document':
            showCheckoutForm();
            break;
        case 'return_document':
            showReturnForm();
            break;
        case 'reserve_document':
            showReserveForm();
            break;
        case 'compute_fine':
            showComputeFineForm();
            break;
        case 'print_reserved':
            showReservedDocuments();
            break;
        case 'print_by_publisher':
            showPrintByPublisherForm();
            break;
        case 'quit':
            session_destroy();
            header('Location: index.php');
            exit;
    }
}

// HTML Form and placeholder method for each action
function showSearchForm() {
    echo '<h2>Search for a Document</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="search_document">
              Document ID, Title, or Publisher Name: <input type="text" name="search_term" required>
              <input type="submit" value="Search">
          </form>';
    if (!empty($_POST['search_term'])) {
        echo "Searching for: " . htmlspecialchars($_POST['search_term']);
    }
}

function showCheckoutForm() {
    echo '<h2>Checkout a Document</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="checkout_document">
              Document ID: <input type="text" name="docid" required>
              <input type="submit" value="Checkout">
          </form>';
    if (!empty($_POST['docid'])) {
        echo "Checking out document ID: " . htmlspecialchars($_POST['docid']);
    }
}

function showReturnForm() {
    echo '<h2>Return a Document</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="return_document">
              Document ID: <input type="text" name="docid" required>
              <input type="submit" value="Return">
          </form>';
    if (!empty($_POST['docid'])) {
        echo "Returning document ID: " . htmlspecialchars($_POST['docid']);
    }
}

function showReserveForm() {
    echo '<h2>Reserve a Document</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="reserve_document">
              Document ID: <input type="text" name="docid" required>
              <input type="submit" value="Reserve">
          </form>';
    if (!empty($_POST['docid'])) {
        echo "Reserving document ID: " . htmlspecialchars($_POST['docid']);
    }
}

function showComputeFineForm() {
    echo '<h2>Compute Fine for a Document</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="compute_fine">
              Document ID: <input type="text" name="docid" required>
              <input type="submit" value="Compute Fine">
          </form>';
    if (!empty($_POST['docid'])) {
        echo "Computing fine for document ID: " . htmlspecialchars($_POST['docid']);
    }
}

function showReservedDocuments() {
    echo '<h2>List of Reserved Documents</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="print_reserved">
              <input type="submit" value="Show Reserved Documents">
          </form>';
    // Placeholder for reserved documents listing
    echo "Displaying reserved documents...";
}

function showPrintByPublisherForm() {
    echo '<h2>Documents Published by a Publisher</h2>
          <form action="readerFunctions.php" method="post">
              <input type="hidden" name="action" value="print_by_publisher">
              Publisher Name: <input type="text" name="publisher" required>
              <input type="submit" value="Show Documents">
          </form>';
    if (!empty($_POST['publisher'])) {
        echo "Listing documents for publisher: " . htmlspecialchars($_POST['publisher']);
    }
}
?>
