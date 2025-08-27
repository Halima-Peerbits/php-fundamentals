<?php include "db.php"; ?>

<?php
$id = $_GET["id"];

$sql = "DELETE FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: read.php");
    exit;
} else {
    echo "❌ Error deleting record: " . $stmt->error;
}
?>
