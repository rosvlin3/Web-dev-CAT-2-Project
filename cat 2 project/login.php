<?php
// Start session
session_start();

// Check if user is already logged in, redirect to account page if so
if (isset($_SESSION['username'])) {
header("Location: page1.html");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to MySQL database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "your_database_name";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user with provided username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows == 1) {
        // Fetch user data
        $row = $result->fetch_assoc();
        // Verify password
        if ($row['password'] == $password) {
            // Set session variables and redirect to page1
            $_SESSION['username'] = $username;
            header("Location: page1.html");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid username";
    }

    $conn->close();
}
?>
