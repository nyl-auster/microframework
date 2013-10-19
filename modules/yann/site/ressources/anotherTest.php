<?php
namespace yann\site\ressources;

use microframework\core\ressource;
use microframework\core\view;

class anotherTest extends ressource {

  function content() {
    $variables = array(
      'content' => 'Another Test Ressource',
      'title' => 'another test',
    );
    return new view('yann/site/views/ressource.php', $variables);
  }

}

