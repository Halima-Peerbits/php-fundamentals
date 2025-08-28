<?php
require __DIR__ . '/db.php';
require __DIR__ . '/auth_bootstrap.php';

$errors = [];
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    // Basic validation
    if ($username === '') $errors[] = 'Username is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        // Check duplicates
        $st = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $st->execute([$username, $email]);
        if ($st->fetch()) {
            $errors[] = 'Username or email already exists.';
        } else {
            // Hash password
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $st = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $st->execute([$username, $email, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body>
<h2>Create Account</h2>

<?php if ($errors): ?>
  <div style="color:red;">
    <ul><?php foreach ($errors as $er) echo '<li>'.e($er).'</li>'; ?></ul>
  </div>
<?php endif; ?>

<form method="post">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  Username: <input type="text" name="username" value="<?= e($username) ?>" required><br><br>
  Email: <input type="email" name="email" value="<?= e($email) ?>" required><br><br>
  Password: <input type="password" name="password" required><br><br>
  Confirm: <input type="password" name="confirm" required><br><br>
  <button type="submit">Register</button>
</form>

<p><a href="login.php">Have an account? Login</a></p>
</body>
</html>
