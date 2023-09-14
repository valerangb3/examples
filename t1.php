<?php
require_once('traits.php');

interface Chargeable {
    public function getPrice(): float;
}

abstract class ShopProductWriter {
    protected $products = [];

    public function addProduct(ShopProduct $shopProduct) {
        $this->products[] = $shopProduct;
    }

    abstract public function write();

}

class ShopProduct implements Chargeable {

    use PriceUtilities, IdentityTrait;

    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    private $discount = 0;

    private $id = 0;

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

    public function setID(int $id) {
        $this->id = $id;
    }

    public static function getInstance(int $id, \PDO $pdo) {
        $stmt = $pdo->prepare("select * from products where id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (empty($row)) {
            return null;
        }
        
        if ($row["type"] === "cd") {
            $product = new CdProduct(
                $row["title"],
                $row["firstname"],
                $row["mainname"],
        (float) $row["price"],
          (int) $row["playlength"]
            );
        } elseif ($row["type"] === "book") {
            $product = new BookProduct(
                $row["title"],
                $row["firstname"],
                $row["mainname"],
        (float) $row["price"],
          (int) $row["numpages"]
            );
        } else {
            $firstName = (is_null($row["firstname"])) ? "" : $row["firstname"];
            $product = new ShopProduct(
                $row["title"],
                $firstName,
                $row["mainname"],
        (float) $row["price"],
            );
        }
        $product->setID($row["id"]);
        $product->setDiscount($row["discount"]);
        return $product;
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

    public function getPrice():float {
        return $this->price - $this->discount;
    }
}

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

    public function getPrice():float {
        return $this->price;
    }
}

class TextProductWriter extends ShopProductWriter {
    public function write() {
        $str = "ТОВАРЫ:\n";
        foreach ($this->products as $shopProduct) {
            $str .= $shopProduct->getSummaryLine() . "\n";
        }
        print $str;
    }
}

class XmlProductWriter extends ShopProductWriter {
    public function write() {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument("1.0", "UTF-8");
        $writer->startElement("products");
        foreach ($this->products as $shopProduct) {
            $writer->startElement("product");
            $writer->writeAttribute("title", $shopProduct->getTitle());
            $writer->startElement("summary");
            $writer->text($shopProduct->getSummaryLine());
            $writer->endElement(); //summary
            $writer->endElement(); //product
        }
        $writer->endElement(); // products
        $writer->endDocument();
        print $writer->flush();
    }
}


$product1 = new ShopProduct(
    "Нежное мыло",
    "",
    "Ванная Боба",
    1.33,
);
print $product1->calculateTax(100) . "\n";
print $product1->generateId() . "\n";
/*
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
$spw = new XmlProductWriter();
$spw->addProduct($product1);
$spw->addProduct($product2);
$spw->write();

$product1->setDiscount(2);
$product2->setDiscount(3);

$spw = new ShopProductWriter();
$spw->addProduct($product1);
$spw->addProduct($product2);
$spw->write();

$pdo = new PDO(
    "sqlite:" . __DIR__ . "/db",
    null,
    null,
    [PDO::ATTR_PERSISTENT => true]
);
$product = ShopProduct::getInstance(4, $pdo);
*/