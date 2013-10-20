<?php
namespace yann\site\ressources;

use microframework\core\ressource;
use microframework\core\view;
use microframework\core\server;

class menu extends ressource {

  function content() {
    return new view('yann/site/views/menu.php');
  }

}

