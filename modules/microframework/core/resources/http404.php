<?php
namespace microframework\core\resources;

use microframework\core\resource;

class http404 extends resource {

  function get() {
    http_response_code(404);
    return "Oups, Page not found ! ";
  }

}

