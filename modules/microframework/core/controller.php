<?php
namespace microframework\core;

/**
 * Map an http request to a class method. 
 */
class controller {

  protected $routes = array();
  // script bootstrapping our framework. This controller will be classically called
  // in a index.php at the root of application, but may be also bootstraped from a "dev.php", for example, if we want.
  protected $appEntryPoint = 'index.php';

  /**
   * @param array $routes
   * An array of associative arrays describing existing routes, with following keys :
   * - path (string) : path to directory containg the class file
   * - class : name of the class to instanciate
   * - method : name of method to call
   */
  public function __construct($routes = array()) {
    $this->routes = $routes;
    $this->appEntryPoint = $this->getAppEntryPoint();
  }

  /**
   * @return string
   *   Name of script used as an entry point. E.g : index.php, dev.php, test.php
   */
  private function getAppEntryPoint() {
    $parts = explode('/', $_SERVER['SCRIPT_NAME']);
    return array_pop($parts);
  }

  /**
   * Return internal url from http request.
   *
   * @return string
   *   e.g : for "www.mydomain/index.php/my/path?argument=1, this function return extracts "my/path" as a path
   */
  public function getRequestedPath() {
    return isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
  }

  /**
   * Execute an arbitrary controller for $path
   * @param string $path
   *   an internal path, e.g : "hello/world".
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function executePath($path = '') {
    if (!$path) return $this->homepage();
    if (!isset($this->routes[$path])) return $this->pageNotFound();
    extract($this->routes[$path]);
    $controller = new $class($this);
    return $controller->$method();
  }

  /**
   * Default method callback for 404 errors.
   */
  public function pageNotFound() {
    header("HTTP/1.1 404 Not Found");
    return 'Oups ! Page not found ... ';
  }

  /**
   * Default method callback for homepage
   */
  public function homepage() {
    return 'Welcome to default Homepage.';
  }

  /**
   * @param string $internalPath
   *   An internal path like 'hello/world'
   * @return string
   *   A real relative path understandable by our controller, like "/index.php/hello/world"
   */
  public function setUrl($internalPath) {
    return "/$this->appEntryPoint/$internalPath";
  }

}

