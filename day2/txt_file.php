<?php
// File path
$file = "data.txt";

// 1. Write to file (overwrite if exists)
file_put_contents($file, "Hello, this is a text file.\n");

// 2. Append to file (add new text without overwriting)
file_put_contents($file, "Appending a new line!\n", FILE_APPEND);

// 3. Read file content
$content = file_get_contents($file);
echo "<h3>TXT File Content:</h3>";
echo nl2br($content); // nl2br = convert new lines to <br>
?>
