<?php
namespace microframework\example\controllers;

use microframework\core\view;

class exampleController {

  function helloWorld() {
    return new view('modules/microframework/example/views/helloWorld.html.php');
  }

}

