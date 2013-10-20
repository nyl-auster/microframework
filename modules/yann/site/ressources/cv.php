<?php
namespace yann\site\ressources;

use microframework\core\ressource;
use microframework\core\view;

class CV extends ressource {

  function content() {
    $variables = array(
      'title' => 'CV',
      'content' => 'contenu du CV',
    );
    return new view('yann/site/views/ressource.php', $variables);
  }

}

