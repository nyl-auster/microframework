<?php
namespace microframework\core\resources;

use microframework\core\resource;

class http403 extends resource {

  function get() {
    return "Access denied";
  }

}

