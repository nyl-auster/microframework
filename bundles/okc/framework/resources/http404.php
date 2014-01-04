<?php
namespace okc\framework\resources;

use okc\framework\resource;

class http404 extends resource {

  function get() {
    return "Oups, Page not found ! ";
  }

}

