<?php
namespace microframework\core\ressources;

use microframework\core\ressource;

class notFound extends ressource {

  function content() {
    header("HTTP/1.1 404 Not Found");
    return "Oups, Page not found ! ";
  }

}

