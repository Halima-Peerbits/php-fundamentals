<?php
echo "<h2>PHP Array Functions Demo</h2>";

/* ----------------------------
   1. array_merge() – Combine arrays
-----------------------------*/
$arr1 = ["Apple", "Banana"];
$arr2 = ["Mango", "Orange"];
$merged = array_merge($arr1, $arr2);
echo "<h3>array_merge()</h3>";
print_r($merged);
echo "<br><br>";

/* ----------------------------
   2. array_push() – Add values
-----------------------------*/
$fruits = ["Apple", "Banana"];
array_push($fruits, "Grapes", "Pineapple");
echo "<h3>array_push()</h3>";
print_r($fruits);
echo "<br><br>";

/* ----------------------------
   3. array_pop() – Remove last value
-----------------------------*/
array_pop($fruits);
echo "<h3>array_pop()</h3>";
print_r($fruits);
echo "<br><br>";

/* ----------------------------
   4. array_keys() – Get all keys
   5. array_values() – Get all values
-----------------------------*/
$user = ["name" => "Halima", "email" => "halima@example.com", "role" => "Admin"];
echo "<h3>array_keys() & array_values()</h3>";
print_r(array_keys($user));
echo "<br>";
print_r(array_values($user));
echo "<br><br>";

/* ----------------------------
   6. array_sum() – Add numbers
-----------------------------*/
$marks = [85, 90, 78, 92];
echo "<h3>array_sum()</h3>";
echo "Total Marks: " . array_sum($marks);
echo "<br><br>";

/* ----------------------------
   7. sort() & rsort() – Sorting
-----------------------------*/
$numbers = [5, 2, 9, 1, 7];
sort($numbers);  // Ascending
echo "<h3>sort()</h3>";
print_r($numbers);
echo "<br>";

rsort($numbers); // Descending
echo "<h3>rsort()</h3>";
print_r($numbers);
echo "<br><br>";

/* ----------------------------
   8. in_array() – Check if value exists
-----------------------------*/
$colors = ["red", "green", "blue"];
echo "<h3>in_array()</h3>";
echo in_array("green", $colors) ? "Yes, green exists" : "No, green not found";
echo "<br><br>";

/* ----------------------------
   9. array_unique() – Remove duplicates
-----------------------------*/
$nums = [1, 2, 2, 3, 4, 4, 5];
$uniqueNums = array_unique($nums);
echo "<h3>array_unique()</h3>";
print_r($uniqueNums);
echo "<br><br>";

/* ----------------------------
   10. array_map() – Apply function to all values
-----------------------------*/
function square($n) {
    return $n * $n;
}
$numbers = [1, 2, 3, 4, 5];
$squares = array_map("square", $numbers);
echo "<h3>array_map()</h3>";
print_r($squares);
echo "<br><br>";

?>
