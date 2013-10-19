<?php
namespace microframework\core;

/**
 * Routeur : Executes a method for a given url.
 * The executeRoute() method is the heart of this class.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * This will match "hello-world" route and execute the corresponding controller method.
 *
 * This class depends on a specific "routes" map definition, that allow this
 * class to match a route with a class and method. See constructor for more details on this.
 */
class routeur {

  // define default routes for 404 errors and homepage.
  // You may override those routes in your routes.php file.
  protected $routes = array(
    '__ROUTE_NOT_FOUND' => array(
      'class' => __CLASS__,
      'method' => 'routeNotFound',
    ),
    '__ROUTE_HOMEPAGE' => array(
      'class' => __CLASS__,
      'method' => 'routeHomepage',
    ),
  );

  /**
   * @param array $routes. 
   * An array of associative arrays describing existing routes, with at least following keys :
   * - class : name of the class to instanciate with full namespace
   * - method : name of method to call
   */
  public function __construct($routes = array()) {
    $this->routes = array_merge($this->routes, $routes);
  }

  /**
   * Return a route name from a full url
   * @return string
   *   e.g : for "www.mydomain/index.php/my/route?argument=1, this function return extracts "my/route" as the route.
   */
  public function getRouteFromUrl() {
    return isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
  }

  /**
   * Execute a controller method corresponding to $route received. 
   * @param string $route
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function executeRoute($route = '') {

    // if this is a "special" route, like homepage or not found, considered
    // that this is a 404, they are not supposed to be triggered by url.
    if (strpos($route, '__') === 0) {
      $route = '__ROUTE_NOT_FOUND';
    }

    // no route given, serve the homepage.
    if (!$route) {
      $route = '__ROUTE_HOMEPAGE';
    }

    // route not found in our routes map, this is a 404 not found
    if (!isset($this->routes[$route])) {
      $route = '__ROUTE_NOT_FOUND';
    }

    // we found route name in our routes map, execute the corresponding controller and method.
    $class = $this->routes[$route]['class'];
    $method = $this->routes[$route]['method'];
    $controller = new $class();
    return $controller->$method();
  }

  /**
   * Default method for route not found error.
   */
  public function routeNotFound() {
    header("HTTP/1.1 404 Not Found");
    return 'Oups ! Page not found ... ';
  }

  /**
   * Default method for homepage route.
   */
  public function routeHomepage() {
    return 'Welcome to default Homepage.';
  }

  /**
   * Create an url from  route name.
   * @param string $route
   * @return string
   *   A real relative Url understandable by our controller, like "wwww.yourdomain/{baseurl}/index.php/hello/world"
   */
  static function createUrlFromRoute($route) {
    return $_SERVER['SCRIPT_NAME'] . '/' . $route;
  }

  /*
  static function redirect($path) {
    $path = self::setUrl($path);
    header("Location: /$path");      
    exit;
  }
  */
}

