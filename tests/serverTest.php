<?php

abstract class microframework_TestCase extends PHPUnit_Framework_TestCase {

  // bootstrap microframework
  function __construct() {
    // autoloader PSR-0. Use vendor and modules directories to look for the requested class.
    set_include_path(get_include_path() . ":.:../modules:../vendor");
    spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});
    $this->eventsManager = \microframework\events\eventsManager::getInstance(array());
  }

}

class serverTest extends microframework_TestCase {

  public function testGetResource() {
    $server = new \microframework\core\server(array(), $this->eventsManager);
    $resource = $server->getResource('');
    $this->assertInstanceOf('\microframework\core\resource', $resource);
  }

}

