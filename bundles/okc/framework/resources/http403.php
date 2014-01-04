<?php
namespace okc\framework\resources;

use okc\framework\resource;

class http403 extends resource {

  function get() {
    return "Access denied";
  }

}

