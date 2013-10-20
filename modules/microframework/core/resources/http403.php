<?php
namespace microframework\core\resources;

use microframework\core\resource;

class http403 extends resource {

  function get() {
    header("HTTP/1.1 403 Access Denied");
    return "Access denied";
  }

}

