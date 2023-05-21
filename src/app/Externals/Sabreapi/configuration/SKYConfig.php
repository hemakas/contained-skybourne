<?php
namespace App\Externals\Sabreapi\configuration;

class SKYConfig {
    
    private $restConfig;
    private static $instance = null;
    
    private function __construct() {
        $this->restConfig = parse_ini_file("SKYRestConfig.ini");
    }
    
    public static function getInstance() {
        if (SKYConfig::$instance === null) {
            SKYConfig::$instance = new SKYConfig();
        }
        return SKYConfig::$instance;
    }
    
    public function getRestProperty($propertyName) {
        return $this->restConfig[$propertyName];
    }
    
    public function getSoapProperty($propertyName) {
        return $this->soapConfig[$propertyName];
    }
}
