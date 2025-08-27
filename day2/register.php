<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

$errors = [];
$username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty($_POST["username"])) {
        $errors[] = "Username is required!";
    } else {
        $username = htmlspecialchars(trim($_POST["username"]));
    }

    // Validate email
    if (empty($_POST["email"])) {
        $errors[] = "Email is required!";
    } else {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format!";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $errors[] = "Password is required!";
    } elseif (strlen($_POST["password"]) < 6) {
        $errors[] = "Password must be at least 6 characters long!";
    } else {
        $password = htmlspecialchars(trim($_POST["password"]));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="POST" action="">
        Username: <input type="text" name="username" value="<?php echo $username; ?>"><br><br>
        Email: <input type="text" name="email" value="<?php echo $email; ?>"><br><br>
        Password: <input type="password" name="password"><br><br>
        <input type="submit" value="Register">
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
            echo "<h3>✅ Registration Successful!</h3>";
            echo "Username: $username <br>";
            echo "Email: $email <br>";
        }
    }
    ?>
</body>
</html>
