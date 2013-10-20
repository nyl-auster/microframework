<?php
namespace microframework\core;

/**
 * Map an url to a resource.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * This will return the resource object map to hello-world route in registry.php
 */
class server {

  // special default resources. They may be overriden in registry.php
  protected $registry = array(
    'http404' => array(
      'class' => 'microframework\core\resources\http404', 
    ),
    'http403' => array(
      'class' => 'microframework\core\resources\http403', 
    ),
    'homepage' => array(
      'class' => 'microframework\core\resources\homepage', 
      'route' => '',
    ),
  );

  /**
   * @param array $registry. 
   * registry resource associative array. see example.registry.php
   */
  public function __construct($registry = array()) {
    $this->registry = array_merge($this->registry, $registry);
  }

  /**
   * Fetch a resource object by its route.
   * @param string $route
   * @return string
   *   output (html or other formats) from requested controller method.
   */
  public function getresourceByRoute($route = '') {

    // loop through registered resources
    foreach($this->registry as $name => $datas) {
      if (is_string($route) && isset($datas['route']) && $datas['route'] === $route) {
        $resource = new $datas['class']();
        break;
      }
    }

    // no resource found, server 404 error resource
    if (!isset($resource)) return new $this->registry['http404']['class'];

    // a resource has been found, serve it if access is allowed, otherwise server 403 error resource.
    return $resource->access() ? $resource : new $this->registry['http403']['class'];

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

