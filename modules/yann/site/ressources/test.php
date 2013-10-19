<?php
namespace yann\site\ressources;

use microframework\core\ressource;
use microframework\core\view;

class test extends ressource {

  function content() {
    $variables = array(
      'content' => 'Test ressource',
      'title' => 'test',
    );
    return new view('yann/site/views/ressource.php', $variables);
  }

}

