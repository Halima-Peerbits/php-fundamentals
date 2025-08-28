<?php
// db.php
$dsn  = "mysql:host=localhost;dbname=secure_auth;charset=utf8mb4";
$user = "root";      // change if needed
$pass = "MySQL@123";          // change if needed

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // real prepared statements
    ]);
} catch (PDOException $e) {
    exit("DB connection failed.");
}
