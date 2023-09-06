<?php
class AddressManager {
    private $address = ["209.131.36.159", "216.58.213.174"];

    public function outputAddress($resolve) {
        foreach ($this->address as $address) {
            print $address . "\n";
            if ($resolve) {
                print " (".gethostbyaddr($address).")";
            }
            print "\n";
        }
    }
}

$settings = simplexml_load_file(__DIR__."/resolve.xml");

(new AddressManager())->outputAddress( (string) $settings->resolvedomains );