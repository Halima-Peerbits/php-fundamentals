<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

$errors = [];
$username = $password = "";

// Fake credentials (just for testing)
$validUser = "halima";
$validPass = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check username
    if (empty($_POST["username"])) {
        $errors[] = "Username is required!";
    } else {
        $username = htmlspecialchars(trim($_POST["username"]));
    }

    // Check password
    if (empty($_POST["password"])) {
        $errors[] = "Password is required!";
    } else {
        $password = htmlspecialchars(trim($_POST["password"]));
    }

    // Validate credentials
    if (empty($errors)) {
        if ($username === $validUser && $password === $validPass) {
            $success = "✅ Login successful! Welcome, $username.";
        } else {
            $errors[] = "Invalid username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
</head>
<body>
    <h2>Login Form</h2>
    <form method="POST" action="">
        Username: <input type="text" name="username" value="<?php echo $username; ?>"><br><br>
        Password: <input type="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>

    <hr>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($errors)) {
            echo "<p style='color:red;'>Errors:</p><ul>";
            foreach ($errors as $err) {
                echo "<li>$err</li>";
            }
            echo "</ul>";
        } else {
            echo "<h3 style='color:green;'>$success</h3>";
        }
    }
    ?>
</body>
</html>
