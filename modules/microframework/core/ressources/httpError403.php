<?php
namespace microframework\core\ressources;

use microframework\core\ressource;

class httpError403 extends ressource {

  function content() {
    header("HTTP/1.1 403 Access Denied");
    return "Access denied";
  }

}

