<?php
class A {
    protected static $bar = "bar";

    public function foo() {
        print "Class: " . __CLASS__ . "\n";
    }
}
class B extends A {
    public function foo() {
        print "Class: " . __CLASS__ . "\n";
    }
    
}
class C extends B {
    public function foo() {
        // parent::foo();
        print parent::$bar . "\n";
    }
}

(new C())->foo();
