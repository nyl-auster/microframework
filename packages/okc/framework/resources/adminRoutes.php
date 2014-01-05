<?php
namespace okc\framework\resources;

use okc\framework\resource;
use okc\framework\view;

class adminRoutes extends resource {

  function get() {
    return new view('packages/okc/framework/views/adminRoutes.php');
  }

}

