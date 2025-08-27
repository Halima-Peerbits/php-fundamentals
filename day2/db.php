<?php
// db.php - Database Connection
$host = "localhost";
$user = "root";      // your MySQL username
$pass = "MySQL@123";          // your MySQL password
$dbname = "student_db";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
