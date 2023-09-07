<?php
class CdProduct extends ShopProduct {

    public function getPlayLength() {
        return $this->playLength;
    }

    public function getSummaryLine() {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        $base .= ": Время звучания - {$this->playLength}";
        return $base;
    }
}

class BookProduct extends ShopProduct {

    public function getNumPages() {
        return $this->numPages;
    }

    public function getSummaryLine() {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        $base .= ": {$this->numPages} стр.";
        return $base;
    }
}

class ShopProduct {
    public $numPages;
    public $playLength;
    public $title;
    public $producerMainName;
    public $producerFirstName;
    public $price;

    function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float $price,
        int $numPages = 0,
        int $playLength = 0,
    ) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
        $this->numPages = $price;
        $this->playLength = $playLength;
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
    "0",
    "55.35"
);
// (new ShopProductWriter())->write($product1);

print "Автор: {$product1->getProducer()}\n";
print "Автор: {$product2->getProducer()}\n";
// print "Количество страниц: {$product1->getNumPages()}стр.\n";
// print "{$product1->getSummaryLine()}\n";
