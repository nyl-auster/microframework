<?php
namespace okc\okc;

/**
 * Helpers
 */
class okc {

  // @FIXME : move somewhere else (note : thank you drupal)
  function setAttributes($attributes = array()) {
    foreach ($attributes as $attribute => &$data) {
      $data = implode(' ', (array) $data);
      $data = $attribute . '="' . $data . '"';
    }
    return $attributes ? ' ' . implode(' ', $attributes) : '';
  }

  function pr($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }

}

