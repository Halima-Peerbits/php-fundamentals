<?php
$servername = "localhost";
$username   = "testuser";
$password   = "password123";
$dbname     = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql    = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>User Records</h2>
          <table border='1'>
          <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>
                    <a href='edit.php?id=" . $row["id"] . "'>Edit</a> |
                    <a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>

