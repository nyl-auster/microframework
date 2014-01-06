<?php
namespace okc\server\resources;

use okc\resource\resource;

class http403 extends resource {

  function get() {
    return "Access denied";
  }

}

