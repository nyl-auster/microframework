<?php
namespace okc\demo\resources;

use okc\resource\resource;
use okc\view\view;

class homepage extends resource {

  function get() {
     return new view('packages/okc/demo/views/homepage.php');
  }

}

