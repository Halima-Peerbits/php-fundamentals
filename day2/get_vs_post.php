<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Initialize variables
$name = $email = $methodUsed = "";
$errors = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    $methodUsed = $_SERVER["REQUEST_METHOD"];

    // Choose input source (POST or GET)
    $input = ($methodUsed == "POST") ? $_POST : $_GET;

    // Validate and sanitize name
    if (empty($input["name"])) {
        $errors[] = "Name is required!";
    } else {
        $name = htmlspecialchars(trim($input["name"])); // sanitization
    }

    // Validate and sanitize email
    if (empty($input["email"])) {
        $errors[] = "Email is required!";
    } else {
        $email = filter_var(trim($input["email"]), FILTER_SANITIZE_EMAIL); // sanitization
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GET vs POST Example</title>
</head>
<body>
    <h2>PHP Form (GET vs POST)</h2>

    <!-- Form with GET -->
    <form method="GET" action="">
        <h3>Form with GET</h3>
        Name: <input type="text" name="name"><br><br>
        Email: <input type="text" name="email"><br><br>
        <input type="submit" value="Submit with GET">
    </form>

    <hr>

    <!-- Form with POST -->
    <form method="POST" action="">
        <h3>Form with POST</h3>
        Name: <input type="text" name="name"><br><br>
        Email: <input type="text" name="email"><br><br>
        <input type="submit" value="Submit with POST">
    </form>

    <hr>

    <!-- Show results -->
    <?php
    if ($methodUsed) {
        echo "<h3>Form submitted using: $methodUsed</h3>";

        if (!empty($errors)) {
            echo "<p style='color:red;'>Errors:</p><ul>";
            foreach ($errors as $err) {
                echo "<li>$err</li>";
            }
            echo "</ul>";
        } else {
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
        }
    }
    ?>
</body>
</html>
