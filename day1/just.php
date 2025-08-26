<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Intentional errors for debugging
$username = "Halima";
// ❌ ERROR 1: Undefined variable
echo "Hello, " . $username . "<br>";

// ❌ ERROR 2: Wrong function name (typo)
print_r([1, 2, 3]);

// ❌ ERROR 3: Missing semicolon
echo "This line is missing semicolon";

// If all errors are fixed, you should see this
echo "✅ Script 1 works fine!";
?>
