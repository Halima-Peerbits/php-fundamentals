<?php
// Example of error handling with exceptions

try {
    // Force an exception
    if (!file_exists("file.txt")) {
        throw new Exception("File not found!");
    }
    echo "File exists.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
