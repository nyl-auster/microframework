<?php
namespace microframework\core;

/**
 * Map an url to a ressource.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 */
class server {

  // default ressources
  protected $registry = array(
    'httpError404' => array(
      'class' => 'microframework\core\ressources\httpError404', 
      'route' => FALSE, // make sure this ressource is not accessible by http.
    ),
    'httpError403' => array(
      'class' => 'microframework\core\ressources\httpError403', 
      'route' => FALSE, // make sure this ressource is not accessible by http.
    ),
    'homepage' => array(
      'class' => 'microframework\core\ressources\homepage', 
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
   * Fetch a ressource object by its route.
   * @param string $route
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function getRessourceByRoute($route = '') {

    $ressource = NULL;

    // loop through registered ressources
    foreach($this->registry as $registryName => $datas) {
      if (isset($datas['route']) && $datas['route'] === $route) {
        $ressource = new $datas['class']();
        break;
      }
    }

    // if a ressource has been found
    if ($ressource) {
      $ressource = new $this->registry[$registryName]['class'];
      // if access is allowed, return this ressource
      if ($ressource->access()) {
        return $ressource;
      }
      // else, return httpError403 ressource
      else {
        // no ressource found, serve 404 ressource
        $ressource = new $this->registry['httpError403']['class'];
        return $ressource;
      }
    }

    // no ressource found, this is a 404
    else {
      // no ressource found, serve 404 ressource
      $ressource = new $this->registry['httpError404']['class'];
      return $ressource;
    }

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
   * Create an url from  route name.
   * @param string $route
   * @return string
   *   A real relative Url understandable by our controller, like "wwww.yourdomain/{baseurl}/index.php/hello/world"
   */
  static function getUrlFromRoute($route) {
    return $_SERVER['SCRIPT_NAME'] . '/' . $route;
  }

}

