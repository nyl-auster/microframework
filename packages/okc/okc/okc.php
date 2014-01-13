<?php
namespace okc\okc;

/**
 * Helpers
 */
class okc {

  function setAttributes($attributes = array()) {
    foreach ($attributes as $attribute => &$data) {
      $data = implode(' ', (array) $data);
      $data = $attribute . '="' . $data . '"';
    }
    return $attributes ? ' ' . implode(' ', $attributes) : '';
  }

  function pre($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    exit;
  }

  function pr($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }

}

