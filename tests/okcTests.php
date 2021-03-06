<?php
use okc\config\config;
use okc\server\server;
use okc\packages\packages;
use okc\okc\okc;

class okcTests extends PHPUnit_Framework_TestCase {

  protected $server = null;

  // bootstrap framework
  function __construct() {

    // set autoloader.
    set_include_path(get_include_path() . ":../:packages:../packages");
    spl_autoload_register(function($class){include_once preg_replace('#\\\|_(?!.+\\\)#','/',$class).'.php';});
     
    // start server with some test routes
    $routes = array(
      'test/url' => array('class' => 'okc\server\resources\homepage'),
    );

    $packages = new packages('../packages', 'config');
    $okc = new okc($packages);

    // instanciate configuration
    $settings = $okc->invokePackagesConfig('settings');
    $config = new config($settings);

    // instanciate events manager
    $listeners = $okc->invokePackagesConfig('listeners');
    $events = new events($listeners);

    $events->fire('frameworkBootstrap');

    // instanciate translations
    $translations = $okc->invokePackagesConfig('translations');
    new i18n($translations);

    $server = new server($routes);

    $this->server = new server($routes);

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

  /**
   * Test if config getter is ok.
   */
  public function testconfigGet() {
    $defaultLanguage = config::get('i18n.defaultLanguage');
    $this->assertContains('en-EN', $defaultLanguage);
  }

}

