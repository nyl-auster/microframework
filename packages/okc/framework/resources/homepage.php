<?php
namespace okc\framework\resources;

use okc\framework\resource;
use okc\framework\view;

class homepage extends resource {

  function get() {
     return new view('okc/framework/views/homepage.php');
  }

}

