<?php
namespace okc\okc;

/**
 * Helpers
 */
class okc {

  static function setAttributes($attributes = array()) {
    foreach ($attributes as $attribute => &$data) {
      $data = implode(' ', (array) $data);
      $data = $attribute . '="' . $data . '"';
    }
    return $attributes ? ' ' . implode(' ', $attributes) : '';
  }

  static function pre($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    exit;
  }

  static function pr($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }

}

