<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

echo "<h2>Deep Dive: PHP Functions & Arrays</h2>";

/* -------------------------------
   1. User-Defined Functions
---------------------------------*/

// Simple function
function greet($name) {
    return "Hello, $name!<br>";
}

echo greet("Halima");
echo greet("Ali");

// Function with default parameter
function addNumbers($a, $b = 10) {
    return $a + $b;
}

echo "5 + default(10) = " . addNumbers(5) . "<br>";
echo "7 + 3 = " . addNumbers(7, 3) . "<br>";

/* -------------------------------
   2. Associative Arrays
---------------------------------*/

$user = [
    "name" => "Halima",
    "email" => "halima@example.com",
    "role" => "Admin"
];

echo "<h3>Associative Array Example</h3>";
foreach ($user as $key => $value) {
    echo ucfirst($key) . ": $value <br>";
}

/* -------------------------------
   3. Multidimensional Arrays
---------------------------------*/

$users = [
    ["id" => 1, "name" => "Halima", "email" => "halima@example.com"],
    ["id" => 2, "name" => "Ali", "email" => "ali@example.com"],
    ["id" => 3, "name" => "Sara", "email" => "sara@example.com"]
];

echo "<h3>Multidimensional Array Example</h3>";
foreach ($users as $user) {
    echo "ID: " . $user["id"] . " | Name: " . $user["name"] . " | Email: " . $user["email"] . "<br>";
}

/* -------------------------------
   4. Array Functions
---------------------------------*/

$numbers = [5, 2, 9, 1, 7];

echo "<h3>Array Functions</h3>";
echo "Original: ";
print_r($numbers);
echo "<br>";

// Sort ascending
sort($numbers);
echo "Sorted ascending: ";
print_r($numbers);
echo "<br>";

// Sort descending
rsort($numbers);
echo "Sorted descending: ";
print_r($numbers);
echo "<br>";

// Count elements
echo "Count: " . count($numbers) . "<br>";

// Search in array
if (in_array(9, $numbers)) {
    echo "Yes, 9 exists in array.<br>";
}

// Get keys
$keys = array_keys($user);
echo "Keys of user array: ";
print_r($keys);
echo "<br>";
?>

