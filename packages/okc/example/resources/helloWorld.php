<?php
// define namespace to allow PSR-0 autoload of our class
// {vendorName}/{namespace}, where namespace reflect the directory structure.
// Here we say autoloader to look in /okc/example/resources directory to find our class.
namespace okc\example\resources;

use okc\framework\resource;
use okc\framework\view;
use okc\framework\translator;

/**
 * Extends framework abstract resource.
 */
class helloWorld extends resource {

  /**
   * When resource is mapped to an url, get method is automatically by frameworl when rendering resource.
   */
  function get() {
    return new view('okc/example/views/helloWorld.php', array(
      'title' => translator::t('hello_world'),
      'content' => translator::t('hello_world_test_page'),
    ));
  }

}

