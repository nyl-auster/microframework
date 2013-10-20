<?php
namespace microframework\core;

/**
 * Map an url to a resource.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * This will return the resource object map to hello-world route in routes.php
 */
class server {

  // special default resources. They may be overriden in routes.php
  protected $routes = array(
    '' => array('class' => 'microframework\core\resources\homepage'),
    '__http404' => array('class' => 'microframework\core\resources\http404'),
    '__http403' => array('class' => 'microframework\core\resources\http403'),
  );

  /**
   * @param array $routes. 
   * routes resource associative array. see example.routes.php
   */
  public function __construct($routes = array()) {
    $this->routes = array_merge($this->routes, $routes);
  }

  /**
   * Fetch a resource object by its route.
   * @param string $route
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function getresourceByRoute($route = '') {

    // search a resource corresponding to this $route. Do not match routes
    // beginning by "__", which is our convention for private but overridable resources.
    $resource = isset($this->routes[$route]) && strpos($route, '__') === FALSE ? new $this->routes[$route]['class'] : FALSE;

    // no resource found, server 404 error resource
    if (!$resource) return new $this->routes['__http404']['class'];

    // a resource has been found, serve it if access is allowed, otherwise server 403 error resource.
    return $resource->access() ? $resource : new $this->routes['__http403']['class'];

  }

  /**
   * Return a route name from a full url
   * @return string
   *   e.g : for "www.mydomain/index.php/my/route?argument=1, this function return extracts "my/route" as the route.
   */
  static function getRouteFromUrl() {
    return isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
  }

  /**
   * Create an url from  route name, to build correct links from routes.
   * @param string $route
   * @return string
   *   A relative url understandable, like "/index.php/hello/world"
   */
  static function getUrlFromRoute($route) {
    return $_SERVER['SCRIPT_NAME'] . '/' . $route;
  }

}

