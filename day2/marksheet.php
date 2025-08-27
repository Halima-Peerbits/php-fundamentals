<?php
// Student data: name + marks in subjects
$students = [
    [
        "name" => "Halima",
        "marks" => [
            "Math" => 85,
            "Science" => 90,
            "English" => 78
        ]
    ],
    [
        "name" => "Aisha",
        "marks" => [
            "Math" => 92,
            "Science" => 88,
            "English" => 81
        ]
    ],
    [
        "name" => "Fatima",
        "marks" => [
            "Math" => 75,
            "Science" => 70,
            "English" => 68
        ]
    ]
];

echo "<h2>Student Marksheet</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Name</th><th>Math</th><th>Science</th><th>English</th><th>Total</th><th>Average</th></tr>";

foreach ($students as $student) {
    $total = array_sum($student["marks"]);  // sum of marks
    $avg   = $total / count($student["marks"]); // average

    echo "<tr>";
    echo "<td>{$student['name']}</td>";
    foreach ($student["marks"] as $subject => $mark) {
        echo "<td>$mark</td>";
    }
    echo "<td>$total</td><td>" . round($avg, 2) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
