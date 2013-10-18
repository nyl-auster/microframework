<?php
namespace microframework\core;

/**
 * Light generic controller that maps an url to a class method. 
 *
 * Note : this class works only with apache http server.
 * This class depends on a specific "routes" definition
 * @see constructor for more precisions on routes format to use
 * 
 * url must follow this pattern :
 * {yourdomain}/{entrypoint}/{internal_setUrl}{arguments GET}
 * E.g : mysite.local/index.php/hello-world?argument=value&argument2=value2
 * "hello-world" is the internal setUrl part, use to map an url to a method 
 *
 * Default entry point is index.php, but you may create different entry points if
 * needed, this class will still works with others filenames than "index.php"
 */
class controller {

  protected $routes = array();

  /**
   * @param array $routes. 
   * An array of associative arrays describing existing routes, with following keys :
   * - class : name of the class to instanciate with full namespace
   * - method : name of method to call
   */
  public function __construct($routes = array()) {
    $this->routes = $routes;
  }

  /**
   * Return internal setUrl from GET http request.
   * @return string
   *   e.g : for "www.mydomain/index.php/my/setUrl?argument=1, this function return extracts "my/path" as a path.
   */
  public function getRequestedPath() {
    return isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
  }

  /**
   * Execute an arbitrary controller for $path
   * @param string $path
   *   an internal setUrl, e.g : "hello/world".
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function execute($path = '') {
    // path is empty, serve the homepage.
    if (!$path) return $this->homepage();
    // we can't find this path in our routes, this is a 404 error
    if (!isset($this->routes[$path])) return $this->documentNotFound();

    // instanciate our class and call corresponding method.
    $route = $this->routes[$path];
    $controller = new $route['class']($this);
    return $controller->$route['method']();
  }

  /**
   * Default method callback for 404 errors.
   */
  public function documentNotFound() {
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
   * Get a full url from an internal setUrl
   * @param string $internalsetUrl
   *   An internal setUrl like 'hello/world'
   * @return string
   *   A real relative setUrl understandable by our controller, like "wwww.yourdomain/{baseurl}/index.php/hello/world"
   */
  static function setUrl($internalPath) {
    return $_SERVER['SCRIPT_NAME'] . '/' . $internalsetUrl;
  }

  /*
  static function redirect($path) {
    $path = self::setUrl($path);
    header("Location: /$path");      
    exit;
  }
  */
}

