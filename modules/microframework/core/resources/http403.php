<?php
namespace microframework\core\resources;

use microframework\core\resource;

class http403 extends resource {

  function get() {
    http_response_code(403);
    return "Access denied";
  }

}

