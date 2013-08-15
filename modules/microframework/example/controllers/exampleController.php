<?php
namespace microframework\example\controllers;
use microframework\core\controller;
use microframework\core\view;

class exampleController extends controller {

  function helloWorld() {
    return new view('modules/microframework/example/views/helloWorld.html.php');
  }

}

