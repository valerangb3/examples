<?php
class ShopProduct {
    public $title = "Стандартный товар";
    public $producerMainName = "Фамилия автора";
    public $producerFirstName = "Имя автора";
    public $price = 0;

    function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float $price
    ) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    function __toString() {
        return "Hello world!\n";
    }

    public function getProducer() {
        return $this->producerFirstName . " "
            . $this->producerMainName;
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

$product1 = new ShopProduct(
    "Собачье сердце",
    "Михаил",
    "Булгаков",
    "5.99"
);

(new ShopProductWriter())->write($product1);

// print "Автор: {$product1->getProducer()}\n";