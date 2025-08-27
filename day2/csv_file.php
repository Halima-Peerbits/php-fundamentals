<?php
// File path
$csvFile = "students.csv";

// 1. Write to CSV (overwrite)
$students = [
    ["Name", "Age", "Grade"],
    ["Halima", 20, "A"],
    ["Aisha", 21, "B"]
];

$fp = fopen($csvFile, "w"); // open file in write mode
foreach ($students as $row) {
    fputcsv($fp, $row);
}
fclose($fp);

// 2. Append new row
$fp = fopen($csvFile, "a"); // open in append mode
fputcsv($fp, ["Fatima", 22, "A+"]);
fclose($fp);

// 3. Read CSV
echo "<h3>CSV File Content:</h3>";
if (($fp = fopen($csvFile, "r")) !== false) {
    echo "<table border='1' cellpadding='5'>";
    while (($row = fgetcsv($fp)) !== false) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>$cell</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    fclose($fp);
}
?>
