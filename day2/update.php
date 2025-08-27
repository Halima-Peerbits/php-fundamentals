<?php include "db.php"; ?>

<?php
$id = $_GET["id"];
$result = $conn->query("SELECT * FROM students WHERE id=$id");
$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $course = $_POST["course"];

    $sql = "UPDATE students SET name=?, email=?, course=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $course, $id);

    if ($stmt->execute()) {
        header("Location: read.php");
        exit;
    } else {
        echo "❌ Error updating record: " . $stmt->error;
    }
}
?>

<h2>Edit Student</h2>
<form method="POST">
    Name: <input type="text" name="name" value="<?= $student["name"]; ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $student["email"]; ?>" required><br><br>
    Course: <input type="text" name="course" value="<?= $student["course"]; ?>" required><br><br>
    <input type="submit" value="Update Student">
</form>
