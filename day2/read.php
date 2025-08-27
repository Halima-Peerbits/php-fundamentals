<?php include "db.php"; ?>

<h2>📋 Student List</h2>
<p><a href="create.php">➕ Add Student</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
    while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= $row["id"]; ?></td>
            <td><?= htmlspecialchars($row["name"]); ?></td>
            <td><?= htmlspecialchars($row["email"]); ?></td>
            <td><?= htmlspecialchars($row["course"]); ?></td>
            <td>
                <a href="update.php?id=<?= $row["id"]; ?>">✏️ Edit</a> | 
                <a href="delete.php?id=<?= $row["id"]; ?>" onclick="return confirm('Delete this student?');">🗑️ Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
