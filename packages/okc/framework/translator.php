<?php
namespace okc\framework;

use okc\framework\server;

class translator {

  static function t($string_id) {

    global $_translations;
    global $_settings;
    $language = server::getCurrentLanguage();
    $defaultLanguage = $_settings['translator']['defaultLanguage'];

    // return current language if translator is enabled
    if (isset($_translations[$language][$string_id])) {
      return $_translations[$language][$string_id];
    }

    // else return default language
    if (isset($_translations[$defaultLanguage][$string_id])) {
      return $_translations[$defaultLanguage][$string_id];
    }
    
    // return stringId if no translations have been found.
    return $string_id;

  }

}

