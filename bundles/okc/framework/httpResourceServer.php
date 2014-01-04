<?php
namespace okc\framework;

use okc\framework\eventsManager;

/**
 * Map a route to a resource.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * "hello-world" will be extract as the "route", and a resource class binded to this
 * route will be searched in routes.php file.
 */
class httpResourceServer {

  // default routes for homepage, 403 and 404 http errors. Overridable in routes.php file.
  protected $routes = array(
    '' => array('class' => 'okc\framework\resources\homepage'),
    '__http404' => array('class' => 'okc\framework\resources\http404'),
    '__http403' => array('class' => 'okc\framework\resources\http403'),
  );

  // eventsManager instance
  protected $eventsManager = null;

  /**
   * @param array $routes. 
   *   Routes to resources map. see example.routes.php
   */
  public function __construct($routes = array(), eventsManager $eventsManager) {
    $this->routes = array_merge($this->routes, $routes);
    $this->eventsManager = $eventsManager;
  }

  /**
   * Fetch a resource object by its route.
   *
   * @param string $route
   *   route searched. E.g : "my/path".
   * @return object
   *   a "resource" object.
   */
  public function getResource($route = '') {

    // search a resource matching our $route. Skip routes beginning by "__".
    if (isset($this->routes[$route]) && strpos($route, '__') === FALSE) {
      $resource = new $this->routes[$route]['class'];
    }

    // no resource found, serve the 404 error resource
    if (!isset($resource)) {
      http_response_code(403);
      return new $this->routes['__http404']['class'];
    }

    // a resource has been found, but acces is denied, return 403 error resource.
    if (!$resource->access()) {
      http_response_code(404);
      return new $this->routes['__http403']['class'];
    }

    $this->eventsManager->fire('server.getResource', array('resource' => $resource));

    // resource exists and access is allowed, hurrah :
    return $resource;

  }

  /**
   * Return a route name from current full url
   *
   * @return string
   *   e.g : for url "www.mydomain/index.php/my/route?argument=1, this function wille return "my/route".
   */
  static function getRouteFromUrl() {
    return isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
  }

  /**
   * Create an url from  route name.
   * @param string $route
   * @return string
   *   A relative url, like "/index.php/hello/world", usable in links.
   */
  static function getUrlFromRoute($route) {
    return $_SERVER['SCRIPT_NAME'] . '/' . $route;
  }

}

