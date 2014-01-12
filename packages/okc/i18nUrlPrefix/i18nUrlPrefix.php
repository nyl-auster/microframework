<?php
namespace okc\i18nUrlPrefix;

use okc\i18n\i18n;
use okc\config\config;

/**
 * Alter routes from okc server to add language prefix url.
 * Overrides getLanguage method to fetch current active language in url.
 *
 * @FIXME inject settings.
 */
class i18nUrlPrefix extends i18n {

  /**
   * okc Listener
   *
   * when picking route from url sent by browser,
   * remove lang urlPrefix from route before passing it back to the server,
   * so that it can find route in the router. (route is never declared with a language)
   */
  function serverGetRouteFromUrl(&$route) {
    $route = self::removeUrlPrefix($route); 
  }

  /**
   * Okc Listener 
   *
   * When building links with this server::getUrlFromRoute or with server::link,
   * we need to add automatically the right urlPrefix for current language.
   */
  function serverGetUrlFromRoute(&$route, $languageCode) {
    $route = self::addUrlPrefix($route, $languageCode); 
  }

  /**
   * Get current active language.
   *
   * return string
   *   e.g fr_FR, en_EN
   */
   public function getLanguage() {
     $languageCode = parent::getLanguage();
     $currentPath = isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
     $urlPrefix = self::getUrlPrefixFromRoute($currentPath);
     // if there is a language urlPrefix, translate it to languageCode.
     // If no prefix is found, fallback to defaultLanguage
     if ($urlPrefix) {
       $languageCode = self::urlPrefixToLanguageCode($urlPrefix);
     }
     return $languageCode;
  }

  /**
   * Get list of existing url prefixes for defined languages
   * in settings.php file.
   *
   * return array
   */
  protected function getUrlPrefixes() {
    $prefixes = config::get('i18n.url.prefixes');
    return $prefixes;
  }

  /**
   * Transform fr_FR to fr, to build url
   */
  protected function languageCodeToUrlPrefix($langCode) {
    $prefixes = self::getUrlPrefixes();
    if (isset($prefixes[$langCode])) {
      return $prefixes[$langCode];
    }
  }

  /**
   * Transform fr to fr_FR, to get languageCode from urlPrefix
   */
  public function urlPrefixToLanguageCode($urlPrefix) {
    $prefixes = self::getUrlPrefixes();
    foreach ($prefixes as $languageCode => $prefix) {
      if ($urlPrefix == $prefix) {
        return $languageCode;
      } 
    }
  }

  /**
   * extract 'fr' from a route like "index.php/fr/my/route"
   */
  public function getUrlPrefixFromRoute($route) {
    $route_parts = explode('/', $route);
    if (in_array($route_parts[0], self::getUrlPrefixes())) {
      return $route_parts[0];
    }
  }

  /**
   * Remove urlPrefix from route, if any.
   */
  public function removeUrlPrefix($route) {
    $prefix = self::getUrlPrefixFromRoute($route);
    if ($prefix) {
      $route_parts = explode('/', $route);
      array_shift($route_parts);
      $route = implode('/', $route_parts);
    }
    return $route;
  }

  /**
   * Add url prefix to a route, if missing.
   */
  public function addUrlPrefix($route, $languageCode = NULL) {
    // do nothing if there is already a prefix.
    $language = $languageCode ? $languageCode : self::getLanguage(); 
    return self::languageCodeToUrlPrefix($language) .'/' . $route;
  }

}

