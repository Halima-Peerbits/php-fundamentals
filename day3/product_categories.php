<?php
// ==========================
// Namespace declaration
// ==========================
namespace Shop;

// ==========================
// Interface for Discountable
// ==========================
interface Discountable {
    public function applyDiscount(float $percent): void;
}

// ==========================
// Trait for Logging
// ==========================
trait Logger {
    public function log(string $message): void {
        echo "[LOG] " . date("Y-m-d H:i:s") . " - $message<br>";
    }
}

// ==========================
// Base Product Class
// ==========================
class Product implements Discountable {
    use Logger; // add logging ability

    protected string $name;
    protected float $price;

    public function __construct(string $name, float $price) {
        $this->name  = $name;
        $this->price = $price;
    }

    // Implement interface method
    public function applyDiscount(float $percent): void {
        $discount = $this->price * ($percent / 100);
        $this->price -= $discount;
        $this->log("Applied {$percent}% discount on {$this->name}");
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getName(): string {
        return $this->name;
    }

    public function showDetails(): void {
        echo "Product: {$this->name}, Price: {$this->price}<br>";
    }
}

// ==========================
// Derived Classes (Inheritance)
// ==========================
class Electronics extends Product {
    private int $warrantyYears;

    public function __construct(string $name, float $price, int $warrantyYears) {
        parent::__construct($name, $price);
        $this->warrantyYears = $warrantyYears;
    }

    public function showDetails(): void {
        parent::showDetails();
        echo "Warranty: {$this->warrantyYears} years<br>";
    }
}

class Clothing extends Product {
    private string $size;

    public function __construct(string $name, float $price, string $size) {
        parent::__construct($name, $price);
        $this->size = $size;
    }

    public function showDetails(): void {
        parent::showDetails();
        echo "Size: {$this->size}<br>";
    }
}

// ==========================
// Example Usage
// ==========================

// Import namespace (if this file is included in another)
use Shop\Electronics;
use Shop\Clothing;

$phone = new Electronics("Smartphone", 50000, 2);
$shirt = new Clothing("T-Shirt", 1500, "M");

$phone->showDetails();
$phone->applyDiscount(10);
echo "After discount: " . $phone->getPrice() . "<br><br>";

$shirt->showDetails();
$shirt->applyDiscount(20);
echo "After discount: " . $shirt->getPrice() . "<br>";
