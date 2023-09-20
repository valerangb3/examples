<?php

use function PHPSTORM_META\type;

class Conf {
    private $file;
    private $xml;
    private SimpleXMLElement $lastMatch;

    public function __construct(string $file) {
        $this->file = $file;
        $this->xml = simplexml_load_file($file);
    }

    public function write() {
        file_put_contents($this->file, $this->xml->asXML());
    }

    public function set(string $key, string $value) {
        if (!is_null($this->get($key))) {
            //Так как в $this->lastMatch хранится объект, то мы можем изменить значение поля
            $this->lastMatch[0] = $value;
            return;
        }
        $this->xml->addChild('item', $value)->addAttribute('name', $key);
    }

    public function get(string $key) {
        //$matches - массив
        $matches = $this->xml->xpath("/conf/item[@name=\"$key\"]");
        if (is_array($matches) && count($matches)) {
            //В $this->lastMatch - объект типа SimpleXMLElement
            $this->lastMatch = $matches[0];
            return (string) $matches[0];
        }
        return null;
    }
}

$confObject = new Conf('conf.xml');
$confObject->set('user', 'bob');
$confObject->set('dbname', 'UncleBob');
$confObject->set('debug', 'true');
$confObject->write();
// var_dump($confObject->get('pass'));