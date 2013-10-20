<?php
namespace microframework\core\ressources;

use microframework\core\ressource;

class http403 extends ressource {

  function content() {
    header("HTTP/1.1 403 Access Denied");
    return "Access denied";
  }

}

