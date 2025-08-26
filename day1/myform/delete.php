<?php
$servername = "localhost";
$username   = "testuser";
$password   = "password123";
$dbname     = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully!<br>";
    echo "<a href='view.php'>Back to Records</a>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>

