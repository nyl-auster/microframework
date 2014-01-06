<?php
namespace okc\framework\resources;

use okc\resource\resource;
use okc\view\view;

class adminSettings extends resource {

  function get() {
    return new view('packages/okc/framework/views/adminSettings.php');
  }

}

