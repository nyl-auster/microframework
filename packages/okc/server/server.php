<?php
namespace okc\server;

use okc\eventsManager\eventsManager;
use okc\packagesManager\packagesManager;

/**
 * Map a route to a resource.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * "hello-world" will be extract as the "route", and a resource class binded to this
 * route will be searched in routes.php file.
 */
class server {

  // default routes for homepage, 403 and 404 http errors. Overridable in routes.php file.
  protected $routes = array(
    '' => array('class' => 'okc\server\resources\homepage'),
    '__http404' => array('class' => 'okc\server\resources\http404'),
    '__http403' => array('class' => 'okc\server\resources\http403'),
  );

  // base path, when framework is installed in a subdirectory
  public static $basePath = '';

  public function getRoutes() {
    $routes = array();
    // waiting for container system...
    $pm = new packagesManager('packages', 'config');
    $packages = $pm->getList();
    foreach ($packages as $packageId => $packageDatas) {
      foreach ($packageDatas['configFiles'] as $fileName => $filePath) {

        // merge all route files to one big route.
        if ($fileName == 'routes.php') {
          if (!is_readable($filePath)) continue;
          $fileDatas = include $filePath;
          if ($fileDatas == 1) continue;
          foreach ($fileDatas as $route => $routeDatas) {
            $routes[$route] = $routeDatas;
            $routes[$route]['packageId'] = $packageId;
          }
        }

      }
    }
    return $routes;
  }

  /**
   * @param array $routes. 
   *   Routes to resources map. see example.routes.php
   */
  public function __construct() {
    $this->routes = array_merge($this->routes, $this->getRoutes());
    self::$basePath = self::getBasePath();
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
      $class = $this->routes[$route]['class'];
      $resource = new $class();
    }

    // no resource found, serve the 404 error resource
    if (!isset($resource)) {
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
      return new $this->routes['__http404']['class'];
    }

    // a resource has been found, but acces is denied, return 403 error resource.
    if (!$resource->access()) {
      header($_SERVER["SERVER_PROTOCOL"]." 403 Access Denied "); 
      return new $this->routes['__http403']['class'];
    }

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
    $route = isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
    eventsManager::fire('serverGetRouteFromUrl', array('route' => &$route));
    return $route;

  }

  /**
   * Create an url from  route name.
   * @param string $route
   * @param string $language
   *   force language prefix for this link (if translator is enabled)
   * @return string
   *   A relative url, like "/index.php/hello/world", usable in links.
   */
  static function getUrlFromRoute($route, $languageCode = NULL) {
    eventsManager::fire('serverGetUrlFromRoute', array('route' => &$route, 'languageCode' => $languageCode));
    $url = $_SERVER['SCRIPT_NAME'] . '/' . $route;
    return $url;
  }

  /**
   * Build a html link, language aware, adding an active class if needed.
   */
  static function link($route, $text, $options = array()) {
    $languageCode = !empty($options['language']) ? $options['language'] : NULL;

    $options += array('attributes' => array());
    if (self::getRouteFromUrl() == $route) {
      $options['attributes']['class'][] = 'active';
    }
    $href = self::getUrlFromRoute($route, $languageCode);
    $link = sprintf('<a href="%s" %s > %s </a>', $href, self::setAttributes($options['attributes']), $text);
    return $link;
  }

  /**
   * @FIXME check security implications with all $_SERVER variables.
   */ 
  static function getBasePath() {
    return str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
  }

  // @FIXME : move somewhere else (note : thank you drupal)
  function setAttributes($attributes = array()) {
    foreach ($attributes as $attribute => &$data) {
      $data = implode(' ', (array) $data);
      $data = $attribute . '="' . $data . '"';
    }
    return $attributes ? ' ' . implode(' ', $attributes) : '';
  }

}
