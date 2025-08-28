<?php
require __DIR__ . '/db.php';
require __DIR__ . '/auth_bootstrap.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Fetch user by username or email
    $st = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1");
    $st->execute([$username, $username]);
    $user = $st->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $errors[] = 'Invalid credentials.';
    }
}
$registered = isset($_GET['registered']);
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h2>Secure Login</h2>

<?php if ($registered): ?>
  <p style="color:green;">Registration successful. Please log in.</p>
<?php endif; ?>

<?php if ($errors): ?>
  <div style="color:red;">
    <ul><?php foreach ($errors as $er) echo '<li>'.e($er).'</li>'; ?></ul>
  </div>
<?php endif; ?>

<form method="post">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  Username or Email: <input type="text" name="username" required><br><br>
  Password: <input type="password" name="password" required><br><br>
  <button type="submit">Login</button>
</form>

<p><a href="register.php">Create an account</a></p>
</body>
</html>
