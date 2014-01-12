<?php
namespace okc\demo\resources;

use okc\resource\resource;
use okc\view\view;

class homepage extends resource {

  // some very basic get implementation. We could have simply returned a string.
  function get() {
     return new view('packages/okc/demo/views/homepage.php');
  }

}

