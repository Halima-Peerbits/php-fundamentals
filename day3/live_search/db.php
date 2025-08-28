<?php
// db.php - Database connection
$host = "localhost";
$user = "root";      // your DB username
$pass = "MySQL@123";          // your DB password
$db   = "testdb";    // your DB name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
