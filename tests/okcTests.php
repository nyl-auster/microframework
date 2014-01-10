<?php

class okcTests extends PHPUnit_Framework_TestCase {

  protected $server = null;

  // bootstrap framework
  function __construct() {

    // set autoloader.
    set_include_path(get_include_path() . ":.:packages:../packages");
    spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});
     
    // start server with some test routes
    $routes = array(
      'test/url' => array('class' => 'okc\server\resources\homepage'),
    );
    $this->server = new \okc\server\server($routes);

  }

  /**
   * Test if homepage resource is correctly served. 
   */
  public function testServerHomepageResource() {
    $resource = $this->server->getResource('');
    $this->assertInstanceOf('\okc\server\resources\homepage', $resource);
  }

  /**
   * Test if url routing is working and returns expected resource
   */
  public function testServerRouting() {
    $resource = $this->server->getResource('test/url');
    $this->assertInstanceOf('\okc\server\resources\homepage', $resource);
  }

  /**
   * Test if a wrong url return the 404 default resource.
   */
  public function testServerHttp404() {
    $resource = $this->server->getResource('a2x789ieZfvuehIa');
    $this->assertInstanceOf('\okc\server\resources\http404', $resource);
  }

  /**
   * Test if homepage resource is correctly served. 
   */
  public function testServerGetResponse() {
    $content = $this->server->getResponse('');
    $this->assertContains('Default homepage', $content);
  }

}

