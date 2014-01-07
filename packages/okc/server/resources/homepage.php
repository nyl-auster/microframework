<?php
namespace okc\server\resources;

use okc\resource\resource;

class homepage extends resource {

  function get() {
    return 'This is the default homepage';
  }

}

