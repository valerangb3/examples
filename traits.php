<?php
trait PriceUtilities {

    public function calculateTax(float $price):float {
        return (($this->getTaxRate() / 100) * $price);
    }

    abstract public function getTaxRate(): float;
}

trait IdentityTrait {
    public function generateId(): string {
        return uniqid();
    }
}

trait TaxTools {
    public function calculateTax(float $price):float {
        return 222;
    }
}