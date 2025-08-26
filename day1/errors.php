<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Intentional error: undefined variable
echo $undefinedVar;

// Intentional warning: include missing file
include("missing.php");

// Intentional fatal error: calling undefined function
testFunction();
?>
