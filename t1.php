<?php
class CdProduct extends ShopProduct {
    public $playLength;

    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float $price,
        int $playLength
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->playLength = $playLength;
    }

    public function getPlayLength() {
        return $this->playLength;
    }

    public function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": Время звучания - {$this->playLength}";
        return $base;
    }
}

class BookProduct extends ShopProduct {
    public $numPages;

    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float $price,
        int $numPages
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->numPages = $numPages;
    }

    public function getNumPages() {
        return $this->numPages;
    }

    public function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": {$this->numPages} стр.";
        return $base;
    }

    public function getPrice() {
        return $this->price;
    }
}

class ShopProduct {
    public $title;
    public $producerMainName;
    public $producerFirstName;
    protected $price;
    public $discount = 0;

    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float $price,
    ) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    public function getProducer() {
        return $this->producerFirstName . " "
            . $this->producerMainName;
    }

    public function getSummaryLine() {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }

    public function setDiscount(int $num) {
        $this->discount = $num;
    }

    public function getPrice() {
        return $this->price - $this->discount;
    }
}

class ShopProductWriter {
    public function write(ShopProduct $shopProduct) {
        $str = $shopProduct->title . ": "
            . $shopProduct->getProducer()
            . " (" . $shopProduct->price . ")\n";
        print $str;
    }
}

$product1 = new BookProduct(
    "Собачье сердце",
    "Михаил",
    "Булгаков",
    "5.99",
    "550"
);
$product2 = new CdProduct(
    "Классическая музыка. Лучшее",
    "Антонио",
    "Вивальди",
    "5.99",
    "55.35"
);

$product1->setDiscount(2);
$product2->setDiscount(3);

// (new ShopProductWriter())->write($product1);

// print "{$product1->getSummaryLine()}\n";
// print "{$product2->getSummaryLine()}\n";

print "Цена товара - {$product1->getPrice()}\n";
print "Цена товара - {$product2->getPrice()}\n";

// print "Количество страниц: {$product1->getNumPages()}стр.\n";
// print "{$product1->getSummaryLine()}\n";
