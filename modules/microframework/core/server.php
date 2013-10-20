<?php
namespace microframework\core;

/**
 * Map an url to a ressource.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * This will return the ressource object map to hello-world route in registry.php
 */
class server {

  // special default ressources. They may be overriden in registry.php
  protected $registry = array(
    'http404' => array(
      'class' => 'microframework\core\ressources\http404', 
    ),
    'http403' => array(
      'class' => 'microframework\core\ressources\http403', 
    ),
    'homepage' => array(
      'class' => 'microframework\core\ressources\homepage', 
      'route' => '',
    ),
  );

  /**
   * @param array $registry. 
   * registry ressource associative array. see example.registry.php
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

    // loop through registered ressources
    foreach($this->registry as $name => $datas) {
      if (is_string($route) && isset($datas['route']) && $datas['route'] === $route) {
        $ressource = new $datas['class']();
        break;
      }
    }

    // no ressource found, server 404 error ressource
    if (!isset($ressource)) return new $this->registry['http404']['class'];

    // a ressource has been found, serve it if access is allowed, otherwise server 403 error ressource.
    return $ressource->access() ? $ressource : new $this->registry['http403']['class'];

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

