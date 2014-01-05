<?php
namespace okc\framework;

use okc\framework\server;

class translator {

  static function t($string_id) {
    global $_translations;
    $language = server::getCurrentLanguage();
    if (isset($_translations[$language][$string_id])) {
      return $_translations[$language][$string_id];
    }
    return $string_id;
  }

}

