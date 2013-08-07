<?php
/**
 * Map an http request to a class method. 
 */
class controller {

  protected $routes = array();

  /**
   * @param array $routes
   * An array of associative arrays describing existing routes, with following keys :
   * - path (string) : path to directory containg the class file
   * - class : name of the class to instanciate
   * - method : name of method to call
   */
  public function __construct($routes = array()) {
    $this->routes = $routes;
  }

  /**
   * Return internal url from http request.
   *
   * @return string
   *   e.g : for "www.mydomain/index.php/my/path?argument=1, this function return extracts "my/path" as a path
   */
  public function getPath() {
    return parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH);
  }

  /**
   * Execute controller for a given path
   * @param string $path
   *   an internal path, e.g : "hello/world".
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function run($path = '') {
    if (!$path) return $this->homepage();
    if (!isset($this->routes[$path])) return $this->pageNotFound();
    $route = $this->routes[$path];
    require_once($route['path'] . '/' . $route['class'] . '.php');
    $controller = new $route['class']($this);
    return $controller->$route['method']();
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

}

