<?php
namespace yann\site\ressources;

use microframework\core\ressource;
use microframework\core\view;

class homepage extends ressource {

  function content() {
    $variables = array(
      'content' => 'Je suis la homepage',
      'title' => 'Homepage',
    );
    return new view('yann/site/views/homepage.php', $variables);
  }

}

