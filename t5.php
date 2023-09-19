<?php

abstract class DomainObject {
    public static function create() {
        return new static();
    }

    protected static function getNumber() {
        return 777;
    }

    public static function getData() {
        return self::getNumber();
    }
}

class User extends DomainObject {

}

class Document extends DomainObject {
    protected static function getNumber() {
        return 333;
    }

    public function getFoo() {
        return 'foo';
    }
}

class DocumentExt extends DomainObject {
    
}

//В контексте объекта мы можем вызывать как статические методы класса,
//так и обычные методы класса.
var_dump((Document::create())->getData());

//В контексте класса мы можем вызывать только статические методы.
// var_dump(Document::getFoo());

//Разница использования self и static в методах:
//static осуществляет поиск с вызываемого класса;
//self осуществляет поиск начиная с текущего класса.
var_dump(Document::getData());