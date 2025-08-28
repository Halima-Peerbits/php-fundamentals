<?php
require __DIR__ . '/db.php';
require __DIR__ . '/auth_bootstrap.php';
require_login();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Dashboard</title></head>
<body>
<h2>Welcome, <?= e($_SESSION['username']) ?> 🎉</h2>

<form method="post" action="logout.php" style="display:inline;">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <button type="submit">Logout</button>
</form>
</body>
</html>
