<?php
// define namespace to allow PSR-0 autoload of our class
namespace okc\example\resources;

// use abstract resource provided by the framework
use okc\framework\resource;
// use template system provided by the framework
use okc\framework\view;

/**
 * Say hello to the world.
 */
class helloWorld extends resource {

  /**
   * When resource is mapped to an url, get method is automatically called
   * on http get request.
   */
  function get() {
    $variables = array(
      'title' => 'Hello World',
      'content' => 'This is an hello world example',
    );
    return new view('okc/example/views/helloWorld.php', $variables);
  }

}

