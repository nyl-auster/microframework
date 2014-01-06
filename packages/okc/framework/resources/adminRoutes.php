<?php
namespace okc\framework\resources;

use okc\resource\resource;
use okc\view\view;

class adminRoutes extends resource {

  function get() {
    return new view('packages/okc/framework/views/adminRoutes.php');
  }

}

