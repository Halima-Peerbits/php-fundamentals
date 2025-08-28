<?php
require __DIR__ . '/auth_bootstrap.php';
csrf_check();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Destroy session safely
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time()-42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
header('Location: login.php');
exit;
