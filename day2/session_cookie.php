<?php
// ------------------ START SESSION ------------------
session_start();

// Dummy credentials (replace with database later)
$validUser = "halima";
$validPass = "123456";

// ------------------ LOGIN HANDLER ------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]);

    if ($username === $validUser && $password === $validPass) {
        // ✅ Save login in session
        $_SESSION["user"] = $username;

        // ✅ If "Remember Me" is checked → Save in cookie (7 days)
        if ($remember) {
            setcookie("user", $username, time() + (7 * 24 * 60 * 60), "/");
        }

        // Redirect to dashboard
        header("Location: session_cookie.php");
        exit;
    } else {
        $error = "❌ Invalid username or password!";
    }
}

// ------------------ LOGOUT HANDLER ------------------
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();
    setcookie("user", "", time() - 3600, "/"); // delete cookie
    header("Location: session_cookie.php");
    exit;
}

// ------------------ RESTORE SESSION FROM COOKIE ------------------
if (!isset($_SESSION["user"]) && isset($_COOKIE["user"])) {
    $_SESSION["user"] = $_COOKIE["user"];
}

// ------------------ PREFERENCES: THEME ------------------
if (isset($_POST["theme"])) {
    setcookie("theme", $_POST["theme"], time() + (30 * 24 * 60 * 60), "/"); // store for 30 days
    $_COOKIE["theme"] = $_POST["theme"]; // update immediately
}
$theme = $_COOKIE["theme"] ?? "light"; // default = light theme
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login System with Session, Cookies & Preferences</title>
</head>
<body style="background-color: <?= $theme == 'dark' ? '#222' : '#fff'; ?>; color: <?= $theme == 'dark' ? '#fff' : '#000'; ?>; font-family: Arial;">

<?php if (!isset($_SESSION["user"])): ?>
    <!-- ------------------ LOGIN FORM ------------------ -->
    <h2>🔑 User Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <label><input type="checkbox" name="remember"> Remember Me</label><br><br>
        <input type="submit" name="login" value="Login">
    </form>

<?php else: ?>
    <!-- ------------------ DASHBOARD ------------------ -->
    <h2>🎉 Welcome, <?= htmlspecialchars($_SESSION["user"]); ?></h2>
    <p>You are logged in using 
        <b><?= isset($_COOKIE["user"]) ? "COOKIE (Remember Me)" : "SESSION"; ?></b>.
    </p>

    <!-- Theme Preferences -->
    <form method="POST">
        <label>Choose Theme:</label>
        <select name="theme" onchange="this.form.submit()">
            <option value="light" <?= $theme == "light" ? "selected" : ""; ?>>Light</option>
            <option value="dark" <?= $theme == "dark" ? "selected" : ""; ?>>Dark</option>
        </select>
    </form>

    <p>Current Theme: <b><?= ucfirst($theme); ?></b></p>

    <a href="?logout=1">🚪 Logout</a>
<?php endif; ?>

</body>
</html>

