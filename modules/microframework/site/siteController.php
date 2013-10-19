<?php
namespace microframework\site;

use microframework\core\view;

class siteController {

  function homepage() {
    $variables = array(
      'title' => 'test', 
      'body' => file_get_contents('modules/microframework/site/content/article.html')
    );
    return new view('modules/microframework/site/views/page.php', $variables);
  }

}
