<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * UnitPHP Test class of PagesController
 *
 * @author skaushalye
 */
class PagesControllerTest extends TestCase
{
    /*private $_this;
    
    public function setUp()
    {
        $this->_this = new \App\Http\Controllers\PagesController();
        
        global $mockSocketCreate;
        $mockSocketCreate = false;
    }*/
    
    public function testIndex()
    {
        $this->visit('/')
             ->see('Skywings')
             ->dontSee('Rails');
    }
}
