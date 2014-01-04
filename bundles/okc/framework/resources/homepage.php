<?php
namespace okc\framework\resources;

use okc\framework\resource;

class homepage extends resource {

  function get() {
     return "This is the default homepage.";
  }

}

