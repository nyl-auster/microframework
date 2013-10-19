<?php
namespace microframework\core\ressources;

use microframework\core\ressource;

class forbidden extends ressource {

  function content() {
    header("HTTP/1.1 403 Access Denied");
    return "Access denied";
  }

}

