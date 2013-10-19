<?php
namespace microframework\core\ressources;

use microframework\core\ressource;

class notFoundRessource extends ressource {

  function render() {
    header("HTTP/1.1 404 Not Found");
    return "Oups, Page not found ! ";
  }

}

