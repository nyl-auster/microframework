<?php
namespace microframework\core\resources;

use microframework\core\resource;

class http404 extends resource {

  function get() {
    header("HTTP/1.1 404 Not Found");
    return "Oups, Page not found ! ";
  }

}

