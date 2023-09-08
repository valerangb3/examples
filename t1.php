<?php
class CdProduct extends ShopProduct {
    private $playLength;

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
    private $numPages;

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
    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    private $discount = 0;

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

    public function getTitle() {
        return $this->title;
    }

    public function getProducerMainName() {
        return $this->producerMainName;
    }

    public function getProducerFirstName() {
        return $this->producerFirstName;
    }
    
    public function getDiscount() {
        return $this->discount;
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
    private $products = [];

    public function addProduct(ShopProduct $shopProduct) {
        $this->products[] = $shopProduct;
    }

    public function write() {
        $str = "";
        foreach ($this->products as $shopProduct) {
            $str .= $shopProduct->title . ": ";
            $str .= $shopProduct->getProducer();
            $str .= " (" . $shopProduct->getPrice() . ")\n";
        }
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

$spw = new ShopProductWriter();
$spw->addProduct($product1);
$spw->addProduct($product2);
$spw->write();

// (new ShopProductWriter())->write($product1);

// print "{$product1->getSummaryLine()}\n";
// print "{$product2->getSummaryLine()}\n";

// print "Количество страниц: {$product1->getNumPages()}стр.\n";
// print "{$product1->getSummaryLine()}\n";
