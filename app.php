<?php
/**
 * Tiny class to map a route to a controller method.
 *
 * 1 - Call this code in the index.php at the root of your application.
 * @code
 * require 'app.php';
 * $app = new app();
 * print $app->executeRoute($app->getPath());
 * @endcode
 *
 * 2 - Create routes in a ini file, in "conf" directory at the root of your application.
 * @code
 * [hello/world]
 * path = controllers
 * class = myController
 * method = helloWorld
 * @encode
 *
 * - hello/world mean than your controller will respond going on "domain.com/index.php/hello/world" url.
 * - class is your class name to instanciate. Your file have to be name myControler.php in this example.
 * - method : method that will be called for this url.
 *
 * 3 - Create your controller in "controllers/myController.php" file, extending defaultController :
 * @code
 * class myController extends defaultController {
 * 
 *   function helloWorld() {
 *     return 'Hello world';
 *     // you may use a template this way :
 *     // return $this->view('templates/helloWorld.html.php');
 *   }
 *
 * }
 * @endcode
 *
 * 4 - goto to yourdomain.com/index.php/hello/world and see "hello world" displaying.
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
    // to path given, execute homepage route.    
    if (!$path) {
      $route = $this->routes['__home__'];
    }
    // path given but no corresponding route found. This is a 404 error.
    elseif (!isset($this->routes[$path])) {
      $route = $this->routes['__404__'];
    }
    // path exists in our routes, fetch corresponding route.
    else {
      $route = $this->routes[$path];
    }
    // load classes files manually for now.
    $file = $route['path'] . '/' . $route['class'] . '.php';
    require_once('controllers/defaultController.php');
    require_once($file);
    $controller = new $route['class']($this);
    return $controller->$route['method']();
  }

  /**
   * Display a template, with or without variables.
   */
  public function view($file, $variables = array()) {
    // pass app objet to our variable
    $variables['app'] = $this;
    extract($variables);
    ob_start();
    include($file);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }

}

