<?php
// error_logger.php

// 1. Define log file path
$logFile = __DIR__ . '/errors.log';

// 2. Custom error handler (for PHP warnings, notices, etc.)
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    global $logFile;
    $message = "[" . date("Y-m-d H:i:s") . "] ERROR ($errno): $errstr in $errfile on line $errline" . PHP_EOL;
    error_log($message, 3, $logFile); // 3 = write to file
    // Optional: also show error in browser for debugging
    // echo "<b>Error:</b> $errstr<br>";
    return true; // prevents PHP's default error handler
}

// 3. Custom exception handler
function customExceptionHandler(Throwable $e) {
    global $logFile;
    $message = "[" . date("Y-m-d H:i:s") . "] EXCEPTION: " . $e->getMessage() .
        " in " . $e->getFile() . " on line " . $e->getLine() . PHP_EOL;
    error_log($message, 3, $logFile);
    // echo "<b>Exception:</b> " . $e->getMessage();
}

// 4. Register handlers
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");

// 5. Example: Normal try–catch
try {
    // Simulating DB connection error
    $pdo = new PDO("mysql:host=localhost;dbname=non_existing_db", "root", "MySQL@123");
} catch (PDOException $e) {
    // Will log into file by our custom exception handler
    throw new Exception("Database connection failed: " . $e->getMessage());
}

// 6. Example: Trigger a warning
$f = fopen("non_existing_file.txt", "r"); // This warning will be logged

// 7. Example: Trigger a notice
echo $undefinedVar; // undefined variable notice will be logged

echo "✅ Script finished. Check errors.log for logged issues.";
