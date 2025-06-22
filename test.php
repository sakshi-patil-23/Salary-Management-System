<?php
// Simple test to check if mysqli is enabled and working
$host = "localhost";
$user = "root";
$password = "";
$database = "wtl_project";// default for XAMPP is no password

// Try creating a connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} else {
    echo "✅ mysqli is working! Connection successful.";
}

$conn->close();
?>
