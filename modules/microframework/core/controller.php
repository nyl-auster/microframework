<?php
namespace microframework\core;

/**
 * Genereic controller.
 * Map an http request to a class method. 
 * This class depends on a specific "routes" definition. 
 * @see constructor for more precisions on that.
 * 
 * http request must be of the following
 * {yourdomain}/{entrypoint}/{path}
 * E.g : mysite.local/index.php/hello-world
 */
class controller {

  protected $routes = array();

  /**
   * @param array $routes. 
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
   *   e.g : for "www.mydomain/index.php/my/path?argument=1, this function return extracts "my/path" as a path.
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
  public function execute($path = '') {
    // path is empty, serve the homepage.
    if (!$path) return $this->homepage();
    // we can't find this parth in our routes, this is a 404 error
    if (!isset($this->routes[$path])) return $this->pageNotFound();
    // instanciate aour class and call corresponding method.
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
   * Default method callback for homepage.
   */
  public function homepage() {
    return 'Welcome to default Homepage.';
  }

  /**
   * @param string $internalPath
   *   An internal path like 'hello/world'
   * @return string
   *   A real relative path understandable by our controller, like "wwww.yourdomain/{baseurl}/index.php/hello/world"
   */
  static function path($internalPath) {
    return $_SERVER['SCRIPT_NAME'] . '/' . $internalPath;
  }

  /*
  static function redirect($path) {
    $path = self::path($path);
    header("Location: /$path");      
    exit;
  }
  */

}

