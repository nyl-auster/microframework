<?php
/**
 * Tiny class to map a route to a controller method.
 *
 * @TODO  * Do not write "index.php" in hard in this file, we may use other entry point if wanted.
 */
class app {

  public function __construct() {
    // get routes.ini and config.ini files. Merge default and custom ones.
    $locations = array(dirname(__FILE___), 'conf');
    foreach (array('routes', 'config') as $name) {
      $this->$name = parse_ini_file("conf/$name.ini", true) + parse_ini_file(dirname(__FILE__) ."/conf/$name.ini", true);
    }
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
  public function executeRoute($path = '') {
    // no path given, execute homepage route.    
    if (!$path) {
      $route = $this->routes['__home__'];
    }
    // path given but no corresponding route found. This is a 404 error.
    elseif (!isset($this->routes[$path])) {
      $route = $this->routes['__404__'];
    }
    // path exists in our routes, fetch corresponding route in our routes' list.
    else {
      $route = $this->routes[$path];
    }
    require_once('controllers/defaultController.php');
    require_once($route['path'] . '/' . $route['class'] . '.php');
    $controller = new $route['class']($this);
    return $controller->$route['method']();
  }

  /**
   * Display a template, with or without variables.
   */
  public function view($file, $variables = array()) {
    // pass app objet to our available variables in templates.
    $variables['app'] = $this;
    extract($variables);
    ob_start();
    include($file);
    $obOutput = ob_get_contents();
    ob_end_clean();
    return $obOutput;
  }

  // create a real url from a symbolic url
  public function url($path) {
    $parts = array('index.php', $path);
    if (isset($this->config['baseUrl'])) {
      array_unshift($parts, $this->config['baseUrl']);
    }
    return '/' . implode('/', $parts);
  }

}

