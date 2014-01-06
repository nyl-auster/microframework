<?php
namespace okc\i18n;

use okc\framework\server;

class i18n {

  /**
   * Listener
   *
   * when picking route from url sent by browser,
   * remove lang urlPrefix from route before passing it back to the server,
   * so that it can find route in the router. (route is never declared with a language)
   */
  function serverGetRouteFromUrl(&$route) {
    global $_settings;

    if ($_settings['i18n']['enabled']) {
      if ($_settings['i18n']['languageNegociation'] == 'urlPrefix') {
        $route = self::removeUrlPrefix($route); 
      }
    }

  }

  /**
   * Listener 
   *
   * When building links with this server::getUrlFromRoute or with server::link,
   * we need to add automatically the right urlPrefix for current language.
   */
  function serverGetUrlFromRoute(&$route, $languageCode) {
    global $_settings;
    if ($_settings['i18n']['enabled']) {
      if ($_settings['i18n']['languageNegociation'] == 'urlPrefix') {
        $route = self::addUrlPrefix($route, $languageCode); 
      }
    }

  }

  /**
   * Translate a string Id to a localized string
   */
  static function t($stringId, $language = NULL) {
    global $_translations;
    $languageCode = self::getLanguage();
    if (isset($_translations[$languageCode][$stringId])) {
       return $_translations[$languageCode][$stringId];
    }
    return $stringId;
  }


  /**
   * Get list of existing url prefixes for defined languages
   * in settings.php file.
   *
   * return array
   */
  static function getI18nUrlPrefixes() {
    global $_settings;
    $prefixes = array();
    foreach ($_settings['i18n']['languages'] as $language => $datas) {
      $prefixes[] = $datas['urlPrefix'];
    }
    return $prefixes;
  }

  /**
   * Remove urlPrefix from route, if any.
   */
  static function removeUrlPrefix($route) {
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
  static function addUrlPrefix($route, $languageCode = NULL) {
    // do nothing if there is already a prefix.
    $language = $languageCode ? self::languageCodeToUrlPrefix($languageCode) : self::getLanguage(); 
    return $language .'/' . $route;
  }

  /**
   * Get Current global language, according to languageNegociation
   * configured in settings.
   *
   * return string
   *   e.g fr_FR, en_EN
   */
  static function getLanguage() {

    global $_settings;

    $languageCode = $_settings['defaultLanguage'];

    if ($_settings['i18n']['enabled']) {
      if ($_settings['i18n']['languageNegociation'] == 'urlPrefix') {
        // cannot use server::getRouteFromUrl as this function return route without urlPrefix.
        $currentPath = isset($_SERVER['PATH_INFO']) ? parse_url(trim($_SERVER['PATH_INFO'], '/'), PHP_URL_PATH) : '';
        $urlPrefix = self::getUrlPrefixFromRoute($currentPath);
        // if there is a language urlPrefix, translate it to languageCode.
        // If no prefix is found, fallback to defaultLanguage
        if ($urlPrefix) {
          $languageCode = self::urlPrefixToLanguageCode($urlPrefix);
        }

      }
    }

    return $languageCode;

  }

  static function getUrlPrefixFromRoute($route) {
    global $_settings;
    $route_parts = explode('/', $route);
    if (in_array($route_parts[0], self::getI18nUrlPrefixes())) {
      return $route_parts[0];
    }
  }

  /**
   * Transform fr_FR to fr, to build url
   */
  static function languageCodeToUrlPrefix($langCode) {
    global $_settings;
    if (isset($_settings['i18n']['languages'][$langCode])) {
      return $_settings['i18n']['languages'][$langCode]['urlPrefix'];
    }
  }

  /**
   * Transform fr to fr_FR, to get languageCode from urlPrefix
   */
  static function urlPrefixToLanguageCode($urlPrefix) {
    global $_settings;
    foreach ($_settings['i18n']['languages'] as $languageCode => $datas) {
      if ($datas['urlPrefix'] == $urlPrefix) {
        return $languageCode;
      } 
    }
  }

}

