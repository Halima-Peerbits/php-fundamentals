<?php
// Inventory: Item, Quantity, Price
$inventory = [
    ["item" => "Laptop",   "qty" => 5,  "price" => 75000],
    ["item" => "Mouse",    "qty" => 20, "price" => 500],
    ["item" => "Keyboard", "qty" => 15, "price" => 1500],
    ["item" => "Monitor",  "qty" => 7,  "price" => 12000]
];

echo "<h2>Inventory List</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Item</th><th>Quantity</th><th>Price</th><th>Total Value</th></tr>";

foreach ($inventory as $product) {
    $totalValue = $product["qty"] * $product["price"];
    echo "<tr>";
    echo "<td>{$product['item']}</td>";
    echo "<td>{$product['qty']}</td>";
    echo "<td>{$product['price']}</td>";
    echo "<td>$totalValue</td>";
    echo "</tr>";
}

echo "</table>";
?>
