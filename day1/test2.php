<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Intentional DB errors for debugging
$servername = "localhost";
$username   = "testuser";   // ❌ incorrect username
$password   = "password123";   // ❌ incorrect password
$dbname     = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// ❌ This will cause "Access denied" error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";   // ❌ typo: should be SELECT
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['name'] . " - " . $row['email'] . "<br>";
    }
} else {
    echo "❌ Query error: " . $conn->error;
}

$conn->close();
?>
