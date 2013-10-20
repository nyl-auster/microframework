<?php
namespace microframework\core\ressources;

use microframework\core\ressource;

class http404 extends ressource {

  function content() {
    header("HTTP/1.1 404 Not Found");
    return "Oups, Page not found ! ";
  }

}

