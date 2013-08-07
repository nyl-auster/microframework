<?php
/**
 * Map an http request to a class method.
 * 
 * http://yourdomain.com/index.php/hello-world will be considered as "hello-word" internal path.
 * Server search in routes.ini file a entry for "hello-world" that will tel him with method to call in response.
 */
class controller {

  protected $routes = array();

  public function __construct($routes = array()) {
    $this->routes = $routes;
  }

  /**
   * from an url "www.mydomain/index.php/my/path?argument=1, this function extracts "my/path" as a path
   */
  public function getPath() {
    return parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH);
  }

  /**
   * Execute controller corresponding to Internalpath (e.g : "hello/World" )
   */
  public function run($path = '') {
    // no path given, execute homepage method.    
    if (!$path) return $this->homepage();
    // path given but no corresponding route found. This is a 404 http error.
    if (!isset($this->routes[$path])) return $this->pageNotFound();
    // path exists in our routes, fetch corresponding route and call corresponding method
    $route = $this->routes[$path];
    require_once($route['path'] . '/' . $route['class'] . '.php');
    $controller = new $route['class']($this);
    return $controller->$route['method']();
  }

  /**
   * Default method called for page not found.
   */
  public function pageNotFound() {
    header("HTTP/1.1 404 Not Found");
    return 'Oups ! Page not found ... ';
  }

  /**
   * Default method called for homepage (when no path is submitted in http request).
   */
  public function homepage() {
    return 'Welcome to default Homepage.';
  }

}

