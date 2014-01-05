<?php
namespace okc\framework;

use okc\framework\server;

class translator {

  static function t($string_id, $context = 'global') {
    global $_translations;
    $language = server::getCurrentLanguage();
    if (isset($_translations[$language][$string_id][$context])) {
      return $_translations[$language][$string_id][$context];
    }
    return $string_id;
  }

}

