<?php
namespace okc\demo\resources;

use okc\resource\resource;
use okc\template\template;

class homepage extends resource {

  function get() {
     $template = new template('okc/demo/templates/homepage.php');
     $template->setParent('okc/demo/templates/layout.php');
     return $template;
  }

}

