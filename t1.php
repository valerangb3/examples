<?php
class ShopProduct {
    public $title = "Стандартный товар";
    public $productName = "Фамилия автора";
    public $producerFirstName = "Имя автора";
    public $price = 0;

    function __toString() {
        return "Hello world!\n";
    }
}

$sp1 = new ShopProduct();
$sp2 = new ShopProduct();
var_dump($sp1);
var_dump($sp2);