<?php
session_start();

// Simple authentication for demonstration purposes
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['loggedin'] = true;
            header('Location: adminMenu.php');  // Redirect to avoid form resubmission issues
            exit;
        } else {
            echo "<p>Invalid username or password</p>";
            showLoginForm();
            exit;
        }
    } else {
        showLoginForm();
        exit;
    }
}

function showLoginForm() {
    echo '<form action="adminMenu.php" method="post">
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit" value="Login">
          </form>';
}

// Log out mechanism
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php"); // redirect to the login page
}

function showAdminMenu() {
    echo '<h1>Administrative Functions Menu</h1>
          <form action="adminMenu.php" method="post">
            <select name="action" id="actionSelect">
                <option value="">Select an action...</option>
                <option value="add_document">Add a Document Copy</option>
                <option value="search_document">Search Document Copy</option>
                <option value="add_reader">Add New Reader</option>
                <option value="print_branch">Print Branch Information</option>
            </select>
            <button type="button" onclick="submitForm()">Submit</button>
          </form>
          <script>
              function submitForm() {
                  var action = document.getElementById(\'actionSelect\').value;
                  if (action) {
                      document.querySelector(\'form\').submit();
                  } else {
                      alert(\'Please select an action.\');
                  }
              }
          </script>
          <form action="adminMenu.php" method="post">
            <input type="hidden" name="logout" value="1">
            <input type="submit" value="Logout">
          </form>';
}


// Display the menu after login
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    showAdminMenu();
}

// Handle form actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    handleAdminAction($_POST['action']);
}

function handleAdminAction($action) {
    switch ($action) {
        case 'add_document':
            if (!empty($_POST['docid'])) {  // Validate that docid is not empty
                processAddDocument();
            } else {
                showAddDocumentForm();
            }
            break;
        case 'search_document':
            if (!empty($_POST['docid'])) {
                processSearchDocument();
            } else {
                showSearchDocumentForm();
            }
            break;
        case 'add_reader':
            if (!empty($_POST['rid'])) {
                processAddReader();
            } else {
                showAddReaderForm();
            }
            break;
        case 'print_branch':
            processPrintBranch();
            break;
    }
}

function processAddDocument() {
    // Add logic to process adding a document copy
    echo "Processing add document...";
    // Add your database interaction code here
    // Redirect after processing to avoid resubmission
    header('Location: adminMenu.php');
    exit;
}

function processSearchDocument() {
    // Add logic to process searching a document copy
    echo "Processing search document...";
    // Redirect after processing
    header('Location: adminMenu.php');
    exit;
}

function processAddReader() {
    // Add logic to process adding a new reader
    echo "Processing add reader...";
    // Redirect after processing
    //header('Location: adminMenu.php');
    exit;
}

function processPrintBranch() {
    // Add logic to print branch information
    echo "Processing print branch information...";
    // Redirect after processing
    header('Location: adminMenu.php');
    exit;
}

function showAddDocumentForm() {
    echo '<h2>Add a Document Copy</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="add_document">
              Document ID: <input type="text" name="docid" required><br>
              Copy Number: <input type="text" name="copyno" required><br>
              Branch ID: <input type="text" name="bid" required><br>
              Position: <input type="text" name="position" required><br>
              <input type="submit" value="Add Copy">
          </form>';
}

function showSearchDocumentForm() {
    echo '<h2>Search Document Copy and Check Its Status</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="search_document">
              Document ID: <input type="text" name="docid" required><br>
              <input type="submit" value="Search">
          </form>';
}

function showAddReaderForm() {
    echo '<h2>Add New Reader</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="add_reader">
              Reader ID: <input type="text" name="rid" required><br>
              Reader Type: <input type="text" name="rtype" required><br>
              Name: <input type="text" name="rname" required><br>
              Address: <input type="text" name="raddress" required><br>
              Phone No: <input type="text" name="phone_no" required><br>
              <input type="submit" value="Add Reader">
          </form>';
}

function showPrintBranchForm() {
    echo '<h2>Print Branch Information</h2>
          <form action="adminMenu.php" method="post">
              <input type="hidden" name="action" value="print_branch">
              <input type="submit" value="Print Branch Info">
          </form>';
}
?>
