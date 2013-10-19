<?php
namespace microframework\core;

/**
 * Map en url to a ressource.
 * The executeRoute() method is the heart of this class.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * This will match "hello-world" route and execute the corresponding controller method.
 *
 * This class depends on a specific "routes" map definition, that allow this
 * class to match a route with a class and method. See constructor for more details on this.
 */
class server {

  // default ressources
  protected $registry = array(
    'notFoundRessource' => array(
      'class' => 'microframework\core\ressources\notFoundRessource', 
      'route' => FALSE, // make sure this ressource is not accessible by http.
    ),
    'homepageRessource' => array(
      'class' => 'microframework\core\ressources\homepageRessource', 
      'route' => '',
    ),
  );

  /**
   * @param array $registry. 
   * An array of associative arrays describing existing ressources, with at least following keys :
   * - class (string) : name of the class to instanciate with full namespace
   * - route (mixed) : route that will trigger this ressource. may be FALSE.
   */
  public function __construct($registry = array()) {
    $this->registry = array_merge($this->registry, $registry);
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
   * Fetch a ressource object by its route.
   * @param string $route
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function getRessourceByRoute($route = '') {
    // loop through registered ressources
    foreach($this->registry as $registryName => $datas) {
      if (isset($datas['route']) && $datas['route'] === $route) {
        $ressource = new $datas['class']();
        return $ressource;
      }
    }
    // no ressource found, serve 404 ressource
    $ressource = $this->registry['notFoundRessource']['class'];
    return $ressource;
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

}

