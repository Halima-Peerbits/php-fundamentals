<?php
// File path
$jsonFile = "users.json";

// 1. Write JSON data
$users = [
    ["name" => "Halima", "email" => "halima@example.com"],
    ["name" => "Aisha", "email" => "aisha@example.com"]
];
file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT));

// 2. Append new user
$data = json_decode(file_get_contents($jsonFile), true); // convert JSON to array
$data[] = ["name" => "Fatima", "email" => "fatima@example.com"];
file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

// 3. Read JSON
$jsonData = json_decode(file_get_contents($jsonFile), true);
echo "<h3>JSON File Content:</h3>";
foreach ($jsonData as $user) {
    echo "Name: {$user['name']} - Email: {$user['email']}<br>";
}
?>
