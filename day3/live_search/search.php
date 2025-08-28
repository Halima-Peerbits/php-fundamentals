<?php
require "db.php";

// Get search term from AJAX
$search = $_GET['q'] ?? '';

if ($search != '') {
    // SQL query: Search in "name" column
    $sql = "SELECT id, name, email FROM users WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%" . $search . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul style='list-style:none; padding:0;'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li style='padding:8px; border-bottom:1px solid #ddd;'>";
            echo "<b>" . htmlspecialchars($row['name']) . "</b> - " . htmlspecialchars($row['email']);
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>No results found</p>";
    }
} else {
    echo "<p>Type something to search...</p>";
}

$conn->close();
?>
