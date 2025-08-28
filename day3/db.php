<?php
// db.php
$dsn  = "mysql:host=localhost;dbname=company_db;charset=utf8mb4";
$user = "root";  // change if needed
$pass = "MySQL@123";      // change if needed

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    exit("DB connection failed: " . $e->getMessage());
}
