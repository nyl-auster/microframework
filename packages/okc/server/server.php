<?php
namespace okc\server;

use okc\events\events;


/**
 * Map a route to a resource class.
 *
 * Example of url to use :
 * www.mysite.local/index.php/hello-world?argument=value&argument2=value2
 * "hello-world" will be extracted as the "route", and a resource class binded to this
 * route will be searched in routes.php file.
 *
 * is server.rewriteEngine is set to TRUE in settings.php, index.php 
 * can be removed from above url.
 */
class server {

  // base path, when framework is installed in a subdirectory
  public static $basePath = '';

  // default routes for homepage, 403 and 404 http errors.
  // @todo maybe http404 and 403 resources should be configured in settings.php.
  protected $routes = array(
    '' => array('class' => 'okc\server\resources\homepage'),
    '__http404' => array('class' => 'okc\server\resources\http404'),
    '__http403' => array('class' => 'okc\server\resources\http403'),
  );

  /**
   * @param array $routes. 
   *   Routes to resources map.
   *   Examples routes :
   *   return array(
   *     'my/path' => array('class' => 'vendor\package\resourceName'),
   *     'hello-world' => array('class' => 'vendor\package\resourceName'),
   *   );
   */
  public function __construct($routes = array()) {
    $this->routes = array_merge($this->routes, $routes);
    self::$basePath = self::getBasePath();
  }

  /**
   * @param string $route
   */
  public function getResource($route = '') {

    // search a resource matching our $route. Skip routes beginning by "__".
    // a hack to not serve __http404 and 403 special resources by url.
    if (isset($this->routes[$route]) && strpos($route, '__') === FALSE) {
      $class = $this->routes[$route]['class'];
      $resource = new $class();
    }

    // no resource found, serve the 404 error resource
    if (!isset($resource)) {
      $resource = new $this->routes['__http404']['class'];
      return $resource;
    }

    // a resource has been found, but access is denied, return 403 error resource.
    if (!$resource->access()) {
      $resource = new $this->routes['__http403']['class'];
      return $resource;
    }

    // resource exists and access is allowed, hurrah :
    return $resource;

  }

  /**
   * Return resource content as a string.
   */
  public function getResponse($route = '') {
    $resource = $this->getResource($route);
    return $resource->render();
  }

  /**
   * Return a route name from current full url
   *
   * @return string
   *   e.g : for url "www.mydomain/index.php/my/route?argument=1, this function wille return "my/route".
   */
  static function getRouteFromUrl() {
    $route = substr_replace($_SERVER['REQUEST_URI'], '', 0, strlen(self::getRouteBasePath()));
    events::fire('serverGetRouteFromUrl', array('route' => &$route));
    return $route;

  }

  /**
   * Treat differently "index.php" in url, if rewriteEngine is enabled or not.
   * We need this to correctly set routes from url and build links from route.
   */
  static function getRouteBasePath() {
    $routeBasePath = '';
    if (\app::setting('server.rewriteEngine') && is_readable('.htaccess')) {
      $routeBasePath = self::getBasePath();
    }
    else {
      $routeBasePath = self::getBasePath() . 'index.php/';
    }
    return $routeBasePath;
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
    events::fire('serverGetUrlFromRoute', array('route' => &$route, 'languageCode' => $languageCode));
    $url = self::getRouteBasePath() . $route;
    return $url;
  }

  /**
   * Build a html link, language aware, adding an active class if needed.
   */
  static function link($text, $route, $options = array()) {
    $languageCode = !empty($options['language']) ? $options['language'] : NULL;
    $options += array('attributes' => array());
    if (self::getRouteFromUrl() == $route) {
      $options['attributes']['class'][] = 'active';
    }
    $href = self::getUrlFromRoute($route, $languageCode);
    $link = sprintf('<a href="%s">%s</a>', $href, $text);
    return $link;
  }

  /**
   * @FIXME check security implications with all $_SERVER variables.
   *
   * Return string :
   *   base relative (relative to the domain name) path of framwork intallation.
   *  for "localhost/directory/okc-framework", if will return
   *  /directory/ if okc-framework is where okc framework is installed.
   */ 
  static function getBasePath() {
    $basePath = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    return $basePath;
  }

}

