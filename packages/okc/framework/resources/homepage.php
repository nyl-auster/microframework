<?php
namespace okc\framework\resources;

use okc\framework\resource;
use okc\view\view;
use okc\framework\i18n;
use okc\framework\server;

class homepage extends resource {

  function get() {
     return new view('packages/okc/framework/views/homepage.php');
  }

}

