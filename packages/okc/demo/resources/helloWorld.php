<?php
// define namespace to allow PSR-0 autoload of our class
// {vendorName}/{namespace}, where namespace reflect the directory structure.
// Here we say autoloader to look in /okc/example/resources directory to find our class.
namespace okc\demo\resources;

use okc\resource\resource;
use okc\view\view;
use okc\i18n\i18n;

/**
 * Extends framework abstract resource.
 */
class helloWorld extends resource {

  /**
   * When resource is mapped to an url, get method is automatically by frameworl when rendering resource.
   */
  function get() {
    return new view('packages/okc/demo/views/helloWorld.php', array(
      'title' => i18n::t('hello_world'),
      'content' => i18n::t('hello_world_test_page'),
    ));
  }

}
