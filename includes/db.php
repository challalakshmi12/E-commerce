<?php
// Database connection settings
$servername = "localhost";
$username = "root";         // Default username in XAMPP
$password = "";             // Default password is empty in XAMPP
$dbname = "ecommerce_website";  // Your new database name with no spaces

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Optional: remove echo in production
// echo "✅ Connected successfully to '$dbname'!";
?>
