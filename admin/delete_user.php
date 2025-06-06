<?php
// admin.php
session_start();

// Database connection
$host = 'localhost'; // Your database host
$username = 'root'; // Your database username
$password = ''; // Your database password
$database = 'shoe_shop'; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    // Redirect to login page if not logged in or not an admin
    header("Location: /Shoe%20Shop/login.php");
    exit();
}

$user_id = $_GET['id'];

$sql = "DELETE FROM Users WHERE user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    header('Location: admin.php');
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
