<?php
namespace okc\server\resources;

use okc\resource\resource;
use okc\view\view;

class homepage extends resource {

  function get() {
    return 'This is the default homepage';
  }

}

