<?php
namespace okc\demo\resources;

use okc\resource\resource;
use okc\view\view;

class homepage extends resource {

  function get() {
     $view = new view('packages/okc/demo/views/homepage.php');
     // insert homepage.php in layout.php template, to build a pretty homepage.
     $view->setParentView('packages/okc/demo/views/layout.php');
     return $view;
  }

}

