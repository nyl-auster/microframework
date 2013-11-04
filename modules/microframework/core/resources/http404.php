<?php
namespace microframework\core\resources;

use microframework\core\resource;

class http404 extends resource {

  function get() {
    return "Oups, Page not found ! ";
  }

}

