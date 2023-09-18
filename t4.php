<?php
require_once('traits.php');

abstract class Service {}

class UtilityService extends Service {
    use PriceUtilities {
        PriceUtilities::calculateTax as private;
    }

    private $taxrate = 17;
    private $price;
    // use PriceUtilities, TaxTools {
    //     TaxTools::calculateTax insteadof PriceUtilities;
    //     PriceUtilities::calculateTax as basicTax;
    // }

    public function __construct(float $price) {
        $this->price = $price;
    }

    public static function printHW() {
        print "Hello world!\n";
    }

    public function getTaxRate(): float {
        return $this->taxrate;
    }

    public function getFinalPrice(): float {
        return ($this->price + $this->calculateTax($this->price));
    }
}

$u = new UtilityService(100);
print $u->getFinalPrice() . "\n";
// $u::printHW();
