<?php
/**
 * Map an http request to a class method.
 * 
 * http://yourdomain.com/index.php/hello-world will be considered as "hello-word" internal path.
 * Server search in routes.ini file a entry for "hello-world" that will tel him with method to call in response.
 */
class controller {

  protected $routes = array();
  protected $path = '';

  public function __construct($routes = array()) {
    $this->routes = $routes;
    $this->path = $this->getPath();
  }

  /**
   * from an url "www.mydomain/index.php/my/path?argument=1, this function extracts "my/path" as a path
   */
  public function getPath() {
    return parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH);
  }

  /**
   * Execute controller corresponding to path
   */
  public function dispatch($path = '') {
    // no path given, execute homepage route.    
    if (!$path) return $this->homepage();
    // path given but no corresponding route found. This is a 404 error.
    if (!isset($this->routes[$path])) return $this->pageNotFound();
    }
    // path exists in our routes, fetch corresponding route and call corresponding method
    else {
      $route = $this->routes[$path];
    }
    // waiting for autoloader...
    require_once($route['path'] . '/' . $route['class'] . '.php');
    $controller = new $route['class']($this);
    return $controller->$route['method']();
  }

  /**
   * Default method called for page not found.
   */
  function pageNotFound() {
    header("HTTP/1.1 404 Not Found");
    return 'page Not found';
  }

  /**
   * Default method called for homepage (when no path is submitted in http request).
   */
  function homepage() {
    return 'This is the default Homepage. Update or create your /conf/routes.ini to route homepage to a custom controller.';
  }

}

