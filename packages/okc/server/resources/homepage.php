<?php
namespace okc\server\resources;

use okc\resource\resource;
use okc\view\view;

class homepage extends resource {

  function get() {
     return new view('packages/okc/framework/views/homepage.php');
  }

}

