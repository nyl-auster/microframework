<?php
namespace yann\site\ressources;

use microframework\core\ressource;
use microframework\core\view;

class footer extends ressource {

  function content() {
    return new view('yann/site/views/footer.php');
  }

}

