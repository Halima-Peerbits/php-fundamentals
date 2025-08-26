<?php
$servername = "localhost";
$username   = "testuser";
$password   = "password123";
$dbname     = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id    = $_POST['id'];
$name  = $_POST['name'];
$email = $_POST['email'];

$sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully!<br>";
    echo "<a href='view.php'>Back to Records</a>";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>

