<?php
namespace okc\server\resources;

use okc\resource\resource;

class homepage extends resource {

  function get() {
    return 'Default homepage.';
  }

}

